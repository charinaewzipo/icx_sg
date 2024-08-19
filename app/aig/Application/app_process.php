<?php
require_once($_SERVER['DOCUMENT_ROOT']."/class/OutboundGenesys.php");
require_once("../../../wlog.php");

if (isset($_POST['action'])) {
	switch ($_POST['action']) {

		case "geneRecordingState":
			geneRecordingState();
			break; // Secure Pause
	}
}
function geneRecordingState(){
	$state = isset($_POST['state'])?$_POST['state']:"ACTIVE"; 
	$agentid = isset($_POST['agentid'])?$_POST['agentid']:""; 
	$lastInteraction = isset($_POST['lastInteraction'])?$_POST['lastInteraction']:""; 
	$voiceid = isset($_POST['voiceid'])?$_POST['voiceid']:""; 
	wlog("[application][genesys-securepause] state:$state agentid:$agentid lastinteraction:$lastInteraction voiceid:$voiceid");
	if(!$lastInteraction && !$voiceid){
		$result = array("result"=>false,"data"=>"Invalid variable");
	} else {
		$convsersationId = ($voiceid)?$voiceid:$lastInteraction;
		$gene = new OutboundGenesys();
		$result = array("result"=>true,"data"=>$gene->RecordingState($convsersationId,$state));
		
	}
	echo json_encode( $result ); 

}

?>