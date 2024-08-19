<?php
include("../../function/StartConnect.inc");

$campaign_id = $_GET["campaign_id"];
$app_id = $_GET["app_id"];


$SQL = "select id from t_aig_qa_answer where campaign_id = '$campaign_id' and app_id = '$app_id' ";
$result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");

$chk = mysql_num_rows($result);

if ($chk > 0) {

  while($row = mysql_fetch_array($result))
  {
    $qa_id = $row["id"];
  }

//echo  $SQL;
 echo "<script>window.location='QADetail.php?id=$qa_id';</script>";

}else{

  echo "<script>window.location='newQA.php?id=$app_id';</script>";

}

?>