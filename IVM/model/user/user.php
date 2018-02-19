<?php
	class Modeluseruser {
		private $registory;

		public function __construct($registory){
			$this->registory = $registory;
		}

		public function getUserGroup($user_id){
			$query = $this->registory['db']->query("SELECT * FROM user u LEFT JOIN user_group ug ON (u.user_group_id = ug.user_group_id) WHERE u.user_id = '" . (int)$this->registory['db']->escape($user_id) . "'")->row;

			return $query;
		}

		public function getUsers(){
			$query = $this->registory['db']->query("SELECT * FROM user")->rows;

			return $query;
		}

		public function getUserInfo($user_id){
			$query = $this->registory['db']->query("SELECT * FROM user WHERE user_id = '" . (int)$this->registory['db']->escape($user_id) . "'")->row;

			return $query;
		}

		public function getUserGroups(){
			$query = $this->registory['db']->query("SELECT * FROM user_group")->rows;

			return $query;
		}

		public function addUserGroup($data = array()){
			$this->registory['db']->query("INSERT INTO user_group SET name = '" . $this->registory['db']->escape($data['name']) . "', role = '" . $this->registory['db']->escape(serialize($data['permission'])) . "'");
		}

		public function editUserGroup($data = array(), $user_group_id){
			$this->registory['db']->query("UPDATE user_group SET name = '" . $this->registory['db']->escape($data['name']) . "', role = '" . $this->registory['db']->escape(serialize($data['permission'])) . "' WHERE user_group_id = '" . (int)$this->registory['db']->escape($user_group_id) . "'");
		}

		public function addUser($data = array()){
			$this->registory['db']->query("INSERT INTO user SET username = '" . $this->registory['db']->escape($data['username']) . "', email = '" . $this->registory['db']->escape($data['email']) . "', password = '" . $this->registory['db']->escape($data['password']) . "', user_group_id = '" . (int)$this->registory['db']->escape($data['user_group_id']) . "'");
		}

		public function editUser($data = array(), $user_id){
			$this->registory['db']->query("UPDATE user SET username = '" . $this->registory['db']->escape($data['username']) . "', email = '" . $this->registory['db']->escape($data['email']) . "', password = '" . $this->registory['db']->escape($data['password']) . "', user_group_id = '" . (int)$this->registory['db']->escape($data['user_group_id']) . "' WHERE user_id = '" . (int)$this->registory['db']->escape($user_id) . "'");
		}

		public function getUserGroupInfo($user_group_id){
			$query = $this->registory['db']->query("SELECT * FROM user_group WHERE user_group_id = '" . (int)$this->registory['db']->escape($user_group_id) . "'")->row;

			return $query;
		}

		public function getUserByUsername($username){
			$query = $this->registory['db']->query("SELECT * FROM user WHERE username = '" . $this->registory['db']->escape($username) . "'")->row;

			return $query;
		}

		public function getUserByEmail($email){
			$query = $this->registory['db']->query("SELECT * FROM user WHERE email = '" . $this->registory['db']->escape($email) . "'")->row;

			return $query;
		}
	} 
?>