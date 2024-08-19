<?php

//config Server
$ServerName = "192.168.8.250";
$DatabaseName = "tubtim";
$User = "tubtim";
$Password = "tubtim1234";

//$ServerName = "10.10.10.253";
//$DatabaseName = "tubtim";
//$User = "tubtim";
//$Password = "tubtim2012";


$Conn = mysql_connect($ServerName,$User,$Password) or die ("Error ติดต่อฐานข้อมูลไม่ได้");


mysql_select_db($DatabaseName,$Conn) or die ("Error ติดต่อฐานข้อมูลไม่ได้");

$cs1 = "SET character_set_results=utf8";
mysql_query($cs1) or die('Error query: ' . mysql_error());

$cs2 = "SET character_set_client = utf8";
mysql_query($cs2) or die('Error query: ' . mysql_error());

$cs3 = "SET character_set_connection = utf8";
mysql_query($cs3) or die('Error query: ' . mysql_error());

error_reporting(E_ALL & ~E_NOTICE);
?>