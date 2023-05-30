<?php

use util\HttpErrorCodes;
require_once '../utils/Response.php';
require_once '../Connection.php';
class TaskController
{

    private static ?mysqli $db = null;

    private static ?TaskController $instance = null;

    public static function getInstance(): TaskController
    {
        if (self::$instance == null) {
            self::$instance = new TaskController();
        }
        return self::$instance;
    }

    private function __construct()
    {
        self::$db = Connection::getInstance();
    }

    public function createTask($b_title, $id, $b_description, $b_board_id)
    {
        if ($b_title == null || $id == null || $b_description == null) {
            Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
        }

        $statement = "INSERT INTO Task (title, description, column_id, board_id) VALUES ('$b_title', $b_description, 0, $b_board_id);";
        if (self::$db->query($statement)) {
            Response::created("Task created")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Board not created")->send();
        }
    }

    public function getTasks($boardId){
        $statement = "SELECT * FROM Task WHERE board_id = $boardId";
        if ($res = self::$db->query($statement)) {
            while ($row = $res->fetch_assoc()) {
                $myArray[] = $row;
            }
            Response::ok("ok", $myArray)->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Tasks not found")->send();
        }
    }

    public function moveTaskForward($taskId){
        $statement = "UPDATE Task SET column_id = column_id + 1 WHERE task_id = $taskId and column_id < 3";
        if (self::$db->query($statement)) {
            Response::ok("Task moved")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Task not moved")->send();
        }
    }

    public function moveTaskBackward($taskId){
        $statement = "UPDATE Task SET column_id = column_id - 1 WHERE task_id = $taskId and column_id > 0";
        if (self::$db->query($statement)) {
            Response::ok("Task moved")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Task not moved")->send();
        }
    }
}