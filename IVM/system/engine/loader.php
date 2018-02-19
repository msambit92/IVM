<?php 
	final class Loader {
		public $registry;

		public function __construct($registry) {
			$this->registry = $registry;
		}

		public function controller($route){
			// Sanitize the call
			$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
			$action = new Controller($route);
			$output = $action->execute($this->registry);
		}

		public function model($route){
			// Sanitize the call
			$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
			
			$file  = 'model/' . $route . '.php';
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $route);
			
			if (is_file($file)) {
				include_once($file);
			} else {
				throw new Exception('Error: Could not load model ' . $route . '!');
			}
		}

		public function view($route, $data = array()){
			// Sanitize the call
			$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
			
			$file  = 'view/template/' . $route . '.php';
			
			if (is_file($file)) {
				include_once($file);
			} else {
				throw new Exception('Error: Could not load view ' . $route . '!');
			}
		}
	}
?>