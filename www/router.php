<?

$request_path = preg_replace(
	'/^([^\?]+).*$/', 
	'\\1', 
	$_SERVER['REQUEST_URI']
);

switch ($request_path) {
	case '/about':
		$page = 'about.php';
		break;
	default:
		$page = '404.php';
}

require_once($page);

?>