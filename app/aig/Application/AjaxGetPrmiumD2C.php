<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE);

include("../../function/StartConnect.inc");

$PRODUCTNAME_TH = $_GET['PRODUCT_NAME'];
$PLAN = $_GET['COVERAGE_NAME'];
$PAYMENTFREQUENCY = $_GET['PAYMENTFREQUENCY'];
$age = $_GET['AGE'];
$campaign_id = $_GET['CAMPAIGN_ID'];

/*
if($campaign_id = '24'){
        $r_age = '20-80';
}else{
if($age >= '0' and $age <= '5'){
	$r_age = '0-5';
}elseif($age >= '6' and $age <= '10'){
	$r_age = '6-10';
}elseif($age >= '11' and $age <= '15'){
	$r_age = '11-15';
}elseif($age >= '16' and $age <= '20'){
	$r_age = '16-20';
}elseif($age >= '21' and $age <= '25'){
	$r_age = '21-25';
}elseif($age >= '26' and $age <= '30'){
	$r_age = '26-30';
}elseif($age >= '31' and $age <= '35'){
	$r_age = '31-35';
}elseif($age >= '36' and $age <= '40'){
	$r_age = '36-40';
}elseif($age >= '41' and $age <= '45'){
	$r_age = '41-45';
}elseif($age >= '46' and $age <= '50'){
	$r_age = '46-50';
}elseif($age >= '51' and $age <= '55'){
	$r_age = '51-55';
}elseif($age >= '56' and $age <= '60'){
	$r_age = '56-60';
}elseif($age >= '61' and $age <= '65'){
	$r_age = '61-65';
}elseif($age >= '66' and $age <= '70'){
	$r_age = '66-70';
}
}
*/

$SQL = "SELECT * FROM t_aig_doublecare_product WHERE PRODUCTNAME_TH = '$PRODUCTNAME_TH' AND PLAN = '$PLAN' AND campaign_id = '$campaign_id' AND '$age' BETWEEN AGE_MIN AND AGE_MAX";

//$SQL = "select * from t_aig_doublecare_product where PRODUCTNAME_TH = '$PRODUCTNAME_TH' and PLAN = '$PLAN' AND campaign_id = '$campaign_id' AND $age BETWEEN AGE_MIN AND AGE_MAX";
$result = mysqli_query($Conn, $SQL);
		while($objResult = mysqli_fetch_array($result))
		{
			//$premium_payment = $objResult["premium_payment"] ;
            if($PAYMENTFREQUENCY == 'รายเดือน'){
                $premium_payment = $objResult["PREMIUM_M"] ;
            }else{
                $premium_payment = $objResult["PREMIUM_Y"] ;
            }
			$PLAN_LAYER_CODE = $objResult["PLAN_LAYER_CODE"] ;
		}

//echo $payment ;
//echo $premium_payment ;

$data = array("premium_payment" => $premium_payment, "PLAN_LAYER_CODE" => $PLAN_LAYER_CODE);
echo json_encode($data);

?>
