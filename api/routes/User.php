<?php
    require_once '../Controller/UserController.php';

    $controller = UserController::getInstance();

    $requestType = $_SERVER['REQUEST_METHOD'];
    $id = $_GET['id'];

    switch ($requestType) {
        case 'GET':
            if ($id) {
                $response = $controller->getUser($id);
            } else {
                $response = $controller->getAllUsers();
            };
            break;
        case 'POST':
            $response = $controller->createUserFromRequest();
            break;
        case 'PUT':
            $response = $controller->updateUserFromRequest($id);
            break;
        case 'DELETE':
            $response = $controller->deleteUser($id);
            break;
        default:
            $response = $controller->notFoundResponse();
            break;
    }

    $lkm = $controller->  getUser(10    );
    echo $lkm;