<?php
class Controllercommondashboard {
	private $registry;
	private $data = array();
	public function __construct($registry) {
		$this->registry = $registry->data;
	}

	public function index() {
		$this->registry['load']->controller('common/header');
		$this->registry['load']->view('common/dashboard', $this->data);
		$this->registry['load']->controller('common/footer');
	}
} 
?>