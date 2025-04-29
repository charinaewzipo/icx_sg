<?php
require_once ("../../../dbconf.php");
require_once("../../function/StartConnect.inc");
require_once("../../function/settings.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$genesys_url = "https://api.mypurecloud.jp";
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

$voice_id = $data['voice_id'] ?? null;
$quote_no = $data['quote_no'] ?? null;
$amount = (string)($data['amount']) ?? null;
$tokenId = $data['tokenId'] ?? null;
$brand = $data['brand'] ?? null;
$is_recurring = $data['is_recurring'] ?? null;
$payment_frequency = $data['payment_frequency'] ?? null;



$access_token = getAccessToken();

$merchant = $GLOBALS['merchant'];
$username = $GLOBALS['username'];
$password = $GLOBALS['password'];

$merchant_amex = $GLOBALS['merchant_amex'];
$username_amex = $GLOBALS['username_amex'];
$password_amex = $GLOBALS['password_amex'];

$now = new DateTime();
$orderId = $orderId = uniqid('order_', true);
// $orderId = $now->format('Y.m.d.H.i.s.').sprintf('%03d', $now->format('u') / 1000);
$batchNo = 'IP' . date('dmY');
// if (!$voice_id || !$quote_no || !$amount || !$tokenId || !$payment_frequency) {
//     http_response_code(400);
//     echo json_encode(["success" => false, "message" => "Missing required fields"]);
//     exit;
// }

if ($access_token) {

    $participantData = getParticipantData($genesys_url, $access_token, $voice_id);
    if ($participantData !== null) {
        $participant_token = $participantData['token'];
        $participant_quote_no = $participantData['quote_no'];
        $participant_id = $participantData['id'];
        $participant_brand = strtoupper($participantData['brand']);

        // Correct quote number checking
        if ($participant_quote_no !== $quote_no) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Quote number mismatch."
            ]);
            exit; 
        }

        $payload = [
            "apiOperation" => "PAY",
            "order" => [
                "amount" => $amount,
                "currency" => 'SGD'
            ],
            "sourceOfFunds" => [
                "type" => "CARD",
                "token" => $tokenId
            ]
        ];
        $jsonPayload = json_encode($payload, JSON_PRETTY_PRINT);

        if (strtoupper($brand) === 'AMEX') {
            $url_pay_by_token = $GLOBALS['url_get_payment_detail_amex'] . "/order/$voice_id/transaction/$orderId";
            $response = callAPI($username_amex, $password_amex, $url_pay_by_token, "PUT", $jsonPayload);
        } else {
            $url_pay_by_token = $GLOBALS['url_get_payment_detail'] . "/order/$voice_id/transaction/$orderId";
            $response = callAPI($username, $password, $url_pay_by_token, "PUT", $jsonPayload);
        }

        $decoded = json_decode($response, true);
        $response_json = json_encode($decoded);

        $result = $decoded["result"] ?? "UNKNOWN";
        $gatewayCode = $decoded["response"]['gatewayCode'] ?? "UNKNOWN";

        // Prepare the SQL statement once
        $stmt = $Conn->prepare("UPDATE t_aig_sg_payment_log SET 
            result=?, 
            time_of_lastupdate=NOW(), 
            response_json=? 
            WHERE payment_token_id=?");

        // Check if the result and gatewayCode indicate success
        if ($result === "SUCCESS" && $gatewayCode === "APPROVED") {
            $status = "SUCCESS";
        } else {
            $status = "FAIL";
        }

        // Bind the parameters for the prepared statement
        $stmt->bind_param("sss", $status, $response_json, $tokenId);

        // Execute the query
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "success" => true,
                "message" => "Payment success",
                "gateway_response" => $decoded
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Payment not approved",
                "gateway_response" => $decoded
            ]);
        }

        // Close the prepared statement
        $stmt->close();

    } else {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Participant data not found."
        ]);
    }

} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Missing required access token."
    ]);
}


?>

<?php


function getAccessToken() {
    $url = "https://login.mypurecloud.jp/oauth/token";

    $client_id = GENE_CLIENTID;
    $client_secret = GENE_CLIENTSECRET;
    $grant_type = "client_credentials";

    $data = [
        'grant_type' => $grant_type,
        'client_id' => $client_id,
        'client_secret' => $client_secret
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
        return null;
    }
    
    curl_close($ch);
    
    $responseData = json_decode($response, true);
    
    if(isset($responseData['access_token'])) {
        return $responseData['access_token'];
    } else {
        echo "Error: No access token returned.";
        return null;
    }
}
function getParticipantData($genesysUrl, $accessToken, $conversationId)
{

    $url = "$genesysUrl/api/v2/conversations/calls/$conversationId";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    if (isset($responseData['participants']) && count($responseData['participants']) > 0) {
        foreach ($responseData['participants'] as $participant) {
            if ($participant['purpose'] == 'customer' && $participant['attributes']['result'] == 'SUCCESS') {
                return [
                    'token' => $participant['attributes']['Token'] ?? null,
                    'brand' => $participant['attributes']['Brand'] ?? null,
                    'quote_no' => $participant['attributes']['quote_no'] ?? null,
                    'id' => $participant['id'] ?? null,
                ];
            }
        }
    }

    return null;
}
function callAPI($username, $password, $url, $method, $body) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password"); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',  
        'Accept: application/json',        
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return "{}";
    } else {
        return $response;
    }
    curl_close($ch);
}

?>