<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE);

include("../../function/StartConnect.inc");

$payment = $_GET['payment'];
$plan = $_GET['plan'];

if($plan == '600000.00'){
	$premium = '4188.00';
}elseif($plan == '1200000.00'){
	$premium = '6646.00';
}elseif($plan == '1800000.00'){
	$premium = '9747.00';
}elseif($plan == '2400000.00'){
	$premium = '12051.00';
}elseif($plan == '3000000.00'){
	$premium = '14233.00';
}elseif($plan == '3600000.00'){
	$premium = '15873.00';
}


echo $premium ;

?>
