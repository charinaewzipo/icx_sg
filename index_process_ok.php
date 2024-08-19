<?php session_start(); ?>
<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "license.php"  ?> 
<?php include "wlog.php" ?>
<?php

date_default_timezone_set('Asia/Bangkok');

	if(isset($_POST['action'])){ 
         switch( $_POST['action']){
	         	case "init" : init();    break;
	         	case "login" : login(); break;
         }
	}

function init(){	
	
		$dbconn = new dbconn; 
		$conn = $dbconn->createConn();
		if( $conn=="404" ){
		     $res = array("result"=>"error","message"=>"Can't connect to database");
			 echo json_encode($res);   
			 exit();
		}
		
		$sql = " SELECT agent_id , first_name , last_name  , img_path ".
			        " FROM t_agents a LEFT OUTER JOIN t_team t ".
	    			" ON a.team_id = t.team_id ".
					" WHERE  agent_id = ".dbNumberFormat( $_POST['token'] )." ";
		
			wlog( $sql );
			$result = $dbconn->executeQuery($sql);
			$count = 0;
			if($rs=mysql_fetch_array($result)){
				$count++;
				$data = array( 
					"uname" => nullToEmpty($rs['first_name']." ".$rs['last_name']),
					"uimg"=> nullToEmpty($rs['img_path'])
				);		
				$_SESSION["uid"] = $rs['agent_id'];
			}
		if($count==0){
			$data = array("result"=>"empty");
		}
			
		 $dbconn->dbClose();
		 echo json_encode($data);   
		
}

function login(){
		
	    $mysalt = 'dH[vdc]h;18+';
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn; 
		$conn = $dbconn->createConn();
	 	if($conn==404){
				    $res = array("result"=>"dberror","message"=>"Database connection failed");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     	$sql = " SELECT agent_id , first_name , last_name , extension, is_active , level_id , team_name, img_path ".
			        	" FROM t_agents a LEFT OUTER JOIN t_team t ".
	    				" ON a.team_id = t.team_id ";
	     	
	     	//check is use from cookie or login id 
	     		$agent = "";
		     if( isset( $_SESSION["uid"] )){
		     	$agentid = $_SESSION["uid"];
		   		$sql = $sql." WHERE agent_id = ".dbformat($_SESSION["uid"])." AND agent_password = ".dbformat(sha1($tmp['passwd'].$mysalt));
		     }else{
		     	$agentid = $tmp['uid'];
		     	$sql = $sql." WHERE agent_login = ".dbformat($tmp['uid'])." AND agent_password = ".dbformat(sha1($tmp['passwd'].$mysalt));
		     }
		     
	     	wlog("[index_process][login] sql : ".$sql);
	     	
	     	$result = $dbconn->executeQuery($sql);
			$count = 0;            
			if($rs=mysql_fetch_array($result)){    
					switch( $rs['is_active'] ){
						case 0 :  $res = array("result"=>"fail", "message"=>"This account has been disabled");		
										break;
						case 1 :	$result = "pass";
										//check activate license
									
										/*
										  	//isActivateLicense();
											$res = array("result"=>"cererror","message"=>":( License Error ");
											$result = "";
										*/
										
										//check concurrent license
										$t = get_license();
										if( $t == "max"){
											$res = array("result"=>"fail","message"=>"Maximum online user license");
											$result = "";
										}
										
										//check duplicate session
										if( $result == "pass"){
											if($tmp['kicking'] != "kick"){
												$t = get_session( $rs['agent_id'] );
												if( $t == "online" ){
														$res = array("result"=>"warning", "message"=>"This user ID  is online,  <br/>Are you want to kick this session ? ");		
										 				$result = "";
												}
											}
										}
										
										 //check login extension id  ( if set )
									     if(  $tmp["extension"] != ""){
									     	 $ext = update_extension( $tmp["extension"] , $rs['agent_id'] );
									     }else{
									     	 $ext = $rs['extension'];
									     }
									
										if( $result == "pass" ){
												$tokenid = uniqid();
												$data = array(
																	"uid" => nullToEmpty($rs['agent_id']),
												  	  				"uname" => nullToEmpty($rs['first_name']." ".$rs['last_name']),
															        "team"  => nullToEmpty($rs['team_name']),
															   		"lv" => nullToEmpty($rs['level_id']),
															   		"uimg" => nullToEmpty($rs['img_path']),
															   	 	"uext"  => nullToEmpty( $ext ),
															   	//	"miss" => remindMiss( $rs['agent_id'] ),
															   		"tokenid"=>$tokenid
															   	);
												$_SESSION["uid"] = $rs['agent_id'];  //initial session
												$_SESSION["pfile"] = $data; 			 //initial session datat
												$res = array("result"=>"success", "data"=> $data ); 
												user_log($rs['agent_id'] , $tokenid);
												
										}
										break;
						case 5 :  $res = array("result"=>"locked", "message"=>"This account has been locked ");		
										break;
					}
					//case login success
					if( isset( $_SESSION["loginfail"] ) ){
							//remove loginfail session
				 			unset($_SESSION['loginfail']);
					}
			}else{
				//case login fail
				$check = true;
				//check account is disable or lock first ( ignore passowrd false or true )
				$tmp = json_decode( $_POST['data'] , true); 
				if( isset( $_SESSION["uid"] )){
					$sql = 	"WHERE agent_id = ".dbNumberFormat($_SESSION["uid"]);
				 }else{
				 	$sql = 	"WHERE agent_login = ".dbformat($tmp['uid']);
				 }
			 
				$sql = "SELECT is_active FROM t_agents ".$sql;
				$result = $dbconn->executeQuery($sql);
				if($rs=mysql_fetch_array($result)){    
							wlog("is active is ".$rs['is_active']);
							switch( $rs['is_active'] ){
									case 0 :  //account is disable
													$res = array("result"=>"fail", "message"=>"This account has been disabled");		
													$check = false;
													break;
									case 5 :	//account is locked 	
													$res = array("result"=>"locked", "message"=>"This account has been locked ");					
													$check = false;		
													break;
							}
				}//end if
				
			
				//is check for next step
				if($check){
							//	set to session
							if( isset( $_SESSION["loginfail"] ) ){
							
										$_SESSION["loginfail"]  = $_SESSION["loginfail"]  + 1;
										switch( parseInt( $_SESSION["loginfail"] ) ){
											case 1:  $res = array("result"=>"fail","message"=>"Login Fail, Please try again."); break;
											case 2:  $res = array("result"=>"fail","message"=>"Login Fail, Please try again."); break;
											case 3 : $time = 10000;
														   $res = array("result"=>"disable","time"=> $time );
														   break;
											case 4 :  $time = 20000;
															$res = array("result"=>"disable","time"=> $time );
															break;
											case 5 :  //lock account 
															$res = array("result"=>"locked", "message"=>"This account has been locked ");											
															 process_lock_account();
															break;
															//other is lock too
											default : $res = array("result"=>"locked", "message"=>"This account has been locked ");
															 process_lock_account();
															break;
										}
								
							}else{
								$_SESSION["loginfail"] = 1;
								$res = array("result"=>"fail","message"=>"Login Fail, Please try again.");
							}
				}//end if check
			}//end else login
	
			$dbconn->dbClose();
		 	echo json_encode($res);   
			
}

function update_extension( $ext , $agentid){
	
		   	   $dbconn = new dbconn; 
			   $dbconn->createConn();
			   
			   $sql = " UPDATE t_agents SET extension = ".dbformat( $ext )."  WHERE agent_id = ".dbNumberFormat( $agentid );
			    	
			   	wlog("[index_process][update_extension] LOGIN set EXTENSION  sql : ".$sql);
			   $dbconn->executeUpdate($sql); 
			   $dbconn->dbClose();
			   
			   return $ext;
		 
}

//after trying to login fail over 5 times
function process_lock_account(){
	
			$tmp = json_decode( $_POST['data'] , true); 
			if( isset( $_SESSION["uid"] )){
				$sql = 	"WHERE agent_id = ".dbNumberFormat($_SESSION["uid"]);
			 }else{
			 	$sql = 	"WHERE agent_login = ".dbformat($tmp['uid']);
			 }
			 
			 //is_active == 5 is status lock 
				$sql = "UPDATE t_agents SET is_active = 5 ".$sql;
				
			   $dbconn = new dbconn; 
			   $dbconn->createConn();
			   	wlog("[index_process][process_lock_account] sql : ".$sql);
			   $dbconn->executeUpdate($sql); 
			   $dbconn->dbClose();
			
	
}


function get_license(){
	
	//return max if license if full
	return "maxs";
	
}


function get_session( $uid ){
	
	   		   $dbconn = new dbconn; 
			   $dbconn->createConn();
			   
			   //session expire in 45 min
			   $sess_expire = 45;
			   
			   //update session
			  $sql = "DELETE  FROM t_session WHERE TIMEDIFF( NOW(), timestamp ) > '00:".$sess_expire.":00' ";
			  wlog("session init sql :".$sql);
		      $dbconn->executeUpdate($sql); 
		
               //check concurrent session
               $res = "";
	           $sql = "SELECT agent_id FROM t_session WHERE agent_id = ".$uid." AND ip_addr != ".dbformat(getIPAddr())." ";
	           wlog("session init check concurrent session : ".$sql);
			   $result = $dbconn->executeQuery($sql); 
			   if($rs=mysql_fetch_array($result)){    
			   	             $res = "online";
				}
				
	//return online if account are logon other computer
	return $res;
	
}

//log user login to system
function user_log( $uid , $tokenid  ){
	
	   $dbconn = new dbconn; 
	   $dbconn->createConn();
	   //log t_session
	   	$sql = "DELETE  FROM t_session WHERE agent_id = ".$uid;
		$result = $dbconn->executeQuery($sql);
		
		//update last login
		$sql = "UPDATE t_agents SET last_login_dt = NOW() WHERE agent_id = ".$uid;
		wlog("update last login  : ".$sql);
	    $dbconn->executeUpdate($sql); 
			   
		$sql = "INSERT INTO t_session( agent_id , ip_addr , tokenid , timestamp ) VALUE(  '".$uid."','".getIPAddr()."', ".dbformat($tokenid)." , NOW() );";
	    wlog("session init : ".$sql);
	    $dbconn->executeUpdate($sql); 
	
}

   
   function licenseCheck( ){
   	
   	        $dbconn = new dbconn; 
		    $dbconn->createConn();
		    
		
		    $lsup = "5";
		    $lagent = "";
		    $lmanager = "";
		    
		    
              $sql = "SELECT COUNT(agent_id) AS concurrent_uid FROM t_session ";
           
			   $result = $dbconn->executeQuery($sql); 
			   if($rs=mysql_fetch_array($result)){  
			   	
			                        $max = getLicense();
			                        
			                       // echo "license : ". $max;
			                      //  echo "concurrent ".$rs['concurrent_uid'] ;
						        	if($rs['concurrent_uid'] > $max ){
								       $res = array("result"=>"fail","message"=>"Maximum user online");
								       return $res;
						        	}
						       
			   }	        	
			           
   	
   }

   function sessionInit( $uid , $tokenid ){ 
               $dbconn = new dbconn; 
			   $dbconn->createConn();
			   
			   //session expire in 45 min
			   $sess_expire = 45;
			   
			   //update session
			  $sql = "DELETE  FROM t_session WHERE TIMEDIFF( NOW(), timestamp ) > '00:".$sess_expire.":00' ";
			  wlog("session init sql :".$sql);
		      $dbconn->executeUpdate($sql); 
		      
		      
               //check concurrent session
	           $sql = "SELECT agent_id FROM t_session WHERE agent_id = ".$uid." AND ip_addr != ".dbformat(getIPAddr())." ";
	           wlog("session init check concurrent session : ".$sql);
			   $result = $dbconn->executeQuery($sql); 
			   if($rs=mysql_fetch_array($result)){   
			   	
			   	             $res = array("result"=>"warning", "message"=>"This user ID  is online,  <br/>Are you want to kick this session ? ");		
							 return $res;
					
				}else{
					
					 	$sql = "DELETE  FROM t_session WHERE agent_id = ".$uid;
						$result = $dbconn->executeQuery($sql);

						
						$now = date('Y-m-d H:i:s', strtotime('now'));
					    $sql = "INSERT INTO t_session( agent_id , ip_addr , tokenid , timestamp ) VALUE(  '".$uid."','".getIPAddr()."', ".dbformat($tokenid)." ,'".$now."' );";
					    wlog("session init : ".$sql);
					    $dbconn->executeUpdate($sql); 
				        $res = array("result"=>"success","message"=>"success");
					    return $res;
								    
				}
		
   
   }

   
   //new
     function getIPAddr(){
	  	
	  	    $ip = $_SERVER['REMOTE_ADDR'];     
	        if($ip){
	            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	                $ip = $_SERVER['HTTP_CLIENT_IP'];
	            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	            }
	            return $ip;
	        }
	        // There might not be any data
	        return false;
		    
	}
	
   //old
function getIPAddr_old() {
	   		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		    $remote  = $_SERVER['REMOTE_ADDR'];
		    if(filter_var($client, FILTER_VALIDATE_IP)) {
		        $ip = $client;
		    } elseif(filter_var($forward, FILTER_VALIDATE_IP)){
		        $ip = $forward;
		    }else{
		        $ip = $remote;
		    }
		    return $ip;
		    /*
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address=$_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address=$_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address=$_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
    */
}   

/*
function remindMe( $uid ){
	  
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	
	     		//echo $reminddt;
				    date_default_timezone_set('Asia/Bangkok');
				    $datetime1 = new DateTime();
					$datetime2 = new DateTime($reminddt);
					$interval = $datetime1->diff($datetime2);
					$elapsed = $interval->format(' %y years %m months %a days %h hours %i minutes %S seconds');
					//echo $elapsed."<br/>";
					$hour = $interval->format('%h');
					$min = $interval->format('%i');
					$sec = $interval->format('%S');
					
					$sec  =  (($hour * 60 * 60 ) + ( $min * 60 ) + $sec ) *1000; 
					
					return $sec;
	}
	*/
//check is missing some reminder when logout
function remindMiss( $uid ){
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
					$sql = " SELECT COUNT(*) AS total_miss , MAX(reminder_dt) AS last_remind  FROM t_reminder WHERE reminder_dt < NOW() ".
								" AND status = 1 ".
								" AND create_user =  ".dbNumberFormat($uid )." ";
					
					wlog("check reminder : ".$sql);
					$result = $dbconn->executeQuery($sql);
					$count = 0;
					if($rs=mysql_fetch_array($result)){
						$count = $rs['total_miss'];
					}
					
					if($count>0){
						$result = "miss";
					}else{
						$result = "";
					}
					
		
	 		return $result;
	
	}
 
 ?>