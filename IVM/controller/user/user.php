<?php
class Controlleruseruser {
	private $registry;
	private $data = array();
	private $error = array();
	public function __construct($registry) {
		$this->registry = $registry->data;
	}

	public function index() {
		$this->getList();
	}

	private function getList(){
		$this->data['allowed'] = false;

		$this->registry['load']->model('user/user');
		$model = new Modeluseruser($this->registry);
		$getUserGroup = $model->getUserGroup($_SESSION['user_id']);

		if ($getUserGroup && $getUserGroup['role'] && in_array('user', unserialize($getUserGroup['role']))) {
			$this->data['allowed'] = true;
			$getUsers = $model->getUsers();
			$this->data['users'] = array();
			foreach ($getUsers as $user) {
				$this->data['users'][] = array(
					'user_id' => $user['user_id'],
					'username' => $user['username'],
					'email' => $user['email'],
					'edit' => 'index.php?route=user/user/edit&token='. $_SESSION['token']. '&user_id='. $user['user_id']
				);
			}
		}

		if (isset($_SESSION['success'])) {
			$this->data['success'] = $_SESSION['success'];

			unset($_SESSION['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['user_group'] = 'index.php?route=user/user_group&token='. $_SESSION['token'];
		$this->data['add'] = 'index.php?route=user/user/add&token='. $_SESSION['token'];

		$this->registry['load']->controller('common/header');
		$this->registry['load']->view('user/user_list', $this->data);
		$this->registry['load']->controller('common/footer');
	}

	public function add() {

		$this->data['allowed'] = false;

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$this->registry['load']->model('user/user');
			$model = new Modeluseruser($this->registry);
			$model->addUser($_POST);
			$_SESSION['success'] = 'You have successfully created user';
			header("Location: index.php?route=user/user&token=". $_SESSION['token']);
		}
		$this->getForm();
	}

	public function edit() {

		$this->data['allowed'] = false;

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$this->registry['load']->model('user/user');
			$model = new Modeluseruser($this->registry);
			$model->editUser($_POST, $_GET['user_id']);
			$_SESSION['success'] = 'You have successfully edited user';
			header("Location: index.php?route=user/user&token=". $_SESSION['token']);
		}

		$this->getForm();
	}

	private function getForm(){

		$this->registry['load']->model('user/user');
		$model = new Modeluseruser($this->registry);
		$getUserGroup = $model->getUserGroup($_SESSION['user_id']);

		if ($getUserGroup && $getUserGroup['role'] && in_array('user', unserialize($getUserGroup['role']))) {
			$this->data['allowed'] = true;

			if (isset($_GET['user_id'])) {
				$user_info = $model->getUserInfo($_GET['user_id']);
			}

			if (isset($this->error['username'])) {
				$this->data['error_username'] = $this->error['username'];
			} else {
				$this->data['error_username'] = '';
			}

			if (isset($this->error['password'])) {
				$this->data['error_password'] = $this->error['password'];
			} else {
				$this->data['error_password'] = '';
			}

			if (isset($this->error['confirm'])) {
				$this->data['error_confirm'] = $this->error['confirm'];
			} else {
				$this->data['error_confirm'] = '';
			}

			if (isset($this->error['email'])) {
				$this->data['error_email'] = $this->error['email'];
			} else {
				$this->data['error_email'] = '';
			}


			if (isset($_POST['username'])) {
				$this->data['username'] = $_POST['username'];
			} elseif (!empty($user_info)) {
				$this->data['username'] = $user_info['username'];
			} else {
				$this->data['username'] = '';
			}

			if (isset($_POST['password'])) {
				$this->data['password'] = $_POST['password'];
			} else {
				$this->data['password'] = '';
			}

			if (isset($_POST['confirm'])) {
				$this->data['confirm'] = $_POST['confirm'];
			} else {
				$this->data['confirm'] = '';
			}

			if (isset($_POST['email'])) {
				$this->data['email'] = $_POST['email'];
			} elseif (!empty($user_info)) {
				$this->data['email'] = $user_info['email'];
			} else {
				$this->data['email'] = '';
			}

			if (isset($_POST['user_group_id'])) {
				$this->data['user_group_id'] = $_POST['user_group_id'];
			} elseif (!empty($user_info)) {
				$this->data['user_group_id'] = $user_info['user_group_id'];
			} else {
				$this->data['user_group_id'] = '';
			}

			$this->data['user_groups'] = $getUserGroups = $model->getUserGroups();

			$this->data['back'] = 'index.php?route=user/user&token='. $_SESSION['token'];

			if (!empty($user_info)) {
				$this->data['action'] = 'index.php?route=user/user/edit&token='. $_SESSION['token']. '&user_id='. $_GET['user_id'];
			}else{
				$this->data['action'] = 'index.php?route=user/user/add&token='. $_SESSION['token'];
			}
		}

		// echo '<pre>';
		// print_r($this->data);
		// echo '</pre>';
		// die();

		$this->registry['load']->controller('common/header');
		$this->registry['load']->view('user/user_form', $this->data);
		$this->registry['load']->controller('common/footer');
	}

	private function validate(){
		$this->registry['load']->model('user/user');
		$model = new Modeluseruser($this->registry);

		if ((strlen($_POST['username']) < 3) || (strlen($_POST['username']) > 25)) {
			$this->error['username'] = 'Please enter usermane between 3 and 25 characters';
		}

		$user_info = $model->getUserByUsername($_POST['username']);

		if (!isset($_GET['user_id'])) {
			if ($user_info) {
				$this->error['username'] = 'username is already exists';
			}
		} else {
			if ($user_info && ($_GET['user_id'] != $user_info['user_id'])) {
				$this->error['username'] = 'username is already exists';
			}
		}

		if ((strlen($_POST['email']) > 96) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = 'Please enter email';
		}

		$user_info = $model->getUserByEmail($_POST['email']);


		if (!isset($_GET['user_id'])) {
			if ($user_info) {
				$this->error['email'] = 'Email is already exists';
			}
		} else {
			if ($user_info && ($_GET['user_id'] != $user_info['user_id'])) {
				$this->error['email'] = 'Email is already exists';
			}
		}

		if ($_POST['password'] || (!isset($_GET['user_id']))) {
			if ((strlen($_POST['password']) < 4) || (strlen($_POST['password']) > 20)) {
				$this->error['password'] = 'Please enter password between 4 and 20 characters';
			}

			if ($_POST['password'] != $_POST['confirm']) {
				$this->error['confirm'] = 'Confirm password is incorrect';
			}
		}

// 		echo '<pre>';
// print_r($this->error);
// echo '</pre>';
// die();

		return !$this->error;
	}
} 
?>