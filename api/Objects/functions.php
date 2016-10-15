<?php

class Response{
	public $Errors;
	public $Data;
	public $message;
	
	function __construct(){
		$this->Errors = array();
		$this->Data = array();
		$this->message = array();
	}
	
	function proceed(){
		if(count($this->Errors) == 0){
			return true;
		}
		return false;
	}
}


class Config{
	public $GenOtp;
	public $GetKYC;
	
	function __construct(){
		$this->GenOtp = "http://139.59.30.133:9090/otp";
		$this->GenOtp = "http://139.59.30.133:9090/kyc/raw";
	}
}

function SendData($Url, $data_json){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer z45qm16ggm8415x0jzrp0p1p343wx0x0'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response  = curl_exec($ch);
	curl_close($ch);
	return $response;
}

class HasuraQueryObject{
	public $type;
	public $table;
	public $returning;
	public $objects;
	
	function __construct(){
		
	}
	
	function getJSON(){
		$Temp = array();
		$Temp['type'] = $this->type;
		$Temp['args']['table'] = $this->table;
		$Temp['args']['returning'] = $this->returning;
		$Temp['args']['objects'] = $this->objects;
		return json_encode($Temp);
	}
	
	function AddObject($ob){
		$this->objects[] = $ob;
	}
}
/*
$HasuraQuery = new HasuraQueryObject();
$HasuraQuery->type = "insert";
$HasuraQuery->table = "driver";
$HasuraQuery->returning = array('driver_id');
$HasuraQuery->AddObject(array(
	"aadhar_id" => "72347632568725",
	"name" => "Anon Ray",
	"dob" => "1980-03-04",
	"address" => "Trial address2",
	"photo" => "sadjfh asidgf pasidgy padsgi ypadsio gypaso digypasiodg ypaosdgypoads gyopid",
	"mobile" => 9833058965,
	"pin_code" => 400079
));


echo $HasuraQuery->getJSON();
echo SendData("https://data.death39.hasura-app.io/v1/query", $HasuraQuery->getJSON());
*/
?>