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
$objPHPExcel = $objReader->load("templates/DailyReport2.xls");

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

$workday = 0 ;

while( $i < $dif_date)
{
    
	
	$date_app = str_replace("-","",$strNewDate); // Cove Date
	
	$SQL_count=  mysql_query(" SELECT COUNT(id) from t_app where Sale_Date = '$date_app' and campaign_id = '$campaign_id' and AppStatus != 'Follow Doc'  ");
	$count_app = mysql_result($SQL_count, 0);
	
	$SQL_count=  mysql_query(" SELECT COUNT(id) from t_app where Approved_Date = '$date_app' and campaign_id = '$campaign_id'  ");
	$count_success = mysql_result($SQL_count, 0);
	
	
	
	$SQL_count=  mysql_query(" SELECT sum(INSTALMENT_PREMIUM) from t_app where Sale_Date = '$date_app' and campaign_id = '$campaign_id' and AppStatus != 'Follow Doc'  ");
	$sum_AARP = mysql_result($SQL_count, 0);
	
	if($sum_AARP <> '0'){
		$sum_AARP = $sum_AARP;
	}else{
		$sum_AARP = '0' ;
	}
	
	$sum_TARP = 0 ;
	
///  sum respound AFYP
$SQL = "select INSTALMENT_PREMIUM,camp  from `t_app` where campaign_id = '$campaign_id'  and  Sale_Date = '$date_app' and AppStatus != 'Follow Doc' " ;
 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($dataRow = mysql_fetch_array($result))
{

	$product_name = $dataRow["camp"];
	$INSTALMENT_PREMIUM = $dataRow["INSTALMENT_PREMIUM"];
	
	if($product_name == 'GenExclusive'){
		
		$SQLSUM=  mysql_query(" select premium  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM' ");
	    $premium = mysql_result($SQLSUM, 0);
	
	}elseif($product_name == 'GenHealth'){
		 
		$SQLSUM=  mysql_query(" select premium  from t_health_lump_sum  where  premium_payment = '$INSTALMENT_PREMIUM'  ");
	    $premium = mysql_result($SQLSUM, 0);
		
	}
	$sum_TARP = $sum_TARP + $premium;	
}

///  sum success AFYP
$sum_success_afyp = '0' ;

$SQL = "select INSTALMENT_PREMIUM,camp  from `t_app` where campaign_id = '$campaign_id'  and  Approved_Date = '$date_app' and AppStatus = 'Success' " ;
 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($dataRow = mysql_fetch_array($result))
{

	$product_name = $dataRow["camp"];
	$INSTALMENT_PREMIUM = $dataRow["INSTALMENT_PREMIUM"];
	
	if($product_name == 'GenExclusive'){
		
		$SQLSUM=  mysql_query(" select premium  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM' ");
	    $premium = mysql_result($SQLSUM, 0);
	
	}elseif($product_name == 'GenHealth'){
		 
		$SQLSUM=  mysql_query(" select premium  from t_health_lump_sum  where  premium_payment = '$INSTALMENT_PREMIUM'  ");
	    $premium = mysql_result($SQLSUM, 0);
		
	}
	$sum_success_afyp = $sum_success_afyp + $premium;	
}



///  sum success  M
$sum_success_M = '0' ;

$SQL = "select INSTALMENT_PREMIUM,camp  from `t_app` where campaign_id = '$campaign_id'  and  Approved_Date = '$date_app' and AppStatus = 'Success' and PaymentFrequency = 'รายเดือน' " ;
 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($dataRow = mysql_fetch_array($result))
{

	$product_name = $dataRow["camp"];
	$INSTALMENT_PREMIUM = $dataRow["INSTALMENT_PREMIUM"];
	
	if($product_name == 'GenExclusive'){
		
		$SQLSUM=  mysql_query(" select premium_payment  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM' ");
	    $premium = mysql_result($SQLSUM, 0);
	
	}elseif($product_name == 'GenHealth'){
		 
		$SQLSUM=  mysql_query(" select premium_payment  from t_health_lump_sum  where  premium_payment = '$INSTALMENT_PREMIUM'  ");
	    $premium = mysql_result($SQLSUM, 0);
		
	}
	$sum_success_M = $sum_success_M + $premium;	
}


///  sum success  Y
$sum_success_Y = '0' ;

$SQL = "select INSTALMENT_PREMIUM,camp  from `t_app` where campaign_id = '$campaign_id'  and  Approved_Date = '$date_app' and AppStatus = 'Success' and PaymentFrequency = 'รายปี' " ;
 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($dataRow = mysql_fetch_array($result))
{

	$product_name = $dataRow["camp"];
	$INSTALMENT_PREMIUM = $dataRow["INSTALMENT_PREMIUM"];
	
	if($product_name == 'GenExclusive'){
		
		$SQLSUM=  mysql_query(" select premium  from t_gen_exclusive  where  premium_payment = '$INSTALMENT_PREMIUM' ");
	    $premium = mysql_result($SQLSUM, 0);
	
	}elseif($product_name == 'GenHealth'){
		 
		$SQLSUM=  mysql_query(" select premium  from t_health_lump_sum  where  premium_payment = '$INSTALMENT_PREMIUM'  ");
	    $premium = mysql_result($SQLSUM, 0);
		
	}
	$sum_success_Y = $sum_success_Y + $premium;	
}


$sum_total = $sum_success_M + $sum_success_Y;
	
		$cov_app = '0';

	//$cov_app = $count_success / $count_app ;
	if($count_success == '0'){
		$cov_app = '0';
		}
		
	
	

	$row = $baseRow + 1  ;
	$row2 = $row - 1 ;
	$r = $r+1;	
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, $strNewDate)
								   ->setCellValue('B'.$row2, $count_app)
	                               ->setCellValue('C'.$row2, $sum_TARP)
								   ->setCellValue('D'.$row2, $count_app)
								   ->setCellValue('E'.$row2, $count_success)
								   ->setCellValue('F'.$row2, $sum_TARP)	
								   ->setCellValue('G'.$row2, $sum_success_afyp)	
							
								   ->setCellValue('J'.$row2, $count_success)		
								   ->setCellValue('K'.$row2, $sum_success_M)	
								   ->setCellValue('L'.$row2, $sum_success_Y)
								   ->setCellValue('M'.$row2, $sum_total)		
								   						  
								  ;

								 
	$baseRow = $baseRow + 1 ;
	$strNewDate = date ("Y-m-d", strtotime("+1 day", strtotime($strNewDate)));
	$i++;
	
									 
}

$objPHPExcel->getActiveSheet()->setCellValue('B4', $workday);



//echo date('H:i:s') , " Write to Excel5 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$fname = "Daily_Conversion_Report.xls";
$objWriter->save($droot.$fname);
//$objWriter->save(str_replace('.php', '.xls', __FILE__));

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing file" , EOL;
//echo 'File has been created in ' , getcwd() , EOL;

echo  $fname;
