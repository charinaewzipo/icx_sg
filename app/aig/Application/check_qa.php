<?php
session_start();
include("../../function/StartConnect.inc");

$agent_id = $_SESSION["pfile"]["uid"];
$lv = intval($_SESSION["pfile"]["lv"]);

$campaign_id = $_GET["campaign_id"];
$app_id = $_GET["app_id"];


$SQL = "select app_id from t_aig_qa_answer where campaign_id = '$campaign_id' and app_id = '$app_id' limit 0,1 ";
$result = mysqli_query($Conn, $SQL) or die("ไม่สามารถเรียกดูข้อมูลได้");

$chk = mysqli_num_rows($result);

if ($chk > 0) {

  while ($row = mysqli_fetch_array($result)) {
    $app_id = $row["app_id"];
  }

  //echo  $SQL;
  echo "<script>window.location='QADetail.php?id=$app_id';</script>";
} else {
  if ($lv == 3) {
    echo "<script>window.location='newQA.php?id=$app_id';</script>";
  } else {
    echo "<script>alert('ต้องผ่านการ QC ก่อนถึงใช้งานได้')</script>";
  }
}
