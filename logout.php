<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['userid']);
session_destroy();
die(header("location: index.php"));
	exit();
	?>

