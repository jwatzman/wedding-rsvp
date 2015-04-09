<?hh

function is_admin(): bool {
	return idx($_COOKIE, 'admin', '') === ADMIN_PASS;
}

function enforce_admin(): void {
	if (!is_admin()) {
		echo '<html><body><a href="auth.php">Authenticate</a></body></html>';
		die;
	}
}

function create_party(string $new_party_name, bool $rehearsal): int {
	$stmt = db()->prepare(
		'INSERT INTO parties (name, akey, rehearsal_invited)'
		.' VALUES (:name, :akey, :rehearsal)'
	);

	$stmt->bindParam(':name', $new_party_name);

	// This is a terrible way to generate a random string, but security
	// isn't a huge concern, just preventing stupid scraping.
	$akey = substr(md5(mt_rand()), 0, 4);
	$stmt->bindParam(':akey', $akey);

	$stmt->bindParam(':rehearsal', $rehearsal);

	$stmt->execute();

	return (int)db()->lastInsertId();
}

function add_guest(
	int $party_id,
	string $new_guest_name,
	bool $is_plus_one
): int {
	$stmt = db()->prepare(
		'INSERT INTO guests (name, party_id, is_plus_one)'
		.' VALUES (:name, :party_id, :is_plus_one)'
	);
	$stmt->bindParam(':name', $new_guest_name);
	$stmt->bindParam(':party_id', $party_id);
	$stmt->bindParam(':is_plus_one', $is_plus_one);
	$stmt->execute();
	return (int)db()->lastInsertId();
}
