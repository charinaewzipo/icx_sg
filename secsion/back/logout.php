<?php 
 session_start(); 
 session_destroy();
?>
<?php include "dbconn.php"?>
<?php include "util.php"  ?>
<?php include "wlog.php"  ?>  
<?php 

 		if( !isset( $_GET['logout'])){
 	
		  		$uid =  $_SESSION["uid"]; 
				$dbconn = new dbconn;  
		        $dbconn->createConn();
		        
		         $sql = "INSERT INTO t_login_history ( agent_id , datetime , type ) VALUES (  ".dbNumberFormat($uid)." , NOW() , 'logout' ) ";
				 $dbconn->executeUpdate($sql);
				 
				$sql = "DELETE FROM t_session WHERE agent_id = ".dbNumberFormat($uid);
		        $dbconn->executeUpdate($sql);
		        
		        
		         //agent log report
		        $sql = " SELECT rowid FROM t_agent_log ".
		        			" WHERE agent_id = ".dbNumberFormat($uid)." ".
		        			" AND login_dt IS NOT NULL ".
		        			" ORDER BY rowid DESC ".
							" LIMIT 0,1 ";
		         
		     	$result = $dbconn->executeQuery($sql);
					if($rs=mysql_fetch_array($result)){   
					$sql = " UPDATE t_agent_log SET ".
			        			" logout_dt = NOW() ".
			        			" WHERE rowid = ".$rs['rowid'];
					    		$dbconn->executeUpdate($sql);
					}
		     
		        $dbconn->dbClose();
 		}
  		$complete = "true";
?>
<?php if ($complete=="true"){ ?>
<script type="text/javascript">
	window.location="index.php";
</script>
<?php } ?>


