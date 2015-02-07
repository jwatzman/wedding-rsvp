<?hh

require_once 'lib/lib.php';

function main__index(): void {
	$guests = null;

	$password = idx($_GET, 'password');
	$password_valid = $password === RSVP_PASS;

	$name = idx($_GET, 'name');
	if ($password_valid && strlen($name) > 1) {
		$stmt = db()->prepare(
			'SELECT guests.name, guests.party_id, parties.akey FROM guests'
			.' INNER JOIN parties ON guests.party_id = parties.id'
			.' WHERE guests.name LIKE :search_name ESCAPE "="'
		);

		$search_name = str_replace(
			array('=', '_', '%'),
			array('==', '=_', '=%'),
			$name
		);
		$search_name = '%'.$search_name.'%';
		$stmt->bindParam(':search_name', $search_name);
		$stmt->execute();
		$guests = $stmt->fetchAll();
	}

	echo t()->render(
		'index.html',
		array(
			'guests' => $guests,
			'name' => $name,
			'password' => $password,
			'password_valid' => $password_valid,
		)
	);
}

main__index();
