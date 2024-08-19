<?php

ob_start();
session_start();


include("../../function/StartConnect.inc");
include("../../function/currentDateTime.inc");

function CovNum2($Data)
	 {
		return number_format($Data, 2, '.', '');  /// COV 123456.123456 --> 123456.12
	}


$app_number = $_POST["app_number"];

$insure_select = $_POST["insure_select"];

$package_id_1 = $_POST["insure"][0];
$package_id_2 = $_POST["insure"][1];
$package_id_3 = $_POST["insure"][2];

$issue_no = $_POST["issue_no"];
$Title = $_POST["Title"];
$Firstname = $_POST["Firstname"];
$Lastname = $_POST["Lastname"];
$car_license = $_POST["car_license"];
$body_no = $_POST["body_no"];
$engine_no = $_POST["engine_no"];
$car_regit_year = $_POST["car_regit_year"];
$car_brand = $_POST["car_brand"];
$car_model = $_POST["car_model"];
$car_year = $_POST["car_year"];
$car_engine = $_POST["car_engine"];
$car_cover = $_POST["car_cover"];

$AddressNo1 = $_POST["AddressNo1"];
$building1 = $_POST["building1"];
$Moo1 = $_POST["Moo1"];
$Soi1 = $_POST["Soi1"];
$Road1 = $_POST["Road1"];
$Sub_district1 = $_POST["Sub_district1"];
$district1 = $_POST["district1"];
$province1 = $_POST["province1"];
$zipcode1 = $_POST["zipcode1"];
$telephone1 = $_POST["telephone1"];
$Mobile1 = $_POST["Mobile1"];

$AddressNo3 = $_POST["AddressNo3"];
$building3 = $_POST["building3"];
$Moo3 = $_POST["Moo3"];
$Soi3 = $_POST["Soi3"];
$Road3 = $_POST["Road3"];
$Sub_district3 = $_POST["Sub_district3"];
$district3 = $_POST["district3"];
$province3 = $_POST["province3"];
$zipcode3 = $_POST["zipcode3"];
$telephone3 = $_POST["telephone3"];
$Mobile3 = $_POST["Mobile3"];

$insurer = $_POST["insurer"];
$insure_type = $_POST["insure_type"];
$insure_cover_type = $_POST["insure_cover_type"];
$effective_date = $_POST["effective_date"];
$expire_date = $_POST["expire_date"];
$premium1 = $_POST["premium1"];
$premium2 = $_POST["premium2"];
$free_premium2 = $_POST["free_premium2"];
$payment_type = $_POST["payment_type"] ;
$pay_by_installments = $_POST["pay_by_installments"];
$AccountNo = $_POST["AccountNo"];
$Bank = $_POST["bank"];
$AccountType = $_POST["AccountType"];
$ExpiryDate = $_POST["ExpiryDate"];

$free_premium2 = $_POST["free_premium2"];

$policy_type = $_POST["policy_type"];
$insurer_premium2 = $_POST["insurer_premium2"];

$refund = $_POST["refund"];
$refund_date = $_POST["refund_date"];

$remark = $_POST["remark"];
$AppStatus = $_POST["AppStatus"];

$policy_no = $_POST["policy_no"];

$policy_no2 = $_POST["policy_no2"];
$policy_effective2 = $_POST["policy_effective2"];

$agent_id = $_SESSION["uid"];

/*update history*/

/*echo $SequenceNo;*/
if($package_id_1 != ''){
					$SQL_pk1 = "INSERT INTO t_motor_map_package ( app_number, package_id, create_date, create_time, create_by )
					 VALUES('$app_number', '$package_id_1' , '$agent_id' , '$currentdate_app' , '$currenttime_app' )" ;
					 mysql_query($SQL_pk1,$Conn) ;
}

if($package_id_2 != ''){
					$SQL_pk2 = "INSERT INTO t_motor_map_package ( app_number, package_id, create_date, create_time, create_by )
					 VALUES('$app_number', '$package_id_2' , '$agent_id' , '$currentdate_app' , '$currenttime_app' )" ;
					 mysql_query($SQL_pk2,$Conn) ;
}

if($package_id_3 != ''){
					$SQL_pk3 = "INSERT INTO t_motor_map_package ( app_number, package_id, create_date, create_time, create_by )
					 VALUES('$app_number', '$package_id_3' , '$agent_id' , '$currentdate_app' , '$currenttime_app' )" ;
					 mysql_query($SQL_pk3,$Conn) ;
}


 /*Insert YersFile*/
$SQL_YesFile = "update t_motor_app  set
policy_no = '$policy_no',
remark = '$remark',
Title = '$Title',
Firstname = '$Firstname',
Lastname = '$Lastname',
car_license = '$car_license',
body_no = '$body_no',
engine_no = '$engine_no',
car_regit_year = '$car_regit_year',
car_brand = '$car_brand',
car_model = '$car_model',
car_year = '$car_year',
car_engine = '$car_engine',
car_cover = '$car_cover',
AddressNo1 = '$AddressNo1',
building1 = '$building1',
Moo1 = '$Moo1',
Soi1 = '$Soi1',
Road1 = '$Road1',
Sub_district1 = '$Sub_district1',
district1 = '$district1',
province1 = '$province1',
zipcode1 = '$zipcode1',
telephone1 = '$telephone1',
Mobile1 = '$Mobile1',
AddressNo3 = '$AddressNo3',
building3 = '$building3',
Moo3 = '$Moo3',
Soi3 = '$Soi3',
Road3 = '$Road3',
Sub_district3 = '$Sub_district3',
district3 = '$district3',
province3 = '$province3',
zipcode3 = '$zipcode3',
telephone3 = '$telephone3',
Mobile3 = '$Mobile3',
insurer = '$insurer',
insure_type = '$insure_type',
insure_cover_type = '$insure_cover_type',
effective_date = '$effective_date',
expire_date = '$expire_date',
premium1 = '$premium1',
premium2 = '$premium2',
free_premium2 = '$free_premium2',
payment_type = '$payment_type',
pay_by_installments = '$pay_by_installments',
AccountNo = '$AccountNo',
Bank = '$Bank',
AccountType = '$AccountType',
ExpiryDate = '$ExpiryDate',
insure_select = '$insure_select',
free_premium2 = '$free_premium2',
policy_type = '$policy_type',

insurer_premium2 = '$insurer_premium2',
policy_no2 = '$policy_no2',
policy_effective2 = '$policy_effective2',

remark = '$remark',
issue_no = '$issue_no',
refund = '$refund',
refund_date = '$refund_date',
AppStatus = '$AppStatus'

where app_number = '$app_number' ";

if(mysql_query($SQL_YesFile,$Conn))
{

		
		$SQL_report = "update t_motor_installment_report  set remark = '$AppStatus'  where app_number = '$app_number'   " ;
		if(mysql_query($SQL_report,$Conn))
		{
				echo "<script>alert('Save Complete.');window.location='appDetail.php?Id=$app_number';</script>";
		}
	
	}
else
{
	echo $SQL_YesFile ;
}

?>
