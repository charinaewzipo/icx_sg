<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE);

include("../../function/StartConnect.inc");

$payment = $_GET['payment'];
$plan = $_GET['plan'];

if($payment == 'รายเดือน'){
	$payment = 'M' ;
}else{
	$payment = 'Y' ;
}

$SQL = "select premium_payment from t_gen_exclusive where sum_insure = '$plan' and payment_type = '$payment' ";
$result = mysql_query($SQL);
		while($objResult = mysql_fetch_array($result))
		{
			$premium_payment = $objResult["premium_payment"] ;
		}

//echo $payment ;
echo $premium_payment ;

?>
