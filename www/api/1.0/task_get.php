<?

$response = array();

$m = new MongoClient();
$db = $m->citypie;
$tasks = $db->tasks;

if (isset($query_parts[1])) {
	$task_id = $query_parts[1];
	try {
		$mongo_id = new MongoId($task_id);
		$task = $tasks->findOne(array('_id' => $mongo_id));
		if (! is_null($task) ) {
			# a specific task
			$status_code = 200;
			$response['status'] = 'ok';
			$response['data'] = array(
				'id' => (string) $task['_id'], 
				'name' => $task['name'], 
				'category' => $task['category'], 
				'requirements' => $task['requiremnets']
			);
		}
		else {
			$status_code = 404;
			$response['status'] = 'error';
			$response['errors'] = array('Task not found');
		}
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('Task not found');
	}
}
else {
	try {
		$task_list = $tasks->find();
		$status_code = 200;
		$response['status'] = 'ok';
		$response['count'] = count($task_list);
		$response['offset'] = 0;
		$response['total'] = count($task_list);
		foreach ($task_list as $task) {
			$response['data'][] = array(
				'id' => (string) $task['_id'], 
				'name' => $task['name'], 
				'category' => $task['category'], 
				'requirements' => $task['requirements']
			);
		}
		
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('Tasks not found');
	}
}

RestUtils::sendResponse(
	$status_code, 
	json_encode($response), 
	$format
);
exit;

?>
