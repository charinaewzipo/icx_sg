<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../function/StartConnect.inc");

if(isset($_POST['campaign_id']))
$campaign_id = $_POST['campaign_id'];
$strSQL = "SELECT * FROM t_campaign where campaign_id='$campaign_id'";
$objQuery = mysqli_query($Conn, $strSQL);

$calllist = [];
while ($row = mysqli_fetch_assoc($objQuery)) {
    $calllist[] = $row;
}
header('Content-Type: application/json');
echo json_encode($calllist);

// Close the database connection
mysqli_close($Conn);
?>
