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
