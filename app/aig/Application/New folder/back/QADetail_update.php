<?php

ob_start();
session_start();

$lv = $_SESSION["pfile"]["lv"];


include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

$currentdatetime = date("Y").'-'.date("m").'-'.date("d").' '.date("H:i:s");




$qa_id = $_POST["qa_id"];
$agent_id = $_POST["agent_id"];
$remark = $_POST["remark"];
$reconfirm = $_POST["reconfirm"];
$feedback = $_POST["feedback"];
$comment = $_POST["comment"];
$QAStatus = $_POST["QAStatus"];


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

if($lv ==3){
 /*Insert YersFile*/
$SQL_YesFile = "update t_aig_qa_answer set

answer1 = '$answer1' ,
answer2 = '$answer2' ,
answer3 = '$answer3' ,
answer4 = '$answer4' ,
answer5 = '$answer5' ,
answer6 = '$answer6' ,
answer7 = '$answer7' ,
answer8 = '$answer8' ,
answer9 = '$answer9' ,
answer10 = '$answer10' ,
answer11 = '$answer11' ,
answer12 = '$answer12' ,
answer13 = '$answer13' ,
answer14 = '$answer14' ,
answer15 = '$answer15' ,
answer16 = '$answer16' ,
answer17 = '$answer17' ,
answer18 = '$answer18' ,
answer19 = '$answer19' ,
answer20 = '$answer20' ,
answer21 = '$answer21' ,
answer22 = '$answer22' ,
answer23 = '$answer23' ,
answer24 = '$answer24' ,
answer25 = '$answer25' ,
answer26 = '$answer26' ,
answer27 = '$answer27' ,
answer28 = '$answer28' ,
answer29 = '$answer29' ,
answer30 = '$answer30' ,
answer31 = '$answer31' ,
answer32 = '$answer32' ,
answer33 = '$answer33' ,
answer34 = '$answer34' ,
answer35 = '$answer35' ,
answer36 = '$answer36' ,
answer37 = '$answer37' ,
answer38 = '$answer38' ,
answer39 = '$answer39' ,
answer40 = '$answer40' ,
answer41 = '$answer41' ,
answer42 = '$answer42' ,
answer43 = '$answer43' ,
answer44 = '$answer44' ,
answer45 = '$answer45' ,

remark = '".mysql_escape_string($remark)."' ,
reconfirm = '".mysql_escape_string($reconfirm)."' ,
feedback = '".mysql_escape_string($feedback)."' ,
comment = '".mysql_escape_string($comment)."' ,
QAStatus = '$QAStatus' ,
update_by = '$agent_id' ,
update_date = '$currentdatetime' 

where id = '$qa_id' ";
} else {
	$SQL_YesFile = "update t_aig_qa_answer set
QAStatus = '$QAStatus' ,
update_by = '$agent_id' ,
update_date = '$currentdatetime' 
where id = '$qa_id' ";
}

if(mysql_query($SQL_YesFile,$Conn))
{	
		echo "<script>alert('Save Complete.');window.location='QADetail.php?id=$qa_id';</script>";
	
}
else
{
	echo $SQL_YesFile ;
}

?>
