<?php

use util\HttpErrorCodes;

require_once '../Controller/TaskController.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

$controller = TaskController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];

if ($requestType != 'POST') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}

$b_title = $_POST['title'];
$b_description = $_POST['description'];
$b_board_id = $_POST['boardId'];

$controller->createTask($b_title, $b_description, $b_board_id);