<?php
session_start();

if (isset($_SESSION['email'])) {
	echo "Logging you out.. Please wait";
	session_destroy();
	header("location:/forum/index.php?status=logout");
}

?>