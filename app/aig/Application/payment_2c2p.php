<?php
require_once("../../function/StartConnect.inc");
require_once("../../function/settings.php");

$amount = $_GET['amount'];
$quoteNo = $_GET['quoteNo'];
$bank = $_GET['bank'];
$ipp = $_GET['ipp'];

$url_payment = $GLOBALS['2c2p_payment_url'];

if(strtolower($bank) == "test")
{
    $merchant = $GLOBALS['2c2p_test_merchant'];
    $secret_key = $GLOBALS['2c2p_test_secret_key'];
}
if(strtolower($bank) == "uob")
{
    $merchant = $GLOBALS['2c2p_uob_merchant'];
    $secret_key = $GLOBALS['2c2p_uob_secret_key'];
}
if(strtolower($bank) == "dbs" && $ipp == "6")
{
    $merchant = $GLOBALS['2c2p_dbs6_merchant'];
    $secret_key = $GLOBALS['2c2p_dbs6_secret_key'];
}
if(strtolower($bank) == "dbs" && $ipp == "12")
{
    $merchant = $GLOBALS['2c2p_dbs12_merchant'];
    $secret_key = $GLOBALS['2c2p_dbs12_secret_key'];
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$returnUrl = "$protocol$host/app/aig/Application/payment_result_2c2p.php";

$SQL = "SELECT COUNT(quote_no) AS count_quote FROM t_aig_sg_payment_log WHERE quote_no = '$quoteNo'";
$result = mysqli_query($Conn, $SQL);
while ($row = mysqli_fetch_array($result)) {
    $count_quote = $row["count_quote"];
}
if($count_quote == 0){
    $orderId = $quoteNo;
}
else{
    $orderId = "$quoteNo-$count_quote";
}

$batchNo = 'IP' . date('dmY');
$installmentPeriodFilter=array_filter(array_map('intval', explode(",",$ipp)));
$PT_dataArray = array(
	"merchantID" => $merchant,
	"invoiceNo" => $orderId,
	"description" => 'Goods and Services',
	"amount" => $amount,
	"currencyCode" => 'SGD',
    "frontendReturnUrl" => $returnUrl,
    "paymentChannel" => ["IPP"],
    "request3DS" => 'N'
	);  

$PT_dataArray = (object) array_filter((array) $PT_dataArray);   
$PT_data = json_encode($PT_dataArray);  
echo "<script>console.log('PT_data',$PT_data);</script>";

$PT_dataB64= base64url_encode($PT_data);
$PT_header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
$PT_headerB64= base64url_encode($PT_header);
$PT_signature= hash_hmac('sha256', $PT_headerB64 . "." . $PT_dataB64 ,$secret_key, true); 
$PT_signatureB64= base64url_encode($PT_signature);
$PT_payloadData = $PT_headerB64 . "." . $PT_dataB64 . "." . $PT_signatureB64;
$PT_payloadArray = array(
	"payload" => $PT_payloadData
);
$PT_payloadArray = (object) array_filter((array) $PT_payloadArray);                 
$PT_payload = json_encode($PT_payloadArray);    
echo "<script>console.log('PT_payload','$PT_payload');</script>";

$PT_response = callAPI($url_payment,$PT_payload);
echo "<script>console.log('PT_response','$PT_response');</script>";
$PT_resData = json_decode($PT_response);
$PT_resData_respCode = $PT_resData->{"respCode"};
$PT_resData_respDesc = $PT_resData->{"respDesc"};
echo "$PT_response";
echo "<script>console.log('PT_resData_respCode','$PT_resData_respCode');</script>";
echo "<script>console.log('PT_resData_respCode','$PT_resData_respDesc');</script>";
$PT_resData_Payload = $PT_resData->{"payload"};
echo "<script>console.log('PT_resData_Payload','$PT_resData_Payload');</script>";
$PT_resData_Payload_decode = base64_decode($PT_resData_Payload);
echo "<script>console.log('PT_resData_Payload_decode','$PT_resData_Payload_decode');</script>";
$parts = explode('}{', $PT_resData_Payload_decode);
$payloadJson = '{' . $parts[1];
$payloadJson = substr($payloadJson, 0, strpos($payloadJson, '}') + 1);
echo "<script>console.log('payloadJson','$payloadJson');</script>";
$PT_result = json_decode($payloadJson);
$webPaymentUrl = $PT_result->{"webPaymentUrl"};
$paymentToken = $PT_result->{"paymentToken"};
echo "<script>console.log('webPaymentUrl','$webPaymentUrl');</script>";
echo "<script>console.log('paymentToken','$paymentToken');</script>";

if($webPaymentUrl != ""){
    $SQL = "INSERT INTO t_aig_sg_payment_log (order_amount,order_currency,result,time_of_record,payment_session_id,payment_order_id,request_json,payment_session_version,payment_is_recurring,merchant,secret,quote_no,batch_no) VALUES 
    ('$amount','SGD','CREATE',NOW(),'$paymentToken','$orderId','$PT_data','$PT_payload','0','$merchant','$secret_key','$quoteNo','$batchNo')" ;
	mysqli_query($Conn, $SQL);

    echo "<script>window.location.href = '$webPaymentUrl';</script>";
}

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