<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="style/styles.css">
    <title><?php echo $pagetitle?> </title>
</head>
<body id="<?php echo $page ?>">
  <!-- DO NOT TAMPER WITH CLASS NAMES! -->

  <!-- top bar starts here -->
  <div class="top-bar">
    <div class="top-nav">
      <a href="index.html"><h3 class="brand"><span>T</span>ech<span>K</span>now</h3></a>
      <ul class="top-nav-list">
        <li class="top-nav-listItem Home"><a href="index.php">Home</a></li>
        <li class="top-nav-listItem catalogue"><a href="catalogue.php">Catalogue</a></li>
        <li class="top-nav-listItem login"><a href="login.php">Log In</a></li>
        <li class="top-nav-listItem register"><a href="registration.php">Register</a></li>
        <li class="top-nav-listItem login"><a href="client_logout.php">Log Out</a></li>
        <li class="top-nav-listItem cart">
          <div class="cart-item-indicator">
            <p><?php if (isset($_SESSION['user_id'])) {
              $cartAmount = cartAmount($conf, $_SESSION['user_id']);
              echo $cartAmount;
            }else{
              $cartAmount = 0;
              echo $cartAmount;
            }  

            ?></p>
          </div>
          <a href="cart.php">Cart</a>
        </li>
      </ul>
      <form class="search-brainfood">
        <input type="text" class="text-field" placeholder="Search all books">
      </form>
    </div>
  </div>
