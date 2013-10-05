<?
require_once('../../lib/rest.php');

$dispatcher = array(
	# request    class
	'users'      => 'user', 
	'checks'     => 'check', 
	'badges'     => 'badge', 
	'categories' => 'category', 
	'tags'       => 'tag', 
	'tasks'      => 'task'
);

$errors = array();

$request = RestUtils::processRequest();
$data = $request->getData();
$format = 'application/json'; # 'text/plain'

# figure what they are asking for
$api_base = '/api/1.0/';
$query = substr($_SERVER['REQUEST_URI'], strlen($api_base));

# remove any query string
if ( $pos = strpos($query, '?') ) {
	$query = substr($query, 0, $pos);
}

# remove any trailing slash
if ( substr($query, -1) == '/') {
	$query = substr($query, 0, -1);
}
$query_parts = explode('/', $query);
$noun = $query_parts[0];


if ( isset($dispatcher[$noun]) ) {
	$model_name = $dispatcher[$noun];
}
else {
	RestUtils::sendResponse(
		400, 
		json_encode(array(
			'status' => 'error', 
			'errors' => 'unknown model', 
			'models' => array_keys($dispatcher)
		)), 
		$format
	);
	exit;
}

switch($request->getMethod()) {
	case 'get':
		if ( file_exists($model_name . "_get.php") ) {
			require_once($model_name . "_get.php");
		}
		else {
			# dunno what you want
			RestUtils::sendResponse(
				501, 
				json_encode(array('status' => 'error', 'errors' => array('Not Implemented'))), 
				$format
			);
		}

		break;

	# create new record
	case 'post':
		if ( file_exists($model_name . "_post.php") ) {
			require_once($model_name . "_post.php");
		}
		else {
			# dunno what you want
			RestUtils::sendResponse(
				501, 
				json_encode(array('status' => 'error', 'errors' => array('Not Implemented'))), 
				$format
			);
		}
		break;

	# update existing record
	case 'put':
		# PUT vars to POST vars
		$_POST = $request->getRequestVars();

		if ( file_exists($noun . "_put.php") ) {
			require_once($noun . "_put.php");
		}
		else {
			# dunno what you want
			RestUtils::sendResponse(
				501, 
				json_encode(array('status' => 'error', 'errors' => array('Not Implemented'))), 
				$format
			);
		}
		break;

	# delete existing record
	case 'delete':
		RestUtils::sendResponse(
			501, 
			json_encode(array('status' => 'error', 'errors' => array('Delete not supported'))), 
			$format
		);


	default :
		RestUtils::sendResponse(
			501, 
			json_encode(array('status' => 'error', 'errors' => array('Unsupported Request Method'))), 
			$format
		);
}

?>