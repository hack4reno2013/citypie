<?

$response = array();
$data = array();
$errors = array();

$m = new MongoClient();
$db = $m->citypie;
$users = $db->users;

if ( isset($_POST['user_id']) ) {
	try {
		$mongo_id = new MongoId($_POST['user_id']);
		$user = $users->findOne(array('_id' => $mongo_id));
		if ( is_null($user) ) {
			# not found
			$errors[] = 'Invalid user ID';
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

if ( isset($_POST['task_id']) ) {
	$tasks = $db->tasks;
	$filters = array();
	try {
		$mongo_id = new MongoId($_POST['task_id']);
		$task = $tasks->findOne(array('_id' => $mongo_id));
		if (! is_null($task) ) {
			$data['task_id'] = $_POST['task_id'];
			if ( isset($user['tasks']) ) {
				$tasks = $user['tasks'];
				if ( in_array($data['task_id'], $tasks) ) {
					$errors[] = 'Task already added';
				}
			}
			else {
				$tasks = array();
			}
		}
	}
	catch (MongoException $e) {
		$status_code = 403;
		$response['status'] = 'error';
		$response['errors'] = 'Invalid task ID (2)';
	}
}
else {
	$errors[] = 'No task ID specified';
}

if ( count($errors) == 0 ) {

	try {
		$filters['_id'] = new MongoId($_POST['user_id']);
		$users->update(
			$filters, 
			array('$push' => array('tasks' => $_POST['task_id']))
		);
		$status_code = 200;
		$response['status'] = 'ok';
	}
	catch (MongoException $e) {
		$status_code = 500;
		$response['status'] = 'error';
		$response['errors'] = 'Failed to add task. ';
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
?>
