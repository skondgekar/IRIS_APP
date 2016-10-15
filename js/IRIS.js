var IRIS_APP = angular.module("IRIS_APP",[])
				.config(['$httpProvider', function($httpProvider) {
  					$httpProvider.defaults.withCredentials = true;
				}])

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
	this.Messages = [];
	this.Errors = [];
	this.RegistrationSuccessfull = false;
	this.pincode =[];

	this.SubmitDriver = function(){
		
		if(this.otpgenerated){
			this.getKYC();
			return;
		}
		
		this.loading = true;
		this.otpgenerated = false;
		this.Messages = [];
		this.Errors = [];
		$http({
			url : "http://172.16.4.56/IRIS_APP/api/AddDriver.php",
			method: "POST",
			data : {
				aadhaar_ID : this.aadhaar_ID,
			}
		}).then(function(data){
			$timeout(function(){
				console.log(data);
				if(data.data.Errors){
					object.Errors = data.data.Errors;
				}
				object.loading = false;
				
				if(data.data.Errors){
					if(data.data.Errors.length == 0){
						object.otpgenerated = true;
					}
				}
				object.Messages = data.data.message;
			},2000)
		},function(err){
			console.log(err);
		});
	}

	this.getKYC = function(){
		this.loading = true;
		this.Messages = [];
		this.Errors = [];
		$http({
			url : "http://172.16.4.56/IRIS_APP/api/getKYC.php",
			method: "POST",
			data : {
				aadhaar_ID : this.aadhaar_ID,
				OTP : this.OTP
			}
		}).then(function(data){
			object.loading = false;
			console.log(data);
			if(data.data.success){
				object.RegistrationSuccessfull = true;
				object.Messages.push("Your registration is successfull");
				return;
			}
			object.Errors.push(data);
			
		},function(err){
			console.log(err);
		});
	}

}

function Traveller($http, $scope){
	this.TravellerName = "";
	this.TravellerEmail = "";
	this.TravellerPass = "";

	this.SubmitTraveller = function(){
		console.log('here', this);
		var t = this;
		$http({
			url : "https://auth.death39.hasura-app.io/signup",
			method: "POST",
			data : {
				username : this.TravellerEmail,
				email : this.TravellerEmail,
				password: this.TravellerPass
			}
		}).then(function(data){
			console.log(data);
			var userId = data.data.hasura_id;
			
			$http({
				url : "https://data.death39.hasura-app.io/v1/query",
				method: "POST",
				data : {
					type: "insert",
					args: {
						table : "user",
	    				returning: ["user_id"],
					    objects: [{
					      "user_id" : userId,
					      "name" : t.TravellerName,
					      "email" : t.TravellerEmail
					    }]
					}
				}
			}).then(function(data) {
				console.log(data);
			}, function(err) {
				console.log(err);
			});
		},function(err){
			console.log(err);
		});
	}
}


function Login($http, $scope){
	this.username ="";
	this.password ="";

	this.SubmitLogin = function(){
	    console.log('here', this);
		var t = this;
		$http({
			url : "https://auth.death39.hasura-app.io/login",
			method: "POST",
			data : {
				username : this.email,
				password : this.password,
			}
		}).then(function(data){
			console.log(data);
			var userId = data.data.hasura_id;
			
			$http({
				url : "https://data.death39.hasura-app.io/v1/query",
				method: "POST",
				data : {
					type: "insert",
					args: {
						table : "user",
	    				returning: ["user_id"],
					    objects: [{
					     "username" : t.email,
					      "password" : t.password
					    }]
					}
				}
			}).then(function(data) {
				console.log(data);
			}, function(err) {
				console.log(err);
			});
		},function(err){
			console.log(err);
		});
	}
}