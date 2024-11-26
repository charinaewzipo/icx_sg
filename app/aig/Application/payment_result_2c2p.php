<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Result Page</title>
</head>
<body>
    <p id="countdown" hidden>Closing in 3 seconds...</p>

<?php
    require_once("../../function/StartConnect.inc");
    require_once("../../function/settings.php");

    $url_payment_inquiry = $GLOBALS['2c2p_payment_inquiry_url'];

    $invoiceNo = $_GET['quoteNo'];
    echo "<script>console.log('quoteNo','$invoiceNo');</script>";
    if($invoiceNo == "")
    {
        $paymentResponse = $_GET['paymentResponse'];
        echo "<script>console.log('paymentResponse','$paymentResponse');</script>";

        $paymentResponse_decode = base64_decode($paymentResponse);
        echo "<script>console.log('paymentResponse_decode','$paymentResponse_decode');</script>";

        $paymentResponse_json = json_decode($paymentResponse_decode);
        $invoiceNo = $paymentResponse_json->{"invoiceNo"};
        echo "<script>console.log('invoiceNo','$invoiceNo');</script>";
    }

    $SQL = "SELECT * FROM t_aig_sg_payment_log WHERE payment_order_id='$invoiceNo'";
    $objQuery = mysqli_query($Conn, $SQL);
    while($objResult = mysqli_fetch_array($objQuery))
    {
        $payment_id = $objResult["id"];
        $payment_merchant = $objResult["merchant"];
        $payment_secret = $objResult["secret"];
    }

    $PT_dataArray = array(
        "merchantID" => $payment_merchant,
        "invoiceNo" => $invoiceNo
    ); 

    $PT_dataArray = (object) array_filter((array) $PT_dataArray);   
    $PT_data = json_encode($PT_dataArray);  
    echo "<script>console.log('PT_data',$PT_data);</script>";

    $PT_dataB64= base64url_encode($PT_data);
    $PT_header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $PT_headerB64= base64url_encode($PT_header);
    $PT_signature= hash_hmac('sha256', $PT_headerB64 . "." . $PT_dataB64 ,$payment_secret, true); 
    $PT_signatureB64= base64url_encode($PT_signature);
    $PT_payloadData = $PT_headerB64 . "." . $PT_dataB64 . "." . $PT_signatureB64;
    $PT_payloadArray = array(
        "payload" => $PT_payloadData
    );
    $PT_payloadArray = (object) array_filter((array) $PT_payloadArray);                 
    $PT_payload = json_encode($PT_payloadArray);    
    echo "<script>console.log('PT_payload','$PT_payload');</script>";
    
    $PT_response = callAPI($url_payment_inquiry,$PT_payload);
    echo "<script>console.log('PT_response','$PT_response');</script>";
    $PT_resData = json_decode($PT_response);
    $PT_resData_respCode = $PT_resData->{"respCode"};
    $PT_resData_respDesc = $PT_resData->{"respDesc"};
    echo "$PT_response";
    echo "<script>console.log('PT_resData_respCode','$PT_resData_respCode');</script>";
    echo "<script>console.log('PT_resData_respCode','$PT_resData_respDesc');</script>";
    if($PT_resData_respCode == ""){
        $PT_resData_Payload = $PT_resData->{"payload"};
        echo "<script>console.log('PT_resData_Payload','$PT_resData_Payload');</script>";
        $PT_resData_Payload_decode = base64_decode($PT_resData_Payload);
        echo "<script>console.log('PT_resData_Payload_decode','$PT_resData_Payload_decode');</script>";
        $parts = explode('}{', $PT_resData_Payload_decode);
        $payloadJson = '{' . $parts[1];
        $payloadJson = substr($payloadJson, 0, strpos($payloadJson, '}') + 1);
        echo "<script>console.log('payloadJson','$payloadJson');</script>";
        $PT_result = json_decode($payloadJson);
        $invoiceNo = $PT_result->{"invoiceNo"};
        $cardNo = $PT_result->{"cardNo"};
        $accountNo = $PT_result->{"accountNo"};
        $cardNo = $cardNo != "" ? $cardNo : $accountNo;
        $panExpiry = $PT_result->{"panExpiry"};
        $expire_month = substr($panExpiry, 0, 2);
        $expire_year = substr($panExpiry, 2);
        $respCode = $PT_result->{"respCode"};
        $respDesc = $PT_result->{"respDesc"};
        echo "<script>console.log('respCode','$respCode');</script>";
        echo "<script>console.log('respDesc','$respDesc');</script>";
        echo "<script>console.log('cardNo','$cardNo');</script>";
        if($respCod == "0000"){
            $respDesc = "SUCCESS";
        }
        $SQL = "UPDATE t_aig_sg_payment_log SET 
        result='$respDesc'
        ,time_of_lastupdate=NOW()
        ,source_of_funds_type='CARD' 
        ,card_number='$cardNo' 
        ,card_expiry_month='$expire_month' 
        ,card_expiry_year='$expire_year' 
        ,response_json='$payloadJson'
        ,payment_result_indicator='$PT_payload'
        WHERE payment_order_id='$invoiceNo' ";
        mysqli_query($Conn, $SQL);    
    }
    else{
        $SQL = "UPDATE t_aig_sg_payment_log SET 
        result='FAIL'
        ,time_of_lastupdate=NOW()
        ,source_of_funds_type='CARD' 
        ,response_json='$PT_response'
        ,payment_result_indicator='$PT_payload'
        WHERE payment_order_id='$invoiceNo' ";
        mysqli_query($Conn, $SQL);   
    }
?>
    <script>
        window.onload = function() {
            if (window.opener && !window.opener.closed) {
                window.opener.showAlert('Payment completed successfully!');
                window.close();
            }
    };
    </script>

</body>
</html>

<?php

function callAPI($url,$fields_string)
{
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url); 
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',                 
	));
 
    $result = curl_exec($ch); //close connection
    curl_close($ch);
    return $result;
} 

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
  
function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
} 

?>
