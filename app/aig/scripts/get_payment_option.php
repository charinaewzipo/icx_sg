<?php include "wlog.php"?>
<?php
header('Content-Type: application/json; charset=utf-8');

include("../../function/StartConnect.inc");

$payment_frequency = isset($_GET['payment_frequency']) ? $_GET['payment_frequency'] : '';
$payment_mode = isset($_GET['payment_mode']) ? $_GET['payment_mode'] : '';

// Your SQL query to fetch payment modes and card types
$strSQL = "SELECT taspc.id, taspc.payment_mode_card_name
               FROM t_aig_sg_payment_cardtype taspc
               INNER JOIN t_aig_sg_payment_mode taspm
               ON taspc.payment_mode_value = taspm.payment_mode_value
               WHERE taspm.payment_mode_value = '$payment_mode'
               AND taspc.payment_frequency = '$payment_frequency'";

// wlog($strSQL);
$objQuery = mysqli_query($Conn, $strSQL);
$plans = [];
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $plans[] = $objResult; // Collect results in an array
}

echo json_encode($plans); // Return JSON data

// Close the database connection
mysqli_close($Conn);
?>
