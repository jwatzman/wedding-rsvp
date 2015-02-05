<?hh

require_once '../lib/lib.php';

function main__admin_index(): void {
	$new_party_name = idx($_POST, 'new_party_name');
	if (strlen($new_party_name) > 0) {
		$stmt = db()->prepare(
			'INSERT INTO parties (name, akey, rehearsal_invited)'
			.' VALUES (:name, :akey, :rehearsal)'
		);

		$stmt->bindParam(':name', $new_party_name);

		// This is a terrible way to generate a random string, but security
		// isn't a huge concern, just preventing stupid scraping.
		$akey = substr(md5(mt_rand()), 0, 4);
		$stmt->bindParam(':akey', $akey);

		$rehearsal = (bool)idx($_POST, 'rehearsal', false);
		$stmt->bindParam(':rehearsal', $rehearsal);

		$stmt->execute();
	}

	$parties = db()->query(
		'SELECT id, name, comment, rehearsal_invited FROM parties'
	);

	echo t()->render('admin/index.html', array('parties' => $parties));
}

main__admin_index();
