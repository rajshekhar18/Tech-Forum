<?php
	include 'db_connect.php';
	$showalert = "";
	$showerror = false;

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		
		$signup_email = $_REQUEST['email'];
		$signup_name = $_REQUEST['name'];
		$signup_password = $_REQUEST['password'];
		$signup_cpassword = $_REQUEST['cpassword'];

		$q = "select * from users where user_email =?";
		$stmt = $pdo->prepare($q);
		$stmt->execute([$signup_email]);
		$count = $stmt->rowcount();

		if ($count > 0) {
			
			$showerror = true;
		}
		elseif ($signup_password == $signup_cpassword) {
			
			$password_hash = password_hash($signup_password, PASSWORD_DEFAULT);

			$insert = "insert into users(user_email,user_name,user_password,date) value(:email,:name,:pass,current_timestamp())";
			$stmt1->bindValue('email',$signup_email);
			$stmt1->bindValue('name',$signup_name);
			$stmt1->bindValue('pass',$password_hash);
			$stmt1->execute();

			$showalert = "Your signup is successful";
			header("Location:index.php?signup = pass");

		}
		else{
			$showalert = "Email already taken"
			header("location:index.php?signup = fail");
		}
	}

?>