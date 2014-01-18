<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$user_id=$_SESSION['userid'];
$username = $_SESSION['username'];
?>
<a href='login.php'>click here to login in </a>