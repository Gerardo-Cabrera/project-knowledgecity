<?php

require_once("../conf/database_connection.php");

class Authentication {
    public function __construct() {
        $this->connection = new DatabaseConnection();
        $this->table = "api_users";
    }

    public function auth($data) {
        $respuesta = array();

		try {
            $connect = $this->connection->connect();
            $table = $this->table;
            $username = $data['username'];
            $pass = $data['password'];
            $sql = "SELECT id, password FROM $table WHERE username = ?";
            $result = $connect->prepare($sql);
            $result->bind_param('s', $username);
            $result->execute();
            $result->store_result();

            if ($result->num_rows > 0) {
                $result->bind_result($id, $password);
                $result->fetch();

                if ($pass === $password) {
                    $respuesta['status'] = 1;
                    $respuesta['message'] = 'Success';
                } else {
                    $respuesta['status'] = 2;
                    $respuesta['message'] = 'Incorrect password';
                }
            } else {
                $respuesta['status'] = 2;
                $respuesta['message'] = 'User not registered';
            }

		    $result->close();
		} catch (Exception $e) {
		    echo 'There was an error logging in. ' . $e->getMessage();
        }
        
		return $respuesta;
	}
}