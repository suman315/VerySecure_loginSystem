<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$db_user_id=$_SESSION['userid'];
$db_user = $_SESSION['username'];
?>
<a href='login.php'>click here to login in </a>
<br>
<?php 
echo date("Y-m-d H:i:s");
?>
