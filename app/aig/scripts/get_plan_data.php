<?php
header('Content-Type: text/html; charset=utf-8');

include("../../function/StartConnect.inc");

$strSQL = "SELECT * FROM t_aig_sg_premium";
$objQuery = mysqli_query($Conn, $strSQL);

$plans = [];
while ($row = mysqli_fetch_assoc($objQuery)) {
    $plans[] = $row;
}
header('Content-Type: application/json');
echo json_encode($plans);

// Close the database connection
mysqli_close($Conn);
?>
