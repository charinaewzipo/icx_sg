<?php include "wlog.php"?>
<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../function/StartConnect.inc");

$makeValue = isset($_GET['makeValue']) ? $_GET['makeValue'] : '';

// Your SQL query to fetch payment modes and card types
$strSQL = "SELECT *
FROM t_aig_sg_lov where name='Model' and filterValue='$makeValue'  order by description asc;";

// wlog($strSQL);
$objQuery = mysqli_query($Conn, $strSQL);
$plans = [];
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $plans[] = $objResult; // Collect results in an array
}

echo json_encode($plans); 


mysqli_close($Conn);
?>
