<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php


   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
            case "init" : init(); break; 
	        case "query"  : query(); break;
			case "detail"  : detail(); break;
			case "save"    : save(); break;
			case "delete"  : delete(); break;
			
 	   	    
		 }
	}
	
	function query(){
		//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
  			$sql = " SELECT script_id , script_name , script_detail ". 
						" FROM t_callscript ".
						" ORDER BY script_name ";
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			
			  	$data[$count] = array(
						        "scriptid"  => nullToEmpty($rs['script_id']),
								"sname"  => nullToEmpty($rs['script_name']),
							    "sdetail"  => nullToEmpty($rs['script_detail']),
						);   
				$count++;  
			}
		    if($count==0){
			$data = array("result"=>"empty");
			} 
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	
	function detail(){
		//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
  			$sql = " SELECT script_id , script_name , script_detail ". 
						" FROM t_callscript ".
  						" WHERE script_id = ".dbNumberFormat( $_POST['id'] )." ";
					
			$count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			
			  	$tmp1 = array(
						        "scriptid"  => nullToEmpty($rs['script_id']),
								"sname"  => nullToEmpty($rs['script_name']),
							    "sdetail"  => nullToEmpty($rs['script_detail']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			 
			$data = array("data"=>$tmp1);
		
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	
	 function save(){
	  
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
				$sql = " SELECT script_id FROM t_callscript WHERE script_id = ".dbNumberFormat( $tmp['scriptid'] );
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
			
				   //update   
					$sql = " UPDATE t_callscript SET ".
						        " script_name =".dbformat( $tmp['sname']).",".
							    " script_detail =".dbformat( $tmp['sdetail']).",".	
							    " update_date =NOW(),".
							    " update_user =".dbformat( $tmp['uid'])." ".
							    " WHERE script_id = ".dbformat( $tmp['scriptid'])." ";	
					$dbconn->executeUpdate($sql); 
					 
				}else{
				   //insert
				   $sql = " INSERT INTO t_callscript( script_name,script_detail,create_user, create_date ) VALUES ( ".
					   		   " ".dbformat( $tmp['sname'])." ".
							   ",".dbformat( $tmp['sdetail'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
					$dbconn->executeUpdate($sql); 
				}		
			
   			
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
	  
	}
	
		function delete(){

	        $tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
				
			$sql = " DELETE FROM t_callscript WHERE script_id = ".dbNumberFormat( $tmp['scriptid'])." ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	