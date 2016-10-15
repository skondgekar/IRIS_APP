var IRIS_APP = angular.module("IRIS_APP",[])

IRIS_APP.controller('IRISCtrl',function($http, $scope, $timeout){

	$scope.Driver = new Driver($http, $scope, $timeout);
	$scope.Traveller = new Traveller($http, $scope);
	$scope.Login = new Login($http, $scope);


});


function Driver($http, $scope, $timeout){
	var object = this;
	this.aadhaar_ID = "";
	this.OTP = "";
	this.otpgenerated = false;
	this.loading = false;
	

	this.SubmitDriver = function(){
		
		$http({
			url : "http://172.16.4.56/IRIS_APP/api/AddDriver.php",
			method: "POST",
			data : {
				aadhaar_ID : this.aadhaar_ID,
			}
		}).then(function(data){
			$timeout(function(data){
				console.log(data);
				object.loading = false;
				object.otpgenerated = true;
			},2000)
		},function(err){
			console.log(err);
		});
	}

}

function Traveller($http, $scope){
	this.TravellerName = "";
	this.TravellerEmail = "";

	this.SubmitTraveller = function(){
		console.log(this);
		return;
		$http({
			url : "",
			method: "POST",
			data : {
				TravellerName : this.TravellerName,
				TravellerEmail : this.TravellerEmail
			}
		}).then(function(data){
			console.log(data);
		},function(err){
			console.log(err);
		});
	}
}


function Login($http, $scope){
	this.username ="";
	this.password ="";

	this.SubmitLogin = function(){
	    $http({
	    	url : "",
	    	method : "POST",
	    	data : {
	    		username : this.username,
	    		password : this.password
	    	}
	    }).then(function(data){
			console.log(data);
		},function(err){
			console.log(err);
		});
	}
}