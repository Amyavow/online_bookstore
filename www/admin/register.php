	<?php  
		$page_title = "Register";
		include '../include/db.php';
		include '../include/header.php';
		include '../include/functions.php';


		$error = array();
		if (array_key_exists('register', $_POST)) {
			

			if (empty($_POST['fname'])) {
				$error['fname'] = "Please enter your firstname";
			}

			if (empty($_POST['lname'])) {
				$error['lname'] = "Please enter your lastname";
			}

			if (empty($_POST['email'])) {
				$error['email'] = "Please enter in your email address";
			}

			if (doesEmailExist($conf, $_POST['email'])) {
				$error['email'] = 'Email already exists';
			}


			if (empty($_POST['password'])) {
				$error['password'] = "Please enter in your password";
			}

			if (empty($_POST['pword'])) {
				$error['pword'] = "Please confirm your password";
			}

			if ($_POST['password'] !== $_POST['pword']) {
				$error['pword'] = "Your password does not match. Please make sure they match";
			}

			if (empty($error)) {

				$clean = array_map('trim', $_POST);
				adminRegister($conf,$clean);
				

				echo "Registered successfully";
			}
		}



	?>
	
	<div class="wrapper">
		<h1 id="register-label">Register</h1>
		<hr>
		<form id="register"  action ="register.php" method ="POST">
			<div>
				<?php $errorinfo = displayErrors($error, 'fname'); echo $errorinfo; ?>
				<label>first name:</label>
				<input type="text" name="fname" placeholder="first name">
			</div>
			<div>
				<?php $errorinfo = displayErrors($error, 'lname'); echo $errorinfo;?>
				<label>last name:</label>	
				<input type="text" name="lname" placeholder="last name">
			</div>

			<div>
				<?php  $errorinfo = displayErrors($error, 'email'); echo $errorinfo; ?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php  $errorinfo = displayErrors($error, 'password'); echo $errorinfo; ?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>
 
			<div>
				<?php  $errorinfo = displayErrors($error, 'pword'); echo $errorinfo; ?>
				<label>confirm password:</label>	
				<input type="password" name="pword" placeholder="password">
			</div>

			<input type="submit" name="register" value="register">
		</form>

		<h4 class="jumpto">Have an account? <a href="login.php">login</a></h4>
	</div>

	<?php include '../include/footer.php'?>