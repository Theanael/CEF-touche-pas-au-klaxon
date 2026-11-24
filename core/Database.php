<?php
class Database{
    
    /**
     * getDb
     * Retourne la connexion à la base de donnée
     * @return PDO la connexion à la base de donnée
     */

    public static function getDb(){

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        return new PDO($dsn, $username, $password);
    }

    }
    
    
    