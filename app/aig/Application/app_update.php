<?php

ob_start();
session_start();


require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../../class/Encrypt.php");
require_once("../../../util.php");


$currentdatetime = date("Y").'-'.date("m").'-'.date("d").' '.date("H:i:s");

function CovNum2($Data)
	 {
		return number_format($Data, 2, '.', '');  /// COV 123456.123456 --> 123456.12
	}

$Approved_Date = $_POST["Approved_Date"]; // 19/02/2023 --> 20230219
$Approved_Date = (substr($Approved_Date, 6, 4).substr($Approved_Date, 3, 2).substr($Approved_Date, 0, 2)) ;

$Id = $_POST["id"];
$campaign_id = $_POST['campaign_id'];
$calllist_id = $_POST['calllist_id'];


$TITLE = $_POST['TITLE'];
$FIRSTNAME = $_POST['FIRSTNAME'];
$LASTNAME = $_POST['LASTNAME'];
$SEX = $_POST['SEX'];
$DOB = $_POST['DOB'];
$ADE_AT_RCD = $_POST['ADE_AT_RCD'];
$IDCARD = $_POST['IDCARD'];
$OCCUPATIONAL = $_POST['OCCUPATIONAL'];
$ADDRESSNO1 = $_POST['ADDRESSNO1'];
$BUILDING1 = $_POST['BUILDING1'];
$MOO1 = $_POST['MOO1'];
$SOI1 = $_POST['SOI1'];
$ROAD1 = $_POST['ROAD1'];
$SUB_DISTRICT1 = $_POST['SUB_DISTRICT1'];
$DISTRICT1 = $_POST['DISTRICT1'];
$PROVINCE1 = $_POST['PROVINCE1'];
$ZIPCODE1 = $_POST['ZIPCODE1'];
$TELEPHONE1 = $_POST['TELEPHONE1'];
$MOBILE1 = $_POST['MOBILE1'];
$EMAIL = $_POST['EMAIL'];
$PRODUCT_NAME = $_POST['PRODUCT_NAME'];
$COVERAGE_NAME = $_POST['COVERAGE_NAME'];
$PAYMENTFREQUENCY = $_POST['PAYMENTFREQUENCY'];
$INSTALMENT_PREMIUM = $_POST['INSTALMENT_PREMIUM'];
$INSURED_TITLE2 = $_POST['INSURED_TITLE2'];
$INSURED_NAME2 = $_POST['INSURED_NAME2'];
$INSURED_LASTNAME2 = $_POST['INSURED_LASTNAME2'];
$INSURED_DOB2 = $_POST['INSURED_DOB2'];
$INSURED_RELATIONSHIP2 = $_POST['INSURED_RELATIONSHIP2'];
$INSURED_SEX2 = $_POST['INSURED_SEX2'];
$INSURED_TITLE3 = $_POST['INSURED_TITLE3'];
$INSURED_NAME3 = $_POST['INSURED_NAME3'];
$INSURED_LASTNAME3 = $_POST['INSURED_LASTNAME3'];
$INSURED_DOB3 = $_POST['INSURED_DOB3'];
$INSURED_RELATIONSHIP3 = $_POST['INSURED_RELATIONSHIP3'];
$INSURED_SEX3 = $_POST['INSURED_SEX3'];
$INSURED_TITLE4 = $_POST['INSURED_TITLE4'];
$INSURED_NAME4 = $_POST['INSURED_NAME4'];
$INSURED_LASTNAME4 = $_POST['INSURED_LASTNAME4'];
$INSURED_DOB4 = $_POST['INSURED_DOB4'];
$INSURED_RELATIONSHIP4 = $_POST['INSURED_RELATIONSHIP4'];
$INSURED_SEX4 = $_POST['INSURED_SEX4'];
$INSURED_TITLE5 = $_POST['INSURED_TITLE5'];
$INSURED_NAME5 = $_POST['INSURED_NAME5'];
$INSURED_LASTNAME5 = $_POST['INSURED_LASTNAME5'];
$INSURED_DOB5 = $_POST['INSURED_DOB5'];
$INSURED_RELATIONSHIP5 = $_POST['INSURED_RELATIONSHIP5'];
$INSURED_SEX5 = $_POST['INSURED_SEX5'];
$GIVEN_BENAFICIARY = ($_POST['GIVEN_BENAFICIARY'])?$_POST['GIVEN_BENAFICIARY']:0;
$BENEFICIARY_TITLE1 = $_POST['BENEFICIARY_TITLE1'];
$BENEFICIARY_NAME1 = $_POST['BENEFICIARY_NAME1'];
$BENEFICIARY_LASTNAME1 = $_POST['BENEFICIARY_LASTNAME1'];
$BENEFICIARY_RELATIONSHIP1 = $_POST['BENEFICIARY_RELATIONSHIP1'];
$BENEFICIARY_BENEFIT1 = $_POST['BENEFICIARY_BENEFIT1'];
$BENEFICIARY_SEX1 = $_POST['BENEFICIARY_SEX1'];
$BENEFICIARY_TITLE2 = $_POST['BENEFICIARY_TITLE2'];
$BENEFICIARY_NAME2 = $_POST['BENEFICIARY_NAME2'];
$BENEFICIARY_LASTNAME2 = $_POST['BENEFICIARY_LASTNAME2'];
$BENEFICIARY_RELATIONSHIP2 = $_POST['BENEFICIARY_RELATIONSHIP2'];
$BENEFICIARY_BENEFIT2 = $_POST['BENEFICIARY_BENEFIT2'];
$BENEFICIARY_SEX2 = $_POST['BENEFICIARY_SEX2'];
$BENEFICIARY_TITLE3 = $_POST['BENEFICIARY_TITLE3'];
$BENEFICIARY_NAME3 = $_POST['BENEFICIARY_NAME3'];
$BENEFICIARY_LASTNAME3 = $_POST['BENEFICIARY_LASTNAME3'];
$BENEFICIARY_RELATIONSHIP3 = $_POST['BENEFICIARY_RELATIONSHIP3'];
$BENEFICIARY_BENEFIT3 = $_POST['BENEFICIARY_BENEFIT3'];
$BENEFICIARY_SEX3 = $_POST['BENEFICIARY_SEX3'];
$BENEFICIARY_TITLE4 = $_POST['BENEFICIARY_TITLE4'];
$BENEFICIARY_NAME4 = $_POST['BENEFICIARY_NAME4'];
$BENEFICIARY_LASTNAME4 = $_POST['BENEFICIARY_LASTNAME4'];
$BENEFICIARY_RELATIONSHIP4 = $_POST['BENEFICIARY_RELATIONSHIP4'];
$BENEFICIARY_BENEFIT4 = $_POST['BENEFICIARY_BENEFIT4'];
$BENEFICIARY_SEX4 = $_POST['BENEFICIARY_SEX4'];
$REMARK = $_POST['REMARK'];

$APP_CONSENT = $_POST['APP_CONSENT'];
$FIRST_PAYMENT = ($_POST['FIRST_PAYMENT'])?$_POST['FIRST_PAYMENT']:0;
$ACCOUNT_NAME = $_POST['ACCOUNT_NAME'];
$ACCOUNT_EXPIRE = $_POST['ACCOUNT_EXPIRE'];
$AppStatus = $_POST['AppStatus'];

$payment_key = $_POST['payment_key'];

$OLD_DOB = (isset($_POST['OLD_DOB']))?$_POST['OLD_DOB']:"";
$OLD_IDCARD = (isset($_POST['OLD_IDCARD']))?$_POST['OLD_IDCARD']:"";
$OLD_MOBILE1 = (isset($_POST['OLD_MOBILE1']))?$_POST['OLD_MOBILE1']:"";
$OLD_TELEPHONE1 = (isset($_POST['OLD_TELEPHONE1']))?$_POST['OLD_TELEPHONE1']:"";
$OLD_IN2_DOB = (isset($_POST['OLD_IN2_DOB']))?$_POST['OLD_IN2_DOB']:"";
$OLD_IN3_DOB = (isset($_POST['OLD_IN3_DOB']))?$_POST['OLD_IN3_DOB']:"";
$OLD_IN4_DOB = (isset($_POST['OLD_IN4_DOB']))?$_POST['OLD_IN4_DOB']:"";
$OLD_IN5_DOB = (isset($_POST['OLD_IN5_DOB']))?$_POST['OLD_IN5_DOB']:"";

$SMOKE = ($_POST['SMOKE'])?$_POST['SMOKE']:0;
$INSURED_STATUS = $_POST['INSURED_STATUS'];

$Effective_Date = $_POST['Effective_Date'];
if($Effective_Date == ""){
	$Effective_Date = "NULL";
}
else{
	$Effective_Date = "'$Effective_Date'";
}

$agent_id = $_SESSION["uid"];

 
// check X ใน Mask
if($OLD_DOB && strpos( $DOB, "X" ) !== false){
	$DOB = $OLD_DOB;
}
if($OLD_IDCARD && strpos( $IDCARD, "000000000" ) !== false){
	$IDCARD = $OLD_IDCARD;
}
if($OLD_MOBILE1 && strpos( $MOBILE1, "X" ) !== false){
	$MOBILE1 = $OLD_MOBILE1;
}
if($OLD_TELEPHONE1 && strpos( $TELEPHONE1, "X" ) !== false){
	$TELEPHONE1 = $OLD_TELEPHONE1;
}
if($OLD_IN2_DOB && strpos( $INSURED_DOB2, "X" ) !== false){
	$INSURED_DOB2 = $OLD_IN2_DOB;
}
if($OLD_IN3_DOB && strpos( $INSURED_DOB3, "X" ) !== false){
	$INSURED_DOB3 = $OLD_IN3_DOB;
}
if($OLD_IN4_DOB && strpos( $INSURED_DOB4, "X" ) !== false){
	$INSURED_DOB4 = $OLD_IN4_DOB;
}
if($OLD_IN5_DOB && strpos( $INSURED_DOB5, "X" ) !== false){
	$INSURED_DOB5 = $OLD_IN5_DOB;
}


$IDCARD = Encryption::encrypt($IDCARD);
$MOBILE1 = Encryption::encrypt($MOBILE1);
$TELEPHONE1 = Encryption::encrypt($TELEPHONE1);
$LASTNAME = Encryption::encrypt($LASTNAME);
$DOB = Encryption::encrypt($DOB);

/*update history*/
$SQL_history = "INSERT INTO t_aig_app_history ( AppID, AppStatus, remark, update_by )
				VALUES('$Id', '$AppStatus' , '$REMARK' , '$agent_id' )" ;
				mysqli_query($Conn, $SQL_history) ;


 /*Insert YersFile*/
$SQL_YesFile = "update t_aig_app set

TITLE = '$TITLE',
FIRSTNAME = '$FIRSTNAME',
LASTNAME = '$LASTNAME',
SEX = '$SEX',
DOB = '$DOB',
ADE_AT_RCD = '$ADE_AT_RCD',
IDCARD = '$IDCARD',
OCCUPATIONAL = '$OCCUPATIONAL',
ADDRESSNO1 = '$ADDRESSNO1',
BUILDING1 = '$BUILDING1',
MOO1 = '$MOO1',
SOI1 = '$SOI1',
ROAD1 = '$ROAD1',
SUB_DISTRICT1 = '$SUB_DISTRICT1',
DISTRICT1 = '$DISTRICT1',
PROVINCE1 = '$PROVINCE1',
ZIPCODE1 = '$ZIPCODE1',
TELEPHONE1 = '$TELEPHONE1',
MOBILE1 = '$MOBILE1',
PRODUCT_NAME = '$PRODUCT_NAME',
COVERAGE_NAME = '$COVERAGE_NAME',
PAYMENTFREQUENCY = '$PAYMENTFREQUENCY',
INSTALMENT_PREMIUM = '$INSTALMENT_PREMIUM',
INSURED_TITLE2 = '$INSURED_TITLE2',
INSURED_NAME2 = '$INSURED_NAME2',
INSURED_LASTNAME2 = '$INSURED_LASTNAME2',
INSURED_DOB2 = '$INSURED_DOB2',
INSURED_RELATIONSHIP2 = '$INSURED_RELATIONSHIP2',
INSURED_SEX2 = '$INSURED_SEX2',
INSURED_TITLE3 = '$INSURED_TITLE3',
INSURED_NAME3 = '$INSURED_NAME3',
INSURED_LASTNAME3 = '$INSURED_LASTNAME3',
INSURED_DOB3 = '$INSURED_DOB3',
INSURED_RELATIONSHIP3 = '$INSURED_RELATIONSHIP3',
INSURED_SEX3 = '$INSURED_SEX3',
INSURED_TITLE4 = '$INSURED_TITLE4',
INSURED_NAME4 = '$INSURED_NAME4',
INSURED_LASTNAME4 = '$INSURED_LASTNAME4',
INSURED_DOB4 = '$INSURED_DOB4',
INSURED_RELATIONSHIP4 = '$INSURED_RELATIONSHIP4',
INSURED_SEX4 = '$INSURED_SEX4',
INSURED_TITLE5 = '$INSURED_TITLE5',
INSURED_NAME5 = '$INSURED_NAME5',
INSURED_LASTNAME5 = '$INSURED_LASTNAME5',
INSURED_DOB5 = '$INSURED_DOB5',
INSURED_RELATIONSHIP5 = '$INSURED_RELATIONSHIP5',
INSURED_SEX5 = '$INSURED_SEX5',
GIVEN_BENAFICIARY = $GIVEN_BENAFICIARY,
BENEFICIARY_TITLE1 = '$BENEFICIARY_TITLE1',
BENEFICIARY_NAME1 = '$BENEFICIARY_NAME1',
EMAIL = '$EMAIL',
BENEFICIARY_LASTNAME1 = '$BENEFICIARY_LASTNAME1',
BENEFICIARY_RELATIONSHIP1 = '$BENEFICIARY_RELATIONSHIP1',
BENEFICIARY_BENEFIT1 = '$BENEFICIARY_BENEFIT1',
BENEFICIARY_SEX1 = '$BENEFICIARY_SEX1',
BENEFICIARY_TITLE2 = '$BENEFICIARY_TITLE2',
BENEFICIARY_NAME2 = '$BENEFICIARY_NAME2',
BENEFICIARY_LASTNAME2 = '$BENEFICIARY_LASTNAME2',
BENEFICIARY_RELATIONSHIP2 = '$BENEFICIARY_RELATIONSHIP2',
BENEFICIARY_BENEFIT2 = '$BENEFICIARY_BENEFIT2',
BENEFICIARY_SEX2 = '$BENEFICIARY_SEX2',
BENEFICIARY_TITLE3 = '$BENEFICIARY_TITLE3',
BENEFICIARY_NAME3 = '$BENEFICIARY_NAME3',
BENEFICIARY_LASTNAME3 = '$BENEFICIARY_LASTNAME3',
BENEFICIARY_RELATIONSHIP3 = '$BENEFICIARY_RELATIONSHIP3',
BENEFICIARY_BENEFIT3 = '$BENEFICIARY_BENEFIT3',
BENEFICIARY_SEX3 = '$BENEFICIARY_SEX3',
BENEFICIARY_TITLE4 = '$BENEFICIARY_TITLE4',
BENEFICIARY_NAME4 = '$BENEFICIARY_NAME4',
BENEFICIARY_LASTNAME4 = '$BENEFICIARY_LASTNAME4',
BENEFICIARY_RELATIONSHIP4 = '$BENEFICIARY_RELATIONSHIP4',
BENEFICIARY_BENEFIT4 = '$BENEFICIARY_BENEFIT4',
BENEFICIARY_SEX4 = '$BENEFICIARY_SEX4',
REMARK = '$REMARK',
APP_CONSENT = '$APP_CONSENT',
FIRST_PAYMENT = $FIRST_PAYMENT,
ACCOUNT_NAME = '$ACCOUNT_NAME',
ACCOUNT_EXPIRE = '$ACCOUNT_EXPIRE',
Approved_Date = '$Approved_Date',
AppStatus = '$AppStatus',

payment_key = '$payment_key',

update_by = '$agent_id',
update_date = '$currentdatetime',

smoke = '$SMOKE',
insured_status = '$INSURED_STATUS',
effective_date = $Effective_Date

where id = '$Id' ";


if(mysqli_query($Conn, $SQL_YesFile))
{	
	if(in_array($AppStatus, array("QC_Reject","Reconfirm","Reconfirm-App"))) {
		$sql = " UPDATE t_calllist_agent SET " .
			" last_wrapup_option_id = " . dbNumberFormat("9") . "," .
			" status = " . dbNumberFormat("1") . "," .
			" last_wrapup_dt = NOW()" .
			" WHERE campaign_id =  " . dbNumberFormat($campaign_id) . " " .
			" AND calllist_id = " . dbNumberFormat($calllist_id) . " ";
		mysqli_query($Conn, $sql);
	}
	if(in_array($AppStatus, array("Submit","Re-submit","Approve"))) {
		$sql = " UPDATE t_calllist_agent SET " .
			" last_wrapup_option_id = " . dbNumberFormat("6") . "," .
			" status = " . dbNumberFormat("1") . "," .
			" last_wrapup_dt = NOW()" .
			" WHERE campaign_id =  " . dbNumberFormat($campaign_id) . " " .
			" AND calllist_id = " . dbNumberFormat($calllist_id) . " ";
		mysqli_query($Conn, $sql);

		$sql_effective_date1 = "UPDATE t_aig_app SET effective_date = DATE(create_date) + INTERVAL 1 DAY WHERE id='$Id' AND effective_date IS NULL AND create_date IS NOT NULL";
		mysqli_query($Conn, $sql_effective_date1);
	}
	if($AppStatus == "Submit") {
		$sql_effective_date = "UPDATE t_aig_app SET effective_date = CURDATE() + INTERVAL 1 DAY WHERE id='$Id' AND create_date IS NULL";
		mysqli_query($Conn, $sql_effective_date);

		$sql = "UPDATE t_aig_app SET create_date = NOW() WHERE id='$Id' AND create_date IS NULL";
		mysqli_query($Conn, $sql);
	}
	
	$data = array("result"=>"success","data"=>"Save Complete.", "url"=>"check_app.php?id=$Id");

}
else
{
	$data = array("result"=>false,"data"=>"Please contact IT.");
}
echo json_encode( $data ); 
//echo ($SQL_YesFile);
?>
