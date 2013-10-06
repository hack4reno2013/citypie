<?
# valid tag types 
$types = array('task', 'quest');

$response = array();

$m = new MongoClient();
$db = $m->citypie;
$tags = $db->tags;

if (isset($query_parts[1])) {
	$tag_id = $query_parts[1];
	try {
		$mongo_id = new MongoId($tag_id);
		$tag = $tags->findOne(array('_id' => $mongo_id));
		if (! is_null($tag) ) {
			# a specific tag
			$status_code = 200;
			$response['status'] = 'ok';
			$response['data'] = array(
				'id' => (string) $tag['_id'], 
				'type' => $tag['created']->sec, 
				'object' => $tag['id'], 
				'name' => $tag['name'], 
				'count' => $tag['count']
			);
		}
		else {
			$status_code = 404;
			$response['status'] = 'error';
			$response['errors'] = array('Tag not found');
		}
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('Tag not found');
	}
}
else {
	try {
		$filters = array();
		# search by tag object type 
		if ( isset($_GET['type']) ) {
			if ( in_array($_GET['type'], $types) ) {
				$filters['type'] = $_GET['type'];
			}
			else {
				$status_code = 404;
				$response['status'] = 'error';
				$response['errors'] = array('Invalid tag type');
			}
		}
		
		# search by tag object id 
		if ( isset($_GET['object']) ) {
			$mongo_id = new MongoId($_GET['object']);
			$filters['id'] = $mongo_id;
		}
		
		$tag_list = $tags->find($filters);
		$tag_list->sort(array('count' => -1));
		$status_code = 200;
		$response['status'] = 'ok';
		$response['count'] = count($tag_list);
		$response['offset'] = 0;
		$response['total'] = count($tag_list);
		foreach ($tag_list as $tag) {
			$response['data'][] = array(
				'id'     => (string) $tag['_id'], 
				'type'   => $tag['type'], 
				'object' => (string) $tag['id'], 
				'name'   => $tag['name'], 
				'count'  => $tag['count'], 
			);
		}
		
	}
	catch (MongoException $e) {
		$status_code = 404;
		$response['status'] = 'error';
		$response['errors'] = array('Tag not found');
	}
}

RestUtils::sendResponse(
	$status_code, 
	json_encode($response), 
	$format
);
exit;

?>
