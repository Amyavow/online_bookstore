<?php
	$pagetitle ="Delete Category";
	session_start();
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/dashboard_header.php';
	
	
	checkLogin();

	

	if (isset($_GET['cat_id'])) {
		$catId = $_GET['cat_id'];
	}

	$data = getCategoryById($conf, $catId);

	$error = array();



	if (array_key_exists('delete', $_POST)) {
		if (empty($_POST['cat_name'])) {
			$error['cat_name'] = "Please enter a category name";

		}

		if (empty($error)) {
			$clean = array_map('trim', $_POST);
			$clean['cat_id'] = $catId;

			deleteCategory($conf, $clean);


		}
		
	}



?>

<div class="wrapper">
		<div id="stream">

			<form id="register"  action ="" method ="POST">
			<div>
				<?php $errorinfo = displayErrors($error, 'cat_name'); echo $errorinfo;  ?>
				<label>Delete Category:</label>
				<input type="text" name="cat_name" placeholder="category name" value="<?php echo $data['category_name'];?>">
			</div>
			

			<input type="submit" name="delete" value="Delete">
		</form>
			
		</div>
	</div>
	<?php include '../include/footer.php';  ?>