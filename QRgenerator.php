<?php

include_once('api/Objects/functions.php');
include_once('api/Objects/Driver.php');
include_once('includes/phpqrcode/phpqrcode.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>QR Code Generator</title>

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
  <body>
 	<?php
 	

	$Driver = new Driver();
	$Driver->AadharId = $_SESSION['aadhar_Id'];
	
	$DriverDetails = $Driver->getDriver();
	

 	
 	?>
   <div class="jumbotron">
 
  <div class="panel panel-default">
    <div class="panel-body" style="text-align: center">
    	<?php
     		QRcode::png("http://188.166.212.28/IRIS_APP/user.php?ai=".$Driver->AadharId, "images/".$Driver->AadharId.".png");    	
    	?>
    	<img style="width: 200px" src="images/<?php echo $Driver->AadharId ?>.png" />
    	<h1><?php echo $DriverDetails[0]['name'] ?></h1>
    </div>
</div>

 
</div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
  </body>
</html>