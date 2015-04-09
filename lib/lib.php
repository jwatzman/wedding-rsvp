<?hh

error_reporting(E_ALL);
ini_set('default_charset', 'utf-8');

function log_request(): void {
	$msg = $_SERVER['SCRIPT_NAME'];
	$msg .= ' '.$_SERVER['REMOTE_ADDR'].' ';
	$msg .= ' GET: ';
	foreach ($_GET as $k => $v) {
		$msg .= $k.'='.$v.' ';
	}
	$msg .= 'POST: ';
	foreach ($_POST as $k => $v) {
		$msg .= $k.'='.$v.' ';
	}
	error_log($msg);
}
log_request();

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/twig.php';

require_once __DIR__.'/idx.php';
require_once __DIR__.'/db_conf.php';
require_once __DIR__.'/db.php';
require_once __DIR__.'/admin.php';
