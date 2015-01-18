<?hh

require_once 'lib/lib.php';

function main__rsvp() {
	$party = null;
	$guests = null;

	$party_id = idx($_GET, 'id');
	$akey = idx($_GET, 'akey');
	if ($party_id && $akey) {
		$stmt = db()->prepare(
			'SELECT id, akey, comment, rehearsal_invited FROM parties'
			.' WHERE id = :party_id AND akey = :akey'
		);
		$stmt->bindParam(':party_id', $party_id);
		$stmt->bindParam(':akey', $akey);
		$stmt->execute();
		$party = $stmt->fetch();

		$stmt = db()->prepare(
			'SELECT id, name, response, rehearsal_response, is_plus_one'
			.' FROM guests WHERE party_id = :party_id'
		);
		$stmt->bindParam(':party_id', $party_id);
		$stmt->execute();
		$guests = $stmt->fetchAll();
	}

	if (!$party || !$guests) {
		echo "Invalid id\n";
		return;
	}

	echo t()->render(
		'rsvp.html',
		array('guests' => $guests, 'party' => $party)
	);
}

main__rsvp();
