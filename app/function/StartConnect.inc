<?php

//Database 
$ServerName = "195.179.239.102";
$DatabaseName = "u297918512_icx_sg";
$User = "u297918512_root";
$Password = '3Y:zMKKe>8';

$ServerName2 = "icxpoc-db2.clce66q2ulno.ap-southeast-1.rds.amazonaws.com";
$DatabaseName2 = "tubtim20240906";
$User2 = "arkuser";
$Password2 = '$ep2@24ICX';


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
