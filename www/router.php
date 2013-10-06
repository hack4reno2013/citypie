<?

$request_path = preg_replace(
	'/^([^\?]+).*$/', 
	'\\1', 
	$_SERVER['REQUEST_URI']
);

switch ($request_path) {
	case '/signup':
		$page = 'signup.php';
		break;
	case '/login':
		$page = 'login.php';
		break;
	default:
		$page = '404.php';
}

require_once($page);

?>