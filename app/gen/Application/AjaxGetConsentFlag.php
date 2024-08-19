<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE);

include("../../function/StartConnect.inc");

$currenttime = date("Hi");
$currentdate = date("Y").date("m").date("d");

$ConsentFlag = $_GET['ConsentFlag'];
$ProposalNumber = $_GET['ProposalNumber'];



$SQL = " update t_app set  Consent_Flag = '$ConsentFlag', Consent_Date = '$currentdate' , Consent_Time = '$currenttime' where ProposalNumber = '$ProposalNumber'  ";
$result = mysql_query($SQL);
		while($objResult = mysql_fetch_array($result))
		{
			//$premium_payment = $objResult["premium_payment"] ;
		}

//echo $payment ;
//echo $premium_payment ;

?>
