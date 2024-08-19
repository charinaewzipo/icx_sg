<?php 

	if( isset($_GET['ext'])){
		echo "ext :".$_GET['ext']."\r\n";
	}
	
	if( isset($_GET['act'])){
		echo "action:".$_GET['action']."\r\n";
	}

	exit();
?>