<?php
	$pagetitle ="Edit Category";
	session_start();
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/dashboard_header.php';
	
	checkLogin();

	
	$error = array();
	if (isset($_GET['cat_id'])) {
		$catId = $_GET['cat_id'];
	}


	$data = getCategoryById($conf, $catId);


	if (array_key_exists('edit', $_POST)) {
		if (empty($_POST['cat_name'])) {
			$error['cat_name'] = "Please input the category name";
		}

		if (empty($error)) {

			$clean = array_map('trim', $_POST);
			$clean['cat_id'] = $catId;

			editCategory($conf,$clean);

			
			
		}
	}


?>

	<div class="wrapper">
		<div id="stream">

			<form id="register"  action ="" method ="POST">
			<div>
				<?php $errorinfo = displayErrors($error, 'cat_name'); echo $errorinfo;  ?>
				<label>Edit Category:</label>
				<input type="text" name="cat_name" placeholder="category name" value="<?php echo $data[1];?>">
			</div>
			

			<input type="submit" name="edit" value="edit">
		</form>
			
		</div>
	</div>
	<?php include '../include/footer.php'; ?>

	
