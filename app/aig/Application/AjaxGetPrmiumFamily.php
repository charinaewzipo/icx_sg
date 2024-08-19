<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE);

include("../../function/StartConnect.inc");

$PRODUCTNAME_TH = $_GET['PRODUCT_NAME'];
$PLAN = $_GET['COVERAGE_NAME'];
$PAYMENTFREQUENCY = $_GET['PAYMENTFREQUENCY'];

$SQL = "select * from t_aig_family_product where PRODUCTNAME_TH = '$PRODUCTNAME_TH' and PLAN = '$PLAN' ";
$result = mysqli_query($Conn, $SQL);
		while($objResult = mysqli_fetch_array($result))
		{
			//$premium_payment = $objResult["premium_payment"] ;

            if($PAYMENTFREQUENCY == 'รายเดือน'){
                $premium_payment = $objResult["PREMIUM_M"] ;
            }else{
                $premium_payment = $objResult["PREMIUM_Y"] ;
            }
		}

//echo $payment ;
echo $premium_payment ;

?>
