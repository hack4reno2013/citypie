<?

$response = array();

$m = new MongoClient();
$db = $m->citypie;
$badges = $db->badges;

if (isset($query_parts[1])) {
	$badge_id = $query_parts[1];
	try {
		$mongo_id = new MongoId($badge_id);
		$badge = $badges->findOne(array('_id' => $mongo_id));
		if (! is_null($badge) ) {
			# a specific badge
			$status_code = 200;
			$response['status'] = 'ok';
			$response['data'] = array(
				'id' => (string) $badge['_id'], 
				'name' => $badge['name'], 
				'description' => $badge['description'], 
				'tasks' => $badge['tasks']
			);
		}
		else {
			$status_code = 404;
			$response['status'] = 'error';
			$response['errors'] = array('Badge not found');
		}
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('Badge not found');
	}
}
else {
	try {
		$badge_list = $badges->find();
		$status_code = 200;
		$response['status'] = 'ok';
		$response['count'] = count($badge_list);
		$response['offset'] = 0;
		$response['total'] = count($badge_list);
		foreach ($badge_list as $badge) {
			$response['data'][] = array(
				'id' => (string) $badge['_id'], 
				'name' => $badge['name'], 
				'description' => $badge['description'], 
				'tasks' => $badge['tasks']
			);
		}
		
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('Badge not found');
	}
}

RestUtils::sendResponse(
	$status_code, 
	json_encode($response), 
	$format
);
exit;

?>
