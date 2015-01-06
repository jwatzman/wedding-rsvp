<?php

function db() {
	static $db = null;
	if (!$db) {
		$db = new PDO(
			'mysql:host='.DB_HOST.';dbname='.DB_NAME,
			DB_USER,
			DB_PASS
		);
	}

	return $db;
}
