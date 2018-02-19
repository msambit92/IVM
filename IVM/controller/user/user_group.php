<?php
class Controlleruserusergroup {
	private $registry;
	private $data = array();
	private $error = array();
	private $permissions = array(
			'user' => 'User',
			'inventory_approve' => 'Inventory Approve',
			'inventory_add' => 'Inventory Add',
			'inventory_edit' => 'Inventory Edit',
			'inventory_delete' => 'Inventory Delete'
		);
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
			$getUserGroups = $model->getUserGroups();
			$this->data['user_groups'] = array();
			foreach ($getUserGroups as $user_group) {
				$this->data['user_groups'][] = array(
					'user_group_id' => $user_group['user_group_id'],
					'name' => $user_group['name'],
					'edit' => 'index.php?route=user/user_group/edit&token='. $_SESSION['token']. '&user_group_id='. $user_group['user_group_id']
				);
			}

			if (isset($_SESSION['success'])) {
				$this->data['success'] = $_SESSION['success'];

				unset($_SESSION['success']);
			} else {
				$this->data['success'] = '';
			}
		}

		$this->data['back'] = 'index.php?route=user/user&token='. $_SESSION['token'];
		$this->data['add'] = 'index.php?route=user/user_group/add&token='. $_SESSION['token'];

		$this->registry['load']->controller('common/header');
		$this->registry['load']->view('user/user_group_list', $this->data);
		$this->registry['load']->controller('common/footer');
	}

	public function add() {

		$this->data['allowed'] = false;

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$this->registry['load']->model('user/user');
			$model = new Modeluseruser($this->registry);
			$model->addUserGroup($_POST);
			$_SESSION['success'] = 'You have successfully created user group';
			header("Location: index.php?route=user/user_group&token=". $_SESSION['token']);
		}
		$this->getForm();
	}

	public function edit() {

		$this->data['allowed'] = false;

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$this->registry['load']->model('user/user');
			$model = new Modeluseruser($this->registry);
			$model->editUserGroup($_POST, $_GET['user_group_id']);
			$_SESSION['success'] = 'You have successfully edited user group';
			header("Location: index.php?route=user/user_group&token=". $_SESSION['token']);
		}

		$this->getForm();
	}

	private function getForm(){

		$this->registry['load']->model('user/user');
		$model = new Modeluseruser($this->registry);
		$getUserGroup = $model->getUserGroup($_SESSION['user_id']);

		if ($getUserGroup && $getUserGroup['role'] && in_array('user', unserialize($getUserGroup['role']))) {
			$this->data['allowed'] = true;

			if (isset($_GET['user_group_id'])) {
				$user_group_info = $model->getUserGroupInfo($_GET['user_group_id']);
			}

			if (isset($this->error['name'])) {
				$this->data['error_name'] = $this->error['name'];
			} else {
				$this->data['error_name'] = '';
			}

			if (isset($_POST['name'])) {
				$this->data['name'] = $_POST['name'];
			} elseif (!empty($user_group_info)) {
				$this->data['name'] = $user_group_info['name'];
			} else {
				$this->data['name'] = '';
			}

			if (isset($_POST['permission'])) {
				$this->data['access'] = $_POST['permission'];
			} elseif (isset($user_group_info['role'])) {
				$this->data['access'] = unserialize($user_group_info['role']);
			} else {
				$this->data['access'] = array();
			}

			$this->data['back'] = 'index.php?route=user/user_group&token='. $_SESSION['token'];

			if (!empty($user_group_info)) {
				$this->data['action'] = 'index.php?route=user/user_group/edit&token='. $_SESSION['token']. '&user_group_id='. $_GET['user_group_id'];
			}else{
				$this->data['action'] = 'index.php?route=user/user_group/add&token='. $_SESSION['token'];
			}

			$this->data['permissions'] = $this->permissions;
		}

		$this->registry['load']->controller('common/header');
		$this->registry['load']->view('user/user_group_form', $this->data);
		$this->registry['load']->controller('common/footer');
	}

	private function validate(){
		if (!isset($_POST['name']) && ((strlen($_POST['name']) < 3) || (strlen($_POST['name']) > 20))) {
			$this->error['name'] = 'Please enter user group name between 3 and 20 characters';
		}

		if (!isset($_POST['permission'])) {
			$_POST['permission'] = array();
		}

		return !$this->error;
	}
} 
?>