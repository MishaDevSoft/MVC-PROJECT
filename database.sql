CREATE DATABASE IF NOT EXISTS biblioteka CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE biblioteka;

CREATE TABLE ksiazki (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tytul VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    rok_wydania INT,
    isbn VARCHAR(13),
    ilosc_dostepnych INT DEFAULT 0,
    data_dodania TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE czytelnicy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imie VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE,
    telefon VARCHAR(15),
    data_rejestracji TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE wypozyczenia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ksiazka_id INT,
    czytelnik_id INT,
    data_wypozyczenia TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_zwrotu TIMESTAMP NULL,
    status ENUM('wypozyczone', 'zwrocone') DEFAULT 'wypozyczone',
    FOREIGN KEY (ksiazka_id) REFERENCES ksiazki(id),
    FOREIGN KEY (czytelnik_id) REFERENCES czytelnicy(id)
);

INSERT INTO ksiazki (tytul, autor, rok_wydania, isbn, ilosc_dostepnych) VALUES
('Pan Tadeusz', 'Adam Mickiewicz', 1834, '9788373271890', 3),
('Lalka', 'Bolesław Prus', 1890, '9788373272040', 2),
('Quo Vadis', 'Henryk Sienkiewicz', 1896, '9788373272156', 4),
('Ferdydurke', 'Witold Gombrowicz', 1937, '9788373272187', 1),
('Solaris', 'Stanisław Lem', 1961, '9788373272194', 2);

INSERT INTO czytelnicy (imie, nazwisko, email, telefon) VALUES
('Jan', 'Kowalski', 'jan.kowalski@email.com', '+48123456789'),
('Anna', 'Nowak', 'anna.nowak@email.com', '+48234567890'),
('Piotr', 'Wiśniewski', 'piotr.wisniewski@email.com', '+48345678901'),
('Maria', 'Wójcik', 'maria.wojcik@email.com', '+48456789012'),
('Tomasz', 'Lewandowski', 'tomasz.lewandowski@email.com', '+48567890123');

INSERT INTO wypozyczenia (ksiazka_id, czytelnik_id, data_wypozyczenia, status) VALUES
(1, 1, NOW() - INTERVAL 5 DAY, 'wypozyczone'),
(2, 2, NOW() - INTERVAL 10 DAY, 'wypozyczone'),
(3, 3, NOW() - INTERVAL 15 DAY, 'wypozyczone'),
(4, 4, NOW() - INTERVAL 35 DAY, 'wypozyczone'),
(5, 5, NOW() - INTERVAL 2 DAY, 'wypozyczone'); 