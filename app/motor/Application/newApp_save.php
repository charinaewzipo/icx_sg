<?php

ob_start();
//session_start();


include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

$app_yy_mm = date("ym"); 

$campaign_id = $_POST["campaign_id"];
$calllist_id = $_POST["calllist_id"];
$agent_id = $_POST["agent_id"];
$import_id = $_POST["import_id"];
$team_id = $_POST["team_id"];

$package_id_1 = $_POST["insure"][0];
$package_id_2 = $_POST["insure"][1];
$package_id_3 = $_POST["insure"][2];

$app_run_no = mysql_result(mysql_query("Select Max(app_run_no)+1 as MaxID from t_motor_app where app_yy_mm = '$app_yy_mm'  "),0,"MaxID");
if($app_run_no == ''){
	$app_run_no = '1';
}

$SequenceNo = sprintf("%05d",$app_run_no);
$app_number = 'APP'.$app_yy_mm.$SequenceNo;


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

$remark = $_POST["remark"];
$AppStatus = $_POST["AppStatus"];
$create_date = $_POST["create_date"];
$create_time = $_POST["create_time"];

$policy_type = $_POST["policy_type"];
$disc_premium1 = $_POST["disc_premium1"];
$total_premium1 = $_POST["total_premium1"];
$disc_premium2 = $_POST["disc_premium2"];
$total_premium2 = $_POST["total_premium2"];

$car_code = $_POST["car_type_s"];
$insurer_premium2 = $_POST["insurer_premium2"];
$policy_no2 = $_POST["policy_no2"];
$policy_effective2 = $_POST["policy_effective2"];




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
$SQL_APP = "INSERT INTO t_motor_app ( app_run_no , app_yy_mm , app_number , issue_no , Title , Firstname , Lastname , car_license , body_no , engine_no , car_regit_year , car_brand , car_model , car_year , car_engine , car_cover , 
AddressNo1 , building1 , Moo1 , Soi1 , Road1 , Sub_district1 , district1 , province1 , zipcode1  ,telephone1  ,Mobile1 ,AddressNo3 ,building3 ,Moo3 ,Soi3 ,Road3 ,Sub_district3 ,district3 ,province3 ,zipcode3 ,telephone3 ,
Mobile3 , insurer , insure_type , insure_cover_type , effective_date ,expire_date , premium1 , premium2 , free_premium2 , payment_type , pay_by_installments , AccountNo , Bank , AccountType , ExpiryDate , 
package_id_1 , package_id_2 , package_id_3, policy_type, disc_premium1, total_premium1, disc_premium2, total_premium2 , car_code, insurer_premium2, policy_no2, policy_effective2,

remark, AppStatus , campaign_id , calllist_id , agent_id , import_id , team_id, create_date, create_time  )

 VALUES('$app_run_no' , '$app_yy_mm' , '$app_number' , '$issue_no' , '$Title' , '$Firstname' , '$Lastname' , '$car_license' , '$body_no' , '$engine_no' , '$car_regit_year' , '$car_brand' , '$car_model' , '$car_year' , '$car_engine' , '$car_cover' , 
 '$AddressNo1' , '$building1' , '$Moo1' , '$Soi1' , '$Road1' , '$Sub_district1' , '$district1' , '$province1' , '$zipcode1'  , '$telephone1'  ,'$Mobile1'  ,'$AddressNo3' ,'$building3' ,'$Moo3' ,'$Soi3' ,'$Road3' ,'$Sub_district3' ,'$district3' ,'$province3' ,'$zipcode3' ,'$telephone3',
 '$Mobile3' ,'$insurer' ,'$insure_type' ,'$insure_cover_type' ,'$effective_date' ,'$expire_date ' ,'$premium1' ,'$premium2' ,'$free_premium2' ,'$payment_type' ,'$pay_by_installments' ,'$AccountNo' ,'$Bank' ,'$AccountType' ,'$ExpiryDate' ,
 '$package_id_1' , '$package_id_2' , '$package_id_3', '$policy_type' , '$disc_premium1' , '$total_premium1' , '$disc_premium2' , '$total_premium2' ,  '$car_code' , '$insurer_premium2' , '$policy_no2', '$policy_effective2' ,
 
'$remark', '$AppStatus'  , '$campaign_id' , '$calllist_id' , '$agent_id' , '$import_id' , '$team_id' , '$create_date' , '$create_time' )" ;

if(mysql_query($SQL_APP,$Conn))
{

	echo "<script>alert('Save Complete.');window.location='appDetail.php?Id=$app_number';</script>";


}else{
	
	echo $SQL_APP ;
}

?>
