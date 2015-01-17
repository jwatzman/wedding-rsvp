<?php

require_once 'lib/lib.php';

$party = null;
$guests = null;

$party_id = idx($_GET, 'id');
$akey = idx($_GET, 'akey');
if ($party_id && $akey) {
	$stmt = db()->prepare(
		'SELECT comment, rehearsal_invited FROM parties'
		.' WHERE id = :party_id AND akey = :akey'
	);
	$stmt->bindParam(':party_id', $party_id);
	$stmt->bindParam(':akey', $akey);
	$stmt->execute();
	$party = $stmt->fetch();

	$stmt = db()->prepare(
		'SELECT name, response, rehearsal_response, is_plus_one FROM guests'
		.' WHERE party_id = :party_id'
	);
	$stmt->bindParam(':party_id', $party_id);
	$stmt->execute();
	$guests = $stmt->fetchAll();
}

if (!$party || !$guests) {
	echo "Invalid id\n";
	return;
}

echo '<pre>';
var_dump($party);
var_dump($guests);
