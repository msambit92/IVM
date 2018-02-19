<?php
class Controllerinventoryinventory {
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
		$model_user = new Modeluseruser($this->registry);

		$this->registry['load']->model('inventory/inventory');
		$model_inventory = new Modelinventoryinventory($this->registry);

		$getUserGroup = $model_user->getUserGroup($_SESSION['user_id']);

		if ($getUserGroup && $getUserGroup['role'] && (in_array('inventory_approve', unserialize($getUserGroup['role'])) || in_array('inventory_add', unserialize($getUserGroup['role'])) || in_array('inventory_edit', unserialize($getUserGroup['role'])) || in_array('inventory_delete', unserialize($getUserGroup['role'])))) {
			$this->data['allowed'] = true;
			$getItems = $model_inventory->getItems();
			$this->data['items'] = array();
			foreach ($getItems as $item) {
				$this->data['items'][] = array(
					'product_id' => $item['product_id'],
					'name'       => $item['name'],
					'mrp'        => $item['mrp'],
					'vendor'     => $item['vendor'],
					'batch_no'   => $item['batch_no'],
					'batch_date' => $item['batch_date'],
					'quantity'   => $item['quantity'],
					'status'     => $item['status'] ? 'Approved' : 'Pending',
					'status_id'  => $item['status'],
					'edit'       => 'index.php?route=inventory/inventory/edit&token='. $_SESSION['token']. '&product_id='. $item['product_id']
				);
			}

			if (isset($_SESSION['success'])) {
				$this->data['success'] = $_SESSION['success'];

				unset($_SESSION['success']);
			} else {
				$this->data['success'] = '';
			}

			$this->data['user_role'] =  unserialize($getUserGroup['role']);
			$this->data['token'] = $_SESSION['token'];

			$this->data['delete'] = 'index.php?route=inventory/inventory/delete&token='. $_SESSION['token'];
			$this->data['add'] = 'index.php?route=inventory/inventory/add&token='. $_SESSION['token'];
		}

		$this->registry['load']->controller('common/header');
		$this->registry['load']->view('inventory/inventory_list', $this->data);
		$this->registry['load']->controller('common/footer');
	}

	public function add() {
		$this->getForm('inventory_add');
	}

	public function edit() {
		$this->getForm('inventory_edit');
	}

	private function getForm($role){

		$this->data['allowed'] = false;

		$this->registry['load']->model('user/user');
		$model_user = new Modeluseruser($this->registry);
		$getUserGroup = $model_user->getUserGroup($_SESSION['user_id']);

		if ($getUserGroup && $getUserGroup['role'] && in_array($role, unserialize($getUserGroup['role']))) {
			$this->data['allowed'] = true;

			if (isset($_GET['product_id'])) {
				$this->registry['load']->model('inventory/inventory');
				$model_inventory = new Modelinventoryinventory($this->registry);
				$product_info = $model_inventory->getProductInfo($_GET['product_id']);
			}

			$field_datas = array(
				'name',
				'vendor',
				'mrp',
				'batch_no',
				'batch_date',
				'quantity'
			);

			foreach ($field_datas as $field_data) {
				if (!empty($product_info)) {
					$this->data[$field_data] = $product_info[$field_data];
				} else {
					$this->data[$field_data] = '';
				}
			}

			$this->data['back'] = 'index.php?route=inventory/inventory&token='. $_SESSION['token'];

			if (!empty($product_info)) {
				$this->data['product_id'] = $_GET['product_id'];
			}else{
				$this->data['product_id'] = '';
			}
		}

		$this->data['token'] = $_SESSION['token'];

		$this->registry['load']->controller('common/header');
		$this->registry['load']->view('inventory/inventory_form', $this->data);
		$this->registry['load']->controller('common/footer');
	}

	public function delete(){
		$json = array();
		$this->registry['load']->model('user/user');
		$model_user = new Modeluseruser($this->registry);

		$getUserGroup = $model_user->getUserGroup($_SESSION['user_id']);
		if ($getUserGroup && $getUserGroup['role'] && in_array('inventory_delete', unserialize($getUserGroup['role'])) && isset($_POST['product_id'])) {
			
			$this->registry['load']->model('inventory/inventory');
			$model_inventory = new Modelinventoryinventory($this->registry);
			$model_inventory->delete($_POST['product_id']);

			$json['success'] = 'You have deleted the inventory';
			
		}else{
			$json['error'] = 'You are not allowed to delete inventory';
		}

		echo json_encode($json);
	}

	public function approve(){

		$json = array();

		$this->registry['load']->model('user/user');
		$model_user = new Modeluseruser($this->registry);

		$getUserGroup = $model_user->getUserGroup($_SESSION['user_id']);

		if ($getUserGroup && $getUserGroup['role'] && in_array('inventory_approve', unserialize($getUserGroup['role'])) && isset($_POST['product_id']) && isset($_POST['approve'])) {

			if (!isset($_POST['approve'])) {
				$json['error'] = 'There is some issue. Please try again';
			}

			if (!isset($json['error'])) {
				$this->registry['load']->model('inventory/inventory');
				$model_inventory = new Modelinventoryinventory($this->registry);
				$model_inventory->approve($_POST['approve'], $_POST['product_id']);

				if ($_POST['approve']) {
					$json['success'] = 'You have approved the inventory';
				}else{
					$json['success'] = 'You have disapproved the inventory';
				}
			}
		}else{
			$json['error'] = 'You are not allowed to approve or disapprove inventory';
		}

		echo json_encode($json);
	}

	public function save(){
		$json = array();

		$this->registry['load']->model('user/user');
		$model_user = new Modeluseruser($this->registry);

		$getUserGroup = $model_user->getUserGroup($_SESSION['user_id']);

		if ($getUserGroup && $getUserGroup['role'] && isset($_POST['action']) && in_array($_POST['action'], unserialize($getUserGroup['role']))) {
			if ((strlen(trim($_POST['name'])) < 3) || (strlen(trim($_POST['name'])) > 255)) {
				$json['error']['product_name'] = 'Please enter product name between 3 and 255 characters';
			}

			if (!isset($json['error'])) {
				$this->registry['load']->model('inventory/inventory');
				$model_inventory = new Modelinventoryinventory($this->registry);
				if ($_POST['action'] == 'inventory_add') {
					if (in_array('inventory_approve', unserialize($getUserGroup['role']))) {
						$status = 1;
					}else{
						$status = 0;
					}

					$model_inventory->addInventory($_POST, $status);
					$_SESSION['success'] = 'You have successfully added a new inventory';
					$json['success'] = true;
				}else{

					if (in_array('inventory_approve', unserialize($getUserGroup['role']))) {
						$status = 1;
					}else{
						$status = 0;
					}

					$model_inventory->editInventory($_POST, $_POST['product_id'], $status);
					$_SESSION['success'] = 'You have successfully edited inventory';
					$json['success'] = true;
				}
			}
		}else{
			if ($_POST['action'] == 'inventory_add') {
				$json['error'] = 'You are not allowed add inventory';
			}else{
				$json['error'] = 'You are not allowed edit inventory';
			}
		}

		echo json_encode($json);
	}
} 
?>