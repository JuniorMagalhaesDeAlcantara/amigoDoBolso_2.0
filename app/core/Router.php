<?php

class Router
{
    private $controller = 'DashboardController';
    private $method = 'index';
    private $params = [];

    public function run()
    {
        $url = $this->parseUrl();

        // Verifica se é rota de autenticação
        if (isset($url[0]) && $url[0] === 'auth') {
            $this->controller = 'AuthController';
            array_shift($url);
        } 
        elseif (isset($url[0]) && !empty($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';

            if (file_exists(CONTROLLERS . '/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
            }

            array_shift($url);
        }

        require_once CONTROLLERS . '/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[0]) && method_exists($this->controller, $url[0])) {
            $this->method = $url[0];
            array_shift($url);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array(
            [$this->controller, $this->method],
            $this->params
        );
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode(
                '/',
                filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)
            );
        }

        return [];
    }
}
