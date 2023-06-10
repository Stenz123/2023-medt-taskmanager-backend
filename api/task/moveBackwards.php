<?php

use util\HttpErrorCodes;

require_once '../Controller/TaskController.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

$user = $_SESSION['user'];

$controller = TaskController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];

//TODO: Check if user is permitted to move task forward


if ($requestType != 'POST') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}
$id = $_POST['id'];

$controller->moveTaskBackward($id);