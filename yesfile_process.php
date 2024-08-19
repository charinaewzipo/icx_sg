<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php

   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
         
	        case "yesfile"  : query(); break;
	        case "history" : history(); break;
	        
		 }
	}
	
	
	function remove_remark(){
		
			$tmp = json_decode( $_POST['data'] , true); 
			 	
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
				//delete is update set is active = 0
					$sql = " UPDATE  t_ticket_comment SET ".
								" is_active = 0 ,".	
							    " update_date = NOW(),".
							    " update_user =".dbNumberFormat( $tmp['uid'])." ".
								" WHERE ticket_id = ".dbNumberFormat( $tmp['tid'])." ".
								" AND msg_id =  ".dbNumberFormat( $_POST['msgid']);
					
				 	wlog("[ticket_process][remove_remark] update sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
		
	}
	
	function update_remark(){
		
			 	$tmp = json_decode( $_POST['data'] , true); 
			 	
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
					$sql = "UPDATE t_ticket_comment SET ".
						        "msg_detail =".dbformat( $tmp['edit_remark_msg']).",".
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE ticket_id = ".dbNumberFormat( $tmp['tid'])." ".
								"AND msg_id =  ".dbNumberFormat( $_POST['msgid']);
					
				 	wlog("[ticket_process][update_remark] update sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
		
		
	}
	
	function query_remark(){
		
			    $tmp = json_decode( $_POST['data'] , true); 
			 	
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
				$sql = " SELECT  ticket_id , msg_id , msg_detail , c.create_user , c.create_date , a.first_name , a.last_name , a.img_path ".
							" FROM  t_ticket_comment c  LEFT OUTER JOIN t_agents a ON c.create_user = a.agent_id ".
							" WHERE ticket_id = ".dbNumberFormat($_POST["id"]).
							" AND c.is_active = 1 ";
				
				wlog($sql);
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$data[$count] = array(
			  	     			"tid"  => nullToEmpty($rs['ticket_id']),
						        "msgid"  => nullToEmpty($rs['msg_id']),
			  	    			"msgdtl"  => nullToEmpty($rs['msg_detail']),
								"creu"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
							    "creimg"  => nullToEmpty($rs['img_path']),
			  					"timstamp"  => nullToEmpty($rs['create_date']),		
			  					"cred"  => allthaidate($rs['create_date']),			  	
						);   
				$count++;  
			}
		    if($count==0){
			$member = array("result"=>"empty");
			} 
				
			$dbconn->dbClose();	 
		 	$data = array("rem"=>$data );		 	
			echo json_encode( $data ); 
		
				
	}
	
	function save_remark(){
		

				$tmp = json_decode( $_POST['data'] , true); 
			 	
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
				$sql = "SELECT ticket_id FROM t_ticket_comment WHERE ticket_id = ".dbNumberFormat($tmp["isid"])." AND msg_id = ".dbNumberFormat()."  ";
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update   
					$sql = "UPDATE t_ticket_comment SET ".
						        "msg_detail =".dbformat( $tmp['remark']).",".
								"is_active =".dbNumberFormat( $tmp['cat1']).",".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE ticket_id = ".dbNumberFormat( $tmp['isid'])." ".
								"AND msg_id =  ".dbNumberFormat( $tmp['isid']);
					 wlog("[ticket_process][save_remark] update sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					 
				}else{

				   //insert
					$sql = "INSERT INTO t_ticket_comment ( ticket_id  , msg_detail  , is_active , create_user , create_date ) VALUES ( ".
				      		   " ".dbformat( $tmp['tid'])." ".
							   ",".dbformat( $tmp['remark'])." ".
						   	   ", 1 ". //default value 
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				   wlog("[ticket_process][save_remark] insert sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					
				}		

            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
			
			
		
		
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
	           	/*
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
			*/
	     
	        $sql = " SELECT COUNT(*) AS total FROM t_issues WHERE cat2 = 1 AND status != 3 ";
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1 = array(
						        "total"  => nullToEmpty($rs['total']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp1 = array("result"=>"empty");
			} 
			
		    $sql = " SELECT COUNT(*) AS total FROM t_issues WHERE cat2 = 2 AND status != 3 ";
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp2 = array(
						        "total"  => nullToEmpty($rs['total']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp2 = array("result"=>"empty");
			} 
	     
			 $sql = " SELECT COUNT(*) AS total FROM t_issues WHERE cat2 = 3 AND status != 3 ";
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp3 = array(
						        "total"  => nullToEmpty($rs['total']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp3 = array("result"=>"empty");
			} 
			
			    $sql = " SELECT COUNT(*) AS total FROM t_issues WHERE cat2 = 4  AND status != 3 ";
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp4 = array(
						        "total"  => nullToEmpty($rs['total']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp4 = array("result"=>"empty");
			} 
	     
			
		 	$dbconn->dbClose();	 
		 	$data = array("bug"=>$tmp1,"req"=>$tmp2,"chreq"=>$tmp3,"idea"=>$tmp4  );		 	
			echo json_encode( $data ); 
		
		
	}
	

	
	function query(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
  		 
	     //check level of agent for permission
	     wlog("".$_POST['view']); 
	     switch( $_POST['view'] ){
	     	case "inbox-new" :
	     		    if( $tmp['lvl'] == "1" ){
	     		    	//agent
	     			$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
								" FROM t_ticket t ".
	     						" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
	     						" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
	     						" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
								" WHERE t.is_active = 1 ".
	     						" AND t.create_user = ".dbNumberFormat($tmp['uid'])." ".
	     						" AND t.ticket_status = 1 ";
	     		    }else{
	     			//qc  = agent submit
     		 		$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
								" FROM t_ticket t ".
		     					" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
		     					" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
		     					" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
		     					" WHERE t.is_active = 1 ".
								" AND t.ticket_status = 2  ";   //inbox : status = submit
	     		    }
	     			 break;	     	
     		case "inbox-submit" :
     			$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
							" FROM t_ticket t ".
     						" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
     						" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
     						" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
     						" WHERE t.is_active = 1 ".
							" AND t.ticket_status = 2  ".
     						" AND t.owner_id = ".dbNumberFormat($tmp['uid']);
     			break;		 
	     	case "inbox-inbox" : 
	     		
	     			$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
								" FROM t_ticket t ".
	     						" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
	     						" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
	     						" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
	     						" WHERE t.is_active = 1 ".
								" AND t.ticket_status = 3  ".
	     						" AND t.owner_id = ".dbNumberFormat($tmp['uid']);
	     			break;
	     			
	     	case "inbox-inprogress" : 
	     			$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
								" FROM t_ticket t ".
	     						" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
	     						" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
	     						" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
	     						" WHERE t.is_active = 1 ".
								" AND t.ticket_status = 3  ";  //inbox : status = inprogress
	     						" AND t.create_user = ".dbNumberFormat($tmp['uid']);  
	     			break;
	     			
	     	case "inbox-reconfirm" : 
	     			$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
								" FROM t_ticket t ".
	     						" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
	     						" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
	     						" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
								" WHERE  t.ticket_status = 5  ";   //inbox : status = inprogress
	     						" AND  t.owner_id = ".dbNumberFormat($tmp['uid']);  
	     			break;
	     			
	     	case "inbox-approved" :
	     			//agent
	     		    if( $tmp['lvl'] == "1" ){
					$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
								" FROM t_ticket t ".
	     						" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
	     						" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
	     						" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
								" WHERE  t.ticket_status = 4  ";   //inbox : status = inprogress
	     						" AND  t.create_user = ".dbNumberFormat($tmp['uid']);  
	     		    }else{
	     		
	     			//qc
	     			$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
								" FROM t_ticket t ".
	     						" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
	     						" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
	     						" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
								" WHERE  t.ticket_status = 4  ";   //inbox : status = inprogress
	     						" AND  t.owner_id = ".dbNumberFormat($tmp['uid']);  
	     		    }
	     			break;
	     	case "inbox-reject" :
	     			$sql = " SELECT ticket_id , app_uniqueid , ticket_status , ts.ticket_status_detail , t.cust_fname, t.cust_lname , c.campaign_name , calllist_id , owner_id , t.is_active , app_uniqueid , t.create_date , a.first_name , a.last_name ".
								" FROM t_ticket t ".
	     						" LEFT OUTER JOIN t_agents a ON a.agent_id = t.create_user ". 
	     						" LEFT OUTER JOIN t_campaign c ON t.campaign_id = c.campaign_id ". 
	     						" LEFT OUTER JOIN tl_ticket_status ts ON ts.ticket_status_id = t.ticket_status ".
								" WHERE  t.ticket_status = 6  ";   //inbox : status = inprogress
	     						" AND  t.owner_id = ".dbNumberFormat($tmp['uid']);  
	     			break;
	     			
	     	case "inbox-trash" : break;
	     			
	     }
	        wlog("[ticket_process][query] sql : ".$sql); 
	    
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1[$count] = array(
					  			"tid"  => nullToEmpty($rs['ticket_id']),
			  					"appid"  => nullToEmpty($rs['app_uniqueid']),
								"tsts"  => nullToEmpty($rs['ticket_status']),
			  					"tstsdtl"  => nullToEmpty($rs['ticket_status_detail']),
			  					"cust"  => nullToEmpty($rs['cust_fname']." ".$rs['cust_lname']),
			  					"cmp"  => nullToEmpty($rs['campaign_name']),
							    "clid"  => nullToEmpty($rs['calllist_id']),
			  			  	 	"ownid"  => nullToEmpty($rs['owner_id']),
							  	"act"  => nullToEmpty($rs['is_active']),
							  	"uniq"  => nullToEmpty($rs['app_uniqueid']),
							  	"creu"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
			  					"cred"  => getDatetimeFromDatetime($rs['create_date']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			//count nav
					$sql = "SELECT COUNT(ticket_id) AS total ".
							" ,SUM(count_new) AS total_new ".
							" ,SUM(count_submit) AS total_submit ".
							" ,SUM(count_inprogress) AS total_inprogress ".
							" ,SUM(count_approved) AS total_approved ".
							"  ,SUM(count_reconfirm) AS total_reconfirm ".
							" ,SUM(count_reject) AS total_reject ".
						" FROM ( ".
							" SELECT ticket_id ".
							" ,CASE WHEN ticket_status = 1 THEN 1 ELSE 0 END AS count_new ".
							" ,CASE WHEN ticket_status = 2 THEN 1 ELSE 0 END AS count_submit ".
							" ,CASE WHEN ticket_status = 3 THEN 1 ELSE 0 END AS count_inprogress ".
							" ,CASE WHEN ticket_status = 4 THEN 1 ELSE 0 END AS count_approved ".
							" ,CASE WHEN ticket_status = 5 THEN 1 ELSE 0 END AS count_reconfirm ".
							" ,CASE WHEN ticket_status = 6 THEN 1 ELSE 0 END AS count_reject ".
							" FROM t_ticket ".
							" WHERE create_user = 10 ".
						" ) AS a";
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$tmp2 = array(
						        "total"  => zeroToEmpty($rs['total']),
			  					"tnew"  => zeroToEmpty($rs['total_new']),			  	
							    "tsub"  => zeroToEmpty($rs['total_submit']),
			  	    			"tinp"  => zeroToEmpty($rs['total_inprogress']),
						  		"tappr"  => zeroToEmpty($rs['total_approved']),
						  		"treconf"  => zeroToEmpty($rs['total_reconfirm']),
						  		"trej"  => zeroToEmpty($rs['total_reject']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp2 = array("result"=>"empty");
			} 
			
			$data = array("data"=>$tmp1,"cnav"=>$tmp2);
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
	     //how to get detail
	     //1 find customize app table from select app id from table t_ticket
	     $sql = "SELECT table_name FROM t_ticket_app WHERE app_id = ";
	     //2 select field from table tl_app_field
	     $sql = "SELECT field_name FROM tl_app_field WHERE app_id = "; 
	     //3 or select from view
	     $sql = "";
	     
  	     $sql = " SELECT issue_id , subject , detail , solution , cat1 , cat2 , status , a.first_name , a.last_name , s.create_date   ".
					 " FROM t_issues s LEFT OUTER JOIN t_agents a ON s.create_user = a.agent_id ".
        		     " WHERE issue_id =  ".dbNumberFormat($_POST['id'])." ";
    
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$data =  array(
			  	      			"isid"  => nullToEmpty($rs['issue_id']),
								"sub"  => nullToEmpty($rs['subject']),
							    "det"  => nullToEmpty($rs['detail']),
			  			  	 	"sol"  => nullToEmpty($rs['solution']),
							  	"cat1"  => nullToEmpty($rs['cat1']),
							  	"cat2"  => nullToEmpty($rs['cat2']),
			  					"sts"  => nullToEmpty($rs['status']),
							  	"creu"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
			  					"cred"  => getDatetimeFromDatetime($rs['create_date']),
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
				$id = json_decode( $_POST['id'], true); 
				wlog($id);
				$id = implode(",", $id);
			 	
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				
				
				$sql = " UPDATE t_ticket SET ";
				switch( $_POST['saveaction'] ){
					case "submit" 		: $sql = $sql."ticket_status =  2"; break;
					case "takeowner"  : $sql = $sql."ticket_status =  3 , owner_id = ".dbNumberFormat($tmp['uid'])." "; break;
					case "conf"				: $sql = $sql."ticket_status =  4"; break;
					case "reconf" 			: $sql = $sql."ticket_status =  5"; break;
					case "reject" 			: $sql = $sql."ticket_status =  6"; break;					
				}
				$sql = $sql." WHERE ticket_id IN (".$id.")";
				$rs = $dbconn->executeUpdate($sql); 
				
				wlog("[ticket_process][save] save action [".$_POST['saveaction']."] sql  : ".$sql." result update ".$rs);
				   /*
				
				$sql = "INSERT INTIO t_ticket ( ticket_status , calllist_id , campaign_id , is_active , owner_id , create_user , create_date ) VALUES ( )";
			 
				$sql = "SELECT issue_id FROM t_issues WHERE issue_id = ".dbNumberFormat($tmp["isid"])." ";
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update   
					$sql = "UPDATE t_issues SET ".
						        "subject =".dbformat( $tmp['sub']).",".
							    "detail =".dbformat( $tmp['det']).",".
					 			"solution =".dbformat( $tmp['sol']).",".
								"cat1 =".dbNumberFormat( $tmp['cat1']).",".	
					 			"cat2 =".dbNumberFormat( $tmp['cat2']).",".
							    "status =".dbNumberFormat( $tmp['status']).",".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE issue_id = ".dbNumberFormat( $tmp['isid'])." ";	
					$dbconn->executeUpdate($sql); 
					 
				}else{

				   //insert
				   $sql = " INSERT INTO t_issues(  subject , detail , solution , cat1 , cat2 , status ,create_user,create_date  ) VALUES ( ".
				      		   " ".dbformat( $tmp['sub'])." ".
							   ",".dbformat( $tmp['det'])." ".
						       ",".dbformat( $tmp['sol'])." ".
						       ",".dbNumberFormat( $tmp['cat1'])." ".
						       ",".dbNumberFormat( $tmp['cat2'])." ".
						       ",".dbNumberFormat( $tmp['status'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				   
					$dbconn->executeUpdate($sql); 
					
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
				
			$sql = " DELETE FROM t_issues WHERE issue_id IN (".dbNumberFormat( $tmp['isid']).") ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	


?>