<?php

use util\HttpErrorCodes;
require_once '../utils/Response.php';
require_once '../Controller/UserController.php';

session_start();

//api works with this line when using Web but not with Postman
$_POST = json_decode(file_get_contents('php://input'), true);

function validateEmail($email) : bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password): bool
{
    return strlen($password) >= 8;
}

$name = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if (!validateEmail($email)) {
    Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Invalid email")->send();
}

if (!validatePassword($password)) {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "Password too short")->send();
}

$passwordHash = hash('sha256', $password.'feelingSalty');

UserController::getInstance()->createUserFromRequest($name, $email, $passwordHash);