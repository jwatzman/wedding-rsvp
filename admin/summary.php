<?hh

require_once '../lib/lib.php';

enforce_admin();

function main__admin_summary(): void {
	$guests = db()->query(
		'SELECT'
		.' guests.name, guests.response, guests.rehearsal_response,'
		.' parties.rehearsal_invited'
		.' FROM guests'
		.' INNER JOIN parties ON guests.party_id = parties.id'
	);

	echo t()->render('admin/summary.html', array('guests' => $guests));
}

main__admin_summary();
