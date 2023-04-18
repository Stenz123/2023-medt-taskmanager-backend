<?php

use util\HttpErrorCodes;
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
        Response::ok("User found", $myArray)->send();
    }

    public function getAllUsers()
    {
        $statement = "SELECT user_id, username, email, password  FROM User;";
        $res = self::$db->query($statement);
        while($row = $res->fetch_assoc()) {
            $myArray[] = $row;
        }
        Response::ok("User found", $myArray)->send();
    }

    public function createUserFromRequest($userName, $email, $password)
    {
        if ($userName == null || $email == null || $password == null) {
            Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
        }
        $statement = "INSERT INTO User (username, email, password) VALUES ('$userName', '$email', '$password');";
        if(self::$db->query($statement)){
            $data = array();

            Response::created("User created")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "User not created")->send();
        }
    }

    public function deleteUser($userId)
    {
        if ($userId == null) {
            Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
        }
        $statement = "DELETE FROM User WHERE user_id = $userId;";
        if(self::$db->query($statement)){
            Response::ok("User deleted")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "User not deleted")->send();
        }
    }
}