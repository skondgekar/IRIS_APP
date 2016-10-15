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
		$this->Pincode = "400079";
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
		return $KYC->getKYC();
	}
}

?>