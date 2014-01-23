<?php

if(isset($_POST['search_username'])){
	if(strlen($_POST['search_username'])>4){
	require("./functions.php");
	$username = $_POST['search_username'];
	if(userNameCheck($username)){
$search = $_POST['search_username'];
require("./connect.php");
$query = "select `user_id` from user where `username`='$search'";
$result = mysqli_query($connect, $query) or die("error connecting database");
$num_rows = mysqli_num_rows($result);
if($num_rows == 1){
	echo "username not availabel";
}
else{
	echo "username is avialabel";
}


}
else{
	echo "username must be alfa numeric";
}
}else{
	echo "username must be more then 4 character";
}
}


?>