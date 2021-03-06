<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Dashboard</title>

    <!-- Bootstrap -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 <link href="css/stylesheet.css" rel="stylesheet">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->

<script
  src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.20/angular.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body ng-app="Logout" ng-controller="LogoutCtrl">
  <div class="container">
  <div class="jumbotron">
    <h1>Dashboard</h1>
    <p>Success!You are logged  into your account!</p>
  </div>
  <button ng-click="logout()" type="button" class="btn btn-danger">Logout</button>
  
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script>
  	var Logout = angular.module("Logout",[])
				.config(['$httpProvider', function($httpProvider) {
  					$httpProvider.defaults.withCredentials = true;
				}]);
  	
  	Logout.controller('LogoutCtrl',function($http, $scope, $window){
  		$scope.logout = function(){
  			$http({
  				url : "https://auth.death39.hasura-app.io/user/logout",
  				method : "GET"
  			}).then(function(data){
  				console.log(data);
  				$window.location.href = "index.html";
  			});
  		}
  	});
  </script>
</body>
  
  </body>
</html>