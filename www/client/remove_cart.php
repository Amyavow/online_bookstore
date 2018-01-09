<?php
	session_start();
    include '../include/db.php';
    include '../include/functions.php';
    $userId = $_SESSION['user_id'];
    checkUserLogin($conf, $userId);
   
    $pagetitle = "Remove from cart";
    $page = 'cart';
    
    
    include '../include/clientheader.php';

    if (isset($_GET['book_id'])) {
    	$bookId = $_GET['book_id'];
    }

    $product = getProductById($conf, $bookId);



    $error = array();

     if (array_key_exists('remove', $_POST)) {
     	if (empty($_POST['bookTitle'])) {
     		$error['bookTitle'] = "Please put in a title";
     	}

     	if (empty($error)) {
     		removeFromCart($conf, $bookId);
     		header("location:cart.php");
     	}
     }

?>

	<div class="main">
    <div class="registration-form">
      <form class="def-modal-form" method="post" action="">
        <label for="registration-from" class="header"><h3>Remove from cart</h3></label>
        <?php $errorInfo = displayErrorsClient($error, 'bookTitle'); echo $errorInfo;  ?>
        <input type="text" class="text-field first-name" name="bookTitle" value="<?php echo $product['title'];?>" readonly>
        <input type="submit" class="def-button" name="remove" value="Remove">
      </form>
    </div>
  </div>




<?php include '../include/clientfooter.php';  ?>