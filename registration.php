<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$db_user_id=$_SESSION['userid'];
$db_user = $_SESSION['username'];
?>

<!DOCTYPE html >
<html>
<head>
	<title>registration</title>
</head>
<body>
<?php
$site = "http://dev.sumanpoudel.com";
if ($db_user_id || $db_user){
  echo "you have already activate your account please use the login page.";
  header('refresh:5; url=$site/login.php');
  
}
$registration_form = "<form action='$site/registration.php' method='post' />
<table style='text-align:right;' >
<tr>$errmessage</tr>
<tr><td>
USERNAME:</td><td><input type='text' name='username' autofocus></td>
<tr><td>PLEASE CHOOSE A PASSWORD:</td> <td><input type='password' name='password1'/></td></tr>
<tr><td>PLEASE CONFIRM YOUR PASSWORD:</td> <td><input type='password' name='password2' /></td></tr>
<tr><td>EMAIL:</td><td><input type='email' name='email' /></td></tr>
<tr><td>PHONE NUMBER(optional):</td> <td><input type='text' name='phonenumber' /></td></tr>
<tr><td><input type='submit' name='registrationbtn' value='registration' /></td></tr>
</table> </form>";

if($_POST['registrationbtn']){
  require("./functions.php");
  $username = $_POST['username'];
 usernamecheck($username);

     if(!empty($_POST['password1'])){
  if ($_POST['password1']==$_POST['password2']){
  	$vpassword = md5(md5("dhdh".$_POST['password1']."dgdh"));
  }
  else
  {
  	die("please provide the same password .$registration_form");
  }
}
else{ echo "please provide your password"; }

  if (empty($_POST['email'])){
  	die("please provide the email address.$registration_form");
  }
  else
  {
  	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
  		$vemail = $_POST['email'];
  	}
  	else
  	{
  	die("invalid email address.$registration_form"); 
  	}
  }
  if(strlen($_POST['phonenumber'])>0){
if (preg_match('/^[0-9]+$/', $_POST['phonenumber'])){
	if(strlen($_POST['phonenumber']) < 9 || strlen($_POST['phonenumber']) > 17){
	die("please provide a valid phonenumber.$registration_form");
}else{
	$vphonenumber = $_POST['phonenumber'];
}
}
else
{
	die("please provide a valid phonenumber aaaaaaaa.$registration_form");
}
}
else {
  $vphonenumber = 0;
}
$registration_date = date("Y-m-d H:i:s");
$code = md5(mt_rand(100, 100000));
require("connect.php");
$email_ckeck_query = "select `email` from user where email='$vemail'";
$email_ckeck_result = mysqli_query($connect , $email_ckeck_query);
$email_ckeck_row = mysqli_num_rows($email_ckeck_result);
if ($email_ckeck_row==1){
  echo "this email is alredy exists in system please go to forget password to recover your password.";
  header('refresh:5; url=login.php');
}else{

$query = "insert into `user` (`username` , `password` , `email` , `phonenumber` , `active` , `registration_date` , `code`) values ('$vusername' , '$vpassword' ,
 '$vemail' , '$vphonenumber' , '0' , '$registration_date' , '$code') ";
$result = mysqli_query($connect , $query) or die("please try again for registration");
if ($result){
  echo "registration success please check your email for account activation";
$headers = 'From: no reply<contact@sumanpoudel.com>';
$message = "account activation link.<br>";
$message .= "$site/activation.php?user=$vusername&code=$code";
$subject = 'actiate your account';

// Send
if(mail($vemail, $subject, $message , $headers )){
  echo "email has been sent to <b> $vemail </b> with an activation link";
  $vusername = "";
  $vpassword = "";
  $vemail = "";
}
else{
  die("an error has occured during sending you email");
}
//******************************************************************************/

}
   // closing the result 
      mysqli_free_result($result);
      mysqli_free_result($email_ckeck_result);
            // closing the connection
      mysqli_close($connect);
}

}
else{
	echo $registration_form;
}

?>

</body>
</html>