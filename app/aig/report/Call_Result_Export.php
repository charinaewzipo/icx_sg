<?php
ini_set("display_errors", 0);

date_default_timezone_set("Asia/Bangkok");

require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../PHPExcel/Classes/PHPExcel.php");

function DateDiff($strDate1, $strDate2)
{
    return (strtotime($strDate2) - strtotime($strDate1)) / (60 * 60 * 24); // 1 day = 60*60*24
}

function divZero($faf, $div)
{
    if ($div == 0 || $div == "0") {
        return 0;
    }
    return ($faf / $div);
}

$tmp = json_decode($_POST['data'], true);
$root = "temp/";
$start = $tmp["startdate"];
$end = $tmp["enddate"];
$campaign_id = $tmp["campaign_id"];
//$start = '01/07/2019';
//$end = '15/07/2019';

$start_dd = substr($start, 0, 2); // 16/03/2016
$start_mm = substr($start, 3, 2);
$start_yy = substr($start, 6, 4);
$startdate = $start_yy . $start_mm . $start_dd;
$startdate2 = $start_yy . '-' . $start_mm . '-' . $start_dd;

$end_dd = substr($end, 0, 2);
$end_mm = substr($end, 3, 2);
$end_yy = substr($end, 6, 4);
$enddate = $end_yy . $end_mm . $end_dd;
$enddate2 = $end_yy . '-' . $end_mm . '-' . $end_dd;

//$startdate2 = '2019-07-01';
//$enddate2 =  '2019-07-16';

$currentdatetime = date("Y") . '-' . date("m") . '-' . date("d") . ' ' . date("H:i:s");

$report_date = $startdate2 . ' - ' . $enddate2;

$SQL_campname = "select campaign_name from t_campaign where campaign_id = '$campaign_id' ";
$result = mysqli_query($Conn, $SQL_campname) or die("ไม่สามารถเรียกดูข้อมูลได้");
while ($row = mysqli_fetch_array($result)) {
    $campaign_name = $row["campaign_name"];
}


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
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

// define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


/** PHPExcel_IOFactory */
// require_once dirname(__FILE__) . '/../../PHPExcel/Classes/PHPExcel/IOFactory.php';



// echo date('H:i:s'), " Load from Excel5 template", EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("templates/Call_Result_Report.xls");

$dif_date = (DateDiff($startdate2, $enddate2)) + 1;

$objPHPExcel->getActiveSheet()->setCellValue('C3', $campaign_name);
$objPHPExcel->getActiveSheet()->setCellValue('C4', $currentdatetime);
$objPHPExcel->getActiveSheet()->setCellValue('C5', $report_date);




$baseRow = 9;
$row = 0;
$r = 0;
$i = 0;
$strNewDate = $startdate2;
$endNewDate = $enddate2;

$sum_uesd_accu = 0;
$sum_contact_call = 0;

$workday = $dif_date;

$CallAttempt = 0;

$SQL = "SELECT last_wrapup_id as wrapup,COUNT(distinct campaign_id,agent_id,calllist_id) AS amount FROM t_calllist_agent
WHERE campaign_id=$campaign_id AND last_wrapup_id IS NOT NULL AND last_wrapup_dt BETWEEN '$startdate2 00:00' and '$enddate2 23:59' GROUP BY last_wrapup_id";

$result = mysqli_query($Conn, $SQL) or die("ไม่สามารถเรียกดูข้อมูลได้");

$sql_wrapup = " SELECT lv1.wrapup_code AS lv1code,lv1.wrapup_desc AS lv1desc,lv2.wrapup_code AS lv2code,lv2.wrapup_desc AS lv2desc,lv3.wrapup_code AS lv3code,lv3.wrapup_desc AS lv3desc
FROM t_wrapup_code as lv1 
left OUTER join t_wrapup_code lv2 on lv1.wrapup_code=lv2.parent_code
left OUTER join t_wrapup_code lv3 on lv2.wrapup_code=lv3.parent_code
WHERE lv1.campaign_id LIKE '%,$campaign_id,%' AND lv1.parent_code='0' ORDER BY lv1.wrapup_code,lv1.seq_no,lv2.wrapup_code,lv2.seq_no,lv3.wrapup_code,lv3.seq_no";

$result_wrapup = mysqli_query($Conn, $sql_wrapup);

$Result_V = [];


while ($row = mysqli_fetch_array($result)) {
    $Result_V[] = [
        "wrapup" => explode("|", $row["wrapup"]),
        "value" => $row["amount"]
    ];
}

$baseRow = 9;
$rw = 0;
$rw = $baseRow;
$curlv1_code = "";
$curlv2_code = "";
$curlv3_code = "";
$Total =  array_reduce($Result_V, function ($sum, $item) {
    return $sum + $item["value"];
}, 0);
$sumlv1 = 0;
$sumlv2 = 0;
$sumlv3 = 0;
$AllLV = "";
$poslv1 = "";
$poslv2 = "";
$poslv3 = "";


while ($row = mysqli_fetch_array($result_wrapup)) {
    $lv1code = $row["lv1code"];
    $lv1desc = $row["lv1desc"];
    $lv2code = $row["lv2code"];
    $lv2desc = $row["lv2desc"];
    $lv3code = $row["lv3code"];
    $lv3desc = $row["lv3desc"];
    if ($rw == $baseRow) {
        $AllLV = 'C' . $rw;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rw, "Total");
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $rw, $Total);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $rw, "=" . $AllLV . "/" . $AllLV);
    }
    if ($lv1code && $lv1code !== $curlv1_code) {
        $curlv1_code = $lv1code;
        $rw++;
        $sumlv1 = array_reduce($Result_V, function ($sum, $item) use ($lv1code) {
            return $sum + ((in_array($lv1code, $item["wrapup"])) ? $item["value"] : 0);
        }, 0);
        $poslv1 = 'C' . $rw;
        $objPHPExcel->getActiveSheet()->insertNewRowBefore($rw, 1);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rw, "   " . $lv1desc);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $rw, $sumlv1);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $rw, "=" . $poslv1 . "/" . $AllLV);
    }
    if ($lv2code && $lv2code !== $curlv2_code) {
        $curlv2_code = $lv2code;
        $rw++;
        $sumlv2 = array_reduce($Result_V, function ($sum, $item) use ($lv2code) {
            return $sum + ((in_array($lv2code, $item["wrapup"])) ? $item["value"] : 0);
        }, 0);
        $poslv2 = 'C' . $rw;
        $objPHPExcel->getActiveSheet()->insertNewRowBefore($rw, 1);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rw, "       " . $lv2desc);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $rw, $sumlv2);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $rw, "=" . $poslv2 . "/" . $poslv1);
    }
    if (!$lv3code)
        continue;
    $rw++;
    $sumlv3 = array_reduce($Result_V, function ($sum, $item) use ($lv3code) {
        return $sum + ((in_array($lv3code, $item["wrapup"])) ? $item["value"] : 0);
    }, 0);
    $poslv3 = 'C' . $rw;
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($rw, 1);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $rw, "           " . $lv3desc);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $rw, $sumlv3);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $rw, "=" . $poslv3 . "/" . $poslv2);
}




//echo date('H:i:s') , " Write to Excel5 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$fname = "Call_Result_" . $currentdate . ".xls";
$objWriter->save($droot . $fname);
// $objWriter->save(str_replace('.php', '.xls', __FILE__));

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing file" , EOL;
//echo 'File has been created in ' , getcwd() , EOL;

$result = array("result" => "success", "fname" => $fname);
echo json_encode($result);
