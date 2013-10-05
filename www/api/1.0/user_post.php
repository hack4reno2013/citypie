<?

$response = array();
$data = array();

$m = new MongoClient();
$db = $m->citypie;
$users = $db->users;

if ( isset($_POST['email']) ) {
	if ( IsValidEmail($_POST['email']) ) {
		$data['email'] = $_POST['email'];
	}
	else {
		$errors[] = 'The email address does not appear to be valid';
	}
}
else {
	$errors[] = 'Please enter an email adress';
}

if ( isset($_POST['name']) ) {
	$data['name'] = $_POST['name'];
}
else {
	$errors[] = 'Please enter your name';
}


if (isset($query_parts[1])) {
	$user_id = $query_parts[1];
	try {
		$mongo_id = new MongoId($user_id);
		$user = $users->findOne(array('_id' => $mongo_id));
		if (! is_null($user) ) {
			# a specific user
			$status_code = 200;
			$response['status'] = 'ok';
			$response['data'] = array(
				'id' => (string) $user['_id'], 
				'created' => $user['created']->sec, 
				'name' => $user['name'], 
				'pic' => $user['pic'], 
				'cities' => $user['cities'], 
				'checks' => $user['checks'], 
				'bookmarks' => $user['bookmarks'], 
				'badges' => $user['badges']
			);
		}
		else {
			$status_code = 404;
			$response['status'] = 'error';
			$response['errors'] = array('User not found');
		}
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('User not found');
	}
}
else {
	try {
		$user_list = $users->find();
		$status_code = 200;
		$response['status'] = 'ok';
		$response['count'] = count($user_list);
		$response['offset'] = 0;
		$response['total'] = count($user_list);
		foreach ($user_list as $user) {
			$response['data'][] = (string) $user['_id'];
		}
		
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('User not found');
	}
}

RestUtils::sendResponse(
	$status_code, 
	json_encode($response), 
	$format
);
exit;

function IsValidEmail ($address) {
	return ( preg_match( 
		'/^[-!#$%&\'*+\\.\\/0-9=?A-Z^_`a-z{|}~]+' 
		. '@' 
		. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' 
		. '[-!#$%&\'*+\\.\\/0-9=?A-Z^_`a-z{|}~]+$/', $address ));
}

?>
