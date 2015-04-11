<?hh

require_once '../lib/lib.php';

enforce_admin();

function main__admin_summary(): void {
	$guests = db()->query(
		'SELECT'
		.' guests.name, guests.response, guests.rehearsal_response,'
		.' guests.is_plus_one, guests.party_id, parties.rehearsal_invited'
		.' FROM guests'
		.' INNER JOIN parties ON guests.party_id = parties.id'
	);

	$guests_by_party = array();
	$total_guests = 0;
	$total_responses = 0;
	$total_attending = 0;

	foreach ($guests as $guest) {
		$guests_by_party[$guest['party_id']][] = $guest;
		$total_guests++;

		$response = $guest['response'];
		if ($response !== null) {
			$total_responses++;

			if ($response) {
				$total_attending++;
			}
		}
	}

	echo t()->render(
		'admin/summary.html',
		array(
			'guests_by_party' => $guests_by_party,
			'total_guests' => $total_guests,
			'total_responses' => $total_responses,
			'total_attending' => $total_attending,
		)
	);
}

main__admin_summary();
