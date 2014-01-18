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
$username = $_POST['username'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$phonenumber = $_POST['phonenumber'];
 if (empty($_POST['username'])){
 	$nameErr = "Name is required";
 }
   else
     {
     	if(preg_match('/^[A-Za-z0-9]+$/' , $_POST['username'])){
     		$vusername == $_POST['username'];
     	}
     	else{
     		die("invalid username. username must be abphabatical and numeric.$registration_form");
     	}
     }
  if ($_POST['password1']===$_POST['password2']){
  	$vpassword == md5(md5($_POST['password1']));
  }
  else
  {
  	die("please provide the same password .$registration_form");
  }
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
if (filter_var($_POST['phonenumber'], FILTER_VALIDATE_INT)){
	if(strlen($_POST['phonenumber']) <10 or strlen($_POST['phonenumber'>17])){
	die("please provide a valid phonenumber.$registration_form");
}else{
	$vphonenumber = $_POST['phonenumber'];
}
}
else
{
	die("please provide a valid phonenumber .$registration_form");
}
$registration_date = date("Y-m-d H:i:s");
// begin * from here 
}
else{
	echo $registration_form;
}

?>

</body>
</html>