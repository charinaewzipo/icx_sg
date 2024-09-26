<?php
date_default_timezone_set("Asia/Bangkok");

require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../function/db.php");
require_once("../../PHPExcel/Classes/PHPExcel.php");

function DateDiff($strDate1, $strDate2)
{
    return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
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

$tmp = json_decode($_POST['data'], true);
$root = "temp/";
$start = $tmp["startdate"];
$end = $tmp["enddate"];
$campaign_id = $tmp["campaign_id"];
$campaign_id_lead_list = $tmp["campaign_id_lead_list"];
$GroupID = $tmp["group_id"];
$TeamID = $tmp["team_id"];
$campaign_id_selected = $tmp["campaign_id_selected"];
$campaign_id_selected_lead_list = $tmp["campaign_id_selected_lead_list"];

$LeadID = str_replace(' ', '', $campaign_id_selected_lead_list);

$start_dd = substr($start, 0, 2);
$start_mm = substr($start, 3, 2);
$start_yy = substr($start, 6, 4);
$startdate = $start_yy . $start_mm . $start_dd;
$DateStart = $start_yy . '-' . $start_mm . '-' . $start_dd;

$end_dd = substr($end, 0, 2);
$end_mm = substr($end, 3, 2);
$end_yy = substr($end, 6, 4);
$enddate =  $end_yy . $end_mm . $end_dd;
$DateEnd =  $end_yy . '-' . $end_mm . '-' . $end_dd;

$currentdatetime = date("Y") . '-' . date("m") . '-' . date("d") . ' ' . date("H:i:s");
$currentDate = date("Y") . '-' . date("m") . '-' . date("d");
$report_date = $DateStart . ' - ' . $DateEnd;

if ($currentDate == $DateStart && $currentDate == $DateEnd) {
    $query = "CALL sp_get_report_agentPerformance_by_import_list_t_agent('$LeadID', '$DateStart', '$DateEnd','$GroupID','$TeamID')";
} else {
    $query = "CALL sp_get_report_agentPerformance_by_import_list_t_agent_history('$LeadID', '$DateStart', '$DateEnd','$GroupID','$TeamID')";
}

$result = executeQuery($Conn, $query);
// Load existing Excel template
$templateFileName = 'templates/Agent_Performance_by_lead.xls'; // Update with the path to your existing Excel template
$objPHPExcel = PHPExcel_IOFactory::load($templateFileName);
$file_name = 'report_Agent_Performance_By_Lead-' . $currentDate . '.xls';

$genesys_nocontact = 0;
$genesys_attempt = 0;
$array_import_ids = [];
$total_list_use_summary = 0;
$rowIndex = 11;
$import_ids = array();

while ($row = $result->fetch_assoc()) {
    $import_id = trim($row["import_id"]);
    if (!in_array($import_id, $import_ids)) {
        $import_ids[] = $import_id;
    }
    $array_import_ids[] = $import_id;
    $list_name = $row["list_name"];
    $agent_id = trim($row["agent_id"]);
    $agentname = trim($row["agentname"]);

    $list_new = $row['new_used'];
    $list_old = $row["old_used"];
    $new_used_contact = $row['new_used_contact'];
    $old_used_contact = $row["old_used_contact"];

    $list_contact_total = $new_used_contact + $old_used_contact;
    $list_attempt = $row["list_attempt"];

    $saleSubmit = $row["SubmitTarp"];
    $tarpSubmit = $row["SaleSubmit"];
    $SaleSubmitPremium = $row["SaleSubmitPremium"];
    $saleApprove = $row["ApproveTarp"];
    $ApproveSubmitPremium = $row["ApproveSubmitPremium"];
    $tarpApprove = $row["ApproveSubmit"];


    $success = $row["success"];
    $unsuccess = $row["unsuccess"];
    $follow_up = $row["follow_up"];
    $callback = $row["callback"];
    $other = $row["other"];
    $not_contact = $row["not_contact"];
    $not_update = $row["not_update"];
    $null_list = $row["null_list"];

    $list_badlist = 0;

    // if($campaign_name includes "WC") 
    if (stripos($list_name, 'WC') !== false) {
        // Your code here if $campaign_name includes "WC" (case-insensitive)
        $queryWC = "call sp_get_agent_performance_wc_auto_by_leads($import_id,$agent_id,'$DateStart','$DateEnd') ";
        // $resultWC = get_data_mysql($queryWC, $server);
        $resultWC = executeQuery($Conn, $queryWC);

        while ($row = $resultWC->fetch_assoc()) {
            $list_new = $row['new_used'];
            $list_old = $row["old_used"];
            $new_used_contact = $row['new_used_contact'];
            $old_used_contact = $row["old_used_contact"];

            $list_contact_total = $new_used_contact + $old_used_contact;
            $list_attempt = $row["list_attempt"];

            $list_use = $row["list_use"];
            $success = $row["success"];
            $unsuccess = $row["unsuccess"];
            $follow_up = $row["follow_up"];
            $callback = $row["callback"];
            $other = $row["other"];
            $not_contact = $row["not_contact"];
            $not_update = $row["not_update"];
            $null_list = $row["null_list"];
        }
        // Free the result set
        mysqli_free_result($resultWC);
        // $contactable = $success + $unsucess + $follow_up + $callback + $other;
    }

    $no_contact = $not_contact +  $not_update + $null_list;
    $list_total = $success + $unsuccess + $follow_up + $callback + $other + $no_contact;

    // Insert Blank Row
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($rowIndex + 1, 1);

    // Insert Data 
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowIndex, $list_name);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowIndex, $agentname);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowIndex, $list_new);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowIndex, $list_old);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowIndex, $list_total);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowIndex, $list_attempt);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowIndex, $new_used_contact);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowIndex, "=G$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowIndex, $old_used_contact);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowIndex, "=I$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowIndex, $list_contact_total);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $rowIndex, "=K$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $rowIndex, "=O$rowIndex/K$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('N' . $rowIndex, "=O$rowIndex/E$rowIndex");

    // saleapp query
    $objPHPExcel->getActiveSheet()->setCellValue('O' . $rowIndex, $saleSubmit);
    $objPHPExcel->getActiveSheet()->setCellValue('P' . $rowIndex, $SaleSubmitPremium);
    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $rowIndex, $tarpSubmit);
    $objPHPExcel->getActiveSheet()->setCellValue('R' . $rowIndex, $saleApprove);
    $objPHPExcel->getActiveSheet()->setCellValue('S' . $rowIndex, $ApproveSubmitPremium);
    $objPHPExcel->getActiveSheet()->setCellValue('T' . $rowIndex, $tarpApprove);

    $objPHPExcel->getActiveSheet()->setCellValue('U' . $rowIndex,  $success);
    $objPHPExcel->getActiveSheet()->setCellValue('V' . $rowIndex, "=U$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('W' . $rowIndex, $unsuccess);
    $objPHPExcel->getActiveSheet()->setCellValue('X' . $rowIndex, "=W$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('Y' . $rowIndex, $follow_up);
    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $rowIndex, "=Y$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('AA' . $rowIndex, $callback);
    $objPHPExcel->getActiveSheet()->setCellValue('AB' . $rowIndex, "=AA$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('AC' . $rowIndex, $other);
    $objPHPExcel->getActiveSheet()->setCellValue('AD' . $rowIndex, "=AC$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('AE' . $rowIndex, $no_contact);
    $objPHPExcel->getActiveSheet()->setCellValue('AF' . $rowIndex, "=AE$rowIndex/E$rowIndex");
    $objPHPExcel->getActiveSheet()->setCellValue('AG' . $rowIndex, $list_badlist);
    $objPHPExcel->getActiveSheet()->setCellValue('AH' . $rowIndex, "=AG$rowIndex/E$rowIndex");

    $total_list_use_summary = $total_list_use_summary + $list_total;

    $rowIndex++;
}

$sqlGetHeader = "call  sp_get_headerReport_campaignPerformance_by_importList('$LeadID','$campaign_id_selected','$DateStart','$DateEnd');";
// $resultGetHeader = get_data_mysql($sqlGetHeader, $server);
$resultGetHeader = executeQuery($Conn, $sqlGetHeader);
while ($rowGetHeader = $resultGetHeader->fetch_assoc()) {
    $total_uploads = $rowGetHeader["total_uploads"];
    $dnc_total = $rowGetHeader["dnc_total"];
    $hot_leads_upload = $rowGetHeader["hot_leads_upload"];
    $wc_auto_create = $rowGetHeader["wc_auto_create"];
}

// Free the result set
mysqli_free_result($resultGetHeader);

$total_list_upload_used = (($total_uploads + ($hot_leads_upload +  $wc_auto_create)) - $dnc_total);

$import_ids_genesys = array_unique($array_import_ids);
$import_ids_genesys_str = implode(",", $import_ids_genesys);
$sqlGetCampaingName = "call sp_get_genesys_campaign_name_import_id('$import_ids_genesys_str')";
// $resultGetCampaingName = get_data_mysql($sqlGetCampaingName, $server);
$resultGetCampaingName = executeQuery($Conn, $sqlGetCampaingName);
while ($rowGetCampaingName = $resultGetCampaingName->fetch_assoc()) {
    $genesys_campaign_name = $rowGetCampaingName["concatenated_names"];
}
// Free the result set
mysqli_free_result($resultGetCampaingName);
if (empty($genesys_campaign_name)) {
    $genesys_no_contact = 0;
    $genesys_attempt = 0;
} else {
    $sqlTotalNocontact = "SELECT COUNT(dnis) as genesys_no_contact
                                        FROM (
                                    SELECT dnis
                                    FROM dbo.g_campaign_interaction_detail  
                                    WHERE [date] BETWEEN '$DateStart 00:00:00' AND '$DateEnd 23:59:59' 
                                    AND campaign_name IN ('$genesys_campaign_name')
                                    AND last_wrap_up = 'ININ-OUTBOUND-NO-ANSWER'
                                    GROUP BY dnis
                                ) AS grouped_data;";
    $resultTotalNocontact = get_data_mssql($sqlTotalNocontact);
    while ($rowTotalNocontact = odbc_fetch_array($resultTotalNocontact)) {
        $genesys_nocontact = $rowTotalNocontact["genesys_no_contact"];
    }

    $sqlTotalAttempted = "SELECT COUNT(*) as genesys_attempt
                      FROM dbo.g_campaign_interaction_detail  
                      WHERE [date] BETWEEN '$DateStart 00:00:00' AND '$DateEnd 23:59:59' 
                      AND campaign_name IN ('$genesys_campaign_name');";
    $resultTotalAttempted = get_data_mssql($sqlTotalAttempted);
    while ($rowTotalAttempted = odbc_fetch_array($resultTotalAttempted)) {
        $genesys_attempt = $rowTotalAttempted["genesys_attempt"];
    }
}

if ($genesys_nocontact > $total_list_upload_used - $total_list_use_summary) {
    $genesys_nocontact = $total_list_upload_used - $total_list_use_summary;
} else {
    $genesys_nocontact = $genesys_nocontact;
}
if ($genesys_nocontact < 0) {
    $genesys_nocontact = 0;
}

$objPHPExcel->getActiveSheet()->setCellValue('B' . $rowIndex + 1, 'Genesys Application');
$objPHPExcel->getActiveSheet()->setCellValue('E' . $rowIndex + 1, $genesys_nocontact);
$objPHPExcel->getActiveSheet()->setCellValue('F' . $rowIndex + 1, $genesys_attempt);
$objPHPExcel->getActiveSheet()->setCellValue('AE' . $rowIndex + 1, $genesys_nocontact);


$sqlGetHeader = "call  sp_get_headerReport_agentPerformance_by_importList('$LeadID','$GroupID','$TeamID');";
// $resultGetHeader = get_data_mysql($sqlGetHeader, $server);
$resultGetHeader = executeQuery($Conn, $sqlGetHeader);
while ($rowGetHeader = $resultGetHeader->fetch_assoc()) {
    $campaign_header_name = $rowGetHeader["campaign_name"];
    $sup_name = $rowGetHeader["sup_name"];
    $group_name = $rowGetHeader["group_name"];
}

// Free the result set
mysqli_free_result($resultGetHeader);

// Close the connection
mysqli_close($Conn);

$objPHPExcel->getActiveSheet()->setCellValue('C3', $campaign_header_name);
$objPHPExcel->getActiveSheet()->setCellValue('C4', $group_name);
$objPHPExcel->getActiveSheet()->setCellValue('C5', $sup_name);
$objPHPExcel->getActiveSheet()->setCellValue('C6', $currentdatetime);
$objPHPExcel->getActiveSheet()->setCellValue('C7', $DateStart . ' - ' . $DateEnd);

//echo date('H:i:s') , " Write to Excel5 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$objWriter->save($droot . $file_name);
$result = array("result" => "success", "fname" => $file_name);
echo json_encode($result);
