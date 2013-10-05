<?

$response = array();

$m = new MongoClient();
$db = $m->citypie;
$categories = $db->categories;

if (isset($query_parts[1])) {
	$cat_id = $query_parts[1];
	try {
		$mongo_id = new MongoId($cat_id);
		$cat = $categories->findOne(array('_id' => $mongo_id));
		if (! is_null($cat) ) {
			# a specific category
			$status_code = 200;
			$response['status'] = 'ok';
			$response['data'] = array(
				'name' => $cat['name'], 
				'description' => $cat['description'], 
			);
		}
		else {
			$status_code = 404;
			$response['status'] = 'error';
			$response['errors'] = array('Category not found');
		}
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('Category not found');
	}
}
else {
	try {
		$cat_list = $categories->find();
		$status_code = 200;
		$response['status'] = 'ok';
		$response['count'] = count($cat_list);
		$response['offset'] = 0;
		$response['total'] = count($cat_list);
		foreach ($cat_list as $cat) {
			$response['data'][] = array(
				'name' => $cat['name'], 
				'description' => $cat['description'], 
			);
		}
		
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('Category not found');
	}
}

RestUtils::sendResponse(
	$status_code, 
	json_encode($response), 
	$format
);
exit;

?>
