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

?>

<?php include '../include/clientfooter.php';  ?>