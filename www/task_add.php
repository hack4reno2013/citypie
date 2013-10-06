<?
$errors = array();
$notices = array();

$m = new MongoClient();
$db = $m->citypie;
$categories = $db->categories;

$cursor = $categories->find(array());
$cursor->sort(array('name' => 1));
$cat_list = array();
if (! is_null($cursor) ) {
	foreach ($cursor as $cat) {
		$id = (string) $cat['_id'];
		$cat_list[$id] = $cat['name'];
	}
}

if ( isset($_REQUEST['id']) ) {
	$action = 'Update';
	$id = $_REQUEST['id'];
	$mongo_id = new MongoID($id);
	$tasks = $db->tasks;
	$task = $tasks->findOne(array('_id' => $mongo_id));
	if (! is_null($task) ) {
		$category = $task['category'];
		$name = $task['name'];
		$description = $task['description'];
		if ( is_array($task['requirements']) ) {
			$requirement = key($task['requirements'][0]);
			if ( $requirement == 'geo' ) {
				$latlon = join(',', $task['requirements'][0]['geo']);
			}
		}
	}
	else {
		$errors[] = 'Unknown Task (' . $id . ')';
	}
}
else {
	$action = 'Add';
	$id = null;
	$category = null;
	$name = null;
	$description = null;
	$requirement = null;
	$latlon = 'Reno, NV';
}

# deal with apache hassles
$update = false;
if ( isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post' ) {
	$update = true;
}
elseif ( isset($_SERVER['REDIRECT_REQUEST_METHOD']) && strtolower($_SERVER['REDIRECT_REQUEST_METHOD']) == 'post' ) {
	$update = true;
}

if ( $update ) {

	if ( strlen($_POST['category']) > 0  ) {
		# FIXME: validate
		$category = $_POST['category'];
	}
	else {
		$errors[] = 'Please select a category';
	}

	if ( strlen($_POST['name']) > 0  ) {
		# FIXME: validate
		$name = $_POST['name'];
	}
	else {
		$errors[] = 'Please enter a name';
	}

	if ( strlen($_POST['description']) > 0  ) {
		# FIXME: validate
		$description = $_POST['description'];
	}
	else {
		$errors[] = 'Please describe this task';
	}

	if ( strlen($_POST['requirement']) > 0  ) {
		# FIXME: validate
		$requirement = $_POST['requirement'];
		
		if ($requirement == 'geo') {
			if ( strlen($_POST['latlon']) > 0 ) {
				$latlon = $_POST['latlon'];
				list($lat,$lon) = split(',', $_POST['latlon']);
			}
			else {
				$errors[] = 'Please set the requirement location';
			}
		}
		elseif ($requirement == 'scan') {
			$requirement = 'scan';
		}

	}
	else {
		$errors[] = 'Please select a requirement type';
	}
	
	if ( count($errors) == 0 ) {
		$data = array();
		$data['name'] = $name;
		$data['category'] = $category;
		$data['description'] = $description;
		if ($requirement == 'geo') {
			$data['requirements'][] = array(
				'geo' => array($lat, $lon)
			);
		}
		elseif ( $requirement == 'scan' ) {
			$data['requirements'][] = array('scan' => 1);
		}
		$data['created'] = new MongoDate();
		$tasks = $db->tasks;
		if ( isset($id) ) {
			$mongo_id = new MongoID($id);
			$tasks->update(array('_id' => $mongo_id), $data);
			$notices[] = "Task Updated";
		}
		else {
			$tasks->insert($data);
			$notices[] = "Task Added";
		}
		
		if ( $requirement == 'scan' ) {
			$redir = UrlEncode('http://' . $_SERVER['HTTP_HOST'] . '/qr?id=' .  $data['_id']);
			header("Location: http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=" . $redir . "&chld=H|0");
			exit;
		}

		# empty these out
		$id = null;
		$category = null;
		$name = null;
		$description = null;
		$requirement = null;
		$lat = null;
		$lon = null;
	}

}

?>
<!DOCTYPE html>
<head>
	<title> CityPie </title>
	<link rel = "stylesheet" type="text/css" href = "/css/reset.css">
	<link rel = "stylesheet" type="text/css" href = "/css/master.css">
	<link rel="icon" type="image/x-icon" href="favicon.png">
	<link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
	<script type='text/javascript' src='/js/jquery.locationpicker.js'></script>
	<style type="text/css">
		body {
			color: rgb(65,65,65);
		}
		
		#geo_block {
			display: none;
		}
		
	</style>
	<script  type="text/javascript">
	$(document).ready(function(){
		jQuery('#lat').locationPicker();
		
		if ( $('#requirement').val() == 'geo' ) {
			$('#geo_block').show();
		}
		$('#requirement').change(function(){
			if ( $(this).val() == 'geo' ) {
				$('#geo_block').show();
			}
			else {
				$('#geo_block').hide();
			}
		
		});
	});
	</script>
</head>
<body>
  <div id="wrapper">
<? IF ( count($errors) > 0 ): ?>
  	<div id="errors">
	<? FOREACH ($errors as $error): ?>
		<?= HtmlSpecialChars($error); ?><br>
	<? ENDFOREACH; ?>
  	</div>
<? ENDIF?>
<? IF ( count($notices) > 0 ): ?>
  	<div id="notices">
	<? FOREACH ($notices as $notice): ?>
		<?= HtmlSpecialChars($notice); ?><br>
	<? ENDFOREACH; ?>
  	</div>
<? ENDIF?>

	<h2><?= HtmlSpecialChars($action); ?> a Task</h2>

	<form action="/task_add.php" method="post" id="newuser" class="fform">
		<input type="hidden" name="id" id="id" value="<?= HtmlSpecialChars($id); ?>">
		
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="<?= HtmlSpecialChars($name); ?>">
		
		<label for="category">Category</label>
		<select name="category" id="category">
			<option value=""<?= ($category=='')?(' selected="selected"'):(''); ?>> - Choose a category - </option>		
<? FOREACH ($cat_list as $id => $name): ?>
			<option value="<?= HtmlSpecialChars($id); ?>"<?= ($category==$id)?(' selected="selected"'):(''); ?>><?= HtmlSpecialChars($name); ?></option>
<? ENDFOREACH; ?>		
		</select>
		
		<label for="description">Description</label>
		<textarea name="description" cols="60" rows="6" id="description"><?= HtmlSpecialChars($description); ?></textarea>
		
		<label for="requirement">Requirement</label>
		<select name="requirement" id="requirement">
			<option value=""<?= ($requirement=='')?(' selected="selected"'):(''); ?>> - Choose the task type - </option>
			<option value="geo"<?= ($requirement=='geo')?(' selected="selected"'):(''); ?>>Location</option>
			<option value="scan"<?= ($requirement=='scan')?(' selected="selected"'):(''); ?>>QR Code</option>
		</select>
		
		<div id="geo_block">
			<label for="lat">Location</label>
			<div class="note">(Click search to search map.  Double-click to set location)</div>
			<input type="text" name="latlon" id="lat" value="<?= HtmlSpecialChars($latlon); ?>">
		</div>


		<input type="submit" value="<?= HtmlSpecialChars($action); ?>">
		
	</form>
		
  </div>
</body>
</html>