<?php

function db() {
	static $db = null;
	if (!$db) {
		$db = new PDO(
			'mysql:host='.DB_HOST.';dbname='.DB_NAME,
			DB_USER,
			DB_PASS
		);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	return $db;
}
