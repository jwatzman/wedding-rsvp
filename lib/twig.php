<?hh

function t(): Twig_Environment {
	static $twig = null;
	if (!$twig) {
		$twig = new Twig_Environment(
			new Twig_Loader_Filesystem(__DIR__.'/../templates'),
			array(
				'auto_reload' => true,
				'autoescape' => true,
				'cache' => '/tmp/rsvp-twig-cache',
				'charset' => 'UTF-8',
				'strict_variables' => true,
			)
		);
	}

	return $twig;
}
