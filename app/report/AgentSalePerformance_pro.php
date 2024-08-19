<?php


ini_set("display_errors",0);

date_default_timezone_set("Asia/Bangkok");

include("../function/StartConnect.inc");
include("../function/currentDateTime.inc");

function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }

$root = "temp/";
$start = $_POST["startdate"];
$end = $_POST["enddate"];
$camp = 'Motor';
$campaign_id = '2';

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
require_once dirname(__FILE__) . '/../PHPExcel/Classes/PHPExcel/IOFactory.php';



//echo date('H:i:s') , " Load from Excel5 template" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("templates/AgentSalePerformance.xls");

$dif_date = (DateDiff($startdate2,$enddate2))+1;

$objPHPExcel->getActiveSheet()->setCellValue('B1', $camp);
$objPHPExcel->getActiveSheet()->setCellValue('B3', $report_date);



$baseRow = 7;
$row = 0;
$r = 0;
$i = 0 ;
$strNewDate = $startdate2 ;
$endNewDate = $enddate2 ;

$sum_uesd_accu = 0;
$sum_contact_call = 0;

$workday = $dif_date ;

$TotalLeadAttempted = 0;
$CallAttempt = 0;
$AttempPerLead = 0;

$SQL_Agent = "select agent_id,First_name,Last_name from t_agents where level_id = '1' and is_active = '1'  " ;
$result = mysqli_query($Conn, $SQL_Agent) or die ("ไม่สามารถเรียกดูข้อมูลได้");
while($row = mysqli_fetch_array($result))
	{
		
	$agent_id = $row["agent_id"];
    $agent_name = $row["First_name"].' '.$row["Last_name"];
    
    $SQL_count=  mysqli_query($Conn, " SELECT COUNT(DISTINCT calllist_id) from t_call_trans where (create_date BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and agent_id = '$agent_id' ");
    $TotalLeadAttempted = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " SELECT COUNT(calllist_id) from t_calllist_agent where  campaign_id = '$campaign_id' and  agent_id = '$agent_id' and last_wrapup_id is null ");
    $TotalLeadPossession = mysqli_result($SQL_count, 0);
	
    $SQL_count=  mysqli_query($Conn, " SELECT COUNT(DISTINCT calllist_id) from t_call_trans where (create_date BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and agent_id = '$agent_id' 
	and  (`wrapup_option_id` = '1' or  `wrapup_option_id` = '2'  or `wrapup_option_id` = '3' or `wrapup_option_id` = '6'  or `wrapup_option_id` = '7' or `wrapup_option_id` = '9' ) ");
    $LeadPerTmr = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " SELECT COUNT(calllist_id) from t_call_trans where (create_date BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and agent_id = '$agent_id' ");
    $CallAttempt = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " SELECT COUNT(calllist_id) from t_call_trans where (create_date BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and agent_id = '$agent_id' and agent_id = '$agent_id' and wrapup_id = '400||' ");
    $success = mysqli_result($SQL_count, 0);
    
    
	$AttempPerLead = @($CallAttempt / $TotalLeadAttempted) ;
    if($AttempPerLead === false ){
        $AttempPerLead = 0;
    }

    $conversion = @($success / $CallAttempt);
    if($conversion === false ){
        $conversion = 0;
    }
	
	$conversion2 = @($success / $LeadPerTmr);
    if($conversion2 === false ){
        $conversion2 = 0;
    }
	
	
	$row = $baseRow + 1  ;
	$row2 = $row - 1 ;
	$r = $r+1;	
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, $agent_name)
                                   ->setCellValue('B'.$row2, $TotalLeadAttempted)
                                   ->setCellValue('C'.$row2, $TotalLeadPossession)
                                   ->setCellValue('D'.$row2, $LeadPerTmr)
                                   ->setCellValue('E'.$row2, $CallAttempt)
                                   ->setCellValue('F'.$row2, $AttempPerLead)
                                   ->setCellValue('H'.$row2, $success)	
                                   ->setCellValue('I'.$row2, $conversion)
								   ->setCellValue('J'.$row2, $conversion2)					   
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
$fname = "Agent_Sale_Performance.xls";
$objWriter->save($droot.$fname);
//$objWriter->save(str_replace('.php', '.xls', __FILE__));

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing file" , EOL;
//echo 'File has been created in ' , getcwd() , EOL;

echo  $fname;
