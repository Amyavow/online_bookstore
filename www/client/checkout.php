<?php
	session_start();
    include '../include/db.php';
    $bookId = $_SESSION['bookId'];
    include '../include/functions.php';
    $userId = $_SESSION['user_id'];
    checkUserLogin($conf, $userId);
   
    $pagetitle = "Checkout";
    $page = 'checkout';
	include '../include/clientheader.php';

	

	$error = array();
			if (array_key_exists('chkt', $_POST)) {
				if (empty($_POST['phonenumber'])) {
					$error['phonenumber'] = "Please put in your phone number";
				}

				if (empty($_POST['addy'])) {
					$error['addy'] ="Please type in your address";
				}

				if (empty($_POST['code'])) {
					$error['code'] = "Please put in your postal code";
				}

				if (empty($error)) {
					$row= fetchTotalPrice($conf, $userId);
					$i = 0;
					while(array_key_exists($i,$row))
					{
					$totalsarray1[] = array_sum($row[$i]); 
					$i++;
					}

					$total1 =array_sum($totalsarray1); 
					$clean = array_map('trim', $_POST);
					$clean['total_price'] = $total1;
					$row= fetchTotalPrice($conf, $userId); 
		          	
					$msg = "Thank you for purchasing, your delivery will be ready in 5 days";
					insertToCheckout($conf, $userId, $clean['phonenumber'], $clean['addy'], $clean['code'], $clean['total_price']);
				}
			}

?>


<div class="main">
    <div class="checkout-form">
    	<?php if (isset($msg)) { echo '<p class= "global-error" style="text-align:center; font-weight:bold; font-size:30px;">'.$msg.'</p>' ;}  ?>

      <form class="def-modal-form" method="post" action="">
        <div class="total-cost">
          <h3><?php $row= fetchTotalPrice($conf, $userId); 
          	$i = 0;
			while(array_key_exists($i,$row))
			{
			$totalsarray[] = array_sum($row[$i]); 
			$i++;
			}

			$total =array_sum($totalsarray); 
			echo '<p style="text-align:center; font-weight:bold; font-size:30px;">$'.$total.'</p>';
          ?>
          	
          </h3>
          
        </div>
        <div class="cancel-icon close-form"></div>
        <label for="checkout-form" class="header"><h3>Checkout</h3></label>
        <?php $errorInfo =  displayErrorsCheckout($error, 'phonenumber'); echo $errorInfo; ?>
       
        <input type="text"  class="text-field phone" placeholder="Phone Number" name="phonenumber">

        <?php $errorInfo =  displayErrorsCheckout($error, 'addy'); echo $errorInfo; ?>
        <input type="text" name="addy" class="text-field address" placeholder="Address">

        <?php $errorInfo =  displayErrorsCheckout($error, 'code'); echo $errorInfo; ?>
        <input type="text" name="code" class="text-field post-code" placeholder="Post Code">
        <input type="submit" name="chkt" class="def-button checkout" value="Checkout">
      </form>
    </div>
</div>

<?php include '../include/clientfooter.php'; ?>