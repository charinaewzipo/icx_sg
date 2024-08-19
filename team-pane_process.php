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
	
	function init(){
			//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //query group
  			$sql = " SELECT group_id , group_name  ". 
						" FROM  t_group ".
			  			" ORDER BY group_name ";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1[$count] = array(
						        "id"  => nullToEmpty($rs['group_id']),
								"value"  => nullToEmpty($rs['group_name']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp1 = array("result"=>"empty");
			} 
			
			//query team
			/*
			$sql = " SELECT team_id , team_name ". 
						" FROM  t_team ".
			  			" ORDER BY team_name ";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp2[$count] = array(
						        "id"  => nullToEmpty($rs['team_id']),
								"value"  => nullToEmpty($rs['team_name']),
							  
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
			*/
			$tmp2 = "";
			$data = array("group"=>$tmp1,"team"=>$tmp2);
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
		
	}
	
	function query(){
		//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
  			$sql = " SELECT team_id , team_name , team_detail , group_name ". 
						" FROM  t_team t LEFT OUTER JOIN t_group g  ".
  						" ON t.group_id = g.group_id ".
			  			" ORDER BY team_name ";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$data[$count] = array(
						        "tid"  => nullToEmpty($rs['team_id']),
								"tname"  => nullToEmpty($rs['team_name']),
			  					"tdetail"  => nullToEmpty($rs['team_detail']),
							    "gname"  => nullToEmpty($rs['group_name']),
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
	     
    	$sql = " SELECT team_id , team_name , team_detail , t.group_id as group_id ". 
						" FROM  t_team t LEFT OUTER JOIN t_group g  ".
  						" ON t.group_id = g.group_id ".
        		  	  " WHERE team_id =  ".dbNumberFormat($_POST['id'])." ";
      
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$data =  array(
				     	     "tid"  => nullToEmpty($rs['team_id']),
							"tname"  => nullToEmpty($rs['team_name']),
		  					"tdetail"  => nullToEmpty($rs['team_detail']),
						    "gid"  => nullToEmpty($rs['group_id']),
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
			 
				$sql = "SELECT team_id FROM t_team WHERE team_id = ".dbformat($tmp['teamid'])." ";
		    
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update   
				
					$sql = "UPDATE t_team SET ".
						        "team_name =".dbformat( $tmp['tname']).",".
							   "team_detail =".dbformat( $tmp['tdetail']).",".	
							   "group_id =".dbNumberFormat( $tmp['tgid']).",".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE team_id = ".dbformat( $tmp['teamid'])." ";	
				    
					$dbconn->executeUpdate($sql); 
					 
				}else{
				   //insert
				   $sql = " INSERT INTO t_team( team_name , team_detail , group_id , create_user,create_date ) VALUES ( ".
					   		   " ".dbformat( $tmp['tname'])." ".
							   ",".dbformat( $tmp['tdetail'])." ".
				      			",".dbNumberFormat( $tmp['tgid'])." ".
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
				
			$sql = " DELETE FROM t_team WHERE team_id = ".dbNumberFormat( $tmp['teamid'])." ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}

?>