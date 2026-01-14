<?php

class Router
{
    private $controller = 'AuthController';
    private $method = 'login';
    private $params = [];

    public function run()
    {
        $url = $this->parseUrl();

        // DEBUG
        error_log("Router - URL parseada: " . print_r($url, true));

        // Se não tem URL, vai para login se não estiver logado
        if (empty($url) || (count($url) === 1 && empty($url[0]))) {
            if (isset($_SESSION['user_id'])) {
                $this->controller = 'DashboardController';
                $this->method = 'index';
            } else {
                $this->controller = 'AuthController';
                $this->method = 'login';
            }
        }
        // Verifica se é rota de autenticação
        elseif ($url[0] === 'auth') {
            $this->controller = 'AuthController';
            array_shift($url);

            // Define o método (login, register, logout)
            if (isset($url[0]) && !empty($url[0])) {
                $method = $url[0];

                // Valida se o método existe
                if (in_array($method, ['login', 'register', 'logout'])) {
                    $this->method = $method;
                    error_log("Router - Método auth detectado: {$method}");
                }

                array_shift($url);
            }
        } elseif ($url[0] === 'grupos') {
            $this->controller = 'GruposController';
            array_shift($url);

            if (isset($url[0])) {
                $this->method = $url[0];
                array_shift($url);
            } else {
                $this->method = 'detalhes';
            }
        }
        // Outras rotas
        elseif (isset($url[0]) && !empty($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';

            if (file_exists(CONTROLLERS . '/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                array_shift($url);

                // Se não tem método especificado, usa 'index' como padrão
                if (isset($url[0]) && !empty($url[0])) {
                    // Converte kebab-case para camelCase (togglePaid)
                    $method = $url[0];
                    if (strpos($method, '-') !== false) {
                        $method = lcfirst(str_replace('-', '', ucwords($method, '-')));
                    }
                    $this->method = $method;
                    array_shift($url);
                } else {
                    $this->method = 'index';
                }
            }
        }

        error_log("Router - Controller: {$this->controller}, Method: {$this->method}");

        // Carrega o controller
        $controllerFile = CONTROLLERS . '/' . $this->controller . '.php';

        if (!file_exists($controllerFile)) {
            die("Controller não encontrado: {$this->controller}");
        }

        require_once $controllerFile;
        $this->controller = new $this->controller;

        // Verifica se o método existe
        if (!method_exists($this->controller, $this->method)) {
            die("Método não encontrado: {$this->method} no controller " . get_class($this->controller));
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
