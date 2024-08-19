<?php
//config Server
$ServerName = "localhost";
$DatabaseName = "tubtim";
$User = "tubtim";
$Password = "tubtim1234";

$ServerName2 = "192.168.8.251";
$DatabaseName2 = "asteriskcdrdb";
$User2 = "cms";
$Password2 = "cms";


$Conn = mysqli_connect($ServerName, $User, $Password, true); 
$Conn2 = mysqli_connect($ServerName2, $User2, $Password2);


mysqli_select_db($Conn, 'tubtim');
mysqli_select_db($Conn2, 'asteriskcdrdb');


$cs1 = "SET character_set_results=utf8";
mysqli_query($Conn,$cs1) or die('Error query: ' . mysqli_error());

$cs2 = "SET character_set_client = utf8";
mysqli_query($Conn,$cs2) or die('Error query: ' . mysqli_error());

$cs3 = "SET character_set_connection = utf8";
mysqli_query($Conn,$cs3) or die('Error query: ' . mysqli_error());

error_reporting(E_ALL & ~E_NOTICE);
?>
