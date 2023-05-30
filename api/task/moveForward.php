<?php

use util\HttpErrorCodes;

require_once '../Controller/BoardController.php';

session_start();

//$_POST = json_decode(file_get_contents('php://input'), true);


if(!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];

$controller = TaskController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];

//TODO: Check if user is permitted to move task forward

$id = $_POST['task_id'];

if ($requestType != 'POST') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}

$controller->moveTaskForward($id);