<?php

use util\HttpErrorCodes;

require_once '../Controller/UserController.php';

    if(!isset($_SESSION['user'])) {
        Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
    }

    $user = $_SESSION['user'];


$controller = UserController::getInstance();

    $requestType = $_SERVER['REQUEST_METHOD'];
    $id = $user['user_id'];

    if ($requestType != 'DELETE') {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
    }

    if ($id != null) {
        $controller->deleteUser($id);
    } else {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
    };