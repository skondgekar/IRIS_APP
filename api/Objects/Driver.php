<?php

include_once('functions.php');

class Driver {
	public $FullName;
	public $DateOfBirth;
	public $AadharId;
	public $Errors;
	public $OTP;
	public $Pincode;
	
	public function __construct(){
		$this->FullName = "";
		$this->DateOfBirth = "";
		$this->AadharId = "";
		$this->Errors = array();
		$this->Pincode = "";
	}
	
	function sendOTP(){
		if($this->AadharId == ""){
			$this->Errors[] = "Aadhar Id cannot be empty";
			return FALSE;
		}
		$OTP = new OTP();
		$OTP->AadharId = $this->AadharId;
		return $OTP->genOTP();
	}
	
	function getKYC(){
		$KYC = new KYC();
		$KYC->Aadhar = $this->AadharId;
		$KYC->OTP = $this->OTP;
		$KYC->pincode = $this->Pincode;
		$KYCData = $KYC->getKYC();
		$pKYC = json_decode($KYCData,true);
		
		if($pKYC['success'] == ""){
			return $KYCData;
		}
		
		$_SESSION['aadhar_Id'] = $this->AadharId;
		//Date of birth change format
		$DateOfBirth = $pKYC['kyc']['poi']['dob'];
		$Split = explode("-", $DateOfBirth);
		$DateOfBirth = $Split[2]."-".$Split[1]."-".$Split[0];
		
		//Address consolidate
		$Address1 = $pKYC['kyc']['poa'];
		$Address = PrintNoNull($Address1['house'])."</br>";
		$Address .= PrintNoNull($Address1['lm'])."</br>";
		$Address .= PrintNoNull($Address1['street'])."</br>";
		$Address .= PrintNoNull($Address1['po'])."</br>";
		$Address .= PrintNoNull($Address1['dist'])."</br>";
		$Address .= PrintNoNull($Address1['state'])."</br>";
		
		
		//Add hasuras database connection and driver
		
		$HasuraQuery = new HasuraQueryObject();
		$HasuraQuery->type = "insert";
		$HasuraQuery->table = "driver";
		$HasuraQuery->returning = array("driver_id");
		$HasuraQuery->AddObject(array(
			"aadhar_id" => $this->AadharId,
			"name" => $pKYC['kyc']['poi']['name'],
			"dob" => $DateOfBirth,
			"gender" => $pKYC['kyc']['poi']['gender'],
			"address" => $Address,
			"photo" => $pKYC['kyc']['photo'],
			"pin_code" => intval($pKYC['kyc']['poa']['pc'])
		));
		/*
		print_r(array(
			"aadhar_id" => $this->AadharId,
			"name" => $pKYC['kyc']['poi']['name'],
			"dob" => $DateOfBirth,
			"gender" => $pKYC['kyc']['poi']['gender'],
			"address" => $Address,
			"photo" => $pKYC['kyc']['photo'],
			"pin_code" => $pKYC['kyc']['poa']['pc']
		));
		*/
		SendData("https://data.death39.hasura-app.io/v1/query", $HasuraQuery->getJSON());
		
		return $KYCData;
	}

	function getDriver(){
		$HasuraQuery = new HasuraQueryObject();
		$HasuraQuery->type = "select";
		$HasuraQuery->table = "driver";
		$HasuraQuery->columns = array('driver_id','aadhar_id','name','dob','address','photo','pin_code','gender');
		$HasuraQuery->where = array('aadhar_id' => $this->AadharId);
		
		return json_decode(SendData("https://data.death39.hasura-app.io/v1/query", $HasuraQuery->getJSON()),1);
	}
}

?>