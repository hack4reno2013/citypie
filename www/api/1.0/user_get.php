<?

$response = array();

$m = new MongoClient();
$db = $m->citypie;
$users = $db->users;

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
				'uid' => 1, 
				'created' => 1300000000, 
				'name' => 'Harold Paulson', 
				'pic' => '/files/users/1.png', 
				'cities' => 1, 
				'checks' => 42, 
				'bookmarks' => 19, 
				'badges' => array(
					'52506704877c1036e1d692af', 
					'52506704877c1036f1d692af', 
					'52506704877c1036g1d692af'
				)
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
	echo("This is a user list.");
}

RestUtils::sendResponse(
	$status_code, 
	json_encode($response), 
	$format
);
exit;

?>
