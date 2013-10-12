<?
$errors = array();
$notices = array();

$m = new MongoClient();
$db = $m->citypie;
$users = $db->users;
$tasks = $db->tasks;

$name = 'Unknown';
if ( isset($_REQUEST['id']) ) {
	$id = $_REQUEST['id'];
	try {
		$mongo_id = new MongoID($id);

		$task = $tasks->findOne(array('_id' => $mongo_id));
		if (! is_null($task) ) {
			$name = $task['name'];
			$description = $task['description'];
			if ( is_array($task['requirements']) ) {
				$requirement = key($task['requirements'][0]);
				if ( $requirement != 'scan' ) {
					$errors[] = 'Not a QR Task';
				}
			}
			else {
				$errors[] = 'Not a QR Task';
			}
		}
		else {
			$errors[] = 'Task not found!';
		}
	}
	catch (MongoException $e) {
	$errors[] = 'Invalid Task ID';
	}
}
else {
	$errors[] = 'Task ID Missing?';
}

if ( isset($_COOKIE['user_id']) ) {
	$user_id = $_COOKIE['user_id'];
}
else {
	$errors[] = 'Please log in to check your task';
	$get_login = true;
}


$badge_earned = null;
if ( count($errors) == 0 ) {
	$badges = $db->badges;
	$badge_list = $badges->find(array('tasks' => $id));
	if (! is_null($badges) ) {
		foreach ($badge_list as $badge) {
			$mongo_id = new MongoID($user_id);
			$badge_id = (string) $badge['_id'];
			$users->update(
				array('_id' => $mongo_id), 
				array('$push' => array('badges' => $badge_id))
			);
			$badge_earned = $badge;
		}
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

	<h2><?= HtmlSpecialChars($name); ?> Task</h2>
	
	<p>
	<?= HtmlSpecialChars($description); ?>
	</p>

<? IF (! is_null($badge_earned) ): ?>
<h3>You have Earned the <?= HtmlSpecialChars($badge_earned['name']); ?> Badge!</h3>
<? ENDIF; ?>
		
<? IF ($get_login): ?>
	<form action="/qr.php" method="post" id="newuser" class="fform">
		<input type="hidden" name="id" id="id" value="<?= HtmlSpecialChars($id); ?>">
		
		<input type="submit" value="Complete">
		
	</form>
<? ENDIF; ?>
		
  </div>
</body>
</html>