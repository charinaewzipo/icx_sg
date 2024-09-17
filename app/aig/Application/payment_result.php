<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Result Page</title>
</head>
<body>
    paymentSession: <input type="text" name="paymentSession" id="paymentSession"><br>
    resultIndicator: <input type="text" name="resultIndicator" id="resultIndicator"><br>
    sessionVersion: <input type="text" name="sessionVersion" id="sessionVersion"><br>
    <p id="countdown">Closing in 5 seconds...</p>

    <?php
    session_start();
    if (isset($_SESSION['payment_data'])) {
        $payment_data = $_SESSION['payment_data'];
        echo "<pre>";
        print_r($payment_data);
        echo "</pre>";
    } else {
        echo "No payment data found.";
    }
    $resultIndicator = $_GET['resultIndicator'];
    $sessionVersion = $_GET['sessionVersion'];
    unset($_SESSION['payment_data']);
    ?>

    <script>
        window.onload = function() {
            var paymentSession = localStorage.getItem('paymentSession');
            document.getElementById('paymentSession').value = paymentSession || '';

            document.getElementById('resultIndicator').value = "<?php echo $resultIndicator; ?>";
            document.getElementById('sessionVersion').value = "<?php echo $sessionVersion; ?>";
        };

        function sendMessageToParent() {
            if (window.opener && !window.opener.closed) {
                window.opener.showAlert('Payment completed successfully!');
            }
            window.close(); 
        }

        // นับถอยหลัง 5 วินาที
        // let countdown = 5;
        // const countdownElement = document.getElementById('countdown');

        // const timer = setInterval(() => {
        //     countdown--;
        //     countdownElement.innerText = `Closing in ${countdown} seconds...`;
        //     if (countdown <= 0) {
        //         clearInterval(timer);
        //         sendMessageToParent(); 
        //     }
        // }, 1000); 
    </script>
</body>
</html>
