<?php session_start(); ?>
<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php

//util
	function dateEncodeSpace( $input ){   
	    $input = trim($input);		
	    if( $input != "" ){	    
			$date = explode('/',$input); 
			$ThaiToEngYear = ((int)$date[2]);// - 543;
				return "'".$ThaiToEngYear.$date[1].$date[0]."'";  //reconfig
		}else{
		    return "";
		    //return null;
		}
	}    
        function dateDecodeSpace( $input ){   
	    $input = trim($input);		
	    if( $input != "" ){	    
		        $y = substr($input,0,4);
			$m = substr($input,4,2);
			$d = substr($input,6,2);
			
			return $d.'/'.$m.'/'.$y;  
		}else{
		    return "";
		    //return null;
		}
	}   

   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
            case "init" : init(); break;
	        case "query"  : query(); break;
	        
			case "detail"  : detail(); break;
			case "save"    : save(); break;
			case "delete"  : delete(); break;
			
			case "check"  : check(); break;
 	        case "lock"     : takeaction(); break;
 	   	    case "unlock" : takeaction(); break;
 	   	    
		 }
	}
	
	
		function init(){
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     	//app falcon id == 3
	     	$sql = "SELECT ex_app_url , campaign_id  FROM t_external_app_register ".
	     				"WHERE ex_app_id = ".dbNumberFormat($tmp['exapp_id']).
	     				" AND is_active = 1 ";
	     	
	     	wlog( $sql );
	     	
	     	$count = 0;  
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
			  	$tmp1= array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
			  	 				"url"  => nullToEmpty($rs['ex_app_url']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp1 = array("result"=>"empty");
			} 
	     
			$data = array("exapp"=>$tmp1);
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	
	function query(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		//connect tubtim db
		//$dbconn->setDBName('Tubtim');
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	 	$page = 0;
	   	$pagelength = 50; //row per page 
	     if( isset($_POST['page'])){
	    	 $page =  ( intval($_POST['page']) - 1 ) * $pagelength;
	     }

	         $sql = " SELECT  app_run_no , X_referencepolicynumber as quotation , concat(Firstname,' ',Lastname) as custname , camp ,  ".
			"	concat( agent.first_name ,' ', agent.last_name)  as owner , Sale_Date , AppStatus ".
			"  FROM app_mt app LEFT OUTER JOIN  t_agents  agent ON app.agent_id = agent.agent_id  ".
			" WHERE  RecordType = '1' ";

			//if level is agent where current agent id
			if(  $_SESSION['pfile']['lv'] == 1){
			     $condition = $condition." AND app.agent_id =  ".dbNumberFormat($_SESSION["uid"]);
			 }else{
 			    //check level
                           
			 		//	$condition = $condition." WHERE AgentID IS NOT NULL";
			 }
			 //check level 
  			
  			if( $tmp['search_cust'] != "" ){
  			    $condition = $condition." AND ( Firstname LIKE '".trim($tmp['search_cust'])."%' OR Lastname LIKE '".trim($tmp['search_cust'])."%'  )";
  			}
  			if( $tmp['search_agent'] != "" ){
  		   	    $condition = $condition." AND agent_id = ".dbforamt($tmp['search_agent'])." ";
  			}	
  			if( $tmp['search_quono'] != "" ){
  		    	    $condition = $condition." AND X_referencepolicynumber LIKE '%".trim($tmp['search_quono'])."%' ";
  			}
			if( $tmp['search_sts'] != "" ){
  			    $condition = $condition." AND AppStatus = ".dbformat($tmp['search_sts'])." ";
  			}
			if( $tmp['search_cred'] != "" & $tmp['search_endd'] != "" ){
  			    $condition = $condition." AND STR_TO_DATE( Sale_Date , '%Y%m%d') BETWEEN STR_TO_DATE( ".dateEncodeSpace($tmp['search_cred'])." , '%Y%m%d') AND STR_TO_DATE( ".dateEncodeSpace($tmp['search_endd'])."  , '%Y%m%d')";
  					
  			}

  				$sql = $sql.$condition;
			 	$sql = $sql." ORDER BY Sale_Date  DESC ";
  					  //  " LIMIT ".$page." , ".$pagelength; 
  			
  			wlog('[application-pane_process][query] query : '.$sql);
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			  	$data[$count] = array(
						        "quono"  => nullToEmpty($rs['quotation']),
						        "cname"  => nullToEmpty($rs['custname']),
		  					"camp" => nullToEmpty($rs['camp']),			  
		  					"saledt"  => nullToEmpty( dateDecodeSpace($rs['Sale_Date'])),	
							"appsts"  => nullToEmpty($rs['AppStatus']),
							"owner"  => nullToEmpty($rs['owner'])
						);   
				$count++;  
			}
		        if($count==0){
				$data = array("result"=>"empty");
			} 
			
			//count row for paging
			$sql = " SELECT COUNT(X_referencepolicynumber) AS total ".
				" FROM app_mt app LEFT OUTER JOIN  t_agents  agent ON app.agent_id = agent.agent_id ";
				//" FROM app a LEFT OUTER JOIN user u ON a.AgentID = u.Id ";
			$sql = $sql.$condition;
			 
			// wlog( $sql );
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$total = nullToZero($rs['total']);
			}
			 
			$data = array( "data"=>$data ,"total"=>$total );
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}

	function detail(){

		$dbconn = new dbconn;  
	    $res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     
        $sql =" SELECT agent_id,first_name,last_name,nickname,mobile_phone ,is_active, a.group_id , a.team_id,email,level_id,agent_login ".
        		   " FROM t_agents a ".
        		   " LEFT OUTER JOIN t_group g ON a.group_id = g.group_id ".
        		   " LEFT OUTER JOIN t_team t ON a.team_id = t.team_id ".
        		   " WHERE agent_id =  ".dbNumberFormat($_POST['id'])." ";
  
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
			  	$data =  array(
					        "aid"  => nullToEmpty($rs['agent_id']),
						    "fname"  => nullToEmpty($rs['first_name']),
						    "lname"  => nullToEmpty($rs['last_name']),
							"nickname"  => nullToEmpty($rs['nickname']),
						  	"mobilePhone"  => nullToEmpty($rs['mobile_phone']),	
			  				"email"  => nullToEmpty($rs['email']),	
							"gid"  => nullToEmpty($rs['group_id']),
							"tid"  => nullToEmpty($rs['team_id']),
						  	"loginid"  => nullToEmpty($rs['agent_login']),	
						  	"level"  => nullToEmpty($rs['level_id']),	
						  	"accStatus"  => nullToEmpty($rs['is_active']),
						);   
			   $count++;
			}
 		    if($count==0){
				$data = array("result"=>"empty");
			}  
			
			$data = array("data"=>$data);	
			
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
				if($rs=mysql_fetch_array($result)){   
				   //update   
					$sql = "UPDATE t_agents SET ".
							   "first_name =".dbformat( $tmp['fname']).",".						
							   "last_name=".dbformat( $tmp['lname']).",".
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
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE agent_id = ".dbformat( $tmp['aid'])." ";	
			 
					$dbconn->executeUpdate($sql); 
					 
				}else{
					
				   //insert
				   $sql = " INSERT INTO t_agents( first_name,last_name,nickname,mobile_phone,".
				   			   " email,group_id,team_id,agent_login,agent_password,level_id,is_active,img_path,create_user,create_date ) VALUES ( ".
							   " ".dbformat( $tmp['fname'])." ".
							   ",".dbformat( $tmp['lname'])." ".						
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
				
			$sql = " DELETE FROM t_agents WHERE agent_id IN (".dbformat( $tmp['aid']).") ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	   function check(){
	        
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
			   switch($_POST['con'] ){
			   	case "empid" : $sql = "SELECT empid FROM t_agents WHERE empid = ".dbformat($_POST['val'])." ";
			   							  break;
			   	case "loginid": $sql = "SELECT agent_login FROM t_agents WHERE agent_login = ".dbformat($_POST['val'])." ";
			   							  break;
			   }
			   
			
		    
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysql_fetch_array($result)){   
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
	

?>
