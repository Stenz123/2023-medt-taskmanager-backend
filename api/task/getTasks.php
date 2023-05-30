<?php

use util\HttpErrorCodes;

require_once '../Controller/TaskController.php';

session_start();

header('Access-Control-Allow-Origin: *');

/*
if(!isset($_SESSION['user'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}

$user = $_SESSION['user'];
*/
$controller = TaskController::getInstance();

$requestType = $_SERVER['REQUEST_METHOD'];

if ($requestType != 'GET') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}
$id = $_GET['id'];

$controller->getTasks($id);