<?
header("HTTP/1.0 200 OK");

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
	case '/task/add':
		$page = 'task_add.php';
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		$page = '404.php';
}

require_once($page);

?>