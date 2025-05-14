<?php include "wlog.php"?>
<?php
header('Content-Type: application/json; charset=utf-8');

include("../../function/StartConnect.inc");

$plan_code = isset($_GET['plan_code']) ? $_GET['plan_code'] : '';

// Your SQL query to fetch payment modes and card types
$strSQL = "SELECT *
FROM t_aig_sg_auto_plan_code where plan_code='$plan_code' ;";

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
