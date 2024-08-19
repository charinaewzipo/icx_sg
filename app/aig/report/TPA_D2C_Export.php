<?php
ob_start();
session_start();

require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../../class/Encrypt.php");

$currentdatetime = date("Y").'-'.date("m").'-'.date("d");

$root = "temp/";
$PLAN_NO = "23154";
$CAMPAIGN_CODE = '123054' ;
$CREDIT_CARD_CODE = "BBV45";
$CAMPAIGN_TEST_CODE = '1' ;
$tmp = json_decode( $_POST['data'] , true); 
$startdate = $tmp['startdate'];
//$startdate = '20230913';
$startdate = substr($startdate, 6, 4).substr($startdate, 3, 2).substr($startdate, 0, 2) ;

$enddate = $tmp['enddate'];
//$enddate = '20230913';
$enddate = substr($enddate, 6, 4).substr($enddate, 3, 2).substr($enddate, 0, 2) ;



//SQL Main
$SQL = "SELECT COUNT(id) as result_count,
sum(CASE
WHEN GIVEN_BENAFICIARY=1 THEN 1
ELSE 0
END+
CASE
WHEN GIVEN_BENAFICIARY<>1 and BENEFICIARY_NAME1 <> '' THEN 1
ELSE 0
END+
CASE 
WHEN GIVEN_BENAFICIARY<>1 and BENEFICIARY_NAME2 <> '' THEN 1
ELSE 0
END+
CASE
WHEN GIVEN_BENAFICIARY<>1 and BENEFICIARY_NAME3 <> '' THEN 1
ELSE 0
END) AS benefi_no_count,
sum(CASE
WHEN INSURED_NAME2 <> '' THEN 1
ELSE 0
END+
CASE
WHEN INSURED_NAME3 <> '' THEN 1
ELSE 0
END+
CASE
WHEN INSURED_NAME4 <> '' THEN 1
ELSE 0
END+
CASE
WHEN INSURED_NAME5 <> '' THEN 1
ELSE 0
END) AS insured_no_count
from t_aig_app where campaign_id = '7' and AppStatus = 'Approve' and (Approved_Date between '$startdate' and '$enddate')" ;

$benefi_no_count = 0;
$insured_no_count = 0;
$result_count = 0;

$result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
while($row = mysqli_fetch_array($result))
{
	$result_count = $row['result_count'] ;
	$benefi_no_count = $row['benefi_no_count'] ;
	$insured_no_count = $row['insured_no_count'] ;

} 

$insured_no_count = $insured_no_count+$result_count;
// $result_count = mysqli_query("select COUNT(id) as app from t_aig_app where campaign_id = '7' and AppStatus = 'Approve' and (Approved_Date between '$startdate' and '$enddate') ;");
$Policy_Holder_Count = $result_count;
$Policy_Cert_Count = $Policy_Holder_Count;
$Payment_Details_Count = $Policy_Holder_Count;
$Policy_Cert_Rider = $Policy_Holder_Count;
$Policy_Cert_Premium = $Policy_Holder_Count*7;

$Row_Count = $benefi_no_count+$insured_no_count+$Policy_Holder_Count+$Policy_Cert_Count+$Payment_Details_Count+$Policy_Cert_Rider+$Policy_Cert_Premium;


	$T00 = "";
	$T11 = "";
	$T12 = "";
	$T13 = "";
	$T14 = "";
	$T15 = "";
	$T16 = "";
	$T17 = "";

	//TYPE HEADER 00
	$T00 .= "00";
	$T00 .=  str_pad_unicode($Row_Count,8,' ',STR_PAD_RIGHT) ;
	$T00 .=  str_pad_unicode($Policy_Holder_Count,6,' ',STR_PAD_RIGHT) ;
	$T00 .=  str_pad_unicode($Policy_Cert_Count,6,' ',STR_PAD_RIGHT) ;
	$T00 .=  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) ;
	$T00 .=  str_pad_unicode($benefi_no_count,6,' ',STR_PAD_RIGHT) ; // Beneficiary Count
	$T00 .=  str_pad_unicode($Payment_Details_Count,6,' ',STR_PAD_RIGHT) ;
	$T00 .=  str_pad_unicode($Policy_Cert_Rider,6,' ',STR_PAD_RIGHT) ;
	$T00 .=  str_pad_unicode($insured_no_count,6,' ',STR_PAD_RIGHT) ; // Named Insured
	$T00 .=  str_pad_unicode($Policy_Cert_Premium,6,' ',STR_PAD_RIGHT) ;
	$T00 .=  str_pad_unicode(' ',6,' ',STR_PAD_RIGHT) ;
	$T00 .= "\r\n";


 $SQL = "select app.*,agent.agent_login from `t_aig_app` app left join `t_agents` agent on app.agent_id=agent.agent_id where app.campaign_id = '7' and app.AppStatus = 'Approve' and (app.Approved_Date between '$startdate' and '$enddate') " ;

 $result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysqli_fetch_array($result))
{
	// TYPE 11
	$TITLE = getTitleCode($row["TITLE"]);
	if($TITLE == '-'){
		$FIRSTNAME = $row["FIRSTNAME"].' ('.$row["TITLE"].')';
	}else{
		$FIRSTNAME = $row["FIRSTNAME"];
	}

	$LASTNAME = Encryption::decrypt($row["LASTNAME"]);
	$ADDRESS1 = $row["ADDRESSNO1"].' '.$row["BUILDING1"];
	$ADDRESS2 = $row["MOO1"].' '.$row["SOI1"].' '.$row["ROAD1"];
	$ADDRESS3 = $row["SUB_DISTRICT1"].' '.$row["DISTRICT1"];
	$ADDRESS4 = '';
	$PROVINCE1 = $row["PROVINCE1"];
	$ZIPCODE1 = $row["ZIPCODE1"];

	$HOME_PHONE = ($row["TELEPHONE1"])?Encryption::decrypt($row["TELEPHONE1"]):"";
	if($HOME_PHONE == ''){
		$HOMEPHONE = '-';
	}else{
		// 020234242 0809009000
		$HOMEPHONE = substr($HOME_PHONE, 0, 1).'-'.substr($HOME_PHONE, 1, 4).'-'.substr($HOME_PHONE, 5, 9) ;
	}

	$MOBILE_PHONE = ($row["MOBILE1"])?Encryption::decrypt($row["MOBILE1"]):"";
	if($MOBILE_PHONE == ''){
		$MOBILEPHONE = '-';
	}else{
		// 020234242 0815653211
		$MOBILEPHONE = substr($MOBILE_PHONE, 0, 2).'-'.substr($MOBILE_PHONE, 2, 4).'-'.substr($MOBILE_PHONE, 6, 10) ;
	}

	$DOB = Encryption::decrypt($row["DOB"]);
    $age = $row["ADE_AT_RCD"];
		// 20/10/2023
	$DOB = substr($DOB, 0, 2).substr($DOB, 3, 2).substr($DOB, 6, 4) ;

	$SEX = $row["SEX"];
	if($SEX == 'ชาย'){
		$SEX = 'M';
	}else{
		$SEX = 'F';
	}

	$IDCARD = ($row["IDCARD"])?Encryption::decrypt($row["IDCARD"]):"";
	
	$T11 .= "11";
	$T11 .=  $PLAN_NO;
	$T11 .=  $row['ProposalNumber'];
	$T11 .=  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) ;
	$T11 .=  " ";
	$T11 .=  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($ADDRESS1,45,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($ADDRESS2,45,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($ADDRESS3,45,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($ADDRESS4,45,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($PROVINCE1,30,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($ZIPCODE1,10,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($HOMEPHONE,12,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode('-',12,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($MOBILEPHONE,12,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($IDCARD,20,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) ;
	$T11 .=  $SEX;
	$T11 .=  str_pad_unicode(getOccCode($row["OCCUPATIONAL"]),3,' ',STR_PAD_RIGHT) ;
	$T11 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T11 .= "\r\n";


	// TYPE 12
	$Sale_Date_D = $row["Approved_Date"]; // 20230831
	$Sale_Date = substr($Sale_Date_D, 6, 2).substr($Sale_Date_D, 4, 2).substr($Sale_Date_D, 0, 4) ;

	$Running = substr($row["ProposalNumber"],-4);

	$AGENT_LOGIN = $row["agent_login"];
	$T12 .= "12";
	$T12 .=  $PLAN_NO;
	$T12 .=  $row['ProposalNumber'];
	$T12 .=  str_pad_unicode(' ',6,' ',STR_PAD_RIGHT) ;
	$T12 .=  str_pad_unicode(' ',14,' ',STR_PAD_RIGHT) ;
	$T12 .=  str_pad_unicode($AGENT_LOGIN,20,' ',STR_PAD_RIGHT) ;
	$T12 .=  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) ;
	$T12 .=  str_pad_unicode(' ',15,' ',STR_PAD_RIGHT) ;
	$T12 .=  str_pad_unicode($CAMPAIGN_CODE.$Sale_Date.$Running,20,' ',STR_PAD_RIGHT) ;
	$T12 .= "\r\n";

	// TYPE 13
	// Chk ทายาทโดยธรรม
	$GIVEN_BENAFICIARY = $row["GIVEN_BENAFICIARY"];
	if($GIVEN_BENAFICIARY != '1'){ // ไม่ใช่ ทายาทโดยธรรม

	$BENEFICIARY_SEX1 = $row["BENEFICIARY_SEX1"];
	if($BENEFICIARY_SEX1 == 'ชาย'){
		$BENEFICIARY_SEX1 = 'M';
	}else{
		$BENEFICIARY_SEX1 = 'F';
	}

	$BENEFICIARY_SEX2 = $row["BENEFICIARY_SEX2"];
	if($BENEFICIARY_SEX2 == 'ชาย'){
		$BENEFICIARY_SEX2 = 'M';
	}else{
		$BENEFICIARY_SEX2 = 'F';
	}

	$BENEFICIARY_SEX3 = $row["BENEFICIARY_SEX3"];
	if($BENEFICIARY_SEX3 == 'ชาย'){
		$BENEFICIARY_SEX3 = 'M';
	}else{
		$BENEFICIARY_SEX3 = 'F';
	}

		// Chk BENEFICIARY_NAME1
		$BENEFICIARY_NAME1 = $row["BENEFICIARY_NAME1"];

		if($BENEFICIARY_NAME1 != ''){
		
				$BENEFICIARY_TITLE1 = getTitleCode($row["BENEFICIARY_TITLE1"]);
				if($BENEFICIARY_TITLE1 == '-'){
					$BENEFICIARY_NAME1 = $row["BENEFICIARY_NAME1"].' ('.$row["BENEFICIARY_TITLE1"].')';
				}else{
					$BENEFICIARY_NAME1 = $row["BENEFICIARY_NAME1"];
				}
			
			$BENEFICIARY_LASTNAME1 = $row["BENEFICIARY_LASTNAME1"];
			$BENEFICIARY_RELATIONSHIP1 = getRelationCode($row["BENEFICIARY_RELATIONSHIP1"]);
			$BENEFICIARY_BENEFIT1 = $row["BENEFICIARY_BENEFIT1"];
			

			$T13 .= "13";
			$T13 .=  $PLAN_NO;
			$T13 .=  $row['ProposalNumber'];
			$T13 .=  str_pad_unicode($BENEFICIARY_TITLE1,5,' ',STR_PAD_RIGHT) ;
			$T13 .=  " ";
			$T13 .=  str_pad_unicode($BENEFICIARY_NAME1,30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_LASTNAME1,45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('-',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('00000',10,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_BENEFIT1,6,' ',STR_PAD_RIGHT);
			$T13 .=  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_RELATIONSHIP1,1,' ',STR_PAD_RIGHT);
			$T13 .=  str_pad_unicode($BENEFICIARY_SEX1,1,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) ;
			$T13 .=  " ";
			$T13 .= "\r\n";

		}

		// Chk BENEFICIARY_NAME2
		$BENEFICIARY_NAME2 = $row["BENEFICIARY_NAME2"];

		if($BENEFICIARY_NAME2 != ''){
		
			$BENEFICIARY_TITLE2 = getTitleCode($row["BENEFICIARY_TITLE2"]);
			if($BENEFICIARY_TITLE2 == '-'){
				$BENEFICIARY_NAME2 = $row["BENEFICIARY_NAME2"].' ('.$row["BENEFICIARY_TITLE2"].')';
			}else{
				$BENEFICIARY_NAME2 = $row["BENEFICIARY_NAME2"];
			}
		
			$BENEFICIARY_LASTNAME2 = $row["BENEFICIARY_LASTNAME2"];
			$BENEFICIARY_RELATIONSHIP2 = getRelationCode($row["BENEFICIARY_RELATIONSHIP2"]);
			$BENEFICIARY_BENEFIT2 = $row["BENEFICIARY_BENEFIT2"];
			

			$T13 .= "13";
			$T13 .=  $PLAN_NO;
			$T13 .=  $row['ProposalNumber'];
			$T13 .=  str_pad_unicode($BENEFICIARY_TITLE2,5,' ',STR_PAD_RIGHT) ;
			$T13 .=  " ";
			$T13 .=  str_pad_unicode($BENEFICIARY_NAME2,30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_LASTNAME2,45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('-',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('00000',10,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_BENEFIT2,6,' ',STR_PAD_RIGHT);
			$T13 .=  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_RELATIONSHIP2,1,' ',STR_PAD_RIGHT);
			$T13 .=  str_pad_unicode($BENEFICIARY_SEX2,1,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) ;
			$T13 .=  " ";
			$T13 .= "\r\n";
		}

		// Chk BENEFICIARY_NAME3
		$BENEFICIARY_NAME3 = $row["BENEFICIARY_NAME3"];

		if($BENEFICIARY_NAME3 != ''){
		
				$BENEFICIARY_TITLE3 = getTitleCode($row["BENEFICIARY_TITLE3"]);
				if($BENEFICIARY_TITLE3 == '-'){
					$BENEFICIARY_NAME3 = $row["BENEFICIARY_NAME3"].' ('.$row["BENEFICIARY_TITLE3"].')';
				}else{
					$BENEFICIARY_NAME3 = $row["BENEFICIARY_NAME3"];
				}
			
			$BENEFICIARY_LASTNAME3 = $row["BENEFICIARY_LASTNAME3"];
			$BENEFICIARY_RELATIONSHIP3 = getRelationCode($row["BENEFICIARY_RELATIONSHIP3"]);
			$BENEFICIARY_BENEFIT3 = $row["BENEFICIARY_BENEFIT3"];
			

			$T13 .= "13";
			$T13 .=  $PLAN_NO;
			$T13 .=  $row['ProposalNumber'];
			$T13 .=  str_pad_unicode($BENEFICIARY_TITLE3,5,' ',STR_PAD_RIGHT) ;
			$T13 .=  " ";
			$T13 .=  str_pad_unicode($BENEFICIARY_NAME3,30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_LASTNAME3,45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('-',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('00000',10,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_BENEFIT3,6,' ',STR_PAD_RIGHT);
			$T13 .=  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode($BENEFICIARY_RELATIONSHIP3,1,' ',STR_PAD_RIGHT);
			$T13 .=  str_pad_unicode($BENEFICIARY_SEX3,1,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
			$T13 .=  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) ;
			$T13 .=  " ";
			$T13 .= "\r\n";
		}

	}else{ // ทายาทโดยธรรม

		$T13 .= "13";
		$T13 .=  $PLAN_NO;
		$T13 .=  $row['ProposalNumber'];
		$T13 .=  str_pad_unicode('-',5,' ',STR_PAD_RIGHT) ;
		$T13 .=  " ";
		$T13 .=  str_pad_unicode('ทายาทโดยธรรม',30,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode('-',30,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode('00000',10,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode('100',6,' ',STR_PAD_RIGHT);
		$T13 .=  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode('P',1,' ',STR_PAD_RIGHT);
		$T13 .=  str_pad_unicode(' ',1,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
		$T13 .=  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) ;
		$T13 .=  " ";
		$T13 .= "\r\n";	

	} // End ทายาทโดยธรรม

	//TYPE 14
	$PAYMENTFREQUENCY = $row["PAYMENTFREQUENCY"];
	if($PAYMENTFREQUENCY == 'รายเดือน'){
		$PAYMENTFREQUENCY = 'M';
		$PAYMENTFREPERIOR = "2";
	}else{
		$PAYMENTFREQUENCY = 'A';
		$PAYMENTFREPERIOR = "1";
	}

	$ACCOUNT_NAME = $row["ACCOUNT_NAME"];

	$ACCOUNT_NUMBER = trim($row["payment_key"]);
	$APP_CONSENT = $row["APP_CONSENT"];
	if($APP_CONSENT == ''){
		$APP_CONSENT = 'N';
		$PA_TAX_CONSENT = "";
	} else {
		$PA_TAX_CONSENT = "2099";
	}

	$EMAIL = $row["EMAIL"];

	$T14 .= "14";
	$T14 .=  $PLAN_NO;
	$T14 .=  $row['ProposalNumber'];
	$T14 .=  str_pad_unicode($ACCOUNT_NUMBER,16,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode($PAYMENTFREQUENCY,1,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode('',6,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode('',45,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode('',10,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode($CREDIT_CARD_CODE,5,' ',STR_PAD_RIGHT) ; // Credit Card Code
	$T14 .=  str_pad_unicode($ACCOUNT_NAME,45,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode($ACCOUNT_NUMBER,16,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',14,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',16,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',5,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',5,' ',STR_PAD_RIGHT) ;
	$T14 .=  " ";
	$T14 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',5,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode('CRED',4,' ',STR_PAD_RIGHT) ; // Method of Payment Code
	$T14 .=  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) ;
	$T14 .=  " ";
	$T14 .=  " "; // First Payment Collected Flag 
	$T14 .=  str_pad_unicode(' ',4,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode($PAYMENTFREPERIOR,2,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode($EMAIL,50,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode(' ',37,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode($APP_CONSENT,1,' ',STR_PAD_RIGHT) ;
	$T14 .=  str_pad_unicode($PA_TAX_CONSENT,4,' ',STR_PAD_RIGHT) ;
	// $T14 .=  str_pad_unicode(' ',37,' ',STR_PAD_RIGHT) ;
	// $T14 .=  "-"; // PA Tax Consent
	// $T14 .=  str_pad_unicode(' ',4,' ',STR_PAD_RIGHT) ;

	$T14 .=  " ";
	$T14 .= "\r\n";

	//TYPE 15
	$Approved_Date_D = $row["Approved_Date"]; // 20230831
	$Approved_Date = substr($Approved_Date_D, 6, 2).substr($Approved_Date_D, 4, 2).substr($Approved_Date_D, 0, 4) ;

	$Policy_Effective = substr($Approved_Date_D, 4, 2).'/'.substr($Approved_Date_D, 6, 2).'/'.substr($Approved_Date_D, 0, 4) ;
	//$Policy_Effective = '03-31-2023';
	//$Policy_Effective_Date = date('m/d/Y',strtotime($Policy_Effective . "+1 days"));

	//$Policy_Expire_Date = date('dmY',strtotime($Policy_Effective_Date . "+1 year"));
	//$Policy_Effective_Date = date('dmY',strtotime($Policy_Effective . "+1 days"));

	$Policy_Effective_Date = date('dmY',strtotime($row["create_date"] . "+1 days"));
	
	$T15 .= "15";
	$T15 .=  $PLAN_NO;
	$T15 .=  $row['ProposalNumber'];
	$T15 .=  str_pad_unicode($Policy_Effective_Date,8,' ',STR_PAD_RIGHT) ;
	$T15 .=  str_pad_unicode($CAMPAIGN_CODE,7,' ',STR_PAD_RIGHT) ;
	$T15 .=  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) ;
	$T15 .=  str_pad_unicode('1',4,' ',STR_PAD_RIGHT) ;
	$T15 .=  str_pad_unicode($CAMPAIGN_TEST_CODE,7,' ',STR_PAD_RIGHT) ;
	$T15 .=  str_pad_unicode($Policy_Effective_Date,8,' ',STR_PAD_RIGHT) ;
	$T15 .=  str_pad_unicode($Approved_Date,8,' ',STR_PAD_RIGHT) ;
	$T15 .=  " ";
	$T15 .=  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) ;
	$T15 .=  str_pad_unicode(' ',5,' ',STR_PAD_RIGHT) ;
	$T15 .= "\r\n";

	//TYPE 16
	
	$TITLE = getTitleCode($row["TITLE"]);
	if($TITLE == '-'){
		$FIRSTNAME = $row["FIRSTNAME"].' ('.$row["TITLE"].')';
	}else{
		$FIRSTNAME = $row["FIRSTNAME"];
	}

	$LASTNAME = Encryption::decrypt($row["LASTNAME"]);

	$DOB = Encryption::decrypt($row["DOB"]);
			// 20/10/2023
		$DOB = substr($DOB, 0, 2).substr($DOB, 3, 2).substr($DOB, 6, 4) ;


	$SEX = $row["SEX"];
	if($SEX == 'ชาย'){
		$SEX = 'M';
	}else if($SEX == 'หญิง'){
		$SEX = 'F';
	}
	$INSURE_SEX = $SEX;

	$IDCARD = ($row["IDCARD"])?Encryption::decrypt($row["IDCARD"]):"";
	$PRODUCT_NAME = $row["PRODUCT_NAME"];
		
	$T16 .= "16";
	$T16 .=  $PLAN_NO;
	$T16 .=  $row['ProposalNumber'];
	$T16 .=  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) ;
	$T16 .= " ";
	$T16 .=  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode('P',1,' ',STR_PAD_RIGHT) ; // Relationship Code
	$T16 .= " ";
	$T16 .=  $SEX;
	$T16 .=  str_pad_unicode($IDCARD,20,' ',STR_PAD_RIGHT) ;
	$T16 .= "\r\n";

	// CHK INSURED_NAME2
	$INSURED_NAME2 = $row["INSURED_NAME2"];
	//$PRODUCT_NAME = $row["PRODUCT_NAME"];
	if($INSURED_NAME2 != '' && $PRODUCT_NAME != "แผนรายเดี่ยว"){

			$TITLE = getTitleCode($row["INSURED_TITLE2"]);
			if($TITLE == '-'){
				$FIRSTNAME = $row["INSURED_NAME2"].' ('.$row["INSURED_TITLE2"].')';
			}else{
				$FIRSTNAME = $row["INSURED_NAME2"];
			}

			$LASTNAME = $row["INSURED_LASTNAME2"];

			$DOB = $row["INSURED_DOB2"];
					// 20/10/2023
				$DOB = substr($DOB, 0, 2).substr($DOB, 3, 2).substr($DOB, 6, 4) ;

			if($INSURE_SEX == 'M'){
				$SEX = 'F';
			}else if($INSURE_SEX == 'F'){
				$SEX = 'M';
			}else {
				$SEX = 'F';
			}

			$BENEFICIARY_RELATIONSHIP = getRelationCode($row["INSURED_RELATIONSHIP2"]);
			
			$T16 .= "16";
			$T16 .=  $PLAN_NO;
			$T16 .=  $row['ProposalNumber'];
			$T16 .=  str_pad_unicode('1',2,' ',STR_PAD_RIGHT) ;
			$T16 .=  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) ;
			$T16 .=  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) ;
			$T16 .= " ";
			$T16 .=  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) ;
			$T16 .=  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) ;
			$T16 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
			$T16 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
			$T16 .=  str_pad_unicode($BENEFICIARY_RELATIONSHIP,1,' ',STR_PAD_RIGHT) ; // Relationship Code
			$T16 .= " ";
			$T16 .=  $SEX;
			$T16 .=  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) ;
			$T16 .= "\r\n";

	} // END INSURED_NAME2


	// CHK INSURED_NAME3
	$INSURED_NAME3 = $row["INSURED_NAME3"];
	if($INSURED_NAME3 != '' && $PRODUCT_NAME != "แผนรายเดี่ยว"){

			$TITLE = getTitleCode($row["INSURED_TITLE3"]);
			if($TITLE == '-'){
				$FIRSTNAME = $row["INSURED_NAME3"].' ('.$row["INSURED_TITLE3"].')';
			}else{
				$FIRSTNAME = $row["INSURED_NAME3"];
			}

			$LASTNAME = $row["INSURED_LASTNAME3"];

			$DOB = $row["INSURED_DOB3"];
					// 20/10/2023
				$DOB = substr($DOB, 0, 2).substr($DOB, 3, 2).substr($DOB, 6, 4) ;

			$SEX = $row["INSURED_SEX3"];
				if($SEX == 'ชาย'){
					$SEX = 'M';
				}else if($SEX == 'หญิง'){
					$SEX = 'F';
				}else {
					$SEX = 'F';
				}
			
			$BENEFICIARY_RELATIONSHIP = getRelationCode($row["INSURED_RELATIONSHIP3"]);
			
	$T16 .= "16";
	$T16 .=  $PLAN_NO;
	$T16 .=  $row['ProposalNumber'];
	$T16 .=  str_pad_unicode('2',2,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) ;
	$T16 .= " ";
	$T16 .=  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($BENEFICIARY_RELATIONSHIP,1,' ',STR_PAD_RIGHT) ; // Relationship Code
	$T16 .= " ";
	$T16 .=  $SEX;
	$T16 .=  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) ;
	$T16 .= "\r\n";

	} // END INSURED_NAME3


	// CHK INSURED_NAME4
	$INSURED_NAME4 = $row["INSURED_NAME4"];
	if($INSURED_NAME4 != '' && $PRODUCT_NAME != "แผนรายเดี่ยว"){

			$TITLE = getTitleCode($row["INSURED_TITLE4"]);
			if($TITLE == '-'){
				$FIRSTNAME = $row["INSURED_NAME4"].' ('.$row["INSURED_TITLE4"].')';
			}else{
				$FIRSTNAME = $row["INSURED_NAME4"];
			}

			$LASTNAME = $row["INSURED_LASTNAME4"];

			$DOB = $row["INSURED_DOB4"];
					// 20/10/2023
				$DOB = substr($DOB, 0, 2).substr($DOB, 3, 2).substr($DOB, 6, 4) ;

			$SEX = $row["INSURED_SEX4"];
				if($SEX == 'ชาย'){
					$SEX = 'M';
				}else if($SEX == 'หญิง'){
					$SEX = 'F';
				}else {
					$SEX = 'F';
				}
			
			$BENEFICIARY_RELATIONSHIP = getRelationCode($row["INSURED_RELATIONSHIP4"]);
			
	$T16 .= "16";
	$T16 .=  $PLAN_NO;
	$T16 .=  $row['ProposalNumber'];
	$T16 .=  str_pad_unicode('3',2,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) ;
	$T16 .= " ";
	$T16 .=  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($BENEFICIARY_RELATIONSHIP,1,' ',STR_PAD_RIGHT) ; // Relationship Code
	$T16 .= " ";
	$T16 .=  $SEX;
	$T16 .=  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) ;
	$T16 .= "\r\n";

	} // END INSURED_NAME4


	// CHK INSURED_NAME5 $PRODUCT_NAME != "แผนรายเดี่ยว"
	$INSURED_NAME5 = $row["INSURED_NAME5"];
	if($INSURED_NAME4 != '' && $PRODUCT_NAME != "แผนรายเดี่ยว"){

			$TITLE = getTitleCode($row["INSURED_TITLE5"]);
			if($TITLE == '-'){
				$FIRSTNAME = $row["INSURED_NAME5"].' ('.$row["INSURED_TITLE5"].')';
			}else{
				$FIRSTNAME = $row["INSURED_NAME5"];
			}

			$LASTNAME = $row["INSURED_LASTNAME5"];

			$DOB = $row["INSURED_DOB5"];
					// 20/10/2023
				$DOB = substr($DOB, 0, 2).substr($DOB, 3, 2).substr($DOB, 6, 4) ;

			$SEX = $row["INSURED_SEX5"];
				if($SEX == 'ชาย'){
					$SEX = 'M';
				}else if($SEX == 'หญิง'){
					$SEX = 'F';
				}else {
					$SEX = 'F';
				}
			
			$BENEFICIARY_RELATIONSHIP = getRelationCode($row["INSURED_RELATIONSHIP5"]);
			
	$T16 .= "16";
	$T16 .=  $PLAN_NO;
	$T16 .=  $row['ProposalNumber'];
	$T16 .=  str_pad_unicode('4',2,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) ;
	$T16 .= " ";
	$T16 .=  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) ;
	$T16 .=  str_pad_unicode($BENEFICIARY_RELATIONSHIP,1,' ',STR_PAD_RIGHT) ; // Relationship Code
	$T16 .= " ";
	$T16 .=  $SEX;
	$T16 .=  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) ;
	$T16 .= "\r\n";

	} // END INSURED_NAME4

	//TYPE17
	$PRODUCT_NAME = $row["PRODUCT_NAME"];
	$COVERAGE_NAME = $row["COVERAGE_NAME"];
    

    if($age >= '0' and $age <= '5'){
        $r_age = '0-5';
    }elseif($age >= '6' and $age <= '10'){
        $r_age = '6-10';
    }elseif($age >= '11' and $age <= '15'){
        $r_age = '11-15';
    }elseif($age >= '16' and $age <= '20'){
        $r_age = '16-20';
    }elseif($age >= '21' and $age <= '25'){
        $r_age = '21-25';
    }elseif($age >= '26' and $age <= '30'){
        $r_age = '26-30';
    }elseif($age >= '31' and $age <= '35'){
        $r_age = '31-35';
    }elseif($age >= '36' and $age <= '40'){
        $r_age = '36-40';
    }elseif($age >= '41' and $age <= '45'){
        $r_age = '41-45';
    }elseif($age >= '46' and $age <= '50'){
        $r_age = '46-50';
    }elseif($age >= '51' and $age <= '55'){
        $r_age = '51-55';
    }elseif($age >= '56' and $age <= '60'){
        $r_age = '56-60';
    }elseif($age >= '61' and $age <= '65'){
        $r_age = '61-65';
    }elseif($age >= '66' and $age <= '70'){
        $r_age = '66-70';
    }

    $PLAN_RATE_BAND_CODE = $r_age;

	$PRODUCT_CODE1 = '2AD';
	$PRODUCT_CODE2 = '2DMBM';
	$PRODUCT_CODE3 = '2PTD';
	$PRODUCT_CODE4 = '2MDAS';
	$PRODUCT_CODE5 = '2MC';
	$PRODUCT_CODE6 = '2AMR';
    $PRODUCT_CODE7 = '2HIPP';



		$SQL17 = "select * from `t_aig_doublecare_product` where PRODUCTNAME_TH = '$PRODUCT_NAME' and PLAN = '$COVERAGE_NAME' " ;
		$result17 = mysqli_query($Conn, $SQL17) or die ("ไม่สามารถเรียกดูข้อมูลได้");
			while($row17 = mysqli_fetch_array($result17))
		{
			$PLAN_LAYER_CODE = $row17["PLAN_LAYER_CODE"];
			$PLAN_RATE_CATEGORY_CODE = $row17["PLAN_RATE_CATEGORY_CODE"];
			//$PLAN_RATE_BAND_CODE = $row17["PLAN_RATE_BAND_CODE"];
		}

	$T17 .= "17";
	$T17 .=  $PLAN_NO;
	$T17 .=  $row['ProposalNumber'];
	$T17 .=  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PRODUCT_CODE1,6,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) ;
	$T17 .= "\r\n";

	$T17 .= "17";
	$T17 .=  $PLAN_NO;
	$T17 .=  $row['ProposalNumber'];
	$T17 .=  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PRODUCT_CODE2,6,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) ;
	$T17 .= "\r\n";

	$T17 .= "17";
	$T17 .=  $PLAN_NO;
	$T17 .=  $row['ProposalNumber'];
	$T17 .=  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PRODUCT_CODE3,6,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) ;
	$T17 .= "\r\n";

	$T17 .= "17";
	$T17 .=  $PLAN_NO;
	$T17 .=  $row['ProposalNumber'];
	$T17 .=  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PRODUCT_CODE4,6,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) ;
	$T17 .= "\r\n";

	$T17 .= "17";
	$T17 .=  $PLAN_NO;
	$T17 .=  $row['ProposalNumber'];
	$T17 .=  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PRODUCT_CODE5,6,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) ;
	$T17 .= "\r\n";

	$T17 .= "17";
	$T17 .=  $PLAN_NO;
	$T17 .=  $row['ProposalNumber'];
	$T17 .=  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PRODUCT_CODE6,6,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) ;
	$T17 .= "\r\n";

    $T17 .= "17";
	$T17 .=  $PLAN_NO;
	$T17 .=  $row['ProposalNumber'];
	$T17 .=  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PRODUCT_CODE7,6,' ',STR_PAD_RIGHT) ;
    $T17 .=  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) ;
	$T17 .=  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) ;
	$T17 .= "\r\n";
}

	$name = "TPA_File_D2C.txt";
	$allTxt = $T00.$T11.$T12.$T13.$T14.$T15.$T16.$T17;
	$allTxt = iconv(mb_detect_encoding( $allTxt ), 'tis620', $allTxt);
	$fh=fopen($root.$name, "w");
	fwrite($fh, $allTxt);
	// fwrite($fh, $T11);
	// fwrite($fh, $T12);
	// fwrite($fh, $T13);
	// fwrite($fh, $T14);
	// fwrite($fh, $T15);
	// fwrite($fh, $T16);
	// fwrite($fh, $T17);
	fclose($fh);
	// mb_internal_encoding('utf-8'); // @important
	$result = array("result"=>"success");
	echo json_encode( $result ); 



// Function //
	function getTitleCode($title_code) {	
		global $Conn;	
		$SQLFN = "select `code` from `t_aig_pancode` where type = 'titlename' and `name` = '$title_code' limit 1 " ;
		$resultFN = mysqli_query($Conn, $SQLFN) or die ("ไม่สามารถเรียกดูข้อมูลได้");
		   while($rowFN = mysqli_fetch_array($resultFN))
			{	
					$title_code = $rowFN["code"];
					if($title_code == '1'){
						$title_code = 'คุณ';
					}else{
						$title_code = '-';
					}
			}	 
		 return $title_code ;
	}

	function getOccCode($Occ_code) {	
		global $Conn;	
		$SQLFN = "select `code` from `t_aig_pancode` where type = 'occupation' and `name` = '$Occ_code' limit 1 " ;
		$resultFN = mysqli_query($Conn, $SQLFN) or die ("ไม่สามารถเรียกดูข้อมูลได้");
		   while($rowFN = mysqli_fetch_array($resultFN))
			{	
					$Occ_code = $rowFN["code"];
			}	 
		 return $Occ_code ;
	}

	function getRelationCode($relation_code) {	
		global $Conn;	
		$SQLFN = "select `code` from `t_aig_pancode` where type = 'relationship' and `name` = '$relation_code' limit 1 " ;
		$resultFN = mysqli_query($Conn, $SQLFN) or die ("ไม่สามารถเรียกดูข้อมูลได้");
		   while($rowFN = mysqli_fetch_array($resultFN))
			{	
					$relation_code = $rowFN["code"];
			}	 
		 return $relation_code ;
	}

	function str_pad_unicode($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT) {
		$str_len = mb_strlen($str);
		$pad_str_len = mb_strlen($pad_str);
		if (!$str_len && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT)) {
			$str_len = 1; // @debug
		}
		if (!$pad_len || !$pad_str_len || $pad_len <= $str_len) {
			return $str;
		}
		
		$result = null;
		$repeat = ceil($str_len - $pad_str_len + $pad_len);
		if ($dir == STR_PAD_RIGHT) {
			$result = $str . str_repeat($pad_str, $repeat);
			$result = mb_substr($result, 0, $pad_len);
		} else if ($dir == STR_PAD_LEFT) {
			$result = str_repeat($pad_str, $repeat) . $str;
			$result = mb_substr($result, -$pad_len);
		} else if ($dir == STR_PAD_BOTH) {
			$length = ($pad_len - $str_len) / 2;
			$repeat = ceil($length / $pad_str_len);
			$result = mb_substr(str_repeat($pad_str, $repeat), 0, floor($length)) 
						. $str 
						   . mb_substr(str_repeat($pad_str, $repeat), 0, ceil($length));
		}
		
		return $result;
	}


?>