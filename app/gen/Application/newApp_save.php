<?php

ob_start();
//session_start();


include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

function CovNum2($Data)
	 {
		return number_format($Data, 2, '.', '');  /// COV 123456.123456 --> 123456.12
	}

$list_dtl_id = $_POST["list_dtl_id"];
$campaign_id = $_POST["campaign_id"];
$calllist_id = $_POST["calllist_id"];
$agent_id = $_POST["agent_id"];
$import_id = $_POST["import_id"];
$team_id = $_POST["team_id"];

$Id = mysql_result(mysql_query("Select Max(app_run_no)+1 as MaxID from t_app "),0,"MaxID");
$SequenceNo = sprintf("%08d",$Id);
$ProposalNumber = 'BD'.$SequenceNo;

$Title = $_POST["Title"];
$Firstname = $_POST["Firstname"];
$Lastname = $_POST["Lastname"];
$Firstname_eng = $_POST["Firstname_eng"];
$Lastname_eng = $_POST["Lastname_eng"];
$Sex = $_POST["Sex"];
$MaritalStatus = $_POST["MaritalStatus"];
$Nationality = $_POST["Nationality"];

$birthday = $_POST["DOB"];
$DOB = substr($birthday, 0, 2).'/'.substr($birthday, 3, 2).'/'.(substr($birthday, 6, 4)) ;

$IdCard = $_POST["IdCard"];
$Submit_Date = $_POST["Submit_Date"];

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

$OccupationalCategory = $_POST["OccupationalCategory"];
$OCCUPATION_POSITION = $_POST["OCCUPATION_POSITION"];
$OCCUPATION_DETAILS = $_POST["OCCUPATION_DETAILS"];
$AnnualIncome = $_POST["AnnualIncome"];

$WEIGHT = $_POST["WEIGHT"];
$HEIGHT = $_POST["HEIGHT"];
$PaymentFrequency = $_POST["PaymentFrequency"];
$COVERAGE_NAME = $_POST["COVERAGE_NAME"];
$INSTALMENT_PREMIUM = $_POST["INSTALMENT_PREMIUM"] ;

$PayeeName = $_POST["PayeeName"];
$AccountNo = $_POST["AccountNo"];
$Bank = $_POST["bank"];
$AccountType = $_POST["AccountType"];
$ExpiryDate = $_POST["CREDIT_CARD_EXPIRY_DATE"].'/'.$_POST["CREDIT_CARD_EXPIRY_YEAR"];

$card_relation = $_POST["card_relation"];
$card_name_th = $_POST["card_name_th"];
$card_lastname_th = $_POST["card_lastname_th"];
$card_name_eng = $_POST["card_name_eng"];
$card_lastname_eng = $_POST["card_lastname_eng"];
$CardType = $_POST["CardType"];

$BENEFICIARY_TITLE1 = $_POST["BENEFICIARY_TITLE1"];
$BENEFICIARY_NAME1 = $_POST["BENEFICIARY_NAME1"];
$BENEFICIARY_LASTNAME1 = $_POST["BENEFICIARY_LASTNAME1"];
$BENEFICIARY_RELATIONSHIP1 = $_POST["BENEFICIARY_RELATIONSHIP1"];
$BENEFICIARY_BENEFIT1 = $_POST["BENEFICIARY_BENEFIT1"];
$BENEFICIARY_AGE1 = $_POST["BENEFICIARY_AGE1"];

$BENEFICIARY_TITLE2 = $_POST["BENEFICIARY_TITLE2"];
$BENEFICIARY_NAME2 = $_POST["BENEFICIARY_NAME2"];
$BENEFICIARY_LASTNAME2 = $_POST["BENEFICIARY_LASTNAME2"];
$BENEFICIARY_RELATIONSHIP2 = $_POST["BENEFICIARY_RELATIONSHIP2"];
$BENEFICIARY_BENEFIT2 = $_POST["BENEFICIARY_BENEFIT2"];
$BENEFICIARY_AGE2 = $_POST["BENEFICIARY_AGE2"];

$BENEFICIARY_TITLE3 = $_POST["BENEFICIARY_TITLE3"];
$BENEFICIARY_NAME3 = $_POST["BENEFICIARY_NAME3"];
$BENEFICIARY_LASTNAME3 = $_POST["BENEFICIARY_LASTNAME3"];
$BENEFICIARY_RELATIONSHIP3 = $_POST["BENEFICIARY_RELATIONSHIP3"];
$BENEFICIARY_BENEFIT3 = $_POST["BENEFICIARY_BENEFIT3"];
$BENEFICIARY_AGE3 = $_POST["BENEFICIARY_AGE3"];

$BENEFICIARY_TITLE4 = $_POST["BENEFICIARY_TITLE4"];
$BENEFICIARY_NAME4 = $_POST["BENEFICIARY_NAME4"];
$BENEFICIARY_LASTNAME4 = $_POST["BENEFICIARY_LASTNAME4"];
$BENEFICIARY_RELATIONSHIP4 = $_POST["BENEFICIARY_RELATIONSHIP4"];
$BENEFICIARY_BENEFIT4 = $_POST["BENEFICIARY_BENEFIT4"];
$BENEFICIARY_AGE4 = $_POST["BENEFICIARY_AGE4"];

$Answer1_1 = $_POST["Answer1_1"];
$Answer1_2 = $_POST["Answer1_2"];
$Answer1_3 = $_POST["Answer1_3"];
$Answer2_1 = $_POST["Answer2_1"];
$Answer2_2 = $_POST["Answer2_2"];
$Answer2_3 = $_POST["Answer2_3"];
$Answer2_4 = $_POST["Answer2_4"];
$Answer3_1 = $_POST["Answer3_1"];
$Answer3_2 = $_POST["Answer3_2"];
$Answer4_1 = $_POST["Answer4_1"];
$Answer4_2 = $_POST["Answer4_2"];
$Answer5_1 = $_POST["Answer5_1"];
$Answer5_2 = $_POST["Answer5_2"];

$AppStatus = $_POST["AppStatus"];

$TSR_Name = $_POST["TSR_Name"];
$TSR_Lastname = $_POST["TSR_Lastname"];
$Agent_license = $_POST["License_No"];
$SupID = $_POST["SupID"];
$Card_Type = $_POST["Card_Type"];
$tsr_id = $_POST["tsr_id"];
$TSR_CODE = $_POST["TSR_CODE"];

$Sale_Date = $_POST["CREATED_DATE"];
$camp =  $_POST["camp"];
$ProductCode =  $_POST["ProductCode"];

$ADE_AT_RCD = $_POST["ADE_AT_RCD"];
$IdCardExpire = $_POST["IdCardExpire"];
$remark = $_POST["remark"];

$IdCard_from_distric = $_POST["IdCard_from_distric"];
$IdCard_from_province = $_POST["IdCard_from_province"];

$payment_relation = $_POST["payment_relation"];
$payment_title = $_POST["payment_title"];
$payment_name = $_POST["payment_name"];
$payment_lastname = $_POST["payment_lastname"];
$payment_bod = $_POST["payment_bod"];
$payment_age = $_POST["payment_age"];
$payment_idcard = $_POST["payment_idcard"];
$payment_phone = $_POST["payment_phone"];
$payment_occupation = $_POST["payment_occupation"];
$payment_postion = $_POST["payment_postion"];
$payment_tax = $_POST["payment_tax"];

$Payer_Sex = $_POST["Payer_Sex"];
$Payer_status = $_POST["Payer_status"];
$AddressNo4 = $_POST["AddressNo4"];
$building4 = $_POST["building4"];
$Moo4 = $_POST["Moo4"];
$Soi4 = $_POST["Soi4"];
$Road4 = $_POST["Road4"];
$Sub_district4 = $_POST["Sub_district4"];
$district4 = $_POST["district4"];
$province4 = $_POST["province4"];
$zipcode4 = $_POST["zipcode4"];
$Payer_email = $_POST["Payer_email"];

/*echo $SequenceNo;*/

$SQL_history = "INSERT INTO t_app_history ( ProposalNumber, status, remark, update_by, update_date, update_time )
								VALUES('$ProposalNumber', '$AppStatus' , '$remark' , '$agent_id' , '$currentdate_app' , '$currenttime_app' )" ;
								mysql_query($SQL_history,$Conn) ;

 /*Insert YersFile*/
$SQL_YesFile = "INSERT INTO t_app ( app_run_no, ProposalNumber, Title , Firstname , Lastname  , Sex , MaritalStatus , Nationality , ADE_AT_RCD , DOB , IdCard , IdCardExpire , AddressNo1 , building1 , Moo1 , Soi1 , Road1 , Sub_district1 , district1 , province1 , zipcode1 , telephone1 , AddressNo3 , building3 , Moo3 , Soi3 , Road3 , Sub_district3 , district3 , province3 , zipcode3 , telephone3 , Mobile3 , OccupationalCategory , OCCUPATION_POSITION , OCCUPATION_DETAILS, AnnualIncome, WEIGHT , HEIGHT , COVERAGE_NAME , PaymentFrequency , INSTALMENT_PREMIUM , CardType , card_relation , card_name_th , card_lastname_th , card_name_eng , card_lastname_eng , AccountNo , Bank , AccountType , ExpiryDate , BENEFICIARY_TITLE1, BENEFICIARY_NAME1 , BENEFICIARY_LASTNAME1 , BENEFICIARY_RELATIONSHIP1 , BENEFICIARY_BENEFIT1 , BENEFICIARY_TITLE2, BENEFICIARY_NAME2 , BENEFICIARY_LASTNAME2 , BENEFICIARY_RELATIONSHIP2 , BENEFICIARY_BENEFIT2 , BENEFICIARY_TITLE3, BENEFICIARY_NAME3 , BENEFICIARY_LASTNAME3 , BENEFICIARY_RELATIONSHIP3 , BENEFICIARY_BENEFIT3, BENEFICIARY_TITLE4, BENEFICIARY_NAME4 , BENEFICIARY_LASTNAME4 , BENEFICIARY_RELATIONSHIP4 , BENEFICIARY_BENEFIT4 , Answer1_1, Answer1_2, Answer1_3, Answer2_1, Answer2_2, Answer2_3, Answer2_4, Answer3_1, Answer3_2, Answer4_1, Answer4_2, Answer5_1, Answer5_2, BENEFICIARY_AGE1, BENEFICIARY_AGE2, BENEFICIARY_AGE3, BENEFICIARY_AGE4, IdCard_from_distric, IdCard_from_province,
payment_relation, payment_name, payment_lastname, payment_bod, payment_age, payment_idcard, payment_phone, payment_occupation, payment_postion, payment_tax,payment_title,ProductCode,
Payer_Sex, Payer_status, AddressNo4 , building4 , Moo4 , Soi4 , Road4 , Sub_district4 , district4 , province4 , zipcode4, Payer_email,
AppStatus , Sale_Date , Mobile1 , Owner , campaign_id , calllist_id , agent_id , import_id , camp , team_id, remark )

 VALUES('$Id' , '$ProposalNumber' , '$Title' , '$Firstname' , '$Lastname' ,  '$Sex' , '$MaritalStatus' , '$Nationality' , '$ADE_AT_RCD' , '$DOB' , '$IdCard' , '$IdCardExpire' , '$AddressNo1' , '$building1' , '$Moo1' , '$Soi1' , '$Road1' , '$Sub_district1' , '$district1' , '$province1' , '$zipcode1' , '$telephone1' , '$AddressNo3' , '$building3' , '$Moo3' , '$Soi3' , '$Road3' , '$Sub_district3' , '$district3' , '$province3' , '$zipcode3' , '$telephone3' , '$Mobile3' , '$OccupationalCategory' , '$OCCUPATION_POSITION' , '$OCCUPATION_DETAILS' , '$AnnualIncome' , '$WEIGHT' , '$HEIGHT' , '$COVERAGE_NAME' , '$PaymentFrequency' , '$INSTALMENT_PREMIUM' , '$CardType' , '$card_relation' , '$card_name_th' , '$card_lastname_th' , '$card_name_eng' , '$card_lastname_eng' , '$AccountNo' , '$Bank' , '$AccountType' , '$ExpiryDate' , '$BENEFICIARY_TITLE1' , '$BENEFICIARY_NAME1' , '$BENEFICIARY_LASTNAME1' , '$BENEFICIARY_RELATIONSHIP1' , '$BENEFICIARY_BENEFIT1' , '$BENEFICIARY_TITLE2' , '$BENEFICIARY_NAME2' , '$BENEFICIARY_LASTNAME2' , '$BENEFICIARY_RELATIONSHIP2' , '$BENEFICIARY_BENEFIT2' , '$BENEFICIARY_TITLE3', '$BENEFICIARY_NAME3' , '$BENEFICIARY_LASTNAME3' , '$BENEFICIARY_RELATIONSHIP3' , '$BENEFICIARY_BENEFIT3' , '$BENEFICIARY_TITLE4', '$BENEFICIARY_NAME4' , '$BENEFICIARY_LASTNAME4' , '$BENEFICIARY_RELATIONSHIP4' , '$BENEFICIARY_BENEFIT4' , '$Answer1_1' , '$Answer1_2' , '$Answer1_3' , '$Answer2_1' , '$Answer2_2' , '$Answer2_3' , '$Answer2_4' , '$Answer3_1' , '$Answer3_2', '$Answer4_1' , '$Answer4_2', '$Answer5_1' , '$Answer5_2',
 '$BENEFICIARY_AGE1', '$BENEFICIARY_AGE2', '$BENEFICIARY_AGE3', '$BENEFICIARY_AGE4','$IdCard_from_distric', '$IdCard_from_province',
 '$payment_relation', '$payment_name', '$payment_lastname', '$payment_bod', '$payment_age', '$payment_idcard', '$payment_phone', '$payment_occupation', '$payment_postion' , '$payment_tax','$payment_title', '$ProductCode' ,
 '$Payer_Sex' ,'$Payer_status' , '$AddressNo4' , '$building4' , '$Moo4' , '$Soi4' , '$Road4' , '$Sub_district4' , '$district4' , '$province4' , '$zipcode4', '$Payer_email',
 '$AppStatus' , '$Sale_Date' , '$Mobile1' , '$tsr_id' , '$campaign_id' , '$calllist_id' , '$agent_id' , '$import_id' , '$camp' , '$team_id' , '$remark' )" ;

if(mysql_query($SQL_YesFile,$Conn))
{

			if($camp == 'GenExclusive'){  
					echo "<script>alert('Save Complete.');window.location='appDetail.php?Id=$ProposalNumber';</script>";
			 }elseif($camp == 'GenExclusivePlus'){
				 	echo "<script>alert('Save Complete.');window.location='appDetail_exp.php?Id=$ProposalNumber';</script>";
			 }elseif($camp == 'GenHealth'){
				 	echo "<script>alert('Save Complete.');window.location='appDetail_Health.php?Id=$ProposalNumber';</script>";
			 }

}else{
	echo $SQL_YesFile ;
}

?>
