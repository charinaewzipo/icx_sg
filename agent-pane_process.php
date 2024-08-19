<?php session_start(); ?>
<?php include "wlog.php"?>
<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php


 
   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
            case "init" : init(); break;
	        case "query"  : query(); break;
	        case "queryteam" : query_team(); break;
			case "detail"  : detail(); break;
			case "save"    : save(); break;
			case "delete"  : delete(); break;
			
			case "check"  : check(); break;
 	        case "lock"     : takeaction(); break;
 	   	    case "unlock" : takeaction(); break;
 	   	    
		 }
	}
	
	 function query_team(){
	 	
	 	$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	         //query team by group
			$sql = " SELECT team_id , team_name ". 
						" FROM  t_team ";
			if( $_POST['gid'] != "" ){
				$sql = $sql." WHERE group_id = ".dbNumberFormat($_POST['gid'])." ";
			}
						" ORDER BY team_name ";
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1[$count] = array(
						        "id"  => nullToEmpty($rs['team_id']),
								"value"  => nullToEmpty($rs['team_name']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			
			$data = array("team"=>$tmp1);
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
			
	 	
	 }
	
		function init(){
		//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
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

			//query role
			$sql = " SELECT role_seq, role_name, role_label, role_lv ".
			"FROM tl_role WHERE `status` = 1 ORDER BY role_seq ";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp3[$count] = array(
						        "lv"  => nullToEmpty($rs['role_lv']),
								"label"  => nullToEmpty($rs['role_label']),
								"name"  => nullToEmpty($rs['role_name']),
								"seq"  => nullToEmpty($rs['role_seq'])
							  
						);   
				$count++;  
			}
		    if($count==0){
				$tmp3 = array("result"=>"empty");
			} 
			
			$data = array("group"=>$tmp1,"team"=>$tmp2,"role"=>$tmp3);
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	
	function query(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
  			$sql = " SELECT agent_id, agent_login, first_name , last_name, first_name_th, last_name_th , genesysid, nickname, img_path, is_active, lv.role_label , a.group_id , group_name, a.team_id , team_name, last_login_dt ".
						" FROM  t_agents a ".
						" LEFT OUTER JOIN tl_role lv ON a.level_id = lv.role_lv ".
  						" LEFT OUTER JOIN t_group g ON a.group_id = g.group_id ".
  						" LEFT OUTER JOIN t_team t ON t.team_id = a.team_id ".
  						" WHERE agent_id IS NOT NULL ";
  			
		    //if level is agent where current agent id
			if(  $_SESSION['pfile']['lv'] == 2){
						 $sql = $sql." AND a.team_id = ( SELECT team_id FROM t_agents WHERE agent_id = ".dbNumberFormat( $tmp['uid'])." ) ";
			 }
			 if( $_SESSION['pfile']['lv'] == 3){
			 			$sql = $sql." AND a.group_id = ( SELECT group_id FROM t_agents WHERE agent_id = ".dbNumberFormat( $tmp['uid'])." ) ";
			 }
			 
			 if( $tmp['search_name'] != ""){
			 			$sql = $sql." AND CONCAT( first_name,last_name)  LIKE REPLACE('%".$tmp['search_name']."%',' ','%')";
  			}
  			
  			if( $tmp['search_group'] != "" ){
			 			$sql = $sql." AND a.group_id = ".dbNumberFormat( $tmp['search_group']);
  			}
			 	
			if( $tmp['search_team'] != ""){
			 			$sql = $sql." AND a.team_id = ".dbNumberFormat( $tmp['search_team']);
  			}
			
			 $sql = $sql." ORDER BY a.team_id , first_name  ";
			 
			 wlog( $sql );
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
				
				// switch($rs['level_id']){
				// 	case 1 : $level = "Agent"; break;
				// 	case 2 : $level = "Supervisor"; break;
				// 	case 3 : $level = "QC/QA"; break;
				// 	case 4 : $level = "Manager"; break;
				// 	case 5 : $level = "Project manager"; break;
				// 	case 6 : $level = "Administrator"; break;				
				// 	default : $level = "";
				// }
				
				switch($rs['is_active']){
					case 1 : $status = "Active"; break;
					case 0 : $status = "Locked"; break;
					case 5 : $status = "Disabled"; break;
					default : $status = "";
				}
			  	$data[$count] = array(
						        "agentid"  => nullToEmpty($rs['agent_id']),
								"fname"  => nullToEmpty($rs['first_name']),
							    "lname"  => nullToEmpty($rs['last_name']),
								"fname_th"  => nullToEmpty($rs['first_name_th']),
							    "lname_th"  => nullToEmpty($rs['last_name_th']),
							    "genesysid"  => nullToEmpty($rs['genesysid']),
							    "nickname"  => nullToEmpty($rs['nickname']),
			  	  				"imgpath"  => nullToEmpty($rs['img_path']),
			  					"login" => nullToEmpty($rs['agent_login']),			  	
			  					"gid" => nullToEmpty( $rs['group_id']),
			  					"tid" => nullToEmpty( $rs['team_id']),
								"groupname"  => nullToEmpty($rs['group_name']),
								"teamname"  => nullToEmpty($rs['team_name']),
								"level"  => nullToEmpty( $rs['role_label'] ),
			  					"accStatus" => nullToEmpty($status), 
			  					"status" => nullToEmpty($rs['is_active']), 
			  					"lastlogin" => nullToEmpty( dateTimeThai($rs['last_login_dt'])), 
			  					"isonline"=>nullToEmpty(isonline( $rs['agent_id'] ))
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
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     
        $sql =" SELECT agent_id,first_name,last_name,first_name_th,last_name_th,genesysid,nickname,mobile_phone ,is_active, a.group_id , a.team_id,email,level_id,agent_login, ".
        		   " sales_agent_code,sales_agent_name,sales_license_code,sales_license_name".
        		   " FROM t_agents a ".
        		   " LEFT OUTER JOIN t_group g ON a.group_id = g.group_id ".
        		   " LEFT OUTER JOIN t_team t ON a.team_id = t.team_id ".
        		   " WHERE agent_id =  ".dbNumberFormat($_POST['id'])." ";
  
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$data =  array(
					        "aid"  => nullToEmpty($rs['agent_id']),
						    "fname"  => nullToEmpty($rs['first_name']),
						    "lname"  => nullToEmpty($rs['last_name']),
							"fname_th"  => nullToEmpty($rs['first_name_th']),
							"lname_th"  => nullToEmpty($rs['last_name_th']),
							"genesysid"  => nullToEmpty($rs['genesysid']),
							"nickname"  => nullToEmpty($rs['nickname']),
						  	"mobilePhone"  => nullToEmpty($rs['mobile_phone']),	
			  				"email"  => nullToEmpty($rs['email']),	
							"gid"  => nullToEmpty($rs['group_id']),
							"tid"  => nullToEmpty($rs['team_id']),
						  	"loginid"  => nullToEmpty($rs['agent_login']),	
						  	"level"  => nullToEmpty($rs['level_id']),	
						  	"accStatus"  => nullToEmpty($rs['is_active']),
			  	
			  				"sacode"  => nullToEmpty($rs['sales_agent_code']),
						  	"saname"  => nullToEmpty($rs['sales_agent_name']),	
						  	"slcode"  => nullToEmpty($rs['sales_license_code']),	
						  	"slname"  => nullToEmpty($rs['sales_license_name']),
			  	
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
	            $mysalt = 'dH[vdc]h;18+';
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
			 
				$sql = "SELECT agent_id FROM t_agents WHERE agent_id = ".dbNumberFormat($tmp['aid'])." ";
		
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update   
					$sql = "UPDATE t_agents SET ".
							   "first_name =".dbformat( $tmp['fname']).",".						
							   "last_name=".dbformat( $tmp['lname']).",".
							   "first_name_th =".dbformat( $tmp['fname_th']).",".						
							   "last_name_th=".dbformat( $tmp['lname_th']).",".
							   "genesysid=".dbformat( $tmp['genesysid']).",".
							   "nickname=".dbformat( $tmp['nname']).",".
							   "mobile_phone=".dbformat( $tmp['mobilephone']).",".
							   "email=".dbformat( $tmp['email']).",".
							   "group_id=".dbformat( $tmp['gid']).",".					
							   "team_id=".dbformat( $tmp['tid']).",".
				   	 		   "agent_login=".dbformat( $tmp['loginid']).",";
								if( $tmp['passwd'] != ""){
									$sql = $sql."agent_password=".dbformat( sha1($tmp['passwd'].$mysalt)).",";
							   	} 
				   	 	 $sql = $sql."level_id=".dbformat( $tmp['level']).",".
				   	 	 	    "is_active=".dbformat( $tmp['accstatus']).",".
						   	 	 "sales_agent_code=".dbformat( $tmp['sagent_code']).",".
						   	 	 "sales_agent_name=".dbformat( $tmp['sagent_name']).",".
						   	 	 "sales_license_code=".dbformat( $tmp['slicense_code']).",".
						   	 	 "sales_license_name=".dbformat( $tmp['slicense_name']).",".
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE agent_id = ".dbformat( $tmp['aid'])." ";	
wlog("[update] : ".$sql);	
		 
					$dbconn->executeUpdate($sql); 
					 
				}else{
					
				   //insert
				   $sql = " INSERT INTO t_agents( first_name,last_name,first_name_th,last_name_th,genesysid,nickname,mobile_phone,".
				   			   " email,group_id,team_id,agent_login,agent_password,level_id,is_active,img_path,".
				   				"sales_agent_code,sales_agent_name,sales_license_code,sales_license_name, ".
				   				" create_user,create_date ) VALUES ( ".
							   " ".dbformat( $tmp['fname'])." ".
							   ",".dbformat( $tmp['lname'])." ".
							   ",".dbformat( $tmp['fname_th'])." ".
							   ",".dbformat( $tmp['lname_th'])." ".						
							   ",".dbformat( $tmp['genesysid'])." ".						
							   ",".dbformat( $tmp['nname'])." ".
							   ",".dbformat($tmp['mobilephone'])." ".
							   ",".dbformat( $tmp['email'])." ".
						 	   ",".dbNumberFormat( $tmp['gid'])." ".
							    ",".dbNumberFormat( $tmp['tid'])." ".
							    ",".dbformat( $tmp['loginid'])." ".
				  				",".dbformat(sha1($tmp['passwd'].$mysalt))." ".
				   /*
				 			    if( $tmp['passwd'] != ""){
				 			         $sql = $sql.",".dbformat(sha1($tmp['passwd'].$mysalt))." ";
						     	}else{
						     		  $sql = $sql.",".dbformat(sha1($tmp['passwd'].$mysalt))." ";
						     		
						     	}
				 */
						 		",".dbformat( $tmp['level'])." ".
							    ",".dbformat( $tmp['accstatus'])." ".
				   				 ", 'profiles/agents/no_profile.png' ". //default image profile
				  	// 			",".dbformat( $tmp['level'])." ".
					//		    ",".dbformat( $tmp['accstatus'])." ".
				   	//			",".dbformat( $tmp['level'])." ".
					//		    ",".dbformat( $tmp['accstatus'])." ".
				   	 			 ",".dbformat( $tmp['sagent_code'])." ".
						   	 	 ",".dbformat( $tmp['sagent_name'])." ".
						   	 	 ",".dbformat( $tmp['slicense_code'])." ".
						   	 	 ",".dbformat( $tmp['slicense_name'])." ".
							     " ,".dbNumberFormat($tmp['uid'])." , NOW() )  "; 

wlog("[insert]".$sql);
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
				
			$sql = " DELETE FROM t_agents WHERE agent_id IN (".dbformat( $tmp['aid']).") ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	   function check(){
	   	
	            $tmp = json_decode( $_POST['data'] , true); 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				/*
			   switch($_POST['con'] ){
			   	case "empid" : $sql = "SELECT empid FROM t_agents WHERE empid = ".dbformat($_POST['val'])." ";
			   							  break;
			   	case "loginid": $sql = "SELECT agent_login FROM t_agents WHERE agent_login = ".dbformat($_POST['val'])." ";
			   							  break;
			   }
			   */
			   $sql = "SELECT agent_login FROM t_agents WHERE agent_login = ".dbformat($tmp['loginid'])." ";
			   
			   wlog( $sql );
			   
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
					 $res = array("check"=>"duplicate");
				}else{
					$res = array("check"=>"pass");
				}		
				
				$dbconn->dbClose(); 
				echo json_encode($res);   		
				return false; 
		}
		
		function takeaction(){
			$action = $_POST['action'];
			switch($action){
				case "lock" : $action = "0"; break;
				case "unlock" : $action = "1"; break;
		    }
		
	        $tmp = json_decode(  true); 
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
			
			$sql = " UPDATE t_agents SET is_active=".dbNumberFormat( $action )." ,".
			    		" update_date = NOW(),".
					    " update_user =".dbNumberFormat( $_POST['uid'])." ".
						" WHERE agent_id = ".dbNumberFormat( $_POST['aid'])." ";
			
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	function isonline( $aid ){
	
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	 	$sql = " SELECT agent_id FROM t_session ".
					" WHERE agent_id = ".dbNumberFormat($aid);	 	
	 	
	 	$online = "offline";
 	    $result = $dbconn->executeQuery($sql);
		if($rs=mysqli_fetch_array($result)){   
			$online = "online";
		}
	 	return $online;
	 	
	 }
	

?>
