<?hh // decl

class Twig_Loader_Filesystem {
	public function __construct(string $base);
}

class Twig_Environment {
	public function __construct(
		Twig_Loader_Filesystem $loader,
		array<string, mixed> $options
	);

	public function render(
		string $tmpl,
		array<string, mixed> $data
	): string;
}
