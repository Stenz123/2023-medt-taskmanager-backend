<?php

use util\HttpErrorCodes;

require_once '../Controller/TaskController.php';

session_start();

//$_POST = json_decode(file_get_contents('php://input'), true);


if(!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];

$controller = TaskController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];
$id = $user['user_id'];

if ($requestType != 'POST') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}

$b_title = $_POST['title'];
$b_description = $_POST['description'];
$b_board_id = $_POST['board_id'];

$controller->createTask($b_title, $b_description, $b_board_id);