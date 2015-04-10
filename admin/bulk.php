<?hh

require_once '../lib/lib.php';

enforce_admin();

function bulk_add(string $data): void {
	$parties = explode("\r\n\r\n", $data);
	foreach ($parties as $party) {
		echo "--- Begin new party\n";

		$members = explode("\r\n", $party);

		$party_name = '[Bulk] '.implode('/', $members);
		echo "Creating party: $party_name\n";
		$party_id = create_party($party_name, false);
		echo "Created party ID $party_id\n";

		foreach ($members as $member) {
			echo "Adding $member\n";

			$is_plus_one = false;
			if (substr($member, 0, 2) === '+1') {
				$is_plus_one = true;
				$member = trim(substr($member, 2));
				echo "  as a +1\n";
			}

			add_guest($party_id, $member, $is_plus_one);
		}

		echo "-- Finished party\n\n";
	}
}

function main__admin_bulk(): void {
	$bulk_data = idx($_POST, 'bulk_data', '');
	if (strlen($bulk_data) > 0) {
		echo '<pre>';
		bulk_add($bulk_data);
		echo 'Done!';
		echo '</pre>';
		return;
	}

	echo t()->render('admin/bulk.html', array());
}

main__admin_bulk();
