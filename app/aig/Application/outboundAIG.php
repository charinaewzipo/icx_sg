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

// wlog("DBGetQuoteDetailsWithId ".$sql);
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

function DBGetPaymentLogWithId($quoteNo)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Prepare the SQL query to select data by policyId
    $sql = "SELECT * FROM t_aig_sg_payment_log
            WHERE quote_no = ? and result='SUCCESS'";
// wlog("DBGetPaymentLogWithId ".$sql);
    if ($stmt = $dbconn->dbconn->prepare($sql)) {
        // Bind the policyId parameter
        $stmt->bind_param("i", $quoteNo);

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
function DBInsertQuotationData($formData, $response, $type, $campaignDetails,$planData)
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

    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $efulfillmentFlag = isset($formData['efulfillmentFlag']) ? $formData['efulfillmentFlag'] : '';
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $quoteLapseDate = isset($response['quoteLapseDate']) ? transformDateQuote($response['quoteLapseDate']) : null;
    $policyExpDate = isset($response['policyExpDate']) ? transformDateQuote($response['policyExpDate']) : null;
    
    // Handle JSON fields
    $ncdInfo = isset($formData['ncdInfo']) ? json_encode($formData['ncdInfo']) : '{}';
    $policyHolderInfo = isset($formData['policyHolderInfo']) ? json_encode($formData['policyHolderInfo']) : '{}';
    $insuredList = isset($formData['insuredList']) ? json_encode($formData['insuredList']) : '{}';
    $request_quote_json = json_encode($formData); // Convert to JSON string
    $response_quote_json = json_encode($response); // Convert to JSON string
    $plan_premium_json = json_encode($planData);
    // Escape the strings for safe query execution
    $ncdInfo = mysqli_real_escape_string($dbconn->dbconn, $ncdInfo);
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);
    $request_quote_json = mysqli_real_escape_string($dbconn->dbconn, $request_quote_json);
    $response_quote_json = mysqli_real_escape_string($dbconn->dbconn, $response_quote_json);
    $plan_premium_json = mysqli_real_escape_string($dbconn->dbconn, $plan_premium_json);
    // Extract details from campaignDetails
    $agent_id = isset($campaignDetails["agent_id"]) ? (int)$campaignDetails["agent_id"] : null;
    $campaign_id = isset($campaignDetails["campaign_id"]) ? (int)$campaignDetails["campaign_id"] : null;
    $import_id = isset($campaignDetails["import_id"]) ? (int)$campaignDetails["import_id"] : null;
    $calllist_id = isset($campaignDetails["calllist_id"]) ? (int)$campaignDetails["calllist_id"] : null;

    $policy_holder_info = isset($formData['policyHolderInfo']) ? $formData['policyHolderInfo'] : [];
    $individual_info = isset($policy_holder_info['individualPolicyHolderInfo']) ? $policy_holder_info['individualPolicyHolderInfo'] : [];

    $paymentDetails = isset($formData['paymentDetails']) ? $formData['paymentDetails'] : [];

    if (!empty($paymentDetails) && is_array($paymentDetails)) {
        $payment_mode = isset($paymentDetails[0]['paymentMode']) ? $paymentDetails[0]['paymentMode'] : null;
        $payment_frequency = isset($paymentDetails[0]['paymentFrequency']) ? $paymentDetails[0]['paymentFrequency'] : null;
    } else {
        $payment_mode = null;
        $payment_frequency = null;
    }
    
    $full_name = isset($individual_info['fullName']) ? $individual_info['fullName'] : '';
    $date_of_birth = isset($individual_info['dateOfBirth']) ? $individual_info['dateOfBirth'] : '';
    $customer_id = isset($individual_info['customerIdNo']) ? $individual_info['customerIdNo'] : '';
    
    // Start building the SQL query
    $sql = "INSERT INTO t_aig_app (
        policyId, type, productId, distributionChannel, producerCode, propDate, policyEffDate,
        campaignCode, ncdInfo, policyHolderInfo, insuredList, quoteNo, premiumPayable,
        quoteLapseDate, remarksC, agent_id, campaign_id, import_id, calllist_id, update_date,  
        payment_frequency, payment_mode, fullname, dob, efulfillmentFlag, customer_id,request_quote_json,response_quote_json,plan_premium_json";

    // Add quote_create_date field if response is not empty
    if (!empty($response)) {
        $sql .= ", quote_create_date";
    }

    // Conditionally add policyExpDate if it exists in the response
    if ($policyExpDate !== null) {
        $sql .= ", policyExpDate";
    }

    $sql .= ") VALUES (
        '$policyId', '$type', $productId, $distributionChannel, '$producerCode', '$propDate',
        '$policyEffDate', '$campaignCode', '$ncdInfo', '$policyHolderInfo',
        '$insuredList', '$quoteNo', $premiumPayable, '$quoteLapseDate', '$remarksC', $agent_id,
        $campaign_id, $import_id, $calllist_id,NOW(), '$payment_frequency', '$payment_mode', 
        '$full_name', '$date_of_birth', '$efulfillmentFlag', '$customer_id','$request_quote_json','$response_quote_json','$plan_premium_json'";

    // Add NOW() for quote_create_date if response is not empty
    if (!empty($response)) {
        $sql .= ", NOW()";
    }

    // Add policyExpDate value if it exists
    if ($policyExpDate !== null) {
        $sql .= ", '$policyExpDate'";
    }

    $sql .= ")";

    // Execute query
    $result = $dbconn->executeUpdate($sql);
    wlog("DBInsertQuotationData ".$sql);
    if (!$result) {
        $error = mysqli_error($dbconn->dbconn);
        echo json_encode(array("result" => "error", "message" => "Data insertion failed: $error"));
    } else {
        // Get the last inserted ID
        $lastInsertedId = mysqli_insert_id($dbconn->dbconn);
        echo json_encode(array("result" => "success", "message" => "Data inserted successfully", "id" => $lastInsertedId));
    }
}






function DBUpdateQuoteData($formData, $response, $type, $id,$planData)
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

    $campaignCode = isset($formData['campaignCode']) ? $formData['campaignCode'] : '';
    $ncdInfo = isset($formData['ncdInfo']) ? json_encode($formData['ncdInfo']) : '{}';
    $policyHolderInfo = isset($formData['policyHolderInfo']) ? json_encode($formData['policyHolderInfo']) : '{}';
    $insuredList = isset($formData['insuredList']) ? json_encode($formData['insuredList']) : '{}';

    // Response data
    $policyId = isset($response['policyId']) ? $response['policyId'] : '';
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';
    $efulfillmentFlag = isset($formData['efulfillmentFlag']) ? $formData['efulfillmentFlag'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $quoteLapseDate = isset($response['quoteLapseDate']) ? transformDateQuote($response['quoteLapseDate']) : null;
    $policyExpDate = isset($response['policyExpDate']) ? transformDateQuote($response['policyExpDate']) : null;
    $request_quote_json = json_encode($formData); // Convert to JSON string
    $response_quote_json = json_encode($response); // Convert to JSON string
    $plan_premium_json = json_encode($planData); // Convert to JSON string
    // Escape the strings for safe query execution
    $ncdInfo = mysqli_real_escape_string($dbconn->dbconn, $ncdInfo);
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);
    $request_quote_json = mysqli_real_escape_string($dbconn->dbconn, $request_quote_json);
    $response_quote_json = mysqli_real_escape_string($dbconn->dbconn, $response_quote_json);
    $plan_premium_json = mysqli_real_escape_string($dbconn->dbconn, $plan_premium_json);
    $policy_holder_info = isset($formData['policyHolderInfo']) ? $formData['policyHolderInfo'] : [];
    $individual_info = isset($policy_holder_info['individualPolicyHolderInfo']) ? $policy_holder_info['individualPolicyHolderInfo'] : [];

    $paymentDetails = isset($formData['paymentDetails']) ? $formData['paymentDetails'] : [];

    if (!empty($paymentDetails) && is_array($paymentDetails)) {
        $payment_mode = isset($paymentDetails[0]['paymentMode']) ? $paymentDetails[0]['paymentMode'] : null;
        $payment_frequency = isset($paymentDetails[0]['paymentFrequency']) ? $paymentDetails[0]['paymentFrequency'] : null;
    } else {
        $payment_mode = null;
        $payment_frequency = null;
    }
    $full_name = isset($individual_info['fullName']) ? $individual_info['fullName'] : '';
    $date_of_birth = isset($individual_info['dateOfBirth']) ? $individual_info['dateOfBirth'] : '';
    $customer_id = isset($individual_info['customerIdNo']) ? $individual_info['customerIdNo'] : '';
    // Initialize the SQL query
    $sql = "UPDATE t_aig_app
    SET 
        type = '$type',
        productId = $productId,
        distributionChannel = $distributionChannel,
        producerCode = '$producerCode',
        propDate = '$propDate',
        policyEffDate = " . ($policyEffDate === null ? 'NULL' : "'$policyEffDate'") . ",
        campaignCode = '$campaignCode',
        ncdInfo = '$ncdInfo',
        policyHolderInfo = '$policyHolderInfo',
        insuredList = '$insuredList',
        remarksC = '$remarksC',
        policyId = '$policyId',
        quoteNo = '$quoteNo',
        premiumPayable = '$premiumPayable',
        quoteLapseDate = " . ($quoteLapseDate === null ? 'NULL' : "'$quoteLapseDate'") . ",
        payment_frequency = '$payment_frequency', 
        payment_mode = '$payment_mode',            
        fullname = '$full_name',                  
        dob = '$date_of_birth',
        efulfillmentFlag = '$efulfillmentFlag',
        request_quote_json= '$request_quote_json',
        response_quote_json= '$response_quote_json',
        plan_premium_json= '$plan_premium_json',
        customer_id='$customer_id',          
        update_date = NOW()";

    // Add quote_create_date if response is not null
    if (!empty($response)) {
        $sql .= ", quote_create_date = NOW() ,policyExpDate='$policyExpDate'";
    }

    // Complete the WHERE clause
    $sql .= " WHERE id = '$id'";

    // Execute query
    $result = $dbconn->executeUpdate($sql);
    wlog("DBUpdateQuoteData ".$sql);
    header('Content-Type: application/json; charset=UTF-8');
    if (!$result) {
        $error = mysqli_error($dbconn->dbconn);
        echo json_encode(array("result" => "error", "message" => "Data update failed: $error"));
    } else {
        echo json_encode(array("result" => "success", "message" => "Data updated successfully"));
    }
}

function DBUpdatePolicyNo($policyid, $policyNo,$formData,$response)
{
    // Initialize database connection
    $dbconn = new dbconn();
    $res = $dbconn->createConn();
    $request_policy_json = json_encode($formData); // Convert to JSON string
    $response_policy_json = json_encode($response); // Convert to JSON string
    // Escape the strings for safe query execution

    $request_policy_json = mysqli_real_escape_string($dbconn->dbconn, $request_policy_json);
    $response_policy_json = mysqli_real_escape_string($dbconn->dbconn, $response_policy_json);
    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    $sql = "UPDATE t_aig_app 
            SET policyNo = ?, policy_create_date = NOW(), update_date = NOW() ,request_policy_json='$request_policy_json',response_policy_json='$response_policy_json'
            WHERE policyId = ?";
wlog("DBUpdatePolicyNo ".$sql);
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

function DBUpdateQuoteRetrieve($response, $id,$formatData,$planData)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    if (empty($id)) {
        echo json_encode(array("result" => "error", "message" => "ID is required for updating"));
        return;
    }

    // Extract data from response
    $policyId = isset($response['policyId']) ? $response['policyId'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $productId = isset($response['productId']) ? $response['productId'] : 0;
    $producerCode = isset($response['producerCode']) ? $response['producerCode'] : '';
    $propDate = isset($response['propDate']) ? convertToISO8601($response['propDate']) : null;
    $policyEffDate = isset($response['policyEffDate']) ? convertToISO8601($response['policyEffDate']) : null;
    $policyExpDate = isset($response['policyExpDate']) ? convertToISO8601($response['policyExpDate']) : null;
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';
   
    // Handle policy holder information
    $policyHolderInfo = isset($formatData['policyHolderInfo']) ? json_encode($formatData['policyHolderInfo']) : '{}';
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);

    $individualPolicyHolderInfo = isset($formatData['policyHolderInfo']['individualPolicyHolderInfo']) ? $formatData['policyHolderInfo']['individualPolicyHolderInfo'] : [];
    $fullName = isset($individualPolicyHolderInfo['fullName']) ? $individualPolicyHolderInfo['fullName'] : '';
    $customerIdNo = isset($individualPolicyHolderInfo['customerIdNo']) ? $individualPolicyHolderInfo['customerIdNo'] : '';
    $dateOfBirth = isset($individualPolicyHolderInfo['dateOfBirth']) ? convertToISO8601($individualPolicyHolderInfo['dateOfBirth']) : null;
    // Handle insured list information
    $insuredList = isset($formatData['insuredList']) ? json_encode($formatData['insuredList']) : '{}';
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);
    // Handle payment details
    $paymentDetails = isset($formatData['paymentDetails']) ? $formatData['paymentDetails'] : [];

    // No need for [0] since paymentDetails is not an array of arrays
    $paymentMode = !empty($paymentDetails) && isset($paymentDetails['paymentMode']) ? $paymentDetails['paymentMode'] : null;
    $paymentFrequency = !empty($paymentDetails) && isset($paymentDetails['paymentFrequency']) ? $paymentDetails['paymentFrequency'] : null;
    $request_retrieve_json = json_encode($formatData); // Convert to JSON string
    $response_retrieve_json = json_encode($response); // Convert to JSON string
    $plan_premium_json = json_encode($planData); // Convert to JSON string
    // Escape the strings for safe query execution
   
    $request_retrieve_json = mysqli_real_escape_string($dbconn->dbconn, $request_retrieve_json);
    $response_retrieve_json = mysqli_real_escape_string($dbconn->dbconn, $response_retrieve_json);
    $plan_premium_json = mysqli_real_escape_string($dbconn->dbconn, $plan_premium_json);
    
      // Prepare SQL statement
    $sql = "UPDATE t_aig_app
            SET 
                policyId = '$policyId',
                productId = '$productId',
                producerCode = '$producerCode',
                propDate = " . ($propDate === null ? 'NULL' : "'$propDate'") . ",
                policyEffDate = " . ($policyEffDate === null ? 'NULL' : "'$policyEffDate'") . ",
                policyExpDate = " . ($policyExpDate === null ? 'NULL' : "'$policyExpDate'") . ",
                policyHolderInfo = '$policyHolderInfo',
                insuredList = '$insuredList',
                premiumPayable = '$premiumPayable',
                quoteNo = '$quoteNo',
                fullname = '$fullName',
                customer_id = '$customerIdNo',
                payment_mode = '$paymentMode',
                payment_frequency= '$paymentFrequency',
                dob = " . ($dateOfBirth === null ? 'NULL' : "'$dateOfBirth'") . ",
                request_retrieve_json='$request_retrieve_json',
                response_retrieve_json='$response_retrieve_json',
                plan_premium_json='$plan_premium_json',

                update_date = NOW()
            WHERE id = '$id'";

    // Execute the query
    $result = $dbconn->executeUpdate($sql);
    wlog("DBUpdateQuoteRetrieve ".$sql);
    header('Content-Type: application/json; charset=UTF-8');
    if (!$result) {
        $error = mysqli_error($dbconn->dbconn);
        echo json_encode(array("result" => "error", "message" => "Data update failed: $error"));
    } else {
        echo json_encode(array("result" => "success", "message" => "Data updated successfully"));
    }
}

function DBInsertRetrieveQuote($response, $formatData, $type, $campaignDetails)
{
    $dbconn = new dbconn();
    $res = $dbconn->createConn();

    if ($res == "404") {
        echo json_encode(array("result" => "error", "message" => "Can't connect to database"));
        exit();
    }

    // Extract data from response
    $policyId = isset($response['policyId']) ? $response['policyId'] : '';
    $premiumPayable = isset($response['premiumPayable']) ? $response['premiumPayable'] : 0.00;
    $productId = isset($response['productId']) ? $response['productId'] : 0;
    $producerCode = isset($response['producerCode']) ? $response['producerCode'] : '';
    $propDate = isset($response['propDate']) ? convertToISO8601($response['propDate']) : null;
    $policyEffDate = isset($response['policyEffDate']) ? convertToISO8601($response['policyEffDate']) : null;
    $policyExpDate = isset($response['policyExpDate']) ? convertToISO8601($response['policyExpDate']) : null;
    $quoteNo = isset($response['quoteNo']) ? $response['quoteNo'] : '';

    // Add new data fields
    $type = isset($type) ? $type : '';
    $distributionChannel = isset($formatData['distributionChannel']) ? (int)$formatData['distributionChannel'] : 10;
    $campaignCode = isset($formatData['campaignCode']) ? $formatData['campaignCode'] : '';

    // Handle campaign details
    $agent_id = isset($campaignDetails["agent_id"]) ? (int)$campaignDetails["agent_id"] : null;
    $campaign_id = isset($campaignDetails["campaign_id"]) ? (int)$campaignDetails["campaign_id"] : null;
    $import_id = isset($campaignDetails["import_id"]) ? (int)$campaignDetails["import_id"] : null;
    $calllist_id = isset($campaignDetails["calllist_id"]) ? (int)$campaignDetails["calllist_id"] : null;

    // Handle policy holder information
    $policyHolderInfo = isset($formatData['policyHolderInfo']) ? json_encode($formatData['policyHolderInfo']) : '{}';
    $policyHolderInfo = mysqli_real_escape_string($dbconn->dbconn, $policyHolderInfo);

    $individualPolicyHolderInfo = isset($formatData['policyHolderInfo']['individualPolicyHolderInfo']) ? $formatData['policyHolderInfo']['individualPolicyHolderInfo'] : [];
    $fullName = isset($individualPolicyHolderInfo['fullName']) ? $individualPolicyHolderInfo['fullName'] : '';
    $customerIdNo = isset($individualPolicyHolderInfo['customerIdNo']) ? $individualPolicyHolderInfo['customerIdNo'] : '';
    $dateOfBirth = isset($individualPolicyHolderInfo['dateOfBirth']) ? convertToISO8601($individualPolicyHolderInfo['dateOfBirth']) : null;

    // Handle insured list information
    $insuredList = isset($formatData['insuredList']) ? json_encode($formatData['insuredList']) : '{}';
    $insuredList = mysqli_real_escape_string($dbconn->dbconn, $insuredList);

    // Handle payment details
    $paymentDetails = isset($formatData['paymentDetails']) ? $formatData['paymentDetails'] : [];
    $paymentMode = !empty($paymentDetails) && isset($paymentDetails['paymentMode']) ? $paymentDetails['paymentMode'] : null;
    $paymentFrequency = !empty($paymentDetails) && isset($paymentDetails['paymentFrequency']) ? $paymentDetails['paymentFrequency'] : null;

    $request_retrieve_json = json_encode($formatData);
    $response_retrieve_json = json_encode($response);

    // Escape the strings for safe query execution
    $request_retrieve_json = mysqli_real_escape_string($dbconn->dbconn, $request_retrieve_json);
    $response_retrieve_json = mysqli_real_escape_string($dbconn->dbconn, $response_retrieve_json);

    // Prepare SQL insert statement with new data fields
    $sql = "INSERT INTO t_aig_app 
        (policyId, productId, producerCode, propDate, policyEffDate, policyExpDate, policyHolderInfo, insuredList, 
        premiumPayable, quoteNo, fullname, customer_id, payment_mode, payment_frequency, dob, request_retrieve_json, 
        response_retrieve_json, update_date, type, distributionChannel, campaignCode, agent_id, campaign_id, import_id, calllist_id) 
        VALUES ('$policyId', '$productId', '$producerCode', " . 
        ($propDate === null ? 'NULL' : "'$propDate'") . ", " . 
        ($policyEffDate === null ? 'NULL' : "'$policyEffDate'") . ", " . 
        ($policyExpDate === null ? 'NULL' : "'$policyExpDate'") . ", 
        '$policyHolderInfo', '$insuredList', '$premiumPayable', '$quoteNo', '$fullName', 
        '$customerIdNo', '$paymentMode', '$paymentFrequency', " . 
        ($dateOfBirth === null ? 'NULL' : "'$dateOfBirth'") . ", 
        '$request_retrieve_json', '$response_retrieve_json', NOW(), 
        '$type', '$distributionChannel', '$campaignCode', '$agent_id', '$campaign_id', '$import_id', '$calllist_id')";

    // Execute the query
    $result = $dbconn->executeUpdate($sql);
    wlog("DBInsertRetrieveQuote ".$sql);
    header('Content-Type: application/json; charset=UTF-8');
    if (!$result) {
        $error = mysqli_error($dbconn->dbconn);
        echo json_encode(array("result" => "error", "message" => "Data insert failed: $error"));
    } else {
        $lastInsertedId = mysqli_insert_id($dbconn->dbconn);
        echo json_encode(array("result" => "success", "message" => "Data inserted successfully", "id" => $lastInsertedId));
    }
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
  wlog("DBInsertPaymentLog ".$sql);
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

function DBInsertPaymentGatewayLog($response, $policyid)
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
            $planData = isset($data['planData']) ? $data['planData'] : array();
            DBInsertQuotationData($formData, $response, $type, $campaignDetails,$planData);
        } elseif ($data['action'] === 'updateQuoteData') {
            $formData = isset($data['formData']) ? $data['formData'] : array();
            $response = isset($data['response']) ? $data['response'] : array();
            $type = isset($data['type']) ? $data['type'] : "";
            $id = isset($data['id']) ? $data['id'] : "";
            $planData = isset($data['planData']) ? $data['planData'] : array();
            DBUpdateQuoteData($formData, $response, $type, $id,$planData);
        } elseif ($data['action'] === 'getQuotationWithId') {
            $id = isset($data['id']) ? $data['id'] : 0;
            DBGetQuoteDetailsWithId($id);
        } elseif ($data['action'] === 'getPaymentLogWithId') {
            $quoteNo = isset($data['quoteNo']) ? $data['quoteNo'] : 0;
            DBGetPaymentLogWithId($quoteNo);
        } elseif ($data['action'] === 'updatePolicyNo') {
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            $policyNo = isset($data['policyNo']) ? $data['policyNo'] : "";
            $response = isset($data['response']) ? $data['response'] : array();
            $formData = isset($data['formData']) ? $data['formData'] : array();
            DBUpdatePolicyNo($policyid, $policyNo,$formData,$response);
        } elseif ($data['action'] === 'insertPaymentLog') {
            $request = isset($data['request']) ? $data['request'] : array();
            $response = isset($data['response']) ? $data['response'] : array();
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            $objectPayment = isset($data['objectPayment']) ? $data['objectPayment'] : array();
            $response = isset($data['response']) ? $data['response'] : array();
            $policyid = isset($data['policyid']) ? $data['policyid'] : "";
            DBInsertPaymentLog($request, $response, $policyid, $objectPayment);
        } elseif ($data['action'] === 'updateRetrieveQuote') {
            $id = isset($data['id']) ? $data['id'] : 0;
            $response = isset($data['response']) ? $data['response'] : array();
            $formatData = isset($data['formatData']) ? $data['formatData'] : array();
            $planData = isset($data['planData']) ? $data['planData'] : array();
            DBUpdateQuoteRetrieve($response, $id,$formatData,$planData);
        } elseif ($data['action'] === 'insertRetrieveQuote') {
            $response = isset($data['response']) ? $data['response'] : array();
            $formData = isset($data['formData']) ? $data['formData'] : array();
            $campaignDetails = isset($data['campaignDetails']) ? $data['campaignDetails'] : array();
            $type = isset($data['type']) ? $data['type'] : "";
            DBInsertRetrieveQuote($response,$formData, $type, $campaignDetails);
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
function transformDateQuote($dateString)
{
    // Create a DateTime object from the input string (assuming the format is DD/MM/YYYY)
    $dateObject = DateTime::createFromFormat('d/m/Y', $dateString);

    // If the DateTime object is created successfully, format it to the required format
    if ($dateObject) {
        // Format it to "YYYY-MM-DD 00:00:00"
        return $dateObject->format('Y-m-d') . ' 00:00:00';
    }

    // Return null if the date format is invalid
    return null;
}

function convertToISO8601($dateStr) {
    // Try to parse the ISO 8601 date (e.g., YYYY-MM-DDTHH:MM:SSZ)
    try {
        $date = new DateTime($dateStr);
        // Return the date in 'Y-m-d H:i:s' format
        return $date->format('Y-m-d 00:00:00');
    } catch (Exception $e) {
        // If the ISO 8601 format fails, try parsing as 'd/m/Y'
        $date = DateTime::createFromFormat('d/m/Y', $dateStr);
        // Return the date in 'Y-m-d H:i:s' format or null if invalid
        return $date ? $date->format('Y-m-d 00:00:00') : null;
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
function formatBatchNo($dateStr)
{
    $year = substr($dateStr, 0, 4);
    $month = substr($dateStr, 4, 2);
    $day = substr($dateStr, 6, 2);
    return $day . $month . $year;
}
function isoToDateTime($isoDateStr)
{
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
