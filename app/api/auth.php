<?php

require_once("controllers/Auth.php");
$auth = new Auth();

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        $data = $_POST;
        $result = $auth->auth($data);
        break;
    case 'DELETE':
        $result = $auth->closeSession();
    default:
        break;
}

header('Content-Type: application/json');
echo json_encode($result);