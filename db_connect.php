<?php 
	$dsn = "mysql:host=localhost;dbname=idiscuss";
	$user = "root";
	$pass = "";
	$opt = [
		PDO::ATTR_ERRMODE            =>PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   =>false,
	];

	$pdo = new PDO($dsn,$user,$pass,$opt);
 ?>