<?php
class WypozyczeniaModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function pobierzWszystkieWypozyczenia() {
        $this->db->query("SELECT w.*, k.tytul, k.autor, c.imie, c.nazwisko 
                         FROM wypozyczenia w 
                         JOIN ksiazki k ON w.ksiazka_id = k.id 
                         JOIN czytelnicy c ON w.czytelnik_id = c.id 
                         ORDER BY w.data_wypozyczenia DESC");
        return $this->db->resultSet();
    }

    public function pobierzWypozyczenie($id) {
        $this->db->query("SELECT w.*, k.tytul, k.autor, c.imie, c.nazwisko 
                         FROM wypozyczenia w 
                         JOIN ksiazki k ON w.ksiazka_id = k.id 
                         JOIN czytelnicy c ON w.czytelnik_id = c.id 
                         WHERE w.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function dodajWypozyczenie($dane) {
        try {
            $this->db->beginTransaction();

            $this->db->query("SELECT ilosc_dostepnych FROM ksiazki WHERE id = :id FOR UPDATE");
            $this->db->bind(':id', $dane['ksiazka_id']);
            $ksiazka = $this->db->single();

            if(!$ksiazka || $ksiazka->ilosc_dostepnych <= 0) {
                throw new Exception('Książka jest niedostępna');
            }


            $this->db->query("SELECT COUNT(*) as count 
                             FROM wypozyczenia 
                             WHERE ksiazka_id = :ksiazka_id 
                             AND czytelnik_id = :czytelnik_id 
                             AND data_zwrotu IS NULL");
            $this->db->bind(':ksiazka_id', $dane['ksiazka_id']);
            $this->db->bind(':czytelnik_id', $dane['czytelnik_id']);
            $result = $this->db->single();

            if($result->count > 0) {
                throw new Exception('Czytelnik już wypożyczył tę książkę');
            }

            $this->db->query("INSERT INTO wypozyczenia (ksiazka_id, czytelnik_id, data_wypozyczenia, uwagi) 
                             VALUES (:ksiazka_id, :czytelnik_id, NOW(), :uwagi)");
            $this->db->bind(':ksiazka_id', $dane['ksiazka_id']);
            $this->db->bind(':czytelnik_id', $dane['czytelnik_id']);
            $this->db->bind(':uwagi', $dane['uwagi'] ?? null);
            $this->db->execute();

            $this->db->query("UPDATE ksiazki 
                             SET ilosc_dostepnych = ilosc_dostepnych - 1 
                             WHERE id = :id");
            $this->db->bind(':id', $dane['ksiazka_id']);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function zwrocKsiazke($id) {
        try {
            $this->db->beginTransaction();

            $this->db->query("SELECT ksiazka_id FROM wypozyczenia WHERE id = :id AND data_zwrotu IS NULL FOR UPDATE");
            $this->db->bind(':id', $id);
            $wypozyczenie = $this->db->single();

            if(!$wypozyczenie) {
                throw new Exception('Wypożyczenie nie istnieje lub książka została już zwrócona');
            }

            $this->db->query("UPDATE wypozyczenia 
                             SET data_zwrotu = NOW() 
                             WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query("UPDATE ksiazki 
                             SET ilosc_dostepnych = ilosc_dostepnych + 1 
                             WHERE id = :id");
            $this->db->bind(':id', $wypozyczenie->ksiazka_id);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function usunWypozyczenie($id) {

        $this->db->query("SELECT data_zwrotu FROM wypozyczenia WHERE id = :id");
        $this->db->bind(':id', $id);
        $wypozyczenie = $this->db->single();

        if(!$wypozyczenie) {
            throw new Exception('Wypożyczenie nie istnieje');
        }

        if($wypozyczenie->data_zwrotu === null) {
            throw new Exception('Nie można usunąć aktywnego wypożyczenia');
        }

        $this->db->query("DELETE FROM wypozyczenia WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function liczbaAktywnychWypozyczen() {
        $this->db->query("SELECT COUNT(*) as count 
                         FROM wypozyczenia 
                         WHERE data_zwrotu IS NULL");
        $result = $this->db->single();
        return $result->count;
    }

    public function liczbaPrzeterminowanychWypozyczen() {
        $this->db->query("SELECT COUNT(*) as count 
                         FROM wypozyczenia 
                         WHERE data_zwrotu IS NULL 
                         AND data_wypozyczenia < DATE_SUB(NOW(), INTERVAL 30 DAY)");
        $result = $this->db->single();
        return $result->count;
    }

    public function pobierzOstatnieWypozyczenia($limit = 5) {
        $this->db->query("SELECT w.*, k.tytul, k.autor, c.imie, c.nazwisko 
                         FROM wypozyczenia w 
                         JOIN ksiazki k ON w.ksiazka_id = k.id 
                         JOIN czytelnicy c ON w.czytelnik_id = c.id 
                         ORDER BY w.data_wypozyczenia DESC 
                         LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function pobierzPrzeterminowaneWypozyczenia() {
        $this->db->query("SELECT w.*, k.tytul, k.autor, c.imie, c.nazwisko,
                                DATEDIFF(NOW(), w.data_wypozyczenia) as dni_po_terminie
                         FROM wypozyczenia w 
                         JOIN ksiazki k ON w.ksiazka_id = k.id 
                         JOIN czytelnicy c ON w.czytelnik_id = c.id 
                         WHERE w.data_zwrotu IS NULL 
                         AND w.data_wypozyczenia < DATE_SUB(NOW(), INTERVAL 30 DAY)
                         ORDER BY w.data_wypozyczenia ASC");
        return $this->db->resultSet();
    }

    public function pobierzStatystykiWypozyczen() {
        $this->db->query("SELECT 
                             COUNT(*) as wszystkie_wypozyczenia,
                             SUM(CASE WHEN data_zwrotu IS NULL THEN 1 ELSE 0 END) as aktywne_wypozyczenia,
                             SUM(CASE WHEN data_zwrotu IS NULL AND data_wypozyczenia < DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as przeterminowane,
                             AVG(DATEDIFF(IFNULL(data_zwrotu, NOW()), data_wypozyczenia)) as sredni_czas_wypozyczenia
                         FROM wypozyczenia");
        return $this->db->single();
    }

    public function pobierzNoweWypozyczeniaMiesiac($miesiac, $rok) {
        $this->db->query("SELECT COUNT(*) as count 
                         FROM wypozyczenia 
                         WHERE MONTH(data_wypozyczenia) = :miesiac 
                         AND YEAR(data_wypozyczenia) = :rok");
        $this->db->bind(':miesiac', $miesiac);
        $this->db->bind(':rok', $rok);
        $result = $this->db->single();
        return $result->count;
    }
} 