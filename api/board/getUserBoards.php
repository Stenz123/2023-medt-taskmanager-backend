<?php

use util\HttpErrorCodes;

require_once '../Controller/BoardController.php';

session_start();

//$_POST = json_decode(file_get_contents('php://input'), true);


if(!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];

$controller = BoardController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];
$id = $user['user_id'];

if ($requestType != 'GET') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}

$controller->getBoardsByUser($id);