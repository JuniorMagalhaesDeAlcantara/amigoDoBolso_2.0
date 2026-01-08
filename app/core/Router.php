<?php

class Router
{
    private  = 'DashboardController';
    private  = 'index';
    private  = [];

    public function run()
    {
         = ->parseUrl();

        // Verifica se é rota de autenticação
        if (isset([0]) && [0] === 'auth') {
            ->controller = 'AuthController';
            array_shift();
        } elseif (isset([0]) && !empty([0])) {
             = ucfirst([0]) . 'Controller';
            if (file_exists(CONTROLLERS . '/' .  . '.php')) {
                ->controller = ;
            }
            array_shift();
        }

        require_once CONTROLLERS . '/' . ->controller . '.php';
        ->controller = new ->controller;

        if (isset([0]) && method_exists(->controller, [0])) {
            ->method = [0];
            array_shift();
        }

        ->params =  ? array_values() : [];

        call_user_func_array(
            [->controller, ->method],
            ->params
        );
    }

    private function parseUrl()
    {
        if (isset(['url'])) {
            return explode(
                '/',
                filter_var(rtrim(['url'], '/'), FILTER_SANITIZE_URL)
            );
        }

        return [];
    }
}
