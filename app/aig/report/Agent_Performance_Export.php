<?php
// ini_set("display_errors", 0);

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
$group_id = $tmp["group_id"];
$team_id = $tmp["team_id"];
$listcomment = $tmp["listcomment"];
$campaign_id_selected = $tmp["campaign_id_selected"];



//$start = '01/07/2019';
//$end = '15/07/2019';

$start_dd = substr($start, 0, 2);    // 16/03/2016
$start_mm = substr($start, 3, 2);
$start_yy = substr($start, 6, 4);
$startdate = $start_yy . $start_mm . $start_dd;
$startdate2 = $start_yy . '-' . $start_mm . '-' . $start_dd;

$end_dd = substr($end, 0, 2);
$end_mm = substr($end, 3, 2);
$end_yy = substr($end, 6, 4);
$enddate =  $end_yy . $end_mm . $end_dd;
$enddate2 =  $end_yy . '-' . $end_mm . '-' . $end_dd;

//$startdate2 = '2019-07-01';
//$enddate2 =  '2019-07-16';
$currentdate = date("Y") . '-' . date("m") . '-' . date("d");
$currentdatetime = date("Y") . '-' . date("m") . '-' . date("d") . ' ' . date("H:i:s");
$report_date = $startdate2 . ' - ' . $enddate2;

if ($currentdate == $startdate2 && $currentdate == $enddate2) {
    $query = "call sp_get_report_agentPerformance_by_campaign_t_agent('$campaign_id_selected','$startdate2','$enddate2','$listcomment','$group_id','$team_id')";
} else {
    $query = "call sp_get_report_agentPerformance_by_campaign_t_agent_history('$campaign_id_selected','$startdate2','$enddate2','$listcomment','$group_id','$team_id')";
}





$result = executeQuery($Conn, $query);
// $result = mysqli_query($Conn, $query) or die("ไม่สามารถเรียกดูข้อมูลได้");
$templateFileName = 'templates/Agent_Performance.xls';
$objPHPExcel = PHPExcel_IOFactory::load($templateFileName);

$file_name = 'report_Agent_Performance-' . $currentdate . '.xls';

$genesys_nocontact = 0;
$genesys_attempt = 0;
$array_campaign_ids = [];
$total_list_use_summary = 0;

$rowIndex = 11;
while ($row = $result->fetch_assoc()) {

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

    $no_contact = $not_contact +  $not_update + $null_list;
    $list_total = $success + $unsuccess + $follow_up + $callback + $other + $no_contact;


    // Insert Blank Row
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($rowIndex + 1, 1);

    // Insert Data 
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

    $objPHPExcel->getActiveSheet()->setCellValue('U' . $rowIndex,  'succes');
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
// Free the result set
mysqli_free_result($result);


$sqlGetHeader = "call  sp_get_headerReport_campaignPerformance_by_campaign('$campaign_id_selected','$startdate2','$enddate2','$ListComment');";
// $resultGetHeader = mysqli_query($Conn, $sqlGetHeader);
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


$sqlGetCampaingName = "call sp_get_genesys_campaign_name_list_comment ('$campaign_id_selected','$listcomment');";
// $resultGetCampaingName = get_data_mysql($sqlGetCampaingName, $server);
$resultGetCampaingName = executeQuery($Conn, $sqlGetCampaingName);
while ($rowGetCampaingName = $resultGetCampaingName->fetch_assoc()) {
    $genesys_campaign_name = $rowGetCampaingName["genesys_campaign_name"];
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
                                    WHERE [date] BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59' 
                                    AND campaign_name IN ($genesys_campaign_name)
                                    AND last_wrap_up = 'ININ-OUTBOUND-NO-ANSWER'
                                    GROUP BY dnis
                                ) AS grouped_data;";
    $resultTotalNocontact = get_data_mssql($sqlTotalNocontact);
    while ($rowTotalNocontact = odbc_fetch_array($resultTotalNocontact)) {
        $genesys_nocontact = $rowTotalNocontact["genesys_no_contact"];
    }

    $sqlTotalAttempted = "SELECT COUNT(*) as genesys_attempt
                      FROM dbo.g_campaign_interaction_detail  
                      WHERE [date] BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59' 
                      AND campaign_name IN ($genesys_campaign_name);";
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

$sqlGetHeader = "call  sp_get_headerReport_agentPerformance_by_campaign('$campaign_id_selected','$group_id','$team_id');";
// $resultGetHeader =  mysqli_query($Conn, $sqlGetHeader) or die("ไม่สามารถเรียกดูข้อมูลได้");
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
$objPHPExcel->getActiveSheet()->setCellValue('C7', $startdate2 . ' - ' . $enddate2);

$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$droot = "temp/";
$objWriter->save($droot . $file_name);
$result = array("result" => "success", "fname" => $file_name);
echo json_encode($result);
