<?php

ob_start();
session_start();

$lv = $_SESSION["pfile"]["lv"];


include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

$currentdatetime = date("Y").'-'.date("m").'-'.date("d").' '.date("H:i:s");




$app_id = $_POST["app_id"];
$agent_id = $_POST["agent_id"];
$remark = $_POST["remark"];
$reconfirm = $_POST["reconfirm"];
$form_id = $_POST["form_id"];
$feedback = $_POST["feedback"];
$comment = $_POST["comment"];
$QAStatus = $_POST["QAStatus"];
$campaign_id = $_POST["campaign_id"];

$col_id=($lv ==3)?1:2;
$answer_value = ($lv ==3)?"answer":"qaanswer";


$answer1 =  $_POST[$answer_value.'1'];
$answer2 =  $_POST[$answer_value.'2'];
$answer3 =  $_POST[$answer_value.'3'];
$answer4 =  $_POST[$answer_value.'4'];
$answer5 =  $_POST[$answer_value.'5'];
$answer6 =  $_POST[$answer_value.'6'];
$answer7 =  $_POST[$answer_value.'7'];
$answer8 =  $_POST[$answer_value.'8'];
$answer9 =  $_POST[$answer_value.'9'];
$answer10 =  $_POST[$answer_value.'10'];
$answer11 =  $_POST[$answer_value.'11'];
$answer12 =  $_POST[$answer_value.'12'];
$answer13 =  $_POST[$answer_value.'13'];
$answer14 =  $_POST[$answer_value.'14'];
$answer15 =  $_POST[$answer_value.'15'];
$answer16 =  $_POST[$answer_value.'16'];
$answer17 =  $_POST[$answer_value.'17'];
$answer18 =  $_POST[$answer_value.'18'];
$answer19 =  $_POST[$answer_value.'19'];
$answer20 =  $_POST[$answer_value.'20'];
$answer21 =  $_POST[$answer_value.'21'];
$answer22 =  $_POST[$answer_value.'22'];
$answer23 =  $_POST[$answer_value.'23'];
$answer24 =  $_POST[$answer_value.'24'];
$answer25 =  $_POST[$answer_value.'25'];
$answer26 =  $_POST[$answer_value.'26'];
$answer27 =  $_POST[$answer_value.'27'];
$answer28 =  $_POST[$answer_value.'28'];
$answer29 =  $_POST[$answer_value.'29'];
$answer30 =  $_POST[$answer_value.'30'];
$answer31 =  $_POST[$answer_value.'31'];
$answer32 =  $_POST[$answer_value.'32'];
$answer33 =  $_POST[$answer_value.'33'];
$answer34 =  $_POST[$answer_value.'34'];
$answer35 =  $_POST[$answer_value.'35'];
$answer36 =  $_POST[$answer_value.'36'];
$answer37 =  $_POST[$answer_value.'37'];
$answer38 =  $_POST[$answer_value.'38'];
$answer39 =  $_POST[$answer_value.'39'];
$answer40 =  $_POST[$answer_value.'40'];
$answer41 =  $_POST[$answer_value.'41'];
$answer42 =  $_POST[$answer_value.'42'];
$answer43 =  $_POST[$answer_value.'43'];
$answer44 =  $_POST[$answer_value.'44'];
$answer45 =  $_POST[$answer_value.'45'];

if(in_array($lv,[3,7])){

	if($lv == 3){

		$SQL_YesFile = "INSERT INTO t_aig_qa_answer ( 
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
			
			remark,
			reconfirm,
			feedback,
			comment,
			QAStatus,
			campaign_id,
			create_by,
			create_date,
			update_by,
			update_date
			
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
			
			'".mysql_escape_string($remark)."' ,
			'".mysql_escape_string($reconfirm)."' ,
			'".mysql_escape_string($feedback)."' ,
			'".mysql_escape_string($comment)."' ,
			'$QAStatus' ,
			'$campaign_id' ,
			'$agent_id' ,
			'$currentdatetime' ,
			'$agent_id' ,
			'$currentdatetime' 
			) ON DUPLICATE KEY UPDATE

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

			remark = '".mysql_escape_string($remark)."' ,
			reconfirm = '".mysql_escape_string($reconfirm)."' ,
			feedback = '".mysql_escape_string($feedback)."' ,
			comment = '".mysql_escape_string($comment)."' ,
			QAStatus = '$QAStatus' ,
			update_by = '$agent_id' ,
			update_date = '$currentdatetime'";


	} elseif($lv == 7) {

		$SQL_YesFile = "INSERT INTO t_aig_qa_answer ( 
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
			campaign_id,
			create_by,
			create_date,
			update_by,
			update_date
			
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
			'$campaign_id' ,
			'$agent_id' ,
			'$currentdatetime' ,
			'$agent_id' ,
			'$currentdatetime' 
			) ON DUPLICATE KEY UPDATE

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
			update_by = '$agent_id' ,
			update_date = '$currentdatetime'";

			mysql_query($SQL_YesFile,$Conn);

			$SQL_YesFile = "update t_aig_qa_answer set
			QAStatus = '$QAStatus' ,
			update_by = '$agent_id' ,
			update_date = '$currentdatetime' 
			where app_id = '$app_id'  and col_id=1";
	}
}
// } else {
// 	$SQL_YesFile = "update t_aig_qa_answer set
// QAStatus = '$QAStatus' ,
// update_by = '$agent_id' ,
// update_date = '$currentdatetime' 
// where app_id = '$app_id'  and col_id=1";
// }

if(mysql_query($SQL_YesFile,$Conn))
{	
		echo "<script>alert('Save Complete.');window.location='QADetail.php?id=$app_id';</script>";
	
}
else
{
	echo $SQL_YesFile ;
}

?>
