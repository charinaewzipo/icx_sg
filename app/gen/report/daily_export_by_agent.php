<?php


ini_set("display_errors",0);

date_default_timezone_set("Asia/Bangkok");

include("../../function/StartConnect.inc");
include("../../function/currentDateTime.inc");

function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }

$root = "temp/";
$start = $_POST["startdate"];
$end = $_POST["enddate"];
$camp = 'Generali';

//$start = '14/10/2014';
//$end = '2014-12-30';

$start_dd = substr($start,0,2);    // 16/03/2016
$start_mm = substr($start,3,2);
$start_yy = substr($start,6,4);
$startdate = $start_yy.$start_mm.$start_dd;
$startdate2 = $start_yy.'-'.$start_mm.'-'.$start_dd;

$end_dd = substr($end,0,2);
$end_mm = substr($end,3,2);
$end_yy = substr($end,6,4) ;
$enddate =  $end_yy.$end_mm.$end_dd;
$enddate2 =  $end_yy.'-'.$end_mm.'-'.$end_dd;

//$startdate2 = '2016-10-01';
//$enddate2 =  '2016-10-10';



$report_date = $startdate.' - '.$enddate ;


/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../../PHPExcel/Classes/PHPExcel/IOFactory.php';



//echo date('H:i:s') , " Load from Excel5 template" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("templates/DailyReportByAgent.xls");

$dif_date = (DateDiff($startdate2,$enddate2))+1;

$objPHPExcel->getActiveSheet()->setCellValue('B1', $camp);
$objPHPExcel->getActiveSheet()->setCellValue('B3', $report_date);



$baseRow = 9;
$row = 0;
$r = 0;
$i = 0 ;
$strNewDate = $startdate2 ;

$sum_uesd_accu = 0;
$sum_contact_call = 0;

$workday = $dif_date ;

$SQL_Agent = "select agent_id,First_name,Last_name from t_agents where level_id = '1' and is_active = '1'  " ;
$result = mysql_query($SQL_Agent,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
while($row = mysql_fetch_array($result))
	{
		
	$agent_id = $row["agent_id"];
	$agent_name = $row["First_name"].' '.$row["Last_name"];
	
    
	$SQL_count=  mysql_query(" SELECT COUNT(DISTINCT calllist_id) from t_call_trans where create_date like '$strNewDate%' and campaign_id = '1' and (number_of_call IS NULL or number_of_call = '0')  and agent_id = '$agent_id'   ");
	$used_new = mysql_result($SQL_count, 0);
	
	$SQL_count=  mysql_query(" SELECT COUNT(DISTINCT calllist_id) from t_call_trans where create_date like '$strNewDate%' and campaign_id = '1' and  (number_of_call != '0' and number_of_call IS NOT NULL) and agent_id = '$agent_id'   ");
	$used_old = mysql_result($SQL_count, 0);
	
	$used_accu = $used_new + $used_old ;
	
	$SQL_count=  mysql_query(" SELECT COUNT(call_id) from t_call_trans where create_date like '$strNewDate%' and campaign_id = '1' and agent_id = '$agent_id'   ");
	$attemp_call = mysql_result($SQL_count, 0);
	
	$SQL_count=  mysql_query(" SELECT COUNT(DISTINCT calllist_id) from t_call_trans where create_date like '$strNewDate%' and campaign_id = '1' and (wrapup_option_id != '8' and wrapup_option_id != '4' and wrapup_option_id != '5') and agent_id = '$agent_id'   ");
	$contact_call = mysql_result($SQL_count, 0);
	
	$sum_uesd_accu = $sum_uesd_accu + $used_accu ;
	$sum_contact_call = $sum_contact_call + $contact_call ;
	
	if( $contact_call <> '0' and $used_accu <> '0'){
			$daily_con_p = $contact_call / $used_accu ;
	}else {
		$daily_con_p = 0 ;
	}
	
	if( $sum_contact_call <> '0' and $sum_uesd_accu <> '0'){
			$accu_daily_con_p = $sum_contact_call / $sum_uesd_accu ;
	}else {
		$accu_daily_con_p = 0 ;
	}
	
	$date_app = str_replace("-","",$strNewDate); // Cove Date
	
	$SQL_count=  mysql_query(" SELECT COUNT(id) from t_app where (Sale_Date between  '$startdate' and  '$enddate' ) and campaign_id = '1' and agent_id = '$agent_id' ");
	$count_app = mysql_result($SQL_count, 0);
	
	if($count_app <> '0'){
	$sale_con = $count_app / $contact_call ;
	}else{
		$sale_con = '0';
	}
	
	$SQL_count=  mysql_query(" SELECT sum(INSTALMENT_PREMIUM) from t_app where (Sale_Date between  '$startdate' and  '$enddate' )   and campaign_id = '1' and AppStatus = 'Success' and agent_id = '$agent_id'  ");
	$sum_AARP = mysql_result($SQL_count, 0);
	
	if($sum_AARP <> '0'){
		$sum_AARP = $sum_AARP;
	}else{
		$sum_AARP = '0' ;
	}
	
	$sum_AFYP_PA = 0 ;
	$sum_AFYP_Health = 0 ;
	
	$sum_FYP_PA = 0 ;
	$sum_FYP_Health = 0 ;
	

	$submit_FYP_PA = 0;
	$submit_FYP_Health = 0;
	
	$submit_AFYP_PA = 0;
	$submit_AFYP_Health = 0;
	
	$Y = 0;
	$Z = 0;
	$AA = 0;

	// count PA Submit
	$SQL_submit_PA_count=  mysql_query(" SELECT COUNT(id)  from `t_app` where campaign_id = '1' and  (Sale_Date between  '$startdate' and  '$enddate' )  and AppStatus <> 'Follow Doc' and camp = 'GenExclusive'  and agent_id = '$agent_id'   ");
	$SQL_submit_PA_App = mysql_result($SQL_submit_PA_count, 0);
	
		// count HP Submit
	$SQL_submit_HP_count=  mysql_query(" SELECT COUNT(id)  from `t_app` where campaign_id = '1'  and  (Sale_Date between  '$startdate' and  '$enddate' )  and AppStatus <> 'Follow Doc' and camp = 'GenHealth' and agent_id = '$agent_id'    ");
	$SQL_submit_HP_App = mysql_result($SQL_submit_HP_count, 0);
	
	///  check TARP Submit
	$SQL = "  select INSTALMENT_PREMIUM,camp,agent_id  from `t_app` where campaign_id = '1'   and  (Sale_Date between  '$startdate' and  '$enddate' )   and AppStatus <> 'Follow Doc'  and agent_id = '$agent_id'   " ;
	$result99 = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($dataRow = mysql_fetch_array($result99))
{

	$sb_premium_FYP_PA = 0;
	$sb_premium_AFYP_PA = 0;
	$sb_premium_FYP_Health = 0;
	$sb_premium_AFYP_Health = 0;


	$product_name = $dataRow["camp"];
	$INSTALMENT_PREMIUM = $dataRow["INSTALMENT_PREMIUM"];
	

	
	if($product_name == 'GenExclusive'){
			 $SQL2 = "select *  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row3 = mysql_fetch_array($result2))
				{
					$sb_premium_FYP_PA = $row3["premium_payment"];
					$sb_premium_AFYP_PA = $row3["premium"];
				}
	}elseif($product_name == 'GenHealth'){
		 $SQL2 = "select *  from t_health_lump_sum  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row3 = mysql_fetch_array($result2))
				{
					$sb_premium_FYP_Health = $row3["premium_payment"];
					$sb_premium_AFYP_Health = $row3["premium"];
				}
		
	}
	
	$submit_FYP_PA = $submit_FYP_PA + $sb_premium_FYP_PA;
	$submit_AFYP_PA = $submit_AFYP_PA + $sb_premium_AFYP_PA;
	
	$submit_FYP_Health = $submit_FYP_Health + $sb_premium_FYP_Health;
	$submit_AFYP_Health = $submit_AFYP_Health + $sb_premium_AFYP_Health;
		

}
	
	

// count PA Success
	$SQL_Success_PA_count=  mysql_query(" SELECT COUNT(id)  from `t_app` where campaign_id = '1'  and  (Approved_Date between  '$startdate' and  '$enddate' )  and AppStatus = 'Success' and camp = 'GenExclusive' and agent_id = '$agent_id'   ");
	$SQL_Success_PA_App = mysql_result($SQL_Success_PA_count, 0);
	
	// count PA Success
	$SQL_Success_HP_count=  mysql_query(" SELECT COUNT(id)  from `t_app` where campaign_id = '1'  and  (Approved_Date between  '$startdate' and  '$enddate' )  and AppStatus = 'Success' and camp = 'GenHealth' and agent_id = '$agent_id'   ");
	$SQL_Success_HP_App = mysql_result($SQL_Success_HP_count, 0);
	
	///  check TARP
	$SQL = "select INSTALMENT_PREMIUM,camp  from `t_app` where campaign_id = '1'  and  (Approved_Date between  '$startdate' and  '$enddate' )  and AppStatus = 'Success' and agent_id = '$agent_id'  " ;
    $result888 = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($dataRow = mysql_fetch_array($result888))
{
	
	$premium_FYP_PA = 0;
	$premium_AFYP_PA = 0;
	$premium_FYP_Health = 0;
	$premium_AFYP_Health = 0;

	$product_name = $dataRow["camp"];
	$INSTALMENT_PREMIUM = $dataRow["INSTALMENT_PREMIUM"];
	

	
	if($product_name == 'GenExclusive'){
			 $SQL2 = "select *  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row3 = mysql_fetch_array($result2))
				{
					$premium_FYP_PA = $row3["premium_payment"];
					$premium_AFYP_PA = $row3["premium"];
				}
	}elseif($product_name == 'GenHealth'){
		 $SQL2 = "select *  from t_health_lump_sum  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row3 = mysql_fetch_array($result2))
				{
					$premium_FYP_Health = $row3["premium_payment"];
					$premium_AFYP_Health = $row3["premium"];
				}
		
	}
	
	$sum_FYP_PA = $sum_FYP_PA + $premium_FYP_PA;
	$sum_AFYP_PA = $sum_AFYP_PA + $premium_AFYP_PA;
	
	$sum_FYP_Health = $sum_FYP_Health + $premium_FYP_Health;
	$sum_AFYP_Health = $sum_AFYP_Health + $premium_AFYP_Health;
		
	
}


    $Y = @(($SQL_Success_PA_App + $SQL_Success_HP_App) / $contact_call) ;
	$Z = @($SQL_Success_PA_App / ($SQL_Success_PA_App + $SQL_Success_HP_App));
	$AA = @($SQL_Success_HP_App / ($SQL_Success_PA_App + $SQL_Success_HP_App));
	
	if($Y == ''){
		$Y = '0';
	}
	if($Z == ''){
		$Z = '0';
	}
	if($AA == ''){
		$AA = '0';
	}

	
	$row = $baseRow + 1  ;
	$row2 = $row - 1 ;
	$r = $r+1;	
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, $agent_name)
								   ->setCellValue('B'.$row2, $used_new)
								   ->setCellValue('C'.$row2, $used_old)
								   ->setCellValue( 'D'.$row2, $used_accu )
								   ->setCellValue('E'.$row2, $attemp_call)
								   ->setCellValue('F'.$row2, $sum_uesd_accu)
								   ->setCellValue('G'.$row2, $contact_call)
								   ->setCellValue('H'.$row2, $sum_contact_call)
								   ->setCellValue('I'.$row2, $daily_con_p)
								   ->setCellValue('J'.$row2, $accu_daily_con_p)
								   ->setCellValue('K'.$row2, $count_app)
								   ->setCellValue('L'.$row2, $sale_con)
								   ->setCellValue('M'.$row2, $SQL_submit_PA_App)
								   ->setCellValue('N'.$row2, $submit_FYP_PA)
								    ->setCellValue('O'.$row2, $submit_AFYP_PA)
								   ->setCellValue('P'.$row2, $SQL_submit_HP_App)
								    ->setCellValue('Q'.$row2, $submit_FYP_Health)
								   ->setCellValue('R'.$row2, $submit_AFYP_Health)
								    ->setCellValue('S'.$row2, $SQL_Success_PA_App)
								   ->setCellValue('T'.$row2, $sum_FYP_PA)
								   ->setCellValue('U'.$row2, $sum_AFYP_PA)
									->setCellValue('V'.$row2, $SQL_Success_HP_App)
								   ->setCellValue('W'.$row2, $sum_FYP_Health)
								   ->setCellValue('X'.$row2, $sum_AFYP_Health)
								   ->setCellValue('Y'.$row2, $Y)
								   ->setCellValue('Z'.$row2, $Z)	
								   ->setCellValue('AA'.$row2, $AA)								   
								  ;

								 
	$baseRow = $baseRow + 1 ;
	$sum_uesd_accu = 0;
	$sum_contact_call = 0;
	$i++;
	
									 
}

$objPHPExcel->getActiveSheet()->setCellValue('B4', $workday);



//echo date('H:i:s') , " Write to Excel5 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$fname = "Daily_Report_By_Agent.xls";
$objWriter->save($droot.$fname);
//$objWriter->save(str_replace('.php', '.xls', __FILE__));

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing file" , EOL;
//echo 'File has been created in ' , getcwd() , EOL;

echo  $fname;
