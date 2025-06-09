<?php

class StronyController extends Controller {
    private $ksiazkiModel;
    private $czytelnicyModel;
    private $wypozyczeniaModel;

    public function __construct() {
        parent::__construct();
        try {
            $this->ksiazkiModel = $this->model('KsiazkiModel');
            $this->czytelnicyModel = $this->model('CzytelnicyModel');
            $this->wypozyczeniaModel = $this->model('WypozyczeniaModel');
        } catch (Exception $e) {
            die('Błąd inicjalizacji modeli: ' . $e->getMessage());
        }
    }

    public function index($page = 'strona-glowna') {
        try {
            $statystyki = [
                'liczba_ksiazek' => $this->ksiazkiModel->pobierzLiczbeKsiazek(),
                'liczba_czytelnikow' => $this->czytelnicyModel->pobierzLiczbeCzytelnikow(),
                'aktywne_wypozyczenia' => $this->wypozyczeniaModel->liczbaAktywnychWypozyczen(),
                'przeterminowane' => $this->wypozyczeniaModel->liczbaPrzeterminowanychWypozyczen()
            ];

            $ostatnie_ksiazki = $this->ksiazkiModel->pobierzOstatnioDodaneKsiazki(5);
            $ostatnie_wypozyczenia = $this->wypozyczeniaModel->pobierzOstatnieWypozyczenia(5);
            $najpopularniejsze = $this->ksiazkiModel->pobierzNajpopularniejszeKsiazki(5);

            $dane = [
                'statystyki' => $statystyki,
                'ostatnie_ksiazki' => $ostatnie_ksiazki,
                'ostatnie_wypozyczenia' => $ostatnie_wypozyczenia,
                'najpopularniejsze' => $najpopularniejsze
            ];

            if(!file_exists(VIEWROOT . '/strony/index.php')) {
                throw new Exception('Szablon widoku nie został znaleziony');
            }

            $this->view('strony/index', $dane);
        } catch (Exception $e) {
            if(DEBUG_MODE) {
                die('Błąd: ' . $e->getMessage());
            } else {
                $this->error404();
            }
        }
    }

    public function error404() {
        $dane = [
            'tytul' => 'Błąd 404',
            'opis' => 'Strona nie została znaleziona'
        ];

        if(file_exists(VIEWROOT . '/strony/404.php')) {
            $this->view('strony/404', $dane);
        } else {
            die('404 - Strona nie została znaleziona');
        }
    }
} 