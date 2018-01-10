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

?>


<div class="main">
    <div class="checkout-form">
      <form class="def-modal-form">
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
        <input type="text"  class="text-field phone" placeholder="Phone Number">
        <input type="text" name="addy" class="text-field address" placeholder="Address">
        <input type="text" name="code" class="text-field post-code" placeholder="Post Code">
        <input type="submit" name="chkt" class="def-button checkout" value="Checkout">
      </form>
    </div>
</div>

<?php include '../include/clientfooter.php'; ?>