<?hh

function db(): PDO {
	static $db = null;
	if (!$db) {
		$db = new PDO(
			'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
			DB_USER,
			DB_PASS
		);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute(
			PDO::MYSQL_ATTR_INIT_COMMAND,
			'SET sql_mode="STRICT_ALL_TABLES"'
		);
	}

	return $db;
}
