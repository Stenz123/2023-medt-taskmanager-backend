<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ($uri[1] !== 'user') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

echo "userId: $userId";

$requestMethod = $_SERVER["REQUEST_METHOD"];
$conn = Connection::getConnection();

$controller = new UserController($conn, $requestMethod, $userId);
$controller->processRequest();