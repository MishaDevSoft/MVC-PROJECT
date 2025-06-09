<?php

class CzytelnicyController extends Controller {
    private $czytelnicyModel;

    public function __construct() {
        parent::__construct();
        $this->czytelnicyModel = $this->model('CzytelnicyModel');
    }

    public function index() {
        try {
            $czytelnicy = $this->czytelnicyModel->pobierzWszystkichCzytelnikow();
            
            $dane = [
                'title' => 'Lista czytelników',
                'czytelnicy' => $czytelnicy
            ];

            $this->view('czytelnicy/index', $dane);
        } catch (Exception $e) {
            $dane = [
                'title' => 'Błąd',
                'blad' => 'Wystąpił błąd podczas pobierania listy czytelników'
            ];
            if(DEBUG_MODE) {
                $dane['blad'] .= ': ' . $e->getMessage();
            }
            $this->view('czytelnicy/index', $dane);
        }
    }

    public function dodaj() {
        if($this->isPost()) {
            $dane = $this->getPostData();
            
            try {
                if($this->czytelnicyModel->dodajCzytelnika($dane)) {
                    header('Location: ' . BASE_URL . '/czytelnicy');
                    exit;
                } else {
                    throw new Exception('Nie udało się dodać czytelnika');
                }
            } catch (Exception $e) {
                $dane['blad'] = 'Wystąpił błąd podczas dodawania czytelnika';
                if(DEBUG_MODE) {
                    $dane['blad'] .= ': ' . $e->getMessage();
                }
            }
        }

        $dane['title'] = 'Dodaj czytelnika';
        $this->view('czytelnicy/dodaj', $dane);
    }

    public function edytuj($id = null) {
        if($id === null) {
            header('Location: ' . BASE_URL . '/czytelnicy');
            exit;
        }

        if($this->isPost()) {
            $dane = $this->getPostData();
            
            try {
                if($this->czytelnicyModel->aktualizujCzytelnika($id, $dane)) {
                    header('Location: ' . BASE_URL . '/czytelnicy');
                    exit;
                } else {
                    throw new Exception('Nie udało się zaktualizować danych czytelnika');
                }
            } catch (Exception $e) {
                $dane['blad'] = 'Wystąpił błąd podczas aktualizacji danych';
                if(DEBUG_MODE) {
                    $dane['blad'] .= ': ' . $e->getMessage();
                }
            }
        } else {
            try {
                $czytelnik = $this->czytelnicyModel->pobierzCzytelnika($id);
                if(!$czytelnik) {
                    throw new Exception('Nie znaleziono czytelnika');
                }
                $dane = (array)$czytelnik;
            } catch (Exception $e) {
                $dane['blad'] = 'Wystąpił błąd podczas pobierania danych czytelnika';
                if(DEBUG_MODE) {
                    $dane['blad'] .= ': ' . $e->getMessage();
                }
            }
        }

        $dane['title'] = 'Edytuj czytelnika';
        $this->view('czytelnicy/edytuj', $dane);
    }

    public function usun($id = null) {
        if($id === null) {
            header('Location: ' . BASE_URL . '/czytelnicy');
            exit;
        }

        try {
            if($this->czytelnicyModel->usunCzytelnika($id)) {
                header('Location: ' . BASE_URL . '/czytelnicy');
                exit;
            } else {
                throw new Exception('Nie udało się usunąć czytelnika');
            }
        } catch (Exception $e) {
            $dane = [
                'title' => 'Błąd',
                'blad' => 'Wystąpił błąd podczas usuwania czytelnika'
            ];
            if(DEBUG_MODE) {
                $dane['blad'] .= ': ' . $e->getMessage();
            }
            $this->view('czytelnicy/index', $dane);
        }
    }

    public function szczegoly($id = null) {
        if($id === null) {
            header('Location: ' . BASE_URL . '/czytelnicy');
            exit;
        }

        try {
            $czytelnik = $this->czytelnicyModel->pobierzCzytelnika($id);
            $wypozyczenia = $this->czytelnicyModel->pobierzWypozyczeniaCzytelnika($id);
            
            if(!$czytelnik) {
                throw new Exception('Nie znaleziono czytelnika');
            }

            $dane = [
                'title' => 'Szczegóły czytelnika',
                'czytelnik' => $czytelnik,
                'wypozyczenia' => $wypozyczenia
            ];

            $this->view('czytelnicy/szczegoly', $dane);
        } catch (Exception $e) {
            $dane = [
                'title' => 'Błąd',
                'blad' => 'Wystąpił błąd podczas pobierania danych czytelnika'
            ];
            if(DEBUG_MODE) {
                $dane['blad'] .= ': ' . $e->getMessage();
            }
            $this->view('czytelnicy/index', $dane);
        }
    }
} 