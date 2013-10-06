<?
http_response_code(200);

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
		http_response_code(404);
		$page = '404.php';
}

require_once($page);

?>