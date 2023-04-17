<?php

use util\HttpErrorCodes;

require_once '../Controller/UserController.php';

    $controller = UserController::getInstance();

    $requestType = $_SERVER['REQUEST_METHOD'];
    $id = $_GET['id'];

    switch ($requestType) {
        case 'GET':
            if ($id != null) {
                $controller->getUser($id);
            } else {
                $controller->getAllUsers();
            };
            break;
        case 'POST':
            $controller->createUserFromRequest($_POST['username'], $_POST['email'], $_POST['password']);
            break;
        case 'DELETE':
            if ($id != null) {
                $controller->deleteUser($id);
            } else {
                Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
            };
            break;
    }