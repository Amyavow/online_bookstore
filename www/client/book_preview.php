<?php
  include '../include/db.php';
	session_start();
  if (isset($_SESSION['client_name'])) {
    $name = $_SESSION['client_name'];
  }

  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userinit = substr($username, 0, 2);
  }

  if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
  }
  if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
  }
	
	
	$pagetitle = "Book Preview";
	$page = 'bookpreview';
	include '../include/functions.php';
	include '../include/clientheader.php';
 ?>
 
 	<div class="main">
  
    
    <div class="book-display">
      <?php 

      if (isset($_GET['book_id'])) {
      	$bookId = $_GET['book_id'];
      }

      

      $display=bookPreviewDisplay($conf, $bookId); echo $display; 

      $error = array();

      if (array_key_exists('amount', $_POST)) {
      	if (empty($_POST['amount'])||$_POST['amount']<1) {
      		$error['amount'] = "You have not chosen any amount !";
      	}

        if (!isset($userId)) {
          $error['amount'] ="You have to be logged in first";
        }

      	

      	if (empty($error)) {
      		echo '<p class="global-error">successfully to cart</p>';

          $_SESSION['bookId'] = $bookId;

          $product = getProductById($conf, $bookId);

          insertToCart($conf, $bookId, $userId, $_POST['amount'], $product);

      	}
      	
      }

       ?>


      <form method="post" action="">
      	<?php if (isset($error['amount'])) {
      		echo '<p class="global-error">'.$error['amount'].'</p>';
      	}  ?>
          <label for="book-amout">Amount</label>
          <input type="number" class="book-amount text-field" name="amount" value="<?php if (isset($_GET['amount'])) {
        $topSellingAmount = $_GET['amount']; }; echo $topSellingAmount ?>">
          <input class="def-button add-to-cart" type="submit"  value="Add to cart">
        </form>
      </div>
    </div>

    <!-- Validation for the comment section -->
    <?php
      $errors = array();
      if (array_key_exists('add-comment', $_POST)) {


        if (empty($_POST['comment'])) {
          $errors['comment'] = "Please add a comment!";
        }
        if (!isset($username)) {
          $errors['comment'] = "You have to be logged in to be able to comment";
        }

        if (empty($errors)) {
          
          insertComment($conf, $username, $bookId, $_POST['comment']);
          
        }
      }


       ?>


    <div class="book-reviews">
      <h3 class="header">Reviews</h3>
      <ul class="review-list">
        
            <?php  
            $viewCommentById= viewCommentById($conf, $bookId);
            echo $viewCommentById;

            ?>
            
      </ul>

      
      <div class="add-comment">
        <h3 class="header">Add your comment</h3>
        <form class="comment" method="post" action="">
          <?php if (isset($errors['comment'])) {
            echo '<p class="global-error">'.$errors['comment'].'</p>';
          }  ?>
          
          <textarea class="text-field" name="comment"></textarea>
          <button class="def-button post-comment" name="add-comment">Upload comment</button>
        </form>
      </div>
    </div>
  </div>

 
 <?php include '../include/clientfooter.php';  ?>