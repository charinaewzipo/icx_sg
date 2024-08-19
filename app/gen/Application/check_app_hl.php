<?php
include("../../function/StartConnect.inc");

$campaign_id = $_GET["campaign_id"];
$calllist_id = $_GET["calllist_id"];
$agent_id = $_GET["agent_id"];
$import_id = $_GET["import_id"];

$SQL = "select ProposalNumber from t_app where calllist_id = '$calllist_id' and campaign_id = '$campaign_id' ";
$result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");

$chk = mysql_num_rows($result);

if ($chk > 0) {

  while($row = mysql_fetch_array($result))
  {
    $Id = $row["ProposalNumber"];
  }

echo "<script>window.location='appDetail_Health.php?Id=$Id';</script>";

}else{

  echo "<script>window.location='newApp_health.php?campaign_id=$campaign_id&calllist_id=$calllist_id&agent_id=$agent_id&import_id=$import_id';</script>";

}

?>
