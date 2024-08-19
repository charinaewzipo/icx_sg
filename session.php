<?php include "dbconn.php"?>
<?php include "wlog.php"  ?> 
<?php

	
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     	$sql = " SELECT tokenid ".
						" FROM t_session ".
						" WHERE agent_id = ".$_POST['uid']; 
	     	
	     	wlog("session :".$sql);
	     	$result = $dbconn->executeQuery($sql);			
			if($rs=mysqli_fetch_array($result)){   
				$token = $rs['tokenid'];
			}
			
			if( $token != ""){
				if( $token != $_POST['session']){
					$data = array("result"=>"expire");				
				}else{
					$data = array("result"=>"ok");				
				}
			}else{
				$data = array("result"=>"expire");				
			}
			 
		 	$dbconn->dbClose();	 
			 echo json_encode($data);    
 			
	
	

	

 ?>