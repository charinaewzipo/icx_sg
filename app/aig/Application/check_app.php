<?php
session_start();
require_once("../../function/StartConnect.inc");
require_once("../../../wlog.php");

$agent_id = $_SESSION["pfile"]["uid"];
$lv = intval($_SESSION["pfile"]["lv"]);



$campaign_id = ($_GET["campaign_id"]) ? intval($_GET["campaign_id"]) : "";
$calllist_id = ($_GET["calllist_id"]) ? intval($_GET["calllist_id"]) : "";
$import_id = ($_GET["import_id"]) ? intval($_GET["import_id"]) : "";
$agent_id_self = ($_GET["agent_id"]) ? intval($_GET["agent_id"]) : "";

$id = ($_GET["id"]) ? intval($_GET["id"]) : "";
$newapplication = ($_GET["newapplication"]) ? intval($_GET["newapplication"]) : "";

if (($campaign_id && $import_id && $agent_id_self && $calllist_id) || $id) {


  $SQL = "";
  if ($id) {
    $SQL = "select * from t_aig_app where id = '$id'";
  } else {
    // $SQL = "select  tapp.id,tapp.calllist_id,tapp.agent_id,tapp.campaign_id,tcam.cp_type,tapp.import_id from t_aig_app tapp inner join t_campaign tcam on tcam.campaign_id=tapp.campaign_id where campaign_id = '$campaign_id' and  calllist_id = '$calllist_id' and import_id = '$import_id' limit 1 ";
    $SQL = "select * from t_aig_app where campaign_id = '$campaign_id' and  calllist_id = '$calllist_id' and import_id = '$import_id' limit 1 ";
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
  $agent_id_uid = ($agent_id_self) ? $agent_id_self : $agent_id;
  $SQL2 = "SELECT cp_type FROM t_campaign WHERE campaign_id = '$campaign_id'";
  wlog($SQL2);
  $result2 = mysqli_query($Conn, $SQL2) or die("ไม่สามารถเรียกดูข้อมูลแคมเปญได้");

  $cp_type = "";
  if ($row2 = mysqli_fetch_array($result2)) {
    $cp_type = $row2["cp_type"];
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

  if($newapplication){
    echo "<script>window.location='singaporeApplication.php?campaign_id=$campaign_id&calllist_id=$calllist_id&agent_id=$agent_id_uid&import_id=$import_id&id=&formType=$cp_type';</script>";
  }else{
    echo "<script>window.location='singaporeApplication.php?campaign_id=$campaign_id&calllist_id=$calllist_id&agent_id=$agent_id_uid&import_id=$import_id&id=$app_id&formType=$cp_type';</script>";
  }
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