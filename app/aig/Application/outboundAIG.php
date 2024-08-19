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
function DBGetPolicyDetailsWithId($policyId) {
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Prepare the SQL query to select data by policyId
    $sql = "SELECT id, policyId, productId, distributionChannel, producerCode, propDate, policyEffDate, policyExpDate, campaignCode, ncdInfo, policyHolderInfo, insuredList, quoteNo
            FROM tubtim.insurance_data
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


function DBInsertQuotationData($formData, $response)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    $policyId = isset($response['policyId']) ? $response['policyId'] : '';
    $productId = isset($formData['productId']) ? $formData['productId'] : 0;
    $distributionChannel = isset($formData['distributionChannel']) ? $formData['distributionChannel'] : 0;
    $producerCode = isset($formData['producerCode']) ? $formData['producerCode'] : '0002466000';
    $propDate = isset($formData['propDate']) ? $formData['propDate'] : '';
    $policyEffDate = isset($formData['policyEffDate']) ? $formData['policyEffDate'] : '2024-07-31T17:00:00.000Z';
    $policyExpDate = isset($formData['policyExpDate']) ? $formData['policyExpDate'] : '2024-08-07T17:00:00.000Z';
    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $quoteLapseDate = isset($response['quoteLapseDate']) ? $response['quoteLapseDate'] : '2024-08-07T17:00:00.000Z';

    $ncdInfo = isset($formData['ncdInfo']) ? json_encode($formData['ncdInfo']) : '{}';
    $policyHolderInfo = isset($formData['policyHolderInfo']) ? json_encode($formData['policyHolderInfo']) : '{}';
    $insuredList = isset($formData['insuredList']) ? json_encode($formData['insuredList']) : '{}';

    $ncdInfo = mysqli_real_escape_string($dbconn->dbconn, $ncdInfo);
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);

    $sql = "INSERT INTO insurance_data (
        policyId, productId, distributionChannel, producerCode, propDate, policyEffDate,
        policyExpDate, campaignCode, ncdInfo, policyHolderInfo, insuredList, quoteNo,premiumPayable,quoteLapseDate
    ) VALUES (
        '$policyId', $productId, $distributionChannel, '$producerCode', '$propDate',
        '$policyEffDate', '$policyExpDate', '$campaignCode', '$ncdInfo', '$policyHolderInfo',
        '$insuredList', '$quoteNo' ,'$premiumPayable' ,'$quoteLapseDate'
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

function DBInsertPolicyData($policyId, $response) {
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    $policyNo = isset($response['policyNo']) ? $response['policyNo'] : '';

    // Use prepared statements to avoid SQL injection
    $sql = "INSERT INTO policy_data (policyid, policyNo) VALUES (?, ?)";

    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("is", $policyId, $policyNo);

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
            DBInsertQuotationData($formData, $response);
        } elseif ($data['action'] === 'getQuotationWithId') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : 0;
            DBGetPolicyDetailsWithId($policyid);

        } elseif ($data['action'] === 'insertPolicy') {
            $data = isset($data['data']) ? $data['data'] : "";
            $response = isset($data['response']) ? $data['response'] : array();
            DBInsertPolicyData($data,$response);
        } 
        else {
            echo json_encode(array("result" => "error", "message" => "Invalid action"));
        }
    } else {
        echo json_encode(array("result" => "error", "message" => "No action specified"));
    }
} else {
    echo json_encode(array("result" => "error", "message" => "Invalid request method"));
}
