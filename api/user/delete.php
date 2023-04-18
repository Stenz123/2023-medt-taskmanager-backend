<?php

use util\HttpErrorCodes;

require_once '../Controller/UserController.php';

    $controller = UserController::getInstance();

    $requestType = $_SERVER['REQUEST_METHOD'];
    $id = $_GET['id'];

    if ($requestType != 'DELETE') {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid request type")->send();
    }

    if ($id != null) {
        $controller->deleteUser($id);
    } else {
        Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
    };