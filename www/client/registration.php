<?php
	$pagetitle = "Registration";
	$page = "registration";
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/clientheader.php';

	$error = array();

	if (array_key_exists('register', $_POST)) {
		if (empty($_POST['firstname'])) {
			$error['firstname'] = 'Please enter your firstname';
		}

		if (empty($_POST['lastname'])) {
			$error['lastname'] = "Please enter your lastname";
		}

		if (empty($_POST['email'])) {
			$error['email'] = "Please enter your email address";
		}

		if (doesEmailExistClient($conf, $_POST['email'])) {
				$error['email'] = 'Email already exists';
		}

		if (empty($_POST['username'])) {
			$error['username'] = "Please choose a username";
		}

		if (empty($_POST['password'])) {
			$error['password'] = "Please input a password";
		}

		if (empty($_POST['pword'])) {
			$error['pword'] = "Please type your password to confirm again";
		}

		if ($_POST['password']!==$_POST['pword']) {
			$error['pword'] = "Password doesn't match. Please make sure that password matches";
		}

		if (empty($error)) {
			$clean = array_map('trim', $_POST);

			clientRegister($conf, $clean);
			redirect("login.php","");
		}
	}
	


?>

<div class="main">
    <div class="registration-form">
      <form class="def-modal-form" method="post" action="">
        <div class="cancel-icon close-form"></div>
        <label for="registration-from" class="header"><h3>User Registration</h3></label>

        <?php $errorInfo = displayErrorsClient($error, 'firstname'); echo $errorInfo;?>
        <input type="text" class="text-field first-name" placeholder="Firstname" name="firstname">


        <?php $errorInfo = displayErrorsClient($error, 'lastname'); echo $errorInfo;?>
        <input type="text" class="text-field last-name" placeholder="Lastname" name="lastname">

        <?php $errorInfo = displayErrorsClient($error, 'email'); echo $errorInfo;?>
        <input type="email" class="text-field email" placeholder="Email" name="email">

        <?php $errorInfo = displayErrorsClient($error, 'username'); echo $errorInfo; ?>
        <input type="text" class="text-field username" placeholder="Username" name="username">

        <?php $errorInfo = displayErrorsClient($error, 'password'); echo $errorInfo; ?>
        <input type="password" class="text-field password" placeholder="Password" name="password">

        <?php $errorInfo = displayErrorsClient($error, 'pword'); echo $errorInfo; ?>
        <input type="password" class="text-field confirm-password" placeholder="Confirm Password" name="pword">

        <input type="submit" class="def-button" value="Register" name="register">
        <p class="login-option">Have an account already?<a href="login.php"> Login</a></p>
      </form>
    </div>
</div>

<?php include '../include/clientfooter.php'; ?>