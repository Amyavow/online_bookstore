<?php
	$pagetitle ="Edit Product";
	session_start();
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/dashboard_header.php';
	checkLogin();

	if (isset($_GET['book_id'])) {
		$bookId = $_GET['book_id'];
	}


	$bookRow = getProductById($conf, $bookId);
	$category = getCategoryById($conf, $bookRow['category_id']);

	$error = array();
	$flag = array('Top Selling', 'Trending', 'Recently Viewed' );

	if (array_key_exists('edit', $_POST)) {
			

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

			if (empty($error)) {

				$clean = array_map('trim', $_POST);
				$clean['book_id'] = $bookId;

				editProduct($conf,$clean);

				redirect("view_product.php","");
				
				
			}
		}


?>


	<div class="wrapper">
	
		<form id="register"  action ="" method ="post">
			<div>
				<?php $errorinfo = displayErrors($error, 'title'); echo $errorinfo; ?>
				<label>Title:</label>
				<input type="text" name="title" value="<?php echo $bookRow['title'];?>">
			</div>


			<div>
				<?php $errorinfo = displayErrors($error, 'author'); echo $errorinfo;?>
				<label>Author:</label>	
				<input type="text" name="author" value="<?php echo $bookRow['author'];?>">
			</div>


			<div>
				<?php  $errorinfo = displayErrors($error, 'price'); echo $errorinfo; ?>
				<label>Price:</label>
				<input type="text" name="price" value="<?php echo $bookRow['price'];?>">
			</div>


			<div>
				<?php  $errorinfo = displayErrors($error, 'publication_date'); echo $errorinfo; ?>
				<label>Year:</label>
				<input type="text" name="publication_date" value="<?php echo $bookRow['publication_date'];?>">
			</div>
			
 
			<div>
				<?php  $errorinfo = displayErrors($error, 'catId'); echo $errorinfo; ?>
				<label>Category Id:</label>	
				<select name="catId">
					<option value="<?php echo $category[0];?>"><?php echo $category[1]; ?></option>
					<?php $data = getCategory($conf, $category[1]); echo $data;  ?>

					
				</select>
			</div>


			<div>
				<?php  $errorinfo = displayErrors($error, 'flag'); echo $errorinfo; ?>
				<label>Flag:</label>	
				<select name="flag">
					<option value="<?php echo $bookRow['flag']?>"><?php echo $bookRow['flag'];?></option>
					<?php foreach ($flag as $fl) {?>
					<option value="<?php echo $fl?>"><?php echo $fl; ?></option>

					<?php }  ?>
				</select>
			</div>



			<input type="submit" name="edit" value="Edit">
		</form>

		<h4 class="jumpto">To edit product image <a href='edit_image.php?img=<?php echo $bookId; ?>'>click here</a></h4>

		
	</div>

	<?php include '../include/footer.php'; ?>