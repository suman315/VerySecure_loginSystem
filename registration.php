<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$db_user_id=$_SESSION['userid'];
$db_user = $_SESSION['username'];
?>

<!DOCTYPE html >
<html>
<head>
  <script type="text/javascript">
function findName(){
    if (window.XMLHttpRequest){
  xmlhttp=new XMLHttpRequest();
  }
else{
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("result").innerHTML=xmlhttp.responseText;
    }
  }
paramiters = 'search_username='+document.getElementById("searchtext").value;
xmlhttp.open("POST","search.php", true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send(paramiters);
}
   </script>
</head>
<body>
<?php
$site = "http://dev.sumanpoudel.com";
if ($db_user_id || $db_user){
  echo "you have already activate your account please use the login page.";
  echo "<script> function goToLogin(){ setTimeout( function(){window.location = './login.php'; }, 3000)}";
        echo "goToLogin(); </script>";
  
}
$registration_form = "<form action='./registration.php' method='post' />
<table style='text-align:right;' >
<tr>$errmessage</tr>
<tr><div id='result'> </div></tr>
<tr><td>
USERNAME:</td><td><input type='text' id='searchtext' name='username' onkeyup='findName();' autofocus></td>
<tr><td>PLEASE CHOOSE A PASSWORD:</td> <td><input type='password' name='password1'/></td></tr>
<tr><td>PLEASE CONFIRM YOUR PASSWORD:</td> <td><input type='password' name='password2' /></td></tr>
<tr><td>EMAIL:</td><td><input type='email' name='email' /></td></tr>
<tr><td>PHONE NUMBER(optional):</td> <td><input type='text' name='phonenumber' /></td></tr>
<tr><td><input type='submit' name='registrationbtn' value='registration' /></td></tr>
</table> </form>";

if($_POST['registrationbtn']){
    require("./functions.php");
  $username = $_POST['username'];
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];
  $email = $_POST['email'];
  $phonenumber = $_POST['phonenumber'];

  //checking username
userNamecheck($username);
 //checking password 
passWordCheck($password1, $password2);
//checking email
emailCheck($email);
//checking phonenumber
phoneNumberCheck($phonenumber);

if(userNamecheck($username) && passWordCheck($password1, $password2) && emailCheck($email) && phoneNumberCheck($phonenumber)){ 
require("./connect.php"); 
  $query = "SELECT * FROM user WHERE `username` = '$username'";
  $result = mysqli_query($connect, $query) or die("error checking username");
  $user_check = mysqli_num_rows($result);
  if($user_check == 1){
    $errmessage = "this username already exitsts please try somthing else as username";
    echo "$errmessage.$registration_form";
  }
  else{
$registration_date = date("Y-m-d H:i:s");
$code = md5(mt_rand(100, 100000));

$email_ckeck_query = "select `email` from user where email='$email'";
$email_ckeck_result = mysqli_query($connect , $email_ckeck_query);
$email_ckeck_row = mysqli_num_rows($email_ckeck_result);
if ($email_ckeck_row==1){
  echo "this email is alredy exists in system please go to forget password to recover your password.";
  echo "<script> goToLogin(); </script>";
}else{
$password1 = md5(md5("dhdh".$password1."dgdh"));
$query = "insert into `user` (`username` , `password` , `email` , `phonenumber` , `active` , `registration_date` , `code`) values ('$username' , '$password1' ,
 '$email' , '$phonenumber' , '0' , '$registration_date' , '$code') ";
$result = mysqli_query($connect , $query) or die("please try again for registration");
if ($result){
$headers = 'From: no reply<contact@sumanpoudel.com>';
$message = "account activation link.<br>";
$message .= "$site/activation.php?user=$username&code=$code";
$subject = 'actiate your account';

// Send
if(mail($email, $subject, $message , $headers )){
  echo "email has been sent to <b> $email </b> with an activation link";
  unset($username);
  unset($password1);
  unset($password2);
  unset($phonenumber);
  unset($email);
  //redirecting to login page
  echo "<script> goToLogin(); </script>";
}
else{
  die("an error has occured during sending you email");
}
}
   // closing the result 
      mysqli_free_result($result);
      mysqli_free_result($email_ckeck_result);
            // closing the connection
      mysqli_close($connect);
}
}
}
else{
  echo "$errmessage.$registration_form";
}

}
else{
  echo $registration_form;
}
?>


</body>
</html>