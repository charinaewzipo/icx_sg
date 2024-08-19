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
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }

	     $sql = " SELECT s.agent_id, timestamp, a.first_name, a.last_name, dept_name ".
	     			" FROM t_session s LEFT OUTER JOIN t_agents a ON s.agent_id = a.agent_id ".
	     			" LEFT OUTERJOIN t_dept d ON a.dept_id  =  d.dept_id ". 
			  		 " ORDER BY a.first_name,a.last_name ";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$member[$count] = array(
						        "dept"  => nullToEmpty($rs['dept_name']),
								"fname"  => nullToEmpty($rs['first_name']),
							    "lname"  => nullToEmpty($rs['last_name']),
			  					"logint"  => nullToEmpty($rs['timestamp']),			  	
						);   
				$count++;  
			}
		    if($count==0){
			$member = array("result"=>"empty");
			} 
	     
			 //all agents
			 
  			$sql = " SELECT agent_id,first_name,last_name,nickname ". 
						" FROM  t_agents ".
			  			" ORDER BY first_name ";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$all[$count] = array(
						        "aid"  => nullToEmpty($rs['agent_id']),
								"fname"  => nullToEmpty($rs['first_name']),
							    "lname"  => nullToEmpty($rs['last_name']),
							    "nname"  => nullToEmpty($rs['nickname']),
						);   
				$count++;  
			}
		    if($count==0){
			$all = array("result"=>"empty");
			} 
			 
		 	$dbconn->dbClose();	 
		 	$data = array("member"=>$member,"all"=>$all );		 	
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
  		
	        $sql = " SELECT s.agent_id, a.first_name , a.last_name , a.agent_login , s.timestamp ,dept_name".
						" FROM t_session s LEFT OUTER JOIN  t_agents a ON s.agent_id = a.agent_id ".
	        			" LEFT OUTER JOIN tl_dept d ON a.dept_id  =  d.dept_id ". 
			  			" ORDER BY s.timestamp ";
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$data[$count] = array(
					  			"aid"  => nullToEmpty($rs['agent_id']),
								"agent"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
							    "dept"  => nullToEmpty($rs['dept_name']),
			  					"logintime"  => getDatetimeFromDatetime($rs['timestamp']),
						);   
				$count++;  
			}
		    if($count==0){
			$data = array("result"=>"empty");
			} 
			
		
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	
	function getMemeber( $deptid ){
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
	    $res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
     //member in this group
	     $sql =" SELECT a.agent_id,first_name,last_name,nickname ".
					" FROM  t_dept_member m  ".
					" LEFT OUTER JOIN t_agents a  ".
					" ON a.agent_id = m.agent_id ".
					" WHERE m.dept_id =  ".dbNumberFormat($deptid)." ".
					" ORDER BY first_name ";
       
            $count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$member[$count] = array(
						        "conid"  => nullToEmpty($rs['contact_id']),
								"cpname"  => nullToEmpty($rs['con_pre_name']),
							    "cfname"  => nullToEmpty($rs['con_first_name']),
							    "clname"  => nullToEmpty($rs['con_last_name']),
			  					 "cnname"  => nullToEmpty($rs['con_nick_name']),
							  	 "mphone"  => nullToEmpty($rs['con_mobile']),
							  	 "hphone"  => nullToEmpty($rs['con_home_phone']),
							  	 "ophone"  => nullToEmpty($rs['con_office_phone']),
							  	 "fax"  => nullToEmpty($rs['con_fax_number']),
							  	 "email"  => nullToEmpty($rs['con_email']),
							  	 "org"  => nullToEmpty($rs['con_org_name']),
			  					 "title"  => nullToEmpty($rs['con_job_title']),
			  					 "dob"  => nullToEmpty($rs['con_date_of_birth']),
			  					 "cleads"  => nullToEmpty($rs['con_lead_source']),
			  		 			 "caddr"  => nullToEmpty($rs['con_addr']),
						);   
			   $count++;
			}
 		    if($count==0){
				$data = array("result"=>"empty");
			}  
       
       return  $member;
		
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
	     
  		  $sql = " SELECT dept_id,dept_name,role_desc ".
					  " FROM tl_dept ".
        		       " WHERE dept_id =  ".dbNumberFormat($_POST['id'])." ";
    
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$data =  array(
			  	      			"did"  => nullToEmpty($rs['dept_id']),
								"dname"  => nullToEmpty($rs['dept_name']),
							    "ddesc"  => nullToEmpty($rs['role_desc']),
						);   
			   $count++;
			}
 		    if($count==0){
				$data = array("result"=>"empty");
			}  

		    $data = array("data"=>$data );	
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
			
				$sql = "SELECT dept_id FROM tl_dept WHERE dept_id = ".dbNumberFormat($tmp["did"])." ";
wlog($sql);
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update   
					$sql = "UPDATE tl_dept SET ".
						        "dept_name =".dbformat( $tmp['dname']).",".
							    "role_desc =".dbformat( $tmp['ddesc']).",".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE dept_id = ".dbNumberFormat( $tmp['did'])." ";	
wlog("update ".$sql);
					$dbconn->executeUpdate($sql); 
					 
				}else{

				   //insert
				   $sql = " INSERT INTO tl_dept(  dept_name,role_desc,create_user,create_date  ) VALUES ( ".
				      		   " ".dbformat( $tmp['dname'])." ".
							   ",".dbformat( $tmp['ddesc'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
wlog("insert ".$sql);		
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
				
			$sql = " DELETE FROM tl_dept WHERE dept_id IN (".dbNumberFormat( $tmp['did']).") ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	


?>
