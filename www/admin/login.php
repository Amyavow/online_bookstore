	<?php 
	$page_title = "Log In";
	session_start();
	include "../include/header.php";
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/footer.php';

	$error = array();

	if (array_key_exists('login', $_POST)) {
		
		if (empty($_POST['email'])) {
			$error['email'] = "Please enter in your email address";
			}

		if (empty($_POST['password'])) {
			$error['password'] = "Please enter in your password";
			}

		if (empty($error)) {

			$cleanarray = array_map('trim', $_POST);
			$data= adminLogin($conf, $cleanarray);

			if ($data[0]) {
				$details = $data[1];
				$_SESSION['name'] = $details['firstname']. " ". $details['lastname'];
				$_SESSION['admin_id'] = $details['admin_id'];


				header("location:add_category.php");

				/*redirect("add_category.php","");*/
			}else{
				$msg = 'Email or password incorrect';
				header("location:login.php?msg=$msg");

			}

			


		}


	}


	 ?>


	<div class="wrapper">
		<h1 id="register-label">Admin Login</h1>
		<hr>
		<form id="register"  action ="login.php" method ="POST">
			<div>
				<?php $errorinfo = displayErrors($error, 'email'); echo $errorinfo;
				if (isset($_GET['msg'])) {
				echo '<span class="err">'.$_GET['msg'].'</span>';
				}
				 ?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php  $errorinfo = displayErrors($error, 'password'); echo $errorinfo; ?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>

			<input type="submit" name="login" value="login">
		</form>

		<h4 class="jumpto">Don't have an account? <a href="register.php">register</a></h4>
	</div>

	<?php include "../include/footer.php";  ?>