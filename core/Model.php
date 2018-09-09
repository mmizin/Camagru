<?php
class Model {

	public function db_connection() {
		include(ROOT . '/config/database.php');
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		return $db;
	}
}