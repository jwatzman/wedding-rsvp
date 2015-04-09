<?hh

require_once '../lib/lib.php';

enforce_admin();

function main__admin_index(): void {
	$new_party_name = idx($_POST, 'new_party_name', '');
	if (strlen($new_party_name) > 0) {
		$rehearsal = (bool)idx($_POST, 'rehearsal', false);
		$id = create_party($new_party_name, $rehearsal);
	}

	$parties = db()->query(
		'SELECT id, name, comment, rehearsal_invited FROM parties'
	);

	echo t()->render('admin/index.html', array('parties' => $parties));
}

main__admin_index();
