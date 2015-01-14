<?php

require_once '../lib/lib.php';

$new_party_name = idx($_POST, 'new_party_name');
if (strlen($new_party_name) > 0) {
	$stmt = db()->prepare(
		'INSERT INTO parties (name, rehearsal_invited)'
		.' VALUES (:name, :rehearsal)'
	);
	$stmt->bindParam(':name', $new_party_name);
	$rehearsal = (bool)idx($_POST, 'rehearsal', false);
	$stmt->bindParam(':rehearsal', $rehearsal);
	$stmt->execute();
}

$parties = db()->query('SELECT id, name, comment, rehearsal_invited FROM parties');

echo t()->render('admin/index.html', array('parties' => $parties));
