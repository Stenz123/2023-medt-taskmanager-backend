<?php

require_once '../utils/Response.php';
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
        while($row = $res->fetch_assoc()) {
            $myArray[] = $row;
        }
        Response::ok("User found", json_encode($myArray))->send();
    }

    public function getAllUsers()
    {
        $statement = "SELECT user_id, username, email, password  FROM User;";
        $res = self::$db->query($statement);
        while($row = $res->fetch_assoc()) {
            $myArray[] = $row;
        }
        Response::ok("User found", json_encode($myArray))->send();
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