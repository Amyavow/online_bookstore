<?php

	include '../include/functions.php';

	define('MAX_FILE_SIZE', '2097152');

	$ext = array("image/png", "image/jpeg", "image/jpg");
	
	if (array_key_exists('save', $_POST)) {

		$error = array();
		if (empty($_FILES['pics']['name'])) {
			$error[] = "Please select an image";
		}

		if ($_FILES['pics']['size'] > MAX_FILE_SIZE) {
			$error[] = "File too large. Maximum ".MAX_FILE_SIZE;
		}

		if (!in_array($_FILES['pics']['type'], $ext)) {
			$error[] = "File format not supported";
		}

		//this moveable part can be written into a function
		/*$rnd = rand(0000000000,9999999999);
		$strip_name = str_replace(' ', '_',$_FILES['pics']['name']);

		$filename = $rnd . $strip_name;

		$destination = './uploads/'.$filename;*/


		/*if (!move_uploaded_file($_FILES['pics']['tmp_name'], $destination)) {
			$error[] = "File not uploaded";
		}*/

		if (empty($error)) {

			/*move_uploaded_file($_FILES['pics']['tmp_name'], $destination);*/

			$info = uploadFiles($_FILES, "pics", "./uploads/");

			if ($info[0]) {

				echo "File upload sucessful";
			}
			
		}else{
			foreach ($error as $err) {
				echo $err;
			}
		}
		
	}


?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="post" action="index.php" enctype="multipart/form-data">

		<p>Please upload a file</p>
		<input type="file" name="pics">
		<input type="submit" name="save" value="Submit">
		
	</form>

</body>
</html>




