<?php include "wlog.php"?>
<?php
header('Content-Type: application/json; charset=utf-8');

include("../../function/StartConnect.inc");

$name = isset($_GET['name']) ? $_GET['name'] : '';

// Your SQL query to fetch payment modes and card types
$strSQL = "SELECT *
FROM t_aig_sg_lov where name='$name' ;";

// wlog($strSQL);
$objQuery = mysqli_query($Conn, $strSQL);
$plans = [];
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $plans[] = $objResult; // Collect results in an array
}

echo json_encode($plans); 


mysqli_close($Conn);
?>
