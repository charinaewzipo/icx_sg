<?php
        require_once("dbconn.php");
        require_once("util.php");
        require_once("wlog.php");
	

	     
         if(isset($_REQUEST['useremail']) && $_REQUEST['useremail'] != ""){
            $dbconn = new dbconn;  
            $dbconn->createConn();
            $res = $dbconn->createConn();
            if($res==404){
                    $res = array("result"=>"error","message"=>"Can't connect to database");
                    echo json_encode($res);		
                    exit();
            }
			$email = $_REQUEST['useremail'];
			$sql=" SELECT t.agent_id,a.tokenid , t.first_name , t.last_name , t.extension, t.is_active , t.level_id , b.team_name, t.img_path FROM t_agents t 
					LEFT OUTER JOIN t_session a ON t.agent_id = a.agent_id 
					LEFT OUTER JOIN t_team b ON t.team_id = b.team_id 
					WHERE t.email='".$email."'";
			wlog("bypass token :".$sql);
	     	$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
				$token = $rs['tokenid'];
				$uid = $rs['agent_id'];
				if($rs['is_active'] != 1){
					$res = array("result"=>"error","message"=>"This account has been disabled");
					$dbconn->dbClose();	 
				    echo json_encode($res);		
				    exit();
				}
				$o=($token)?$token:uniqid();
				$pfile=array("uid"=>nullToEmpty($rs['agent_id']),"uname"=>nullToEmpty($rs['first_name']." ".$rs['last_name']),"team"=>nullToEmpty($rs['team_name']),"lv"=>nullToEmpty($rs['level_id']),"uimg"=>nullToEmpty($rs['img_path']),"uext"=>nullToEmpty($rs['extension']),"tokenid"=>$o);
				$_SESSION["uid"] = $uid;
				$_SESSION["pfile"]= $pfile;
				if($token != $o){
					user_log($uid,$o);
					$token = $o;
				}
                setcookie("tokenid", $uid, strtotime( '+10 days' ), '/; SameSite=None');
                setcookie("cur-cmp", "1|NTL Demo Campaign|".$uid, strtotime( '+10 days' ), '/; SameSite=None');
			}
		}
 			
	
        function user_log($r,$o){
            global $dbconn;
            $d="DELETE  FROM t_session WHERE agent_id = ".$r;
            $e=$dbconn->executeQuery($d);
        
            $d="UPDATE t_agents SET last_login_dt = NOW() WHERE agent_id = ".$r;
            wlog("update last login  : ".$d);
            $dbconn->executeUpdate($d);
        
            $d="INSERT INTO t_session( agent_id , ip_addr , tokenid , timestamp ) VALUE(  '".$r."','".getIPAddr()."', ".dbformat($o)." , NOW() );";
            wlog("session init : ".$d);
            $dbconn->executeUpdate($d);
        
            $d="INSERT INTO t_login_history ( agent_id , ip , type , datetime ) VALUE(  '".$r."','".getIPAddr()."', 'Login' , NOW() );";
            wlog("session init Insert Login History : ".$d);
            $dbconn->executeUpdate($d);
        
        }
        
        function getIPAddr(){
            $z=$_SERVER['REMOTE_ADDR'];
            if($z){
                if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                    $z=$_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                    $z=$_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                return $z;
            }return false;
        }

	

 ?>