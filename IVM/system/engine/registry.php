<?php
final class Registry {
	public $data = array();

	public function set($key, $value) {
		$this->data[$key] = $value;
	}
}