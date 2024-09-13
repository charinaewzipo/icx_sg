<?php
include "../../../dbconn.php";
include "../../../util.php";
include "../../../license.php";
include "../../../wlog.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
header('Content-Type: application/json; charset=UTF-8');
// Function to fetch data for agents
function DBGetQuoteDetailsWithId($id)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Prepare the SQL query to select data by policyId
    $sql = "SELECT *
        FROM t_aig_app WHERE id = ?";

    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind the policyId parameter
        $stmt->bind_param("i", $id);

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
            WHERE policyId = ? and result='SUCCESS'";

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
function DBInsertQuotationData($formData, $response, $type, $campaignDetails)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Extract data from formData and response
    $policyId = isset($response['policyId']) ? $response['policyId'] : '';
    $productId = isset($formData['productId']) ? (int)$formData['productId'] : 0;
    $type = isset($type) ? $type : '';
    $remarksC = isset($formData['remarksC']) ? $formData['remarksC'] : '';
    $distributionChannel = isset($formData['distributionChannel']) ? (int)$formData['distributionChannel'] : 0;
    $producerCode = isset($formData['producerCode']) ? $formData['producerCode'] : null;

    $propDate = isset($formData['propDate']) ? isoToDateTime($formData['propDate']) : null;
    $policyEffDate = isset($formData['policyEffDate']) ? isoToDateTime($formData['policyEffDate']) : null;
    $policyExpDate = isset($formData['policyExpDate']) ? isoToDateTime($formData['policyExpDate']) : isoToDateTime("2039-12-13T00:00:00Z");    
    

    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $quoteLapseDate = isset($response['quoteLapseDate']) ? transformDate($response['quoteLapseDate']) : null;

    // Handle JSON fields
    $ncdInfo = isset($formData['ncdInfo']) ? json_encode($formData['ncdInfo']) : '{}';
    $policyHolderInfo = isset($formData['policyHolderInfo']) ? json_encode($formData['policyHolderInfo']) : '{}';
    $insuredList = isset($formData['insuredList']) ? json_encode($formData['insuredList']) : '{}';

    // Escape the strings for safe query execution
    $ncdInfo = mysqli_real_escape_string($dbconn->dbconn, $ncdInfo);
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);

    // Extract details from campaignDetails
    $agent_id = isset($campaignDetails["agent_id"]) ? (int)$campaignDetails["agent_id"] : null;
    $campaign_id = isset($campaignDetails["campaign_id"]) ? (int)$campaignDetails["campaign_id"] : null;
    $import_id = isset($campaignDetails["import_id"]) ? (int)$campaignDetails["import_id"] : null;
    $calllist_id = isset($campaignDetails["calllist_id"]) ? (int)$campaignDetails["calllist_id"] : null;

    // SQL query with `update_date` set to `NOW()`
    $sql = "INSERT INTO t_aig_app (
        policyId, type, productId, distributionChannel, producerCode, propDate, policyEffDate,
        policyExpDate, campaignCode, ncdInfo, policyHolderInfo, insuredList, quoteNo, premiumPayable,
        quoteLapseDate, remarksC, agent_id, campaign_id, import_id, calllist_id, update_date, incident_status
    ) VALUES (
        '$policyId', '$type', $productId, $distributionChannel, '$producerCode', '$propDate',
        '$policyEffDate', '$policyExpDate', '$campaignCode', '$ncdInfo', '$policyHolderInfo',
        '$insuredList', '$quoteNo', $premiumPayable, '$quoteLapseDate', '$remarksC', $agent_id, 
        $campaign_id, $import_id, $calllist_id, NOW(),'Open'
    )";

    // Execute query
    $result = $dbconn->executeUpdate($sql);

    if (!$result) {
        $error = mysqli_error($dbconn->dbconn);
        echo json_encode(array("result" => "error", "message" => "Data insertion failed: $error"));
    } else {
        // Get the last inserted ID
        $lastInsertedId = mysqli_insert_id($dbconn->dbconn);
        echo json_encode(array("result" => "success", "message" => "Data inserted successfully", "id" => $lastInsertedId));
    }
}




function DBUpdateQuoteData($formData, $response, $type, $id)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    if (empty($id)) {
        echo json_encode(array("result" => "error", "message" => "id is required for updating"));
        return;
    }

    // Form data
    $productId = isset($formData['productId']) ? (int)$formData['productId'] : 0;
    $type = isset($type) ? $type : '';
    $remarksC = isset($formData['remarksC']) ? $formData['remarksC'] : '';
    $distributionChannel = isset($formData['distributionChannel']) ? (int)$formData['distributionChannel'] : 0;
    $producerCode = isset($formData['producerCode']) ? $formData['producerCode'] : null;

    //ISO to YYYY-MM-DD HH:MM:SS
    $propDate = isset($formData['propDate']) ? isoToDateTime($formData['propDate']) : null;
    $policyEffDate = isset($formData['policyEffDate']) ? isoToDateTime($formData['policyEffDate']) : null;
    $policyExpDate = isset($formData['policyExpDate']) ? isoToDateTime($formData['policyExpDate']) : isoToDateTime("2039-12-13T00:00:00Z");    
    
    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $ncdInfo = isset($formData['ncdInfo']) ? json_encode($formData['ncdInfo']) : '{}';
    $policyHolderInfo = isset($formData['policyHolderInfo']) ? json_encode($formData['policyHolderInfo']) : '{}';
    $insuredList = isset($formData['insuredList']) ? json_encode($formData['insuredList']) : '{}';

    // Response data
    $policyId = isset($response['policyId']) ? $response['policyId'] : '';
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $quoteLapseDate = isset($response['quoteLapseDate']) ? transformDate($response['quoteLapseDate']) : null;

    // Escape the strings for safe query execution
    $ncdInfo = mysqli_real_escape_string($dbconn->dbconn, $ncdInfo);
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);

    // Initialize the SQL query
    $sql = "UPDATE t_aig_app
    SET 
        type = '$type',
        productId = $productId,
        distributionChannel = $distributionChannel,
        producerCode = '$producerCode',
        propDate = '$propDate',
        policyEffDate = " . ($policyEffDate === null ? 'NULL' : "'$policyEffDate'") . ",
        policyExpDate = '$policyExpDate',
        campaignCode = '$campaignCode',
        ncdInfo = '$ncdInfo',
        policyHolderInfo = '$policyHolderInfo',
        insuredList = '$insuredList',
        remarksC = '$remarksC',
        policyId = '$policyId',
        quoteNo = '$quoteNo',
        premiumPayable = '$premiumPayable',
        quoteLapseDate = " . ($quoteLapseDate === null ? 'NULL' : "'$quoteLapseDate'") . ",
        update_date = NOW()"; // Add this line to update the update_date field

    // Add quote_create_date if response is not null
    if (!empty($response)) {
        $sql .= ", quote_create_date = NOW()";
    }

    // Complete the WHERE clause
    $sql .= " WHERE id = '$id'";

    // Execute query
    $result = $dbconn->executeUpdate($sql);

    header('Content-Type: application/json; charset=UTF-8');
    if (!$result) {
        $error = mysqli_error($dbconn->dbconn);
        echo json_encode(array("result" => "error", "message" => "Data update failed: $error"));
    } else {
        echo json_encode(array("result" => "success", "message" => "Data updated successfully"));
    }
}

function DBUpdatePolicyNo($policyid, $policyNo)
{
    // Initialize database connection
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    $sql = "UPDATE t_aig_app 
            SET policyNo = ?, policy_create_date = NOW(), update_date = NOW() 
            WHERE policyId = ?";

    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        $stmt->bind_param("si", $policyNo, $policyid);

        if ($stmt->execute()) {
            echo json_encode(array("result" => "success", "message" => "Policy number and creation date updated successfully"));
        } else {
            echo json_encode(array("result" => "error", "message" => "Update failed: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("result" => "error", "message" => "Failed to prepare SQL statement: " . $dbconn->dbconn->error));
    }

    $dbconn->dbconn->close();
}



function DBInsertPaymentLog($request, $response, $policyid, $objectPayment)
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
    $source_of_funds_type = isset($request['sourceOfFunds']['type']) ? $request['sourceOfFunds']['type'] : '';
    $card_number = isset($response['sourceOfFunds']['provided']['card']['number']) ? ($response['sourceOfFunds']['provided']['card']['number']) : '';
    $card_expiry_month = isset($request['sourceOfFunds']['provided']['card']['expiry']['month']) ? $request['sourceOfFunds']['provided']['card']['expiry']['month'] : '';
    $card_expiry_year = isset($request['sourceOfFunds']['provided']['card']['expiry']['year']) ? $request['sourceOfFunds']['provided']['card']['expiry']['year'] : '';
    $merchant = isset($response['merchant']) ? $response['merchant'] : '';
    $result = isset($response['result']) ? $response['result'] : '';
    $time_of_lastupdate = isset($response['timeOfLastUpdate']) ? $response['timeOfLastUpdate'] : '';
    $time_of_record = isset($response['timeOfRecord']) ? $response['timeOfRecord'] : '';

    // New fields
    $batch_no = isset($response['transaction']['acquirer']['batch']) ? 'IP' . formatBatchNo($response['transaction']['acquirer']['batch']) : '';
    $order_no = isset($response['order']['id']) ? $response['order']['id'] : '';
    $payment_mode = isset($objectPayment['paymentMode']) ? (int)$objectPayment['paymentMode'] : 0;
    $card_type = isset($objectPayment['cardType']) ? $objectPayment['cardType'] : '';
    $payment_frequency = isset($objectPayment['paymentFrequency']) ? (int)$objectPayment['paymentFrequency'] : 0;
    $payment_date = isset($response['order']['creationTime']) ? $response['order']['creationTime'] : '';

    // Encode the response and request arrays as JSON strings

    if (isset($request['sourceOfFunds']['provided']['card']['number'])) {
        // You can either remove the card number or mask it
        $request['sourceOfFunds']['provided']['card']['number'] = maskCardNumber($request['sourceOfFunds']['provided']['card']['number']);
    }

    $response_json = isset($response) ? json_encode($response) : '{}';
    $response_json = mysqli_real_escape_string($dbconn->dbconn, $response_json);

    $request_json = isset($request) ? json_encode($request) : '{}';
    $request_json = mysqli_real_escape_string($dbconn->dbconn, $request_json);

    // SQL query to insert data into the database
    $sql = "INSERT INTO t_aig_sg_payment_log 
                (batch_no, order_no, payment_mode, card_type, card_expiry_month, card_expiry_year, payment_date, payment_frequency, order_amount, card_number, order_currency, source_of_funds_type, merchant, result, time_of_lastupdate, time_of_record, response_json, request_json, policyId) 
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Use prepared statements to avoid SQL injection
    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param(
            "sssssssssssssssssss",
            $batch_no,
            $order_no,
            $payment_mode,
            $card_type,
            $card_expiry_month,
            $card_expiry_year,
            $payment_date,
            $payment_frequency,
            $order_amount,
            $card_number,
            $order_currency,
            $source_of_funds_type,
            $merchant,
            $result,
            $time_of_lastupdate,
            $time_of_record,
            $response_json,
            $request_json,
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
            $campaignDetails = isset($data['campaignDetails']) ? $data['campaignDetails'] : array();
            $type = isset($data['type']) ? $data['type'] : "";
            DBInsertQuotationData($formData, $response, $type, $campaignDetails);
        } elseif ($data['action'] === 'updateQuoteData') {
            $formData = isset($data['formData']) ? $data['formData'] : array();
            $response = isset($data['response']) ? $data['response'] : array();
            $type = isset($data['type']) ? $data['type'] : "";
            $id = isset($data['id']) ? $data['id'] : "";
            DBUpdateQuoteData($formData, $response, $type, $id);
        } elseif ($data['action'] === 'getQuotationWithId') {
            $id = isset($data['id']) ? $data['id'] : 0;
            DBGetQuoteDetailsWithId($id);
        } elseif ($data['action'] === 'getPaymentLogWithId') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : 0;
            DBGetPaymentLogWithId($policyid);
        } elseif ($data['action'] === 'updatePolicyNo') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            $policyNo = isset($data['policyNo']) ? $data['policyNo'] : "";

            DBUpdatePolicyNo($policyid, $policyNo);
        } elseif ($data['action'] === 'insertPaymentLog') {
            $request = isset($data['request']) ? $data['request'] : array();
            $response = isset($data['response']) ? $data['response'] : array();
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            $objectPayment = isset($data['objectPayment']) ? $data['objectPayment'] : array();
            DBInsertPaymentLog($request, $response, $policyid, $objectPayment);
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
function maskCardNumber($card_number)
{
    if (strlen($card_number) > 6) {
        return substr($card_number, 0, 6) . str_repeat('x', strlen($card_number) - 10) . substr($card_number, -4);
    } else {
        return $card_number;
    }
}
function generateUUIDv4()
{
    // Generate 16 random bytes
    $data = random_bytes(16);

    // Set the version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);

    // Set the variant to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Convert the binary data into a hexadecimal format
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
function formatBatchNo($dateStr) {
        $year = substr($dateStr, 0, 4);
        $month = substr($dateStr, 4, 2);
        $day = substr($dateStr, 6, 2);
        return $day . $month . $year;
}
function isoToDateTime($isoDateStr) {
    try {
        $date = new DateTime($isoDateStr);
        return $date->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        // Handle the exception or return a default value
        return null; // or a default date/time like '1970-01-01 00:00:00'
    }
}

ob_end_flush();
exit();
