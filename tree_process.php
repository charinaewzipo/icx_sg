<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php


   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
            case "init" : init(); break;

            
            /*
	        case "query"  : query(); break;
			case "detail"  : detail(); break;
			
			
			//case "save"    : save(); break;
			//save -> insert , update
			case "create" : create(); break;
			case "update" : update(); break;
			// move to deletecmp ( in the same )
			//case "delete"  : delete(); break;
			
			
			case "loadcaption" : load_caption(); break; 
			case "savecaption" : save_caption(); break;
			
			case "saveWrapup" : save_wrapup(); break;
			case "deleteWrapup" : delete_wrapup(); break;
			
			// campaign control
			case "stopcmp" : stop_cmp(); break;
			case "startcmp" : start_cmp(); break;
			case "removecmp" : delete_cmp(); break;
			
			// cmpaign list control
			case "savelist" : save_list(); break;
			case "removelist" : delete_list(); break;
 	   	    */
		 }
	}
	
	function init(){
	
	  		$dbconn = new dbconn;  
			$res = $dbconn->createConn();
		 	if($res==404){
					    $res = array("result"=>"dberror","message"=>"Can't connect to database");
					    echo json_encode($res);		
					    exit();
		     }
		     
				//tab wrapup config
				$sql = " SELECT wrapup_code , wrapup_dtl , parent_code , seq_no , `status` , remove_list , option_id ".
							" FROM t_wrapup_code ";
					
  			
				$count = 0;    
			    $result = $dbconn->executeQuery($sql);
				while($rs=mysqli_fetch_array($result)){   
				
				  	$tmp4[$count] = array(
							        "wcode"  => nullToEmpty($rs['wrapup_code']),
									"wdtl"  => nullToEmpty($rs['wrapup_dtl']),
				  	        		"pcode"  => nullToEmpty($rs['parent_code']),
									"seq"  => nullToEmpty($rs['seq_no']),
				  	        		"sts"  => nullToEmpty($rs['status']),
									"rmlist"  => nullToEmpty($rs['remove_list']),
						  	        "optid"  => nullToEmpty($rs['option_id']),
							);   
					$count++;  
				}
			    if($count==0){
				$tmp4 = array("result"=>"empty");
				} 
			 
			 
			$data = array( "wrapup" => $tmp4 ); 
		
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
			
	}
	
	function save_list(){
	
			$tmp = json_decode( $_POST['data'] , true); 
			$list = json_decode( $_POST['list'], true);
		
			
		    $dbconn = new dbconn;  
			$res = $dbconn->createConn();
		 	if($res==404){
					    $res = array("result"=>"dberror","message"=>"Can't connect to database");
					    echo json_encode($res);		
					    exit();
		     }
		     
		     $size = count($list);
		     for( $i=0; $i<$size;$i++){
				      $sql = "INSERT INTO t_campaign_list( campaign_id , import_id , join_user , join_date) VALUES ( ".
				     			 " ".dbNumberFormat( $tmp['cmpid'] )." ".
				      			 ",".dbNumberFormat( $list[$i] )." ".
				     			 ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				       	wlog("[campaign-pane_process][save_list] insert sql : ".$sql);
				     	$dbconn->executeUpdate($sql);   
		     
		     }
		     
		     //after join list to campaign
			//update campagin status 
			$status = check_cmpstatus();
	 				if( $status == 0){
	 					//check is another list that join this campaign 
		 				$sql = "SELECT COUNT(import_id) AS total  FROM t_campaign_list WHERE campaign_id = ".dbNumberFormat($tmp['cmpid']); 
		 				$result = $dbconn->executeQuery($sql);
						if($rs=mysqli_fetch_array($result)){
							if($rs['total'] > 0 ){
								$status = 2;
								//$sql = " UPDATE t_campaign SET `status` = 2 ";
							}else{
								$status = 1;
								//$sql = " UPDATE t_campaign SET `status` = 1 ";
							}
						}
	 				}
	 				/*
	 				else{
							$sql = " UPDATE t_campaign SET `status` = ".dbNumberFormat($status)." ";
					}
					*/
	 				
	 				$sql = "UPDATE t_campaign SET `status` = ".dbNumberFormat($status)." WHERE campaign_id = ".dbNumberFormat($tmp['cmpid']); 
					wlog("[campaign-pane_process][save_list] sql : ".$sql);
					//update sql;
		 			$dbconn->executeUpdate($sql);
	 				
		   	$dbconn->dbClose();	 
		   	$data = array("result"=>"success");
			echo json_encode( $data ); 
		
	}
	
	function delete_list(){
	
		$tmp = json_decode( $_POST['data'] , true); 
	    $dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	        $sql = "DELETE FROM  t_campaign_list WHERE campaign_id= ".dbNumberFormat($tmp['cmpid'])." AND import_id = ".dbNumberFormat($_POST['list'])." ";
	     	$success = $dbconn->executeUpdate( $sql );
	     	if($success){
	 		     //after join list to campaign
			//update campagin status 
			$status = check_cmpstatus();
	 				if( $status == 0){
	 					//check is another list that join this campaign 
		 				$sql = "SELECT COUNT(import_id) AS total  FROM t_campaign_list WHERE campaign_id = ".dbNumberFormat($tmp['cmpid']); 
		 				$result = $dbconn->executeQuery($sql);
						if($rs=mysqli_fetch_array($result)){
							if($rs['total'] > 0 ){
								$status = 2;
								//$sql = " UPDATE t_campaign SET `status` = 2 ";
							}else{
								$status = 1;
								//$sql = " UPDATE t_campaign SET `status` = 1 ";
							}
						}
	 				}
	 				/*
	 				else{
							$sql = " UPDATE t_campaign SET `status` = ".dbNumberFormat($status)." ";
					}
					*/
	 				
	 				$sql = "UPDATE t_campaign SET `status` = ".dbNumberFormat($status)." WHERE campaign_id = ".dbNumberFormat($tmp['cmpid']); 
					wlog("[campaign-pane_process][delete_list] sql : ".$sql);
					//update sql;
		 			$dbconn->executeUpdate($sql);
	     	}
	      	$dbconn->dbClose();	 
	   	
		   	$data = array("result"=>"success");
			echo json_encode( $data ); 
			
	}
	
	//check campaign shoud be status
	function check_cmpstatus(){
		
				$tmp = json_decode( $_POST['data'] , true); 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				
			//check campaign current status;
				$skip = true;
				$status = 0; //default status set to new
			   //check is expired
			   //expired status == 5
			   //?
			   $sql = "SELECT DATEDIFF(end_date,NOW() ) AS df  FROM t_campaign WHERE campaign_id = ".dbNumberFormat( $tmp['cmpid'] )." AND is_expire = 1 ";
			   wlog($sql);
			   $result = $dbconn->executeQuery($sql);
				if($rs=mysqli_fetch_array($result)){
					if( $rs['df'] <  0){
						$status = 5 ;
						$skip = false;
					}
				}
		
			   //check is in use
			   //inuse status == 3
			   //?
			   if($skip){
						 $sql = "SELECT COUNT(*) AS total FROM t_calllist_agent WHERE campaign_id = ".dbNumberFormat( $tmp['cmpid'] );
						    wlog($sql);
				 		 $result = $dbconn->executeQuery($sql);
							if($rs=mysqli_fetch_array($result)){
								if( $rs['total'] >= 1 ){
										$status = 3;
										$skip = false;
								}
							}
			   }
			   
			
			   //check is active 
			   //active status == 2
			   //?
	  			 if($skip){
						 $sql = "SELECT COUNT(*) AS total FROM t_campaign_list WHERE campaign_id = ".dbNumberFormat( $tmp['cmpid'] );
						    wlog($sql);
				 		 $result = $dbconn->executeQuery($sql);
							if($rs=mysqli_fetch_array($result)){
								if( $rs['total'] >= 1 ){
										$status = 2;
										$skip = false;
								}
							}
			    }
			    
			    //if status == 0 mean not thing from above
			    wlog("[campaign-pan_process][check_cmpstatus] return status : [".$status."]");
			    return $status;
	
	}
	
	function stop_cmp(){
		
				$tmp = json_decode( $_POST['data'] , true); 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
				//report all info abount campagin 
				
				
			   //update campaign
			   //stop status == 4   
				$sql = "UPDATE t_campaign SET ".
					        "`status` = 4 ,".
						    "update_date =NOW(),".
						    "update_user =".dbformat( $tmp['uid'])." ".
						    "WHERE campaign_id = ".dbformat( $tmp['cmpid'])." ";	
				
				$dbconn->executeUpdate($sql); 
	            $dbconn->dbClose(); 
			    $res = array("result"=>"success");
				echo json_encode($res);   
				
	}
	
	function start_cmp(){
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				
				//check campaign current status;
				$skip = true;
				$status = 0; //default status set to new
			   //check is expired
			   //expired status == 5
			   //?
			   $sql = "SELECT DATEDIFF(end_date,NOW() ) AS df  FROM t_campaign WHERE campaign_id = ".dbNumberFormat( $tmp['cmpid'] )." AND is_expire = 1 ";
			   wlog($sql);
			   $result = $dbconn->executeQuery($sql);
				if($rs=mysqli_fetch_array($result)){
					if( $rs['df'] <  0){
						$status = 5 ;
						$skip = false;
					}
				}
		
			   //check is in use
			   //inuse status == 3
			   //?
			   if($skip){
						 $sql = "SELECT COUNT(*) AS total FROM t_calllist_agent WHERE campaign_id = ".dbNumberFormat( $tmp['cmpid'] );
						    wlog($sql);
				 		 $result = $dbconn->executeQuery($sql);
							if($rs=mysqli_fetch_array($result)){
								if( $rs['total'] >= 1 ){
										$status = 3;
										$skip = false;
								}
							}
			   }
			   
			
			   //check is active 
			   //active status == 2
			   //?
	  			 if($skip){
						 $sql = "SELECT COUNT(*) AS total FROM t_campaign_list WHERE campaign_id = ".dbNumberFormat( $tmp['cmpid'] );
						    wlog($sql);
				 		 $result = $dbconn->executeQuery($sql);
							if($rs=mysqli_fetch_array($result)){
								if( $rs['total'] >= 1 ){
										$status = 2;
										$skip = false;
								}
							}
			    }
			    
			   //else
			   // new status == 1
			    if($status==0){
			    	$status = 1 ;
			    }
			
			   //update date to campaign status
				$sql = " UPDATE t_campaign SET ".
							" `status` = ".dbNumberFormat($status)." ".					   
						    " update_date =NOW(),".
						    " update_user =".dbformat( $tmp['uid'])." ".
						    " WHERE campaign_id = ".dbformat( $tmp['cmpid'])." ";	
				   wlog($sql);
				$dbconn->executeUpdate($sql); 
	            $dbconn->dbClose(); 
			    $res = array("result"=>"success");
				echo json_encode($res);   
	}
	
	function delete_cmp(){
		
		    $tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
				
			$sql = " DELETE FROM t_campaign WHERE campaign_id = ".dbNumberFormat( $tmp['cmpid'])." ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	
	
	function init_wrapup(){
		
		$tmp = json_decode( $_POST['data'] , true); 
	    $dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     $sql = " SELECT wrapup_code , wrapup_dtl , parent_code , seq_no , `status` , remove_list , option_id  ".
	     			" FROM t_wrapup_code ";
	     			" ";
	     
		  wlog("[campaign-pane_process][save_wrapup] sql : ".$sql);
	     $result = $dbconn->executeQuery($sql);
	     $count = 0;
		  while($rs=mysqli_fetch_array($result)){
		  	/*
				$data[$count] = array( 
						$rs['wrapup_code'];
						$rs['wrapup_dtl'];
						$rs['parent_code'];
						$rs['seq_no'];
						$rs['status'];
						$rs['remove_list'];
						$rs['option_id'];
				
				);
				*/
		  }

		  $dbconn->dbClose();
	}
	
	function save_wrapup(){
		$tmp = json_decode( $_POST['data'] , true); 
	    $dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     $sql = "DELETE FROM t_wrapup_code WHERE wrapup_code = ";
	     wlog("[campaign-pane_process][save_wrapup] sql : ".$sql);
	     $result = $dbconn->executeQuery($sql);
		  while($rs=mysqli_fetch_array($result)){
				$data[$count] = array( 
				
				
				);
		  }

		  $dbconn->dbClose();
		  
	}
	
	function delete_wrapup(){
		$tmp = json_decode( $_POST['data'] , true); 
	    $dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     $sql = "SELECT FROM ";
	     wlog("[campaign-pane_process][delete_wrapup] sql : ".$sql);
	     
	    $success = $dbconn->executeUpdate($sql);
	    if($success){
	    	
	    }
	     
	}
	
	
	// save campaign caption 
	function save_caption(){
		//used old algorithm delete all then insert
		$tmp = json_decode( $_POST['data'] , true); 
		
	    $dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //delete
	     $sql = "DELETE FROM t_campaign_field WHERE campaign_id = ".dbNumberFormat($tmp['cmpid']);
	     $dbconn->executeUpdate($sql); 
	     
	     //insert
	     if( isset($_POST['field']) ){
	     	
	     	  $field = json_decode( $_POST['field'] , true); 
		     for( $i=0 ; $i < count( $field['data'] ) ; $i++){
		     	
			     	   $sql = " INSERT INTO t_campaign_field( seq , campaign_id , caption_name , field_name,  caption_option  , show_on_callwork , show_on_profile, create_user, create_date ) VALUES ( ".
			     	   
							   		   " ".dbNumberFormat( $field['data'][$i]['seq'])." ".
									   ",".dbNumberFormat( $tmp['cmpid'])." ".
						   	   		   ",".dbformat( $field['data'][$i]['caption'])." ".
			     	      			   ",".dbformat( $field['data'][$i]['field'])." ".
								   	   ",".dbformat( $field['data'][$i]['option'])." ".
								   	   ",".dbNumberFormat( $field['data'][$i]['workpage'])." ".
						     		   ",".dbNumberFormat( $field['data'][$i]['profilepage'])." ".
									   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
			     	   
							$dbconn->executeUpdate($sql); 
			     }
	     }
	     
	}
	
	//initial configuration for caption field
	function load_caption(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //init caption field
		$sql = "SELECT field_name , field_alias_name".
					" FROM ts_field_list ".
					" ORDER BY field_name";
		
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp1[$count] = array(
						        "id"  => nullToEmpty($rs['field_name']),
								"value"  => nullToEmpty($rs['field_alias_name'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			
			//query current campaign caption
				$sql = " SELECT rowid , caption_name , field_name , show_on_callwork , show_on_profile ".
							" FROM t_campaign_field ".
							" WHERE campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
							" ORDER BY seq ";
		
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp2[$count] = array(
			  				     "id"  => nullToEmpty($rs['rowid']),
						        "capn"  => nullToEmpty($rs['caption_name']),
								"fieldn"  => nullToEmpty($rs['field_name']),
			  					"callwork"  => nullToZero($rs['show_on_callwork']),
			  					"profile"  => nullToZero($rs['show_on_profile'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
			
			$data = array("caption"=>$tmp1,"data"=>$tmp2);
			
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
		
	}
	
	
	function query(){
		//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
  			$sql = " SELECT campaign_id,campaign_name,campaign_detail,start_date,end_date,c.status, st.status_detail ". 
						" FROM t_campaign c ".
  						" LEFT OUTER JOIN ts_campaign_status st ON c.status = st.status_id ".
						" ORDER BY campaign_id ";
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$data[$count] = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"cmpName"  => nullToEmpty($rs['campaign_name']),
							    "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
							    "cmpStartDate"  => dateDecode($rs['start_date']),
						  	 	"cmpEndDate"  => dateDecode($rs['end_date']),
			 				 	"cmpStatus" => nullToEmpty($rs['status']),
						  		"cmpStatusDetail" => nullToEmpty($rs['status_detail']),
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
		//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
  			$sql = " SELECT campaign_id,campaign_name,campaign_detail, start_date,end_date, c.status, st.status_detail, c.script_id,s.script_detail, ". 
  						" a.first_name , a.last_name , c.create_date ".
						" FROM t_campaign c LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
  						" LEFT OUTER JOIN ts_campaign_status st ON c.status = st.status_id ".
  						" LEFT OUTER JOIN t_agents a ON a.agent_id = c.create_user ".
  						" WHERE campaign_id = ".dbNumberFormat( $_POST['id'] )." ";
					
  			wlog( $sql );
			$count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1 = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"cmpName"  => nullToEmpty($rs['campaign_name']),
							    "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
							    "cmpStartDate"  => dateDecode($rs['start_date']),
						  	 	"cmpEndDate"  => dateDecode($rs['end_date']),
						  		"cmpStatus"  => nullToEmpty($rs['status']),
			  					"cmpStatusDtail"  => nullToEmpty($rs['status_detail']),
			  					"callscriptid"  => nullToEmpty($rs['script_id']),
			  					"callscriptdtl"  => nullToEmpty($rs['script_detail']),
			  				   "created"  => getDatetimeFromDatetime($rs['create_date']),
			  					"createu" => nulltoEmpty($rs['first_name']." ".$rs['last_name']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			$sql = " SELECT script_id , script_name  ". 
						" FROM t_callscript ".
  						" ORDER BY script_name ";
					
			$count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp2[$count] = array(
						        "id"  => nullToEmpty($rs['script_id']),
								"value"  => nullToEmpty($rs['script_name'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
			
			
			//campaign list
			$sql = "SELECT l.campaign_id , c.campaign_name , i.import_id,i.list_name  ".
						" ,CASE WHEN l.campaign_id IS NOT NULL THEN 1 ELSE 0 END AS is_exists ". 
						" ,COUNT(cl.calllist_id) AS totallist ".
						" FROM t_import_list i ".
						" LEFT OUTER JOIN t_campaign_list l ON (  i.import_id = l.import_id  AND l.campaign_id = ".dbNumberFormat( $_POST['id'] )." )   ".
						" LEFT OUTER JOIN t_campaign c ON ( l.campaign_id = c.campaign_id  ) ". 
						" LEFT OUTER JOIN t_calllist cl  ON ( cl.import_id = i.import_id   ) ".
						" WHERE i.list_name IS NOT NULL ".
						" GROUP BY l.campaign_id , c.campaign_name  , i.import_id,i.list_name ,i.total_records , ". 
 						" CASE WHEN l.campaign_id IS NOT NULL THEN 1 ELSE 0 END ".
						" ORDER BY i.import_id DESC ";
			
			wlog($sql);
		    $result = $dbconn->executeQuery($sql);
		    $count = 0;
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp3[$count] = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"cmpname"  => nullToEmpty($rs['campaign_name']),
			  					"total"  => nullToZero($rs['totallist']),
							  	"impid"  => nullToEmpty($rs['import_id']),
							  	"lname"  => nullToEmpty($rs['list_name']),
			  					"exist"  => nullToEmpty($rs['is_exists']),
			  					"unava" => count_cmplistagent( $_POST['id'] )
						);   
				$count++;  
			}
			
			/*
	   	  //tab summary list in campaign
		     $sql = " SELECT list_name , list_detail, count( calllist_id ) as total_call ".
		     			" , sum( newlist_cnt ) as newlist_cnt ". 
						" , sum( callback_cnt ) as callback_cnt ".
						" , sum( followup_cnt ) as followup_cnt ".
						" , sum( dnd_cnt ) as dnd_cnt ".
						" , sum( badlist_cnt ) as badlist_cnt ". 
						" , sum( maxtry_cnt ) as maxtry_cnt ".
						" , sum( sales_cnt ) as sales_cnt ".
						" from ( ".
										" select a.calllist_id , list_name , list_detail ".
		     							" ,case when last_wrapup_option_id is null then 1 else 0 end as newlist_cnt ". 
										" ,case when last_wrapup_option_id = 1 then 1 else 0 end as callback_cnt ". 
										" ,case when last_wrapup_option_id = 2 then 1 else 0 end as followup_cnt ".
										" ,case when last_wrapup_option_id = 3 then 1 else 0 end as dnd_cnt ".
										" ,case when last_wrapup_option_id = 4 then 1 else 0 end as badlist_cnt ". 
										" ,case when last_wrapup_option_id = 5 then 1 else 0 end as maxtry_cnt ".
										" ,case when last_wrapup_option_id = 6 then 1 else 0 end as sales_cnt ".
										" from t_calllist_agent a ".
			     							" left outer join t_calllist c on a.calllist_id = c.calllist_id".
			     							" left outer join t_import_list i on i.import_id = c.import_id".
										" where a.campaign_id = ".dbNumberFormat( $_POST['id'] )." ".
						" ) as tmp ";		
	     
	 		$result = $dbconn->executeQuery($sql);
	 		$count = 0;
			while($rs=mysqli_fetch_array($result)){
					$tmp3[$count] = array(
						"lid" => nullToEmpty($rs['list_name']),
						"ldetail" => nullToEmpty($rs['list_detail']),
						"total" => nullToEmpty($rs['total_call']),
						"newlist" => nullToEmpty($rs['newlist_cnt']),
						"cback" => nullToEmpty($rs['callback_cnt']),
						"follow" => nullToEmpty($rs['followup_cnt']),
						"dnd" => nullToEmpty($rs['dnd_cnt']),
						"blist" => nullToEmpty($rs['badlist_cnt']),
						"maxtry" => nullToEmpty($rs['maxtry_cnt']),
						"sales" => nullToEmpty($rs['sales_cnt']),
					);					
					$count++;
			}
			
		
		    if($count==0){
				$tmp3 = array("result"=>"empty");
			} 
			*/
			
			//tab wrapup config

				$sql = " SELECT wrapup_code , wrapup_dtl , parent_code , seq_no , `status` , remove_list , option_id ".
							" FROM t_wrapup_code ";
					
  			
				$count = 0;    
			    $result = $dbconn->executeQuery($sql);
				while($rs=mysqli_fetch_array($result)){   
				
				  	$tmp4[$count] = array(
							        "wcode"  => nullToEmpty($rs['wrapup_code']),
									"wdtl"  => nullToEmpty($rs['wrapup_dtl']),
				  	        		"pcode"  => nullToEmpty($rs['parent_code']),
									"seq"  => nullToEmpty($rs['seq_no']),
				  	        		"sts"  => nullToEmpty($rs['status']),
									"rmlist"  => nullToEmpty($rs['remove_list']),
						  	        "optid"  => nullToEmpty($rs['option_id']),
							);   
					$count++;  
				}
			    if($count==0){
				$tmp4 = array("result"=>"empty");
				} 
			 
			 
			$data = array("data"=>$tmp1,"callscript"=>$tmp2, "cmplist" => $tmp3 , "wrapup" => $tmp4 ); 
		
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	
	//count list that distribute to agents
	function count_cmplistagent( $cmpid ){
	
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
				//count between campaign and campaign agent 
				$sql = "SELECT COUNT(calllist_id) AS totallist FROM t_calllist_agent WHERE campaign_id = ".dbNumberFormat($cmpid)." ";
		    
				$total = 0;
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
	      				$total= nullToZero($rs['totallist']);
				}
	
			return $total;
				
	}
	

	//insert campaign
	 function create(){
	 
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				
		   			//insert new campaign
				   $sql = " INSERT INTO t_campaign( campaign_name,campaign_detail, is_expire , start_date,end_date,status , script_id, create_user, create_date ) VALUES ( ".
					   		   " ".dbformat( $tmp['ncmpName'])." ".
							   ",".dbformat( $tmp['ncmpDetail'])." ".
				   			   ",".dbformat( $tmp['ncmpExpire'])." ".
				   	   		   ",".dateEncode( $tmp['ncmpStartDate'])." ".
						   	   ",".dateEncode( $tmp['ncmpEndDate'])." ".
						   	   ", 1 ". //new status == 1
				     		   ",".dbNumberFormat( $tmp['scriptname'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				   
			wlog("[campaign-pane_process][create] create campaign sql : ".$sql);	   
			$dbconn->executeUpdate($sql);
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
			
	 }
	 
	 //update campaign
	 function update(){
	  
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
					
			   //update   
				$sql = "UPDATE t_campaign SET ".
					        "campaign_name =".dbformat( $tmp['cmpName']).",".
						    "campaign_detail =".dbformat( $tmp['cmpDetail']).",".	
				 		  	"start_date =".dateEncode( $tmp['cmpStartDate']).",".	
						  	"end_date =".dateEncode( $tmp['cmpEndDate']).",".	
						  	"status =".dbformat( $tmp['cmpStatus']).",".	
				 			"script_id =".dbNumberFormat( $tmp['scriptname']).",".	
						    "update_date =NOW(),".
						    "update_user =".dbformat( $tmp['uid'])." ".
						    "WHERE campaign_id = ".dbformat( $tmp['cmpid'])." ";	
				
				$dbconn->executeUpdate($sql); 
	            $dbconn->dbClose(); 
			    $res = array("result"=>"success");
				echo json_encode($res);   
	  
	}
	
	

	   

	