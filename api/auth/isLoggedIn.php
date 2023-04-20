<?php

use util\HttpErrorCodes;
require_once '../utils/Response.php';

session_start();
if (isset($_SESSION['user'])) {
    Response::ok("User logged in")->send();
} else {
    Response::error(HttpErrorCodes::HTTP_UNAUTHORIZED, "You are not logged in")->send();
}