<?php

    header('Content-Type: *');
    header("Access-Control-Allow-Origin: *");

include_once('Objects/functions.php');
include_once('Objects/Driver.php');


$_POST = json_decode(file_get_contents("php://input"));

echo json_encode($_POST);

?>