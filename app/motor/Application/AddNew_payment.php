<?php

ob_start();
session_start();
include("../../function/StartConnect.inc");
include("../../function/currentDateTime.inc");


$app_number = $_POST["app_number"];
$policy_no = $_POST["policy_no"];
$payment_no = $_POST["payment_no"];
$due_date = $_POST["due_date"];

$Firstname = $_POST["Firstname"];
$Lastname = $_POST["Lastname"];


$customer_name = $Firstname.' '.$Lastname;
$trans_id = $_POST["payment_id"];

$payment_id = $_POST["payment_id"];

$app_number = $_POST["app_number"];
$insurer = $_POST["insurer"];

$payment_by = $_POST["payment_by"];
$payment_company = $_POST["payment_company"];
$payment_account = $_POST["payment_account"];

$insure_type = $_POST["insure_type"];
$premium1 = $_POST["premium1"];
$premium2 = $_POST["premium2"];
$disc_premium1 = $_POST["disc_premium1"];
$total_premium1 = $_POST["total_premium1"];
$disc_premium2 = $_POST["disc_premium2"];
$total_premium2 = $_POST["total_premium2"];
$insurer_premium2 = $_POST["insurer_premium2"];
$effective_date = $_POST["effective_date"];

$pay_by_installments = $_POST["pay_by_installments"];

$installment = $_POST["installment"];
$payment_date = $_POST["payment_date"];
$payment_time = $_POST["payment_time"];

$agent_id = $_SESSION["uid"];

									$strSQL = "SELECT * FROM t_motor_installment where id = '$payment_id' ";
                                    $objQuery = mysql_query($strSQL);
                                    while($objResuut = mysql_fetch_array($objQuery))
                                    {			
										$payment_due = $objResuut["payment_due"];
										$due_date = $objResuut["due_date"];
										$payment_no = $objResuut["payment_no"];
									}

//$Beneficiary_No = mysql_result(mysql_query("Select Max(Beneficiary_No)+1 as MaxID from app_mt where SequenceNo = '$SequenceNo'"),0,"MaxID");
//$Beneficiary_No_app_detail = mysql_result(mysql_query("Select Max(Benefit_no)+1 as MaxID from app_mt_detail where cXrefNo = '$cXrefNo'"),0,"MaxID");


/*echo $SequenceNo;*/
 
 /*Insert YersFile*/
$SQL = "update t_motor_installment  set

installment = '$installment',
policy_no = '$policy_no',
payment_by = '$payment_by',
payment_company = '$payment_company',
payment_account = '$payment_account',
payment_date = '$payment_date',
payment_time = '$payment_time',
update_by = '$agent_id',
update_date = '$currentdate_DCR2'

where id = '$payment_id' ";
 
if(mysql_query($SQL,$Conn))
{
	$SQL2 = "INSERT INTO t_motor_installment_report ( trans_id, app_number , insurer, payment_no, payment_due, due_date, customer_name, installment, payment_by, payment_company , payment_account , payment_date, payment_time, policy_no, insure_type, premium1, premium2, disc_premium1 , total_premium1, disc_premium2, total_premium2 , insurer_premium2 , effective_date, payment_term
	
 , update_by , update_date , insert_by, insert_date )

 		VALUES('$trans_id', '$app_number' , '$insurer' , '$payment_no'  , '$payment_due' , '$due_date' , '$customer_name', '$installment' , '$payment_by' , '$payment_company' , '$payment_account' , '$payment_date' , '$payment_time'  , '$policy_no' , '$insure_type' , '$premium1' , '$premium2' , '$disc_premium1' , '$total_premium1' , '$disc_premium2' , '$total_premium2' , '$insurer_premium2' , '$effective_date' , '$pay_by_installments'
	 , '$update_by' , '$update_date' , '$agent_id' , '$currentdate_DCR2' )" ;
		
	
 
		if(mysql_query($SQL2,$Conn))
		{
		echo "<script>alert('Save Complete.');window.location='appDetail.php?Id=$app_number';</script>"; 
		//$_SESSION["mess"] = "บันทึกข้อมูลสำเร็จ"; 
		//header("Location: ../search.php");		
		}else{
			echo $SQL2; 
		}

	
}
else
{
	echo $SQL; 

}
?>
