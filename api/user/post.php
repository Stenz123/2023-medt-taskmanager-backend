<?php

use util\HttpErrorCodes;

require_once '../Controller/UserController.php';

$controller = UserController::getInstance();
$requestType = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'];

if ($requestType != 'POST') {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
}

$controller->createUserFromRequest($_POST['username'], $_POST['email'], $_POST['password']);
