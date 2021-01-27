<?php
	include 'db_connect.php';
	$showalert = "";
	$login = 0;
	

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		
		include 'partials/db_connect.php';

		$email_login = $_REQUEST['loginEmail'];	
		$pass_login = $_REQUEST['loginPass'];	

		$q = "select * from users where user_email = ?";
		$stmt = $pdo->prepare($q);
		$stmt->execute([$email_login]);
		$count = $stmt->rowcount();
		$row = $stmt->fetch();
		
		if ($count>0) {
			
			if (password_verify($pass_login, $row['user_password'])) {
				session_start();
				$_SESSION['loggedin'] = true;
				$_SESSION['email'] = $email_login;
				$_SESSION['username'] = $row['user_name'];
				$_SESSION['sno'] = $row['sno'];
				//echo "You are logged in".$email_login;
				$login = 1;
				$showalert = "You are successfully logged in.";
				header("location:/forum/index.php?showalert=$showalert & login_result=1");
			}
			else{
				//echo "Password is wrong";
				$login = 0;
				$showalert = "Login failed! Wrong Password.";
				header("location:/forum/index.php?showalert=$showalert & login_result=0");
			}
		}

		else{
			//echo "Email is wrong";
			$login = 0;
			$showalert = "Login failed! Invalid Email";
			header("location:/forum/index.php?showalert=$showalert & login_result=0");
		}


	}