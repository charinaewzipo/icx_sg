<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../function/StartConnect.inc");

if(isset($_POST['calllist_id']))
$calllist_id = $_POST['calllist_id'];
$strSQL = "SELECT * FROM t_calllist where calllist_id='$calllist_id'";
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
