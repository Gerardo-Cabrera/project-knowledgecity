<?php

require_once("controllers/Users.php");
$users = new Users();

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'GET':
        $result = $users->users();
        break;
    default:
        break;
}

header('Content-Type: application/json');
echo json_encode($result);