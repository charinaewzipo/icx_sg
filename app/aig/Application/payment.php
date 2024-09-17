

<script src="https://ap-gateway.mastercard.com/static/checkout/checkout.min.js"
        data-error="errorCallback"         
        data-cancel="cancelCallback"
        data-beforeRedirect="Checkout.saveFormFields"
        data-afterRedirect="Checkout.restoreFormFields">
</script>

<?php
session_start();
$merchant = "TEST97498471";
$url = `https://ap-gateway.mastercard.com/api/rest/version/llaatteesstt/merchant/$merchant/session`;
$username = 'merchant.TEST97498471';
$password = '8fb334a463b16d4e4d19e3f7639edfd4';

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$paymentUrl = "$protocol$host/app/aig/Application/payment.php";
$returnUrl = "$protocol$host/app/aig/Application/payment_result.php";

$currentDateTime = date('YmdH:i:s');
$amount = $_GET['amount'];

$data = [
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
        "id" => "$currentDateTime",
        "description" => "Goods and Services"
    ]
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password"); 
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',  
    'Accept: application/json',        
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$_SESSION['payment_data'] = $data;
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    $data = json_decode($response, true);
    $payment_session = $data['session']['id'];
    echo "<script>
                var payment_session = '$payment_session';
                localStorage.setItem('dataPayment', data_payment);
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
    echo '<input type="button" style="display:none;" value="" id="btnPayment" onclick="Checkout.showPaymentPage();" />';
    echo '<script>
            document.getElementById("btnPayment").click();
        </script>';
        echo json_encode($data);
    
}

curl_close($ch);

?>