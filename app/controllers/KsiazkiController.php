<?php
class KsiazkiController extends Controller {
    private $ksiazkiModel;

    public function __construct() {
        parent::__construct();
        $this->ksiazkiModel = $this->model('KsiazkiModel');
    }

    public function index() {
        $ksiazki = $this->ksiazkiModel->pobierzWszystkieKsiazki();
        $this->view('ksiazki/index', ['ksiazki' => $ksiazki]);
    }

    public function dodaj() {
        if ($this->isPost()) {
            $dane = [
                'tytul' => trim($_POST['tytul']),
                'autor' => trim($_POST['autor']),
                'rok_wydania' => intval(trim($_POST['rok_wydania'])),
                'isbn' => trim($_POST['isbn']),
                'ilosc_dostepnych' => intval(trim($_POST['ilosc_dostepnych']))
            ];

            $bledy = [];
            if (empty($dane['tytul'])) $bledy[] = 'Tytuł jest wymagany';
            if (empty($dane['autor'])) $bledy[] = 'Autor jest wymagany';
            if ($dane['rok_wydania'] <= 0) $bledy[] = 'Rok wydania jest nieprawidłowy';
            if ($dane['ilosc_dostepnych'] < 0) $bledy[] = 'Ilość nie może być ujemna';

            if (empty($bledy)) {
                if ($this->ksiazkiModel->dodajKsiazke($dane)) {
                    $this->redirect('ksiazki');
                } else {
                    $this->view('ksiazki/dodaj', [
                        'blad' => 'Wystąpił błąd podczas dodawania książki',
                        'dane' => $dane
                    ]);
                }
            } else {
                $this->view('ksiazki/dodaj', [
                    'bledy' => $bledy,
                    'dane' => $dane
                ]);
            }
        } else {
            $this->view('ksiazki/dodaj');
        }
    }

    public function edytuj($id) {
        if ($this->isPost()) {
            $dane = [
                'id' => $id,
                'tytul' => trim($_POST['tytul']),
                'autor' => trim($_POST['autor']),
                'rok_wydania' => intval(trim($_POST['rok_wydania'])),
                'isbn' => trim($_POST['isbn']),
                'ilosc_dostepnych' => intval(trim($_POST['ilosc_dostepnych']))
            ];

            $bledy = [];
            if (empty($dane['tytul'])) $bledy[] = 'Tytuł jest wymagany';
            if (empty($dane['autor'])) $bledy[] = 'Autor jest wymagany';
            if ($dane['rok_wydania'] <= 0) $bledy[] = 'Rok wydania jest nieprawidłowy';
            if ($dane['ilosc_dostepnych'] < 0) $bledy[] = 'Ilość nie może być ujemna';

            if (empty($bledy)) {
                if ($this->ksiazkiModel->aktualizujKsiazke($dane)) {
                    $this->redirect('ksiazki');
                } else {
                    $this->view('ksiazki/edytuj', [
                        'blad' => 'Wystąpił błąd podczas aktualizacji',
                        'ksiazka' => (object)$dane
                    ]);
                }
            } else {
                $this->view('ksiazki/edytuj', [
                    'bledy' => $bledy,
                    'ksiazka' => (object)$dane
                ]);
            }
        } else {
            $ksiazka = $this->ksiazkiModel->pobierzKsiazkePoId($id);
            if ($ksiazka) {
                $this->view('ksiazki/edytuj', ['ksiazka' => $ksiazka]);
            } else {
                $this->redirect('ksiazki');
            }
        }
    }

    public function usun($id) {
        if ($this->ksiazkiModel->usunKsiazke($id)) {
            $this->redirect('ksiazki');
        } else {
            die('Wystąpił błąd podczas usuwania książki');
        }
    }

    public function szczegoly($id) {
        $ksiazka = $this->ksiazkiModel->pobierzKsiazkePoId($id);
        if ($ksiazka) {
            $wypozyczenia = $this->ksiazkiModel->pobierzWypozyczeniaKsiazki($id);
            $this->view('ksiazki/szczegoly', [
                'ksiazka' => $ksiazka,
                'wypozyczenia' => $wypozyczenia
            ]);
        } else {
            $this->redirect('ksiazki');
        }
    }
} 