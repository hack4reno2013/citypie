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

$category = null;
$name = null;
$description = null;
$requirement = null;
$latlon = 'Reno, NV';

if ( strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
	
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
		$tasks = $db->tasks;
		$tasks->insert($data);
		$notices[] = "Task Added";

		# empty these out
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
	<link rel = "stylesheet" type="text/css" href = "css/reset.css">
	<link rel = "stylesheet" type="text/css" href = "css/master.css">
	<link rel="icon" type="image/x-icon" href="favicon.png">
	<link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
	<script type='text/javascript' src='/js/jquery.locationpicker.js'></script>
	<style type="text/css">
		body {
			color: rgb(65,65,65);
		}
		
	</style>
	<script  type="text/javascript">
	$(document).ready(function(){
		jQuery('#lat').locationPicker();
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

	<h2>Add a Task</h2>

	<form method="post" id="newuser" class="fform">
		
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
		</select>
		
		<label for="lat">Location</label>
		<div class="note">(Click search to search map.  Double-click to set location)</div>
		<input type="text" name="latlon" id="lat" value="<?= HtmlSpecialChars($latlon); ?>">

		<input type="submit" value="Add">
		
	</form>
		
  </div>
</body>
</html>