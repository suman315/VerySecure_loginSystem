<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$db_user_id=$_SESSION['userid'];
$db_user = $_SESSION['username'];
?>

<?php
$site = "http://dev.sumanpoudel.com";
if ($user_id || $username){
	echo "you have already activate your account please use the login page.";
	header('refresh:5; url=$site/login.php');
}
else{
$user = $_GET['user'];
$code = $_GET['code'];

if(!empty($user) && !empty($code)){
if(preg_match('/^[A-Za-z0-9]+$/', $user)){
	if(preg_match('/^[A-Za-z0-9]+$/', $code)){
		require("connect.php");
		$query = "SELECT * FROM user WHERE `code` = '$code' AND `username` = '$user'";
		$result = mysqli_query($connect, $query) or die ("error connecting to your activation database");
		$activation_row = mysqli_num_rows($result);
		
		if($activation_row == 1){
			
			$query = "UPDATE `user` SET `active` = '1' WHERE `username` = '$user' AND `code` = '$code'";
			$result = mysqli_query($connect,$query) or die("error activating your account");
			$query = "SELECT * FROM user WHERE `code` = '$code' AND `username` = '$user' AND `active` = '1'";
			$result = mysqli_query($connect, $query);
			$activation_check = mysqli_num_rows($result);
			if($activation_check == 1){
			
				echo " you have sucessfully activated your account please login using your username <b> $user </b> and password";
				header('refresh:5; url=$site/login.php');

			}
			else{
				echo "there has been an error during activation";
			}
		}
		else{
			echo "provided user name or code is not correct /n hello";
		}

	}
	else{
		exit();
	}
}
else{
	exit();
}

}else
{
	echo "your email link is incorrect";
}

	
}

?>