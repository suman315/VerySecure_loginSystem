<?php
global $errmessage;
function userNameCheck($string){
 if (empty($string)){
 	$errmessage = "please provide your username";
 }
   else
     {
     	if(preg_match('/^[A-Za-z0-9]+$/' , $string)){
     	$vusername = $string;
     	}
     	else{
     		$errmessage = "invalid username  username must be abphabatical and numeric";
     	}
     }
}

function passwordcheck($string1, $string2){

	if(!empty($string1)){
  if ($string1 === $string2){
  	$vpassword = md5(md5("dhdh".$string1."dgdh"));
  	return $vpassword;
  }
  else
  {
  	$errmessage = "please provide the same password";
  	return $errmessage;
  }
}
else{ 
	$errmessage = "please provide your password";
	return $errmessage;

	 }

}
$string1 = "hdhdhdh";
$string2 = "dhhdhd";

passwordcheck($string1, $string2);

echo $errmessage;

 ?>