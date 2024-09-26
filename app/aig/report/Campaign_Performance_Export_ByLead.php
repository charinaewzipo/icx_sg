<?php

date_default_timezone_set("Asia/Bangkok");

require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../function/db.php");
require_once("../../PHPExcel/Classes/PHPExcel.php");

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


function executeQuery($Conn, $query)
{
    $result = mysqli_query($Conn, $query) or die("ไม่สามารถเรียกดูข้อมูลได้");

    // Clear all result sets
    while (mysqli_more_results($Conn)) {
        mysqli_next_result($Conn);
        if ($tempResult = mysqli_store_result($Conn)) {
            mysqli_free_result($tempResult);  // Free any remaining results
        }
    }

    return $result;
}


$root = "temp/";

$tmp = json_decode($_POST['data'], true);
$root = "temp/";
$start = $tmp["startdate"];
$end = $tmp["enddate"];
$campaign_id = $tmp["campaign_id"];
$campaign_id_lead_list = $tmp["campaign_id_lead_list"];
$campaign_id_selected = $tmp["campaign_id_selected"];
$campaign_id_selected_lead_list = $tmp["campaign_id_selected_lead_list"];
$LeadID = str_replace(' ', '', $campaign_id_selected_lead_list);

$start_dd = substr($start, 0, 2); // 16/03/2016
$start_mm = substr($start, 3, 2);
$start_yy = substr($start, 6, 4);
$startdate = $start_yy . $start_mm . $start_dd;
$DateStart = $start_yy . '-' . $start_mm . '-' . $start_dd;
$startdatelead = $start_yy . $start_mm;

$end_dd = substr($end, 0, 2); // 16/03/2016
$end_mm = substr($end, 3, 2);
$end_yy = substr($end, 6, 4);
$enddate = $end_yy . $end_mm . $end_dd;
$DateEnd = $end_yy . '-' . $end_mm . '-' . $end_dd;
$enddatelead = $end_yy . $end_mm;

$currentdatetime = date("Y") . '-' . date("m") . '-' . date("d") . ' ' . date("H:i:s");
$currentDate = date("Y") . '-' . date("m") . '-' . date("d");
$report_date = $DateStart . ' - ' . $DateEnd;


if ($currentDate == $DateStart && $currentDate == $DateEnd) {
    $query = "call sp_get_report_campaignPerformance_by_import_list_t_agent('$LeadID','$DateStart','$DateEnd') ";
} else {
    $query = "call sp_get_report_campaignPerformance_by_import_list_t_agent_history('$LeadID','$DateStart','$DateEnd') ";
}

$result = executeQuery($Conn, $query);

// Load existing Excel template
$templateFileName = 'templates/Campaign_Performance_by_lead.xls'; // Update with the path to your existing Excel template
$objPHPExcel = PHPExcel_IOFactory::load($templateFileName);
$file_name = 'report_Campaign_Performance_by_lead-' . $currentDate . '.xls';


$total_calllist_upload_use_summary = 0;
$target_tarp_summary = 0;
$target_app_summary = 0;
$target_contactable_summary = 0;

$dnc_total_summary = 0;
$hot_leads_upload_summary = 0;
$wc_auto_create_summary = 0;

$rowIndex = 11;
while ($row = $result->fetch_assoc()) {
    $list_name = $row["list_name"];
    $import_id = $row["import_id"];
    $saleSubmit = $row["SubmitTarp"];
    $tarpSubmit = $row["SaleSubmit"];
    $saleApprove = $row["ApproveTarp"];
    $tarpApprove = $row["ApproveSubmit"];

    $success = $row["success"];
    $unsucess = $row["unsuccess"];
    $follow_up = $row["follow_up"];
    $callback = $row["callback"];
    $other = $row["other"];
    $not_contact = $row["not_contact"];
    $not_update = $row["not_update"];
    $null_list = $row["null_list"];


    // if($campaign_name includes "WC") 
    if (stripos($list_name, 'WC') !== false) {
        // Your code here if $campaign_name includes "WC" (case-insensitive)
        if ($currentDate == $DateStart && $currentDate == $DateEnd) {
            $queryWC = "call sp_get_campaign_performance_wc_auto_report_t_callist($import_id, '$DateStart', '$DateEnd') ";
        } else {
            $queryWC = "call sp_get_campaign_performance_wc_auto_repot_by_leads($import_id, '$DateStart', '$DateEnd') ";
        }
        // $resultWC = get_data_mysql($queryWC, $server);
        $resultWC = executeQuery($Conn, $queryWC);

        while ($row = $resultWC->fetch_assoc()) {
            $list_use = $row["list_use"];
            $success = $row["success"];
            $unsucess = $row["unsuccess"];
            $follow_up = $row["follow_up"];
            $callback = $row["callback"];
            $other = $row["other"];
            $not_contact = $row["not_contact"];
            $not_update = $row["not_update"];
            $null_list = $row["null_list"];
        }
        $contactable = $success + $unsucess + $follow_up + $callback + $other;
        // Free the result set
        mysqli_free_result($resultWC);
    }


    $genesys_campaign_name = "";

    $sqlGetCampaignName = "SELECT genesys_campaign_name AS genesys_campaign_name FROM t_import_list where import_id = ($import_id)";
    // $resultGetCampaignName = get_data_mysql($sqlGetCampaignName, $server);
    $resultGetCampaignName = executeQuery($Conn, $sqlGetCampaignName);

    // Fetch the first row directly without using a loop
    if ($rowGetCampaignName = mysqli_fetch_assoc($resultGetCampaignName)) {

        if ($rowGetCampaignName["genesys_campaign_name"] !== $genesys_campaign_name) {
            $genesys_campaign_name = $rowGetCampaignName["genesys_campaign_name"];
        } else {
            $genesys_campaign_name = "";
        }
    }
    // Free the result set
    mysqli_free_result($resultGetCampaignName);
    if (empty($genesys_campaign_name)) {
        $genesys_nocontact = 0;
    } else {
        $sqlTotalNocontact = "SELECT COUNT(dnis) as genesys_no_contact
                                        FROM (
                                    SELECT dnis
                                    FROM dbo.g_campaign_interaction_detail  
                                    WHERE [date] BETWEEN '$DateStart 00:00:00' AND '$DateEnd 23:59:59' 
                                    AND campaign_name = ('$genesys_campaign_name')
                                    AND last_wrap_up = 'ININ-OUTBOUND-NO-ANSWER'
                                    GROUP BY dnis
                                ) AS grouped_data;";
        $resultTotalNocontact = get_data_mssql($sqlTotalNocontact);
        while ($rowTotalNocontact = odbc_fetch_array($resultTotalNocontact)) {
            $genesys_nocontact = $rowTotalNocontact["genesys_no_contact"];
        }
    }

    $sqlGetHeader = "call  sp_get_headerReport_campaignPerformance_by_importList('$import_id','$CampaignID','$DateStart','$DateEnd');";
    // $resultGetHeader = get_data_mysql($sqlGetHeader, $server);
    $resultGetHeader = executeQuery($Conn, $sqlGetHeader);
    while ($rowGetHeader = $resultGetHeader->fetch_assoc()) {
        $total_uploads = $rowGetHeader["total_uploads"];
        $dnc_total = $rowGetHeader["dnc_total"];
        $hot_leads_upload = $rowGetHeader["hot_leads_upload"];
        $wc_auto_create = $rowGetHeader["wc_auto_create"];
        $target_contact = $rowGetHeader["target_contact"];
        $target_resp = $rowGetHeader["target_resp"];
        $target_aarp = $rowGetHeader["target_aarp"];
        $campaign_name = $rowGetHeader["campaign_name"];
    }
    // Free the result set
    mysqli_free_result($resultGetHeader);


    $total_list_upload_used = (($total_uploads + ($hot_leads_upload +  $wc_auto_create)) - $dnc_total);
    $target_tarp = $total_list_upload_used  * $target_contact * $target_resp * $target_aarp;
    $target_app = $total_list_upload_used * $target_contact * $target_resp;
    $target_contactable = $total_list_upload_used * $target_contact;




    $total_ineffective = $not_contact + $not_update  + $null_list;
    $contactable = $success + $unsucess + $follow_up + $callback + $other;
    $total_list_use = $contactable + $total_ineffective;

    if ($genesys_nocontact > $total_list_upload_used - $total_list_use) {
        $genesys_nocontact = $total_list_upload_used - $total_list_use;
    }
    if ($genesys_nocontact < 0) {
        $genesys_nocontact = 0;
    }

    $total_ineffective = $not_contact + $not_update + $genesys_nocontact + $null_list;
    $contactable = $success + $unsucess + $follow_up + $callback + $other;
    $total_list_use = $contactable + $total_ineffective;

    // Insert Blank Row
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($rowIndex + 1, 1);

    // Insert Data
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowIndex, $list_name);

    $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowIndex, $saleSubmit);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowIndex, "=C$rowIndex/K$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowIndex, $tarpSubmit);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowIndex, $saleApprove);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowIndex, "=F$rowIndex/K$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowIndex, $tarpApprove);

    $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowIndex, $total_list_use);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowIndex, $contactable);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $rowIndex, "=K$rowIndex/J$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $rowIndex, $success);
    $objPHPExcel->getActiveSheet()->setCellValue('N' . $rowIndex, "=M$rowIndex/K$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('O' . $rowIndex, $unsucess);
    $objPHPExcel->getActiveSheet()->setCellValue('P' . $rowIndex, "=O$rowIndex/K$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $rowIndex, $follow_up);
    $objPHPExcel->getActiveSheet()->setCellValue('R' . $rowIndex, "=Q$rowIndex/K$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('S' . $rowIndex, $callback);
    $objPHPExcel->getActiveSheet()->setCellValue('T' . $rowIndex, "=S$rowIndex/K$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('U' . $rowIndex, $other);
    $objPHPExcel->getActiveSheet()->setCellValue('V' . $rowIndex, "=U$rowIndex/K$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('W' . $rowIndex, $total_ineffective);
    $objPHPExcel->getActiveSheet()->setCellValue('X' . $rowIndex, "=W$rowIndex/J$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('Y' . $rowIndex, $genesys_nocontact);
    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $rowIndex, "=Y$rowIndex/W$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('AA' . $rowIndex, $not_update + $not_contact + $null_list);
    $objPHPExcel->getActiveSheet()->setCellValue('AB' . $rowIndex, "=AA$rowIndex/W$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('AC' . $rowIndex, "0");
    $objPHPExcel->getActiveSheet()->setCellValue('AD' . $rowIndex, "=AC$rowIndex/W$rowIndex");
    $rowIndex++;

    $total_calllist_upload_use_summary = $total_calllist_upload_use_summary + $total_uploads;
    $target_tarp_summary = $target_tarp_summary + $target_tarp;
    $target_app_summary = $target_app_summary + $target_app;
    $target_contactable_summary = $target_contactable_summary + $target_contactable;

    $dnc_total_summary = $dnc_total_summary + $dnc_total;
    $hot_leads_upload_summary = $hot_leads_upload_summary + $hot_leads_upload;
    $wc_auto_create_summary = $wc_auto_create_summary + $wc_auto_create;
}
// Free the result set
mysqli_free_result($result);
// Close the connection
mysqli_close($Conn);


$objPHPExcel->getActiveSheet()->setCellValue('R2', $total_calllist_upload_use_summary);
$objPHPExcel->getActiveSheet()->setCellValue('R3', $dnc_total_summary);
$objPHPExcel->getActiveSheet()->setCellValue('R4', $hot_leads_upload_summary + $wc_auto_create_summary);

$objPHPExcel->getActiveSheet()->setCellValue('J2', $target_contactable_summary);
$objPHPExcel->getActiveSheet()->setCellValue('J4', $target_tarp_summary);
$objPHPExcel->getActiveSheet()->setCellValue('J6', $target_app_summary);

$objPHPExcel->getActiveSheet()->setCellValue('C3', $campaign_name);
$objPHPExcel->getActiveSheet()->setCellValue('C4', $currentdatetime);
$objPHPExcel->getActiveSheet()->setCellValue('C5', $DateStart . ' - ' . $DateEnd);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$objWriter->save($droot . $file_name);
$result = array("result" => "success", "fname" => $file_name);
echo json_encode($result);
