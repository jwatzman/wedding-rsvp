<?php

require_once 'lib/lib.php';

$new_party_name = idx($_POST, 'new_party_name');
if (strlen($new_party_name) > 0) {
	$stmt = db()->prepare('INSERT INTO parties (name) VALUES (:name)');
	$stmt->bindParam(':name', $new_party_name);
	$stmt->execute();
}

$parties = db()->query('SELECT id, name, comment FROM parties');

echo t()->render('admin.html', array('parties' => $parties));
