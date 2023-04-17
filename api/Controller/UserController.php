<?php

require_once '../Connection.php';
class UserController
{
    private static $db;
    private static $instance;

    public static function getInstance(): UserController
    {
        if (self::$instance == null) {
            self::$instance = new UserController(Connection::getInstance());
        }
        return self::$instance;
    }
    private function __construct($db)
    {
        self::$db = $db;
    }

    public function getUser($userId)
    {
        $statement = "SELECT user_id, username, email, password  FROM User where user_id = $userId;";
        $res = self::$db->query($statement);
        $myArray = array();
        while($row = $res->fetch_assoc()) {
            $myArray[] = $row;
        }
        return json_encode($myArray);
    }

    public function getAllUsers()
    {
        return "getAllUsers";
    }

    public function createUserFromRequest()
    {

    }

    public function updateUserFromRequest($userId)
    {
    }

    public function deleteUser($userId)
    {
    }

    public function notFoundResponse()
    {
    }

}