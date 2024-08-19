<?php
ob_start();
session_start();

include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

$currentdatetime = date("Y").'-'.date("m").'-'.date("d");

$root = "temp/";
$PLAN_NO = "23150";
$CAMPAIGN_CODE = '123050' ;
$CAMPAIGN_TEST_CODE = '1' ;
$tmp = json_decode( $_POST['data'] , true); 
$startdate = $tmp['startdate'];
//$startdate = '31/08/2023';
$startdate = substr($startdate, 6, 4).substr($startdate, 3, 2).substr($startdate, 0, 2) ;

$enddate = $tmp['enddate'];
//$enddate = '31/08/2023';
$enddate = substr($enddate, 6, 4).substr($enddate, 3, 2).substr($enddate, 0, 2) ;

//SQL Main
$SQL = "select * from `t_aig_app` where campaign_id = '1' and AppStatus = 'QC_Approved' and (Approved_Date between '$startdate' and '$enddate') " ;

$benefi_no_count = 0;
$insured_no_count = 0;
$result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
while($row = mysqli_fetch_array($result))
{

	$ProposalNumber = $row["ProposalNumber"];
	$GIVEN_BENAFICIARY = $row["GIVEN_BENAFICIARY"];

    if($GIVEN_BENAFICIARY != '1'){
    $SQL_count0 = "select COUNT(id) as app0,
		sum(BENEFICIARY_NAME1 <> '') as benefi_no1,
		sum(BENEFICIARY_NAME2 <> '') as benefi_no2,
		sum(BENEFICIARY_NAME3 <> '') as benefi_no3,
		sum(INSURED_NAME2 <> '') as insured_no2,
		sum(INSURED_NAME3 <> '') as insured_no3,
		sum(INSURED_NAME4 <> '') as insured_no4,
		sum(INSURED_NAME5 <> '') as insured_no5
		from t_aig_app where ProposalNumber = '$ProposalNumber'
	";
		$result0 = mysqli_query($Conn, $SQL_count0) or die ("ไม่สามารถเรียกดูข้อมูลได้");
		while($row0 = mysqli_fetch_array($result0))
		{
			$benefi_no = $row0["benefi_no1"]+$row0["benefi_no2"]+$row0["benefi_no3"] ;
			$insured_no = $row0["insured_no2"]+$row0["insured_no3"]+$row0["insured_no4"]+$row0["insured_no5"]+1 ;
		}

	}else if($GIVEN_BENAFICIARY == '1'){ 

		$SQL_count0 = "select COUNT(id) as app0,
		sum(BENEFICIARY_NAME1 <> '') as benefi_no1,
		sum(BENEFICIARY_NAME2 <> '') as benefi_no2,
		sum(BENEFICIARY_NAME3 <> '') as benefi_no3,
		sum(INSURED_NAME2 <> '') as insured_no2,
		sum(INSURED_NAME3 <> '') as insured_no3,
		sum(INSURED_NAME4 <> '') as insured_no4,
		sum(INSURED_NAME5 <> '') as insured_no5
		from t_aig_app where ProposalNumber = '$ProposalNumber'
	";
		$result0 = mysqli_query($Conn, $SQL_count0) or die ("ไม่สามารถเรียกดูข้อมูลได้");
		while($row0 = mysqli_fetch_array($result0))
		{

			$benefi_no = '1'; 
			$insured_no = $row0["insured_no2"]+$row0["insured_no3"]+$row0["insured_no4"]+$row0["insured_no5"]+1;
		}
		
		
	}

	$benefi_no_count = $benefi_no_count + $benefi_no ;
	$insured_no_count = $insured_no_count + $insured_no ;

} 



$result_count = mysqli_query($Conn, "select COUNT(id) as app from t_aig_app where AppStatus = 'QC_Approved' and (Approved_Date between '$startdate' and '$enddate') ;");
$Policy_Holder_Count = mysqli_result($result_count, 0);
$Policy_Cert_Count = $Policy_Holder_Count;
$Payment_Details_Count = $Policy_Holder_Count;
$Policy_Cert_Rider = $Policy_Cert_Rider;
$Policy_Cert_Premium = $Policy_Holder_Count;
$Policy_Modifier_Count = $Policy_Holder_Count*6;

$Row_Count = $benefi_no_count+$insured_no_count+$Policy_Holder_Count+$Policy_Cert_Count+$Payment_Details_Count+$Policy_Cert_Rider+$Policy_Cert_Premium+$Policy_Modifier_Count ;




    // $name = "TPA File_".$currentdatetime.".txt";
	$name = "TPA_File_Family.txt";
	$fh=fopen($root.$name, "w");

	//TYPE HEADER 00
	fwrite($fh, "00");
	fwrite($fh,  str_pad_unicode($Row_Count,8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($Policy_Holder_Count,6,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($Policy_Cert_Count,6,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($benefi_no_count,6,' ',STR_PAD_RIGHT) ); // Beneficiary Count
	fwrite($fh,  str_pad_unicode($Payment_Details_Count,6,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($Policy_Cert_Rider,6,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($insured_no_count,6,' ',STR_PAD_RIGHT) ); // Named Insured
	fwrite($fh,  str_pad_unicode($Policy_Cert_Premium,6,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($Policy_Modifier_Count,6,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");



// TYPE 11
 $result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysqli_fetch_array($result))
{

	$TITLE = getTitleCode($row["TITLE"]);
	if($TITLE == '-'){
		$FIRSTNAME = $row["FIRSTNAME"].' ('.$row["TITLE"].')';
	}else{
		$FIRSTNAME = $row["FIRSTNAME"];
	}

	$LASTNAME = $row["LASTNAME"];
	$ADDRESS1 = $row["ADDRESSNO1"].' '.$row["BUILDING1"];
	$ADDRESS2 = $row["MOO1"].' '.$row["SOI1"].' '.$row["ROAD1"];
	$ADDRESS3 = $row["SUB_DISTRICT1"].' '.$row["DISTRICT1"];
	$ADDRESS4 = '';
	$PROVINCE1 = $row["PROVINCE1"];
	$ZIPCODE1 = $row["ZIPCODE1"];

	$HOME_PHONE = $row["TELEPHONE1"];
	if($HOME_PHONE == ''){
		$HOMEPHONE = '-';
	}else{
		// 020234242 0809009000
		$HOMEPHONE = substr($HOME_PHONE, 0, 1).'-'.substr($HOME_PHONE, 1, 4).'-'.substr($HOME_PHONE, 5, 9) ;
	}

	$MOBILE_PHONE = $row["MOBILE1"];
	if($MOBILE_PHONE == ''){
		$MOBILEPHONE = '-';
	}else{
		// 020234242 0815653211
		$MOBILEPHONE = substr($MOBILE_PHONE, 0, 2).'-'.substr($MOBILE_PHONE, 2, 4).'-'.substr($MOBILE_PHONE, 6, 10) ;
	}

	$DOB = $row["DOB"];
		// 20/10/2023
	$DOB = substr($DOB, 0, 2).substr($DOB, 3, 2).substr($DOB, 6, 4) ;

	$SEX = $row["SEX"];
	if($SEX == 'ชาย'){
		$SEX = 'M';
	}else{
		$SEX = 'F';
	}

	fwrite($fh, "11");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh,  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($ADDRESS1,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($ADDRESS2,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($ADDRESS3,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($ADDRESS4,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PROVINCE1,30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($ZIPCODE1,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($HOMEPHONE,12,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('-',12,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($MOBILEPHONE,12,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(($row["IDCARD"]),20,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  $SEX);
	fwrite($fh,  str_pad_unicode(getOccCode($row["OCCUPATIONAL"]),3,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");
}

// TYPE 12
$result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysqli_fetch_array($result))
{

	fwrite($fh, "12");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode(' ',6,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',14,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',15,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");

}

// TYPE 13
$result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysqli_fetch_array($result))
{
    // Chk ทายาทโดยธรรม
	$GIVEN_BENAFICIARY = $row["GIVEN_BENAFICIARY"];
	if($GIVEN_BENAFICIARY != '1'){ // ไม่ใช่ ทายาทโดยธรรม

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
	

	fwrite($fh, "13");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode($BENEFICIARY_TITLE1,5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh,  str_pad_unicode($BENEFICIARY_NAME1,30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_LASTNAME1,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('-',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('00000',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_BENEFIT1,6,' ',STR_PAD_RIGHT));
	fwrite($fh,  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_RELATIONSHIP1,1,' ',STR_PAD_RIGHT));
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh, "\r\n");

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
	

	fwrite($fh, "13");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode($BENEFICIARY_TITLE2,5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh,  str_pad_unicode($BENEFICIARY_NAME2,30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_LASTNAME2,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('-',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('00000',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_BENEFIT2,6,' ',STR_PAD_RIGHT));
	fwrite($fh,  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_RELATIONSHIP2,1,' ',STR_PAD_RIGHT));
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh, "\r\n");
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
	

	fwrite($fh, "13");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode($BENEFICIARY_TITLE3,5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh,  str_pad_unicode($BENEFICIARY_NAME3,30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_LASTNAME3,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('-',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('00000',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_BENEFIT3,6,' ',STR_PAD_RIGHT));
	fwrite($fh,  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($BENEFICIARY_RELATIONSHIP3,1,' ',STR_PAD_RIGHT));
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh, "\r\n");
	}

	}else{ // ทายาทโดยธรรม

		fwrite($fh, "13");
		fwrite($fh,  $PLAN_NO);
		fwrite($fh,  $row['ProposalNumber']);
		fwrite($fh,  str_pad_unicode('-',5,' ',STR_PAD_RIGHT) );
		fwrite($fh,  " ");
		fwrite($fh,  str_pad_unicode('ทายาทโดยธรรม',30,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode('-',45,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode('-',30,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode('THD',5,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode('00000',10,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode('Thailand',30,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode('100',6,' ',STR_PAD_RIGHT));
		fwrite($fh,  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode('P',1,' ',STR_PAD_RIGHT));
		fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
		fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
		fwrite($fh,  " ");
		fwrite($fh, "\r\n");	

	} // End ทายาทโดยธรรม

}

// TYPE 14
$result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysqli_fetch_array($result))
{
	$PAYMENTFREQUENCY = $row["PAYMENTFREQUENCY"];
	if($PAYMENTFREQUENCY == 'รายเดือน'){
		$PAYMENTFREQUENCY = 'M';
	}else{
		$PAYMENTFREQUENCY = 'Y';
	}

	$ACCOUNT_NAME = $row["FIRSTNAME"].' '.$row["LASTNAME"];

	fwrite($fh, "14");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode($ACCOUNT_NUMBER,16,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PAYMENTFREQUENCY,1,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('',6,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('',5,' ',STR_PAD_RIGHT) ); // Credit Card Code
	fwrite($fh,  str_pad_unicode($ACCOUNT_NAME,45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($ACCOUNT_NUMBER,16,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',14,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',16,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',45,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',5,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('CRED',4,' ',STR_PAD_RIGHT) ); // Method of Payment Code
	fwrite($fh,  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh,  " "); // First Payment Collected Flag 
	fwrite($fh,  str_pad_unicode(' ',4,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',50,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',37,' ',STR_PAD_RIGHT) );
	fwrite($fh,  "-"); // PA Tax Consent
	fwrite($fh,  str_pad_unicode(' ',4,' ',STR_PAD_RIGHT) );

	fwrite($fh,  " ");
	fwrite($fh, "\r\n");

}

// TYPE 15
$result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysqli_fetch_array($result))
{

	$Approved_Date_D = $row["Approved_Date"]; // 20230831
	$Approved_Date = substr($Approved_Date_D, 6, 2).substr($Approved_Date_D, 4, 2).substr($Approved_Date_D, 0, 4) ;

	$Policy_Effective = substr($Approved_Date_D, 4, 2).'/'.substr($Approved_Date_D, 6, 2).'/'.substr($Approved_Date_D, 0, 4) ;
	//$Policy_Effective = '03-31-2023';
	$Policy_Effective_Date = date('m/d/Y',strtotime($Policy_Effective . "+1 days"));

	$Policy_Expire_Date = date('dmY',strtotime($Policy_Effective_Date . "+1 year"));
	$Policy_Effective_Date = date('dmY',strtotime($Policy_Effective . "+1 days"));

	
	fwrite($fh, "15");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode($Approved_Date,8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($CAMPAIGN_CODE,7,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('1',4,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($CAMPAIGN_TEST_CODE,7,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($Policy_Effective_Date,8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($Policy_Expire_Date,8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  " ");
	fwrite($fh,  str_pad_unicode(' ',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',5,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");

}


// TYPE 16
$result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
while($row = mysqli_fetch_array($result))
{

$TITLE = getTitleCode($row["TITLE"]);
if($TITLE == '-'){
	$FIRSTNAME = $row["FIRSTNAME"].' ('.$row["TITLE"].')';
}else{
	$FIRSTNAME = $row["FIRSTNAME"];
}

$LASTNAME = $row["LASTNAME"];

$DOB = $row["DOB"];
		// 20/10/2023
	$DOB = substr($DOB, 0, 2).substr($DOB, 3, 2).substr($DOB, 6, 4) ;

$SEX = $row["SEX"];
	if($SEX == 'ชาย'){
		$SEX = 'M';
	}else if($SEX == 'หญิง'){
		$SEX = 'F';
	}

$IDCARD = $row["IDCARD"];

fwrite($fh, "16");
fwrite($fh,  $PLAN_NO);
fwrite($fh,  $row['ProposalNumber']);
fwrite($fh,  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) );
fwrite($fh, " ");
fwrite($fh,  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode('P',1,' ',STR_PAD_RIGHT) ); // Relationship Code
fwrite($fh, " ");
fwrite($fh,  $SEX);
fwrite($fh,  str_pad_unicode($IDCARD,20,' ',STR_PAD_RIGHT) );
fwrite($fh, "\r\n");

// CHK INSURED_NAME2
$INSURED_NAME2 = $row["INSURED_NAME2"];
if($INSURED_NAME2 != ''){

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

		$SEX = $row["INSURED_SEX2"];
			if($SEX == 'ชาย'){
				$SEX = 'M';
			}else if($SEX == 'หญิง'){
				$SEX = 'F';
			}
		
		$BENEFICIARY_RELATIONSHIP = getRelationCode($row["INSURED_RELATIONSHIP2"]);
		
fwrite($fh, "16");
fwrite($fh,  $PLAN_NO);
fwrite($fh,  $row['ProposalNumber']);
fwrite($fh,  str_pad_unicode('1',2,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) );
fwrite($fh, " ");
fwrite($fh,  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($BENEFICIARY_RELATIONSHIP,1,' ',STR_PAD_RIGHT) ); // Relationship Code
fwrite($fh, " ");
fwrite($fh,  $SEX);
fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
fwrite($fh, "\r\n");

} // END INSURED_NAME2


// CHK INSURED_NAME3
$INSURED_NAME3 = $row["INSURED_NAME3"];
if($INSURED_NAME3 != ''){

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
			}
		
		$BENEFICIARY_RELATIONSHIP = getRelationCode($row["INSURED_RELATIONSHIP3"]);
		
fwrite($fh, "16");
fwrite($fh,  $PLAN_NO);
fwrite($fh,  $row['ProposalNumber']);
fwrite($fh,  str_pad_unicode('2',2,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) );
fwrite($fh, " ");
fwrite($fh,  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($BENEFICIARY_RELATIONSHIP,1,' ',STR_PAD_RIGHT) ); // Relationship Code
fwrite($fh, " ");
fwrite($fh,  $SEX);
fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
fwrite($fh, "\r\n");

} // END INSURED_NAME3


// CHK INSURED_NAME4
$INSURED_NAME4 = $row["INSURED_NAME4"];
if($INSURED_NAME4 != ''){

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
			}
		
		$BENEFICIARY_RELATIONSHIP = getRelationCode($row["INSURED_RELATIONSHIP4"]);
		
fwrite($fh, "16");
fwrite($fh,  $PLAN_NO);
fwrite($fh,  $row['ProposalNumber']);
fwrite($fh,  str_pad_unicode('3',2,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) );
fwrite($fh, " ");
fwrite($fh,  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($BENEFICIARY_RELATIONSHIP,1,' ',STR_PAD_RIGHT) ); // Relationship Code
fwrite($fh, " ");
fwrite($fh,  $SEX);
fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
fwrite($fh, "\r\n");

} // END INSURED_NAME4


// CHK INSURED_NAME5
$INSURED_NAME5 = $row["INSURED_NAME5"];
if($INSURED_NAME4 != ''){

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
			}
		
		$BENEFICIARY_RELATIONSHIP = getRelationCode($row["INSURED_RELATIONSHIP5"]);
		
fwrite($fh, "16");
fwrite($fh,  $PLAN_NO);
fwrite($fh,  $row['ProposalNumber']);
fwrite($fh,  str_pad_unicode('4',2,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($DOB,8,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($TITLE,5,' ',STR_PAD_RIGHT) );
fwrite($fh, " ");
fwrite($fh,  str_pad_unicode($FIRSTNAME,30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($LASTNAME,45,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',3,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode(' ',30,' ',STR_PAD_RIGHT) );
fwrite($fh,  str_pad_unicode($BENEFICIARY_RELATIONSHIP,1,' ',STR_PAD_RIGHT) ); // Relationship Code
fwrite($fh, " ");
fwrite($fh,  $SEX);
fwrite($fh,  str_pad_unicode(' ',20,' ',STR_PAD_RIGHT) );
fwrite($fh, "\r\n");

} // END INSURED_NAME4

}


// TYPE 17
$result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysqli_fetch_array($result))
{
	$PRODUCT_CODE1 = '2AD';
	$PRODUCT_CODE2 = '2DMBM';
	$PRODUCT_CODE3 = '2MDAS';
	$PRODUCT_CODE4 = '2PTD';
	$PRODUCT_CODE5 = '2MC';
	$PRODUCT_CODE6 = '2AMR';

	$PRODUCT_NAME = $row["PRODUCT_NAME"];
	$COVERAGE_NAME = $row["COVERAGE_NAME"];

		$SQL17 = "select * from `t_aig_family_product` where PRODUCTNAME_TH = '$PRODUCT_NAME' and PLAN = '$COVERAGE_NAME' " ;
		$result17 = mysqli_query($Conn, $SQL17) or die ("ไม่สามารถเรียกดูข้อมูลได้");
			while($row17 = mysqli_fetch_array($result17))
		{
			$PLAN_LAYER_CODE = $row17["PLAN_LAYER_CODE"];
			$PLAN_RATE_CATEGORY_CODE = $row17["PLAN_RATE_CATEGORY_CODE"];
			$PLAN_RATE_BAND_CODE = $row17["PLAN_RATE_BAND_CODE"];
		}

	fwrite($fh, "17");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PRODUCT_CODE1,6,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");

	fwrite($fh, "17");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PRODUCT_CODE2,6,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");

	fwrite($fh, "17");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PRODUCT_CODE3,6,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");

	fwrite($fh, "17");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PRODUCT_CODE4,6,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");

	fwrite($fh, "17");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PRODUCT_CODE5,6,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");

	fwrite($fh, "17");
	fwrite($fh,  $PLAN_NO);
	fwrite($fh,  $row['ProposalNumber']);
	fwrite($fh,  str_pad_unicode('0',2,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PRODUCT_CODE6,6,' ',STR_PAD_RIGHT) );
    fwrite($fh,  str_pad_unicode($PLAN_LAYER_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_CATEGORY_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode($PLAN_RATE_BAND_CODE,10,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode('THD',8,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',9,' ',STR_PAD_RIGHT) );
	fwrite($fh,  str_pad_unicode(' ',2,' ',STR_PAD_RIGHT) );
	fwrite($fh, "\r\n");

}


	fclose($fh);
	mb_internal_encoding('utf-8'); // @important
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