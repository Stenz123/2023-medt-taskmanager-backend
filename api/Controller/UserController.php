<?php

use util\HttpErrorCodes;
require_once '../utils/Response.php';
require_once '../Connection.php';
class UserController
{

    private static ?mysqli $db = null;

    private static ?UserController $instance = null;

public static function getInstance(): UserController
    {
        if (self::$instance == null) {
            self::$instance = new UserController();
        }
        return self::$instance;
    }
    private function __construct()
    {
        self::$db = Connection::getInstance();
    }

    public function getUser($userId)
    {
        $statement = "SELECT user_id, username, email, password  FROM User where user_id = $userId;";
        $res = self::$db->query($statement);

        while ($row = $res->fetch_assoc()) {
            $myArray[] = $row;
        }
        if (empty($myArray)
        ) {
            Response::error(HttpErrorCodes::HTTP_NOT_FOUND, "User not found")->send();
        }
        Response::ok("User found", $myArray)->send();
    }

    public function getAllUsers()
    {
        $statement = "SELECT user_id, username, email, password  FROM User;";
        $res = self::$db->query($statement);
        while ($row = $res->fetch_assoc()) {
            $myArray[] = $row;
        }
        Response::ok("User found", $myArray)->send();
    }

    public function createUserFromRequest($userName, $email, $password)
    {
        if ($userName == null || $email == null || $password == null) {
            Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $statement = "INSERT INTO User (username, email, password) VALUES ('$userName', '$email', '$password');";
        if (self::$db->query($statement)) {
            $statement = "SELECT user_id, username, email, password  FROM User where user_id = (SELECT LAST_INSERT_ID())";
            if ($res = self::$db->query($statement)) {
                while ($row = $res->fetch_assoc()) {
                    $myArray[] = $row;
                }
                Response::created("User created", $myArray)->send();
            }
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
        if (self::$db->query($statement)) {
            Response::ok("User deleted")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "User not deleted")->send();
        }
    }

    public function getUserByEmail($email, $responds)
    {
        $statement = "SELECT user_id, username, email, password  FROM User where email = '$email';";
        $res = self::$db->query($statement);

        while ($row = $res->fetch_assoc()) {
            $myArray[] = $row;
        }
        if ($responds) {
            if (empty($myArray)) {
                Response::error(HttpErrorCodes::HTTP_NOT_FOUND, "User not found")->send();
            }
            Response::ok("User found", $myArray)->send();
        }else
        {
            return $myArray;
        }
    }
}