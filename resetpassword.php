<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$db_user_id=$_SESSION['userid'];
$db_user = $_SESSION['username'];
?>
<?php

if ($db_user_id || $db_user){
  die(header('location: index.php'));
}
$email =$_GET ['email'];
$code =$_GET['code'];
if(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[A-Za-z0-9]+$/', $code)){
require("./connect.php");
$query = "select * from user where `email`='$email' AND `code`='$code'";
$result = mysqli_query($connect, $query) or die (" error connecting to database");
$rows = mysqli_num_rows($result);
if ($rows == 1){
	if($_POST['resetbtn']){
		if($_POST['password1'] === $_POST['password2']){
		$enc_password = md5(md5("dhdh".$_POST['password1']."dgdh"));
		$query = "UPDATE `user` SET `password` = '$enc_password' WHERE `email` = '$email' AND `code` = '$code'";
		$result = mysqli_query($connect, $query) or die("error connecting database");
		if($result){
			echo "password reset success \n <a href='./login.php'>click here</a> to go to login page.";
		}

	}
}

}else{
	echo "user not found";
}


}
else{
	echo "invalid code or email";
}
?>
<form id='passwordreset' method='post'>
please enter your new password:<input type='password' name='password1' /><br>
please reenter your new password:<input type='password' name='password2' /> 
<input type='submit' name='resetbtn' value='passwordreset' />
</form>






