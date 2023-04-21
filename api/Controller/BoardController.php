<?php
use util\HttpErrorCodes;
require_once '../utils/Response.php';
require_once '../Connection.php';
class BoardController{


    private static ?mysqli $db = null;

    private static ?BoardController $instance = null;

    public static function getInstance(): BoardController
    {
        if (self::$instance == null) {
            self::$instance = new BoardController();
        }
        return self::$instance;
    }
    private function __construct()
    {
        self::$db = Connection::getInstance();
    }

    public function createBoardFromRequest($b_title, $owner, $b_sprintLen)
    {
        if ($b_title == null || $b_sprintLen == null) {
            Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
        }

        $statement = "INSERT INTO Board (B_TITLE, B_OWNER, B_SPRINTLEN) VALUES ('$b_title', $owner, $b_sprintLen);";
        if (self::$db->query($statement)) {
            $statement = "SELECT *  FROM Board where B_ID = (SELECT LAST_INSERT_ID())";
            if ($res = self::$db->query($statement)) {
                while ($row = $res->fetch_assoc()) {
                    $myArray[] = $row;
                }
                Response::created("Board created", $myArray)->send();
            }
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Board not created")->send();
        }
    }

    public function addUser($user, $boardId){
        if ($user == null || $boardId == null) {
            Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
        }

        $statement = "INSERT INTO Team (user_id, board_id) VALUES ($user, $boardId);";
        if (self::$db->query($statement)) {
            Response::created("User added to board")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Board not created")->send();
        }
    }

    public function isAdminOfBoard($userId, $boardId){
        $statement = "SELECT * FROM Board WHERE B_OWNER = $userId AND B_ID = $boardId";
        if ($res = self::$db->query($statement)) {
            if($res->num_rows > 0){
                return true;
            }
        }
        return false;
    }

    //User or admin on boarf
    public function isUserOnBoard($userId, $boardId){
        $statement = "SELECT * FROM Team WHERE (user_id = $userId AND board_id = $boardId)";
        if ($res = self::$db->query($statement)) {
            if($res->num_rows > 0){
                return true;
            }
        }
        return $this->isAdminOfBoard($userId, $boardId);
    }

    public function getBoardsByUser($userId){
        $statement = "SELECT * FROM Board WHERE B_OWNER = $userId OR B_ID IN (SELECT board_id FROM Team WHERE user_id = $userId)";
        if ($res = self::$db->query($statement)) {
            while ($row = $res->fetch_assoc()) {
                $myArray[] = $row;
            }
            Response::ok("Boards found", $myArray)->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Boards not found")->send();
        }
    }

    public function getUsersFromBoard($boardId){
        $statement = "SELECT * FROM User WHERE user_id IN (SELECT user_id FROM Team WHERE board_id = $boardId)
                      union 
                      select * from User where user_id = (SELECT B_OWNER FROM Board WHERE B_ID = $boardId);";
        if ($res = self::$db->query($statement)) {
            while ($row = $res->fetch_assoc()) {
                $myArray[] = $row;
            }
            Response::ok("Users found", $myArray)->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Users not found")->send();
        }
    }
}