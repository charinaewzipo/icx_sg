<?php include "wlog.php"?>
<?php
header('Content-Type: application/json; charset=utf-8');

include("../../function/StartConnect.inc");

$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';

// Your SQL query to fetch payment modes and card types
$strSQL = "SELECT id, cover_id, cover_name, cover_code, product_id
FROM t_aig_sg_covers where product_id='$product_id' ;";

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
