<?php
 session_start();
 if (isset($_SESSION['user_id'])) {
   $userId = $_SESSION['user_id'];
 }
  
	$pagetitle = "Catalogue";
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/clientheader.php';

?>

<!-- side bar starts here -->
  <div class="side-bar">
    <div class="categories">
      <h3 class="header">Categories</h3>
      <ul class="category-list">
        <?php $category_list = getCategoryList($conf); echo $category_list;  ?>
      </ul>
    </div>
  </div>
  <!-- main content starts here -->
  <div class="main">
    <div class="main-book-list horizontal-book-list">
      <ul class="book-list">
        <?php $view_allproducts = viewProductList($conf); echo $view_allproducts;  ?>
      </ul>

      <div class="actions">
        <button class="def-button previous">Previous</button>
        <button class="def-button next">Next</button>
      </div>
    </div>
    <div class="recently-viewed-books horizontal-book-list">
      <h3 class="header" style="text-align: center;">Recently Viewed</h3>
      <ul class="book-list">
        <div class="scroll-back"></div>
        <div class="scroll-front"></div>
       <?php $recentlyViewed= getProductByRecentlyViewed($conf); echo $recentlyViewed;  ?>

       
      </ul>
    </div>
    
  </div>

<?php
include '../include/clientfooter.php';
?>