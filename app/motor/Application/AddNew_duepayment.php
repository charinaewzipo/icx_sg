<?php

ob_start();
session_start();
include("../../function/StartConnect.inc");
include("../../function/currentDateTime.inc");

$app_number = $_POST["app_number"];

$insurer = $_POST["insurer"];

$payment_no = $_POST["payment_no"];
$payment_due = $_POST["payment_due"];
$due_date = $_POST["due_date"];

$Firstname = $_POST["Firstname"];
$Lastname = $_POST["Lastname"];

$agent_id = $_SESSION["uid"];

$calllist_id = $_POST["calllist_id"];

$customer_name = $Firstname.' '.$Lastname;

//$Beneficiary_No = mysql_result(mysql_query("Select Max(Beneficiary_No)+1 as MaxID from app_mt where SequenceNo = '$SequenceNo'"),0,"MaxID");

//$Beneficiary_No_app_detail = mysql_result(mysql_query("Select Max(Benefit_no)+1 as MaxID from app_mt_detail where cXrefNo = '$cXrefNo'"),0,"MaxID");


/*echo $SequenceNo;*/
 
 /*Insert YersFile*/
$SQL = "INSERT INTO t_motor_installment ( app_number , insurer, payment_no, payment_due, due_date, customer_name, insert_by, insert_date )

 VALUES( '$app_number' , '$insurer' , '$payment_no'  , '$payment_due' , '$due_date' , '$customer_name', '$agent_id' , '$currentdate_DCR2' )" ;
 
if(mysql_query($SQL,$Conn))
{
	
	
		echo "<script>alert('Save Complete.');window.location='appDetail.php?Id=$app_number';</script>"; 
		//$_SESSION["mess"] = "บันทึกข้อมูลสำเร็จ"; 
		//header("Location: ../search.php");		

	
}
else
{
	echo $SQL; 

}
?>
