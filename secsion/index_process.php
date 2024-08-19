<?php session_start();?>
<?php include "dbconn.php"?>
<?php include "util.php"?>
<?php include "license.php"?>
<?php include "wlog.php"?>
<?php
date_default_timezone_set('Asia/Bangkok');
if(isset($_POST['action'])){
	switch($_POST['action']){
		case  "init":init();break;
		case  "login":login();break;}}
		function init(){
			$a=new dbconn;
			$b=$a->createConn();
			if($b=="404"){
				$c=array("result"=>"error","message"=>"Can't connect to database");
				echo json_encode($c);
				exit();
			}
			$d=" SELECT agent_id , first_name , last_name  , img_path ".
					" FROM t_agents a LEFT OUTER JOIN t_team t ".
					" ON a.team_id = t.team_id ".
					" WHERE  agent_id = ".dbNumberFormat($_POST['token'])." ";
			wlog($d);
			$e=$a->executeQuery($d);
			$f=0;if($g=mysql_fetch_array($e)){
					$f++;$h=array(
						"uname"=>nullToEmpty($g['first_name']." ".$g['last_name']),
						"uimg"=>nullToEmpty($g['img_path']));
						$_SESSION["uid"]=$g['agent_id'];}
						if($f==0){$h=array("result"=>"empty");}$a->dbClose();echo json_encode($h);}function login(){
							if(isset($_SESSION["uid"])) {
								$uid = $_SESSION["uid"];
								session_regenerate_id(true);
								$_SESSION['CREATED'] = time();
								$_SESSION["uid"]=$uid;
							} else {
								session_regenerate_id(true);
								$_SESSION['CREATED'] = time();
							}
							$i='dH[vdc]h;18+';
							$j=json_decode($_POST['data'],true);
							$a=new dbconn;$b=$a->createConn();if($b==404){
								$c=array("result"=>"dberror","message"=>"Database connection failed");
								echo json_encode($c);exit();
								}$d=" SELECT agent_id, genesysid , first_name , last_name , extension, is_active , level_id , team_name, img_path "." FROM t_agents a LEFT OUTER JOIN t_team t "." ON a.team_id = t.team_id ";
								$k="";
								if(isset($_SESSION["uid"])){
									$l=$_SESSION["uid"];$d=$d." WHERE agent_id = ".dbformat($_SESSION["uid"])." AND agent_password = ".dbformat(sha1($j['passwd'].$i));
									}else{
										$l=$j['uid'];
										$d=$d." WHERE agent_login = ".dbformat($j['uid'])." AND agent_password = ".dbformat(sha1($j['passwd'].$i));
										}
								wlog("[index_process][login] sql : ".$d);
								$e=$a->executeQuery($d);
								$f=0;
								if($g=mysql_fetch_array($e)){
									switch($g['is_active']){
										case 0:$c=array("result"=>"fail","message"=>"This account has been disabled");break;
										case 1:$e="pass";$m=get_license();if($m=="max"){$c=array("result"=>"fail","message"=>"Maximum online user license");$e="";}if($e=="pass"){if($j['kicking']!="kick"){$m=get_session($g['agent_id']);if($m=="online"){$c=array("result"=>"warning","message"=>"This user ID  is online,  <br/>Are you want to kick this session ? ");$e="";}}}if($j["extension"]!=""){$n=update_extension($j["extension"],$g['agent_id']);}else{$n=$g['extension'];}if($e=="pass"){$o=uniqid();$h=array("uid"=>nullToEmpty($g['agent_id']),"genesysid"=>(nullToEmpty($g['genesysid'])),"uname"=>nullToEmpty($g['first_name']." ".$g['last_name']),"team"=>nullToEmpty($g['team_name']),"lv"=>nullToEmpty($g['level_id']),"uimg"=>nullToEmpty($g['img_path']),"uext"=>nullToEmpty($n),"tokenid"=>$o);$_SESSION["uid"]=$g['agent_id'];$_SESSION["pfile"]=$h;$c=array("result"=>"success","data"=>$h);user_log($g['agent_id'],$o);}break;
										case 5:$c=array("result"=>"locked","message"=>"This account has been locked ");break;}if(isset($_SESSION["loginfail"])){unset($_SESSION['loginfail']);}}else{$p=true;$j=json_decode($_POST['data'],true);if(isset($_SESSION["uid"])){$d="WHERE agent_id = ".dbNumberFormat($_SESSION["uid"]);}else{$d="WHERE agent_login = ".dbformat($j['uid']);}$d="SELECT is_active FROM t_agents ".$d;$e=$a->executeQuery($d);if($g=mysql_fetch_array($e)){wlog("is active is ".$g['is_active']);
										
									switch($g['is_active']){
										case 0:$c=array("result"=>"fail","message"=>"This account has been disabled");$p=false;break;
										case 5:$c=array("result"=>"locked","message"=>"This account has been locked ");$p=false;break;}}if($p){if(isset($_SESSION["loginfail"])){$_SESSION["loginfail"]=$_SESSION["loginfail"]+1;switch(parseInt($_SESSION["loginfail"])){case 1:$c=array("result"=>"fail","message"=>"Login Fail, Please try again.");break;
										case 2:$c=array("result"=>"fail","message"=>"Login Fail, Please try again.");break;
										case 3:$q=10000;$c=array("result"=>"disable","time"=>$q);break;
										case 4:$q=20000;$c=array("result"=>"disable","time"=>$q);break;
										case 5:$c=array("result"=>"locked","message"=>"This account has been locked ");process_lock_account();break;default:$c=array("result"=>"locked","message"=>"This account has been locked ");process_lock_account();break;}}else{$_SESSION["loginfail"]=1;$c=array("result"=>"fail","message"=>"Login Fail, Please try again.");}}}$a->dbClose();echo json_encode($c);}function update_extension($n,$l){$a=new dbconn;$a->createConn();$d=" UPDATE t_agents SET extension = ".dbformat($n)."  WHERE agent_id = ".dbNumberFormat($l);wlog("[index_process][update_extension] LOGIN set EXTENSION  sql : ".$d);$a->executeUpdate($d);$a->dbClose();return $n;}function process_lock_account(){$j=json_decode($_POST['data'],true);if(isset($_SESSION["uid"])){$d="WHERE agent_id = ".dbNumberFormat($_SESSION["uid"]);}else{$d="WHERE agent_login = ".dbformat($j['uid']);}$d="UPDATE t_agents SET is_active = 5 ".$d;$a=new dbconn;$a->createConn();wlog("[index_process][process_lock_account] sql : ".$d);$a->executeUpdate($d);$a->dbClose();}function get_license(){return "maxs";}function get_session($r){$a=new dbconn;$a->createConn();$s="08";$d="DELETE  FROM t_session WHERE TIMEDIFF( NOW(), timestamp ) > '$s:00:00' ";wlog("session init sql :".$d);$a->executeUpdate($d);$c="";$d="SELECT agent_id FROM t_session WHERE agent_id = ".$r." AND ip_addr != ".dbformat(getIPAddr())." ";wlog("session init check concurrent session : ".$d);$e=$a->executeQuery($d);if($g=mysql_fetch_array($e)){$c="online";}return $c;}
										
										function user_log($r,$o){
											$a=new dbconn;$a->createConn();
											$d="DELETE  FROM t_session WHERE agent_id = ".$r;
											$e=$a->executeQuery($d);
											
											$d="UPDATE t_agents SET last_login_dt = NOW() WHERE agent_id = ".$r;
											wlog("update last login  : ".$d);
											$a->executeUpdate($d);
											
											$d="INSERT INTO t_session( agent_id , ip_addr , tokenid , timestamp ) VALUE(  '".$r."','".getIPAddr()."', ".dbformat($o)." , NOW() );";
											wlog("session init : ".$d);
											$a->executeUpdate($d);
											
											$d="INSERT INTO t_login_history ( agent_id , ip , type , datetime ) VALUE(  '".$r."','".getIPAddr()."', 'Login' , NOW() );";
											wlog("session init Insert Login History : ".$d);
											$a->executeUpdate($d);
											
											}
											
											function licenseCheck(){$a=new dbconn;$a->createConn();$u="5";$v="";$w="";$d="SELECT COUNT(agent_id) AS concurrent_uid FROM t_session ";$e=$a->executeQuery($d);if($g=mysql_fetch_array($e)){$x=getLicense();if($g['concurrent_uid']>$x){$c=array("result"=>"fail","message"=>"Maximum user online");return $c;}}}function sessionInit($r,$o){$a=new dbconn;$a->createConn();$s="08";$d="DELETE  FROM t_session WHERE TIMEDIFF( NOW(), timestamp ) > '$s:00:00' ";wlog("session init sql :".$d);$a->executeUpdate($d);$d="SELECT agent_id FROM t_session WHERE agent_id = ".$r." AND ip_addr != ".dbformat(getIPAddr())." ";wlog("session init check concurrent session : ".$d);$e=$a->executeQuery($d);if($g=mysql_fetch_array($e)){$c=array("result"=>"warning","message"=>"This user ID  is online,  <br/>Are you want to kick this session ? ");return $c;}else{$d="DELETE  FROM t_session WHERE agent_id = ".$r;$e=$a->executeQuery($d);$y=date('Y-m-d H:i:s',strtotime('now'));$d="INSERT INTO t_session( agent_id , ip_addr , tokenid , timestamp ) VALUE(  '".$r."','".getIPAddr()."', ".dbformat($o)." ,'".$y."' );";wlog("session init : ".$d);$a->executeUpdate($d);$c=array("result"=>"success","message"=>"success");return $c;}}function getIPAddr(){$z=$_SERVER['REMOTE_ADDR'];if($z){if(!empty($_SERVER['HTTP_CLIENT_IP'])){$z=$_SERVER['HTTP_CLIENT_IP'];}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$z=$_SERVER['HTTP_X_FORWARDED_FOR'];}return $z;}return false;}function getIPAddr_old(){$aa=@$_SERVER['HTTP_CLIENT_IP'];$bb=@$_SERVER['HTTP_X_FORWARDED_FOR'];$cc=$_SERVER['REMOTE_ADDR'];if(filter_var($aa,FILTER_VALIDATE_IP)){$z=$aa;}elseif(filter_var($bb,FILTER_VALIDATE_IP)){$z=$bb;}else{$z=$cc;}return $z;}function remindMiss($r){$a=new dbconn;$a->createConn();$c=$a->createConn();if($c==404){$c=array("result"=>"dberror","message"=>"Can't connect to database");echo json_encode($c);exit();}$d=" SELECT COUNT(*) AS total_miss , MAX(reminder_dt) AS last_remind  FROM t_reminder WHERE reminder_dt < NOW() "." AND status = 1 "." AND create_user =  ".dbNumberFormat($r)." ";wlog("check reminder : ".$d);
$e=$a->executeQuery($d);
$f=0;if($g=mysql_fetch_array($e)){
	$f=$g['total_miss'];}
	if($f>0){$e="miss";}
	else{$e="";}
	return $e;}?> 