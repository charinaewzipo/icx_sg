<?php
header('Content-Type: text/html; charset=utf-8');

include("../../function/StartConnect.inc");

$strSQL = "SELECT * FROM t_aig_sg_token WHERE id = 1";
$objQuery = mysqli_query($Conn, $strSQL);

$token = mysqli_fetch_assoc($objQuery);
echo json_encode($token);
mysqli_close($Conn);
?>
