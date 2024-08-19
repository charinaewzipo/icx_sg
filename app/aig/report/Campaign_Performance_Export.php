<?php


ini_set("display_errors", 0);

date_default_timezone_set("Asia/Bangkok");

require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../function/db.php");

function DateDiff($strDate1, $strDate2)
{
    return (strtotime($strDate2) - strtotime($strDate1)) / (60 * 60 * 24); // 1 day = 60*60*24
}

function convTime($time)
{
    $thistime = $time;
    $hour = floor($thistime / 3600);
    $T_minute = $thistime % 3600;

    $minute = floor($T_minute / 60);
    $second = $T_minute % 60;

    $talktime = "$hour:$minute:$second";

    return $talktime;
}

function divZero($faf, $div)
{
    if ($div == 0 || $div == "0") {
        return 0;
    }
    return ($faf / $div);
}


$root = "temp/";

$tmp = json_decode($_POST['data'], true);
$root = "temp/";
$start = $tmp["startdate"];
$end = $tmp["enddate"];
$campaign_id = $tmp["campaign_id"];
$campaign_id_selected = $tmp["campaign_id_selected"];

$start_dd = substr($start, 0, 2); // 16/03/2016
$start_mm = substr($start, 3, 2);
$start_yy = substr($start, 6, 4);
$startdate = $start_yy . $start_mm . $start_dd;
$startdate2 = $start_yy . '-' . $start_mm . '-' . $start_dd;
$startdatelead = $start_yy . $start_mm;

$end_dd = substr($end, 0, 2);
$end_mm = substr($end, 3, 2);
$end_yy = substr($end, 6, 4);
$enddate = $end_yy . $end_mm . $end_dd;
$enddate2 = $end_yy . '-' . $end_mm . '-' . $end_dd;
$enddatelead = $end_yy . $end_mm;

$currentdatetime = date("Y") . '-' . date("m") . '-' . date("d") . ' ' . date("H:i:s");

$report_date = $startdate2 . ' - ' . $enddate2;

/** Error reporting */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../../PHPExcel/Classes/PHPExcel/IOFactory.php';

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("templates/Campaign_Performance.xls");

$baseRow = 11;
$row = 0;
$r = 0;
$i = 0;

$sqlTotalCalllistUpload = "SELECT SUM(total_records) As TotalCalllistUpload FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id_selected)) AND is_count != 0 AND list_comment = DATE_FORMAT('$enddate2','%Y%m')";
$resultTotalCalllistUpload = mysqli_query($Conn, $sqlTotalCalllistUpload) or die("ไม่สามารถเรียกดูข้อมูลได้");
while ($rowTotalCalllistUpload = mysqli_fetch_array($resultTotalCalllistUpload)) {
    $total_calllist_upload = $rowTotalCalllistUpload["TotalCalllistUpload"];
}

$sqlTotalCalllistManualAdd = "SELECT COUNT(DISTINCT calllist_id) AS TotalCalllistManualAdd FROM t_calllist WHERE import_id IN (SELECT import_id As TotalCalllist FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id_selected)) AND is_count = 0 AND list_comment = DATE_FORMAT('$enddate2','%Y%m')) AND DATE_FORMAT(create_date,'%Y%m') = DATE_FORMAT('$enddate2','%Y%m')";
$resultTotalCalllistManualAdd = mysqli_query($Conn, $sqlTotalCalllistManualAdd) or die("ไม่สามารถเรียกดูข้อมูลได้");
while ($rowTotalCalllistManualAdd = mysqli_fetch_array($resultTotalCalllistManualAdd)) {
    $total_calllist_manual_add = $rowTotalCalllistManualAdd["TotalCalllistManualAdd"];
}

$sqlTotalCalllistDNC = "SELECT COUNT(DISTINCT l.calllist_id) AS TotalCalllistDNC FROM t_calllist l LEFT JOIN t_calllist_agent_history h ON l.calllist_id = h.calllist_id WHERE l.status IN (11,12,13,14,15,16,17,18,19) AND l.import_id IN (SELECT import_id As TotalCalllist FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id_selected)) AND list_comment = DATE_FORMAT('$enddate2','%Y%m')) AND h.last_wrapup_id IS NULL";
$resultTotalCalllistDNC = mysqli_query($Conn, $sqlTotalCalllistDNC) or die("ไม่สามารถเรียกดูข้อมูลได้");
while ($rowTotalCalllistDNC = mysqli_fetch_array($resultTotalCalllistDNC)) {
    $total_calllist_dnc = $rowTotalCalllistDNC["TotalCalllistDNC"];
}

$sql_app = " SELECT campaign_id, COUNT(DISTINCT(CASE WHEN AppStatus NOT IN( 'Follow-doc') THEN id ELSE NULL END)) sale_front,
            COUNT(DISTINCT(CASE WHEN AppStatus IN( 'Approve') THEN id ELSE NULL END)) sale_back,
            SUM(CASE WHEN AppStatus NOT IN( 'Follow-doc') AND PAYMENTFREQUENCY IN( 'รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) premium_year_front,
            SUM(CASE WHEN AppStatus NOT IN( 'Follow-doc') AND PAYMENTFREQUENCY IN( 'รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END) premium_month_front,
            SUM(CASE WHEN AppStatus IN( 'Approve') AND PAYMENTFREQUENCY IN( 'รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) premium_year_back,
            SUM(CASE WHEN AppStatus IN( 'Approve') AND PAYMENTFREQUENCY IN( 'รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END) premium_month_back
            from t_aig_app where (create_date BETWEEN '$startdate2 00:00' and '$enddate2 23:59') group by campaign_id";
$result_app =  mysqli_query($Conn, $sql_app) or die("ไม่สามารถเรียกดูข้อมูลได้");
$sale_value =array();
while($row = mysqli_fetch_array($result_app))
{
    $sale_value[] = $row;
}
$sale_value = array_column($sale_value,null,'campaign_id');


$SQL = "
SELECT c.campaign_id,campaign_name,campaign_mode,Target_Contact,Target_Response,Target_AARP,Target_TARP,Target_App,

COUNT(DISTINCT (case 
when last_wrapup_option_id in (0,1,2,3,4,5,6,7,8,9) then calllist_id
ELSE NULL
END)) list_contact,

COUNT(DISTINCT (case 
when last_wrapup_option_id in (6,9) then calllist_id
ELSE NULL
END)) list_success,

COUNT(DISTINCT (case 
when last_wrapup_option_id = 7 then calllist_id
ELSE NULL
END)) list_unsuccess,

COUNT(DISTINCT (case 
when last_wrapup_option_id in (2) then calllist_id
ELSE NULL
END)) list_followup,

COUNT(DISTINCT (case 
when last_wrapup_option_id = 1 then calllist_id
ELSE NULL
END)) list_callback,

COUNT(DISTINCT (case 
when last_wrapup_option_id = 8 then calllist_id
ELSE NULL
END)) list_nocontact,

COUNT(DISTINCT (case 
when last_wrapup_option_id = 4 then calllist_id
ELSE NULL
END)) list_badlist,

COUNT(DISTINCT (case 
when last_wrapup_option_id = 3 then calllist_id
ELSE NULL
END)) list_donotcall,

COUNT(DISTINCT (case 
when last_wrapup_option_id in (0,5) then calllist_id
ELSE NULL
END)) list_overcall

FROM 
t_campaign c LEFT JOIN
(
SELECT t1.*
FROM t_calllist_agent_history t1
JOIN (
    SELECT calllist_id,last_wrapup_option_id,MAX(history_date) AS max_history_date
    FROM t_calllist_agent_history WHERE (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59') AND campaign_id IN ($campaign_id_selected) AND import_id IN (SELECT il.import_id FROM t_import_list il INNER JOIN t_campaign_list cl ON il.import_id = cl.import_id WHERE cl.campaign_id in ($campaign_id_selected) AND il.list_comment = DATE_FORMAT('$enddate2','%Y%m')) GROUP BY calllist_id
) t2 ON t1.calllist_id = t2.calllist_id AND t1.history_date = t2.max_history_date
) a ON c.campaign_id = a.campaign_id WHERE c.campaign_id IN ($campaign_id_selected)
GROUP BY campaign_id
";
$result = mysqli_query($Conn, $SQL) or die("ไม่สามารถเรียกดูข้อมูลได้");

$total_calllist_upload_use_summary = 0;
$target_tarp_summary = 0;
$target_app_summary = 0;
$target_contactable_summary = 0;

while ($row = mysqli_fetch_array($result)) {
    $campaign_id = $row["campaign_id"];
    $campaign_name = $row["campaign_name"];
    $campaign_mode = $row["campaign_mode"];
    $list_contact = $row["list_contact"];
    $list_success = $row["list_success"];
    $list_unsuccess = $row["list_unsuccess"];
    $list_followup = $row["list_followup"];
    $list_callback = $row["list_callback"];
    $list_nocontact = $row["list_nocontact"];
    $list_badlist = $row["list_badlist"];
    $list_donotcall = $row["list_donotcall"];
    $list_overcall = $row["list_overcall"];
    $list_other = $list_overcall + $list_donotcall;

    $campaign_name_display = "$campaign_name ($campaign_mode)";
    $campaign_name_header = $campaign_name_header.",".$row["campaign_name"];
    $campaign_mode_header = $campaign_mode_header.",".$row["campaign_mode"];
    $target_contact = $row["Target_Contact"];
    $target_resp = $row["Target_Response"];
    $target_aarp = $row["Target_AARP"];
 
    $call_contact = $list_success + $list_unsuccess + $list_followup + $list_callback + $list_other;
    $call_nocontact = $list_nocontact + $list_badlist;

    $genesys_nocontact = 0;
    if($campaign_mode == "Predictive"){  
        
        $sqlGetCampaingName = "SELECT GROUP_CONCAT(QUOTE(genesys_campaign_name) SEPARATOR ',') AS genesys_campaign_name FROM 
        (
        SELECT genesys_campaign_name FROM t_campaign WHERE campaign_id = $campaign_id
        UNION
        SELECT genesys_campaign_name FROM t_import_list l
        INNER JOIN t_campaign_list cl ON l.import_id = cl.import_id
        WHERE l.genesys_campaign_name IS NOT NULL AND cl.campaign_id = $campaign_id
        ) t";
        $resultGetCampaingName = mysqli_query($Conn, $sqlGetCampaingName) or die("ไม่สามารถเรียกดูข้อมูลได้");
        while ($rowGetCampaingName = mysqli_fetch_array($resultGetCampaingName)) {
            $genesys_campaign_name = $rowGetCampaingName["genesys_campaign_name"];
        }
        
        $sqlTotalNocontact = "SELECT COUNT(DISTINCT dnis) AS TotalNocontact FROM dbo.g_campaign_interaction_detail WHERE users IS NULL and [date] BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59' AND campaign_name IN ($genesys_campaign_name)";
        $resultTotalNocontact = get_data_mssql($sqlTotalNocontact);
        while ($rowTotalNocontact = odbc_fetch_array($resultTotalNocontact)) {
            $genesys_nocontact = $rowTotalNocontact["TotalNocontact"];
        }
    }
    
    $sqlTotalCalllistUploadPercampaign = "SELECT SUM(total_records) As TotalCalllistUploadPercampaign FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id)) AND is_count != 0 AND list_comment = DATE_FORMAT('$enddate2','%Y%m')";
    $resultTotalCalllistUploadPercampaign = mysqli_query($Conn, $sqlTotalCalllistUploadPercampaign) or die("ไม่สามารถเรียกดูข้อมูลได้");
    while ($rowTotalCalllistUploadPercampaign = mysqli_fetch_array($resultTotalCalllistUploadPercampaign)) {
        $total_calllist_upload_cp = $rowTotalCalllistUploadPercampaign["TotalCalllistUploadPercampaign"];
    }

    $sqlTotalCalllistManualAddPercampaign = "SELECT COUNT(DISTINCT calllist_id) AS TotalCalllistManualAddPercampaign FROM t_calllist WHERE import_id IN (SELECT import_id As TotalCalllist FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id)) AND is_count = 0 AND list_comment = DATE_FORMAT('$enddate2','%Y%m')) AND DATE_FORMAT(create_date,'%Y%m') = DATE_FORMAT('$enddate2','%Y%m')";
    $resultTotalCalllistManualAddPercampaign = mysqli_query($Conn, $sqlTotalCalllistManualAddPercampaign) or die("ไม่สามารถเรียกดูข้อมูลได้");
    while ($rowTotalCalllistManualAddPercampaign = mysqli_fetch_array($resultTotalCalllistManualAddPercampaign)) {
        $total_calllist_manual_add_cp = $rowTotalCalllistManualAddPercampaign["TotalCalllistManualAddPercampaign"];
    }

    $sqlTotalCalllistDNCPercampaign = "SELECT COUNT(DISTINCT l.calllist_id) AS TotalCalllistDNCPercampaign FROM t_calllist l LEFT JOIN t_calllist_agent_history h ON l.calllist_id = h.calllist_id WHERE l.status IN (11,12,13,14,15,16,17,18,19) AND l.import_id IN (SELECT import_id As TotalCalllist FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id)) AND list_comment = DATE_FORMAT('$enddate2','%Y%m')) AND h.last_wrapup_id IS NULL";
    $resultTotalCalllistDNCPercampaign = mysqli_query($Conn, $sqlTotalCalllistDNCPercampaign) or die("ไม่สามารถเรียกดูข้อมูลได้");
    while ($rowTotalCalllistDNCPercampaign = mysqli_fetch_array($resultTotalCalllistDNCPercampaign)) {
        $total_calllist_dnc_cp = $rowTotalCalllistDNCPercampaign["TotalCalllistDNCPercampaign"];
    }

    $total_calllist_upload_use = ($total_calllist_upload_cp + $total_calllist_manual_add_cp) - $total_calllist_dnc_cp;
    $target_tarp = $total_calllist_upload_use * $target_contact * $target_resp * $target_aarp;
    $target_app = $total_calllist_upload_use * $target_contact * $target_resp;
    $target_contactable = $total_calllist_upload_use * $target_contact;

    if($genesys_nocontact > $total_calllist_upload_use - ($call_contact + $call_nocontact)){
        $genesys_nocontact = $total_calllist_upload_use - ($call_contact + $call_nocontact);
    }
    if($genesys_nocontact < 0){
        $genesys_nocontact = 0;
    }
    
    $call_nocontact = $list_nocontact + $list_badlist + $genesys_nocontact;

    $total_used = $call_contact + $call_nocontact;

    // sale_app
    $sale_app_front = (isset($sale_value[$campaign_id]["sale_front"]))?$sale_value[$campaign_id]["sale_front"]:0;
    $sale_app_back = (isset($sale_value[$campaign_id]["sale_back"]))?$sale_value[$campaign_id]["sale_back"]:0;

    // sale_premium_y
    $sale_premium_front_y = (isset($sale_value[$campaign_id]["premium_year_front"]))?$sale_value[$campaign_id]["premium_year_front"]:0;
    $sale_premium_back_y = (isset($sale_value[$campaign_id]["premium_year_back"]))?$sale_value[$campaign_id]["premium_year_back"]:0;

    //  sale_premium_M
    $sale_premium_front_m = (isset($sale_value[$campaign_id]["premium_month_front"]))?$sale_value[$campaign_id]["premium_month_front"]:0;
    $sale_premium_back_m = (isset($sale_value[$campaign_id]["premium_month_back"]))?$sale_value[$campaign_id]["premium_month_back"]:0;

    $row = $baseRow + 1;
    $row2 = $row - 1;
    $r = $r + 1;
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);

    $objPHPExcel->getActiveSheet()
    ->setCellValue('B' . $row2, $campaign_name_display)
    ->setCellValue('C'.$row2, $sale_app_front)
    ->setCellValue('D'.$row2, "=C$row2/K$row2")
    ->setCellValue('E'.$row2, $sale_premium_front_m + $sale_premium_front_y)
    ->setCellValue('F'.$row2, $sale_app_back)
    ->setCellValue('G'.$row2, "=F$row2/K$row2")
    ->setCellValue('H'.$row2, $sale_premium_back_m + $sale_premium_back_y)    
    ->setCellValue('J'.$row2, $total_used)
    ->setCellValue('K'.$row2, $call_contact)
    ->setCellValue('L'.$row2, "=K$row2/J$row2")
    ->setCellValue('M'.$row2, $list_success)
    ->setCellValue('N'.$row2, "=M$row2/K$row2")
    ->setCellValue('O'.$row2, $list_unsuccess)
    ->setCellValue('P'.$row2, "=O$row2/K$row2")
    ->setCellValue('Q'.$row2, $list_followup)
    ->setCellValue('R'.$row2, "=Q$row2/K$row2")
    ->setCellValue('S'.$row2, $list_callback)
    ->setCellValue('T'.$row2, "=S$row2/K$row2")
    ->setCellValue('U'.$row2, $list_other)  
    ->setCellValue('V'.$row2, "=U$row2/K$row2") 
    ->setCellValue('W'.$row2, $call_nocontact)
    ->setCellValue('X'.$row2, "=W$row2/J$row2")
    ->setCellValue('Y'.$row2, $genesys_nocontact)
    ->setCellValue('Z'.$row2, "=Y$row2/W$row2")
    ->setCellValue('AA'.$row2, $list_nocontact)
    ->setCellValue('AB'.$row2, "=AA$row2/W$row2")
    ->setCellValue('AC'.$row2, $list_badlist)
    ->setCellValue('AD'.$row2, "=AC$row2/W$row2")  
    ;

    $total_calllist_upload_use_summary = $total_calllist_upload_use_summary + $total_calllist_upload_use;
    $target_tarp_summary = $target_tarp_summary + $target_tarp;
    $target_app_summary = $target_app_summary + $target_app;
    $target_contactable_summary = $target_contactable_summary + $target_contactable;

    $baseRow = $baseRow + 1;
    $i++;
    
}

$campaign_name_header = substr($campaign_name_header,1);
$campaign_mode_header = substr($campaign_mode_header,1);

$objPHPExcel->getActiveSheet()->setCellValue('C3', $campaign_name_header);
$objPHPExcel->getActiveSheet()->setCellValue('C4', $currentdatetime);
$objPHPExcel->getActiveSheet()->setCellValue('C5', $report_date);
$objPHPExcel->getActiveSheet()->setCellValue('C6', $campaign_mode_header);

//$objPHPExcel->getActiveSheet()->setCellValue('J2', $target_contactable_summary/$total_calllist_upload_use_summary);
$objPHPExcel->getActiveSheet()->setCellValue('J4', $target_tarp_summary);
$objPHPExcel->getActiveSheet()->setCellValue('J6', $target_app_summary);

$objPHPExcel->getActiveSheet()->setCellValue('R2', $total_calllist_upload);
$objPHPExcel->getActiveSheet()->setCellValue('R3', $total_calllist_dnc);
$objPHPExcel->getActiveSheet()->setCellValue('R4', $total_calllist_manual_add);


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$fname = "Campaign_Performance_".$currentdate.".xls";
$objWriter->save($droot . $fname);

$result = array("result" => "success", "fname" => $fname);
echo json_encode($result);