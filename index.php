<?php

require_once 'lib/lib.php';

$guests = null;

$search_name = idx($_GET, 'name');
if (strlen($search_name) > 1) {
	$stmt = db()->prepare(
		'SELECT guests.name, guests.party_id, parties.akey FROM guests'
		.' INNER JOIN parties ON guests.party_id = parties.id'
	    .' WHERE guests.name LIKE :search_name'
	);

	$search_name = '%'.$search_name.'%';
	$stmt->bindParam(':search_name', $search_name);
	$stmt->execute();
	$guests = $stmt->fetchAll();
}

echo t()->render('index.html', array('guests' => $guests));
