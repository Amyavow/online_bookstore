<?php
	$pagetitle ="Add Category";
	session_start();
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/dashboard_header.php';
	include '../include/footer.php';
	
	checkLogin();

	$name = $_SESSION['name'];
	$admin_id = $_SESSION['admin_id'];

	$error = array();

	if (array_key_exists('add', $_POST)) {
		if (empty($_POST['cat_name'])) {
			$error['cat_name'] = "Please input the category name";
		}

		if (empty($error)) {

			$clean = array_map('trim', $_POST);

			addCategory($conf, $clean);
			
		}
	}


?>

	<div class="wrapper">
		<div id="stream">

			<form id="register"  action ="add_category.php" method ="POST">
			<div>
				<?php $errorinfo = displayErrors($error, 'cat_name'); echo $errorinfo;  ?>
				<label>Add Category:</label>
				<input type="text" name="cat_name" placeholder="category name">
			</div>
			

			<input type="submit" name="add" value="Add">
		</form>
			
		</div>
	</div>

	
