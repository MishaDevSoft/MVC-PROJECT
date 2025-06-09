<?php
class KsiazkiModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function pobierzWszystkieKsiazki() {
        $this->db->query("SELECT * FROM ksiazki ORDER BY tytul ASC");
        return $this->db->resultSet();
    }

    public function pobierzKsiazkePoId($id) {
        $this->db->query("SELECT * FROM ksiazki WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function dodajKsiazke($dane) {
        $this->db->query("INSERT INTO ksiazki (tytul, autor, isbn, rok_wydania, wydawnictwo, ilosc_dostepnych, opis) 
                         VALUES (:tytul, :autor, :isbn, :rok_wydania, :wydawnictwo, :ilosc_dostepnych, :opis)");


        $this->db->bind(':tytul', $dane['tytul']);
        $this->db->bind(':autor', $dane['autor']);
        $this->db->bind(':isbn', $dane['isbn']);
        $this->db->bind(':rok_wydania', $dane['rok_wydania']);
        $this->db->bind(':wydawnictwo', $dane['wydawnictwo']);
        $this->db->bind(':ilosc_dostepnych', $dane['ilosc_dostepnych']);
        $this->db->bind(':opis', $dane['opis']);

        return $this->db->execute();
    }

    public function aktualizujKsiazke($id, $dane) {
        $this->db->query("UPDATE ksiazki 
                         SET tytul = :tytul, 
                             autor = :autor, 
                             isbn = :isbn, 
                             rok_wydania = :rok_wydania, 
                             wydawnictwo = :wydawnictwo, 
                             ilosc_dostepnych = :ilosc_dostepnych, 
                             opis = :opis 
                         WHERE id = :id");

        $this->db->bind(':id', $id);
        $this->db->bind(':tytul', $dane['tytul']);
        $this->db->bind(':autor', $dane['autor']);
        $this->db->bind(':isbn', $dane['isbn']);
        $this->db->bind(':rok_wydania', $dane['rok_wydania']);
        $this->db->bind(':wydawnictwo', $dane['wydawnictwo']);
        $this->db->bind(':ilosc_dostepnych', $dane['ilosc_dostepnych']);
        $this->db->bind(':opis', $dane['opis']);

        return $this->db->execute();
    }

    public function usunKsiazke($id) {

        $this->db->query("SELECT COUNT(*) as count FROM wypozyczenia 
                         WHERE ksiazka_id = :id AND data_zwrotu IS NULL");
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        
        if($result->count > 0) {
            throw new Exception('Nie można usunąć książki z aktywnymi wypożyczeniami');
        }

        $this->db->query("DELETE FROM ksiazki WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function pobierzWypozyczeniaKsiazki($id) {
        $this->db->query("SELECT w.*, c.imie, c.nazwisko 
                         FROM wypozyczenia w 
                         JOIN czytelnicy c ON w.czytelnik_id = c.id 
                         WHERE w.ksiazka_id = :id
                         ORDER BY w.data_wypozyczenia DESC");
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }

    public function zmniejszIloscDostepnych($id) {
        $this->db->query("UPDATE ksiazki 
                         SET ilosc_dostepnych = ilosc_dostepnych - 1 
                         WHERE id = :id AND ilosc_dostepnych > 0");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function zwiekszIloscDostepnych($id) {
        $this->db->query("UPDATE ksiazki 
                         SET ilosc_dostepnych = ilosc_dostepnych + 1 
                         WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function pobierzDostepneKsiazki() {
        $this->db->query("SELECT * FROM ksiazki 
                         WHERE ilosc_dostepnych > 0 
                         ORDER BY tytul ASC");
        return $this->db->resultSet();
    }

    public function pobierzLiczbeKsiazek() {
        $this->db->query("SELECT COUNT(*) as count FROM ksiazki");
        $result = $this->db->single();
        return $result->count;
    }

    public function pobierzOstatnioDodaneKsiazki($limit = 5) {
        $this->db->query("SELECT * FROM ksiazki 
                         ORDER BY data_dodania DESC 
                         LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function pobierzNajpopularniejszeKsiazki($limit = 5) {
        $this->db->query("SELECT k.*, COUNT(w.id) as liczba_wypozyczen 
                         FROM ksiazki k 
                         LEFT JOIN wypozyczenia w ON k.id = w.ksiazka_id 
                         GROUP BY k.id 
                         ORDER BY liczba_wypozyczen DESC 
                         LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function wyszukajKsiazki($fraza) {
        $this->db->query("SELECT * FROM ksiazki 
                         WHERE tytul LIKE :fraza 
                         OR autor LIKE :fraza 
                         OR isbn LIKE :fraza");
        $this->db->bind(':fraza', '%' . $fraza . '%');
        return $this->db->resultSet();
    }

    public function pobierzNoweKsiazkiMiesiac($miesiac, $rok) {
        $this->db->query("SELECT COUNT(*) as count 
                         FROM ksiazki 
                         WHERE MONTH(data_dodania) = :miesiac 
                         AND YEAR(data_dodania) = :rok");
        $this->db->bind(':miesiac', $miesiac);
        $this->db->bind(':rok', $rok);
        $result = $this->db->single();
        return $result->count;
    }

    public function czyIsbnIstnieje($isbn, $id = null) {
        $sql = "SELECT COUNT(*) as count FROM ksiazki WHERE isbn = :isbn";
        if($id !== null) {
            $sql .= " AND id != :id";
        }
        
        $this->db->query($sql);
        $this->db->bind(':isbn', $isbn);
        
        if($id !== null) {
            $this->db->bind(':id', $id);
        }
        
        $result = $this->db->single();
        return $result->count > 0;
    }
} 