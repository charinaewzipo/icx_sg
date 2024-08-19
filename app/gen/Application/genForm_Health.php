<?php


include("../../function/StartConnect.inc");

$Id = $_GET["Id"];
$ProposalNumber = $_GET["Id"];


 $SQL = "select  * from t_app  where  ProposalNumber = '$Id'" ;

 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 	while($row = mysql_fetch_array($result))
	{



			$data['ProposalNumber'] = $row["ProposalNumber"];
			$data['InsureName'] = $row["Title"].$row["Firstname"].' '.$row["Lastname"];
			$data['telephone1'] = $row["telephone1"];
			$data['Mobile1'] = $row["Mobile1"];
			
			$AddressNo1 = $row["AddressNo1"];
			$building1 = $row["building1"];
			if($building1 !=''){
				$building1 = ' '.$row["building1"];
			}else{
				$building1 = '';
			}
			
			$Moo1 = $row["Moo1"];
			if($Moo1 !=''){
				$Moo1 = ' ม.'.$row["Moo1"];
			}else{
				$Moo1 = '';
			}
			
			$Soi1 = $row["Soi1"];
			if($Soi1 !=''){
				$Soi1 = ' ซ.'.$row["Soi1"];
			}else{
				$Soi1 = '';
			}
			
			$Road1 = $row["Road1"];
			if($Road1 !=''){
				$Road1 = ' ถ.'.$row["Road1"];
			}else{
				$Road1 = '';
			}
			
			$province1 = $row["province1"];
			if($province1 == 'กรุงเทพมหานคร'){
				
				$province1 = ' '.$row["province1"];
				$Sub_district1 = ' '.$row["Sub_district1"];
				$district1 = ' '.$row["district1"];
							
			}else{
				
				$province1 = ' จ.'.$row["province1"];
				$Sub_district1 = ' ต.'.$row["Sub_district1"];
				$district1 = ' อ.'.$row["district1"];
					
			}
		
			$data['address1'] = $AddressNo1.$building1.$Moo1.$Soi1.$Road1.$Sub_district1.$district1.$province1;
			$data['zipcode1'] = $row["zipcode1"];
			
			$data['IdCard'] = $row["IdCard"];
			$data['IdCard_from_distric'] = $row["IdCard_from_distric"];
			$data['IdCard_from_province'] = $row["IdCard_from_province"];
			$data['id_app_loc'] = 'ไทย';
			
			$IdCardExpire = $row["IdCardExpire"];    //  14/09/1980
			$IdCardExpire_DDMM = substr($IdCardExpire,0,6);
			$IdCardExpire_YYYY =  (substr($IdCardExpire,6,4)) + 543 ;
			$data['IdCardExpire'] = $IdCardExpire_DDMM.$IdCardExpire_YYYY ;
			
			$data['ADE_AT_RCD'] = $row["ADE_AT_RCD"];
			
			$DOB = $row["DOB"];    //  12/09/2016
			$DOB_DDMM = substr($DOB,0,6);
			$DOB_YYYY =  (substr($DOB,6,4)) + 543 ;
			$data['DOB'] = $DOB_DDMM.$DOB_YYYY ;
			
			$data['HEIGHT'] = $row["HEIGHT"];
			$data['WEIGHT'] = $row["WEIGHT"];
			$data['Nationality'] = $row["Nationality"];
			$data['OccupationalCategory'] = $row["OccupationalCategory"];
			$data['OCCUPATION_POSITION'] = $row["OCCUPATION_POSITION"];
			$data['OCCUPATION_DETAILS'] = $row["OCCUPATION_DETAILS"];
			
			$OccupationalCategory = $row["OccupationalCategory"];
			 $SQL2 = "select class  from t_occupation  where `desc` = '$OccupationalCategory'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row2 = mysql_fetch_array($result2))
				{
					$Occ_level = $row2["class"];	
				}
					
			$data['Occ_level'] = $Occ_level ;
			$data['AnnualIncome'] = $row["AnnualIncome"];
			
			$AddressNo3 = $row["AddressNo3"];
			$building3 = $row["building3"];
			if($building3 !=''){
				$building3 = ' '.$row["building3"];
			}else{
				$building3 = '';
			}
			
			$Moo3 = $row["Moo3"];
			if($Moo3 !=''){
				$Moo3 = ' ม.'.$row["Moo3"];
			}else{
				$Moo3 = '';
			}
			
			$Soi3 = $row["Soi3"];
			if($Soi3 !=''){
				$Soi3 = ' ซ.'.$row["Soi3"];
			}else{
				$Soi3 = '';
			}
			
			$Road3 = $row["Road3"];
			if($Road3 !=''){
				$Road3 = ' ถ.'.$row["Road3"];
			}else{
				$Road3 = '';
			}
			
			$province3 = $row["province3"];
			if($province3 == 'กรุงเทพมหานคร'){
				
				$province3 = ' '.$row["province3"];
				$Sub_district3 = ' '.$row["Sub_district3"];
				$district3 = ' '.$row["district3"];
							
			}else{
				
				$province3 = ' จ.'.$row["province3"];
				$Sub_district3 = ' ต.'.$row["Sub_district3"];
				$district3 = ' อ.'.$row["district3"];
					
			}
			
			$zipcode3 = $row["zipcode3"];
			$data['address2'] = $AddressNo3.$building3.$Moo3.$Soi3.$Road3.$Sub_district3.$district3.$province3.' '.$zipcode3 ;
			
			
			$data['BENEFICIARY_NAME1'] = $row["BENEFICIARY_TITLE1"].$row["BENEFICIARY_NAME1"].' '.$row["BENEFICIARY_LASTNAME1"] ;
			$data['BENEFICIARY_AGE1'] = $row["BENEFICIARY_AGE1"];
			$data['BENEFICIARY_RELATIONSHIP1'] = $row["BENEFICIARY_RELATIONSHIP1"];
			
			$data['BENEFICIARY_NAME2'] = $row["BENEFICIARY_TITLE2"].$row["BENEFICIARY_NAME2"].' '.$row["BENEFICIARY_LASTNAME2"] ;
			$data['BENEFICIARY_AGE2'] = $row["BENEFICIARY_AGE2"];
			$data['BENEFICIARY_RELATIONSHIP2'] = $row["BENEFICIARY_RELATIONSHIP2"];
			
			$data['BENEFICIARY_NAME3'] = $row["BENEFICIARY_TITLE3"].$row["BENEFICIARY_NAME3"].' '.$row["BENEFICIARY_LASTNAME3"] ;
			$data['BENEFICIARY_AGE3'] = $row["BENEFICIARY_AGE3"];
			$data['BENEFICIARY_RELATIONSHIP3'] = $row["BENEFICIARY_RELATIONSHIP3"];
			
			$data['BENEFICIARY_NAME4'] = $row["BENEFICIARY_TITLE4"].$row["BENEFICIARY_NAME4"].' '.$row["BENEFICIARY_LASTNAME4"] ;
			$data['BENEFICIARY_AGE4'] = $row["BENEFICIARY_AGE4"];
			$data['BENEFICIARY_RELATIONSHIP4'] = $row["BENEFICIARY_RELATIONSHIP4"];
			
			
			$Approved_Date = $row["Approved_Date"];  //20160915
			$Approved_Date_DD = substr($Approved_Date,6,2);
			$Approved_Date_MM = substr($Approved_Date,4,2);
			$Approved_Date_YY = (substr($Approved_Date,0,4))+543 ;
			
			$data['Approved_Date'] = $Approved_Date_DD.'/'.$Approved_Date_MM.'/'.$Approved_Date_YY ;
			
			$data['Approved_Time'] = $row["Approved_Time"];
			
			
			
			
			$INSTALMENT_PREMIUM = $row["INSTALMENT_PREMIUM"];
			 $SQL2 = "select *  from t_health_lump_sum  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row2 = mysql_fetch_array($result2))
				{
					$plan_code = $row2["plan_code"];
					$premium = $row2["premium"];	
				}
			
			
			$data['COVERAGE_NAME'] = $plan_code ;
			$data['Premium'] = number_format($premium, 2, '.', ',');
			$data['INSTALMENT_PREMIUM'] = number_format($INSTALMENT_PREMIUM, 2, '.', ',');
			
			$PaymentFrequency = $row["PaymentFrequency"];
			if($PaymentFrequency == 'รายเดือน' ){
				$data['PaymentFrequency_M'] = 'Yes' ;
			}else{
				$data['PaymentFrequency_Y'] = 'Yes' ;
			}
			
			// เงินสด
			$CardType = $row["CardType"];
			if($CardType == 'เงินสด'){
			$data['AccountNo'] = '';
			$data['ExpiryDate'] = '';
			$data['54'] =  'Yes' ;
			$data['bank_payin'] = $row["Bank"];
			}else{
			$data['AccountNo'] = $row["AccountNo"];
			$data['ExpiryDate'] = $row["ExpiryDate"];
			$data['53'] =  'Yes' ;
			}
			
			
			$Answer1_1 = $row["Answer1_1"];
			if($Answer1_1 == '0' ){
				$data['Answer1_1_N'] = 'Yes' ;
			}else{
				$data['Answer1_1_Y'] = 'Yes' ;
			}
			
			$data['Answer1_2'] = $row["Answer1_2"];
			$data['Answer1_3'] = $row["Answer1_3"];
			
			$Answer2_1 = $row["Answer2_1"];
			if($Answer2_1 == '0' ){
				$data['Answer2_1_N'] = 'Yes' ;
			}else{
				$data['Answer2_1_Y'] = 'Yes' ;
			}
			
			$data['Answer2_2'] = $row["Answer2_2"];
			$data['Answer2_3'] = $row["Answer2_3"];
			$data['Answer2_4'] = $row["Answer2_4"];
			
			$Answer3_1 = $row["Answer3_1"];
			if($Answer3_1 == '0' ){
				$data['Answer3_1_N'] = 'Yes' ;
			}else{
				$data['Answer3_1_Y'] = 'Yes' ;
			}
			
			$data['Answer3_2'] = $row["Answer3_2"];
			
			$Answer4_1 = $row["Answer4_1"];
			if($Answer4_1 == '0' ){
				$data['Answer4_1_N'] = 'Yes' ;
			}else{
				$data['Answer4_1_Y'] = 'Yes' ;
			}
			$data['Answer4_2'] = $row["Answer4_2"];
			
			$Answer5_1 = $row["Answer5_1"];
			if($Answer5_1 == '0' ){
				$data['Answer5_1_N'] = 'Yes' ;
			}else{
				$data['Answer5_1_Y'] = 'Yes' ;
			}
			$data['Answer5_2'] = $row["Answer5_2"];
			
			$Answer6_1 = $row["Answer6_1"];
			if($Answer6_1 == '0' ){
				$data['Answer6_1_N'] = 'Yes' ;
			}else{
				$data['Answer6_1_Y'] = 'Yes' ;
			}
			$data['Answer6_2'] = $row["Answer6_2"];
			
			$Approved_Date = $row["Approved_Date"];
			$Approved_Time = $row["Approved_Time"];
			
			$data['app_dd'] = $Approved_Date_DD ;
			$data['app_mm'] = $Approved_Date_MM ;
			$data['app_yyyy'] = $Approved_Date_YY ;
			
			$payment_relation = $row["payment_relation"];
			if($payment_relation != 'ผู้เอาประกัน'){		
				$data['payment_id'] = 'Yes' ;
				$data['payment_name'] = $row["payment_name"].' '.$row["payment_lastname"] ;
				$data['payment_bod'] = $row["payment_bod"];
				$data['payment_age'] = $row["payment_age"];
				$data['payment_idcard'] = $row["payment_idcard"];
				$data['payment_phone'] = $row["payment_phone"];
				$data['payment_occupation'] = $row["payment_occupation"];
				$data['payment_postion'] = $row["payment_postion"];
				$data['payment_tax'] = $row["payment_tax"];
				$data['payment_relation'] = $row["payment_relation"];
				
				
						$payment_tax = $row["payment_tax"];
						if($payment_tax == 'ต้องการ'){
							$data['payment_tax1'] = 'Yes' ;
						}else{
							$data['payment_tax2'] = 'Yes' ;
						}
				
				}
				
			
					

			$agent_id = $row["agent_id"];		
			$strSQL_agent = "SELECT * FROM t_agents WHERE agent_id = '$agent_id' ";
			$result2= mysql_query($strSQL_agent);
			while($objResult2 = mysql_fetch_array($result2))
			{
			$data['agent_name'] = $objResult2["sales_agent_name"] ;
			$data['agent_code'] = $objResult2["sales_agent_code"] ;
			}
			
			
			

            // if we got here, the data should be valid,
            // time to create our FDF file contents

            // need the function definition
            require_once 'createXFDF.php';

            // some variables to use

            // file name will be <the current timestamp>.fdf
            $fdf_file= $row["ProposalNumber"].'.fdf';

            // the directory to write the result in
            $fdf_dir=dirname(__FILE__).'/fdfFile';

            // need to know what file the data will go into
			 $pdf_doc='http://192.168.8.250/tubtim/app/gen/Application/Form/GenHealthFormv2.pdf';

            // generate the file content
            $fdf_data=createXFDF($pdf_doc,$data);

            // this is where you'd do any custom handling of the data
            // if you wanted to put it in a database, email the
            // FDF data, push ti back to the user with a header() call, etc.

            // write the file out

            if($fp=fopen($fdf_dir.'/'.$fdf_file,'w')){
               fwrite($fp,$fdf_data,strlen($fdf_data));
              // echo $fdf_file,' written successfully.';
			   
			   echo "<a href='Download.php?filename=$fdf_file'>Download </a>";


           }else{
               die('Unable to create file: '.$fdf_dir.'/'.$fdf_file);
           }
           fclose($fp);



}


 ?>
