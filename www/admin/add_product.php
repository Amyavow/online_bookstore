	<?php
		$pagetitle ="Add Product";

		session_start();
		include '../include/db.php';
		include '../include/functions.php';
		include '../include/dashboard_header.php';
		

		checkLogin();


		define('MAX_FILE_SIZE', '2097152');

		$ext = array("image/png", "image/jpeg", "image/jpg");
		


		$error = array();
		$flag = array('Top Selling', 'Trending', 'Recently Viewed' );
		if (array_key_exists('addProduct', $_POST)) {
			

			if (empty($_POST['title'])) {
				$error['title'] = "Please enter the book title";
			}

			if (empty($_POST['author'])) {
				$error['author'] = "Please enter the author name";
			}

			if (empty($_POST['price'])) {
				$error['price'] = "Please enter the price of the book here";
			}


			if (empty($_POST['publication_date'])) {
				$error['publication_date'] = "Please put in the year the book was published";
			}

			if (empty($_POST['catId'])) {
				$error['catId'] = "Please choose a book category";
			}

			if (empty($_POST['flag'])) {
				$error['flag'] = "Select a flag category";
			}

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

				addProduct($conf, $clean);
				
				redirect("view_product.php", "");
			}
		}



	?>
	
	<div class="wrapper">
		<h1 id="register-label">Add Product</h1>
		<hr>
		<form id="register"  action ="add_product.php" method ="POST" enctype="multipart/form-data">
			<div>
				<?php $errorinfo = displayErrors($error, 'title'); echo $errorinfo; ?>
				<label>Title:</label>
				<input type="text" name="title" placeholder="book title">
			</div>


			<div>
				<?php $errorinfo = displayErrors($error, 'author'); echo $errorinfo;?>
				<label>Author:</label>	
				<input type="text" name="author">
			</div>


			<div>
				<?php  $errorinfo = displayErrors($error, 'price'); echo $errorinfo; ?>
				<label>Price:</label>
				<input type="text" name="price" placeholder="price">
			</div>


			<div>
				<?php  $errorinfo = displayErrors($error, 'publication_date'); echo $errorinfo; ?>
				<label>Year:</label>
				<input type="text" name="publication_date" placeholder="Publication Date">
			</div>
			
 
			<div>
				<?php  $errorinfo = displayErrors($error, 'catId'); echo $errorinfo; ?>
				<label>Category Id:</label>	
				<select name="catId">
					<option value="">category</option>
					<?php $data = getCategory($conf); echo $data;  ?>

					
				</select>
			</div>

			<div>
				<?php  $errorinfo = displayErrors($error, 'flag'); echo $errorinfo; ?>
				<label>Flag:</label>	
				<select name="flag">
					<option value="">Flag</option>
					<?php foreach ($flag as $fl) {?>
					<option value="<?php echo $fl?>"><?php echo $fl; ?></option>

					<?php }  ?>
				</select>
			</div>


			<div>
				<?php  $errorinfo = displayErrors($error, 'pics'); echo $errorinfo; ?>
				<label>Image:</label>	
				<input type="file" name="pics">
			</div>



			<input type="submit" name="addProduct" value="Add">
		</form>

		
	</div>

	<?php include '../include/footer.php';?>