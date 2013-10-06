<?

$response = array();
$data = array();
$errors = array();

$m = new MongoClient();
$db = $m->citypie;
$users = $db->users;
$max_distance = 200; # meters

if ( isset($_POST['user_id']) ) {
	try {
		$mongo_id = new MongoId($_POST['user_id']);
		$user = $users->findOne(array('_id' => $mongo_id));
		$data['user_id'] = $_POST['user_id'];
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
				if (! in_array($data['task_id'], $tasks) ) {
					try {
						$filters['_id'] = new MongoId($_POST['user_id']);
						$users->update(
							$filters, 
							array('$set' => array('tasks' => $_POST['task_id']))
						);
					}
					catch (MongoException $e) {
						$status_code = 500;
						$response['status'] = 'error';
						$response['errors'] = 'Failed to add task. ';
					}
				}
				
				# FIXME: do more than one requirement
				$requirement = $task['requirements'][0];
				if ( isset($requirement['geo']) ) {
					# are we close
					$task_lat = $requirement['geo'][0];
					$task_lon = $requirement['geo'][1];
					if ( isset($_POST['lat']) && isset($_POST['lon']) ) {
						$dist = (int) distance(
							$task_lat, 
							$task_lon, 
							$_POST['lat'], 
							$_POST['lon']
						);
						if ( abs($dist) > $max_distance) {
							$errors[] = "You must be within $max_distance of the task's location";
							$errors[] = "Currently $dist meters off";
						}
					}
					else {
						$status_code = 403;
						$response['status'] = 'error';
						$response['errors'] = 'Task requires position info to confirm';
					}
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
		$response['errors'] = 'Invalid task ID';
	}
}
else {
	$errors[] = 'No task ID specified';
}

if ( count($errors) == 0 ) {
	try {
		$data['created'] = new MongoDate();
		$checks = $db->checks;
		$checks->insert($data);
		$status_code = 200;
		
		# did we earn a badge
		$badges = $db->badges;
		$badge_list = $badges->find(array('tasks' => $_POST['task_id']));
		if (! is_null($badges) ) {
			foreach ($badge_list as $badge) {
				$mongo_id = new MongoID($data['user_id']);
				$badge_id = (string) $badge['_id'];
				$users->update(
					array('_id' => $mongo_id), 
					array('$push' => array('badges' => $badge_id))
				);
				$response['data']['badge'] = $badge_id;
			}
		}
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

# http://chrishacia.com/2012/03/php-calculate-distance-between-2-longitude-latitude-points/
function distance($lat1, $lon1, $lat2, $lon2) { 
	$theta = $lon1 - $lon2; 
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
	$dist = acos($dist); 
	$dist = rad2deg($dist); 
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
 
	return ($miles * 1.609344); 
}    
?>
