<?php
class Router {
    private $routes = [];
    private $currentController = '';
    private $currentMethod = '';
    private $params = [];

    public function __construct() {
        $url = $this->getUrl();
        
        $this->currentController = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : 'StronyController';
        $controllerFile = APPROOT . '/controllers/' . $this->currentController . '.php';
        
        if(file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->currentController = new $this->currentController;
            unset($url[0]);
        } else {

            header("HTTP/1.0 404 Not Found");
            require_once VIEWROOT . '/errors/404.php';
            exit;
        }


        if(isset($url[1])) {
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            } else {

                header("HTTP/1.0 404 Not Found");
                require_once VIEWROOT . '/errors/404.php';
                exit;
            }
        } else {
            $this->currentMethod = 'index';
        }


        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

    public function addRoute($route, $controller, $method) {
        $this->routes[$route] = [
            'controller' => $controller,
            'method' => $method
        ];
    }
} 