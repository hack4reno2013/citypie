<?

$response = array();
$data = array();

$m = new MongoClient();
$db = $m->citypie;
$users = $db->users;

if ( isset($_POST['email']) ) {
	if ( IsValidEmail($_POST['email']) ) {
		$data['email'] = $_POST['email'];
			$user = $users->findOne(array('email' => $data['email']));
			if (! is_null($user) ) {
				# a specific user
				$status_code = 409;
				$response['status'] = 'error';
				$response[errors] = 'A user already exists with that email address';
			}
			else {
				$status_code = 404;
				$response['status'] = 'error';
				$response['errors'] = array('User not found');
			}
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

if ( isset($_POST['password']) ) {
	$data['password'] = $_POST['password'];
}
else {
	$errors[] = 'Please enter a password';
}

if ( count($errors) == 0 ) {
	try {
		$users->insert($data);
		$status_code = 200;
		$response['status'] = 'ok';
		$response['data'] = $data;
	}
	catch (MongoException $e) {
		$status_code = 500;
		$response['status'] = 'error';
		$response[errors] = 'Account creation failed. ';
	}
}
else {
	$status_code = 500;
	$response['status'] = 'error';
	$response['errors'] = $errors;
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
