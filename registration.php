<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
?>

<!DOCTYPE html >
<html>
<head>
	<title>registration</title>
</head>
<body>
<?php

$registration_form = "<form action='./registration.php' method='post' />
<table style='text-align:right;' >
<tr><td>
USERNAME:</td><td><input type='text' name='username' autofocus></td>
<tr><td>PLEASE CHOOSE A PASSWORD:</td> <td><input type='password' name='password1'/></td></tr>
<tr><td>PLEASE CONFIRM YOUR PASSWORD:</td> <td><input type='password' name='password2' /></td></tr>
<tr><td>EMAIL:</td><td><input type='email' name='email' /></td></tr>
<tr><td>PHONE NUMBER(optional):</td> <td><input type='text' name='phonenumber' /></td></tr>
<tr><td><input type='submit' name='registrationbtn' value='registration' /></td></tr>
</table> </form>";

if($_POST['registrationbtn']){
 if (empty($_POST['username'])){
 	$nameErr = "Name is required";
 }
   else
     {
     	if(preg_match('/^[A-Za-z0-9]{3,}/' , $_POST['username'])){
     		$vusername = $_POST['username'];
     	}
     	else{
     		die("invalid username. username must be abphabatical and numeric.$registration_form");
     	}
     }
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
require("connect.php");
$email_ckeck_query = "select `email` from user where email='$vemail'";
$email_ckeck_result = mysqli_query($connect , $email_ckeck_query);
$email_ckeck_row = mysqli_num_rows($email_ckeck_result);
if ($email_ckeck_row==1){
  echo "this email is alredy exists in system please go to forget password to recover your password.";
  header('refresh:5; url=login.php');
}else{

$query = "insert into `user` (`username` , `password` , `email` , `phonenumber` , `active` , `registration_date`) values ('$vusername' , '$vpassword' ,
 '$vemail' , '$vphonenumber' , '0' , '$registration_date') ";
$result = mysqli_query($connect , $query) or die("please try again for registration");
if ($result){
  echo "registration success please check your email for account activation";
/**********************************************************************************
 for mail server 
// The message
 $message = "click this link for activation";

// Send
mail('$vemail', 'account activaton', $message);

******************************************************************************/

}
}

}
else{
	echo $registration_form;
}

?>

</body>
</html>