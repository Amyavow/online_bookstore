<?php
	function uploadFiles($files, $name, $loc)
	{
		$result = [];

		$rnd = rand(0000000000, 9999999999);
		$strip_name = str_replace(' ', '_', $files[$name]['name']);

		$filename = $rnd. $strip_name;
		$destination = $loc.$filename;


		
		if (move_uploaded_file($files[$name]['tmp_name'], $destination)) {

			
			$result[] = true;
			$result[] = $destination;

		}else{
			$result[] = false;
		}

		return $result;
	}




	function displayErrors($err, $key)
	{
		$result = "";
		if (isset($err[$key])) {
			$result = '<span class = "err">'. $err[$key].'</span>';
		}
		return $result;
	}

	function displayErrorsClient($err, $key)
	{
		$result = "";
		if (isset($err[$key])) {
			$result = '<span class = "form-error">'. $err[$key].'</span>';
		}
		return $result;
	}



	function adminRegister($dbconn, $input)
	{
		$hash = password_hash($input['password'], PASSWORD_BCRYPT);
		
		$stmt = $dbconn->prepare("INSERT INTO `admin` (`firstname`, `lastname`, `email`, `hash`) VALUES(:f, :l, :e, :h)");

		$data = [
			":f" => $input['fname'],
			":l"=> $input['lname'],
			":e"=> $input['email'],
			":h"=> $hash
		];
		$stmt->execute($data);
	}


	function clientRegister($dbconn, $input)
	{
		$hash = password_hash($input['password'], PASSWORD_BCRYPT);

		$stmt = $dbconn->prepare("INSERT INTO `users`(`firstname`,`lastname`,`email`,`username`,`password`) VALUES(:f, :l, :e, :u, :p)");

		$data = array(
		':f' =>$input['firstname'],
		':l' =>$input['lastname'],
		':e' =>$input['email'], 
		':u' =>$input['username'],
		':p' =>$hash);

		$stmt->execute($data);
	}



	function doesEmailExist($dbconn, $email)
	{
		$result = false;
		$stmt = $dbconn->prepare("SELECT `email` FROM `admin` WHERE `email`=:e");

		$stmt->bindParam(":e", $email);
		$stmt->execute();

		$count = $stmt->rowCount();


		if ($count > 0) {
			$result = true;
		}
		return $result;
	}

	function doesEmailExistClient($dbconn, $email)
	{
		$result = false;
		$stmt = $dbconn->prepare("SELECT `email` FROM `users` WHERE `email`=:e");

		$stmt->bindParam(":e", $email);
		$stmt->execute();

		$count = $stmt->rowCount();


		if ($count > 0) {
			$result = true;
		}
		return $result;
	}




	function adminLogin($dbconn, $input)
	{
		$result = [];

		$stmt = $dbconn->prepare("SELECT * FROM `admin` WHERE `email`=:e");

		$stmt->bindParam(":e", $input['email']);

		$stmt->execute();

		$count = $stmt->rowCount();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);



		//Testing echo $row['email']; exit();

		if ($count!==1||!password_verify($input['password'],$row['hash'])) {
			$result[] =false;
		}else{
			$result[]=true;
			$result[]=$row;
		}

		return $result;
	}

	function clientLogin($dbconn, $input)
	{
		$result =[];

		$stmt = $dbconn->prepare("SELECT * FROM `users` WHERE `email`= ?");
		$stmt->bindParam(1, $input['email']);
		$stmt->execute();

		$count =$stmt->rowCount();
		$row = $stmt->fetch(PDO::FETCH_BOTH);

		if ($count!==1||!password_verify($input['password'],$row['password'])) {
			$result[] = false;
		}else{
			$result[] = true;
			$result[] = $row;
		}

		return $result;

	}



	function redirect($loc, $msg)
	{
		header("location:".$loc.$msg);
	}


	function addCategory($dbconn, $input)
	{
		$stmt = $dbconn->prepare("INSERT INTO `category`(`category_name`) VALUES (:catName)");

		$stmt->bindParam(":catName", $input['cat_name']);
		$stmt->execute();
	}

	function checkLogin()
	{
		if (!isset($_SESSION['admin_id'])) {
			redirect("login.php", "");
		}
	}


	function viewCategory($dbconn)
	{
		$result = "";

		$stmt = $dbconn->prepare("SELECT * FROM `category`");

		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
			$result .= '<tr><td>'. $row[0].'<td>';
			$result .= '<td>'.$row[1].'<td>';
			$result .= '<td><a href="edit_category.php?cat_id='.$row[0].'">edit</a></td>';
			$result .= '<td><a href="delete_category.php?cat_id='.$row[0].'">delete</a></td></tr>';
		}

		return $result;
	}



	function getCategoryById($dbconn, $catId)
	{
		$stmt = $dbconn->prepare("SELECT * FROM `category` WHERE `category_id`=:cat_id");

		$stmt->bindParam(":cat_id", $catId);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_BOTH);
		return $row;

	}

	function editCategory($dbconn, $input)
	{
		$stmt = $dbconn->prepare("UPDATE `category` SET `category_name`=:cat_name WHERE `category_id`=:cat_id");

		$stmt->bindParam(":cat_id", $input['cat_id']);
		$stmt->bindParam(":cat_name", $input['cat_name']);

		$stmt->execute();

		redirect("view_category.php","");
	}

	function deleteCategory($dbconn, $input)
	{
		$stmt = $dbconn->prepare("DELETE FROM `category` WHERE `category_id`=?");
		$stmt->bindParam(1, $input['cat_id']);
		$stmt->execute();



		redirect("view_category.php", "");

	}



	function getCategory($dbconn, $val=null)
	{
		$result = "";

		$stmt = $dbconn->prepare("SELECT * FROM `category`");

		$stmt->execute();

		while ($row=$stmt->fetch(PDO::FETCH_BOTH)) {
			if ($val==$row[1]) {
				continue;
			}

			$result .= '<option value="'.$row[0].'">'.$row[1].'</option>';
		}

		return $result;

		
	}



	function getCategoryList($dbconn)
	{
		$result = "";

		$stmt = $dbconn->prepare("SELECT * FROM `category`");

		$stmt->execute();

		while ($row=$stmt->fetch(PDO::FETCH_BOTH)) {
			
			$result .= '<li class="category"><a href="view_catalogue.php?cat_id='.$row[0].'">'.$row[1].'</a></li>';
			
		}

		return $result;

		
	}





	function selectPage($page)
	{

		$scriptPage = basename($_SERVER['SCRIPT_FILENAME']);

		if ($page == $scriptPage) {
			echo 'class="selected"';
		}
	}


	function addProduct($dbconn, $input)
	{
		$stmt = $dbconn->prepare("INSERT INTO `books`(`title`, `author`,`price`, `publication_date`, `category_id`, `flag`, `image_path`) VALUES (:title, :author, :price, :publication_date, :category_id, :flag, :image_path)");

		$values = array(':title' =>$input['title'] , 
						':author' => $input['author'],
						':price' => $input['price'],
						':publication_date' => $input['publication_date'],
						':category_id' => $input['catId'],
						':flag'=> $input['flag'],
						':image_path' => $input['dest']);

		$stmt->execute($values);
	}

	function viewProducts($dbconn)
	{
		$result ="";

		$stmt = $dbconn->prepare("SELECT * FROM `books`");

		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
			$result .= '<tr><td>'.$row['title'].'</td>';
			$result .= '<td>'.$row['author'].'</td>';
			$result .='<td>'.$row['price'].'</td>';
			$result .= '<td>'.$row[5].'</td>';
			$result .= '<td>'.$row['publication_date'].'</td>';
			$result .= '<td><img src="'.$row['image_path'].'" height="50" width="50"></td>';
			$result.='<td><a href="edit_products.php?book_id='.$row[0].'">Edit</a></td>';
			$result.='<td><a href="delete_products.php?book_id='.$row[0].'">Delete</a></td></tr>';

		}

		return $result;
	}

	function viewProductList($dbconn)
	{
		$result ="";

		$stmt = $dbconn->prepare("SELECT * FROM `books`");

		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
			$result .= '<li class="book"><a href="book_preview.php?book_id='.$row[0].'">';
			$result .= '<div class="book-cover" style="background: url('.$row['image_path'].'); background-size: cover; background-position: center; background-repeat:no-repeat;">';
			$result .= '</div></a>';
			$result .= '<div class="book-price"><p>$'.$row['price'].'</p></div></li>';
		}

		return $result;
	}





	function getProductById($dbconn, $bookId)
	{
		$result="";
		$stmt = $dbconn->prepare("SELECT * FROM `books` WHERE `book_id`=:bookId");

		$stmt->bindParam(':bookId',$bookId);
		$stmt->execute();

		$result =$stmt->fetch(PDO::FETCH_BOTH);

		return $result;
		
	}


	function getProductByRecentlyViewed($dbconn)
	{
		$result = "";
		$recently_viewed = 'Recently Viewed';
		$stmt= $dbconn->prepare("SELECT * FROM `books` WHERE `flag`= :rv");
		$stmt->bindParam(':rv', $recently_viewed);
		$stmt->execute();

		while ($rv = $stmt->fetch(PDO::FETCH_BOTH)) {
			$result .= '<li class="book">';
			$result .= '<a href="book_preview.php?book_id='.$rv['book_id'].'">';
			$result .= '<div class="book-cover" style="background: url('.$rv['image_path'].'); background-size: cover; background-position: center; background-repeat:no-repeat;">';
			$result .= '</div></a><div class="book-price"><p>$'.$rv['price'].'</p></div></li>';

		}

		return $result;
	}

	function getProductByTrending($dbconn)
	{
		$result = "";
		$trending = 'Trending';
		$stmt= $dbconn->prepare("SELECT * FROM `books` WHERE `flag`= :tr");
		$stmt->bindParam(':tr', $trending);
		$stmt->execute();

		while ($tr = $stmt->fetch(PDO::FETCH_BOTH)) {
			$result .= '<li class="book">';
			$result .= '<a href="book_preview.php?book_id='.$tr['book_id'].'">';
			$result .= '<div class="book-cover" style="background: url('.$tr['image_path'].'); background-size: cover; background-position: center; background-repeat:no-repeat;">';
			$result .= '</div></a><div class="book-price"><p>$'.$tr['price'].'</p></div></li>';

		}

		return $result;
	}



	function viewProductByTopSelling($dbconn)
	{
		$result = "";
		$top_selling = 'Top Selling';
		$stmt= $dbconn->prepare("SELECT * FROM `books` WHERE `flag`= :tp");
		$stmt->bindParam(':tp', $top_selling);
		$stmt->execute();

		while ($ts = $stmt->fetch(PDO::FETCH_BOTH)) {
			$result .= '<a href="book_preview.php?book_id='.$ts['book_id'].'">';
			$result .= '<div  class="display-book" style="background: url('.$ts['image_path'].'); background-size: cover; background-position: center; background-repeat:no-repeat;">';
			$result .= '</div></a><div class="info"><h2 class="book-title">'.$ts['title'].'</h2>';
			$result .= '<h3 class="book-author">by '.$ts['author'].'</h3>';
			$result.='<h3 class="book-price">$'.$ts['price'].'</h3>';


		}

		return $result;
	}

	function getProductTopSelling($dbconn)
	{
		
		$top_selling = 'Top Selling';

		$stmt=$dbconn->prepare("SELECT * FROM `books` WHERE `flag`=:tp");
		$stmt->bindParam(':tp', $top_selling);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_BOTH);

		return $row;
	}


	function bookPreviewDisplay($dbconn, $bookId)
	{
		$result = "";
		$stmt = $dbconn->prepare("SELECT * FROM `books` WHERE `book_id`=:bookId");
		$stmt->bindParam(':bookId', $bookId);
		$stmt->execute();
		while ($bpd =$stmt->fetch(PDO::FETCH_BOTH)) {
			$result .= '<div class="display-book" style="background: url('.$bpd['image_path'].'); background-size: cover; background-position: center; background-repeat: no-repeat;">';
			$result .='</div><div class="info"><h2 class="book-title">'.$bpd['title'].'</h2>';
			$result .= '<h3 class="book-author">by '.$bpd['author'].'</h3>';
			$result .= '<h3 class="book-price">$'.$bpd['price'].'</h3>';
		}

		return $result;
	}
	





	 function editProduct($dbconn,$input)
	 {
	 	$stmt = $dbconn->prepare("UPDATE `books` SET `title`=:t, `author`=:a, `price`=:p, `publication_date`=:pdate, `category_id`=:catId, `flag`=:flag WHERE `book_id`=:bookId");

	 	$data = array(':t' =>$input['title'],
	 				':a' =>$input['author'],
	 				':p' =>$input['price'],
	 				':pdate' =>$input['publication_date'],
	 				':catId' =>$input['catId'],
	 				':flag' =>$input['flag'],
	 				':bookId' =>$input['book_id']);

	 	$stmt->execute($data);
	 }




	 function deleteProduct($dbconn, $bookId)
	 {
	 	$stmt= $dbconn->prepare("DELETE FROM `books` WHERE `book_id`=:bookId");
	 	$stmt->execute(array(':bookId' => $bookId));
	 }


	 function editImage($dbconn, $bookId, $input)
	 {
	 	$stmt= $dbconn->prepare("UPDATE `books` SET `image_path`=:img WHERE `book_id`=:bookId");

	 	$data = array(':img' => $input['dest'], ':bookId'=>$bookId);

	 	$stmt->execute($data);
	 }



	 function insertComment($dbconn, $username, $bookId, $comment)
	 {
	 	$stmt = $dbconn->prepare("INSERT INTO `comment`(`comment`,`username`,`book_id`) VALUES(:comment, :username, :bookId)");

	 	$data = array(':comment'=>$comment, ':username'=>$username, ':bookId'=>$bookId);

	 	$stmt->execute($data);
	 }

	 function viewComment($dbconn)
	 {
	 	$result = "";
	 	$stmt = $dbconn->prepare("SELECT * FROM `comment`");
	 	$stmt->execute();

	 	while ($row=$stmt->fetch(PDO::FETCH_BOTH)) {
	 		$init = substr($row['username'], 0,2);
	 		$result .= '<li class="review"><div class="avatar-def user-image">';
	 		$result .= '<h4 class="user-init">'. $init .'</h4></div>';
	 		$result .= '<div class="info"><h4 class="username">'.$row['username'].'</h4>';
	 		$result .= '<p class="comment">'.$row['comment'].'</p></div></li>';
	 	}

	 	return $result;
	 }

	 function viewCommentById($dbconn, $bookId)
	 {
	 	$result = "";
	 	$stmt = $dbconn->prepare("SELECT * FROM `comment` WHERE `book_id` = :bookId");
	 	$stmt->bindParam(":bookId", $bookId);
	 	$stmt->execute();

	 	while ($row=$stmt->fetch(PDO::FETCH_BOTH)) {
	 		$init = substr($row['username'], 0,2);
	 		$result .= '<li class="review"><div class="avatar-def user-image">';
	 		$result .= '<h4 class="user-init">'. $init .'</h4></div>';
	 		$result .= '<div class="info"><h4 class="username">'.$row['username'].'</h4>';
	 		$result .= '<p class="comment">'.$row['comment'].'</p></div></li>';
	 	}

	 	return $result;
	 }

	 


	 function viewCart($dbconn, $userId)
	 {

	 	$result = "";

	 	$stmt = $dbconn->prepare("SELECT * FROM `cart` WHERE user_id=:userId");
	 	$stmt->bindParam(':userId', $userId);
	 	$stmt->execute();

	 	while ($row=$stmt->fetch(PDO::FETCH_BOTH)) {
	 		$result .= '<tr><td><div class="book-cover" style="background:url('.$row['image_path'].'); background-size:contain; background-position: center; background-repeat: no-repeat;"></div></td>';
	 		$result .= '<td><p class="book-price">$'.$row['price'].'</p></td>';
	 		$result .= '<td><p class="quantity">'.$row['amount'].'</p></td>';
	 		$result .= '<td><p class="total">$'.$row['total_price'].'</p></td>';
	 		$result .= '<td><a href="change_quantity.php?book_id='.$row['book_id'].'" class="def-button remove-item">Change Quantity</a>';
	 		$result .= '</td><td><a href="remove_cart.php?book_id='.$row['book_id'].'" class="def-button remove-item">Remove Item</a></td></tr>';
	 	}

	 	

	 	return $result;
	 }

	 function insertToCart($dbconn, $bookId, $userId, $amount, $product)
	 {
	 	$price = $product['price'];
	 	$totalPrice = $price * $amount;
	 	$image_path = $product['image_path'];

	 	$stmt = $dbconn->prepare("INSERT INTO `cart`(`price`, `amount`, `total_price`, `image_path`, `user_id`, `book_id`) VALUES(:price, :amount, :totalPrice, :image_path, :userId, :bookId)");

	 	$data = array(':price'=>$price, ':amount' => $amount , ':totalPrice'=>$totalPrice, ':image_path'=>$image_path, ':userId'=>$userId, ':bookId'=>$bookId);

	 	$stmt->execute($data);
	 }


	 function cartAmount($dbconn, $userId)
	 {
	 	$result ="";

	 	$stmt= $dbconn->prepare("SELECT * FROM `cart` WHERE user_id = :userId");
	 	$stmt->bindParam(':userId',$userId);

	 	$stmt->execute();
	 	$result = $stmt->rowCount();
	 	return $result;
	 }

	 function checkUserLogin($dbconn, $userId)
	 {
	 	if (!isset($userId)) {
	 		header("location:index.php");
	 	}
	 }

	 function fetchCartbById($dbconn, $bookId)
	 {
	 	$stmt= $dbconn->prepare("SELECT * FROM `cart` WHERE `book_id`=:bookId");

	 	$stmt->bindParam(':bookId', $bookId);
	 	$stmt->execute();
	 	$row = $stmt->fetch(PDO::FETCH_BOTH);

	 	return $row;
	 }


	 function removeFromCart($dbconn, $bookId)
	 {
	 	$stmt = $dbconn->prepare("DELETE FROM `cart` WHERE `book_id`=:bookId ");
	 	$stmt->bindParam(':bookId', $bookId);

	 	$stmt->execute();

	 }




	 function updateCart($dbconn, $amount, $price, $cart_id)
	 {
	 	$total_price = $price * $amount;
	 	$stmt = $dbconn->prepare("UPDATE `cart` SET `amount`=:amount, `total_price`=:total_price WHERE `cart_id`= :cart_id");

	 	$data = array(':amount'=>$amount, ':total_price'=>$total_price, ':cart_id'=>$cart_id);

	 	$stmt->execute($data);

	 	header("location:cart.php");


	 }


?>