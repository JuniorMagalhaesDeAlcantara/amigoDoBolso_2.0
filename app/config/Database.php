<?php

class Database
{
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $db_name = 'amigo_do_bolso';
    private $username = 'root';
    private $password = '';

   // private $host = 'localhost';
   // private $db_name = 'juni1512_amigo_do_bolso';
   // private $username = 'juni1512_jrlevita09';
   // private $password = 'W0r2tf5pz@103555';

    private function __construct()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
