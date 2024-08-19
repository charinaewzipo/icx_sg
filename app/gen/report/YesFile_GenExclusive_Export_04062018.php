<?php
ob_start();
session_start();

include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="GenExclusive.xls"');# ชื่อไฟล์
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>
<BODY>
<?php
$start = $_POST["startdate"];  //   01/06/2016
$end = $_POST["enddate"];  //       01/06/2016

$start_dd = substr($start,0,2);
$start_mm = substr($start,3,2);
$start_yy = substr($start,6,4);
$startdate = $start_yy.$start_mm.$start_dd;

$end_dd = substr($end,0,2);
$end_mm = substr($end,3,2);
$end_yy = substr($end,6,4) ;
$enddate =  $end_yy.$end_mm.$end_dd;
?>

<TABLE x:str>
<tr>
<td>Proposal number</td>
<td>Policy number</td>
<td>Inception date</td>
<td>Inception time</td>
<td>Proposal date</td>
<td>Pay Plan</td>
<td>Bank key</td>
<td>Bank Name</td>
<td>Bank branch</td>
<td>Bank Account Number/Credit Card</td>
<td>Bank Account Description</td>
<td>Credit Card Expiry Date</td>
<td>Bank Account Type</td>
<td>Social Security Number</td>
<td>Surname</td>
<td>Given Name</td>
<td>Salutation</td>
<td>Salutation Code</td>
<td>Client Sex</td>
<td>Client Sex Code</td>
<td>Client Status</td>
<td>Client Status Code</td>
<td>Client Address1</td>
<td>Client Address2</td>
<td>Client Address3</td>
<td>Client Address4</td>
<td>Client Address5</td>
<td>Post Code</td>
<td>Client Telephone Number1</td>
<td>Client Telephone Number2</td>
<td>Client Telephone Number3</td>
<td>e-mail Address</td>
<td>Client Date of Birth</td>
<td>Occupation</td>
<td>Occupation Code</td>
<td>Age</td>
<td>Height</td>
<td>Weight</td>
<td>Beneficiary name 1</td>
<td>Beneficiary Relationship 1</td>
<td>Beneficiary Age 1</td>
<td>Beneficiary Benefit %1</td>
<td>Beneficiary name 2</td>
<td>Beneficiary Relationship 2</td>
<td>Beneficiary Age 2</td>
<td>Beneficiary Benefit %2</td>
<td>Beneficiary name 3</td>
<td>Beneficiary Relationship 3</td>
<td>Beneficiary Age 3</td>
<td>Beneficiary Benefit %3</td>
<td>Beneficiary name 4</td>
<td>Beneficiary Relationship 4</td>
<td>Beneficiary Age 4</td>
<td>Beneficiary Benefit %4</td>
<td>Source of name list</td>
<td>Created By</td>
<td>Servicing Agent No.</td>
<td>Created date</td>
<td>Created time</td>
<td>Contract Type</td>
<td>Occupation/Trade code</td>
<td>Coverage Code</td>
<td>Coverage Name</td>
<td>Sum Insured</td>
<td>Deductible</td>
<td>Annualized premium</td>
<td>Instalment premium</td>
<td>Social Security Number</td>
<td>Surname</td>
<td>Given Name</td>
<td>Salutation</td>
<td>Salutation Code</td>
<td>Client Sex</td>
<td>Client Sex Code</td>
<td>Client Status</td>
<td>Client Status Code</td>
<td>Client Address1</td>
<td>Client Address2</td>
<td>Client Address3</td>
<td>Client Address4</td>
<td>Client Address5</td>
<td>Post Code</td>
<td>Client Telephone Number1</td>
<td>Client Telephone Number2</td>
<td>Client Telephone Number3</td>
<td>e-mail Address</td>
<td>Client Date of Birth</td>
<td>Occupation</td>
<td>Occupation Code</td>
<td>Age</td>
<td>Height</td>
<td>Weight</td>
<td>Beneficiary name 1</td>
<td>Beneficiary Relationship 1</td>
<td>Beneficiary Age 1</td>
<td>Beneficiary Benefit %1</td>
<td>Beneficiary name 2</td>
<td>Beneficiary Relationship 2</td>
<td>Beneficiary Age 2</td>
<td>Beneficiary Benefit %2</td>
<td>Beneficiary name 3</td>
<td>Beneficiary Relationship 3</td>
<td>Beneficiary Age 3</td>
<td>Beneficiary Benefit %3</td>
<td>Beneficiary name 4</td>
<td>Beneficiary Relationship 4</td>
<td>Beneficiary Age 4</td>
<td>Beneficiary Benefit %4</td>
<td>Answer01</td>
<td>Answer01 Rem01</td>
<td>Answer01 Rem02</td>
<td>Answer01 Rem03</td>
<td>Answer02</td>
<td>Answer02 Rem01</td>
<td>Answer02 Rem02</td>
<td>Answer02 Rem03</td>
<td>Answer03</td>
<td>Answer03 Rem01</td>
<td>Answer03 Rem02</td>
<td>Answer03 Rem03</td>
<td>Answer04</td>
<td>Answer04 Rem01</td>
<td>Answer04 Rem02</td>
<td>Answer04 Rem03</td>
<td>Answer05</td>
<td>Answer05 Rem01</td>
<td>Answer05 Rem02</td>
<td>Answer05 Rem03</td>
<td>Answer01</td>
<td>Answer01 Rem01</td>
<td>Answer01 Rem02</td>
<td>Answer01 Rem03</td>
<td>Answer02</td>
<td>Answer02 Rem01</td>
<td>Answer02 Rem02</td>
<td>Answer02 Rem03</td>
<td>Answer03</td>
<td>Answer03 Rem01</td>
<td>Answer03 Rem02</td>
<td>Answer03 Rem03</td>
<td>Answer04</td>
<td>Answer04 Rem01</td>
<td>Answer04 Rem02</td>
<td>Answer04 Rem03</td>
<td>Answer05</td>
<td>Answer05 Rem01</td>
<td>Answer05 Rem02</td>
<td>Answer05 Rem03</td>
<td>Annual Income</td>

<TD>Consent flag</TD>
<TD>Consent type</TD>
<TD>Data source </TD>
<TD>Consent Date</TD>
<TD>Consent Time</TD>
<TD>Consent  version</TD>
<TD>Consent_Revenue_flag</TD>

</tr>
<?php
$SQL = "select * from `t_app` where campaign_id = '1' and camp = 'GenExclusive' and ( Approved_Date between '$startdate' and '$enddate') and AppStatus = 'Success' " ;
 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysql_fetch_array($result))
{
	$agent_id = $row["agent_id"] ;

	$ProposalNumber = $row["ProposalNumber"];
	$Approved_Date = $row["Approved_Date"];
	$ApprovedTime = $row["Approved_Time"];
	$Approved_Time = substr($ApprovedTime,0,2).substr($ApprovedTime,3,2);
	
	
	$PaymentFrequency = $row["PaymentFrequency"];
	if($PaymentFrequency == 'รายเดือน'){
		$PaymentFrequency = 'BI12';
	}else{
		$PaymentFrequency = 'BI01';
	}
	
	$Bank = $row["Bank"];
	$AccountNo = $row["AccountNo"];
	$card_name = strtoupper($row["card_name_eng"].' '.$row["card_lastname_eng"]);
	$ExpiryDate = $row["ExpiryDate"];
	$ExpiryDate = substr($ExpiryDate,0,2).substr($ExpiryDate,3,2);
	
	$AccountType = $row["AccountType"];
	$IdCard = $row["IdCard"];
	$Lastname = $row["Lastname"];
	$Firstname = $row["Firstname"];
	
	$Title = $row["Title"];
			 $SQL2 = "select *  from t_salutation  where `desc` = '$Title'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row2 = mysql_fetch_array($result2))
				{
					$Title_code = $row2["code"];	
				}
	
	$Sex = $row["Sex"];
	if($Sex == 'ชาย'){
		$Sex_code = 'M' ;
	}else{
		$Sex_code = 'F' ;
	}
	$MaritalStatus = $row["MaritalStatus"];
	if($MaritalStatus == 'โสด'){
		$MaritalStatus_code = 'S' ;
	}elseif($MaritalStatus == 'สมรส'){
		$MaritalStatus_code = 'M' ;
	}elseif($MaritalStatus == 'หม้าย'){
		$MaritalStatus_code = 'W' ;
	}elseif($MaritalStatus == 'หย่าร้าง'){
		$MaritalStatus_code = 'D' ;
	}
	
	$AddressNo1 = $row["AddressNo1"];
	$building1 = $row["building1"];
	if($building1 != ''){
		$building1 = ' '.$row["building1"];
	}
	
	$Moo1 = $row["Moo1"];
	if($Moo1 != ''){
		$Moo1 = ' ม.'.$row["Moo1"];
	}
	
	$Soi1 = $row["Soi1"];
	if($Soi1 != ''){
		$Soi1 = ' ซ.'.$row["Soi1"];
	}
		
	$Road1 = $row["Road1"];
	if($Road1 != ''){
		$Road1 = ' ถ.'.$row["Road1"];
	}
	
	$ClientAddress1 = $AddressNo1.$building1.$Moo1 ;
	$ClientAddress2 = $Soi1.$Road1 ;
	
	$province1 = $row["province1"];
			if($province1 == 'กรุงเทพมหานคร'){
				
				$province1 = $row["province1"];
				$Sub_district1 = 'แขวง'.$row["Sub_district1"];
				$district1 = 'เขต'.$row["district1"];
							
			}else{
				
				$province1 = 'จังหวัด'.$row["province1"];
				$Sub_district1 = 'ตำบล'.$row["Sub_district1"];
				$district1 = 'อำเภอ'.$row["district1"];					
			}
	
	$zipcode1 = $row["zipcode1"];
	
	
	$telephone1 = $row["telephone1"];
	$Mobile1 = $row["Mobile1"];
	$DOB = $row["DOB"];  // 25/11/2982
	$DOB = substr($DOB,6,4).substr($DOB,3,2).substr($DOB,0,2);
	
	$OccupationalCategory = $row["OccupationalCategory"];
	$SQL2 = "select *  from t_occupation  where `desc` = '$OccupationalCategory'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row2 = mysql_fetch_array($result2))
				{
					$OccupationalCategory_code = $row2["code"];	
					$Occ_level = $row2["class"];
				}
	$ADE_AT_RCD = $row["ADE_AT_RCD"];
	$HEIGHT = $row["HEIGHT"];
	$HEIGHT = number_format($HEIGHT, 2, '.', '');
	$WEIGHT = $row["WEIGHT"];
	$WEIGHT = number_format($WEIGHT, 2, '.', '');
	
	$BENEFICIARY_NAME1 = $row["BENEFICIARY_TITLE1"].$row["BENEFICIARY_NAME1"].' '.$row["BENEFICIARY_LASTNAME1"];
	$BENEFICIARY_RELATIONSHIP1 = $row["BENEFICIARY_RELATIONSHIP1"];
	$BENEFICIARY_AGE1 = $row["BENEFICIARY_AGE1"];
	$BENEFICIARY_BENEFIT1 = $row["BENEFICIARY_BENEFIT1"];
	
	$BENEFICIARY_NAME2 = $row["BENEFICIARY_TITLE2"].$row["BENEFICIARY_NAME2"].' '.$row["BENEFICIARY_LASTNAME2"];
	$BENEFICIARY_RELATIONSHIP2 = $row["BENEFICIARY_RELATIONSHIP2"];
	$BENEFICIARY_AGE2 = $row["BENEFICIARY_AGE2"];
	$BENEFICIARY_BENEFIT2 = $row["BENEFICIARY_BENEFIT2"];
	
	$BENEFICIARY_NAME3 = $row["BENEFICIARY_TITLE3"].$row["BENEFICIARY_NAME3"].' '.$row["BENEFICIARY_LASTNAME3"];
	$BENEFICIARY_RELATIONSHIP3 = $row["BENEFICIARY_RELATIONSHIP3"];
	$BENEFICIARY_AGE3 = $row["BENEFICIARY_AGE3"];
	$BENEFICIARY_BENEFIT3 = $row["BENEFICIARY_BENEFIT3"];
	
	$BENEFICIARY_NAME4 = $row["BENEFICIARY_TITLE4"].$row["BENEFICIARY_NAME4"].' '.$row["BENEFICIARY_LASTNAME4"];
	$BENEFICIARY_RELATIONSHIP4 = $row["BENEFICIARY_RELATIONSHIP4"];
	$BENEFICIARY_AGE4 = $row["BENEFICIARY_AGE4"];
	$BENEFICIARY_BENEFIT4 = $row["BENEFICIARY_BENEFIT4"];
	
	$agent_id = $row["agent_id"];		
			$strSQL_agent = "SELECT * FROM t_agents WHERE agent_id = '$agent_id' ";
			$result2= mysql_query($strSQL_agent);
			while($objResult2 = mysql_fetch_array($result2))
			{
			$agent_name = $objResult2["sales_agent_name"] ;
			$agent_code = $objResult2["sales_agent_code"] ;
			}

	
	
	$Sale_Date = $row["Sale_Date"];
	
	$Approved_Time = $row["Approved_Time"];
	$Approved_Time = substr($Approved_Time,0,2).substr($Approved_Time,3,2);
	
	$INSTALMENT_PREMIUM = $row["INSTALMENT_PREMIUM"];
			 $SQL2 = "select *  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row2 = mysql_fetch_array($result2))
				{
					$plan_code = $row2["plan_code"];
					$plan_name = $row2["plan_name"];
					$premium = $row2["premium"];
					$sum_insure = $row2["sum_insure"];	
				}

	
	$Answer1_1 = $row["Answer1_1"];
	if($Answer1_1 == '0'){
		$Answer1_1 = 'N' ;
	}else{
		$Answer1_1 = 'Y' ;
	}	
	$Answer1_2 = $row["Answer1_2"];
	$Answer1_3 = $row["Answer1_3"];
	
	$Answer2_1 = $row["Answer2_1"];
	if($Answer2_1 == '0'){
		$Answer2_1 = 'N' ;
	}else{
		$Answer2_1 = 'Y' ;
	}
	
	$Answer2_2 = $row["Answer2_2"];
	$Answer2_3 = $row["Answer2_3"];
	$Answer2_4 = $row["Answer2_4"];
	
	$Answer3_1 = $row["Answer3_1"];
	if($Answer3_1 == '0'){
		$Answer3_1 = 'N' ;
	}else{
		$Answer3_1 = 'Y' ;
	}
	$Answer3_2 = $row["Answer3_2"];
	
	$AnnualIncome = $row["AnnualIncome"];
	
	$pay_code = 'A2' ;
	
	// เงินสด
	$CardType = $row["CardType"];
	if($CardType == 'เงินสด'){
		$Bank = 'Dummy NB Saving Bank Account';
		$AccountNo = '9'.substr($ProposalNumber, 2, 8);
		$ExpiryDate  = '1299';
		$pay_code = '99' ;
		$AccountType = 'AC01' ;
	}
	
	$Consent_Flag = $row["Consent_Flag"];
	$Consent_Time = $row["Consent_Time"];
	$Consent_Date = $row["Consent_Date"];
		

 print "
<tr>
  <td x:str>$ProposalNumber</td>
  <td x:str></td>
  <td x:str>$Approved_Date</td>
  <td x:str>$Approved_Time</td>
  <td x:str>$Approved_Date</td>
  <td x:str>$PaymentFrequency</td>
  <td x:str>$pay_code</td>
  <td x:str>$Bank</td>
  <td x:str>$pay_code</td>
  <td x:str>$AccountNo</td>
  <td x:str>$card_name</td>
  <td x:str>$ExpiryDate</td>
  <td x:str>$AccountType</td>
  <td x:str>$IdCard</td>
  <td x:str>$Lastname</td>
  <td x:str>$Firstname</td>
  <td x:str>$Title</td>
  <td x:str>$Title_code</td>
  <td x:str>$Sex</td>
  <td x:str>$Sex_code</td>
  <td x:str>$MaritalStatus</td>
  <td x:str>$MaritalStatus_code</td>
  <td x:str>$ClientAddress1</td>
  <td x:str>$ClientAddress2</td>
  <td x:str>$Sub_district1</td>
  <td x:str>$district1</td>
  <td x:str>$province1</td>
  <td x:str>$zipcode1</td>
  <td x:str>$telephone1</td>
  <td x:str></td>
  <td x:str>$Mobile1</td>
  <td x:str></td>
  <td x:str>$DOB</td>
  <td x:str>$OccupationalCategory</td>
  <td x:str>$OccupationalCategory_code</td>
  <td x:str>$ADE_AT_RCD</td>
  <td x:str>$HEIGHT</td>
  <td x:str>$WEIGHT</td>
  
  <td x:str>$BENEFICIARY_NAME1</td>
  <td x:str>$BENEFICIARY_RELATIONSHIP1</td>
  <td x:str>$BENEFICIARY_AGE1</td>
  <td x:str>$BENEFICIARY_BENEFIT1</td>
  <td x:str>$BENEFICIARY_NAME2</td>
  <td x:str>$BENEFICIARY_RELATIONSHIP2</td>
  <td x:str>$BENEFICIARY_AGE2</td>
  <td x:str>$BENEFICIARY_BENEFIT2</td>
  <td x:str>$BENEFICIARY_NAME3</td>
  <td x:str>$BENEFICIARY_RELATIONSHIP3</td>
  <td x:str>$BENEFICIARY_AGE3</td>
  <td x:str>$BENEFICIARY_BENEFIT3</td>
  <td x:str>$BENEFICIARY_NAME4</td>
  <td x:str>$BENEFICIARY_RELATIONSHIP4</td>
  <td x:str>$BENEFICIARY_AGE4</td>
  <td x:str>$BENEFICIARY_BENEFIT4</td>
  
  <td x:str>ARK</td>
  <td x:str>$agent_name</td>
  <td x:str>$agent_code</td>
  <td x:str>$Sale_Date</td>
  <td x:str>$Approved_Time</td>
  <td x:str>AAIAAI</td>
  <td x:str>$Occ_level</td>
  
  <td x:str>$plan_code</td>
  <td x:str>$plan_name</td>
  <td x:str>$sum_insure</td>
  <td x:str></td>
  <td x:str>$premium</td>
  <td x:str>$INSTALMENT_PREMIUM</td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  
  <td x:str>$Answer1_1</td>
  <td x:str>$Answer1_2</td>
  <td x:str>$Answer1_3</td>
  <td x:str></td>
  
  <td x:str>$Answer2_1</td>
  <td x:str>$Answer2_2</td>
  <td x:str>$Answer2_3</td>
  <td x:str>$Answer2_4</td>
  
  <td x:str>$Answer3_1</td>
  <td x:str>$Answer3_2</td>
  
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str></td>
  <td x:str>$AnnualIncome</td>
  
  <td x:str>$Consent_Flag</td>
 <td x:str></td>
  <td x:str>002</td>
  <td x:str>$Consent_Date</td>
  <td x:str>$Consent_Time</td>
  <td x:str>1</td>
 <td x:str></td>

  
 
</tr>";
}
?>
</TABLE>

</BODY>
</HTML>
