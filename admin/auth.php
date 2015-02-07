<?hh

require_once '../lib/lib.php';

function main__admin_auth(): void {
	$authenticated = is_admin();

	$password = idx($_POST, 'password');
	if ($password === ADMIN_PASS) {
		setcookie('admin', $password);
		$authenticated = true;
	}

	echo t()->render(
		'admin/auth.html',
		array('authenticated' => $authenticated)
	);
}

main__admin_auth();
