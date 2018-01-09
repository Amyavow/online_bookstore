<?php
	$pagetitle ="Edit Product Image";
	session_start();
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/dashboard_header.php';


	checkLogin();

	if (isset($_GET['img'])) {
		$bookId = $_GET['img'];
	}

	$bookRow = getProductById($conf, $bookId);

	define('MAX_FILE_SIZE', '2097152');

	$ext = array("image/png", "image/jpeg", "image/jpg");
		
	$error = array();

	if (array_key_exists('updateImage', $_POST)) {
		if (empty($_FILES['pics']['name'])) {
				$error['pics'] = "Please upload an image";
		}

		if ($_FILES['pics']['size'] > MAX_FILE_SIZE) {
				$error['pics'] = "File too large Maximum ".MAX_FILE_SIZE;
		}

		if (!in_array($_FILES['pics']['type'], $ext)) {
				$error['pics'] ="File format not supported";
		}

		if (empty($error)) {
			$pic = uploadFiles($_FILES,'pics','../uploads/');

				if ($pic[0]) {
					$location = $pic[1];
				}
				$clean = array_map('trim', $_POST);
				$clean['dest'] = $location;

				editImage($conf, $bookId, $clean);

			redirect("view_product.php","");
		}
	}

?>

	<div class="wrapper">
		<form id="register"  action ="" method ="POST" enctype="multipart/form-data">
			<div>
				<?php  $errorinfo = displayErrors($error, 'pics'); echo $errorinfo; ?>
				<label>Image:</label>	
				<input type="file" name="pics" value="<?php echo $bookRow['image_path']?>">
			</div>

			<input type="submit" name="updateImage" value="Update">
			
		</form>
	</div>


	<?php include '../include/footer.php'; ?>

