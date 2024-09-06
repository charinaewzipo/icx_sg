<?php
session_start();
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
        FROM t_aig_app WHERE policyId = ?";

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
function DBGetDraftDataWithId($draftid)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Prepare the SQL query to select data by policyId
    $sql = "SELECT * FROM t_aig_app_draft WHERE policyId = ?";

    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind the policyId parameter
        $stmt->bind_param("i", $draftid);

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
function DBGetPolicyCreateOrNot($policyId)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Prepare the SQL query to select data by policyId
    $sql = "SELECT * FROM policy_data
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
    $productId = isset($formData['productId']) ? (int)$formData['productId'] : 0;
    $type = isset($type) ? $type : '';
    $remarksC = isset($formData['remarksC']) ? $formData['remarksC'] : '';
    $distributionChannel = isset($formData['distributionChannel']) ? (int)$formData['distributionChannel'] : 0;
    $producerCode = isset($formData['producerCode']) ? $formData['producerCode'] : null;
    $propDate = isset($formData['propDate']) ? $formData['propDate'] : null;
    $policyEffDate = isset($formData['policyEffDate']) ? $formData['policyEffDate'] : null;
    $policyExpDate = isset($formData['policyExpDate']) ? $formData['policyExpDate'] : null;
    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $quoteLapseDate = isset($response['quoteLapseDate'])
        ? transformDate($response['quoteLapseDate'])
        : null;
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
function DBInsertDraftQuoteData($formData, $type)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }


    $policyId = generateUUIDv4();
    $productId = isset($formData['productId']) ? (int)$formData['productId'] : 0;
    $type = isset($type) ? $type : '';
    $remarksC = isset($formData['remarksC']) ? $formData['remarksC'] : '';
    $distributionChannel = isset($formData['distributionChannel']) ? (int)$formData['distributionChannel'] : 0;
    $producerCode = isset($formData['producerCode']) ? $formData['producerCode'] : null;
    $propDate = isset($formData['propDate']) ? $formData['propDate'] : null;
    $policyEffDate = isset($formData['policyEffDate']) ? $formData['policyEffDate'] : null;
    $policyExpDate = isset($formData['policyExpDate']) ? $formData['policyExpDate'] : null;
    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $quoteNo = '';
    $premiumPayable = null;
    $quoteLapseDate = null;
    $ncdInfo = isset($formData['ncdInfo']) ? json_encode($formData['ncdInfo']) : '{}';
    $policyHolderInfo = isset($formData['policyHolderInfo']) ? json_encode($formData['policyHolderInfo']) : '{}';
    $insuredList = isset($formData['insuredList']) ? json_encode($formData['insuredList']) : '{}';


    $sql = "INSERT INTO t_aig_app_draft (
        policyId, type, productId, distributionChannel, producerCode, propDate, policyEffDate,
        policyExpDate, campaignCode, ncdInfo, policyHolderInfo, insuredList, quoteNo, premiumPayable, quoteLapseDate, remarksC
    ) VALUES (
        '$policyId', '$type', $productId, $distributionChannel, '$producerCode', '$propDate',
        " . ($policyEffDate === null ? 'NULL' : "'$policyEffDate'") . ",
        '$policyExpDate', '$campaignCode', '$ncdInfo', '$policyHolderInfo', '$insuredList',
        '$quoteNo', '$premiumPayable', '$quoteLapseDate', '$remarksC'
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
function DBUpdateDraftQuoteData($formData, $type,$draftid)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }
   
    if (empty($draftid)) {
        echo json_encode(array("result" => "error", "message" => "draftid is required for updating"));
        return;
    }

    $productId = isset($formData['productId']) ? (int)$formData['productId'] : 0;
    $type = isset($type) ? $type : '';
    $remarksC = isset($formData['remarksC']) ? $formData['remarksC'] : '';
    $distributionChannel = isset($formData['distributionChannel']) ? (int)$formData['distributionChannel'] : 0;
    $producerCode = isset($formData['producerCode']) ? $formData['producerCode'] : null;
    $propDate = isset($formData['propDate']) ? $formData['propDate'] : null;
    $policyEffDate = isset($formData['policyEffDate']) ? $formData['policyEffDate'] : null;
    $policyExpDate = isset($formData['policyExpDate']) ? $formData['policyExpDate'] : null;
    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $ncdInfo = isset($formData['ncdInfo']) ? json_encode($formData['ncdInfo']) : '{}';
    $policyHolderInfo = isset($formData['policyHolderInfo']) ? json_encode($formData['policyHolderInfo']) : '{}';
    $insuredList = isset($formData['insuredList']) ? json_encode($formData['insuredList']) : '{}';

    $ncdInfo = mysqli_real_escape_string($dbconn->dbconn, $ncdInfo);
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);

    // SQL query to update the record
    $sql = "UPDATE t_aig_app_draft
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
            remarksC = '$remarksC'
        WHERE policyId = '$draftid'";

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

function DBInsertPaymentLog($request, $response, $policyid,$objectPayment)
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
    $card_security_code = isset($request['sourceOfFunds']['provided']['card']['securityCode']) ? $request['sourceOfFunds']['provided']['card']['securityCode'] : '';
    $merchant = isset($response['merchant']) ? $response['merchant'] : '';
    $result = isset($response['result']) ? $response['result'] : '';
    $time_of_lastupdate = isset($response['timeOfLastUpdate']) ? $response['timeOfLastUpdate'] : '';
    $time_of_record = isset($response['timeOfRecord']) ? $response['timeOfRecord'] : '';

    // New fields
    $batch_no = isset($response['transaction']['acquirer']['batch']) ? 'IP' . $response['transaction']['acquirer']['batch'] : '';
    $order_no = isset($response['order']['id']) ? $response['order']['id'] : '';
    $payment_mode = isset($objectPayment['paymentMode']) ? (int)$objectPayment['paymentMode'] : 0;
    $card_type = isset($objectPayment['cardType']) ? $objectPayment['cardType'] : '';
    $payment_frequency = isset($objectPayment['paymentFrequency']) ? (int)$objectPayment['paymentFrequency'] : 0;
    $payment_date = isset($response['order']['creationTime']) ? $response['order']['creationTime'] : '';

    // Encode the response array as a JSON string
    $response_json = isset($response) ? json_encode($response) : '{}';
    $response_json = mysqli_real_escape_string($dbconn->dbconn, $response_json);

    // SQL query to insert data into the database
    $sql = "INSERT INTO t_aig_sg_payment_log 
                (batch_no, order_no, payment_mode, card_type, card_expiry_month, card_expiry_year, payment_date, payment_frequency, order_amount, card_number, order_currency, source_of_funds_type, merchant, result, time_of_lastupdate, time_of_record, response_json, policyId,card_security_code) 
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

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
            $policyid,
            $card_security_code
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
            $type = isset($data['type']) ? $data['type'] : "";
            DBInsertQuotationData($formData, $response, $type);
        } 
        elseif ($data['action'] === 'insertDraftQuoteData') {
            $formData = isset($data['formData']) ? $data['formData'] : array();
            $type = isset($data['type']) ? $data['type'] : "";
            DBInsertDraftQuoteData($formData, $type);
        } 
        elseif ($data['action'] === 'updateDraftQuoteData') {
            $formData = isset($data['formData']) ? $data['formData'] : array();
            $type = isset($data['type']) ? $data['type'] : "";
            $draftid = isset($data['draftid']) ? $data['draftid'] : "";
            DBUpdateDraftQuoteData($formData, $type,$draftid);
        } 
        elseif ($data['action'] === 'getQuotationWithId') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : 0;
            DBGetPolicyDetailsWithId($policyid);
        } 
        elseif ($data['action'] === 'getDraftDataWithId') {
            $draftid = isset($data['draftid']) ? $data['draftid'] : 0;
            DBGetDraftDataWithId($draftid);
        } 
        elseif ($data['action'] === 'getPaymentLogWithId') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : 0;
            DBGetPaymentLogWithId($policyid);
        }
         
        elseif ($data['action'] === 'getPolicyCreateOrNot') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : 0;
            DBGetPolicyCreateOrNot($policyid);
        }
        elseif ($data['action'] === 'insertPolicy') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            $policyNo = isset($data['policyNo']) ? $data['policyNo'] : "";

            DBInsertPolicyData($policyid, $policyNo);
        }  elseif ($data['action'] === 'insertPaymentLog') {
            $request = isset($data['request']) ? $data['request'] : array();
            $response = isset($data['response']) ? $data['response'] : array();
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            $objectPayment = isset($data['objectPayment']) ? $data['objectPayment'] : array();
            DBInsertPaymentLog($request, $response,$policyid,$objectPayment);
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
function generateUUIDv4() {
    // Generate 16 random bytes
    $data = random_bytes(16);

    // Set the version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    
    // Set the variant to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Convert the binary data into a hexadecimal format
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}



ob_end_flush();
exit();