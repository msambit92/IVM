<?php
	class Modelinventoryinventory {
		private $registory;

		public function __construct($registory){
			$this->registory = $registory;
		}

		public function getItems() {
			$query = $this->registory['db']->query("SELECT * FROM inventory")->rows;

			return $query;
		}

		public function approve($status, $product_id){
			$this->registory['db']->query("UPDATE inventory SET status = '" . (int)$this->registory['db']->escape($status) . "' WHERE product_id = '" . (int)$this->registory['db']->escape($product_id) . "'");
		}

		public function delete($product_id){
			$this->registory['db']->query("DELETE FROM inventory WHERE product_id = '" . (int)$this->registory['db']->escape($product_id) . "'");
		}

		public function getProductInfo($product_id){
			$query = $this->registory['db']->query("SELECT * FROM inventory WHERE product_id = '" . (int)$this->registory['db']->escape($product_id) . "'")->row;

			return $query;
		}

		public function addInventory($data = array(), $status){
			$this->registory['db']->query("INSERT INTO inventory SET name = '" . $this->registory['db']->escape($data['name']) . "', vendor = '" . $this->registory['db']->escape($data['vendor']) . "', mrp = '" . (float)$this->registory['db']->escape($data['mrp']) . "', batch_no = '" . (int)$this->registory['db']->escape($data['batch_no']) . "', batch_date = '" . $this->registory['db']->escape($data['batch_date']) . "', quantity = '" . (int)$this->registory['db']->escape($data['quantity']) . "', status = '" . (int)$this->registory['db']->escape($status) . "'");
		}

		public function editInventory($data = array(), $product_id, $status){
			$this->registory['db']->query("UPDATE inventory SET name = '" . $this->registory['db']->escape($data['name']) . "', vendor = '" . $this->registory['db']->escape($data['vendor']) . "', mrp = '" . (float)$this->registory['db']->escape($data['mrp']) . "', batch_no = '" . (int)$this->registory['db']->escape($data['batch_no']) . "', batch_date = '" . $this->registory['db']->escape($data['batch_date']) . "', quantity = '" . (int)$this->registory['db']->escape($data['quantity']) . "', status = '" . (int)$this->registory['db']->escape($status) . "' WHERE product_id = '" . (int)$this->registory['db']->escape($product_id) . "'");
		}
	}

?>