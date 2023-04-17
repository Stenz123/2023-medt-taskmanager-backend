<?php
class Connection{
    private static $dbConnection = null;
    public static function getConnection()
    {
        $host = '127.0.0.1';
        $port = '3306';
        $db   = 'taskManager';
        $user = 'taskManager';
        $pass = 'passme';
        if (self::$dbConnection == null){
            try {
                self::$dbConnection = new mysqli($host, $user, $pass, $db);
            } catch (Exception $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            return self::$dbConnection;
        }
    }

    private static ?Connection $instance = null;

    public static function getInstance(): mysqli
    {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$dbConnection;
    }


    private function __construct() {
        self::getConnection();
    }

}