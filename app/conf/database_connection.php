<?php

class DatabaseConnection
{
	function readFile() {
		try {
			$path = __DIR__.'/config.json';
			$file = file_get_contents($path);
			$iterator = new RecursiveIteratorIterator(
			    new RecursiveArrayIterator(json_decode($file, TRUE)),
			    RecursiveIteratorIterator::SELF_FIRST);
			$arrConf = array();

			foreach ($iterator as $key => $val) {
			    if(!is_array($val)) {
			        $arrConf[$key] = $val;
			    }
			}
		} catch (Exception $e) {
			echo 'Ocurrió un error leyendo el archivo de configuración. ' . $e->getMessage();
		}

		return $arrConf;
	}

	public function connect() {
		try {
			$arrConf = $this->readFile();
			$host = $arrConf["host"];
			$user = $arrConf["user"];
			$password = $arrConf["password"];
			$database = $arrConf["database"];
			$connection = mysqli_connect($host, $user, $password, $database);
		} catch (Exception $e) {
			echo 'An error occurred and could not connect to the database. ' . $e->getMessage();
		}

		return $connection;
	}

	public function auth($data) {
		session_start();
		$respuesta = array();

		try {
			$connect = $this->connect();
			$usuario = $data['usuario'];
			$pass = $data['password'];
			$sql = 'SELECT id, password FROM usuarios WHERE usuario = ? OR email = ?';
			$result = $connect->prepare($sql);
			$result->bind_param('ss', $usuario, $usuario);
			$result->execute();
			$result->store_result();

			if ($result->num_rows > 0) {
				$result->bind_result($id, $password);
				$result->fetch();

				if (password_verify($pass, $password)) {
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $usuario;
					$_SESSION['id'] = $id;
					$respuesta['estatus'] = 1;
					$respuesta['mensaje'] = 'inicio.php';
				} else {
					$respuesta['estatus'] = 2;
					$respuesta['mensaje'] = 'Contraseña incorrecta';
				}
			} else {
				$respuesta['estatus'] = 2;
				$respuesta['mensaje'] = 'Usuario o correo incorrecto';
			}

			$result->close();
		} catch (Exception $e) {
			echo 'Ocurrió un error ingresando al sistema. ' . $e->getMessage();
		}

		return $respuesta;
	}
}