<?php
class Controllercommonlogin {
	private $registry;
	private $data = array();
	public function __construct($registry) {
		$this->registry = $registry->data;
	}

	public function index() {
		$this->registry['load']->view('common/login', $this->data);
	}

	public function validate() {

		$json = array();

		if (!isset($_POST['username']) || !$_POST['username']) {
			$json['error']['username'] = 'Please enter your username';
		}

		if (!isset($_POST['password']) || !$_POST['password']) {
			$json['error']['password'] = 'Please enter your password';
		}

		if (!isset($json['error'])) {
			$this->registry['load']->model('common/login');
			$model = new ModelCommonLogin($this->registry);
			$result = $model->login($_POST['username'], $_POST['password']);

			if ($result) {
				$_SESSION['user_id'] = $result['user_id'];
				$_SESSION['token'] = md5(uniqid(rand(), true));
				$json['success'] = $_SESSION['token'];
			}else{
				$json['error']['not_authenticated'] = 'Please enter correct username and password';
			}
		}

		// echo '<pre>';
		// 	print_r($json);
		// 	echo '</pre>';
		// 	die();

		echo json_encode($json);
	}

} 
?>