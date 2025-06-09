# System Zarządzania Biblioteką

System zarządzania biblioteką to aplikacja webowa napisana w PHP, wykorzystująca architekturę MVC (Model-View-Controller). Umożliwia efektywne zarządzanie księgozbiorem, czytelnikami oraz wypożyczeniami w bibliotece.

## Spis treści
- [Funkcjonalności](#funkcjonalności)
- [Wymagania systemowe](#wymagania-systemowe)
- [Instalacja](#instalacja)
- [Struktura projektu](#struktura-projektu)
- [Konfiguracja](#konfiguracja)
- [Bezpieczeństwo](#bezpieczeństwo)
- [Funkcje](#funkcje)

## Funkcjonalności

### Zarządzanie książkami
- Dodawanie, edycja i usuwanie książek
- Kategoryzacja książek
- Śledzenie stanu magazynowego
- Wyszukiwanie książek
- Szczegółowe informacje o książce

### Zarządzanie czytelnikami
- Rejestracja nowych czytelników
- Edycja danych czytelników
- Historia wypożyczeń czytelnika
- Statystyki aktywności

### System wypożyczeń
- Wypożyczanie książek
- Zwroty książek
- Monitorowanie terminów zwrotu
- Automatyczne wykrywanie przeterminowanych wypożyczeń
- Raportowanie i statystyki

### Raportowanie
- Statystyki wypożyczeń
- Raporty miesięczne
- Lista przeterminowanych wypożyczeń
- Popularność książek
- Aktywność czytelników

## Wymagania systemowe
- PHP 7.4 lub nowszy
- MySQL 5.7 lub nowszy
- Serwer Apache z mod_rewrite
- Composer (menedżer zależności PHP)
- XAMPP (zalecane dla środowiska deweloperskiego)

## Instalacja

1. Sklonuj repozytorium:
```bash
git clone [adres-repozytorium]
cd project
```

2. Zainstaluj zależności przez Composer:
```bash
composer install
```

3. Utwórz bazę danych i zaimportuj schemat:
```bash
mysql -u root -p < database.sql
```

4. Skonfiguruj połączenie z bazą danych w `app/config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'twoj_uzytkownik');
define('DB_PASS', 'twoje_haslo');
define('DB_NAME', 'biblioteka');
```

5. Skonfiguruj ścieżki w pliku `.htaccess`:
```apache
RewriteBase /project/public
```

## Struktura projektu
```
project/
├── app/
│   ├── config/         # Pliki konfiguracyjne
│   ├── controllers/    # Kontrolery MVC
│   ├── core/          # Klasy bazowe i narzędzia
│   ├── models/        # Modele danych
│   └── views/         # Widoki i szablony
├── public/            # Publiczny katalog główny
│   ├── css/          # Style CSS
│   ├── js/           # Skrypty JavaScript
│   ├── img/          # Obrazy
│   ├── index.php     # Punkt wejścia aplikacji
│   └── .htaccess     # Konfiguracja Apache
├── logs/             # Logi aplikacji
├── vendor/           # Zależności Composer
├── composer.json     # Konfiguracja Composer
├── database.sql      # Schemat bazy danych
└── README.md         # Dokumentacja
```

## Konfiguracja

### Stałe aplikacji
- `APPROOT` - Ścieżka do katalogu aplikacji
- `URLROOT` - Bazowy URL aplikacji
- `SITENAME` - Nazwa witryny
- `VIEWROOT` - Ścieżka do katalogu widoków

### Baza danych
- Wykorzystuje PDO dla bezpiecznych połączeń
- Prepared statements dla wszystkich zapytań
- Transakcje dla operacji złożonych
- Automatyczne zarządzanie połączeniami

## Bezpieczeństwo

### Ochrona danych
- Walidacja wszystkich danych wejściowych
- Ochrona przed SQL Injection przez prepared statements
- Ochrona przed XSS przez htmlspecialchars()
- Bezpieczne zarządzanie sesjami

### Obsługa błędów
- Szczegółowe logowanie błędów
- Tryb debugowania konfigurowalny
- Przyjazne komunikaty dla użytkownika
- Zabezpieczenie wrażliwych danych

## Funkcje

### Książki (KsiazkiModel)
- `pobierzWszystkieKsiazki()`
- `pobierzKsiazkePoId($id)`
- `dodajKsiazke($dane)`
- `edytujKsiazke($id, $dane)`
- `usunKsiazke($id)`
- `pobierzDostepneKsiazki()`

### Czytelnicy (CzytelnicyModel)
- `pobierzWszystkichCzytelnikow()`
- `pobierzCzytelnikaPoId($id)`
- `dodajCzytelnika($dane)`
- `edytujCzytelnika($id, $dane)`
- `usunCzytelnika($id)`
- `pobierzHistorieCzytelnika($id)`

### Wypożyczenia (WypozyczeniaModel)
- `pobierzWszystkieWypozyczenia()`
- `dodajWypozyczenie($dane)`
- `zwrocKsiazke($id)`
- `pobierzPrzeterminowaneWypozyczenia()`
- `pobierzStatystykiWypozyczen()`
- `pobierzOstatnieWypozyczenia($limit)`

### Raporty
- Statystyki ogólne
- Statystyki miesięczne
- Raporty aktywności
- Zestawienia przeterminowań

## Autorzy
[Twoje imię/nazwa zespołu]

## Licencja
[Informacje o licencji] 