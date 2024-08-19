<?php
require_once($_SERVER['DOCUMENT_ROOT']."/class/OutboundGenesys.php");

if (isset($_GET['action'])) {
	switch ($_GET['action']) {

		case "testrecording":
			postBatchRecording();
				break; // Secure Pause
	}
}

function postBatchRecording(){
	$tmp_val = (object) [
		"batchDownloadRequestList" => array((object) [
			"conversationId"=>"cf30a5ea-2422-4851-9467-b7d73b302069"
		],(object) [
			"conversationId"=>"4deb181c-492c-40c6-bafd-283c9e132d85"
		])
	];
	$gene = new OutboundGenesys();
	$result = $gene->postBatchRecording($tmp_val);
	var_dump($result);
}

?>