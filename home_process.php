<?php session_start(); ?>
<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php

	 	if(isset($_POST['action'])){ 
		         switch( $_POST['action']){
		            case "query"            : workingagent(); break;
		            case "agentwall"    : agentwall(); break;
		           // case "transferhist" : transferhist(); break;
		         }
	 	}

	function workingagent(){
		
	 //get level of agent from session
	  $lvl = $_SESSION["pfile"]["lv"];
	 	
	    $tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     if( $lvl > 1){
	     		     $sql = "SELECT  group_id , team_id FROM t_agents WHERE agent_id = ".dbNumberFormat($tmp['uid']);
	     		     $result = $dbconn->executeQuery($sql);
					 if($rs=mysqli_fetch_array($result)){
					 	$gid = $rs['group_id'];
					 	$tid = $rs['team_id'];
					 }   
	     	
	     }
 
	 	//calllist on agent hands seperate by level of agent 
			   $sql =" SELECT c.campaign_name , a.campaign_id , ag.agent_id , ag.first_name , ag.last_name ".
				  		"  , ag.img_path ,  ag.extension, t.team_name ". 
		     			" , count( a.calllist_id ) as total_call".
				   		" , sum( a.new_cnt ) as new_cnt".
						" , sum( a.callback_cnt ) as success_cnt".
		     			" , sum( a.callback_cnt ) as callback_cnt".
		     			" , sum( a.follow_cnt ) as follow_cnt".
		     			" , sum( a.dnc_cnt ) as dnc_cnt".
		     			" , sum( a.bad_cnt ) as bad_cnt".
				   		" , sum( a.nocont_cnt) as nocont_cnt".
						" FROM  ( ".
						" select campaign_id ,agent_id ,calllist_id ".
				   		" ,case when last_wrapup_option_id IS NULL then 1 else 0 end as new_cnt ". 
						" ,case when last_wrapup_option_id = 0 then 1 else 0 end as success_cnt ". 
						" ,case when last_wrapup_option_id = 1 then 1 else 0 end as callback_cnt ".
		     			" ,case when last_wrapup_option_id in ( 2,9 ) then 1 else 0 end as follow_cnt ".
						" ,case when last_wrapup_option_id = 3 then 1 else 0 end as dnc_cnt ".
		     			" ,case when last_wrapup_option_id = 4 then 1 else 0 end as bad_cnt ".
				   		" ,case when last_wrapup_option_id = 8 then 1 else 0 end as nocont_cnt ".
						" FROM t_calllist_agent ) AS a ".
						" LEFT OUTER JOIN t_campaign c ON a.campaign_id = c.campaign_id  ".
						" LEFT OUTER JOIN t_agents ag ON a.agent_id = ag.agent_id  ".
						" LEFT OUTER JOIN t_team t ON ag.team_id = t.team_id  ".
						" LEFT OUTER JOIN t_group g ON t.group_id = g.group_id  ";

				   switch( intval($lvl) ){
				   		case 1 : $sql = $sql." WHERE ag.agent_id  = ".dbNumberFormat($tmp['uid']); break;
				   		case 2 :  $sql = $sql." WHERE ag.team_id  = ".dbNumberFormat($tid); break;
				   		case 3 :  $sql = $sql." WHERE ag.team_id  = ".dbNumberFormat($tid); break;
				   		case 4 : $sql = $sql." WHERE ag.group_id = ".dbNumberFormat($gid); break;
				   		case 5 : $sql = $sql." WHERE ag.agent_id is not null "; break;
				   		case 6 : $sql = $sql." WHERE ag.agent_id is not null "; break;
				   		default :  $sql = $sql." WHERE ag.agent_id  = ".dbNumberFormat($tmp['uid']); 
				   	
				   }
	
			$sql = $sql." GROUP BY c.campaign_name , a.campaign_id , ag.agent_id , ag.first_name , ag.last_name ".
				        		" ,ag.img_path ,  ag.extension, t.team_name ";
			
			wlog("check sup permission : ".$sql);
			     
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			//	$progress = ((($rs['total_call'] - $rs['new_cnt'] ) * 100 ) / $rs['total_call'] );
				$total = nullToZero($rs['new_cnt']) +  nullToZero($rs['nocont_cnt']) +   nullToZero($rs['follow_cnt']) + nullToZero($rs['callback_cnt']);
			  	$tmp1[$count] = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
			  					"cmpn"  => nullToEmpty($rs['campaign_name']),
								"aid"  => nullToEmpty($rs['agent_id']),
			  					"aname"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
			  					"aimg"  => nullToEmpty($rs['img_path']),
			  					"aext"  => nullToEmpty($rs['extension']),
			  					"ateam"  => nullToEmpty($rs['team_name']),
			  					"agroup"  => nullToEmpty($rs['group_name']),
			  					"aext"  => nullToEmpty($rs['extension']),			  	
							 //   "tcall"  => nullToEmpty($rs['total_call']),
							 	"tcall"  => nullToZero($total),
			  		  			"tnew"  => nullToEmpty($rs['new_cnt']),
			  	     			"tsuccess"  => nullToEmpty($rs['success_cnt']),
								"tcallback"  => nullToEmpty($rs['callback_cnt']),
			  					"tfollow"  => nullToEmpty($rs['follow_cnt']),			  	
							    "tdnc"  => nullToEmpty($rs['dnc_cnt']),
			  	    			"tbad"  => nullToEmpty($rs['bad_cnt']),
			  					"tnoc"  => nullToEmpty($rs['nocont_cnt']),
			  					//"pgress"  => nullToZero( ceil($progress)),
			  					"isonline"=>nullToEmpty(isonline( $rs['agent_id'] ))
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			 
	
	 	$data = array("callsts"=>$tmp1);
			
		$dbconn->dbClose();
		echo json_encode( $data ); 
		
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
	 
	 function agentwall(){
	 	
	 	$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //condition by date
	     //condition by campaign
	     //condition by agent
	     
	     $startdate = "";  $enddate = "";
	     $onhands = "1";
	     if( isset($_POST['condition'])){
	     	switch($_POST['condition']){
	     		case "onhands"		 :  $onhands = "0"; break;
	     		case "today"		     :  $startdate = today_start();  $enddate = today_end(); break;
	     		case "yesterday"    :  $startdate = yesterday_start();  $enddate = yesterday_end(); break;
	     		case "thisweek"      :  $startdate = thisweek_start();  $enddate = thisweek_end(); break;   	 //change mon to sun // ERROR !!
	     		case "thismonth"   :  $startdate = thismonth_start();  $enddate = thismonth_end(); break;
	     	}
	     }
	     
	     //query agent info 
	   $sql =" SELECT  ag.agent_id , ag.first_name , ag.last_name , ag.img_path ,  ag.extension, t.team_name ,j.campaign_id ,c.campaign_name , s.timestamp ".
   				 " FROM t_agents ag ".	
   				 " LEFT OUTER JOIN t_team t ON ag.team_id = t.team_id  ".
				 " LEFT OUTER JOIN t_group g ON t.group_id = g.group_id  ".
	  		  	" LEFT OUTER JOIN ( select  campaign_id , agent_id ,last_join_date ".
						 " from t_agent_join_campaign ".
						 " where agent_id  = ".dbNumberFormat( $_POST['aid'])." AND campaign_id = ".dbNumberFormat( $_POST['cmp'])." ".
						 " order by last_join_date desc ". 
						 "  limit 1 )  j ON ag.agent_id  = j.agent_id  ".
	   	   			 " LEFT OUTER JOIN t_campaign c ON j.campaign_id = c.campaign_id  ".
	   			 " LEFT OUTER JOIN t_session s ON s.agent_id = ag.agent_id ".
   				 " WHERE ag.agent_id = ".dbNumberFormat( $_POST['aid']);
	   			
	   
	   wlog("[home_process][agentwall] agent info sql : ".$sql );
	   
	 	$online = "offline";
 	    $result = $dbconn->executeQuery($sql);
		if($rs=mysqli_fetch_array($result)){   
		    $timestamp = nullToEmpty($rs['timestamp']);
			if( $timestamp == "" ){
				$timestamp = loginhist( dbNumberFormat( $_POST['aid']) );
			}
			
	 		$tmp1 = array(
	 							"aid" => nullToZero($rs['agent_id']),
	 							"aname"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
					 			"aimg"  => nullToEmpty($rs['img_path']),
					 			"aext"  => nullToEmpty($rs['extension']),
					 			"ateam"  => nullToEmpty($rs['team_name']),
			  					"agroup"  => nullToEmpty($rs['group_name']),
	 							"isonline"=>nullToEmpty(isonline( $rs['agent_id'] )),
	 							"acmp"=>nullToEmpty($rs['campaign_name'] ),
	 							"alastjoin"=>getDatetimeFromDatetime( $timestamp ),
	 							"alastjointime"=>nullToEmpty($timestamp ),
	 							"acurdate" => getEngDate(date('Y-m-d')),
	 
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 

		//count call summary
   		 $sql =" SELECT c.campaign_name , a.campaign_id , ag.agent_id  ".
	     			" , count( a.calllist_id ) as total_call".
			   		" , sum( a.new_cnt ) as new_cnt".
					" , sum( a.callback_cnt ) as success_cnt".
	     			" , sum( a.callback_cnt ) as callback_cnt".
	     			" , sum( a.follow_cnt ) as follow_cnt".
	     			" , sum( a.dnc_cnt ) as dnc_cnt".
	     			" , sum( a.bad_cnt ) as bad_cnt".
   		 			" , sum( a.sales_cnt ) as sales_cnt".
   		 			" , sum( a.nocont_cnt ) as nocont_cnt".
					" FROM  ( ".
					" select campaign_id ,agent_id ,calllist_id ".
			   		" ,case when last_wrapup_option_id IS NULL then 1 else 0 end as new_cnt ". 
					" ,case when last_wrapup_option_id = 0 then 1 else 0 end as success_cnt ". 
					" ,case when last_wrapup_option_id = 1 then 1 else 0 end as callback_cnt ".
	     			" ,case when last_wrapup_option_id in ( 2,9 ) then 1 else 0 end as follow_cnt ".
					" ,case when last_wrapup_option_id = 3 then 1 else 0 end as dnc_cnt ".
	     			" ,case when last_wrapup_option_id = 4 then 1 else 0 end as bad_cnt ".
   		 			" ,case when last_wrapup_option_id = 6 then 1 else 0 end as sales_cnt ".
   		 			" ,case when last_wrapup_option_id = 8 then 1 else 0 end as nocont_cnt ".
					" FROM t_calllist_agent  ";
   		 			
   		 if( $onhands == "0" ){
   		 		$sql = $sql." WHERE campaign_id =  ".dbNumberFormat($_POST['cmp'])."  ) AS a ";
   		 	 			
   		 }else{
   		 		$sql = $sql." WHERE campaign_id =  ".dbNumberFormat($_POST['cmp'])." ". 
   		 							" AND IFNULL(last_wrapup_dt,assign_dt) BETWEEN ".dbformat( $startdate )." AND ".dbformat( $enddate )." ) AS a ";
   		 } 
   		
			$sql = $sql." LEFT OUTER JOIN t_campaign c ON a.campaign_id = c.campaign_id  ".
								" LEFT OUTER JOIN t_agents ag ON a.agent_id = ag.agent_id  ".
			   		 			" WHERE ag.agent_id  = ".dbNumberFormat($_POST['aid']).
								" GROUP BY c.campaign_name , a.campaign_id , ag.agent_id ";
   		 
   		 	wlog("[home_process][agentwall] count CALL SUMMARY : ".$sql);
   		  
   		 	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
				if( nullToZero($rs['total_call']) != 0  ){
					$progress = ((($rs['total_call'] - $rs['new_cnt'] ) * 100 ) / $rs['total_call'] );
				}else{
					$progress = 0;
				}
			  	$tmp2 = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
			  					"cmpn"  => nullToEmpty($rs['campaign_name']),
								"aid"  => nullToEmpty($rs['agent_id']),
							    "tcall"  => nullToEmpty($rs['total_call']),
			  		  			"tnew"  => nullToEmpty($rs['new_cnt']),
			  	     			"tsuccess"  => nullToEmpty($rs['success_cnt']),
			  					"tnocont"  => nullToEmpty($rs['nocont_cnt']),
								"tcallback"  => nullToEmpty($rs['callback_cnt']),
			  					"tfollow"  => nullToEmpty($rs['follow_cnt']),			  	
							    "tdnc"  => nullToEmpty($rs['dnc_cnt']),
			  	    			"tbad"  => nullToEmpty($rs['bad_cnt']),
			  					"tsales"  => nullToEmpty($rs['sales_cnt']),
			  					//"pgress"  => nullToZero( ceil($progress)),
			  
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
			
			//current list assign
			$sql = " SELECT sum( a.new_cnt) as new_cnt , ".
						" sum( a.nocont_cnt ) as nocont_cnt, ".
						" sum( a.callback_cnt ) as callback_cnt , ".
						" sum( a.followup_cnt ) as followup_cnt  ".
						" from ( ".
						" select transfer_to_id ".  
						" ,case when transfer_on_status in ( 1,2 )  then 1 else 0 end as new_cnt ". 
						" ,case when transfer_on_status = 3 then 1 else 0 end as nocont_cnt ".
						" ,case when transfer_on_status = 4 then 1 else 0 end as callback_cnt ".
						" ,case when transfer_on_status = 5 then 1 else 0 end as followup_cnt ".
						" FROM t_calllist_transfer  ".
						" WHERE transfer_date BETWEEN ".dbformat( $startdate )." AND ".dbformat( $enddate )." ".
						" ) as a ";
			
			//wlog( $sql );
			
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$tmp3 = array(
			  			"ne" => nullToZero($rs['new_cnt']),
				  		"no" => nullToZero($rs['nocont_cnt']),
				  		"call" => nullToZero($rs['callback_cnt']),
				  		"foll" => nullToZero($rs['followup_cnt'])
			  	);
			  	$count++;
			}
			
			if($count==0){
				$tmp3 = array("result"=>"empty");
			} 
			
			
			
			/*
			//current list assigned today
		
			$sql = " SELECT SUM( transfer_total ) AS trans_total , MAX( transfer_date ) AS assign_dt ".
						" FROM t_calllist_transfer WHERE transfer_to_id = ".dbNumberFormat($_POST['aid'])." ".
						" AND transfer_type = 1 ".
						" AND transfer_date BETWEEN ".dbformat( $startdate )." AND ".dbformat( $enddate )." ".
						" AND transfer_cmpid = ".dbNumberFormat($_POST['cmp']);
			
			 	wlog("[home_process][agentwall] list assigned : ".$sql);
		
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$tmp3 = array(
			  			"transtotal" => nullToZero($rs['trans_total']),
						"transdate"  => getDatetimeFromDatetime($rs['assign_dt']),
			  	);
			  	$count++;
			}
			
			if($count==0){
				$tmp3 = array("result"=>"empty");
			} 
			
			
			//current list revoke today
			//current list revoke date
			$sql = "SELECT SUM( transfer_total ) AS revoke_total , MAX( transfer_date ) AS revoke_dt  FROM t_calllist_transfer WHERE transfer_to_id = ".dbNumberFormat($_POST['aid'])." ".
						" AND transfer_type = 0 ".
						" AND transfer_date BETWEEN ".dbformat( $startdate )." AND ".dbformat( $enddate )." ".
						" AND transfer_cmpid = ".dbNumberFormat($_POST['cmp']);
	
			 wlog("[home_process][agentwall] list revoked : ".$sql);
						
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$tmp4 = array(
			  			"revoketotal" => nullToZero($rs['revoke_total']),
						"revokedate"  => getDatetimeFromDatetime($rs['revoke_dt']),
			  	);
			  	$count++;
			}
			
			if($count==0){
				$tmp4 = array("result"=>"empty");
			} 
			
			//current list 
			$sql = " SELECT DISTINCT list_name  ".
						" FROM t_calllist_agent ca ".
						" INNER JOIN t_import_list l ON ca.import_id = l.import_id ".
						" WHERE ca.agent_id =".dbNumberFormat($_POST['aid']).
						" AND ca.campaign_id = ".dbNumberFormat($_POST['cmp']);
			
			wlog("[home_process][agentwall] current working list : ".$sql);
					
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$tmp5[$count] = array(
			  			"lname" => nullToZero($rs['list_name'])
			  	);
			  	$count++;
			}
			
			if($count==0){
				$tmp5 = array("result"=>"empty");
			} 
			
			
			//avg talk time
			//$sql ="SELECT SUM(billsec) AS talktime FROM asteriskcdrdb.cdr WHERE userfield IS NOT NULL ";
			//condition by date
			//default by today !!
			*/
			
			
			
			
		
	 	$data = array("awall"=>$tmp1,"astat"=>$tmp2 , "atrans" => $tmp3 ); // , "arevoke" => $tmp4 , "alist" => $tmp5
			
		$dbconn->dbClose();
		echo json_encode( $data ); 
	 	
	 	
	 }
	 
	 function loginhist( $aid ){
	 	
	 	$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //query agent info 
	   $sql =" SELECT  last_login_dt ".
   				 " FROM t_agents WHERE agent_id = ".dbNumberFormat( $aid );
	   		

	    $result = $dbconn->executeQuery($sql);
	    $data = "";
		if($rs=mysqli_fetch_array($result)){   
			$data = nullToEmpty($rs['last_login_dt']);
		}
	   
	 	return $data;
	 }
	 
	

?>

