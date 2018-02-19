<?php
class Controllercommonfooter {
	private $registry;
	private $data = array();
	public function __construct($registry) {
		$this->registry = $registry->data;
	}

	public function index() {
		$this->registry['load']->view('common/footer', $this->data);
	}
} 
?>