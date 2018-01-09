<?php
	session_start();
	$pagetitle = "Log in";
	$page = 'login';
	include '../include/db.php';
	include '../include/functions.php';
	include '../include/clientheader.php';

	$error = array();

	if (array_key_exists('log_in', $_POST)) {
		if (empty($_POST['email'])) {
			$error['email'] = "Please put in your email";
		}

		if (empty($_POST['password'])) {
			$error['password'] = "Please put in your password";
		}

		if (empty($error)) {

		$clean = array_map('trim', $_POST);

		$data = clientLogin($conf, $clean);

		if ($data[0]) {
			$info = $data[1];

			$_SESSION['client_name'] = $info['firstname']." ".$info['lastname'];
			$_SESSION['username'] = $info['username'];
			$_SESSION['email'] =$info['email'];
			$_SESSION['user_id'] = $info['user_id'];

			redirect("index.php","");
		}else{
			$msg = "Incorrect Email or password";
			header("location:login.php?msg=$msg");
		}

		
			
		}
	}


?>

<!-- main content starts here -->
  <div class="main">
    <div class="login-form">
      <form class="def-modal-form" action="" method="post">
        <div class="cancel-icon close-form"></div>
        <label for="login-form" class="header"><h3>Login</h3></label>

        <?php if (isset($_GET['msg'])) {
        	echo '<span class="form-error">'.$_GET['msg'].'</span>';
        }  ?>

        <?php $errorInfo = displayErrorsClient($error,'email'); echo $errorInfo; ?>
        <input type="text" class="text-field email" placeholder="Email" name="email">
        <!-- <p class="form-error">invalid email</p> -->

        <?php $errorInfo = displayErrorsClient($error, 'password'); echo $errorInfo; ?>
        <input type="password" class="text-field password" placeholder="Password" name="password">
        <!--clear the error and use it later just to show you how it works -->
       <!--  <p class="form-error">wrong password</p> -->
        <input type="submit" class="def-button login" value="Login" name="log_in">
      </form>
    </div>
  </div>

<?php include '../include/clientfooter.php'; ?>
