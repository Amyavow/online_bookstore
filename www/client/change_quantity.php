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
    $num = range(1, 50);

    $error = array();
        if (array_key_exists('update_qty', $_POST)) {
          if (empty($_POST['amount'])||$_POST['amount']<1) {
            $error[] = "Choose a quantity";
          }

          if (empty($error)) {
            $cart = fetchCartbById($conf, $bookId);
            $cart_id = $cart[0];
            $price = $cart['price'];

            echo '$'.$price;

            /*updateCart($conf, $_POST['amount'], $price, $cart_id);*/

            
          }/*else{
            foreach ($error as $err) {
              echo '<p class="global-error">'.$err.'</p>';
            }
          }*/
        }


?>

<div class="main">
    <div class="registration-form">
      <form class="def-modal-form" method="post" action="">
        <label for="registration-from" class="header"><h3>Update quantity</h3></label>
        <input type="number" class="text-field first-name" name="amount">
        <input type="submit" class="def-button" name="update_qty" value="Update">
      </form>
    </div>
  </div>

			



<?php include '../include/clientfooter.php';  ?>