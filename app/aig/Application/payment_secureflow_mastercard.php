<?php
require_once("../../../dbconf.php");
require_once("../../function/StartConnect.inc");
require_once("../../function/settings.php");
$genesys_url = "https://api.mypurecloud.jp";
$voice_id = $_GET['voice_id'];
$quote_no = $_GET['quote_no'];
$amount = $_GET['amount'];
$is_recurring = $_GET['is_recurring'];
$payment_frequency = $_GET['payment_frequency'];

$access_token = getAccessToken();

$merchant = $GLOBALS['merchant'];
$username = $GLOBALS['username'];
$password = $GLOBALS['password'];

$merchant_amex = $GLOBALS['merchant_amex'];
$username_amex = $GLOBALS['username_amex'];
$password_amex = $GLOBALS['password_amex'];

$now = new DateTime();
$orderId = $voice_id;
// $orderId = $now->format('Y.m.d.H.i.s.').sprintf('%03d', $now->format('u') / 1000);
$batchNo = 'IP' . date('dmY');

// echo "voice_id=$voice_id<br>";
// echo "access_token=$access_token<br>";
if ($access_token) {
    $participantData = getParticipantId($genesys_url, $access_token, $voice_id);
    // echo "</br>";
    // print_r($participantData);
    // echo "</br>";
    if ($participantData !== null) {
        $participant_token = $participantData['token'];
        $participant_brand = strtoupper($participantData['brand']);
        //เช็คเพื่อตรวจสอบกรณีซ้ำกันของtoken
        $checkSQL = "SELECT COUNT(*) as count FROM t_aig_sg_payment_log WHERE payment_order_id = '$voice_id' and result='CREATE'";
        $result = mysqli_query($Conn, $checkSQL);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] == 0) {
            // getTokenDetail

            if ($participant_brand === 'AMEX') {
                // echo "</br>";
                // print_r($participant_brand);
                // echo "</br>";
                $url_get_payment_token_detail = $GLOBALS['url_get_payment_detail_amex'] . "/token/$participant_token";
                $response_get_payment_token_detail = callAPI($username_amex, $password_amex, $url_get_payment_token_detail, "GET", "");
                $merchanttt=$merchant_amex;
            } else {
                // echo "</br>";
                // print_r($participant_brand);
                // echo "</br>";
                $url_get_payment_token_detail = $GLOBALS['url_get_payment_detail'] . "/token/$participant_token";
                $response_get_payment_token_detail = callAPI($username, $password, $url_get_payment_token_detail, "GET", "");
                $merchanttt=$merchant;
            }
        
            $response_get_payment_token_detail = json_decode($response_get_payment_token_detail, true);
            // echo "</br>";
            // print_r($response_get_payment_token_detail);
            // echo "</br>";
            if (
                $response_get_payment_token_detail
                && $response_get_payment_token_detail['result'] === "SUCCESS"
                && $response_get_payment_token_detail['status'] === "VALID"
            ) {
                $cardtype    = $response_get_payment_token_detail['sourceOfFunds']['type'];
                $expiry      = $response_get_payment_token_detail['sourceOfFunds']['provided']['card']['expiry'];
                $card_number = $response_get_payment_token_detail['sourceOfFunds']['provided']['card']['number'];
                $brand = $response_get_payment_token_detail['sourceOfFunds']['provided']['card']['brand'];

                $expiryMonth = substr($expiry, 0, 2);  // "01"
                $expiryYear  = substr($expiry, 2, 2);  // "39"

                $response_json = mysqli_real_escape_string(
                    $Conn,
                    json_encode($response_get_payment_token_detail, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                );
                // เตรียม SQL INSERT
                $SQL = "
                    INSERT INTO t_aig_sg_payment_log (
                        order_amount,
                        order_currency,
                        result,
                        time_of_record,
                        payment_session_id,
                        payment_order_id,
                        payment_token_id,
                        payment_is_recurring,
                        merchant,
                        quote_no,
                        batch_no,
                        source_of_funds_type,
                        card_number,
                        card_expiry_month,
                        card_expiry_year,
                        response_json,
                        is_secureflow,
                        brand
                    ) VALUES (
                        '$amount',
                        'SGD',
                        'CREATE',
                        NOW(),
                        '',
                        '$orderId',
                        '$participant_token',
                        '$is_recurring',
                        '$merchanttt',
                        '$quote_no',
                        '$batchNo',
                        '$cardtype',
                        '$card_number',
                        '$expiryMonth',
                        '$expiryYear',
                        '$response_json',
                        '1',
                        '$brand'
                    )
                ";

                // Execute และตรวจสอบผล
                if (mysqli_query($Conn, $SQL)) {
                    echo "<div id='paymentResult'>Create token successfully.</div>";
                } else {
                    echo "Error inserting record: " . mysqli_error($Conn);
                }
                $participantData=null;
            } else {
                echo "Invalid or unsuccessful API response.";
            }
        } else {
            echo "<div id='paymentResult'>Duplicate entry blocked for payment_token_id = $participant_token<br></div>";
        }
         //เคลียค่า
    $participantData = null;
    $participant_token = null;
    $participant_brand = null;
    $merchanttt = null;
    $response_get_payment_token_detail = null;
    }   
   
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Master Card Page</title>
</head>

<body>
    <!-- <p id="paymentResult" hidden><?php echo "Payment Result:" . $participant_token; ?></p> -->
    <iframe name="payment_frame" id="payment_frame" src="https://apps.mypurecloud.jp/crm/interaction.html#url=https://apps.mypurecloud.jp/directory/?disableSoftphone=true&disableProactiveDevicePermissions=true" style="width: 100%; height: 500px; border: none;"></iframe>
</body>

<script>
    let interval = setInterval(checkPaymentResult, 3000);

    function checkPaymentResult() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, 'text/html');
                let paymentResult = doc.getElementById('paymentResult');

                if (paymentResult && paymentResult.innerText && paymentResult.innerText !== "null" && paymentResult.innerText !== "undefined") {
                    console.log("checkPaymentResult: " + paymentResult.innerText);

                    clearInterval(interval);

                    if (window.opener && !window.opener.closed) {
                        window.opener.showAlert(paymentResult.innerText); // ✅ ส่งข้อความจริงไป showAlert
                        window.close();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

</html>

<?php


function getAccessToken()
{
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

    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
        return null;
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['access_token'])) {
        return $responseData['access_token'];
    } else {
        echo "Error: No access token returned.";
        return null;
    }
}

function getParticipantId($genesysUrl, $accessToken, $conversationId)
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
            if ($participant['state'] == 'connected' && $participant['purpose'] == 'customer' && $participant['attributes']['result'] == 'SUCCESS') {
                return [
                    'token' => $participant['attributes']['Token'] ?? null,
                    'brand' => $participant['attributes']['Brand'] ?? null,
                ];
            }
        }
    }

    return null;
}

function setParticipantAttributes($genesysUrl, $accessToken, $conversationId, $participantId, $quote_no, $amount, $is_recurring, $payment_frequency)
{

    $url = "$genesysUrl/api/v2/conversations/$conversationId/participants/$participantId/attributes";

    $attributes = [
        'quote_no' => $quote_no,
        'amount' => $amount,
        'is_recurring' => $is_recurring,
        'payment_frequency' => $payment_frequency
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);

    $data = json_encode(['attributes' => $attributes]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $responseData = json_decode($response, true);

    return $response_code;
}


function callAPI($username, $password, $url, $method, $body)
{
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