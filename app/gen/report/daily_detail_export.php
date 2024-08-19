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
$search_agent = $_POST["search_agent"];
$search_team = $_POST["search_team"];
$camp = 'Generali';
$campaign_id = '1';

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
$objPHPExcel = $objReader->load("templates/Daily_Detail_Report.xls");

$dif_date = (DateDiff($startdate2,$enddate2))+1;

$objPHPExcel->getActiveSheet()->setCellValue('B1', $camp);
$objPHPExcel->getActiveSheet()->setCellValue('B3', $report_date);



$baseRow = 9;
$row = 0;
$r = 0;
$i = 0 ;
$strNewDate = $startdate2 ;
$workday = 0 ;

$sum_premium_FYP = '0';
$sum_premium_AFYP = '0';

$SQL_APP = "select *  from `v_success_report` where  ( Sale_Date BETWEEN '$startdate' and '$enddate')  and  AppStatus  != 'Follow Doc' " ;

$result = mysql_query($SQL_APP,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
while($dataRow = mysql_fetch_array($result))
{
	
	$ProposalNumber = $dataRow["ProposalNumber"];
	$custname = $dataRow["Title"].$dataRow["Firstname"].' '.$dataRow["Lastname"] ;
	$team_name = $dataRow["team_name"];
	$agent_name = $dataRow["first_name"].' '.$dataRow["last_name"];
	$INSTALMENT_PREMIUM = $dataRow["INSTALMENT_PREMIUM"];
	$camp = $dataRow["camp"];
	$AppStatus = $dataRow["AppStatus"];
	$Sale_Date = $dataRow["Sale_Date"];
	$Approved_Date = $dataRow["Approved_Date"];
	$Insure = "Generali";
	
	$product_name = $dataRow["camp"];
	
	if($product_name == 'GenExclusive'){
			 $SQL2 = "select *  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row3 = mysql_fetch_array($result2))
				{
					$premium_FYP = $row3["premium_payment"];
					$premium_AFYP= $row3["premium"];
				}
	}elseif($product_name == 'GenHealth'){
		 $SQL2 = "select *  from t_health_lump_sum  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row3 = mysql_fetch_array($result2))
				{
					$premium_FYP = $row3["premium_payment"];
					$premium_AFYP = $row3["premium"];
				}
		
	}
	
	
	$row = $baseRow + 1  ;
	$row2 = $row - 1 ;
	$r = $r+1;	
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, $ProposalNumber)
								   					  ->setCellValue('B'.$row2, $custname)	
													  ->setCellValue('C'.$row2, $team_name)
													  ->setCellValue('D'.$row2, $agent_name)	
													  ->setCellValue('E'.$row2, $premium_FYP)
													  ->setCellValue('F'.$row2, $premium_AFYP)
													  ->setCellValue('G'.$row2, $camp)	
													  ->setCellValue('H'.$row2, $Insure )
													  ->setCellValue('I'.$row2, $AppStatus)
													  ->setCellValue('J'.$row2, $Sale_Date)
													  ->setCellValue('K'.$row2, $Approved_Date)	
								   						  
								  ;
								  
	$sum_premium_FYP = 	$sum_premium_FYP + $premium_FYP;		
	$sum_premium_AFYP = 	$sum_premium_AFYP + $premium_AFYP;					  
	$baseRow = $baseRow + 1 ;
	$strNewDate = date ("Y-m-d", strtotime("+1 day", strtotime($strNewDate)));
	$i++;

}

$row_footer = 	$row2 + 3;
									
$objPHPExcel->getActiveSheet()->setCellValue('B4', $workday);

$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_footer, $sum_premium_FYP);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_footer, $sum_premium_AFYP);



//echo date('H:i:s') , " Write to Excel5 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$fname = "Daily_Detail_Report.xls";
$objWriter->save($droot.$fname);
//$objWriter->save(str_replace('.php', '.xls', __FILE__));

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing file" , EOL;
//echo 'File has been created in ' , getcwd() , EOL;

echo  $fname;
