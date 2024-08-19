<?php

ob_start();
//session_start();


include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

$currentdatetime = date("Y") . '-' . date("m") . '-' . date("d") . ' ' . date("H:i:s");

function CovNum2($Data)
{
	return number_format($Data, 2, '.', '');  /// COV 123456.123456 --> 123456.12
}

$app_id = $_POST["app_id"];
$agent_id = $_POST["agent_id"];
$form_id = $_POST["form_id"];
$remark = $_POST["remark"];
$reconfirm = $_POST["reconfirm"];
$feedback = $_POST["feedback"];
$comment = $_POST["comment"];
$QAStatus = $_POST["QAStatus"];
$campaign_id = $_POST["campaign_id"];
$talk_time = $_POST["talk_time"];
$qc_score = $_POST["qc_score"];

$col_id = 1;

$answer1 =  $_POST['answer1'];
$answer2 =  $_POST['answer2'];
$answer3 =  $_POST['answer3'];
$answer4 =  $_POST['answer4'];
$answer5 =  $_POST['answer5'];
$answer6 =  $_POST['answer6'];
$answer7 =  $_POST['answer7'];
$answer8 =  $_POST['answer8'];
$answer9 =  $_POST['answer9'];
$answer10 =  $_POST['answer10'];
$answer11 =  $_POST['answer11'];
$answer12 =  $_POST['answer12'];
$answer13 =  $_POST['answer13'];
$answer14 =  $_POST['answer14'];
$answer15 =  $_POST['answer15'];
$answer16 =  $_POST['answer16'];
$answer17 =  $_POST['answer17'];
$answer18 =  $_POST['answer18'];
$answer19 =  $_POST['answer19'];
$answer20 =  $_POST['answer20'];
$answer21 =  $_POST['answer21'];
$answer22 =  $_POST['answer22'];
$answer23 =  $_POST['answer23'];
$answer24 =  $_POST['answer24'];
$answer25 =  $_POST['answer25'];
$answer26 =  $_POST['answer26'];
$answer27 =  $_POST['answer27'];
$answer28 =  $_POST['answer28'];
$answer29 =  $_POST['answer29'];
$answer30 =  $_POST['answer30'];
$answer31 =  $_POST['answer31'];
$answer32 =  $_POST['answer32'];
$answer33 =  $_POST['answer33'];
$answer34 =  $_POST['answer34'];
$answer35 =  $_POST['answer35'];
$answer36 =  $_POST['answer36'];
$answer37 =  $_POST['answer37'];
$answer38 =  $_POST['answer38'];
$answer39 =  $_POST['answer39'];
$answer40 =  $_POST['answer40'];
$answer41 =  $_POST['answer41'];
$answer42 =  $_POST['answer42'];
$answer43 =  $_POST['answer43'];
$answer44 =  $_POST['answer44'];
$answer45 =  $_POST['answer45'];


/*Insert YersFile*/
$SQL_YesFile = "INSERT INTO t_aig_qa_non_sale_answer ( 
app_id,
col_id,
form_id,

answer1,
answer2,
answer3,
answer4,
answer5,
answer6,
answer7,
answer8,
answer9,
answer10,
answer11,
answer12,
answer13,
answer14,
answer15,
answer16,
answer17,
answer18,
answer19,
answer20,
answer21,
answer22,
answer23,
answer24,
answer25,
answer26,
answer27,
answer28,
answer29,
answer30,
answer31,

talk_time,
remark,
reconfirm,
feedback,
comment,
QAStatus,
campaign_id,
create_by,
create_date,
update_by,
update_date,
score

 )

 VALUES(

'$app_id' ,
'$col_id' ,
'$form_id' ,

'$answer1' ,
'$answer2' ,
'$answer3' ,
'$answer4' ,
'$answer5' ,
'$answer6' ,
'$answer7' ,
'$answer8' ,
'$answer9' ,
'$answer10' ,
'$answer11' ,
'$answer12' ,
'$answer13' ,
'$answer14' ,
'$answer15' ,
'$answer16' ,
'$answer17' ,
'$answer18' ,
'$answer19' ,
'$answer20' ,
'$answer21' ,
'$answer22' ,
'$answer23' ,
'$answer24' ,
'$answer25' ,
'$answer26' ,
'$answer27' ,
'$answer28' ,
'$answer29' ,
'$answer30' ,
'$answer31' ,

'$talk_time',
'" . mysqli_escape_string($Conn, $remark) . "' ,
'" . mysqli_escape_string($Conn, $reconfirm) . "' ,
'" . mysqli_escape_string($Conn, $feedback) . "' ,
'" . mysqli_escape_string($Conn, $comment) . "' ,
'$QAStatus' ,
'$campaign_id' ,
'$agent_id' ,
'$currentdatetime' ,
'$agent_id' ,
'$currentdatetime',
'$qc_score'


 )";


if (mysqli_query($Conn, $SQL_YesFile)) {
	// $id = mysqli_insert_id();		
	echo "<script>alert('Save Complete.');window.location='QADetail_nonsale.php?id=$app_id';</script>";
} else {
	echo $SQL_YesFile;
}
