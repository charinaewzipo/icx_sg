<?php


ini_set("display_errors",0);

date_default_timezone_set("Asia/Bangkok");

include("../../function/StartConnect.inc");
include("../../function/currentDateTime.inc");

$root = "temp/";
$start = $_POST["startdate"];
$end = $_POST["enddate"];

//$start = '14/10/2014';
//$end = '2014-12-30';

$start_dd = substr($start,0,2);    // 16/03/2016
$start_mm = substr($start,3,2);
$start_yy = substr($start,6,4);
$startdate = $start_yy.$start_mm.$start_dd;

$end_dd = substr($end,0,2);
$end_mm = substr($end,3,2);
$end_yy = substr($end,6,4) ;
$enddate =  $end_yy.$end_mm.$end_dd;


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

date_default_timezone_set('Europe/London');

/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../../PHPExcel/Classes/PHPExcel/IOFactory.php';



//echo date('H:i:s') , " Load from Excel5 template" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("templates/DRC_Exclusive_Template.xls");


$objPHPExcel->getActiveSheet()->setCellValue('S2', $currentdate_DCR2);
$objPHPExcel->getActiveSheet()->setCellValue('S3', $currentdate_DCR2);

$baseRow = 10;
$row = 0;
$r = 0;
$SQL = "select * from `t_app` where campaign_id = '1' and camp = 'GenExclusive' and ( Approved_Date between '$startdate' and '$enddate') and AppStatus = 'Success' and CardType != 'เงินสด' " ;
 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($dataRow = mysql_fetch_array($result))
{
	$row = $baseRow + 1  ;
	$row2 = $row - 1 ;
	$r = $r+1;
	
	$INSTALMENT_PREMIUM = $dataRow["INSTALMENT_PREMIUM"];
			 $SQL2 = "select *  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM'" ;
			 $result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 			while($row3 = mysql_fetch_array($result2))
				{
					$premium = $row3["premium"];
				}
				
	$AccountType = $dataRow["AccountType"];
	if($AccountType == 'MC01'){
		$AccountType = 'Master';
	}else{
		$AccountType = 'visa';
	}
	
	$agent_id = $dataRow["agent_id"];		
			$strSQL_agent = "SELECT * FROM t_agents WHERE agent_id = '$agent_id' ";
			$result2= mysql_query($strSQL_agent);
			while($objResult2 = mysql_fetch_array($result2))
			{
			$agent_name = $objResult2["sales_agent_name"] ;
			$agent_code = $objResult2["sales_agent_code"] ;
			}
	
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, $r)
	                              ->setCellValue('C'.$row2, $dataRow['ProposalNumber'])
	                              ->setCellValue('D'.$row2, $dataRow['Firstname'])
								  ->setCellValue('E'.$row2, $dataRow['Lastname'])
								  ->setCellValue('F'.$row2, $premium)
								  ->setCellValue('J'.$row2, $AccountType)
								  ->setCellValue('K'.$row2, $dataRow['Bank'])
								  ->setCellValue('L'.$row2, "'".$dataRow['AccountNo'])
								   ->setCellValue('M'.$row2, $dataRow['INSTALMENT_PREMIUM'])
								   ->setCellValue('N'.$row2, $dataRow['Approved_code'])  
								   ->setCellValue('O'.$row2, '✓') 
								   ->setCellValue('R'.$row2, $agent_name)  
								   ->setCellValue('S'.$row2, $agent_code)  
								  
								  ;
								 
	$baseRow = $baseRow + 1 ;
								 
} 


//echo date('H:i:s') , " Write to Excel5 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$fname = "Gen Exclusive_".$currentdate_DCR."_DCR.xls";
$objWriter->save($droot.$fname);
//$objWriter->save(str_replace('.php', '.xls', __FILE__));

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing file" , EOL;
//echo 'File has been created in ' , getcwd() , EOL;

echo  $fname;
