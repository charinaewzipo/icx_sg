<?php
session_start();
include "../../../dbconn.php";
include "../../../util.php";
include "../../../license.php";
include "../../../wlog.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Function to fetch data for agents
function DBGetPolicyDetailsWithId($policyId)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Prepare the SQL query to select data by policyId
    $sql = "SELECT id, policyId, productId, distributionChannel, producerCode, propDate, policyEffDate, policyExpDate, campaignCode, ncdInfo, policyHolderInfo, insuredList, quoteNo, premiumPayable, quoteLapseDate, `type`,remarksC
FROM t_aig_app
            WHERE policyId = ?";

    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind the policyId parameter
        $stmt->bind_param("i", $policyId);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the data as an associative array
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode(array("result" => "success", "data" => $data));
        } else {
            echo json_encode(array("result" => "error", "message" => "No data found for the given policyId"));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array("result" => "error", "message" => "Failed to prepare SQL statement"));
    }

    // Close the database connection
    $dbconn->dbconn->close();
}
function DBGetPaymentLogWithId($policyId)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Prepare the SQL query to select data by policyId
    $sql = "SELECT * FROM t_aig_sg_payment_log
            WHERE policyId = ?";

    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind the policyId parameter
        $stmt->bind_param("i", $policyId);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the data as an associative array
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode(array("result" => "success", "data" => $data));
        } else {
            echo json_encode(array("result" => "error", "message" => "No data found for the given policyId"));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array("result" => "error", "message" => "Failed to prepare SQL statement"));
    }

    // Close the database connection
    $dbconn->dbconn->close();
}
function DBInsertQuotationData($formData, $response, $type)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }


    $policyId = isset($response['policyId']) ? $response['policyId'] : '';
    $productId = isset($formData['productId']) ? $formData['productId'] : 0;
    $type = isset($type) ? $type : '';
    $remarksC =  isset($formData['remarksC']) ? $formData['remarksC'] : '';
    $distributionChannel = isset($formData['distributionChannel']) ? $formData['distributionChannel'] : 0;
    $producerCode = isset($formData['producerCode']) ? $formData['producerCode'] : '0002466000';
    $propDate = isset($formData['propDate']) ? $formData['propDate'] : '';
    $policyEffDate = isset($formData['policyEffDate']) ? $formData['policyEffDate'] : '2024-07-31T17:00:00.000Z';
    $policyExpDate = isset($formData['policyExpDate']) ? $formData['policyExpDate'] : '2024-08-07T17:00:00.000Z';
    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $quoteLapseDate = isset($response['quoteLapseDate'])
        ? transformDate($response['quoteLapseDate'])
        : '2024-08-07T17:00:00.000Z';
    $ncdInfo = isset($formData['ncdInfo']) ? json_encode($formData['ncdInfo']) : '{}';
    $policyHolderInfo = isset($formData['policyHolderInfo']) ? json_encode($formData['policyHolderInfo']) : '{}';
    $insuredList = isset($formData['insuredList']) ? json_encode($formData['insuredList']) : '{}';

    $ncdInfo = mysqli_real_escape_string($dbconn->dbconn, $ncdInfo);
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);

    $sql = "INSERT INTO t_aig_app (
        policyId,type, productId, distributionChannel, producerCode, propDate, policyEffDate,
        policyExpDate, campaignCode, ncdInfo, policyHolderInfo, insuredList, quoteNo,premiumPayable,quoteLapseDate,remarksC
    ) VALUES (
        '$policyId','$type', $productId, $distributionChannel, '$producerCode', '$propDate',
        '$policyEffDate', '$policyExpDate', '$campaignCode', '$ncdInfo', '$policyHolderInfo',
        '$insuredList', '$quoteNo' ,'$premiumPayable' ,'$quoteLapseDate','$remarksC'
    )";

    // Execute query
    $result = $dbconn->executeUpdate($sql);

    if (!$result) {
        $error = mysqli_error($dbconn->dbconn);
        echo json_encode(array("result" => "error", "message" => "Data insertion failed: $error"));
    } else {
        echo json_encode(array("result" => "success", "message" => "Data inserted successfully"));
    }
}

function DBInsertPolicyData($policyid, $policyNo)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }


    // Use prepared statements to avoid SQL injection
    $sql = "INSERT INTO policy_data (policyId, policyNo) VALUES (?, ?)";

    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("is", $policyid, $policyNo);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(array("result" => "success", "message" => "Data inserted successfully"));
        } else {
            echo json_encode(array("result" => "error", "message" => "Data insertion failed: " . $stmt->error));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array("result" => "error", "message" => "Failed to prepare SQL statement"));
    }

    // Close the database connection
    $dbconn->dbconn->close();
}

function DBInsertPaymentLog($request, $response,$policyid)
{
    // Create database connection
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Extract data from request and response
    $order_amount = isset($request['order']['amount']) ? $request['order']['amount'] : 0.00;
    $order_currency = isset($request['order']['currency']) ? $request['order']['currency'] : '';
    $sourceOfFundsType = isset($request['sourceOfFunds']['type']) ? $request['sourceOfFunds']['type'] : '';
    $cardNumber = isset($request['sourceOfFunds']['provided']['card']['number']) ? maskCreditCardNumbers($request['sourceOfFunds']['provided']['card']['number']) : '';
    $expiryMonth = isset($request['sourceOfFunds']['provided']['card']['expiry']['month']) ? $request['sourceOfFunds']['provided']['card']['expiry']['month'] : '';
    $expiryYear = isset($request['sourceOfFunds']['provided']['card']['expiry']['year']) ? $request['sourceOfFunds']['provided']['card']['expiry']['year'] : '';
    $securityCode = isset($request['sourceOfFunds']['provided']['card']['securityCode']) ? $request['sourceOfFunds']['provided']['card']['securityCode'] : '';
    $merchant = isset($response['merchant']) ? $response['merchant'] : '';
    $result = isset($response['result']) ? $response['result'] : '';
    $timeOfLastUpdate = isset($response['timeOfLastUpdate']) ? $response['timeOfLastUpdate'] : '';
    $timeOfRecord = isset($response['timeOfRecord']) ? $response['timeOfRecord'] : '';

    // Encode the response array as a JSON string
    $responseJson = isset($response) ? json_encode($response) : '{}';
    $responseJson = mysqli_real_escape_string($dbconn->dbconn, $responseJson);

    // SQL query to insert data into the database
    $sql = "INSERT INTO t_aig_sg_payment_log (order_amount, order_currency, source_of_funds_type, card_number, card_expiry_month, card_expiry_year, card_security_code, merchant, result, time_of_lastupdate, time_of_record, response_json,policyId) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    // Use prepared statements to avoid SQL injection
    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param(
            "dssssssssssss",
            $order_amount,
            $order_currency,
            $sourceOfFundsType,
            $cardNumber,
            $expiryMonth,
            $expiryYear,
            $securityCode,
            $merchant,
            $result,
            $timeOfLastUpdate,
            $timeOfRecord,
            $responseJson,
            $policyid
        );

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(array("result" => "success", "message" => "Data inserted successfully"));
        } else {
            echo json_encode(array("result" => "error", "message" => "Data insertion failed: " . $stmt->error));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array("result" => "error", "message" => "Failed to prepare SQL statement"));
    }

    // Close the database connection
    $dbconn->dbconn->close();
}



function DBInsertPlanInfoWithCovers($planInfo)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Insert plan information
    $sqlPlan = "INSERT INTO plan_info (plan_id, plan_description, plan_poi, plan_code, net_premium) VALUES (?, ?, ?, ?, ?)";

    if ($stmtPlan = $dbconn->dbconn->prepare($sqlPlan)) {
        $stmtPlan->bind_param(
            "isids",
            $planInfo['planId'],
            $planInfo['planDescription'],
            $planInfo['planPoi'],
            $planInfo['planCode'],
            $planInfo['netPremium']
        );

        if ($stmtPlan->execute()) {
            // Get the last inserted plan_id for use in cover insertions
            $planId = $dbconn->dbconn->insert_id;
        } else {
            echo json_encode(array("result" => "error", "message" => "Plan data insertion failed: " . $stmtPlan->error));
            $stmtPlan->close();
            $dbconn->dbconn->close();
            return;
        }

        $stmtPlan->close();
    } else {
        echo json_encode(array("result" => "error", "message" => "Failed to prepare SQL statement for plan data: " . $dbconn->dbconn->error));
        $dbconn->dbconn->close();
        return;
    }

    // Insert cover information
    $sqlCover = "INSERT INTO cover_list (plan_id, cover_id, cover_code, cover_description, cover_name, auto_attached, optional_flag, cover_type, cover_premium, limit_display, final_excess, selected_flag) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmtCover = $dbconn->dbconn->prepare($sqlCover)) {
        foreach ($planInfo['coverList'] as $cover) {
            // Convert boolean to integer (0 or 1)
            $autoAttached = $cover['autoAttached'] ? 1 : 0;
            $optionalFlag = $cover['optionalFlag'] ? 1 : 0;
            $selectedFlag = $cover['selectedFlag'] ? 1 : 0;

            // Bind parameters for cover information
            $stmtCover->bind_param(
                "iissssiiisid",
                $planId,
                $cover['id'],
                $cover['code'],
                $cover['description'],
                $cover['name'],
                $autoAttached,
                $optionalFlag,
                $cover['type'],
                $cover['premium'],
                $cover['limitDisplay'],
                $cover['finalExcess'],
                $selectedFlag
            );

            // Execute the statement for each cover
            if (!$stmtCover->execute()) {
                echo json_encode(array("result" => "error", "message" => "Cover data insertion failed: " . $stmtCover->error));
                break; // Exit loop if error occurs
            }
        }

        echo json_encode(array("result" => "success", "message" => "All cover data inserted successfully"));

        // Close the statement
        $stmtCover->close();
    } else {
        echo json_encode(array("result" => "error", "message" => "Failed to prepare SQL statement for cover data: " . $dbconn->dbconn->error));
    }

    // Close the database connection
    $dbconn->dbconn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(array("result" => "error", "message" => "Invalid JSON"));
        exit();
    }
    if (isset($data['action'])) {
        if ($data['action'] === 'insertQuotation') {
            $formData = isset($data['formData']) ? $data['formData'] : array();
            $response = isset($data['response']) ? $data['response'] : array();
            $type = isset($data['type']) ? $data['type'] : "";
            DBInsertQuotationData($formData, $response, $type);
        } elseif ($data['action'] === 'getQuotationWithId') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : 0;
            DBGetPolicyDetailsWithId($policyid);
        } elseif ($data['action'] === 'getPaymentLogWithId') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : 0;
            DBGetPaymentLogWithId($policyid);
        }
        elseif ($data['action'] === 'insertPolicy') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            $policyNo = isset($data['policyNo']) ? $data['policyNo'] : "";

            DBInsertPolicyData($policyid, $policyNo);
        } elseif ($data['action'] === 'insertPremiumData') {
            $data = isset($data['data']) ? $data['data'] : "";
            DBInsertPlanInfoWithCovers($data);
        } elseif ($data['action'] === 'insertPaymentLog') {
            $request = isset($data['request']) ? $data['request'] : array();
            $response = isset($data['response']) ? $data['response'] : array();
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            DBInsertPaymentLog($request, $response,$policyid);
        } else {
            echo json_encode(array("result" => "error", "message" => "Invalid action"));
        }
    } else {
        echo json_encode(array("result" => "error", "message" => "No action specified"));
    }
} else {
    echo json_encode(array("result" => "error", "message" => "Invalid request method"));
}
function transformDate($dateString)
{
    $dateParts = explode('/', $dateString);

    if (count($dateParts) === 3) {
        // Reformat to YYYY-MM-DD
        $formattedDate = "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}";

        // Create a DateTime object with the formatted date
        $date = new DateTime($formattedDate);

        // Return the date in ISO 8601 format
        return $date->format(DateTime::ISO8601);
    } else {
        throw new Exception("Invalid date format: $dateString");
    }
}
function maskCreditCardNumbers($text) {
    // Define the pattern to match credit card numbers
    $creditCardPattern = '/\b(?:\d[ -]*?){13,19}\b/';
    
    // Function to mask the card number
    function maskCard($card) {
        // Remove non-digit characters
        $cleaned = preg_replace('/\D/', '', $card);
        // Mask all but the last 4 digits
        if (strlen($cleaned) > 4) {
            return str_repeat('*', strlen($cleaned) - 4) . substr($cleaned, -4);
        }
        return $cleaned; // Return as-is if it doesn't meet the length requirement
    }

    // Use preg_replace_callback to replace each match with a masked version
    return preg_replace_callback($creditCardPattern, function($matches) {
        return maskCard($matches[0]);
    }, $text);
}