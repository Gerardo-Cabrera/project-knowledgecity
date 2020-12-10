<?php

require_once("controllers/Auth.php");
require_once("controllers/Users.php");
$auth = new Auth();
$users = new Users();

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        //$data = $_POST['data'];
        $data = $_POST;
        $result = $auth->auth($data);
        break;
    case 'GET':
        $result = $users->users();
        break;
    case 'DELETE':
        $result = $auth->closeSession();
    default:
        # code...
        break;
}

//header('Content-Type: application/json');
echo json_encode($result);

// $connection = new DatabaseConnection();

// if (isset($_POST['data']['funcion']) && isset($_POST['data']['datos'])) {
// 	$funcion = $_POST['data']['funcion'];
// 	$data = $_POST['data']['datos'];

// 	if ($funcion == "eliminarUsuario") {
// 		$data = $_POST['data']['datos']['id'];
// 	}

// 	$datos = consulta($connection, $funcion, $data);
// 	echo json_encode($datos);
// }