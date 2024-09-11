<?php
session_start();
require_once("../../function/StartConnect.inc");
require_once("../../../wlog.php");

$agent_id = $_SESSION["pfile"]["uid"];
$lv = intval($_SESSION["pfile"]["lv"]);



$campaign_id = ($_GET["campaign_id"]) ? intval($_GET["campaign_id"]) : "";
$calllist_id = ($_GET["calllist_id"]) ? intval($_GET["calllist_id"]) : "";
$import_id = ($_GET["import_id"]) ? intval($_GET["import_id"]) : "";
$agent_id = ($_GET["agent_id"]) ? intval($_GET["agent_id"]) : "";

$id = ($_GET["id"]) ? intval($_GET["id"]) : "";

if (($campaign_id && $import_id && $agent_id && $calllist_id) || $id) {


  $SQL = "";
  if ($id) {
    $SQL = "select id,incident_status,campaign_id,calllist_id,import_id,agent_id from t_aig_app where id = '$id'";
  } else {
    $SQL = "select id,incident_status,campaign_id from t_aig_app where campaign_id = '$campaign_id' and  calllist_id = '$calllist_id' and import_id = '$import_id' limit 1 ";
  }
  wlog($SQL);
  $result = mysqli_query($Conn, $SQL) or die("ไม่สามารถเรียกดูข้อมูลได้");

  $chk = mysqli_num_rows($result);
  
  while ($row = mysqli_fetch_array($result)) {
    $tmp_campid=$row["campaign_id"];
    $app_id = $row["id"];
    $AppStatus = $row["incident_status"];
    $campaign_id = $row["campaign_id"];
    $import_id = $row["import_id"];
    $agent_id = $row["agent_id"];
    $calllist_id = $row["calllist_id"];
    $campaign_id = ($tmp_campid)?$tmp_campid:$campaign_id;
  }


  $app = "";
  $newapp = "";
  switch ($campaign_id) {
    case 1:
      $app = "appDetail.php";
      $newapp = "newApp.php";
      break;
    case 7:
      $app = "appDetailD2C.php";
      $newapp = "newAppD2C.php";
      break;
    default:
      $app = "openApplication.php";
      $newapp = "newApplication.php";
  }

  echo "<script>window.location='singaporeApplication.php?campaign_id=$campaign_id&calllist_id=$calllist_id&agent_id=$agent_id&import_id=$import_id&id=$id&formType=ah';</script>";
  // if ($chk > 0) {
  //   //echo  $SQL;
  //   if ((in_array($AppStatus,["Follow-doc","Follow Doc","QC_Reject","Reconfirm-App","Reconfirm"]) && $lv==1) || $lv>1) {
  //     echo "<script>window.location='$app?id=$app_id';</script>";
  //   } else {
  //     echo "<script>alert('ไม่มีสิทธิ์แก้ไข App นี้แล้วจ้า')</script>";
  //   }

  // } else {


  // }
}

?>