<?php
class Controllercommonlogout {
	private $registry;
	public function __construct($registry) {
		$this->registry = $registry->data;
	}

	public function index() {
		unset($_SESSION['user_id']);
		session_destroy();
		header("Location: index.php?route=common/login");
	}
}