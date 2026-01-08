<?php

class Controller
{
    protected function view(,  = [])
    {
        extract();

        if (file_exists(VIEWS . '/' .  . '.php')) {
            require_once VIEWS . '/' .  . '.php';
        } else {
            die(""View não encontrada: "");
        }
    }

    protected function redirect()
    {
        header(""Location: "" . );
        exit();
    }

    protected function isLoggedIn()
    {
        return isset(['user_id']);
    }

    protected function requireLogin()
    {
        if (!->isLoggedIn()) {
            ->redirect('/auth/login');
        }
    }

    protected function json()
    {
        header('Content-Type: application/json');
        echo json_encode();
        exit();
    }
}
