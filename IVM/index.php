<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (is_file('config.php')) {
	require_once('config.php');
}else{
	echo 'Your config file is missing.';
}

session_start();

// Registry
require_once(DIR_SYSTEM . '/engine/registry.php'); 
$registry = new Registry();

require_once(DIR_SYSTEM . '/library/db/database.php'); 
$db = new Database(db_hostname, db_username, db_password, db_database, db_port);
$registry->set('db', $db);

require_once(DIR_SYSTEM . '/engine/controller.php');
require_once(DIR_SYSTEM . '/engine/loader.php');
$loader = new Loader($registry); 
$registry->set('load', $loader);

$db->query("CREATE TABLE IF NOT EXISTS user (
			user_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			email VARCHAR(100) NOT NULL,
			username VARCHAR(25) NOT NULL,
			password VARCHAR(20) NOT NULL,
			user_group_id int(11))");

$db->query("CREATE TABLE IF NOT EXISTS user_group (
			user_group_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(20) NOT NULL,
			role text NOT NULL)");

$db->query("CREATE TABLE IF NOT EXISTS inventory (
			product_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL,
			vendor VARCHAR(100) NULL,
			mrp decimal(15,4) NOT NULL,
			batch_no int(11) NULL,
			batch_date date NULL,
			quantity int(11) NOT NULL,
			status tinyint(1))");

if (isset($_GET) && $_GET) {

	if (isset($_GET['route'])) {

		if ($_GET['route'] == 'common/login' || $_GET['route'] == 'common/login/validate') {
			$loader->controller($_GET['route']);
		} elseif (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
			$loader->controller($_GET['route']);
		}else{
			header("Location: index.php?route=common/login");
		}
	}else{
		header("Location: index.php?route=common/login");
	}
}else{
	header("Location: index.php?route=common/login");
}
?>