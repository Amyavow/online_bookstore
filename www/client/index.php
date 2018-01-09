<?php
  include '../include/db.php';
	session_start();
  if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
  }
  
	$pagetitle = "Home";
  $page = 'home';
	include '../include/functions.php';
	include '../include/clientheader.php';
 ?>
<div class="main">
    <div class="book-display">
      
      <?php $topSelling= viewProductByTopSelling($conf); echo $topSelling;

      $topsellingRow = getProductTopSelling($conf);
      $bookId = $topsellingRow['book_id'];

       

      $error = array();

      if (array_key_exists('cart', $_POST)) {
        if (empty($_POST['cart'])||$_POST['cart']< 1) {
          $error['cart'] ="Please pick an appropraite amount";
        }

        if (empty($error)) {
          $amount= $_POST['cart'];
          header("location:book_preview.php?amount=$amount&book_id=$bookId");
        }
      }



      ?>
     

        <form method="post" action="">
          <?php if (isset($error['cart'])) {
            echo '<div><span style="color: #ce2a60; background-color:#f4c999; position: relative; margin-top:16px margin-bottom: 24px;">*'.$error['cart'].'</span></div>';
          } ?>
          <label for="book-amout">Amount</label>
          <input type="number" class="book-amount text-field" name="cart">
          <input class="def-button add-to-cart" type="submit" name="" value="Add to cart">
        </form>
      </div>
    </div>

    <!-- Trending -->

    <div class="trending-books horizontal-book-list">
      <h3 class="header" style="text-align: center;">Trending</h3>
      <ul class="book-list">

      	<?php $trendingProduct = getProductByTrending($conf); echo $trendingProduct; ?>
      </ul>
    </div>



    <!-- Recently Viewed -->

    <div class="recently-viewed-books horizontal-book-list">
      <h3 class="header" style="text-align: center;">Recently Viewed</h3>
      <ul class="book-list">
        <div class="scroll-back"></div>
        <div class="scroll-front"></div>
        <?php $recentlyViewed = getProductByRecentlyViewed($conf); echo $recentlyViewed; ?>
        
      </ul>
    </div>
    
  </div>
 <?php include '../include/clientfooter.php';  ?>