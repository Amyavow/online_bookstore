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

    $error = array();

     if (array_key_exists('remove', $_POST)) {
     	if (empty($_POST['bookTitle'])) {
     		$error['bookTitle'] = "Please put in a title";
     	}
     }

?>

	<div class="main">
    <div class="registration-form">
      <form class="def-modal-form">
        <label for="registration-from" class="header"><h3>Remove from cart</h3></label>
        <?php $errorInfo = displayErrorsClient($error, 'bookTitle'); echo $errorInfo;  ?>
        <input type="text" class="text-field first-name" name="bookTitle" value="<?php $product = getProductById($conf, $bookId); echo $product['title'];?>">
        <input type="submit" class="def-button" name="remove" value="Remove">
      </form>
    </div>
  </div>




<?php include '../include/clientfooter.php';  ?>