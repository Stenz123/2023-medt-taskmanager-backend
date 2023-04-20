<?php

use util\HttpErrorCodes;

require_once '../utils/Response.php';
require_once '../Controller/UserController.php';

session_start();

//api works with this line when using Web but not with Postman
$_POST = json_decode(file_get_contents('php://input'), true);

$email = $_POST['email'];
$password = $_POST['password'];

if ($email == null || $password == null) {
    echo "Missing parameters";
    echo $email;
    echo $password;
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
}

$dbUser = UserController::getInstance()->getUserByEmail($email)[0];

if ($dbUser == null) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "User not found")->send();
}

$passwordHash = hash('sha256', $password.'feelingSalty');

if(!password_verify($passwordHash, $dbUser['password'])) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "Wrong password")->send();
}

$_SESSION['user'] = $dbUser;

Response::ok("Login successful", $dbUser)->send();