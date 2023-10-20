<?php

namespace config;

use PDO;

class DbConnection
{
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect(){
        $connect = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $connect;
    }
}