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
$camp = 'Motor';
$camp_id = '2';

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
$objPHPExcel = $objReader->load("templates/DailyReportByAgentMotor.xls");

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
	
    
	$SQL_count=  mysql_query(" SELECT COUNT(DISTINCT calllist_id) from t_call_trans where create_date like '$strNewDate%' and campaign_id = '$camp_id' and (number_of_call IS NULL or number_of_call = '0')  and agent_id = '$agent_id'   ");
	$used_new = mysql_result($SQL_count, 0);
	
	$SQL_count=  mysql_query(" SELECT COUNT(DISTINCT calllist_id) from t_call_trans where create_date like '$strNewDate%' and campaign_id = '$camp_id' and  (number_of_call != '0' and number_of_call IS NOT NULL) and agent_id = '$agent_id'   ");
	$used_old = mysql_result($SQL_count, 0);
	
	$used_accu = $used_new + $used_old ;
	
	$SQL_count=  mysql_query(" SELECT COUNT(call_id) from t_call_trans where create_date like '$strNewDate%' and campaign_id = '$camp_id' and agent_id = '$agent_id'   ");
	$attemp_call = mysql_result($SQL_count, 0);
	
	$SQL_count=  mysql_query(" SELECT COUNT(DISTINCT calllist_id) from t_call_trans where create_date like '$strNewDate%' and campaign_id = '$camp_id' and (wrapup_option_id != '8' and wrapup_option_id != '4' and wrapup_option_id != '5') and agent_id = '$agent_id'   ");
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
	
	$SQL_count=  mysql_query(" SELECT COUNT(id) from t_app where (Sale_Date between  '$startdate' and  '$enddate' ) and campaign_id = '$camp_id' and agent_id = '$agent_id' ");
	$count_app = mysql_result($SQL_count, 0);
	
	if($count_app <> '0'){
	$sale_con = $count_app / $contact_call ;
	}else{
		$sale_con = '0';
	}
	
	$SQL_count=  mysql_query(" SELECT sum(INSTALMENT_PREMIUM) from t_app where (Sale_Date between  '$startdate' and  '$enddate' )   and campaign_id = '$camp_id' and AppStatus = 'Success' and agent_id = '$agent_id'  ");
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
