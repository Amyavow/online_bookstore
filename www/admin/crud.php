<?php
include ('../include/db.php');
//Querying database
 	/*$result = $conf ->query("Select * from user");
 	foreach ($result as $res) {
 		echo $res[0]. "<br>";
 		echo $res[1]. "<br>";
 	}*/

 	//Querying database style 2 and preferred style
 	$name = "Amy";
 	$check= $conf->prepare("SELECT * FROM user WHERE `username` = :name ");

 	$check->bindParam(":name",$name);
 	//$conf ->bindValue(":name", "Amy")//not as efficient as bindParam
 	$check ->execute();
 		$row = $check->fetch();
 		echo $row['username'];
 	//executes the prepare statement

 ?>
