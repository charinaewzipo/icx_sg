<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php

   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
      		case "init" : init(); break;
	        case "query"  : query(); break;
         	
         	// not used
			case "detail"  : detail(); break;
			case "save"    : save(); break;
			case "delete"  : delete(); break;
			case "check" : check(); break;
 
		 }
	}
	
	
	function init(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     	//count online and offline
				$sql = " SELECT count( distinct s.agent_id) as agent_online ".
							" , count( distinct a.agent_id ) - count( distinct s.agent_id)  as agent_offline ".
							" FROM t_agents a ".
							" LEFT OUTER JOIN t_session s   ON s.agent_id = a.agent_id ". 
							" WHERE a.team_id = 3 ".
							" AND a.group_id = 4 ".
							" AND a.is_active = 1";
				
				$result = $dbconn->executeQuery($sql);
				if($rs=mysqli_fetch_array($result)){   
				  	$tmp1 = array(
							        "online"  => nullToEmpty($rs['agent_online']),
				  	 				"offline"  => nullToEmpty($rs['agent_offline']),
							);   
					$count++;  
				}
			    if($count==0){
					$tmp1 = array("result"=>"empty");
				} 
			
			/*
		     $sql = " SELECT SUM( transfer_new_list ) AS tnewlist , SUM( revoke_new_list ) AS rnewlist ,  SUM( transfer_used_list ) AS tusedlist , SUM( revoke_used_list ) ". 
						" FROM v_dashboard_calllist ".
						" WHERE team_id = 3 ".
						" AND group_id = 4 ";
		    */

	     $sql = "SELECT agent_id,first_name,last_name,img_path,extension,team_name,group_name, ".
	     			" remain_new_list , remain_no_contact , remain_callback , remain_followup ".
	     			" FROM v_dashboard_calllist ".
					" WHERE team_id = 3 ".
					" AND group_id = 4 ";
				
		     wlog("[dashboard_process][init] ".$sql);
		    $count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
					  	$tmp3[$count] = array(
					  	       		"an"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
				  	 				"im"  => nullToEmpty($rs['img_path']),
					  				"ex"  => nullToEmpty($rs['extension']),
					  				"tn"  => nullToEmpty($rs['team_name']),
					  				"gn"  => nullToEmpty($rs['group_name']),
					  				"o" => isonline( $rs['agent_id'] ),
					  	
					  				"nl"  => nullToEmpty($rs['remain_new_list']),
					  				"nc"  => nullToEmpty($rs['remain_no_contact']),
					  				"cb"  => nullToEmpty($rs['remain_callback']),
					  				"fu"  => nullToEmpty($rs['remain_followup']),
					  	
					  	
							);   
					$count++;  
				}
			    if($count==0){
					$tmp3 = array("result"=>"empty");
				} 
			
	     
		     /*
	     
	     $sql = " SELEC";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
				$progress = ((($rs['total_call'] - $rs['new_cnt'] ) * 100 ) / $rs['total_call'] );
			  	$tmp6[$count] = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"aid"  => nullToEmpty($rs['agent_id']),
			  					"aname"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
			  					"aimg"  => nullToEmpty($rs['img_path']),
			  					"aext"  => nullToEmpty($rs['extension']),
			  					"ateam"  => nullToEmpty($rs['team_name']),
			  					"agroup"  => nullToEmpty($rs['group_name']),
			  					"aext"  => nullToEmpty($rs['extension']),			  	
							    "tcall"  => nullToEmpty($rs['total_call']),
			  		  			"tnew"  => nullToEmpty($rs['new_cnt']),
			  	     			"tsuccess"  => nullToEmpty($rs['success_cnt']),
								"tcallback"  => nullToEmpty($rs['callback_cnt']),
			  					"tfollow"  => nullToEmpty($rs['follow_cnt']),			  	
							    "tdnc"  => nullToEmpty($rs['dnc_cnt']),
			  	    			"tbad"  => nullToEmpty($rs['bad_cnt']),
			  					"pgress"  => nullToZero( ceil($progress)),
			  	
						);   
				$count++;  
			}
		    if($count==0){
			$tmp6 = array("result"=>"empty");
			} 
			
			*/
		$data = array("login"=>$tmp1 , "hands"=>$tmp3);
		
		$dbconn->dbClose();
		echo json_encode( $data ); 
	     
		
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
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     
	     $startdate = "";  $enddate = "";
	     if( isset($_POST['condition'])){
	     	switch($_POST['condition']){
	     		case "today"		     :  $startdate = today_start();  $enddate = today_end(); break;
	     		case "yesterday"    :  $startdate = yesterday_start();  $enddate = yesterday_end(); break;
	     		case "thisweek"      :  $startdate = thisweek_start();  $enddate = thisweek_end(); break;
	     		case "thismonth"   :  $startdate = thismonth_start();  $enddate = thismonth_end(); break;
	     	}
	     }
	     
	     
	     $sql =" SELECT campaign_id , ag.agent_id , ag.first_name , ag.last_name , ag.img_path ,  ag.extension, t.team_name , group_name , ". 
	     			" count( calllist_id ) as total_call".
	       			" , sum( new_cnt ) as new_cnt".
	     			" , sum( callback_cnt ) as callback_cnt".
	     			" , sum( follow_cnt ) as follow_cnt".
	     			" , sum( dnc_cnt ) as dnc_cnt".
	     			" , sum( bad_cnt ) as bad_cnt".
	     			" , sum( submit_cnt ) as submit_cnt".
	         		" , sum( nocontact_cnt ) as nocontact_cnt".
					" FROM  ( ".
					" select campaign_id ,agent_id ,calllist_id ".
	     			" ,case when last_wrapup_option_id IS NULL then 1 else 0 end as new_cnt ". 
					" ,case when last_wrapup_option_id = 1 then 1 else 0 end as callback_cnt ".
	     			" ,case when last_wrapup_option_id IN ( 2 , 9 )  then 1 else 0 end as follow_cnt ".
					" ,case when last_wrapup_option_id = 3 then 1 else 0 end as dnc_cnt ".
	     			" ,case when last_wrapup_option_id = 4 then 1 else 0 end as bad_cnt ".
	     			" ,case when last_wrapup_option_id = 6 then 1 else 0 end as submit_cnt ". 
	     			" ,case when last_wrapup_option_id = 8 then 1 else 0 end as nocontact_cnt ".  
					" FROM t_calllist_agent ".
					" ) AS a ".
	      			" LEFT OUTER JOIN t_agents ag ON a.agent_id = ag.agent_id ". 
	     			" LEFT OUTER JOIN t_group g ON ag.group_id = g.group_id ".
	     			" LEFT OUTER JOIN t_team t ON ag.team_id = t.team_id ".
					//-- where camoaign_id = 1 
					" GROUP BY campaign_id ,agent_id ";


			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1[$count] = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"aid"  => nullToEmpty($rs['agent_id']),
			  					"aname"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
			  					"aimg"  => nullToEmpty($rs['img_path']),
			  					"aext"  => nullToEmpty($rs['extension']),
			  					"ateam"  => nullToEmpty($rs['team_name']),
			  					"agroup"  => nullToEmpty($rs['group_name']),
			  					"aext"  => nullToEmpty($rs['extension']),			  	
							    "tcall"  => nullToZero($rs['total_call']),
			  	
			  					"tnew"  => nullToZero($rs['new_cnt']),
			  	     			"tsubmit"  => nullToZero($rs['submit_cnt']),
								"tcallback"  => nullToZero($rs['callback_cnt']),
			  					"tfollow"  => nullToZero($rs['follow_cnt']),			  	
			  					"tnocont"  => nullToZero($rs['nocontact_cnt']),		
			  	
							    "tdnc"  => nullToZero($rs['dnc_cnt']),
			  	    			"tbad"  => nullToZero($rs['bad_cnt']),
			  					"isonline" => isonline( $rs['agent_id'] ),
						);   
				$count++;  
			}
		    if($count==0){
			$data = array("result"=>"empty");
			} 

			$data = array("hands"=>$tmp1);
		
			//new list 
			$sql = " SELECT SUM(transfer_total) as total FROM t_calllist_transfer ".
						" WHERE transfer_date BETWEEN ".dbformat($startdate)." AND ".dbformat($enddate).  
						" AND transfer_type = 1 ".
						" AND transfer_on_status = 1 ".
						" AND transfer_to_id IN ( SELECT agent_id FROM t_agents WHERE team_id = 2 AND group_id = 1 ) ";
			wlog( "[dashboard_process][query] sql : ".$sql );
			
			//used list 
			$sql = "SELECT SUM(transfer_total) as total FROM t_calllist_transfer ".
						" WHERE transfer_date BETWEEN ".dbformat($startdate)." AND ".dbformat($enddate).   
						" AND transfer_type = 1";
						" AND transfer_on_status <> 1";
						" AND transfer_to_id IN ( SELECT agent_id FROM t_agents WHERE team_id = 2 AND group_id = 1 ) ";
				wlog( "[dashboard_process][query] sql : ".$sql );	
			//current list focus
			
				//new list used
				$sql = "SELECT". 
							"FROM t_calllist_agent".
							"WHERE last_wrapup_option_id IS NOT NULL ";
	
			//used list used
			//???
			
				$sql = "count new list no contact ,  call back  ,followup ";
				
				$sql = "count submit ";
				
				
			
		
				
			 
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
	

?>