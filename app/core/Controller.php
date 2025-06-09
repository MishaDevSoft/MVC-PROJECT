<?php
class Controller {
    protected $data = [];

    public function __construct() {

        $this->data['title'] = SITENAME;
        $this->data['version'] = APPVERSION;
    }

    public function model($model) {

        $modelFile = APPROOT . '/models/' . $model . '.php';
        if(file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        } else {
            throw new Exception("Model {$model} not found");
        }
    }

    public function view($view, $data = []) {

        $this->data = array_merge($this->data, $data);

        $dane = $this->data;
        
        $viewFile = VIEWROOT . '/' . $view . '.php';
        
        if(file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new Exception("View {$view} not found");
        }
    }

    public function redirect($url) {
        header('Location: ' . BASE_URL . '/' . $url);
        exit;
    }

    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function getPostData() {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    protected function getQueryData() {
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    }
} 