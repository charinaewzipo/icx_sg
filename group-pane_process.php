<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php

   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
	        case "query"  : query(); break;
			case "detail"  : detail(); break;
			case "save"    : save(); break;
			case "delete"  : delete(); break;
			case "check" : check(); break;
 
		 }
	}
	
	function check(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
  			$sql = " SELECT  group_name  ". 
						" FROM  t_group ".
  						" WHERE group_name = ".dbformat( $tmp['gname'])." ".
  						" AND group_id != ".dbNumberFormat( $tmp['gid'])." ";
			  			
			$check = "true";
		    $result = $dbconn->executeQuery($sql);		    
			if($rs=mysqli_fetch_array($result)){   
			 	$check = "false";
			}
		 
		 	$dbconn->dbClose();
		 	$data = array("result"=>$check);	 
			echo json_encode( $data ); 
		
	}
	
	function query(){
		//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
  			$sql = " SELECT group_id , group_name , group_detail ". 
						" FROM  t_group ".
			  			" ORDER BY group_name ";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$data[$count] = array(
						        "gid"  => nullToEmpty($rs['group_id']),
								"gname"  => nullToEmpty($rs['group_name']),
							    "gdetail"  => nullToEmpty($rs['group_detail']),
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

		$dbconn = new dbconn;  
        $dbconn->createConn();
	    $res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
       	$sql = " SELECT group_id , group_name , group_detail ". 
					" FROM  t_group ".
        		    " WHERE group_id =  ".dbNumberFormat($_POST['id'])." ";
      
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$data =  array(
				     		"gid"  => nullToEmpty($rs['group_id']),
							"gname"  => nullToEmpty($rs['group_name']),
						    "gdetail"  => nullToEmpty($rs['group_detail']),
			  				//"member" => getMemeber($rs['position_id'] )
						);   
			   $count++;
			}
 		    if($count==0){
				$data = array("result"=>"empty");
			}  
			
		 //member in this group
		 /*
		 $sql =" SELECT a.agent_id,first_name,last_name,nickname ".
					" FROM  t_agents a  ".
				//	" LEFT OUTER JOIN tl_position p ".
			//		" ON a.position_id = p.position_id ".
					" WHERE a.position_id =   ".dbNumberFormat($_POST['posid'])." ";
					" ORDER BY first_name ";

		 
		// echo "member: ".$sql;
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$member[$count] = array(
						        "aid"  => nullToEmpty($rs['agent_id']),
								"fname"  => nullToEmpty($rs['first_name']),
							    "lname"  => nullToEmpty($rs['last_name']),
							    "nname"  => nullToEmpty($rs['nickname']),
						);   
				$count++;  
			}
		    if($count==0){
			    $member = array("result"=>"empty");
			} 
	     
		 //no member (they are not member )
  		  $sql =" SELECT agent_id,first_name,last_name,nickname ".
					" FROM  t_agents ".
					" WHERE position_id !=".dbNumberFormat($_POST['posid'])." ".
					" ORDER BY first_name ";
  		
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$nomember[$count] = array(
						        "aid"  => nullToEmpty($rs['agent_id']),
								"fname"  => nullToEmpty($rs['first_name']),
							    "lname"  => nullToEmpty($rs['last_name']),
							    "nname"  => nullToEmpty($rs['nickname']),
						);   
				$count++;  
			}
		    if($count==0){
			$nomember = array("result"=>"empty");
			} 
			*/
			$member = "";
			$nomember = "";
			 
		 	$data = array("data"=>$data,"member"=>$member,"nomember"=>$nomember );	
			$dbconn->dbClose();	 
			echo json_encode( $data ); 
			
	
			
	}
	//end query detail
	

    function save(){
	  
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
			 
				$sql = "SELECT group_id FROM t_group WHERE group_id = ".dbformat($tmp['groupid'])." ";
		    
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update   
				
					$sql = "UPDATE t_group SET ".
						        "group_name =".dbformat( $tmp['gname']).",".
							   "group_detail =".dbformat( $tmp['gdetail']).",".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE group_id = ".dbformat( $tmp['groupid'])." ";	
				    
					$dbconn->executeUpdate($sql); 
					 
				}else{
				   //insert
				   $sql = " INSERT INTO t_group( group_name , group_detail ,create_user,create_date ) VALUES ( ".
					   		   " ".dbformat( $tmp['gname'])." ".
							   ",".dbformat( $tmp['gdetail'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
					$dbconn->executeUpdate($sql); 
				}		
			
   			 //update member
   			 /*
		    $arr = json_decode( $_POST['member'] , true); 
    		if( count($arr['member']) !=0 ){
    				if($tmp['posid']!=""){
					 		 foreach( $arr['member'] as $val ){
							  		//then update all member
							   		$sql = "UPDATE t_agents SET position_id = ".dbNumberFormat( $tmp['posid'])." WHERE agent_id = ".$val." ";
							      	$dbconn->executeUPdate($sql);
					 		 }
					  }
    			
			}
			*/
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
				
			$sql = " DELETE FROM t_group WHERE group_id = ".dbNumberFormat( $tmp['groupid'])." ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}

?>