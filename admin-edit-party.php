<?php

require_once 'lib/lib.php';

$id = idx($_GET, 'id');
if ($id === null) {
	echo "No id\n";
	return;
}

$stmt = db()->prepare('SELECT name FROM parties WHERE id = ?');
$stmt->execute(array($id));
if (($party = $stmt->fetch()) === false) {
	echo "Unknown id\n";
	return;
}
$party_name = $party['name'];
echo $party_name;
