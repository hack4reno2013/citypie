<?

$response = array();
$data = array();
$errors = array();

$m = new MongoClient();
$db = $m->citypie;
$users = $db->users;

if ( isset($_POST['email']) ) {
	$email = $_POST['email'];
	try {
		$user = $users->findOne(array('email' => $email));
		if (! is_null($user) ) {
			if ( isset($_POST['password']) ) {
				if ( $_POST['password'] == $user['password']) {
					setcookie('user_id', $user['_id'], 3600*24*365);
					$status_code = 200;
					$response['status'] = 'ok';
				}
				else {
					$response['errors'][] = 'Invalid Password';
					$response['status'] = 'error';
				}
			}
			else {
				$response['errors'][] = 'No password specified';
				$response['status'] = 'error';
			}
		}
		else {
			# not found
			$response['errors'][] = 'Invalid user ID';
			$response['status'] = 'error';
		}
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('User not found');
	}
}
else {
	$errors[] = 'No user ID specified';
}

RestUtils::sendResponse(
	$status_code, 
	json_encode($response), 
	$format
);

exit;
?>
