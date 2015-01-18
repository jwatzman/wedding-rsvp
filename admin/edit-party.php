<?hh

require_once '../lib/lib.php';

function main__admin-edit-party(): void {
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

	$new_guest_name = idx($_POST, 'new_guest_name');
	if (strlen($new_guest_name) > 0) {
		$stmt = db()->prepare(
			'INSERT INTO guests (name, party_id, is_plus_one)'
			.' VALUES (:name, :party_id, :is_plus_one)'
		);
		$stmt->bindParam(':name', $new_guest_name);
		$stmt->bindParam(':party_id', $id);
		$is_plus_one = (bool)idx($_POST, 'plus_one', false);
		$stmt->bindParam(':is_plus_one', $is_plus_one);
		$stmt->execute();
	}

	$stmt = db()->prepare(
		'SELECT name, is_plus_one, response, rehearsal_response'
		.' FROM guests WHERE party_id = ?'
	);
	$stmt->execute(array($id));
	$parties = $stmt->fetchAll();

	echo t()->render(
		'admin/edit-party.html',
		array(
			'id' => $id,
			'party_name' => $party_name,
			'guests' => $parties,
		)
	);
}

main__admin-edit-party();
