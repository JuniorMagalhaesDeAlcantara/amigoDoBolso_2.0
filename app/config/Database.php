<?php

class Database
{
    private static  = null;
    private ;

    private System.Management.Automation.Internal.Host.InternalHost = 'localhost';
    private  = 'amigo_do_bolso';
    private  = 'root';
    private  = '';

    private function __construct()
    {
        try {
            ->conn = new PDO(
                ""mysql:host={->host};dbname={->db_name};charset=utf8mb4"",
                ->username,
                ->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException ) {
            die(""Erro de conexão: "" . ->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self:: === null) {
            self:: = new self();
        }
        return self::;
    }

    public function getConnection()
    {
        return ->conn;
    }
}
