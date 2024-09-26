<?php

ob_start();
//session_start();


require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../../class/Encrypt.php");


$currentdatetime = date("Y").'-'.date("m").'-'.date("d").' '.date("H:i:s");

function CovNum2($Data)
	 {
		return number_format($Data, 2, '.', '');  /// COV 123456.123456 --> 123456.12
	}

$campaign_id = $_POST["campaign_id"];
$calllist_id = $_POST["calllist_id"];
$agent_id = $_POST["agent_id"];
$import_id = $_POST["import_id"];
$team_id = $_POST["team_id"]; 

// Campaign ID URL
// if($campaign_id == '1'){
// 	$camp_url = 'appDetail.php';
// }elseif($campaign_id == '2'){
// 	$camp_url = 'appDetailD2C.php';
// }elseif($campaign_id == ''){
// 	$camp_url = 'appDetailD2C.php';
// }

//$CountApp = mysqli_result(mysqli_query($Conn, "SELECT COUNT(id) AS CountApp FROM t_aig_app WHERE calllist_id = '$calllist_id' AND campaign_id = '$campaign_id '"),0,"CountApp");

$query = "SELECT COUNT(id) AS CountApp FROM t_aig_app WHERE calllist_id = '$calllist_id' AND campaign_id = '$campaign_id'";
$result = mysqli_query($Conn, $query);

// Fetch the result as an associative array
$row = mysqli_fetch_assoc($result);
// Access the value of 'CountApp'
$CountApp = $row['CountApp'];

if($CountApp == 0){

	// $Id = mysqli_result(mysqli_query($Conn, "Select Max(app_run_no)+1 as MaxID from t_aig_app where campaign_id = '$campaign_id' "),0,"MaxID");
	// if(is_null($Id)){ 
	//	$Id = 1;
	// }

	// Execute the query to get the maximum ID
	$query = "SELECT MAX(app_run_no) + 1 AS MaxID FROM t_aig_app WHERE campaign_id = '$campaign_id'";
	$result = mysqli_query($Conn, $query);

	// Fetch the result as an associative array
	$row = mysqli_fetch_assoc($result);

	// Access the value of 'MaxID'
	$Id = isset($row['MaxID']) ? $row['MaxID'] : 1;



	$SequenceNo = str_pad($Id, 9 ,"0", STR_PAD_LEFT);
	$ProposalNumber = $SequenceNo;

	$TITLE = $_POST['TITLE'];
	$FIRSTNAME = $_POST['FIRSTNAME'];
	$LASTNAME = Encryption::encrypt($_POST['LASTNAME']);
	$SEX = $_POST['SEX'];
	$DOB = Encryption::encrypt($_POST['DOB']);
	$ADE_AT_RCD = $_POST['ADE_AT_RCD'];
	$IDCARD = Encryption::encrypt($_POST['IDCARD']);
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
	$TELEPHONE1 = Encryption::encrypt($_POST['TELEPHONE1']);
	$MOBILE1 = Encryption::encrypt($_POST['MOBILE1']);
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
	$EMAIL = $_POST['EMAIL'];
	$APP_CONSENT = $_POST['APP_CONSENT'];
	$FIRST_PAYMENT = ($_POST['FIRST_PAYMENT'])?$_POST['FIRST_PAYMENT']:0;
	$ACCOUNT_NAME = $_POST['ACCOUNT_NAME'];
	$ACCOUNT_EXPIRE = $_POST['ACCOUNT_EXPIRE'];
	$payment_key = $_POST['payment_key'];
	$AppStatus = $_POST['AppStatus'];
	$SMOKE = ($_POST['SMOKE'])?$_POST['SMOKE']:0;
	$INSURED_STATUS = $_POST['INSURED_STATUS'];
	$id_num = $_POST['id_num'];

	/*Insert YersFile*/
	$SQL_YesFile = "INSERT INTO t_aig_app ( 
	app_run_no,
	ProposalNumber,
	TITLE,
	FIRSTNAME,
	LASTNAME,
	SEX,
	DOB,
	ADE_AT_RCD,
	IDCARD,
	OCCUPATIONAL,
	ADDRESSNO1,
	BUILDING1,
	MOO1,
	SOI1,
	ROAD1,
	SUB_DISTRICT1,
	DISTRICT1,
	PROVINCE1,
	ZIPCODE1,
	TELEPHONE1,
	MOBILE1,
	PRODUCT_NAME,
	COVERAGE_NAME,
	PAYMENTFREQUENCY,
	INSTALMENT_PREMIUM,
	INSURED_TITLE2,
	INSURED_NAME2,
	INSURED_LASTNAME2,
	INSURED_DOB2,
	INSURED_RELATIONSHIP2,
	INSURED_SEX2,
	INSURED_TITLE3,
	INSURED_NAME3,
	INSURED_LASTNAME3,
	INSURED_DOB3,
	INSURED_RELATIONSHIP3,
	INSURED_SEX3,
	INSURED_TITLE4,
	INSURED_NAME4,
	INSURED_LASTNAME4,
	INSURED_DOB4,
	INSURED_RELATIONSHIP4,
	INSURED_SEX4,
	INSURED_TITLE5,
	INSURED_NAME5,
	INSURED_LASTNAME5,
	INSURED_DOB5,
	INSURED_RELATIONSHIP5,
	INSURED_SEX5,
	GIVEN_BENAFICIARY,
	BENEFICIARY_TITLE1,
	BENEFICIARY_NAME1,
	BENEFICIARY_LASTNAME1,
	BENEFICIARY_RELATIONSHIP1,
	BENEFICIARY_BENEFIT1,
	BENEFICIARY_SEX1,
	BENEFICIARY_TITLE2,
	BENEFICIARY_NAME2,
	BENEFICIARY_LASTNAME2,
	BENEFICIARY_RELATIONSHIP2,
	BENEFICIARY_BENEFIT2,
	BENEFICIARY_SEX2,
	BENEFICIARY_TITLE3,
	BENEFICIARY_NAME3,
	BENEFICIARY_LASTNAME3,
	BENEFICIARY_RELATIONSHIP3,
	BENEFICIARY_BENEFIT3,
	BENEFICIARY_SEX3,
	BENEFICIARY_TITLE4,
	BENEFICIARY_NAME4,
	BENEFICIARY_LASTNAME4,
	BENEFICIARY_RELATIONSHIP4,
	BENEFICIARY_BENEFIT4,
	BENEFICIARY_SEX4,
	REMARK,
	EMAIL,
	APP_CONSENT,
	FIRST_PAYMENT,
	ACCOUNT_NAME,
	ACCOUNT_EXPIRE,
	AppStatus,
	campaign_id,
	calllist_id,
	agent_id,
	import_id,
	team_id,
	create_date,
	update_by,
	update_date,
	payment_key,
	smoke,
	insured_status,
	id_num
	)

	VALUES(

	'$Id' ,
	'$ProposalNumber' ,
	'$TITLE' ,
	'$FIRSTNAME' ,
	'$LASTNAME' ,
	'$SEX' ,
	'$DOB' ,
	'$ADE_AT_RCD' ,
	'$IDCARD' ,
	'$OCCUPATIONAL' ,
	'$ADDRESSNO1' ,
	'$BUILDING1' ,
	'$MOO1' ,
	'$SOI1' ,
	'$ROAD1' ,
	'$SUB_DISTRICT1' ,
	'$DISTRICT1' ,
	'$PROVINCE1' ,
	'$ZIPCODE1' ,
	'$TELEPHONE1' ,
	'$MOBILE1' ,
	'$PRODUCT_NAME' ,
	'$COVERAGE_NAME' ,
	'$PAYMENTFREQUENCY' ,
	'$INSTALMENT_PREMIUM' ,
	'$INSURED_TITLE2' ,
	'$INSURED_NAME2' ,
	'$INSURED_LASTNAME2' ,
	'$INSURED_DOB2' ,
	'$INSURED_RELATIONSHIP2' ,
	'$INSURED_SEX2' ,
	'$INSURED_TITLE3' ,
	'$INSURED_NAME3' ,
	'$INSURED_LASTNAME3' ,
	'$INSURED_DOB3' ,
	'$INSURED_RELATIONSHIP3' ,
	'$INSURED_SEX3' ,
	'$INSURED_TITLE4' ,
	'$INSURED_NAME4' ,
	'$INSURED_LASTNAME4' ,
	'$INSURED_DOB4' ,
	'$INSURED_RELATIONSHIP4' ,
	'$INSURED_SEX4' ,
	'$INSURED_TITLE5' ,
	'$INSURED_NAME5' ,
	'$INSURED_LASTNAME5' ,
	'$INSURED_DOB5' ,
	'$INSURED_RELATIONSHIP5' ,
	'$INSURED_SEX5' ,
	$GIVEN_BENAFICIARY ,
	'$BENEFICIARY_TITLE1' ,
	'$BENEFICIARY_NAME1' ,
	'$BENEFICIARY_LASTNAME1' ,
	'$BENEFICIARY_RELATIONSHIP1' ,
	'$BENEFICIARY_BENEFIT1' ,
	'$BENEFICIARY_SEX1' ,
	'$BENEFICIARY_TITLE2' ,
	'$BENEFICIARY_NAME2' ,
	'$BENEFICIARY_LASTNAME2' ,
	'$BENEFICIARY_RELATIONSHIP2' ,
	'$BENEFICIARY_BENEFIT2' ,
	'$BENEFICIARY_SEX2' ,
	'$BENEFICIARY_TITLE3' ,
	'$BENEFICIARY_NAME3' ,
	'$BENEFICIARY_LASTNAME3' ,
	'$BENEFICIARY_RELATIONSHIP3' ,
	'$BENEFICIARY_BENEFIT3' ,
	'$BENEFICIARY_SEX3' ,
	'$BENEFICIARY_TITLE4' ,
	'$BENEFICIARY_NAME4' ,
	'$BENEFICIARY_LASTNAME4' ,
	'$BENEFICIARY_RELATIONSHIP4' ,
	'$BENEFICIARY_BENEFIT4' ,
	'$BENEFICIARY_SEX4' ,
	'$REMARK' ,
	'$EMAIL' ,
	'$APP_CONSENT' ,
	$FIRST_PAYMENT,
	'$ACCOUNT_NAME',
	'$ACCOUNT_EXPIRE',
	'$AppStatus' ,
	'$campaign_id' ,
	'$calllist_id' ,
	'$agent_id' ,
	'$import_id' ,
	'$team_id' ,
	NULL ,
	'$agent_id' ,
	'$currentdatetime',
	'$payment_key',
	'$SMOKE',
	'$INSURED_STATUS',
	'$id_num'

	)" ;

	if(mysqli_query($Conn, $SQL_YesFile))
	{
		$id = mysqli_insert_id($Conn);
		$SQL_history = "INSERT INTO t_aig_app_history ( AppID, AppStatus, remark, update_by ) VALUES ('$id', '$AppStatus' , '$REMARK' , '$agent_id')" ;
		mysqli_query($Conn, $SQL_history);

		if($AppStatus == "Submit") {
			$sql_effective_date = "UPDATE t_aig_app SET effective_date = CURDATE() + INTERVAL 1 DAY WHERE id='$id' AND create_date IS NULL";
			mysqli_query($Conn, $sql_effective_date);
			
			$sql = "UPDATE t_aig_app SET create_date = NOW() WHERE id='$id' AND create_date IS NULL";
			mysqli_query($Conn, $sql);

			$sql_update = "UPDATE t_calllist_agent SET last_wrapup_option_id = 6, status = 1, last_wrapup_dt = NOW() WHERE campaign_id ='$campaign_id' AND calllist_id='$calllist_id'";
			mysqli_query($Conn, $sql_update);
		}

		$data = array("result"=>"success","data"=>"Save Complete.", "url"=>"check_app.php?campaign_id=$campaign_id&calllist_id=$calllist_id&agent_id=$agent_id&import_id=$import_id");
		// header( "location: check_app.php?campaign_id=$campaign_id&calllist_id=$calllist_id&agent_id=$agent_id&import_id=$import_id" );
				
	}else{
		$data = array("result"=>false,"data"=>"Please contact IT.");
	}
	echo json_encode( $data ); 
}
else {
	$data = array("result"=>false,"data"=>"Already created.");
	echo json_encode( $data ); 
}
?>
