<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Result Page</title>
</head>
<body>
    <p id="countdown">Closing in 3 seconds...</p>
    <input type="hidden" name="paymentSession" id="paymentSession"><br>
    <input type="hidden" name="resultIndicator" id="resultIndicator"><br>
    <input type="hidden" name="sessionVersion" id="sessionVersion"><br>
    <input type="hidden" name="paymentOrderId" id="paymentOrderId"><br>
    <input type="hidden" name="paymentToken" id="paymentToken"><br>  

<?php
    require_once("../../function/StartConnect.inc");

    $merchant = 'TEST97498471';
    $username = "merchant.$merchant";
    $password = '8fb334a463b16d4e4d19e3f7639edfd4';

    $resultIndicator = $_GET['resultIndicator'];
    $sessionVersion = $_GET['sessionVersion'];
    $is_recurring = $_GET['is_recurring'];

    $SQL = "SELECT * FROM t_aig_sg_payment_log where payment_result_indicator = '$resultIndicator'";
    $objQuery = mysqli_query($Conn, $SQL);
    while($objResult = mysqli_fetch_array($objQuery))
    {
        $payment_id = $objResult["id"];
        $payment_session_id = $objResult["payment_session_id"];
        $payment_order_id = $objResult["payment_order_id"];
    }

    $url_get_payment_detail  = "https://ap-gateway.mastercard.com/api/rest/version/llaatteesstt/merchant/$merchant/order/$payment_order_id";
    $response_get_payment_detail  = callAPI($username, $password, $url_get_payment_detail, "GET", "");
    echo "<script>
            console.log('response_get_payment_detail',$response_get_payment_detail);
        </script>";
    $data_payment_detail = json_decode($response_get_payment_detail, true);
    $payment_amount = $data_payment_detail['amount'];
    $payment_currency = $data_payment_detail['currency'];
    $payment_sourceOfFunds = $data_payment_detail['sourceOfFunds']['type'];
    $payment_card_number = $data_payment_detail['sourceOfFunds']['provided']['card']['number'];
    $payment_card_expire_month = $data_payment_detail['sourceOfFunds']['provided']['card']['expiry']['month'];
    $payment_card_expire_year = $data_payment_detail['sourceOfFunds']['provided']['card']['expiry']['year'];

    $payment_token_id = "";
    if($is_recurring == "1"){
        $payment_token_id = str_replace(".", "", $payment_order_id);
        $url_create_token  = "https://ap-gateway.mastercard.com/api/rest/version/llaatteesstt/merchant/$merchant/token/$payment_token_id";
        $data_create_token = [
            "session" => [
                "id" => $payment_session_id
            ],
        ];
        $body_create_token = json_encode($data_create_token);
        echo "<script>
            console.log('body_create_token',$body_create_token);
        </script>";
        $response_create_token = callAPI($username, $password, $url_create_token, "PUT", $body_create_token);
        echo "<script>
            console.log('response_create_token',$response_create_token);
            var payment_token = '$payment_token_id';
            localStorage.setItem('paymentToken', payment_token);
        </script>";
    }

    $SQL = "UPDATE t_aig_sg_payment_log SET 
            result='SUCCESS'
            ,time_of_lastupdate=NOW()
            ,payment_token_id='$payment_token_id'
            ,payment_session_version='$sessionVersion' 
            ,order_amount='$payment_amount' 
            ,order_currency='$payment_currency' 
            ,source_of_funds_type='$payment_sourceOfFunds' 
            ,card_number='$payment_card_number' 
            ,card_expiry_month='$payment_card_expire_month' 
            ,card_expiry_year='$payment_card_expire_year' 
            ,response_json='$response_get_payment_detail' 
            WHERE id='$payment_id' " ;
	mysqli_query($Conn, $SQL);

    echo "<script>
            window.open('', '_self');
            window.close(); 
        </script>";
?>

    <script>
        window.onload = function() {
            var paymentSession = localStorage.getItem('paymentSession');
            var paymentOrderId = localStorage.getItem('paymentOrderId');
            var paymentToken = localStorage.getItem('paymentToken');
            document.getElementById('paymentSession').value = paymentSession || '';
            document.getElementById('resultIndicator').value = "<?php echo $resultIndicator; ?>";
            document.getElementById('sessionVersion').value = "<?php echo $sessionVersion; ?>";
            document.getElementById('paymentOrderId').value = paymentOrderId || '';
            document.getElementById('paymentToken').value = paymentToken || '';
            
        };
    </script>

</body>
</html>

<?php

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
