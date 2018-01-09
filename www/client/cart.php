  <?php
    session_start();
    include '../include/db.php';
    include '../include/functions.php';
    $userId = $_SESSION['user_id'];
    checkUserLogin($conf, $userId);
   
    $pagetitle = "View Cart";
    $page = 'cart';
    
    
    include '../include/clientheader.php';

  ?>
  <!-- main content starts here -->
  <div class="main">
    <table class="cart-table">
      <thead>
        <tr>
          <th><h3>Item</h3></th>
          <th><h3>Price</h3></th>
          <th><h3>Quantity</h3></th>
          <th><h3>Total</h3></th>
          <th><h3>Update</h3></th>
          <th><h3>Remove</h3></th>
        </tr>
      </thead>
      <tbody>
        <?php

        
        $viewCart= viewCart($conf, $userId);
        echo $viewCart;

         ?>
      </tbody>
    </table>
    <div class="cart-table-actions">
      <button class="def-button previous">previous</button>
      <button class="def-button next">next</button>
      <div class="index">
        <a href="#"><p>1</p></a>
        <a href="#"><p>2</p></a>
        <a href="#"><p>3</p></a>
      </div>
      <a href="checkout.html"><button class="def-button checkout">Checkout</button></a>
    </div>
    
  </div>
  <!-- footer starts here -->
  <?php include '../include/clientfooter.php';  ?>




 