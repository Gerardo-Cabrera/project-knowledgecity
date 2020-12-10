<?php

//require_once("../models/Authentication.php");
require_once("models/Authentication.php");

class Auth {
	public function __construct() {
		$this->authentication = new Authentication();
	}

	public function auth($data) {
		$response = array();
		$modelAuth = $this->authentication;
		$login = $modelAuth->auth($data);

		if ($login['status'] == 1) {
			session_start();
			$_SESSION['loggedin'] = true;
			$response['status'] = 1;
			$response['loggedin'] = true;
		} else {
			$response['status'] = 2;
			$response['message'] = $login['message'];
		}

		return $response;
    }
    
    public function closeSession() {
        session_start();
        session_destroy();

        $response['message'] = "Close session";

        return $response;
    }
}