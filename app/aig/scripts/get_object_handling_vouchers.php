<?php include "wlog.php"?>
<?php
header('Content-Type: application/json; charset=utf-8');

include("../../function/StartConnect.inc");

$renewal_year = isset($_GET['renewal_year']) ? $_GET['renewal_year'] : '';
$renewal_premium = isset($_GET['renewal_premium']) ? $_GET['renewal_premium'] : '';

// Your SQL query to fetch payment modes and card types

$strSQL = "SELECT *
FROM t_aig_sg_objection_handling_vouchers
WHERE FIND_IN_SET('$renewal_year', renewal_year)
  AND CAST(renewal_premium AS UNSIGNED) <= '$renewal_premium'
ORDER BY CAST(renewal_premium AS UNSIGNED) DESC;";
 
// wlog($strSQL);
$objQuery = mysqli_query($Conn, $strSQL);
$product = [];
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $product[] = $objResult; // Collect results in an array
}

echo json_encode($product); // Return JSON data

// Close the database connection
mysqli_close($Conn);
?>
