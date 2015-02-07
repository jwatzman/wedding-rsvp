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

	foreach ($guests as &$guest) {
		// Depending on which exact mysql PDO driver you have, these may come
		// back as strings or ints.
		$r = $guest['response'];
		if ($r !== null) {
			$guest['response'] = (int)$r;
		}

		$r = $guest['rehearsal_response'];
		if ($r !== null) {
			$guest['rehearsal_response'] = (int)$r;
		}
	}
	/* UNSAFE_EXPR */ unset($guest);

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$update_guest_stmt = db()->prepare(
			'UPDATE guests SET'
			.' name = :name,'
			.' response = :response,'
			.' rehearsal_response = :rehearsal_response'
			.' WHERE id = :id'
		);

		// OH HOW I LOVE REFERENCES
		$name = null;
		$response = null;
		$rehearsal_response = null;
		$guest_id = null;
		$update_guest_stmt->bindParam(':name', $name);
		$update_guest_stmt->bindParam(':response', $response);
		$update_guest_stmt->bindParam(':rehearsal_response', $rehearsal_response);
		$update_guest_stmt->bindParam(':id', $guest_id);

		foreach ($guests as &$guest) {
			$guest_id = $guest['id'];
			$name = $guest['name'];
			if ($guest['is_plus_one']) {
				$name = idx($_POST, 'name-'.$guest_id, $name);
			}

			$response = idx($_POST, 'response-'.$guest_id, 'y') === 'y';

			if ($party['rehearsal_invited']) {
				$rehearsal_response =
					idx($_POST, 'rehearsal-response-'.$guest_id, 'y') === 'y';
			} else {
				$rehearsal_response = null;
			}

			$update_guest_stmt->execute();

			$guest['name'] = $name;
			$guest['response'] = $response;
			$guest['rehearsal_response'] = $rehearsal_response;
		}
		/* UNSAFE_EXPR */ unset($guest);

		$update_comment_stmt = db()->prepare(
			'UPDATE parties SET comment = :comment WHERE id = :id'
		);
		$party['comment'] = idx($_POST, 'comment', '');
		$update_comment_stmt->bindParam(':id', $party_id);
		$update_comment_stmt->bindParam(':comment', $party['comment']);
		$update_comment_stmt->execute();

		// TODO: output message when sucesfull
	}

	echo t()->render(
		'rsvp.html',
		array('guests' => $guests, 'party' => $party)
	);
}

main__rsvp();
