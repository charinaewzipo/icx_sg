paymentSession:<input type="text" name="paymentSession" id="paymentSession"><br>
resultIndicator:<input type="text" name="resultIndicator" id="resultIndicator"><br>
sessionVersion:<input type="text" name="sessionVersion" id="sessionVersion">
<?php
$resultIndicator = $_GET['resultIndicator'];
$sessionVersion = $_GET['sessionVersion'];
echo "<script>
        var paymentSession = localStorage.getItem('paymentSession');
        document.getElementById('paymentSession').value = paymentSession;
        document.getElementById('resultIndicator').value = '$resultIndicator';
        document.getElementById('sessionVersion').value = '$sessionVersion';
    </script>";
?>