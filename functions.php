<?php
if($_POST['registrationbtn'])
{
$username = $_POST['username'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$phonenumber = $_POST['phonenumber'];
if(preg_match('/^[A-Za-z0-9]+$/', $username)){
	if($password1 == $password2){
		if(filter_var($email , FILTER_VALIDATE_EMAIL)){

		}
		else
		{
			echo "please provide valid email address.$registration_form";
		}
	


	}
	else
	{
		echo "please enter the same password in both password field.$registration_form";
	}

}
else
{
	echo "please provide a valid username. username should contain only latters and numbers.$registration_form";
}

}

?>