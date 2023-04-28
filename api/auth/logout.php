<?php
require_once '../utils/Response.php';

session_start();

$_SESSION['user'] = null;

Response::ok("Logged out")->send();