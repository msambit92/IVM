<?php
class Controllercommonheader {
	private $registry;
	private $data = array();
	public function __construct($registry) {
		$this->registry = $registry->data;
	}

	public function index() {

		$this->registry['load']->model('user/user');
		$model = new Modeluseruser($this->registry);
		$getUserGroup = $model->getUserGroup($_SESSION['user_id']);

		$this->data['dashboard'] = 'index.php?route=common/dashboard&token='. $_SESSION['token'];
		$this->data['user'] = 'index.php?route=user/user&token='. $_SESSION['token'];
		$this->data['inventory'] = 'index.php?route=inventory/inventory&token='. $_SESSION['token'];
		$this->data['logout'] = 'index.php?route=common/logout&token='. $_SESSION['token'];

		$this->registry['load']->view('common/header', $this->data);
	}
} 
?>