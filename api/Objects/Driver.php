<?php

include_once('functions.php');

class Driver {
	public $FullName;
	public $DateOfBirth;
	public $AadharId;
	public $Errors;
	
	public function __construct(){
		$this->FullName = "";
		$this->DateOfBirth = "";
		$this->AadharId = "";
		$this->Errors = array();
	}
	
	function AddDriver(){
		if($this->AadharId == ""){
			$this->Errors[] = "Aadhar Id cannot be empty";
			return FALSE;
		}
	}
	
	function GenerateOTP(){
		//send curl request through php
	}
}

?>