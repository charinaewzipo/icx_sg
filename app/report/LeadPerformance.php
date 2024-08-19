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
$objPHPExcel = $objReader->load("templates/LeadPerformance.xls");

$dif_date = (DateDiff($startdate2,$enddate2))+1;

$objPHPExcel->getActiveSheet()->setCellValue('B1', $camp);
$objPHPExcel->getActiveSheet()->setCellValue('B3', $report_date);



$baseRow = 8;
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

$SQL_Lead = " SELECT import_id ,create_date ,list_name ,total_records ,`status`, campaign_id from v_list_campaign where `status` = '1' and campaign_id = '$campaign_id' ORDER BY import_id DESC  " ;
$result = mysqli_query($Conn, $SQL_Lead) or die ("ไม่สามารถเรียกดูข้อมูลได้");
while($row = mysqli_fetch_array($result))
	{
		
	$import_id = $row["import_id"];
    $list_name = $row["list_name"];
    $total_records = $row["total_records"];

    $SQL_count=  mysqli_query($Conn, " select COUNT(campaign_id) from t_calllist_agent where campaign_id = '$campaign_id' and import_id = '$import_id' ");
    $totalLeadUsed = mysqli_result($SQL_count, 0);

    $TotalLeadsRemain = $total_records - $totalLeadUsed;

    $SQL_count=  mysqli_query($Conn, " select COUNT(campaign_id) from t_calllist_agent where (last_wrapup_dt BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and import_id = '$import_id' ");
    $leadUsed = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " select COUNT(campaign_id) from t_calllist_agent where (last_wrapup_dt BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and import_id = '$import_id'and  last_wrapup_id = '400||' ");
    $success = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " select COUNT(campaign_id) from t_calllist_agent where (last_wrapup_dt BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and import_id = '$import_id'and  
    ( last_wrapup_id = '103||' or last_wrapup_id = '201||' or last_wrapup_id = '300||' or last_wrapup_id = '500||' or last_wrapup_id = '501||' or last_wrapup_id = '502||' ) ");
    $unsuccess = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " select COUNT(campaign_id) from t_calllist_agent where (last_wrapup_dt BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and import_id = '$import_id'and  
    ( last_wrapup_id = '101||' or last_wrapup_id = '102||' or last_wrapup_id = '202||' or last_wrapup_id = '303||' or last_wrapup_id = '304||') ");
    $nocontact = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " select COUNT(campaign_id) from t_calllist_agent where (last_wrapup_dt BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and import_id = '$import_id'and  
    ( last_wrapup_id = '302||') ");
    $followup = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " select COUNT(campaign_id) from t_calllist_agent where (last_wrapup_dt BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and import_id = '$import_id'and  
    ( last_wrapup_id = '301||') ");
    $callback = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " select COUNT(campaign_id) from t_calllist_agent where (last_wrapup_dt BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and import_id = '$import_id'and  
    ( last_wrapup_id = '305||') ");
    $DND = mysqli_result($SQL_count, 0);

    $contactable = @(( $success + $unsuccess + $followup + $callback + $DND )/$leadUsed) ; 
    if($contactable === false ){
        $contactable = 0;
    }

    $conversion = @( $success / $leadUsed ) ; 
    if($conversion === false ){
        $conversion = 0;
    }
    
	
	$row = $baseRow + 1  ;
	$row2 = $row - 1 ;
	$r = $r+1;	
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, $list_name)
                                   ->setCellValue('B'.$row2, $total_records)
                                   ->setCellValue('C'.$row2, $totalLeadUsed)
                                   ->setCellValue('D'.$row2, $TotalLeadsRemain)
                                   ->setCellValue('E'.$row2, $leadUsed)	
                                   ->setCellValue('F'.$row2, $success)
                                   ->setCellValue('G'.$row2, $unsuccess)
                                   ->setCellValue('H'.$row2, $nocontact)
                                   ->setCellValue('I'.$row2, $followup)
                                   ->setCellValue('J'.$row2, $callback)
                                   ->setCellValue('K'.$row2, $DND)
                                   ->setCellValue('L'.$row2, $contactable)
                                   ->setCellValue('M'.$row2, $conversion)				   
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
$fname = "LeadPerformance.xls";
$objWriter->save($droot.$fname);
//$objWriter->save(str_replace('.php', '.xls', __FILE__));

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing file" , EOL;
//echo 'File has been created in ' , getcwd() , EOL;

echo  $fname;
