<?php include "dbconn.php"?>
<?php include "util.php"  ?>
<?php include "wlog.php"  ?> 
<?php

	    $dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	      $sql = "TRUNCATE t_call_trans ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_call_trans success <br/>";
	     } 
	     
	     $sql = "TRUNCATE t_calllist ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_calllist success <br/>";
	     } 
	     
	     $sql = "TRUNCATE t_calllist_agent ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_calllist_agent success <br/>";
	     } 
	     
	     $sql = "TRUNCATE t_import_list ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_import_list success <br/>";
	     } 
	     
	     $sql = "TRUNCATE t_import_list_field ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_import_list_field success <br/>";
	     } 
	     
	     
	     $sql = "TRUNCATE t_list_field ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_list_field success <br/>";
	     } 
	     
	    $sql = "TRUNCATE t_campaign_list ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_campaign_list success <br/>";
	     } 
	     
	     
	     
	     $sql = "TRUNCATE t_ticket ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_ticket success <br/>";
	     } 
	     
	        $sql = "TRUNCATE t_ticket_export_history ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_ticket_export_history success <br/>";
	     } 
	     
	     $sql = "TRUNCATE t_ticket_history ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_ticket_history success <br/>";
	     } 
	     
	        $sql = "TRUNCATE t_ticket_comment ";
	     $result = $dbconn->executeUpdate($sql);
	     if( $result == 1){
	     	echo "truncate t_ticket_comment success <br/>";
	     } 


?>