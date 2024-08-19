<?php


ini_set("display_errors",0);

date_default_timezone_set("Asia/Bangkok");

include("../function/StartConnect2.inc");
include("../function/currentDateTime.inc");

function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }

function convTime($time){
$thistime = $time;
$hour = floor($thistime/3600);
$T_minute = $thistime % 3600;

$minute = floor($T_minute / 60);
$second = $T_minute % 60;

$talktime = "$hour:$minute:$second";

return $talktime;
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
$objPHPExcel = $objReader->load("templates/AgentActivity.xls");

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

$CallAttempt = 0;

$SQL_Agent = "select agent_id, First_name, Last_name,mobile_phone from t_agents where level_id = '1' and is_active = '1'  " ;
$result = mysqli_query($Conn, $SQL_Agent) or die ("ไม่สามารถเรียกดูข้อมูลได้");
while($row = mysqli_fetch_array($result))
	{	
	$agent_id = $row["agent_id"];
    $agent_name = $row["First_name"].' '.$row["Last_name"];
	$ext = $row["mobile_phone"];
	if($ext == ''){
		$ext = '000';
	}
	
	$totalTime = 0;
	$strDate = $startdate2 ;
	$workday = 0 ;
		while( $i < $dif_date)
		{
			$min_time = "SELECT MIN(datetime) as minTime from t_login_history where type = 'login' and agent_id = '$agent_id' and (datetime like '$strDate%')" ;
			$re_mintime = mysqli_query($Conn, $min_time) or die ("ไม่สามารถเรียกดูข้อมูลได้");
				while($row_mintime = mysqli_fetch_array($re_mintime))
				{
					$minTime = $row_mintime["minTime"];
					}
			
			$max_time = "SELECT MIN(datetime) as maxTime from t_login_history where type = 'logout' and agent_id = '$agent_id' and (datetime like '$strDate%')" ;
			$re_maxtime = mysqli_query($Conn, $max_time) or die ("ไม่สามารถเรียกดูข้อมูลได้");
				while($row_maxtime = mysqli_fetch_array($re_maxtime))
				{
					$maxTime = $row_maxtime["maxTime"];
					}
			
			
			$sql_TimeDiff = " SELECT TIME_TO_SEC(TIMEDIFF('$minTime', '$maxTime')) AS TimeDiff ";
			$re_timeDiff = mysqli_query($Conn, $sql_TimeDiff) or die ("ไม่สามารถเรียกดูข้อมูลได้");
				while($row_timediff = mysqli_fetch_array($re_timeDiff))
				{
					$TimeDiff = $row_timediff["TimeDiff"];
					}
			
			$totalTime = $totalTime +  $TimeDiff;
			$strDate = date ("Y-m-d", strtotime("+1 day", strtotime($strDate)));
			$i++;
			}
			
			
	
    $SQL_count=  mysqli_query($Conn, " SELECT COUNT(DISTINCT calllist_id) from t_call_trans where (create_date BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and agent_id = '$agent_id' 
	and  (`wrapup_option_id` = '1' or  `wrapup_option_id` = '2'  or `wrapup_option_id` = '3' or `wrapup_option_id` = '6'  or `wrapup_option_id` = '7' or `wrapup_option_id` = '9' ) " ,  $Conn );
    $LeadPerTmr = mysqli_result($SQL_count, 0);

    $SQL_count=  mysqli_query($Conn, " SELECT COUNT(calllist_id) from t_call_trans where (create_date BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and campaign_id = '$campaign_id' and agent_id = '$agent_id' " ,  $Conn );
    $CallAttempt = mysqli_result($SQL_count, 0);
	
	$SQL_count=  mysqli_query($Conn, " SELECT sum(duration) FROM `cdr` WHERE (calldate BETWEEN '$strNewDate 00:00:00' and '$endNewDate 23:59:59') and src = '$ext' and disposition = 'ANSWERED' " , $Conn2);
	$talktime_s = mysqli_result($SQL_count, 0);
	$talktime = convTime($talktime_s);
    
	
	$row = $baseRow + 1  ;
	$row2 = $row - 1 ;
	$r = $r+1;	
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, $agent_name)
                                   ->setCellValue('C'.$row2, $CallAttempt)
                                   ->setCellValue('D'.$row2, $LeadPerTmr)
                                   ->setCellValue('E'.$row2, $talktime)
					   
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
$fname = "Agent_Activities.xls";
$objWriter->save($droot.$fname);
//$objWriter->save(str_replace('.php', '.xls', __FILE__));

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing file" , EOL;
//echo 'File has been created in ' , getcwd() , EOL;

echo  $fname;
