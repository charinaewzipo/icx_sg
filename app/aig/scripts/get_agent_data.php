<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../function/StartConnect.inc");

if(isset($_POST['agent_id']))
$agent_id = $_POST['agent_id'];
$strSQL = "SELECT * FROM t_agents where agent_id='$agent_id'";
$objQuery = mysqli_query($Conn, $strSQL);

$agent_data = [];
while ($row = mysqli_fetch_assoc($objQuery)) {
    $agent_data[] = $row;
}
header('Content-Type: application/json');
echo json_encode($agent_data);

// Close the database connection
mysqli_close($Conn);
?>
