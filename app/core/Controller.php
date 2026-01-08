<?php

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);

        $file = VIEWS . '/' . $view . '.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            die("View não encontrada: {$view}");
        }
    }

    protected function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }

    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/auth/login');
        }
    }

    protected function json($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}
