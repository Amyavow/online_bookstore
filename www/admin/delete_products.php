<?php
	$pagetitle ="Delete Product";
	session_start();
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/dashboard_header.php';
	checkLogin();

	if (isset($_GET['book_id'])) {
		$bookId = $_GET['book_id'];
	}

	$bookRow = getProductById($conf, $bookId);

	$error = array();

	if (array_key_exists('delete', $_POST)) {
		if (empty($_POST['product_name'])) {
			$error['product_name'] ="Please put in product name";
		}

		if (empty($error)) {
			/*echo "deleted successfully";*/

			deleteProduct($conf,$bookId);
			redirect("view_product.php","");
		}
	}


?>

<div class="wrapper">
		<div id="stream">

			<form id="register"  action ="" method ="POST">
			<div>
				<?php $errorinfo = displayErrors($error, 'product_name'); echo $errorinfo;  ?>
				<label>Delete Product:</label>
				<input type="text" name="product_name" placeholder="title" value="<?php echo $bookRow['title'];?>" readonly>
			</div>
			

			<input type="submit" name="delete" value="Delete">
		</form>
			
		</div>
	</div>
	<?php include '../include/footer.php';  ?>