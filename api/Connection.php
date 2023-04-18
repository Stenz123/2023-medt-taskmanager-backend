<?php
class Connection{
    private static $dbConnection = null;
    public static function getConnection()
    {
        $env = parse_ini_file(__DIR__ . '/../.env');

        $host = $env['DB_HOST'];
        $db   = $env['DB_NAME'];
        $user = $env['DB_USER'];
        $pass = $env['DB_PASS'];
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