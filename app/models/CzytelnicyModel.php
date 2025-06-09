<?php
class CzytelnicyModel {
    private $db;
    private $table = 'czytelnicy';

    public function __construct() {
        $this->db = new Database;
    }

    public function pobierzWszystkichCzytelnikow() {
        $this->db->query("SELECT * FROM czytelnicy ORDER BY nazwisko, imie");
        return $this->db->resultSet();
    }

    public function pobierzCzytelnika($id) {
        $this->db->query("SELECT * FROM czytelnicy WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function dodajCzytelnika($dane) {
        $this->db->query("INSERT INTO czytelnicy (imie, nazwisko, email, telefon, adres) 
                         VALUES (:imie, :nazwisko, :email, :telefon, :adres)");
        

        $this->db->bind(':imie', $dane['imie']);
        $this->db->bind(':nazwisko', $dane['nazwisko']);
        $this->db->bind(':email', $dane['email']);
        $this->db->bind(':telefon', $dane['telefon']);
        $this->db->bind(':adres', $dane['adres']);

        return $this->db->execute();
    }

    public function aktualizujCzytelnika($id, $dane) {
        $this->db->query("UPDATE czytelnicy 
                         SET imie = :imie, 
                             nazwisko = :nazwisko, 
                             email = :email, 
                             telefon = :telefon, 
                             adres = :adres 
                         WHERE id = :id");

        $this->db->bind(':id', $id);
        $this->db->bind(':imie', $dane['imie']);
        $this->db->bind(':nazwisko', $dane['nazwisko']);
        $this->db->bind(':email', $dane['email']);
        $this->db->bind(':telefon', $dane['telefon']);
        $this->db->bind(':adres', $dane['adres']);

        return $this->db->execute();
    }

    public function usunCzytelnika($id) {

        $this->db->query("SELECT COUNT(*) as count FROM wypozyczenia 
                         WHERE czytelnik_id = :id AND data_zwrotu IS NULL");
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        
        if($result->count > 0) {
            throw new Exception('Nie można usunąć czytelnika z aktywnymi wypożyczeniami');
        }

        $this->db->query("DELETE FROM czytelnicy WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function pobierzWypozyczeniaCzytelnika($id) {
        $this->db->query("SELECT w.*, k.tytul, k.autor 
                         FROM wypozyczenia w 
                         JOIN ksiazki k ON w.ksiazka_id = k.id 
                         WHERE w.czytelnik_id = :id 
                         ORDER BY w.data_wypozyczenia DESC");
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }

    public function pobierzHistorieWypozyczen($id) {
        $sql = "SELECT w.*, k.tytul, k.autor 
                FROM wypozyczenia w 
                JOIN ksiazki k ON w.ksiazka_id = k.id 
                WHERE w.czytelnik_id = ? AND w.status = 'zwrocone' 
                ORDER BY w.data_zwrotu DESC";
        return $this->db->query($sql, [$id]);
    }

    public function pobierzLiczbeCzytelnikow() {
        $this->db->query("SELECT COUNT(*) as count FROM czytelnicy");
        $result = $this->db->single();
        return $result->count;
    }

    public function wyszukajCzytelnikow($fraza) {
        return $this->db->search($this->table, 'nazwisko', $fraza);
    }

    public function pobierzNowychCzytelnikowMiesiac($miesiac, $rok) {
        $this->db->query("SELECT COUNT(*) as count 
                         FROM czytelnicy 
                         WHERE MONTH(data_rejestracji) = :miesiac 
                         AND YEAR(data_rejestracji) = :rok");
        $this->db->bind(':miesiac', $miesiac);
        $this->db->bind(':rok', $rok);
        $result = $this->db->single();
        return $result->count;
    }

    public function sprawdzCzyMaWypozyczenia($id) {
        $sql = "SELECT COUNT(*) as count FROM wypozyczenia 
                WHERE czytelnik_id = ? AND status = 'wypozyczone'";
        $result = $this->db->query($sql, [$id], true);
        return $result->count > 0;
    }

    public function czyEmailIstnieje($email, $id = null) {
        $sql = "SELECT COUNT(*) as count FROM czytelnicy WHERE email = :email";
        if($id !== null) {
            $sql .= " AND id != :id";
        }
        
        $this->db->query($sql);
        $this->db->bind(':email', $email);
        
        if($id !== null) {
            $this->db->bind(':id', $id);
        }
        
        $result = $this->db->single();
        return $result->count > 0;
    }

    public function pobierzStatystykiCzytelnika($id) {
        $this->db->query("SELECT 
                             COUNT(*) as wszystkie_wypozyczenia,
                             SUM(CASE WHEN data_zwrotu IS NULL THEN 1 ELSE 0 END) as aktywne_wypozyczenia,
                             SUM(CASE WHEN data_zwrotu IS NULL AND data_wypozyczenia < DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as przeterminowane
                         FROM wypozyczenia 
                         WHERE czytelnik_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
} 