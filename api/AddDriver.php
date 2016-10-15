<?php

    header('Content-Type: *');
    header("Access-Control-Allow-Origin: *");

include_once('Objects/functions.php');
include_once('Objects/Driver.php');

$Result = new Response();

$_POST = json_decode(file_get_contents("php://input"),1);


if($_POST['aadhaar_ID'] == ""){
	$Result->Errors[] = "Aadhar id cannot be blank";
}

if(strlen($_POST['aadhaar_ID']) != 12){
	$Result->Errors[] = "aadhar Id must be 12 characters";
}

if(!$Result->proceed()){
	echo json_encode($Result);
	die();
}

$Result->Data = array("Some data");
$Result->message[] = "OTP generated. Check your mobile";

echo json_encode($Result);

?>