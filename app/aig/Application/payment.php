<script src="https://ap-gateway.mastercard.com/static/checkout/checkout.min.js"
        data-error="errorCallback"         
        data-cancel="cancelCallback"
        data-beforeRedirect="Checkout.saveFormFields"
        data-afterRedirect="Checkout.restoreFormFields">
</script>

<?php
require_once("../../function/StartConnect.inc");

$amount = $_GET['amount'];
$is_recurring = $_GET['is_recurring'];
$quoteNo = $_GET['quoteNo'];

$merchant = 'TEST97498471';
$username = "merchant.$merchant";
$password = '8fb334a463b16d4e4d19e3f7639edfd4';

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$paymentUrl = "$protocol$host/app/aig/Application/payment.php";
$returnUrl = "$protocol$host/app/aig/Application/payment_result.php?is_recurring=$is_recurring";

$now = new DateTime();
$orderId = $now->format('Y.m.d.H.i.s.').sprintf('%03d', $now->format('u') / 1000);

$url_create_session = "https://ap-gateway.mastercard.com/api/rest/version/llaatteesstt/merchant/$merchant/session";
$data_create_session = [
    "apiOperation" => "INITIATE_CHECKOUT",
    "checkoutMode" => "WEBSITE",
    "interaction" => [
        "operation" => "PURCHASE",
        "merchant" => [
            "name" => "IRMA Insights",
            "url" => "$paymentUrl"
        ],
        "returnUrl" => "$returnUrl"
    ],
    "order" => [
        "currency" => "SGD",
        "amount" => "$amount",
        "id" => "$orderId",
        "description" => "Goods and Services"
    ]
];
$body_create_session = json_encode($data_create_session);
echo "<script>
        console.log('body_create_session',$body_create_session);
    </script>";

$response_create_session = callAPI($username, $password, $url_create_session, "POST", $body_create_session);
echo "<script>
        console.log('response_create_session',$response_create_session);
    </script>";

if($response_create_session != "{}"){
    $data = json_decode($response_create_session, true);
    $payment_session = $data['session']['id'];
    $payment_result_indicator = $data['successIndicator'];

    $SQL = "INSERT INTO t_aig_sg_payment_log (order_amount,order_currency,result,time_of_record,payment_session_id,payment_order_id,payment_result_indicator,payment_is_recurring,merchant,quote_no) VALUES ('$amount','SGD','CREATE',NOW(),'$payment_session','$orderId','$payment_result_indicator','$is_recurring','$merchant','$quoteNo')" ;
	mysqli_query($Conn, $SQL);

    echo "<script>
        var payment_session = '$payment_session';
        localStorage.setItem('paymentSession', payment_session);
        var order_id = '$orderId';
        localStorage.setItem('paymentOrderId', order_id);
    </script>";
    echo '<script type="text/javascript">
        function errorCallback(error) {
        }
        function cancelCallback() {
        }
        Checkout.configure({
        session: {
            id: "'.$payment_session.'"
            }
        });
    </script>';
    echo '<input type="button" value="" id="btnPayment" onclick="Checkout.showPaymentPage();" />';
    echo '<script>
        document.getElementById("btnPayment").click();
    </script>';

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