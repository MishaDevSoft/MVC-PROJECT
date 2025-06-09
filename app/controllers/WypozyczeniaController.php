<?php
class WypozyczeniaController extends Controller {
    private $wypozyczeniaModel;
    private $ksiazkiModel;
    private $czytelnicyModel;

    public function __construct() {
        parent::__construct();
        try {
            $this->wypozyczeniaModel = $this->model('WypozyczeniaModel');
            $this->ksiazkiModel = $this->model('KsiazkiModel');
            $this->czytelnicyModel = $this->model('CzytelnicyModel');
        } catch (Exception $e) {
            die('Błąd inicjalizacji modeli: ' . $e->getMessage());
        }
    }

    public function index() {
        try {
            $wypozyczenia = $this->wypozyczeniaModel->pobierzWszystkieWypozyczenia();
            $dane = [
                'title' => 'Wypożyczenia',
                'wypozyczenia' => array_filter($wypozyczenia, function($w) {
                    return $w->data_zwrotu === null;
                })
            ];
            $this->view('wypozyczenia/index', $dane);
        } catch (Exception $e) {
            $this->obslugaBledu('Wystąpił błąd podczas pobierania wypożyczeń', $e);
        }
    }

    public function wypozycz() {
        if ($this->isPost()) {
            $dane = $this->getPostData();

            try {
                if ($this->wypozyczeniaModel->dodajWypozyczenie($dane)) {
                    $this->redirect('wypozyczenia');
                }
            } catch (Exception $e) {
                $this->obslugaBledu('Wystąpił błąd podczas wypożyczania', $e, 'wypozyczenia/wypozycz');
            }
        } else {
            try {
                $ksiazki = $this->ksiazkiModel->pobierzDostepneKsiazki();
                $czytelnicy = $this->czytelnicyModel->pobierzWszystkichCzytelnikow();
                
                $dane = [
                    'title' => 'Wypożycz książkę',
                    'ksiazki' => $ksiazki,
                    'czytelnicy' => $czytelnicy
                ];
                
                $this->view('wypozyczenia/wypozycz', $dane);
            } catch (Exception $e) {
                $this->obslugaBledu('Wystąpił błąd podczas ładowania formularza', $e, 'wypozyczenia/wypozycz');
            }
        }
    }

    public function zwroc($id = null) {
        if($id === null) {
            $this->redirect('wypozyczenia');
        }

        try {
            if ($this->wypozyczeniaModel->zwrocKsiazke($id)) {
                $this->redirect('wypozyczenia');
            }
        } catch (Exception $e) {
            $this->obslugaBledu('Wystąpił błąd podczas zwrotu książki', $e);
        }
    }

    public function historia() {
        try {
            $wypozyczenia = $this->wypozyczeniaModel->pobierzWszystkieWypozyczenia();
            $dane = [
                'title' => 'Historia wypożyczeń',
                'historia' => $wypozyczenia
            ];
            $this->view('wypozyczenia/historia', $dane);
        } catch (Exception $e) {
            $this->obslugaBledu('Wystąpił błąd podczas pobierania historii', $e, 'wypozyczenia/historia');
        }
    }

    public function przeterminowane() {
        try {
            $wypozyczenia = $this->wypozyczeniaModel->pobierzPrzeterminowaneWypozyczenia();
            $dane = [
                'title' => 'Przeterminowane wypożyczenia',
                'wypozyczenia' => $wypozyczenia
            ];
            $this->view('wypozyczenia/przeterminowane', $dane);
        } catch (Exception $e) {
            $this->obslugaBledu('Wystąpił błąd podczas pobierania przeterminowanych wypożyczeń', $e);
        }
    }

    public function raport() {
        try {
            $statystyki = $this->wypozyczeniaModel->pobierzStatystykiWypozyczen();
            $ostatnie = $this->wypozyczeniaModel->pobierzOstatnieWypozyczenia(10);
            $przeterminowane = $this->wypozyczeniaModel->pobierzPrzeterminowaneWypozyczenia();
            
            $miesiac = date('m');
            $rok = date('Y');
            $nowe_wypozyczenia = $this->wypozyczeniaModel->pobierzNoweWypozyczeniaMiesiac($miesiac, $rok);
            $nowe_ksiazki = $this->ksiazkiModel->pobierzNoweKsiazkiMiesiac($miesiac, $rok);
            $nowi_czytelnicy = $this->czytelnicyModel->pobierzNowychCzytelnikowMiesiac($miesiac, $rok);
            
            $dane = [
                'title' => 'Raport wypożyczeń',
                'statystyki' => $statystyki,
                'ostatnie' => $ostatnie,
                'przeterminowane' => $przeterminowane,
                'miesiac' => [
                    'wypozyczenia' => $nowe_wypozyczenia,
                    'ksiazki' => $nowe_ksiazki,
                    'czytelnicy' => $nowi_czytelnicy
                ]
            ];
            
            $this->view('wypozyczenia/raport', $dane);
        } catch (Exception $e) {
            $this->obslugaBledu('Wystąpił błąd podczas generowania raportu', $e);
        }
    }

    private function obslugaBledu($komunikat, $wyjatek, $widok = 'wypozyczenia/index') {
        $dane = [
            'title' => 'Błąd',
            'blad' => $komunikat
        ];
        if(DEBUG_MODE) {
            $dane['blad'] .= ': ' . $wyjatek->getMessage();
        }
        $this->view($widok, $dane);
    }
} 