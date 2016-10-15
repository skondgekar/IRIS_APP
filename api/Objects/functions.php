<?php

session_start();


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
	public $columns;
	public $where;
	
	function __construct(){
		
	}
	
	function getJSON(){
		$Temp = array();
		if($this->type){
			$Temp['type'] = $this->type;
		}

		$Temp['args']['table'] = $this->table;
		if($this->returning){
			$Temp['args']['returning'] = $this->returning;
		}
		
		if($this->objects){
			$Temp['args']['objects'] = $this->objects;
		}

		if($this->columns){
			$Temp['args']['columns'] = $this->columns;
		}
		if($this->where){
			$Temp['args']['where'] = $this->where;
		}
		return json_encode($Temp);
	}
	
	function AddObject($ob){
		$this->objects[] = $ob;
	}
}

class OTP{
	public $Url;
	public $AadharId;
	public $DeviceId;
	public $CertificateType;
	public $Channel;
	public $Type;
	public $latitide;
	public $longitude;
	public $altitude;
	public $pincode;
	
	
	public function __construct(){
		$this->Url = "http://139.59.30.133:9090/otp";
		$this->AadharId = "";
		$this->DeviceId = "";
		$this->CertificateType = "preprod";
		$this->Channel = "SMS";
		$this->Type = "";
		$this->latitide = "";
		$this->longitude = "";
		$this->altitude = "";
		$this->pincode = "";
		
	}

	public function genOTP(){
		$Data = array();
		$Data['aadhaar-id'] = $this->AadharId;
		$Data['device-id'] = $this->DeviceId;
		$Data['certificate-type'] = $this->CertificateType;
		$Data['channel'] = $this->Channel;
		$Data['location']['type'] = "";
		$Data['location']['latitude'] = "";
		$Data['location']['longitude'] = "";
		$Data['location']['altitude'] = "";
		$Data['location']['pincode'] = "";
		
		return SendData($this->Url, json_encode($Data));
	}
}

class KYC{
	public $Url;
	public $Consent;
	public $type;
	public $pincode;
	public $modality;
	public $certificate;
	public $OTP;
	public $Aadhar;
	
	public function __construct(){
		$this->Url = "http://139.59.30.133:9090/kyc/raw";
		$Data = array();
		$this->Consent = "Y";
		$this->modality = "otp";
		$this->certificate = "preprod";
		$this->type = "pincode";
		$this->pincode = "";
	}
	
	public function getKYC(){
		$Data = array();
		$Data['consent'] = $this->Consent;
		$Data['auth-capture-request']['aadhaar-id'] = $this->Aadhar;
		$Data['auth-capture-request']['location']['type'] = $this->type;
		$Data['auth-capture-request']['location']['pincode'] = $this->pincode;
		$Data['auth-capture-request']['modality'] = $this->modality;
		$Data['auth-capture-request']['certificate-type'] = $this->certificate;
		$Data['auth-capture-request']['otp'] = $this->OTP;
		
		return SendData($this->Url, json_encode($Data));
	}
}

function PrintNoNull($Input){
	if(isset($Input)){
		return $Input;
	}
	return "";
}

function convertToBlank($Input){
	if(!isset($Input)){
		$Input = "";
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