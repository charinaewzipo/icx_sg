<?php
//config Server
$ServerName = "localhost";
$DatabaseName = "tubtim";
$User = "root";
$Password = "";

$ServerName2 = "192.168.50.2";
$DatabaseName2 = "tubtim";
$User2 = "tubtim";
$Password2 = "yOD6M0A0X0gz";


$Conn = mysqli_connect($ServerName,$User,$Password) or die ("Error เธ•เธดเธ”เธ•เนเธญเธเธฒเธเธเนเธญเธกเธนเธฅเนเธกเนเนเธ”เน");
mysqli_select_db($Conn,$DatabaseName) or die ("Error เธ•เธดเธ”เธ•เนเธญเธเธฒเธเธเนเธญเธกเธนเธฅเนเธกเนเนเธ”เน");


$cs1 = "SET character_set_results=utf8";
mysqli_query($Conn,$cs1) or die('Error query: ' . mysqli_error());

$cs2 = "SET character_set_client = utf8";
mysqli_query($Conn,$cs2) or die('Error query: ' . mysqli_error());

$cs3 = "SET character_set_connection = utf8";
mysqli_query($Conn,$cs3) or die('Error query: ' . mysqli_error());

error_reporting(E_ALL & ~E_NOTICE);
?>
