<?php
	class ModelCommonLogin {
		private $registory;
		public function __construct($registory){
			$this->registory = $registory;
		}
		public function login($username, $password){
			$query = $this->registory['db']->query("SELECT * FROM user WHERE username = '" . $this->registory['db']->escape($username) . "' AND password = '" . $this->registory['db']->escape($password) . "'")->row;

			return $query;
		}
	} 
?>