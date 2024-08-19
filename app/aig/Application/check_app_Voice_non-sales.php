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

if ($campaign_id == 3 && $calllist_id) {
  $SQL = "SELECT ConfirmID FROM t_calllist WHERE import_id = 3 AND calllist_id = $calllist_id";
  $result = mysqli_query($Conn, $SQL) or die("ไม่สามารถเรียกดูข้อมูลได้");
  while ($row = mysqli_fetch_array($result)) {
    $ConfirmID = $row["ConfirmID"];
  }
  $ConfirmIDs = explode('|', $ConfirmID);
  $app_id = $ConfirmIDs[0];
  echo "<script>window.location='openApplication.php?id=$app_id';</script>";
} else if (($campaign_id && $import_id && $agent_id && $calllist_id) || $id) {
  $SQL = "";
  if ($id) {
    $SQL = "select id,AppStatus,campaign_id from t_aig_app where id = '$id'";
  } else {
    $SQL = "select id,AppStatus,campaign_id from t_aig_app where campaign_id = '$campaign_id' and  calllist_id = '$calllist_id' and import_id = '$import_id' limit 1 ";
  }
  // wlog($SQL);
  $result = mysqli_query($Conn, $SQL) or die("ไม่สามารถเรียกดูข้อมูลได้");

  $chk = mysqli_num_rows($result);

  while ($row = mysqli_fetch_array($result)) {
    $tmp_campid = $row["campaign_id"];
    $app_id = $row["id"];
    $AppStatus = $row["AppStatus"];
    $campaign_id = ($tmp_campid) ? $tmp_campid : $campaign_id;
  }

  $app = "";
  $newapp = "";
  switch ($campaign_id) {
    case 1:
      $app = "appDetail_Voice_non-sales.php";
      $newapp = "newApp.php";
      break;
    default:
      $app = "openApplication_Voice_non-sales.php";
      $newapp = "newApplication.php";
  }

  if ($chk > 0) {
    //echo  $SQL;
    if ((in_array($AppStatus, ["Follow-doc", "Follow Doc", "QC_Reject", "Reconfirm-App", "Reconfirm"]) && $lv == 1) || $lv > 1) {
      echo "<script>window.location='$app?id=$app_id';</script>";
    } else {
      echo "<script>alert('ไม่มีสิทธิ์แก้ไข App นี้แล้ว')</script>";
    }
  } else {

    echo "<script>window.location='$newapp?campaign_id=$campaign_id&calllist_id=$calllist_id&agent_id=$agent_id&import_id=$import_id';</script>";
  }
}
