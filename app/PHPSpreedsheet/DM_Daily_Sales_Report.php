<?php
//call the autoload
// require("./function/setting.php");
require 'vendor/autoload.php';

$db_host = '192.168.50.2';
$db_username = 'tubtim';
$db_password = 'yOD6M0A0X0gz';
$db_name = 'tubtim';


$db = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}

$db->set_charset("utf8mb4");


$start = isset($_GET['startdate']) ? $_GET['startdate'] : '';
$end = isset($_GET['enddate']) ? $_GET['enddate'] : '';
$campaign_id = isset($_GET['campaign_id']) ? $_GET['campaign_id'] : '';
$campaign_id_lead_list = isset($_GET['campaign_id_lead_list']) ? $_GET['campaign_id_lead_list'] : '';
$campaign_id_selected = isset($_GET['campaign_id_selected']) ? $_GET['campaign_id_selected'] : '';

//not use
//$campaign_id_selected_lead_list = isset($_GET['campaign_id_selected_lead_list']) ? $_GET['campaign_id_selected_lead_list'] : '';
//$status_selected_list = isset($_GET['status_selected_list']) ? $_GET['status_selected_list'] : '';

$errormsg = 'status_selected_list: ' . $_GET['status_selected_list'];
error_log($errormsg);


$start_dd = substr($start, 0, 2); // 16/03/2016

$start_mm = substr($start, 3, 2);

$start_yy = substr($start, 6, 4);
$startdate = $start_yy . $start_mm . $start_dd;
$startdate2 = $start_yy . '-' . $start_mm . '-' . $start_dd;
$startdate3 = $start_mm . '/' . $start_dd . '/' . $start_yy;
$startdatelead = $start_yy . $start_mm;

$end_dd = substr($end, 0, 2); // 16/03/2016
$end_mm = substr($end, 3, 2);
$end_yy = substr($end, 6, 4);
$enddate = $end_yy . $end_mm . $end_dd;
$enddate2 = $end_yy . '-' . $end_mm . '-' . $end_dd;
$enddatelead = $end_yy . $end_mm;

//$currentdatetime = date("Y") . '-' . date("m") . '-' . date("d") . ' ' . date("H:i:s");

$report_date = $startdate2 . ' - ' . $enddate2;


$currentDateTime = date("Y-m-d");


// load phpspreadsheet class using namspaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// call xlsx writer class to make an xlsx file
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function PHPSTORM_META\type;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
$spreadsheet = $reader->load("DM_Daily_Sales_Report_spread.xls");

//$spreadsheet = new Spreadsheet();
// make a new spreadsheet object
$Excel_writer = new Xlsx($spreadsheet);
$Excel_writer->setOffice2003Compatibility(true);

$spreadsheet->setActiveSheetIndex(0);
//get currect active sheet (first sheet)
$activeSheet = $spreadsheet->getActiveSheet();

//baserow
$base_row = 8;




$columnMapping = [
    '01' => 'F', '02' => 'G', '03' => 'H', '04' => 'I', '05' => 'J',
    '06' => 'K', '07' => 'L', '08' => 'M', '09' => 'N', '10' => 'O',
    '11' => 'P', '12' => 'Q', '13' => 'R', '14' => 'S', '15' => 'T',
    '16' => 'U', '17' => 'V', '18' => 'W', '19' => 'X', '20' => 'Y',
    '21' => 'Z', '22' => 'AA', '23' => 'AB', '24' => 'AC', '25' => 'AD',
    '26' => 'AE', '27' => 'AF', '28' => 'AG', '29' => 'AH', '30' => 'AI',
    '31' => 'AJ'
];



//======================================NOT IN THE LOOP ==============================================//
//======================================NOT IN THE LOOP ==============================================//
//======================================NOT IN THE LOOP ==============================================//
//======================================NOT IN THE LOOP ==============================================//
//======================================NOT IN THE LOOP ==============================================//


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// find month ////
$activeSheet->setCellValue('C1', $startdate3);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sqlpasssingday = $db->query("SELECT COUNT(*) AS row_count
FROM (
    SELECT calendar AS count_of_occurrences, COUNT(*) AS tsr_total
    FROM (
        SELECT DISTINCT agent_id, DATE_FORMAT(history_date, '%d%m%Y') AS calendar
        FROM t_calllist_agent_history
        WHERE (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59')
    ) subquery
    GROUP BY calendar
) result;");

$row = $sqlpasssingday->fetch_assoc();

if (!empty($row) && isset($row['row_count'])) {
    $activeSheet->setCellValue('C4', $row['row_count']);
} else {
    // Handle the case where no rows are returned
    $activeSheet->setCellValue('C4', 'No passing day');
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////// ********** campaign type ********** //////////////

// $sqlcampaignType = $db->query("SELECT campaign_name FROM t_campaign where campaign_id in ($campaign_id_selected) ;");
// $rows = $sqlcampaignType->fetch_all(MYSQLI_ASSOC);

// if (!empty($rows)) {
//     $campaignType = array_column($rows, 'campaign_name');
//     $typeOf2 = array();

//     foreach ($campaignType as $value) {
//         if (strpos($value, "WC") === false && strpos($value, "XS") === false && strpos($value, "Winback") === false && strpos($value, "CM") === false) {
//             $typeOf2[] = "0";
//         } elseif (strpos($value, "WC") !== false) {
//             $typeOf2[] = "1";
//         } elseif (strpos($value, "XS") !== false) {
//             $typeOf2[] = "2";
//         } elseif (strpos($value, "Winback") !== false) {
//             $typeOf2[] = "3";
//         } elseif (strpos($value, "CM") !== false) {
//             $typeOf2[] = "4";
//         }
//     }

//     // Remove duplicates from $typeOf array
//     $typeOf2 = array_values(array_unique($typeOf2));

//     // Set default value based on conditions
//     if (count($typeOf2) > 1 && !in_array(0, $typeof2)) {
//         $defaultValue2 = "POM - CM";
//     } elseif (count($typeOf2) > 1) {
//         $defaultValue2 = "All";
//     } elseif (in_array("0", $typeOf2)) {
//         $defaultValue2 = "ACQ";
//     } elseif (in_array("1", $typeOf2)) {
//         $defaultValue2 = "POM - WC ";
//     } elseif (in_array("2", $typeOf2)) {
//         $defaultValue2 = "POM - XS ";
//     } elseif (in_array("3", $typeOf2)) {
//         $defaultValue2 = "POM - Winback ";
//     } elseif (in_array("4", $typeOf2)) {
//         $defaultValue2 = "POM - CM ";
//     } else {
//         $defaultValue2 = "Default Value2"; // Set a default value if none of the conditions are met
//     }

//     // Loop through the next 6 rows and set the value
//     for ($i = 0; $i < 23; $i++) {
//         $activeSheet->setCellValue('B' . ($base_row + $i), $defaultValue2);
//     }
// } else {
//     // Handle the case where no rows are returned
//     $activeSheet->setCellValue('B10', 'No totalList found');
// }

//======================================NOT IN THE LOOP ================================================//
//======================================NOT IN THE LOOP ================================================//
//======================================NOT IN THE LOOP ================================================//
//======================================NOT IN THE LOOP ================================================//
//======================================NOT IN THE LOOP ================================================//

// Convert $campaign_id_selected into an array
$campaign_id_selected_array = array();

// Check if $campaign_id_selected is not empty before adding it to the array
if (!empty($campaign_id_selected)) {
    $campaign_id_selected_array = explode(',', $campaign_id_selected);
}

foreach ($campaign_id_selected_array as $campaign_id_loop) {


    // echo 'loop1 ' . $campaign_id_loop;
    // echo 'loop1 ' . $campaign_id_loop . "\n";
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** campaign name ********** ////////////
    $sqlcampaignName = $db->query("SELECT campaign_name FROM t_campaign where campaign_id in ($campaign_id_loop) ;");
    $rows = $sqlcampaignName->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $campaignName = array_column($rows, 'campaign_name');
        $typeOf = array();

        foreach ($campaignName as $value) {
            if (strpos($value, "WC") === false && strpos($value, "XS") === false && strpos($value, "Winback") === false && strpos($value, "CM") === false) {
                $typeOf[] = "0";
            } elseif (strpos($value, "WC") !== false) {
                $typeOf[] = "1";
            } elseif (strpos($value, "XS") !== false) {
                $typeOf[] = "2";
            } elseif (strpos($value, "Winback") !== false) {
                $typeOf[] = "3";
            } elseif (strpos($value, "CM") !== false) {
                $typeOf[] = "4";
            }
        }
        // Remove duplicates from $typeOf array
        $typeOfUnique = array_values(array_unique($typeOf));

        // Set default value based on conditions
        if (count($typeOfUnique) > 1 && !in_array(0, $typeOfUnique)) {
            $defaultValue = "Total POM CM";
            $defaultValue2 = "POM - CM";
            $typeforkpi = 5;
        } elseif (count($typeOfUnique) > 1) {
            $defaultValue = "Total Campaign";
            $defaultValue2 = "All";
            $typeforkpi = 6;
        } else {
            $type = isset($typeOfUnique[0]) ? $typeOfUnique[0] : "0"; // Default to "0" if no type foundd

            switch ($type) {
                case "0":
                    $defaultValue = count($typeOf) > 1 ? "Total ACQ" : "$campaignName[0]";
                    $defaultValue2 = "ACQ";
                    $typeforkpi = 1;

                    break;
                case "1":
                    $defaultValue = count($typeOf) > 1 ? "Total POM WC" : "$campaignName[0]";
                    $defaultValue2 = "POM - WC";
                    $typeforkpi = 3;
                    break;
                case "2":
                    $defaultValue = count($typeOf) > 1 ? "Total POM XS" : "$campaignName[0]";
                    $defaultValue2 = "POM - XS";
                    $typeforkpi = 2;
                    break;
                case "3":
                    $defaultValue = count($typeOf) > 1 ? "Total POM Winback" : "$campaignName[0]";
                    $defaultValue2 = "POM - Winback";
                    $typeforkpi = 4;
                    break;
                case "4":
                    $defaultValue = count($typeOf) > 1 ? "Total POM CM" : "$campaignName[0]";
                    break;
                default:
                    $defaultValue = "Unknown Type";
            }
        }


        // Loop through the next 6 rows and set the value
        for ($i = 0; $i < 23; $i++) {
            $activeSheet->setCellValue('C' . ($base_row + $i), $defaultValue);
            $activeSheet->setCellValue('B' . ($base_row + $i), $defaultValue2);
        }


        $concatenatedString = implode(', ', $campaignName);
        $activeSheet->setCellValue('D3', $concatenatedString);
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('C10', 'No totalList found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////// TARGET /////////////////////////////////////////////////////////////////////
    //////////////////////////////////// TARGET /////////////////////////////////////////////////////////////////////
    //////////////////////////////////// TARGET /////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** TARGET ********** ////////////  ///

    $sqltarget = $db->query("SELECT c.campaign_id as campnum,campaign_name,campaign_mode,Target_Contact,Target_Response,Target_AARP,Target_TARP,Target_App

FROM 
t_campaign c LEFT JOIN
(
SELECT t1.*
FROM t_calllist_agent_history t1
JOIN (
    SELECT calllist_id,last_wrapup_option_id,MAX(history_date) AS max_history_date
    FROM t_calllist_agent_history WHERE (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59') AND campaign_id IN ($campaign_id_loop) AND import_id IN (SELECT il.import_id FROM t_import_list il INNER JOIN t_campaign_list cl ON il.import_id = cl.import_id WHERE cl.campaign_id in ($campaign_id_loop) AND il.list_comment = DATE_FORMAT('$enddate2','%Y%m')) GROUP BY calllist_id
) t2 ON t1.calllist_id = t2.calllist_id AND t1.history_date = t2.max_history_date
) a ON c.campaign_id = a.campaign_id WHERE c.campaign_id IN ($campaign_id_loop)
GROUP BY  campnum");
    $rows = $sqltarget->fetch_all(MYSQLI_ASSOC);

    $total_calllist_upload_use_summary = 0;
    $target_tarp_summary = 0;
    $target_app_summary = 0;
    $target_contactable_summary = 0;

    //dnc
    $total_calllist_dnc_cpsum = 0;

    if (!empty($rows)) {
        $targetContact = array_column($rows, 'Target_Contact', 'campnum');
        $targetResp = array_column($rows, 'Target_Response', 'campnum');
        $targetAARP = array_column($rows, 'Target_AARP', 'campnum');



        foreach ($targetContact as $campaign_id2 => $target_contact) {
            $target_resp = $targetResp[$campaign_id2];
            $target_aarp = $targetAARP[$campaign_id2];

            $sqlTotalCalllistUploadPercampaign = $db->query("SELECT SUM(total_records) As TotalCalllistUploadPercampaign FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id2)) AND is_count != 0 AND list_comment = DATE_FORMAT('$enddate2','%Y%m')");
            $rowTotalCalllistUploadPercampaign = $sqlTotalCalllistUploadPercampaign->fetch_assoc();
            $total_calllist_upload_cp  = $rowTotalCalllistUploadPercampaign['TotalCalllistUploadPercampaign'];

            $sqlTotalCalllistManualAddPercampaign = $db->query("SELECT COUNT(DISTINCT calllist_id) AS TotalCalllistManualAddPercampaign FROM t_calllist WHERE import_id IN (SELECT import_id As TotalCalllist FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id2)) AND is_count = 0 AND list_comment = DATE_FORMAT('$enddate2','%Y%m'))");
            $rowTotalCalllistManualAddPercampaign = $sqlTotalCalllistManualAddPercampaign->fetch_assoc();
            $total_calllist_manual_add_cp = $rowTotalCalllistManualAddPercampaign['TotalCalllistManualAddPercampaign'];

            $sqlTotalCalllistDNCPercampaign = $db->query("SELECT COUNT(DISTINCT l.calllist_id) AS TotalCalllistDNCPercampaign FROM t_calllist l LEFT JOIN t_calllist_agent_history h ON l.calllist_id = h.calllist_id WHERE l.status IN (11,12,13,14,15,16,17,18,19) AND l.import_id IN (SELECT import_id As TotalCalllist FROM t_import_list WHERE import_id IN (SELECT import_id FROM t_campaign_list WHERE campaign_id in ($campaign_id2)) AND list_comment = DATE_FORMAT('$enddate2','%Y%m')) AND h.last_wrapup_id IS NULL");
            $rowTotalCalllistDNCPercampaign = $sqlTotalCalllistDNCPercampaign->fetch_assoc();
            $total_calllist_dnc_cp = $rowTotalCalllistDNCPercampaign['TotalCalllistDNCPercampaign'];



            //dnc 
            $total_calllist_dnc_cpsum = $total_calllist_dnc_cpsum + $total_calllist_dnc_cp;

            $total_calllist_upload_use = ($total_calllist_upload_cp + $total_calllist_manual_add_cp) - $total_calllist_dnc_cp;
            $target_tarp = $total_calllist_upload_use * $target_contact * $target_resp * $target_aarp;
            $target_app = $total_calllist_upload_use * $target_contact * $target_resp;
            $target_contactable = $total_calllist_upload_use * $target_contact;

            $total_calllist_upload_use_summary = $total_calllist_upload_use_summary + $total_calllist_upload_use;
            $target_tarp_summary = $target_tarp_summary + $target_tarp;
            $target_app_summary = $target_app_summary + $target_app;
            $target_contactable_summary = $target_contactable_summary + $target_contactable;
        }



        //$activeSheet->setCellValue('E15', ($target_contactable_summary / $total_calllist_upload_use_summary));
        $activeSheet->setCellValue('E' . ($base_row + 11), ($target_tarp_summary));
        $activeSheet->setCellValue('E' . ($base_row + 10), ($target_app_summary));
        //$activeSheet->setCellValue('C6', ($total_calllist_dnc_cpsum));
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('E10', 'No totalList found');
    }
    // Set default value based on conditions
    // if (count($typeOf2) > 1 && !in_array(0, $typeof2)) {
    //     $typeforkpi = 5;
    // } elseif (count($typeOf2) > 1) {
    //     $typeforkpi = 6;
    // } elseif (in_array("0", $typeOf2)) {
    //     $typeforkpi = 1;
    // } elseif (in_array("1", $typeOf2)) {
    //     $typeforkpi = 3;
    // } elseif (in_array("2", $typeOf2)) {
    //     $typeforkpi = 2;
    // } elseif (in_array("3", $typeOf2)) {
    //     $typeforkpi = 4;
    // } elseif (in_array("4", $typeOf2)) {
    //     $typeforkpi = "POM - CM ";
    // } else {
    //     $typeforkpi = "Default Value2"; // Set a default value if none of the conditions are met // update
    // }

    $sqltargetKPI = $db->query("SELECT numbe_of_tsr,leads,contact_percentage,response_percentage,gross_tarp,aarp FROM t_kpi_monthly_target WHERE type_id = $typeforkpi AND month = date_format('$enddate2','%m')");
    $rows = $sqltargetKPI->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {


        $activeSheet->setCellValue('E' .  ($base_row), $rows[0]['numbe_of_tsr']); // Assuming you want the first row
        $activeSheet->setCellValue('E' .  ($base_row + 2), $rows[0]['leads']); // Assuming you want the first row
        $activeSheet->setCellValue('E' .  ($base_row + 7), $rows[0]['contact_percentage']); // Assuming you want the first row
        $activeSheet->setCellValue('E' .  ($base_row + 8), $rows[0]['response_percentage']); // Assuming you want the first row
        //$activeSheet->setCellValue('E' .  ($base_row + 9), $rows[0]['conversion_percentage']); // Assuming you want the first row
        // $activeSheet->setCellValue('E' .  ($base_row + 11), $rows[0]['issued_tarp']); // Assuming you want the first row
        $activeSheet->setCellValue('E' .  ($base_row + 12), $rows[0]['aarp']); // Assuming you want the first row
        $activeSheet->setCellValue('E' .  ($base_row + 19), $rows[0]['gross_tarp']); // Assuming you want the first row
        // Assuming $base_row is the starting row number
        // $activeSheet->setCellValue('E' . ($base_row), $targetKPI['numbe_of_tsr']);
        // $activeSheet->setCellValue('E' . ($base_row + 2), $targetKPI['leads']);
        // $activeSheet->setCellValue('E' . ($base_row + 7), $targetKPI['contact_percentage']);
        // $activeSheet->setCellValue('E' . ($base_row + 8), $targetKPI['response_percentage']);
        // $activeSheet->setCellValue('E' . ($base_row + 8), $targetKPI['conversion_percentage']);
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('E' . $base_row, 'No numbe_of_tsr found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////// TARGET /////////////////////////////////////////////////////////////////////
    //////////////////////////////////// TARGET /////////////////////////////////////////////////////////////////////
    //////////////////////////////////// TARGET /////////////////////////////////////////////////////////////////////

    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // //////////// ********** total List up loaded ********** ////////////  ##OK##

    $sqlTotal_ListUploaded = $db->query("SELECT campaign_id, tci.import_id, il.total_records, il.list_comment,sum(total_records)
FROM t_campaign_list tci
LEFT JOIN t_import_list il ON tci.import_id = il.import_id
WHERE campaign_id IN ($campaign_id_loop) AND il.list_comment = DATE_FORMAT('$enddate2', '%Y%m');");
    $rows = $sqlTotal_ListUploaded->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $totalList_upload = array_column($rows, 'sum(total_records)');
        $activeSheet->setCellValue('AK' . ($base_row + 2), implode(', ', $totalList_upload));
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('AK10', 'No totalList found');
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** TSR Total on that day  ********** ////////////  ##OK##

    // $sqltsrtotal = $db->query("SELECT calendar as count_of_occurrences, count(*) as tsr_total
    //     FROM (SELECT distinct  agent_id,DATE_FORMAT(history_date, '%d%m%Y') as calendar 
    //     FROM t_calllist_agent_history 
    //     where (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59')) subquery 
    //     group by calendar");
    // $rows = $sqltsrtotal->fetch_all(MYSQLI_ASSOC);

    // if (!empty($rows)) {
    //     $tsrtotal = array_column($rows, 'tsr_total', 'count_of_occurrences');

    //     foreach ($tsrtotal as $count_of_occurrences => $value) {
    //         $firstTwoDigits = substr($calendar, 0, 2);

    //         if (isset($columnMapping[$firstTwoDigits])) {
    //             $columnLetter = $columnMapping[$firstTwoDigits];
    //             $activeSheet->setCellValue($columnLetter . ($base_row), $value);
    //         } else {
    //             // Handle other cases if needed
    //         }
    //     }
    // } else {
    //     // Handle the case where no rows are returned
    //     $activeSheet->setCellValue('N' .  ($base_row), 'No list found');
    // }


    $sqltsrtota = $db->query("SELECT calendar as count_of_occurrences, count(*) as tsr_total
    FROM (SELECT distinct  agent_id,DATE_FORMAT(history_date, '%d%m%Y') as calendar 
    FROM t_calllist_agent_history 
    where (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59')) subquery 
    group by calendar");
    $rows = $sqltsrtota->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $sqltsrtota = array_column($rows, 'tsr_total', 'count_of_occurrences');

        foreach ($sqltsrtota as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row), 'No list found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** TSR Working on that day  ********** ///////////////  ##OK##
    $sqltsrworking = $db->query("SELECT calendar as count_of_occurrences, count(*) as tsr_working 
        FROM (SELECT distinct  agent_id,DATE_FORMAT(history_date, '%d%m%Y') as calendar 
        FROM t_calllist_agent_history 
        where (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59') AND campaign_id in ($campaign_id_loop) ) subquery 
        group by calendar");
    $rows = $sqltsrworking->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $tsrworking = array_column($rows, 'tsr_working', 'count_of_occurrences');

        foreach ($tsrworking as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 1), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 1), 'No list found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** total list used ->  list_contact ********** ////////////  ##OK##
    $sqlListUsed = $db->query("SELECT c.campaign_id,campaign_name,DATE_FORMAT(history_date, '%d%m%Y') as calendar ,

COUNT(DISTINCT (case 
when last_wrapup_option_id in (0,1,2,3,4,5,6,7,8,9) then calllist_id
ELSE NULL
END)) list_contact

FROM 
t_campaign c LEFT JOIN
(
SELECT t1.*
FROM t_calllist_agent_history t1
JOIN (
    SELECT calllist_id,last_wrapup_option_id,MAX(history_date) AS max_history_date
    FROM t_calllist_agent_history WHERE (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59') AND campaign_id IN ($campaign_id_loop) AND import_id IN (SELECT il.import_id FROM t_import_list il INNER JOIN t_campaign_list cl ON il.import_id = cl.import_id WHERE cl.campaign_id in ($campaign_id_loop) AND il.list_comment = DATE_FORMAT('$enddate2','%Y%m')) GROUP BY calllist_id
) t2 ON t1.calllist_id = t2.calllist_id AND t1.history_date = t2.max_history_date
) a ON c.campaign_id = a.campaign_id WHERE c.campaign_id IN ($campaign_id_loop)
GROUP BY DATE_FORMAT(history_date, '%d%m%Y')
;
");
    $rows = $sqlListUsed->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $listUsed = array_column($rows, 'list_contact', 'calendar');

        foreach ($listUsed as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 3), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 3), 'No list found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** New list used ********** ////////////  
    $sqllist_new = $db->query("
SELECT DATE_FORMAT(history_date, '%d%m%Y') as calendar,

COUNT(DISTINCT (case 
when is_new = 1 then calllist_id
ELSE NULL
END)) list_new

FROM 
(
SELECT tc.*,ta.first_name,ta.last_name,
IF(
    EXISTS(
      SELECT 1
      FROM t_call_trans h
      WHERE DATE(h.create_date) < DATE(tc.history_date) AND h.calllist_id = tc.calllist_id
    ),
    '0',
    '1'
 ) AS is_new
FROM (
SELECT t1.*
FROM t_calllist_agent_history t1
JOIN (
    SELECT calllist_id,last_wrapup_option_id,MAX(history_date) AS max_history_date
    FROM t_calllist_agent_history WHERE (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59') AND campaign_id in ($campaign_id_loop) AND import_id IN (SELECT il.import_id FROM t_import_list il INNER JOIN t_campaign_list cl ON il.import_id = cl.import_id WHERE cl.campaign_id in ($campaign_id_loop) AND il.list_comment = DATE_FORMAT('$enddate2','%Y%m')) GROUP BY calllist_id
) t2 ON t1.calllist_id = t2.calllist_id AND t1.history_date = t2.max_history_date
) tc LEFT JOIN t_agents ta ON tc.agent_id=ta.agent_id WHERE (tc.history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59') AND tc.campaign_id in ($campaign_id_loop) 
) a GROUP BY  calendar");
    $rows = $sqllist_new->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $list_new = array_column($rows, 'list_new', 'calendar');

        foreach ($list_new as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 4), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 4), 'No list found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** contactable - > list_contact_new + list_contact_old ********** ////////////  ##OK##
    $sqlcontactable = $db->query("SELECT 
campaign_id,
campaign_name,
formatted_date,
list_contact,
list_success,
list_unsuccess,
list_followup,
list_callback,
list_nocontact,
list_badlist,
list_donotcall,
list_overcall,
(list_success + list_unsuccess + list_followup + list_callback + list_donotcall + list_overcall) AS contactable
FROM (
SELECT 
    c.campaign_id,
    campaign_name,
    DATE_FORMAT(history_date, '%d%m%Y') AS formatted_date,
    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id IN (0,1,2,3,4,5,6,7,8,9) THEN calllist_id
        ELSE NULL
    END)) AS list_contact,

    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id IN (6,9) THEN calllist_id
        ELSE NULL
    END)) AS list_success,

    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id = 7 THEN calllist_id
        ELSE NULL
    END)) AS list_unsuccess,

    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id IN (2) THEN calllist_id
        ELSE NULL
    END)) AS list_followup,

    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id = 1 THEN calllist_id
        ELSE NULL
    END)) AS list_callback,

    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id = 8 THEN calllist_id
        ELSE NULL
    END)) AS list_nocontact,

    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id = 4 THEN calllist_id
        ELSE NULL
    END)) AS list_badlist,

    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id = 3 THEN calllist_id
        ELSE NULL
    END)) AS list_donotcall,

    COUNT(DISTINCT (CASE 
        WHEN last_wrapup_option_id IN (0,5) THEN calllist_id
        ELSE NULL
    END)) AS list_overcall
FROM 
    t_campaign c 
LEFT JOIN (
    SELECT t1.*
    FROM t_calllist_agent_history t1
    JOIN (
        SELECT calllist_id, last_wrapup_option_id, MAX(history_date) AS max_history_date
        FROM t_calllist_agent_history 
        WHERE (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59') 
            AND campaign_id IN ($campaign_id_loop) 
            AND import_id IN (
                SELECT il.import_id 
                FROM t_import_list il 
                INNER JOIN t_campaign_list cl 
                ON il.import_id = cl.import_id 
                WHERE cl.campaign_id IN ($campaign_id_loop) 
                AND il.list_comment = DATE_FORMAT('$enddate2','%Y%m')
            ) 
        GROUP BY calllist_id
    ) t2 ON t1.calllist_id = t2.calllist_id AND t1.history_date = t2.max_history_date
) a ON c.campaign_id = a.campaign_id 
WHERE c.campaign_id IN ($campaign_id_loop)
GROUP BY formatted_date
) subquery;
");
    $rows = $sqlcontactable->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $contactable = array_column($rows, 'contactable', 'formatted_date');

        foreach ($contactable as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 6), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 6), 'No list found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** submit APP  ********** ////////////  ##OK##
    $sqlsubbmitApp = $db->query("SELECT 
COUNT(DISTINCT(CASE WHEN AppStatus NOT IN ('Follow-doc') THEN id ELSE NULL END)) sale_front,
DATE_FORMAT(create_date, '%d%m%Y') AS calendar,
COUNT(DISTINCT(CASE WHEN AppStatus IN ('Approve') THEN id ELSE NULL END)) sale_back,
SUM(CASE WHEN AppStatus NOT IN ('Follow-doc') AND PAYMENTFREQUENCY IN ('รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) premium_year_front,
SUM(CASE WHEN AppStatus NOT IN ('Follow-doc') AND PAYMENTFREQUENCY IN ('รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END) premium_month_front,
SUM(CASE WHEN AppStatus IN ('Approve') AND PAYMENTFREQUENCY IN ('รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) premium_year_back,
SUM(CASE WHEN AppStatus IN ('Approve') AND PAYMENTFREQUENCY IN ('รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END) premium_month_back
FROM t_aig_app 
WHERE (create_date BETWEEN '$startdate2 00:00' AND '$enddate2 23:59') 
AND campaign_id in ($campaign_id_loop)
GROUP BY DATE_FORMAT(create_date, '%d%m%Y');");
    $rows = $sqlsubbmitApp->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $subbmitApp = array_column($rows, 'sale_front', 'calendar');

        foreach ($subbmitApp as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 10), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 10), 'No list found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** tarp submit   ********** ////////////  ##OK##
    $sqltarpsubbmit = $db->query("SELECT 
sale_front,
formatted_create_date,
sale_back,
tarp_app,
tarp_appv
FROM (
SELECT 
  COUNT(DISTINCT(CASE WHEN AppStatus NOT IN ('Follow-doc') THEN id ELSE NULL END)) AS sale_front,
  DATE_FORMAT(create_date, '%d%m%Y') AS formatted_create_date,
  COUNT(DISTINCT(CASE WHEN AppStatus IN ('Approve') THEN id ELSE NULL END)) AS sale_back,
  (SUM(CASE WHEN AppStatus NOT IN ('Follow-doc') AND PAYMENTFREQUENCY IN ('รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) +
   SUM(CASE WHEN AppStatus NOT IN ('Follow-doc') AND PAYMENTFREQUENCY IN ('รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END)) AS tarp_app,
  (SUM(CASE WHEN AppStatus IN ('Approve') AND PAYMENTFREQUENCY IN ('รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) +
  SUM(CASE WHEN AppStatus IN ('Approve') AND PAYMENTFREQUENCY IN ('รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END)) AS tarp_appv
FROM t_aig_app 
WHERE (create_date BETWEEN '$startdate2 00:00' AND '$enddate2 23:59') 
  AND campaign_id in ($campaign_id_loop) 
GROUP BY formatted_create_date
) AS subquery;
");
    $rows = $sqltarpsubbmit->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $tarpsubbmit = array_column($rows, 'tarp_app', 'formatted_create_date');

        foreach ($tarpsubbmit as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 11), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 11), 'No list found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////// ********** appAppv   ********** ////////////  ##OK##
    $sqlappAppv = $db->query("SELECT 
sale_front,
formatted_create_date,
sale_back,
tarp_app,
tarp_appv
FROM (
SELECT 
  COUNT(DISTINCT(CASE WHEN AppStatus NOT IN ('Follow-doc') THEN id ELSE NULL END)) AS sale_front,
  DATE_FORMAT(create_date, '%d%m%Y') AS formatted_create_date,
  COUNT(DISTINCT(CASE WHEN AppStatus IN ('Approve') THEN id ELSE NULL END)) AS sale_back,
  (SUM(CASE WHEN AppStatus NOT IN ('Follow-doc') AND PAYMENTFREQUENCY IN ('รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) +
   SUM(CASE WHEN AppStatus NOT IN ('Follow-doc') AND PAYMENTFREQUENCY IN ('รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END)) AS tarp_app,
  (SUM(CASE WHEN AppStatus IN ('Approve') AND PAYMENTFREQUENCY IN ('รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) +
  SUM(CASE WHEN AppStatus IN ('Approve') AND PAYMENTFREQUENCY IN ('รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END)) AS tarp_appv
FROM t_aig_app 
WHERE (create_date BETWEEN '$startdate2 00:00' AND '$enddate2 23:59') 
  AND campaign_id in ($campaign_id_loop) 
GROUP BY formatted_create_date
) AS subquery;
");
    $rows = $sqlappAppv->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $appAppv = array_column($rows, 'sale_back', 'formatted_create_date');

        foreach ($appAppv as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 13), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 13), 'No list found');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////// ********** tarp_appv   ********** ////////////  ##OK##
    $sqltarp_appv = $db->query("SELECT 
sale_front,
formatted_create_date,
sale_back,
tarp_app,
tarp_appv
FROM (
SELECT 
  COUNT(DISTINCT(CASE WHEN AppStatus NOT IN ('Follow-doc') THEN id ELSE NULL END)) AS sale_front,
  DATE_FORMAT(create_date, '%d%m%Y') AS formatted_create_date,
  COUNT(DISTINCT(CASE WHEN AppStatus IN ('Approve') THEN id ELSE NULL END)) AS sale_back,
  (SUM(CASE WHEN AppStatus NOT IN ('Follow-doc') AND PAYMENTFREQUENCY IN ('รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) +
   SUM(CASE WHEN AppStatus NOT IN ('Follow-doc') AND PAYMENTFREQUENCY IN ('รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END)) AS tarp_app,
  (SUM(CASE WHEN AppStatus IN ('Approve') AND PAYMENTFREQUENCY IN ('รายปี') THEN INSTALMENT_PREMIUM ELSE 0 END) +
  SUM(CASE WHEN AppStatus IN ('Approve') AND PAYMENTFREQUENCY IN ('รายเดือน') THEN (INSTALMENT_PREMIUM*12) ELSE 0 END)) AS tarp_appv
FROM t_aig_app 
WHERE (create_date BETWEEN '$startdate2 00:00' AND '$enddate2 23:59') 
  AND campaign_id in ($campaign_id_loop) 
GROUP BY formatted_create_date
) AS subquery;
");
    $rows = $sqltarp_appv->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $tarp_appv = array_column($rows, 'tarp_appv', 'formatted_create_date');

        foreach ($tarp_appv as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 14), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 14), 'No list found');
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////// ********** Unsucess App -> Unsucess List - > ?  ********** ////////////  

    $sqlunsuccess = $db->query("SELECT DATE_FORMAT(history_date, '%d%m%Y') as calendar,
COUNT(DISTINCT (case 
when last_wrapup_option_id = 7 then calllist_id
ELSE NULL
END)) list_unsuccess
FROM 
t_campaign c LEFT JOIN
(
SELECT t1.*
FROM t_calllist_agent_history t1
JOIN (
    SELECT calllist_id,last_wrapup_option_id,MAX(history_date) AS max_history_date
    FROM t_calllist_agent_history WHERE (history_date BETWEEN '$startdate2 00:00:00' AND '$enddate2 23:59:59') AND campaign_id IN ($campaign_id_loop) AND import_id IN (SELECT il.import_id FROM t_import_list il INNER JOIN t_campaign_list cl ON il.import_id = cl.import_id WHERE cl.campaign_id in ($campaign_id_loop) AND il.list_comment = DATE_FORMAT('$enddate2','%Y%m')) GROUP BY calllist_id
) t2 ON t1.calllist_id = t2.calllist_id AND t1.history_date = t2.max_history_date
) a ON c.campaign_id = a.campaign_id WHERE c.campaign_id IN ($campaign_id_loop)
GROUP BY  calendar");
    $rows = $sqlunsuccess->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $unsuccess = array_column($rows, 'list_unsuccess', 'calendar');

        foreach ($unsuccess as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 20), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 20), 'No list found');
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////// ********** call_attemped   ********** ////////////  ##OK##
    $sqlcall_attemped = $db->query("SELECT COUNT(*) as call_attemped ,DATE_FORMAT(create_date, '%d%m%Y') as formatted_create_date FROM t_call_trans where campaign_id in ($campaign_id_loop) and create_date BETWEEN '$startdate2 00:00:00' and '$enddate2 23:59:59' group by DATE_FORMAT(create_date, '%d%m%Y')");
    $rows = $sqlcall_attemped->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $call_attemped = array_column($rows, 'call_attemped', 'formatted_create_date');

        foreach ($call_attemped as $calendar => $value) {
            $firstTwoDigits = substr($calendar, 0, 2);

            if (isset($columnMapping[$firstTwoDigits])) {
                $columnLetter = $columnMapping[$firstTwoDigits];
                $activeSheet->setCellValue($columnLetter . ($base_row + 22), $value);
            } else {
                // Handle other cases if needed
            }
        }
    } else {
        // Handle the case where no rows are returned
        $activeSheet->setCellValue('N' .  ($base_row + 22), 'No list found');
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $base_row = $base_row + 24;
}

$filename = 'DM_Daily_Sales_Report_spread-' . $currentDateTime . '.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$Excel_writer->save('php://output');
