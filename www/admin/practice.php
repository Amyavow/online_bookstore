<?php
$host = '127.0.0.1';
$db   = 'practice';
$user = 'root';
$pass = 'philip';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);


//Using the query PDO::query() method to run queries. It should be used only when the the query does not contain a variable
/*$stmt = $pdo->query("SELECT * FROM `user`");
$row = $stmt->fetch();*/
//while ($row)
//{
    /*echo $row['username'] . "\n";*/
//}

 //Using the prepare PDO::prepare() and PDO::execute() method to run query. It is ideal for queries that contain variables and helpful to prevent sql injections into our database
 //It makes use of placeholders(?, the positional placeholder) and the (:dummy, named placeholder)

    //Using the postional placeholder, the query is run like so:

    	/*$user_id = 1;
    	$username = Amy;

    	$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ? AND username=?');
		$stmt->execute([$user_id, $username]);
		$user = $stmt->fetch();
*/

	//Using the named placeholder, the query is run like so: note that the named placeholder makes use of the key=>value array form:

		$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id AND username=:username');
		$stmt->execute(['user_id' => $user_id, 'username' => $username]);
		$user = $stmt->fetch();


?>