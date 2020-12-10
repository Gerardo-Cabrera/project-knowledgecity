<?php

require_once("../conf/database_connection.php");

class User {
    public function __construct() {
        $this->connection = new DatabaseConnection();
        $this->table = "students";
    }
    
    public function listUsers() {
        $response = array();

		try {
            $connect = $this->connection->connect();
            $table = $this->table;
			$sql = "SELECT name, lastname, username, student_group FROM $table";
			$result = $connect->query($sql);
            $listUsers = $result->fetch_all(MYSQLI_ASSOC);

            if (count($listUsers) > 0) {
                $response['status'] = 1;
                $response['list_users'] = $listUsers;
            } else {
                $response['status'] = 2;
                $response['message'] = "There are not users.";
            }
		} catch (Exception $e) {
			echo 'Ocurrió un error obteniendo el listado de usuarios. ' . $e->getMessage();
		}

		return $response;
	}
}