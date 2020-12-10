<?php

require_once("models/User.php");

class Users {
	public function __construct() {
		$this->user = new User();
	}

	public function users() {
		$modelUser = $this->user;
		$users = $modelUser->listUsers();
		return $users;
	}
}