<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php


   	if(isset($_POST['action'])){ 
         switch( $_POST['action']){
         	
            case "init" : init(); break; //load select campaign
            
            //may deprecate 
	        case "query"  : query_newlist(); break;
	        case "query_dashboard" : query_dashboard(); break;
	        case "query_newlist" : query_newlist(); break;
	        case "query_nocontact" : query_nocontact(); break;
	        case "query_callback" : query_callback(); break;
	        case "query_followup" : query_followup(); break;
	        case "query_callhistory" : query_callhistory(); break;
	        
	        //is used
			case "detail"  : detail(); break;
			
			case "cmp_initial" : cmp_initial(); break;
			case "cmp_joinlog" : cmp_joinlog(); break;
			
			//case "save"    : save(); break;
			//case "delete"  : delete(); break;
			//test only
			//case "save_reminder" : save_reminder(); break;
			
			//test only
			//start lv1 of wrapup ( should keep to session )
			case "initwrapup" : init_wrapup(); break;
			// query other level of wrapup
			case "querywrapup" : query_wrapup(); break;
			// save wrapup 
			case "savewrapup" : save_wrapup(); break;
			//load popup content
			case "loadpopup_content" : loadpopup_content(); break;
			
			//search calllist
			//case "search_calllist" : search_calllist(); break;
			case "search_calllist" : query_newlist(); break;
			case "search_nocontact" : query_nocontact(); break;
			case "search_callback" : search_callback(); break;
			case "search_followup" : search_followup(); break;
			case "search_callhistory" : search_callhistory(); break;
			
			//search popup callhistory
			case "search_popupcallhistory" : search_popupcallhistory(); break;
			case "save_reminder" : save_reminder(); break;
			
 	   	     
		 }
	}
	
	function query_all(){
	
	
	}

	function save_reminder(){
	
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				
				  $dtime =  "";
				  $id = $tmp['pop_reminderOn'];
				  
					switch($id){
						case 1 : $dtime =  "ADDTIME(now(), '00:30:00')"; break;	
						case 2 : $dtime =  "ADDTIME(now(), '00:45:00')"; break;	
						case 3 : $dtime =  "ADDTIME(now(), '01:30:00')"; break;	
						case 4 : $dtime =  "ADDTIME(now(), '01:30:00')"; break;	
						case 5 : $dtime =  "ADDTIME(now(), '02:00:00')"; break;	
						case 6 : $dtime =  "ADDTIME(now(), '03:00:00')"; break;	
						case 7 : $dtime =  "ADDTIME(now(), '05:00:00')"; break;	
						case 8 : $dtime =  "ADDTIME(now(), '08:00:00')"; break;	
						case 9 : $dtime =  "NOW()+INTERVAL 1 DAY";     break;	
						case 10 : $dtime = ""; break;
					}
					
				wlog( $dtime );
				//$date = $tmp['reminderDate']."/".$tmp['reminderMonth']."/".$tmp['reminderYear'];
				
				$sql = "SELECT reminder_id FROM t_reminder WHERE reminder_id = ".dbformat($tmp['pop_reminderid'])." ";
				wlog( "[reminder_process][save] check sql : ".$sql );
		    
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysql_fetch_array($result)){   
					
				   //update   
					$sql = "UPDATE t_reminder SET ".
						        "reminder_dt =".$dtime.",".
								"subject =".dbformat( $tmp['pop_reminderSubj']).",".	
							    "detail =".dbformat( $tmp['pop_reminderDesc']).",".	
					 		  	"reminder_type_id =".dbformat( $tmp['pop_reminderType']).",".	
								"status =".dbformat( $tmp['pop_reminderStatus']).",".	
								"calllist_id =".dbformat( $tmp['listid']).",".
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE reminder_id = ".dbformat( $tmp['pop_reminderid'])." ";	
					
					 wlog( "[call-pane_process][save_reminder] update sql : ".$sql );
					$dbconn->executeUpdate($sql); 
					 
				}else{
				   //insert
				   $sql = " INSERT INTO t_reminder( reminder_dt ,reminder_type_id ,subject ,detail , calllist_id , status , create_user, create_date ) VALUES ( ".
					   		   " ".$dtime." ".
							   ",".dbformat( $tmp['pop_reminderType'])." ".
				    		   ",".dbformat( $tmp['pop_reminderSubj'])." ".
				   	   		   ",".dbformat( $tmp['pop_reminderDesc'])." ".
				     			",".dbformat( $tmp['listid'])." ".
				   	   		    ",".dbformat( $tmp['pop_reminderStatus'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				    
				    wlog( "[call-pane_process][save_reminder] insert sql : ".$sql );
					$dbconn->executeUpdate($sql); 
				}		
				
			//get current reminderid ( use for update )
			$sql = "SELECT reminder_id FROM t_reminder WHERE calllist_id = ".$tmp['listid'];
			wlog( "[call-pane_process][get_current redminderid]  sql : ".$sql );
			$result = $dbconn->executeQuery($sql); 
			if($rs=mysql_fetch_array($result)){   
				$current_reminderid = 	$rs['reminder_id'];
			}
				
			//reinitial - reminder alert 
			remineMe( $current_reminderid );	
				
            $dbconn->dbClose(); 
		    //$res = array("result"=>"success");
			//echo json_encode($res);   
			
	}
	
	 //remineMe();
	function remineMe( $current_reminderid ){
	
		$tmp = json_decode( $_POST['data'] , true); 
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
  			$sql = " SELECT reminder_id , reminder_dt ". 
						" FROM t_reminder ".
						" WHERE create_user = ".dbNumberFormat($tmp['uid'])." ".
						" AND status = 1 ".
						" AND reminder_dt >= NOW() ".
						" ORDER BY reminder_dt ".
						" LIMIT 0 , 1 ";
  			
  		
  			
  			$reminddt = "";
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$reminddt = $rs['reminder_dt'];
		 		wlog( $reminddt );
				//update current reminder to status 0 for next reminder
				if( isset($_POST['opt'])){
					if($_POST['opt']=="off"){
						$sql = "UPDATE t_reminder SET status = 0 WHERE reminder_id = ".$rs['reminder_id'];
						wlog( "reminder update : ".$sql );
					    $dbconn->executeUpdate($sql);
					}
				}
			
			
				$count++;  
			}
			
		
		
			
		    if($count==0){
			$data = array("result"=>"empty");
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
			
			$timeinsec  =  (($hour * 60 * 60 ) + ( $min * 60 ) + $sec ) *1000; 
			
			//echo $timeinsec * 1000 ;
			wlog("next reminde ".$elapsed);
		
   			$dbconn->dbClose();	 
			$data = array("result"=>"success","data"=>$timeinsec,"remid"=>$current_reminderid);
		    echo json_encode( $data ); 
	
	}
 
	function search_popupcallhistory(){
		
			$tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn;  
	        $dbconn->createConn();
			$res = $dbconn->createConn();
		 	if($res==404){
					    $res = array("result"=>"dberror","message"=>"Can't connect to database");
					    echo json_encode($res);		
					    exit();
		     }
		     
		   $sql =  " SELECT create_date FROM t_call_trans t ".
		   				" WHERE  campaign_id = ".dbNumberFormat($tmp['cmpid'])." ";
						" AND agent_id = ".dbNumberFormat($tmp['uid'])." "; 
		   				
		   
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				//get dynamic field for query data
				array_push( $fields , $rs['field_name'] );
			  	$data[$count] = array(
			  	      			"cd"  => getDatetimeFromDatetime($rs['create_date']),
						 
						);   
				$count++;  
			}
		   
		     if($count==0){
				$data = array("result"=>"empty");
			} 
			
			
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
	
	function search_calllist(){
	
			$tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn;  
			$res = $dbconn->createConn();
		 	if($res==404){
					    $res = array("result"=>"dberror","message"=>"Can't connect to database");
					    echo json_encode($res);		
					    exit();
		     }
		     
		     /*
		   $sql =  " SELECT fl.field_name ".
		   				" FROM t_campaign_field f LEFT OUTER JOIN ts_field_list fl ".
		   				" ON f.field_name = fl.field_name ".
		   				" WHERE f.campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
						" AND fl.field_detail = 'name' ";
		   
		    $search = " AND ( ";
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){
					$search = $search.$rs['field_name']." LIKE '%".$tmp['newlist_search']."%' OR ";
			}   
			$search = substr($search, 0, strripos($search, 'OR'));
			$search = $search." ) ";
			
			wlog("search condition : ".$sql);
			*/
			
			//normal query 
  $sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  ".dbNumberFormat($tmp['cmpid'])." ".
	     	" AND c.show_on_callwork = 1 ";
  
  wlog("normal query : ".$sql);
	
	       //system field ( customer system provide field )
	   		$fields = array("a.calllist_id");
	    	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				//get dynamic field for query data
				array_push( $fields , $rs['field_name'] );
			  	$tmp0[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}


		//get dynamic field  from db
			$field = implode(",", $fields);
			
			 //query agent call list
			//call list
  			$sql = " SELECT ".$field." ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
  						" AND a.status = 1 ".
  						" AND ( c.first_name  LIKE '%".$tmp['newlist_search']."%' OR c.last_name LIKE '%".$tmp['newlist_search']."%' ) ";
  						
  			
  			wlog( "query agent call list ".$sql);
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
		    
		    $fieldlength = count($fields); 
		    while($rs=mysql_fetch_row($result)){   
			   $a = array();
		    	for($i=0; $i< count($fields);$i++){
		    			$a['f'.$i] = nullToEmpty($rs[$i]);
		    	}
		    	 $tmp3[$count]  = $a;
		    	$count++;
			}
			 
		    if($count==0){
			$tmp3 = array("result"=>"empty");
			} 
			
			$data = array( "result"=>"success", "clist"=> $tmp3);
			
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
			
	}
	
	function loadpopup_content(){
		
		$tmp = json_decode( $_POST['data'] , true); 
			
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     /*
	     $test = 1;
	     //check calllist current status is a do not call status
  		$sql = " SELECT calllist_id FROM t_calllist WHERE calllist_id = ".dbNumberFormat($tmp['listid'])." AND  status = 3 ";
		$count = 0;    
	    $result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$tmp = array("status"=>"dnc");
			}else{
				$tmp = array("status"=>"normal");
			} 	
			*/
		
			$field = array();
				// profile field data
				/*
			$sql = " SELECT caption_name , field_name ".
						" FROM t_campaign_field ".
						" WHERE campaign_id =   ".dbNumberFormat($tmp['cmpid'])." ".
						" AND show_on_profile = 1 ";
			*/
			
			$sql = " SELECT f.caption_name , f.field_name , f.caption_option, s.field_detail  ".
						" FROM t_campaign_field f LEFT OUTER JOIN ts_field_list s ".
						" ON f.field_name = s.field_name ".
						" WHERE campaign_id =   ".dbNumberFormat($tmp['cmpid'])." ".
						" AND show_on_profile = 1 ";
			
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			$fields = "";
			
			while($rs=mysql_fetch_array($result)){   
				/*
			  	$tmp1[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);
						*/   
				$count++;  
				
				$fields = $fields." ".$rs['field_name'].",";
				array_push( $field , $rs['field_detail']."|".$rs['field_name']."|".$rs['caption_option']);
			}
			//."|".$rs['caption_option']
	
		// if($count==0){
		
		//	} 
 
			$sql = "SELECT ".$fields." status FROM t_calllist WHERE calllist_id =  ".dbNumberFormat( $_POST['listid'])." ";  //$tmp['listid']
			wlog($sql);
			
			$count = 0;    
	    	$result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_row($result)){   
				
					for($i=0;$i< count($field); $i++){
						
						  //wlog( "fetch : ".$field[$i]."|".$rs[$i] );
						  
							$tmp1[$count] = array(
						        "key"  => nullToEmpty($field[$i]),
								"value"  => nullToEmpty($rs[$i]),
							);
						
							$count++;
					}
						
					//status field 
					
					$tmp1[$count] = array(
						        "key"  => "status|status",
								"value"  => nullToEmpty($rs[$count]),
					);
				
			
				
			}
			if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			//recently wrapup history
			$sql = " SELECT a.last_wrapup_dt ,  r.reminder_dt  ".
						" FROM t_calllist_agent a LEFT OUTER JOIN t_reminder r ON a.reminder_id = r.reminder_id ".
						" WHERE a.campaign_id = ".dbNumberFormat( $tmp['cmpid'] )."  ". 
						" AND a.agent_id =  ".dbNumberFormat( $tmp['uid'] )."". 
						" AND a.calllist_id = ".dbNumberFormat( $_POST['listid'] );
			
				wlog($sql);
			
			$result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$tmp2 = array( 
								"lastwrapupdt_th" => allthaidatetime($rs['last_wrapup_dt']),
								"lastwrapupdt" => nullToEmpty($rs['last_wrapup_dt']),
								"lastreminderdt_th" => allthaidatetime($rs['reminder_dt']),
								"lastreminderdt" => nullToEmpty($rs['reminder_dt'])
							);
			}else{
				$tmp2 = array("result"=>"empty");
			}
			
			//query wrapup history NO paging 
			/*
			$sql = " SELECT t.create_date , t.wrapup_id , cdr.billsec , cdr.disposition ".
						" FROM t_call_trans t LEFT OUTER JOIN cdr cdr ON cdr.uniqueid = t.uniqueid ".
						" WHERE t.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND t.campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
						" AND t.calllist_id = ".dbNumberFormat( $_POST['listid'] ).
						" ORDER BY t.create_date DESC ";
			*/
			 $sql = " SELECT t.create_date , t.wrapup_id , t.wrapup_note ".
			 	" FROM t_call_trans t ".
   				" WHERE t.agent_id = ".dbNumberFormat($tmp['uid'])." ".
				" AND t.campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
				" AND t.calllist_id = ".dbNumberFormat( $_POST['listid'] ).
				" ORDER BY t.create_date DESC ";
				
			wlog("[call-pane_process][loadpopup_content] cal history sql : ".$sql);
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				$tmp3[$count] = array( 
						"cred" => allthaidatetime_short($rs['create_date']),
						"wup" => wrapupdtl($rs['wrapup_id']),
						"note" => nullToEmpty($rs['wrapup_note']),
						//"bill" => nullToEmpty($rs['billsec']) ,
						//"disp" => nullToEmpty($rs['disposition']) 
				);	
				$count++;
			}
			
			if($count==0){
				$tmp3 = array("result"=>"empty");
			}
			
			//current campaign list name
			$sql = "SELECT external_web_url FROM t_campaign WHERE campaign_id = ".dbNumberFormat($tmp['cmpid'])." ";
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){
				$tmp4 = nullToEmpty($rs['external_web_url']);
				$count++;
			}
			
			if($count==0){
				$tmp4 = array("result"=>"empty");
			}
			
		
			//external app
			$sql = " SELECT ex_app_name , ex_app_url , ex_app_icon ".
						" FROM t_external_app_register ".
						" WHERE campaign_id =  ".dbNumberFormat($tmp['cmpid'])."  ".
						" AND is_active = 1 ";
			
			wlog("[call-pane_process][loadexternal_app] sql : ".$sql);
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				$tmp5[$count] = array( 
						"appn" => nullToEmpty($rs['ex_app_name']),
						"appu" => nullToEmpty($rs['ex_app_url']),
						"appi" => nullToEmpty($rs['ex_app_icon']) ,
				);	
				$count++;
			}
			
			if($count==0){
				$tmp5 = array("result"=>"empty");
			}
			
			$sql = "SELECT import_id FROM t_calllist WHERE calllist_id =  ".dbNumberFormat( $_POST['listid'])." ";  
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$tmp6 = array( 
						"id" => nullToEmpty($rs['import_id'])
				);	
				$count++;
			}
			
			if($count==0){
				$tmp6 = array("result"=>"empty");
			}
		 
			//campaign data
  			$data = array("calllist"=>$tmp1,"wrapuphist"=>$tmp2,"listhist"=>$tmp3 , "script"=>$tmp4  , "exapp" => $tmp5 , "impid" => $tmp6 ); 
	

			//$data = array("empty");
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
	function init_wrapup(){
	
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
  			$sql = " SELECT wrapup_code , wrapup_dtl ".
						" FROM t_wrapup_code ".
						" WHERE status = 1 ".
						" and parent_code = 0 ".
						" ORDER BY seq_no ";
  			
  		//wlog("[call-pane_process][init] sql :".$sql);
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			
			  	$data[$count] = array(
						        "wcode"  => nullToEmpty($rs['wrapup_code']),
								"wdtl"  => nullToEmpty($rs['wrapup_dtl']),
						);   
				$count++;  
			}
		    if($count==0){
			$data = array("result"=>"empty");
			} 
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
			
	}
	
	function query_wrapup(){
	
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
  				$sql = " SELECT wrapup_code , wrapup_dtl ".
							" FROM t_wrapup_code ".
							" WHERE status = 1 ".
							" AND parent_code = ".dbNumberFormat($_POST['wrapupcode'])." ".
							" ORDER BY seq_no ";
  			
  			//wlog("[call-pane_process][init] sql :".$sql);
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			
			  	$data[$count] = array(
						        "wcode"  => nullToEmpty($rs['wrapup_code']),
								"wdtl"  => nullToEmpty($rs['wrapup_dtl']),
						);   
				$count++;  
			}
		    if($count==0){
			$data = array("result"=>"empty");
			} 
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	}
	
	function save_wrapup(){
	
				$tmp = json_decode( $_POST['data'] , true); 
			  
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
		
				//check remove call list  from worklist or not
				$sql = "SELECT remove_list FROM t_wrapup_code WHERE wrapup_code = ".dbNumberFormat($tmp['wrapup1'])."  ";
				wlog("[call-pane_process][save_wrapup] check remove list from working list sql : ".$sql);
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysql_fetch_array($result)){   
					if( $rs['remove_list'] == 1){
						$sql = " UPDATE t_calllist_agent SET status = 0 WHERE calllist_id = ".dbNumberFormat($tmp['listid'])."  ".
									" AND campaign_id =  ".dbNumberFormat( $tmp['cmpid'])." ".
								   	" AND calllist_id = ".dbNumberFormat( $tmp['listid'])." ".
								   	" AND agent_id = ".dbNumberFormat( $tmp['uid'])." ";
						wlog("[call-pane_process][save_wrapup] update list from working list  sql : ".$sql);
						$dbconn->executeUpdate($sql); 
					}				
				}
				
				//check wrapup option 
				$option = null;
				$sql = "SELECT option_id  FROM t_wrapup_code WHERE wrapup_code = ".dbNumberFormat($tmp['wrapup1'])."  ";
			    $result = $dbconn->executeQuery($sql); 
				if($rs=mysql_fetch_array($result)){   
					$option = $rs['option_id']; 
				}
				
			     $wrapupid = nullToEmpty($tmp['wrapup1'])."|".nullToEmpty($tmp['wrapup2'])."|".nullToEmpty($tmp['wrapup3']);
			     
			     //check if uniqueid is the same  update
				//prevent change wrapup and save again
			     if( isset($_POST['uniq'])){
			     		     $uniq = $_POST['uniq'];
			  
			     		     $sql = "SELECT uniqueid FROM t_call_trans WHERE uniqueid = ".dbformat( $uniq );
			     		     wlog("[call-pane_process][save_wrapup] select unique id sql :".$sql);
			     		     
			     		     $result = $dbconn->executeQuery($sql);
							 if($rs=mysql_fetch_array($result)){
							 	     $sql = "UPDATE t_call_trans SET ".
							 	      			 " import_id =".dbformat( $_POST['impid'] ).",".	 //add import id 
							 	     	   		 " wrapup_id =".dbformat( $wrapupid ).",".	
							 	     			 " wrapup_note =".dbformat( $tmp['wrapupdtl']).",".	
							 	     			 " wrapup_option_id =".dbNumberFormat( $option ).",".	
											     " update_date =NOW() ".
											     " WHERE uniqueid = ".dbformat( $uniq )." ";	 
							 	      wlog("[call-pane_process][save_wrapup] update call transaction sql :".$sql);
							  		$dbconn->executeUpdate($sql);
							  		
							  		//update calllist last wrapup ( no + number of call )
								   $sql = " UPDATE t_calllist_agent SET ".
								      		   " last_wrapup_id = ".dbformat($wrapupid).",".
								      		   " last_wrapup_detail = ".dbformat($tmp['wrapupdtl']).",".
								   			   " last_wrapup_option_id = ".dbNumberFormat( $option ).",".
								   	   		   " last_wrapup_dt = NOW() ,".
								   			   " WHERE campaign_id =  ".dbNumberFormat( $tmp['cmpid'])." ".
								   			   " AND calllist_id = ".dbNumberFormat( $tmp['listid'])." ".
								   			   " AND agent_id = ".dbNumberFormat( $tmp['uid'])." ";
								   
									wlog("[call-pane_process][save_wrapup] update last wrapup : ".$sql);
									$dbconn->executeUpdate($sql); 
							  		
							 }else{
							 		   //insert call transaction
									   $sql = " INSERT INTO t_call_trans  ( campaign_id , import_id , calllist_id , agent_id ,  uniqueid , wrapup_option_id , wrapup_id , wrapup_note ,  create_date ) VALUES (".
										   		   " ".dbNumberFormat( $tmp['cmpid'])." ".
									   	   		   ",".dbNumberFormat( $_POST['impid'] )." ". // add import id
												   ",".dbNumberFormat( $tmp['listid'])." ".
									   	   		   ",".dbNumberFormat( $tmp['uid'])." ".
									   	   		   ",".dbformat( $_POST['uniq'] )." ".
									      	  	   ",".dbNumberFormat( $option )." ".
											   	   ",".dbformat( $wrapupid )." ".
											   	   ",".dbformat( $tmp['wrapupdtl'])." , NOW() )  ";
				   
							    	 wlog("[call-pane_process][save_wrapup] insert call transaction sql :".$sql);
							    	 $dbconn->executeUpdate($sql); 
							    	 
							    	 
						    	 	   $sql = " UPDATE t_calllist_agent SET ".
									      		   " last_wrapup_id = ".dbformat($wrapupid).",".
									      		   " last_wrapup_detail = ".dbformat($tmp['wrapupdtl']).",".
									   			   " last_wrapup_option_id = ".dbNumberFormat( $option ).",".
									   	   		   " last_wrapup_dt = NOW() ,".
									   			   " number_of_call = number_of_call + 1".
									   			   " WHERE campaign_id =  ".dbNumberFormat( $tmp['cmpid'])." ".
									   			   " AND calllist_id = ".dbNumberFormat( $tmp['listid'])." ".
									   			   " AND agent_id = ".dbNumberFormat( $tmp['uid'])." ";
									   
										wlog("[call-pane_process][save_wrapup] update last wrapup : ".$sql);
										$dbconn->executeUpdate($sql); 
							 
							 }   
			     		     
			     }
			     
			     //check campaign condition if  max trying call != 0 and over limit 
			     //remove from list too
			  	$sql = " UPDATE t_calllist_agent a ".
							" , t_campaign b ".
							" SET a.status = 0 ". 
							" WHERE a.campaign_id = b.campaign_id ".
							" and ifnull(b.maximum_call,0) > 0 ".
							" and a.number_of_call >= ifnull(b.maximum_call,0) ".
			 	 		   " WHERE a.campaign_id =  ".dbNumberFormat( $tmp['cmpid'])." ".
			   			   " AND a.calllist_id = ".dbNumberFormat( $tmp['listid'])." ".
			   			   " AND a.agent_id = ".dbNumberFormat( $tmp['uid'])." ";
								 		   
	 		   			wlog("[call-pane_process][save_wrapup] update last wrapup : ".$sql);
						$dbconn->executeUpdate($sql);  
			       /*
				   //insert call transaction
				   $sql = " INSERT INTO t_call_trans  ( campaign_id , calllist_id , agent_id ,  uniqueid , wrapup_option_id , wrapup_id , wrapup_note ,  create_date ) VALUES (".
					   		   " ".dbNumberFormat( $tmp['cmpid'])." ".
							   ",".dbNumberFormat( $tmp['listid'])." ".
				   	   		   ",".dbNumberFormat( $tmp['uid'])." ".
				   	   			",".dbformat( $_POST['uniq'] )." ".
				      	  	 	",".dbNumberFormat( $option )." ".
						   	   ",".dbformat( $wrapupid )." ".
						   	   ",".dbformat( $tmp['wrapupdtl'])." , NOW() )  ";
				   
				    wlog("[call-pane_process][save_wrapup] insert call transaction : ".$sql);
					$dbconn->executeUpdate($sql); 
					*/
				   
				   //update calllist last wrapup
				   /*
				   $sql = " UPDATE t_calllist_agent SET ".
				      		   " last_wrapup_id = ".dbformat($wrapupid).",".
				      		   " last_wrapup_detail = ".dbformat($tmp['wrapupdtl']).",".
				   			   " last_wrapup_option_id = ".dbNumberFormat( $option ).",".
				   	   		   " last_wrapup_dt = NOW() ,".
				   			   " number_of_call = number_of_call + 1".
				   			   " WHERE campaign_id =  ".dbNumberFormat( $tmp['cmpid'])." ".
				   			   " AND calllist_id = ".dbNumberFormat( $tmp['listid'])." ".
				   			   " AND agent_id = ".dbNumberFormat( $tmp['uid'])." ";
				   
					wlog("[call-pane_process][save_wrapup] update last wrapup : ".$sql);
					$dbconn->executeUpdate($sql); 
   			  */
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	//show campaign for agent
	function init(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	   
	     
  			$sql = " SELECT COUNT(calllist_id) AS total , a.agent_id , a.campaign_id , c.campaign_name , c.campaign_detail , last_join_date  ".
						" , COUNT( a.CNT_NEW_LIST ) AS TOT_NEW_LIST ".
  						" , COUNT( a.CNT_NOCONTACT ) AS TOT_NOCONTACT ".
						" , COUNT( a.CNT_CALLBACK ) AS TOT_CALLBACK ".
						" , COUNT( a.CNT_FOLLOWUP ) AS TOT_FOLLOWUP ".
						" FROM ( ". 
						" SELECT calllist_id , agent_id , campaign_id ". 
						" ,CASE WHEN last_wrapup_option_id IS NULL THEN calllist_id END AS CNT_NEW_LIST ".
						" ,CASE WHEN last_wrapup_option_id = 1   THEN calllist_id END AS CNT_CALLBACK ".
						" ,CASE WHEN last_wrapup_option_id  IN ( 2,9 ) THEN calllist_id END AS CNT_FOLLOWUP ".
  						" ,CASE WHEN last_wrapup_option_id = 8 THEN calllist_id END AS CNT_NOCONTACT ".
						" FROM t_calllist_agent ".
						" WHERE agent_id = ".dbNumberFormat($tmp['uid'])." ) a ".
						" left outer join t_campaign c   on ( a.campaign_id = c.campaign_id ) ". 
						" left outer join t_agent_join_campaign j on ( a.campaign_id = j.campaign_id  AND a.agent_id = j.agent_id ) ".
						" GROUP BY a.agent_id , a.campaign_id , c.campaign_name , c.campaign_detail , last_join_date";
  			
  			wlog("[call-pane_process][init] sql :".$sql);
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				$total = nullToZero($rs['TOT_NEW_LIST']) +  nullToZero($rs['TOT_NOCONTACT']) + nullToZero($rs['TOT_FOLLOWUP']) + nullToZero($rs['TOT_CALLBACK']);
			  	$data[$count] = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"cmpName"  => nullToEmpty($rs['campaign_name']),
							    "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
			  	 				"total"  => nullToEmpty($total),
							    "nlist"  => nullToZero($rs['TOT_NEW_LIST']),
			  				    "ncont"  => nullToZero($rs['TOT_NOCONTACT']),
						  	 	"clsit"  => nullToZero($rs['TOT_CALLBACK']),
						  		"flist"  => nullToZero($rs['TOT_FOLLOWUP']),
			  					"jdate"  => getDatetimeFromDatetime($rs['last_join_date']),
						);   
				$count++;  
			}
		    if($count==0){
			$data = array("result"=>"empty");
			} 
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
	function cmp_joinlog(){
	
				$tmp = json_decode( $_POST['data'] , true); 
				$dbconn = new dbconn;  
		        $dbconn->createConn();
				$res = $dbconn->createConn();
			 	if($res==404){
						    $res = array("result"=>"dberror","message"=>"Can't connect to database");
						    echo json_encode($res);		
						    exit();
			     }
	     
			     //insert agent join campaign log time
			     $sql = " SELECT agent_id  FROM t_agent_join_campaign ".
			     			 " WHERE agent_id = ".dbNumberFormat($tmp['uid']). " ".
			     			" AND campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
			     
			    $result = $dbconn->executeQuery($sql);
				if($rs=mysql_fetch_array($result)){
							$sql = "UPDATE t_agent_join_campaign SET ".
										" last_join_date = NOW() ".
									    " WHERE agent_id = ".dbNumberFormat($tmp['uid']). " ".
			     					    " AND campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
							 $dbconn->executeUpdate($sql);
				}else{
							$sql = "INSERT INTO t_agent_join_campaign (  last_join_date  , agent_id , campaign_id ) VALUES (".
										" NOW() , ".
									    " ".dbNumberFormat($tmp['uid']). ", ".
			     					    " ".dbNumberFormat($_POST['cmpid'])."  ) ";
							 $dbconn->executeUpdate($sql);
				}
				
				$dbconn->dbClose();	 
				$data = array( "result"=>"success");
				
				echo json_encode( $data ); 
	
	
	}
	
	function cmp_initial(){
	
				$tmp = json_decode( $_POST['data'] , true); 
				$dbconn = new dbconn;  
		        $dbconn->createConn();
				$res = $dbconn->createConn();
			 	if($res==404){
						    $res = array("result"=>"dberror","message"=>"Can't connect to database");
						    echo json_encode($res);		
						    exit();
			     }
	      
		  	//initial campaign dynamic from setting
			//init data ( show field in profile );
			$sql = " SELECT caption_name , field_name ".
						" FROM t_campaign_field ".
						" WHERE campaign_id =   ".dbNumberFormat($_POST['cmpid'])." ".
						" AND show_on_profile = 1 ".
						" ORDER BY seq ";
			
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			  	$tmp1[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
			    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
	     
	    //prepare campaign action 
	     $sql = " SELECT campaign_name , campaign_detail , external_web_url , script_detail ".
					" FROM t_campaign c ".
					" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
					" WHERE c.campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
	     
	     	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
	     	if($rs=mysql_fetch_array($result)){   
			
			  	$tmp2 = array(
			  	      			"cmpName"  => nullToEmpty($rs['campaign_name']),
						        "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
								"exturl"  => nullToEmpty($rs['external_web_url']),
							    "saleScript"  => nullToEmpty($rs['script_detail']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
			
			$data = array( "pfield"=>$tmp1 , "cmp" => $tmp2);
			$dbconn->dbClose();	 
			echo json_encode( $data ); 
	}
	
	//count newlist , no contact , call back , follow up to dashboard
	function query_dashboard(){
	
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     $sql = " SELECT COUNT(a.calllist_id) AS total ".
 					 " FROM t_calllist_agent a ". 
					" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
					" WHERE a.agent_id = ".dbNumberFormat($tmp['uid']).
					" AND campaign_id = ".dbNumberFormat($_POST['cmpid']).
					" AND a.last_wrapup_option_id IS NULL ";
	     
	        wlog("[call-pane_process][query_dashboard] NEW LIST sql  : ".$sql);
	        $result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$total_newlist = nullToZero($rs['total']);
			}
	
	  		$sql = " SELECT COUNT(*) AS total ".
							" FROM t_calllist_agent a ". 
							" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
							" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
	  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
							" AND a.status = 1 ".
  							" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 2 ) "; //no contact is tab_id = 2 in ts config
	  		
	        wlog("[call-pane_process][query_dashboard] NO CONTACT LIST sql  : ".$sql);
	  		$result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$total_nocontact = nullToZero($rs['total']);
			}
	     
			//count  call back
	      $sql = " SELECT COUNT(a.calllist_id) AS total ".
 					 " FROM t_calllist_agent a ". 
					" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
					" WHERE a.agent_id = ".dbNumberFormat($tmp['uid']).
					" AND campaign_id = ".dbNumberFormat($_POST['cmpid']).
					" AND a.status = 1 ".
  					" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 3 ) "; //call back is tab_id = 3 in ts config
	         wlog("[call-pane_process][query_dashboard] CALL BACK LIST sql  : ".$sql);
	  		$result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$total_callback = nullToZero($rs['total']);
			}
	      //count followup
	       $sql = " SELECT COUNT(a.calllist_id) AS total ".
 					 " FROM t_calllist_agent a ". 
					" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
					" WHERE a.agent_id = ".dbNumberFormat($tmp['uid']).
					" AND campaign_id = ".dbNumberFormat($_POST['cmpid']).
					" AND a.status = 1 ".
  					" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 4 ) "; //followup  is tab_id = 4 in ts config
	         wlog("[call-pane_process][query_dashboard] FOLLOWUP LIST sql  : ".$sql);
	  		$result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
				$total_followup = nullToZero($rs['total']);
			}
	       
			$data = array( "tnewlist" => $total_newlist , "tnocont"=>$total_nocontact , "tcallback" => $total_callback , "tfollowup" => $total_followup);
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
			

	}
	
	//query new call list
	function query_newlist(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //campaign detail
	     //init data ( show field in call work );
	     
	     $sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  ".dbNumberFormat( $_POST['cmpid'] )." ".
	    		 	" AND c.show_on_callwork = 1 ";
	   	
	       //system field ( customer system provide field )
	   		$fields = array("a.calllist_id");
	    	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				//get dynamic field for query data
				array_push( $fields , $rs['field_name'] );
			  	$tmp0[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
	      
	     
			//init data ( show field in profile );
			$sql = " SELECT caption_name , field_name ".
						" FROM t_campaign_field ".
						" WHERE campaign_id =   ".dbNumberFormat($_POST['cmpid'])." ".
						" AND show_on_profile = 1 ";
			
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			  	$tmp1[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
			    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
	     
	    //prepare call popup  action 
	     $sql = " SELECT campaign_name , campaign_detail , external_web_url , script_detail ".
					" FROM t_campaign c ".
					" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
					" WHERE c.campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
	     
	     	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
	     	if($rs=mysql_fetch_array($result)){   
			  	$tmp2 = array(
			  	      			"cmpName"  => nullToEmpty($rs['campaign_name']),
						        "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
								"exturl"  => nullToEmpty($rs['external_web_url']),
							    "saleScript"  => nullToEmpty($rs['script_detail']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
	      
			//add system field for query value 
			//array_push( $fields , "a.calllist_id");
			
			//** change requirement add list name to system field  from db
			array_push( $fields );
			$field = implode(",", $fields);
			
			//calculate new list paging
			$page = 0;
		   	$pagelength = 40; //row per page 
		     if( isset($_POST['page'])){
		    	 $page =  ( intval($_POST['page']) - 1 ) * $pagelength;
		     }
	     
			 //query agent new list
			//call list
  			$sql = " SELECT ".$field." ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
  						" LEFT OUTER JOIN t_import_list l ON a.import_id = l.import_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  						
  						" AND a.last_wrapup_option_id IS NULL ";
  			if( $tmp['newlist_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['newlist_search']."%',' ','%')";
  			}
  			$sql = $sql." LIMIT ".$page." , ".$pagelength; 
  			
  			wlog( "[call-pane_process][query_newlist] NEW LIST show in table sql : ".$sql);
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
		    
		    $fieldlength = count($fields); 
		    while($rs=mysql_fetch_row($result)){   
			   $a = array();
		    	for($i=0; $i< $fieldlength ;$i++){
		    			$a['f'.$i] = nullToEmpty($rs[$i]);
		    	}
		    	 $tmp3[$count]  = $a;
		    	$count++;
			}
			 
		    if($count==0){
				$tmp3 = array("result"=>"empty");
			}
			
			//count total calllist for paging
				$sql = " SELECT COUNT(*) AS totallist ".
							" FROM t_calllist_agent a ". 
							" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
							" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
	  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  							" AND a.last_wrapup_option_id IS NULL ";
			if( $tmp['newlist_search'] != "" ){
  						$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['newlist_search']."%',' ','%')";
  			}
			wlog( "[call-pane_process][query_newlist] NEW LIST show total row sql : ".$sql);
				
			  $totallist = 0;	
			  $result = $dbconn->executeQuery($sql);
	     	  if($rs=mysql_fetch_array($result)){
	     	  			$totallist = $rs['totallist'];
	     	  }   
  				
			//, "cback"=> $tmp4 , "cfollow" => $tmp5 , "chistory"=> $tmp6 ,"fieldlength"=>$fieldlength);
			$data = array( "cfield" => $tmp0 , "pfield"=>$tmp1 , "cmp" => $tmp2 , "clist" => $tmp3 , "totalnewlist"=>$totallist );
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	 
	}
	
	//no contact list
	function query_nocontact(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //campaign detail
	     //init data ( show field in call work );
	     
	     
	     $sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  ".dbNumberFormat( $_POST['cmpid'] )." ".
	    		 	" AND c.show_on_callwork = 1 ";
	   	
	       //system field ( customer system provide field )
	   		$fields = array("a.calllist_id");
	    	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				//get dynamic field for query data
				array_push( $fields , $rs['field_name'] );
			  	$tmp0[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
	      
	     
			//init data ( show field in profile );
			/*
			$sql = " SELECT caption_name , field_name ".
						" FROM t_campaign_field ".
						" WHERE campaign_id =   ".dbNumberFormat($_POST['cmpid'])." ".
						" AND show_on_profile = 1 ";
			
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			  	$tmp1[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
			    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
	     
	    //prepare call popup  action  //duplicate action
	    /*
	     $sql = " SELECT campaign_name , campaign_detail , external_web_url , script_detail ".
					" FROM t_campaign c ".
					" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
					" WHERE c.campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
	     
	     	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
	     	if($rs=mysql_fetch_array($result)){   
			
			  	$tmp2 = array(
			  	      			"cmpName"  => nullToEmpty($rs['campaign_name']),
						        "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
								"exturl"  => nullToEmpty($rs['external_web_url']),
							    "saleScript"  => nullToEmpty($rs['script_detail']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
	      
			//add system field for query value 
			//array_push( $fields , "a.calllist_id");
			*/
		
			
			//calculate new list paging
			$page = 0;
		   	$pagelength = 40; //row per page 
		     if( isset($_POST['page'])){
		    	 $page =  ( intval($_POST['page']) - 1 ) * $pagelength;
		     }
		     
		    //get dynamic field  from db
			$field = implode(",", $fields);
	     
		    //callback system field
		 	array_push( $fields , "a.last_wrapup_id","a.last_wrapup_detail","a.number_of_call","a.last_wrapup_dt" );
		 	
		 		//** change requirement add list name to system field  from db
			//array_push( $fields , );
			$field = implode(",", $fields);
			 
  			$sql = " SELECT ".$field." ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  						//" AND last_wrapup_option_id = 8 ".
  						" AND a.status = 1 ".
  						" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 2 ) "; //no contact is tab_id = 2 in ts config
			if( $tmp['nocontact_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['nocontact_search']."%',' ','%')";
  			}
  					$sql = $sql." ORDER BY last_wrapup_dt ".$_POST['orderby']." ".
  										" LIMIT ".$page." , ".$pagelength; 
  			
  			wlog( "[call-pane_process][query_nocontact] NO CONTACT  show data in row sql : ".$sql);  			
			// callback list
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
		    
		    $dt_field = count($fields)-1;
		    $wrapup_field = count($fields)-4;
		    while($rs=mysql_fetch_row($result)){ 
			   $a = array();
			   $size = count($fields);
		    	for($i=0; $i<$size ;$i++){
		    			// change format for datetime field
		    			if( $i== $dt_field){
		    				$a['f'.$i] = getDatetimeFromDatetime($rs[$i]);
		    			}else if( $i == $wrapup_field){
		    				$a['f'.$i] = nullToEmpty( wrapupdtl($rs[$i]));
		    			}else{		    			
		    				$a['f'.$i] = nullToEmpty($rs[$i]);
		    			}
		    	}
		    	 $tmp1[$count]  = $a;
		    	$count++;
				
			} 
   
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			//count total calllist for paging
				$sql = " SELECT COUNT(*) AS totallist ".
							" FROM t_calllist_agent a ". 
							" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
							" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
	  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
							" AND a.status = 1 ".
  							" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 2 ) "; //no contact is tab_id = 2 in ts config
			if( $tmp['nocontact_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['nocontact_search']."%',' ','%')";
  			}
  			
			wlog( "[call-pane_process][query_nocontact] NO CONTACT show total row sql : ".$sql);  			
			  $totallist = 0;	
			  $result = $dbconn->executeQuery($sql);
	     	  if($rs=mysql_fetch_array($result)){
	     	  			$totallist = $rs['totallist'];
	     	  }   
  				

			$data = array( "cfield" => $tmp0 , "cnocontact"=>$tmp1 , "totalnocontact"=>$totallist );
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
	
	//call back list
	function query_callback(){
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //campaign detail
	     //init data ( show field in call work );
	     
	     
	     $sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  ".dbNumberFormat( $_POST['cmpid'] )." ".
	    		 	" AND c.show_on_callwork = 1 ";
	   	
	       //system field ( customer system provide field )
	   		$fields = array("a.calllist_id");
	    	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				//get dynamic field for query data
				array_push( $fields , $rs['field_name'] );
			  	$tmp0[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
	      
	     
			//init data ( show field in profile );
			/*
			$sql = " SELECT caption_name , field_name ".
						" FROM t_campaign_field ".
						" WHERE campaign_id =   ".dbNumberFormat($_POST['cmpid'])." ".
						" AND show_on_profile = 1 ";
			
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			  	$tmp1[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
			    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
	     
	    //prepare call popup  action  //duplicate action
	    /*
	     $sql = " SELECT campaign_name , campaign_detail , external_web_url , script_detail ".
					" FROM t_campaign c ".
					" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
					" WHERE c.campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
	     
	     	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
	     	if($rs=mysql_fetch_array($result)){   
			
			  	$tmp2 = array(
			  	      			"cmpName"  => nullToEmpty($rs['campaign_name']),
						        "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
								"exturl"  => nullToEmpty($rs['external_web_url']),
							    "saleScript"  => nullToEmpty($rs['script_detail']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
	      
			//add system field for query value 
			//array_push( $fields , "a.calllist_id");
			*/
		
			
			//calculate new list paging
			$page = 0;
		   	$pagelength = 40; //row per page 
		     if( isset($_POST['page'])){
		    	 $page =  ( intval($_POST['page']) - 1 ) * $pagelength;
		     }
		     
		    //get dynamic field  from db
			$field = implode(",", $fields);
	     
		    //callback system field
		 	array_push( $fields , "a.last_wrapup_id","a.last_wrapup_detail","a.number_of_call","a.last_wrapup_dt");
			$field = implode(",", $fields);
			 
  			$sql = " SELECT ".$field." ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  						" AND a.status = 1 ".
  						" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 3 ) "; //call back is tab_id = 3 in ts config
			if( $tmp['callback_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['callback_search']."%',' ','%')";
  			}
  					$sql = $sql." ORDER BY a.last_wrapup_dt ".$_POST['orderby']."  ".
  										" LIMIT ".$page." , ".$pagelength; 
  			
  			wlog( "[call-pane_process][query_callback] CALL BACK show in table sql : ".$sql);
  		
  			
			// callback list
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
		    
		    $dt_field = count($fields)-1;
		    $wrapup_field = count($fields)-4;
		    while($rs=mysql_fetch_row($result)){   
			   $a = array();
			   $size = count($fields);
		    	for($i=0; $i<$size ;$i++){
		    			// change format for datetime field
		    			if( $i== $dt_field){
		    				$a['f'.$i] = getDatetimeFromDatetime($rs[$i]);
		    			}else if( $i == $wrapup_field){
		    				$a['f'.$i] = nullToEmpty( wrapupdtl($rs[$i]));
		    			}else{		    			
		    				$a['f'.$i] = nullToEmpty($rs[$i]);
		    			}
		    	}
		    	 $tmp1[$count]  = $a;
		    	$count++;
				
			} 
   
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			//count total calllist for paging
				$sql = " SELECT COUNT(*) AS totallist ".
							" FROM t_calllist_agent a ". 
							" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
							" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
	  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
							" AND a.status = 1 ".
							" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 3 ) "; //call back is tab_id = 3 in ts config
			if( $tmp['callback_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['callback_search']."%',' ','%')";
  			}
				
			  $totallist = 0;	
			  
			  wlog( "[call-pane_process][query_callback] CALL BACK count row sql : ".$sql);
			  		
			  $result = $dbconn->executeQuery($sql);
	     	  if($rs=mysql_fetch_array($result)){
	     	  			$totallist = $rs['totallist'];
	     	  }   
  				

			$data = array( "cfield" => $tmp0 , "cback"=>$tmp1 , "totalcallback"=>$totallist );
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
	//no contact list
	function query_followup(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //campaign detail
	     //init data ( show field in call work );
	     $sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  ".dbNumberFormat( $_POST['cmpid'] )." ".
	    		 	" AND c.show_on_callwork = 1 ";
	   	
	       //system field ( customer system provide field )
	   		$fields = array("a.calllist_id");
	    	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				//get dynamic field for query data
				array_push( $fields , $rs['field_name'] );
			  	$tmp0[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
	      
	     
			//init data ( show field in profile );
			/*
			$sql = " SELECT caption_name , field_name ".
						" FROM t_campaign_field ".
						" WHERE campaign_id =   ".dbNumberFormat($_POST['cmpid'])." ".
						" AND show_on_profile = 1 ";
			
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			  	$tmp1[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
			    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
	     
	    //prepare call popup  action  //duplicate action
	    /*
	     $sql = " SELECT campaign_name , campaign_detail , external_web_url , script_detail ".
					" FROM t_campaign c ".
					" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
					" WHERE c.campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
	     
	     	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
	     	if($rs=mysql_fetch_array($result)){   
			
			  	$tmp2 = array(
			  	      			"cmpName"  => nullToEmpty($rs['campaign_name']),
						        "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
								"exturl"  => nullToEmpty($rs['external_web_url']),
							    "saleScript"  => nullToEmpty($rs['script_detail']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
	      
			//add system field for query value 
			//array_push( $fields , "a.calllist_id");
			*/
		
			
			//calculate new list paging
			$page = 0;
		   	$pagelength = 40; //row per page 
		     if( isset($_POST['page'])){
		    	 $page =  ( intval($_POST['page']) - 1 ) * $pagelength;
		     }
		     
		    //get dynamic field  from db
			$field = implode(",", $fields);
	     
		    //callback system field
		 	array_push( $fields , "a.last_wrapup_id","a.last_wrapup_detail","a.number_of_call","a.last_wrapup_dt");
			$field = implode(",", $fields);
			 
  			$sql = " SELECT ".$field." ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  						" AND a.status = 1 ".
  						" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 4 ) "; //followup is tab_id = 4 in ts config
			if( $tmp['followup_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['followup_search']."%',' ','%')";
  			}
  			
  					$sql = $sql." ORDER BY a.last_wrapup_dt ".$_POST['orderby']."  ".
  						" LIMIT ".$page." , ".$pagelength; 
  			
  				wlog( "[call-pane_process][query_followup] FOLLOW UP show in table sql : ".$sql);
  				
			// callback list
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
		    
		    $dt_field = count($fields)-1;
		    $wrapup_field = count($fields)-4;
		    while($rs=mysql_fetch_row($result)){   
			   $a = array();
			   $size = count($fields);
		    	for($i=0; $i<$size ;$i++){
		    			// change format for datetime field
		    			if( $i== $dt_field){
		    				$a['f'.$i] = getDatetimeFromDatetime($rs[$i]);
		    			}else if( $i == $wrapup_field){
		    				$a['f'.$i] = nullToEmpty( wrapupdtl($rs[$i]));
		    			}else{		    			
		    				$a['f'.$i] = nullToEmpty($rs[$i]);
		    			}
		    	}
		    	 $tmp1[$count]  = $a;
		    	$count++;
				
			} 
   
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			//count total calllist for paging
				$sql = " SELECT COUNT(*) AS totallist ".
							" FROM t_calllist_agent a ". 
							" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
							" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
	  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
							" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 4 ) ". //followup is tab_id = 4 in ts config
	  						" AND a.status = 1 ";
				if( $tmp['followup_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['followup_search']."%',' ','%')";
  				}
  			
				wlog( "[call-pane_process][query_followup] FOLLOW UP count sql : ".$sql);
  				
				
			  $totallist = 0;	
			  $result = $dbconn->executeQuery($sql);
	     	  if($rs=mysql_fetch_array($result)){
	     	  			$totallist = $rs['totallist'];
	     	  }   

			$data = array( "cfield" => $tmp0 , "cfollowup"=>$tmp1 , "totalfollowup"=>$totallist );
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
	
	function query_callhistory(){
	
					$tmp = json_decode( $_POST['data'] , true); 
					$dbconn = new dbconn;  
					$res = $dbconn->createConn();
				 	if($res==404){
							    $res = array("result"=>"dberror","message"=>"Can't connect to database");
							    echo json_encode($res);		
							    exit();
				     }
				     
				     //campaign detail
				     //init data ( show field in call work );
				     $sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  ".dbNumberFormat( $_POST['cmpid'] )." ".
				    		 	" AND c.show_on_callwork = 1 ";
				   	
				       //start call history system field 
				   		$fields = array("t.call_id");
				    	$count = 0;    
					    $result = $dbconn->executeQuery($sql);
						while($rs=mysql_fetch_array($result)){   
							//get dynamic field for query data
							array_push( $fields , $rs['field_name'] );
						  	$tmp0[$count] = array(
						  	      			"cn"  => nullToEmpty($rs['caption_name']),
									        "fn"  => nullToEmpty($rs['field_name']),
									);   
							$count++;  
						}
				      
				     
						//init data ( show field in profile );
						/*
						$sql = " SELECT caption_name , field_name ".
									" FROM t_campaign_field ".
									" WHERE campaign_id =   ".dbNumberFormat($_POST['cmpid'])." ".
									" AND show_on_profile = 1 ";
						
						$count = 0;
						$result = $dbconn->executeQuery($sql);
						while($rs=mysql_fetch_array($result)){   
						  	$tmp1[$count] = array(
						  	      			"cn"  => nullToEmpty($rs['caption_name']),
									        "fn"  => nullToEmpty($rs['field_name']),
									);   
							$count++;  
						}
						    if($count==0){
							$tmp1 = array("result"=>"empty");
						} 
				     
				    //prepare call popup  action  //duplicate action
				    /*
				     $sql = " SELECT campaign_name , campaign_detail , external_web_url , script_detail ".
								" FROM t_campaign c ".
								" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
								" WHERE c.campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
				     
				     	$count = 0;    
					    $result = $dbconn->executeQuery($sql);
				     	if($rs=mysql_fetch_array($result)){   
						
						  	$tmp2 = array(
						  	      			"cmpName"  => nullToEmpty($rs['campaign_name']),
									        "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
											"exturl"  => nullToEmpty($rs['external_web_url']),
										    "saleScript"  => nullToEmpty($rs['script_detail']),
									);   
							$count++;  
						}
					    if($count==0){
							$tmp2 = array("result"=>"empty");
						} 
				      
						//add system field for query value 
						//array_push( $fields , "a.calllist_id");
						*/
					
						
						//calculate new list paging
						$page = 0;
					   	$pagelength = 40; //row per page 
					     if( isset($_POST['page'])){
					    	 $page =  ( intval($_POST['page']) - 1 ) * $pagelength;
					     }

						//callhistory system field
					 	//array_push( $fields ,"t.wrapup_id","t.wrapup_note", "'call_duration'","'call_type'","t.create_date" );
					 	
					 	array_push( $fields ,"t.wrapup_id","t.wrapup_note", "cdr.billsec","cdr.disposition","t.create_date" );
						$field = implode(",", $fields);
						
						
						
						//call history list  ( in this campaign );
						$sql = " SELECT ".$field." ". // , 'call_duration','call_type'  
									" FROM t_call_trans t ".
									" LEFT OUTER JOIN t_calllist c ON t.calllist_id = c.calllist_id ".
									" LEFT OUTER JOIN asteriskcdrdb.cdr cdr ON t.uniqueid = cdr.uniqueid".
									" WHERE t.agent_id = ".dbNumberFormat($tmp['uid'])." ".
			  						" AND t.campaign_id = ".dbNumberFormat($_POST['cmpid'])." ";
				if( $tmp['callhistory_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['callhistory_search']."%',' ','%')";
  				}
					$sql = $sql." ORDER BY t.create_date ".$_POST['orderby']."  ".
										" LIMIT ".$page." , ".$pagelength; 
						
						$count = 0;    
						wlog( "[call-pane_process][query_callhistory] CALL HISTORY in table sql : ".$sql);
					    $result = $dbconn->executeQuery($sql);
					    
					    $dt_field = count($fields)-1;
					    $wrapup_field = count($fields)-5;
					    while($rs=mysql_fetch_row($result)){   
						   $a = array();
						   $size = count($fields) +2 ;
					    	for($i=0; $i<$size ;$i++){
					    			// change format for datetime field
					    			if($i==$dt_field){
					    				$a['credt'] = getDatetimeFromDatetime($rs[$i]);
					    			}else if( $i == $wrapup_field){
					    				$a['f'.$i] = nullToEmpty( wrapupdtl($rs[$i]));
					    			}else{
					    				$a['f'.$i] = nullToEmpty($rs[$i]);
					    			}
					    	}
					    	 $tmp1[$count]  = $a;
					    	$count++;
							
						} 
			   
					    if($count==0){
							$tmp1 = array("result"=>"empty");
						} 
			
						
						//count total call history 
							$sql = " SELECT COUNT(*) AS totallist ".
										" FROM t_call_trans t ".
										" LEFT OUTER JOIN t_calllist c ON t.calllist_id = c.calllist_id ".
										" WHERE t.agent_id = ".dbNumberFormat($tmp['uid'])." ".
				  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ";
				if( $tmp['callhistory_search'] != "" ){
  					$sql = $sql." AND CONCAT( c.first_name,c.last_name)  LIKE REPLACE('%".$tmp['callhistory_search']."%',' ','%')";
  				 }
							
							wlog( "[call-pane_process][query_callhistory] CALL HISTORY count sql : ".$sql);
							
						  $totallist = 0;	
						  $result = $dbconn->executeQuery($sql);
				     	  if($rs=mysql_fetch_array($result)){
				     	  			$totallist = $rs['totallist'];
				     	  }   
		
						$data = array( "cfield" => $tmp0 , "chistory"=>$tmp1 , "totalhistory"=>$totallist );
						 
					 	$dbconn->dbClose();	 
						echo json_encode( $data ); 
			
	
	}
	
	
	
	//query call list for agent
	function query(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     /*
	     //insert agent join campaign 
	     $sql = " SELECT agent_id  FROM t_agent_join_campaign ".
	     			 " WHERE agent_id = ".dbNumberFormat($tmp['uid']). " ".
	     			" AND campaign_id =  ".dbNumberFormat($tmp['cmpid'])." ";
	     
	    $result = $dbconn->executeQuery($sql);
		if($rs=mysql_fetch_array($result)){
					$sql = "UPDATE t_agent_join_campaign SET ".
								" last_join_date = NOW() ".
							    " WHERE agent_id = ".dbNumberFormat($tmp['uid']). " ".
	     					    " AND campaign_id =  ".dbNumberFormat($tmp['cmpid'])." ";
					 $dbconn->executeUpdate($sql);
		}else{
					$sql = "INSERT INTO t_agent_join_campaign (  last_join_date  , agent_id , campaign_id ) VALUES (".
								" NOW() , ".
							    " ".dbNumberFormat($tmp['uid']). ", ".
	     					    " ".dbNumberFormat($tmp['cmpid'])."  ) ";
					 $dbconn->executeUpdate($sql);
		}
	     */
	     
	     //campaign detail
	     //init data ( show field in call work );
	     
	     $sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  ".dbNumberFormat( $_POST['cmpid'] )." ".
	    		 	" AND c.show_on_callwork = 1 ";
	   	
	       //system field ( customer system provide field )
	   		$fields = array("a.calllist_id");
	    	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
				//get dynamic field for query data
				array_push( $fields , $rs['field_name'] );
			  	$tmp0[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
			
			//debug fields
			/*
			for( $i=0;$i< count($fields); $i++){
			wlog( $fields[$i]);
			}
			*/
			
			//system field ( customer system provide field )
			//array_push( $fields , "a.number_of_call"); 
			
		    if($count==0){
				$tmp0 = array("result"=>"empty");
			} 
			
			//init data ( show field in profile );
			$sql = " SELECT caption_name , field_name ".
						" FROM t_campaign_field ".
						" WHERE campaign_id =   ".dbNumberFormat($_POST['cmpid'])." ".
						" AND show_on_profile = 1 ";
			
			$count = 0;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			  	$tmp1[$count] = array(
			  	      			"cn"  => nullToEmpty($rs['caption_name']),
						        "fn"  => nullToEmpty($rs['field_name']),
						);   
				$count++;  
			}
			    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
	     
	    //prepare campaign action 
	     $sql = " SELECT campaign_name , campaign_detail , external_web_url , script_detail ".
					" FROM t_campaign c ".
					" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
					" WHERE c.campaign_id =  ".dbNumberFormat($_POST['cmpid'])." ";
	     
	     	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
	     	if($rs=mysql_fetch_array($result)){   
			
			  	$tmp2 = array(
			  	      			"cmpName"  => nullToEmpty($rs['campaign_name']),
						        "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
								"exturl"  => nullToEmpty($rs['external_web_url']),
							    "saleScript"  => nullToEmpty($rs['script_detail']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
	      
			//add system field for query value 
			//array_push( $fields , "a.calllist_id");
			
			//get dynamic field  from db
			$field = implode(",", $fields);
			
			
			//calculate call list paging
		    $page = 0;
		     if( isset($_POST['calllistpage'])){
		     	 $pagelength = 5;
		    	 $page =  ( intval($_POST['calllistpage']) - 1 ) * $pagelength;
		     }
			
			 //query agent call list
			//call list
  			$sql = " SELECT ".$field." ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  						" AND a.status = 1 ".
  						" LIMIT ".$page." , 5 "; 
  			
  			wlog( "query agent call list ".$sql);
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
		    
		    $fieldlength = count($fields); 
		    while($rs=mysql_fetch_row($result)){   
			   $a = array();
		    	for($i=0; $i< $fieldlength ;$i++){
		    			$a['f'.$i] = nullToEmpty($rs[$i]);
		    	}
		    	 $tmp3[$count]  = $a;
		    	$count++;
			}
			 
		    if($count==0){
				$tmp3 = array("result"=>"empty");
			}
			
			//count total calllist for paging
				$sql = " SELECT COUNT(*) AS totallist ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  						" AND a.status = 1 ";
			  $totallist = 0;	
			  $result = $dbconn->executeQuery($sql);
	     	  if($rs=mysql_fetch_array($result)){
	     	  			$totallist = $rs['totallist'];
	     	  }   
  				
			
			
			// callback list
			
			//callback system field
		 	array_push( $fields , "a.last_wrapup_id","a.last_wrapup_detail","a.number_of_call","a.last_wrapup_dt");
			$field = implode(",", $fields);
			 
  			$sql = " SELECT ".$field." ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  						" AND last_wrapup_option_id = 1 ";
  			
			// callback list
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
		    $dt_field = count($fields)-1;
		    $wrapup_field = count($fields)-4;
		    while($rs=mysql_fetch_row($result)){   
			   $a = array();
			   $size = count($fields);
		    	for($i=0; $i<$size ;$i++){
		    			// change format for datetime field
		    			if( $i== $dt_field){
		    				$a['f'.$i] = getDatetimeFromDatetime($rs[$i]);
		    			}else if( $i == $wrapup_field){
		    				$a['f'.$i] = nullToEmpty( wrapupdtl($rs[$i]));
		    			}else{		    			
		    				$a['f'.$i] = nullToEmpty($rs[$i]);
		    			}
		    			
		    			/*
		    			if( $i== $dt_field){
		    				$a['f'.$i] = getDatetimeFromDatetime($rs[$i]);
		    			}else{
		    				$a['f'.$i] = nullToEmpty($rs[$i]);
		    			}
		    			*/
		    	}
		    	 $tmp4[$count]  = $a;
		    	$count++;
				
			} 
   
		    if($count==0){
				$tmp4 = array("result"=>"empty");
			} 
			
			//followup list ;
			$sql = " SELECT ".$field." ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($_POST['cmpid'])." ".
  						" AND last_wrapup_option_id = 2 ";
				/*
				$sql = " SELECT a.calllist_id , c.first_name , c.last_name , c.tel1 , c.tel2 ".
						" FROM t_calllist_agent a ". 
						" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
						" WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
						" AND last_wrapup_option_id = 2 ";
  			*/
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			    $a = array();
			    $size = count($fields);
		    	for($i=0; $i<$size;$i++){
		    			// change format for datetime field
		    			if( $i== $dt_field){
		    				$a['f'.$i] = getDatetimeFromDatetime($rs[$i]);
		    			}else if( $i == $wrapup_field){
		    				$a['f'.$i] = nullToEmpty( wrapupdtl($rs[$i])); 
		    			}else{
		    				$a['f'.$i] = nullToEmpty($rs[$i]);
		    			}
		    	}
		    	 $tmp5[$count]  = $a;
		    	$count++;
		    	/*
			  	$tmp5[$count] = array(
			  	      			"f0"  => nullToEmpty($rs['calllist_id']),
						        "f1"  => nullToEmpty($rs['first_name']),
								"f2"  => nullToEmpty($rs['last_name']),
							    "f3"  => nullToEmpty($rs['tel1']),
							    "f4"  => nullToEmpty($rs['tel2'])						  	 
						);   
				$count++;  
				*/
			}
		    if($count==0){
					$tmp5 = array("result"=>"empty");
			} 
			
			
			//call history list  ( in this campaign );
			$sql = " SELECT t.call_id , c.first_name , c.last_name , t.wrapup_id , t.wrapup_note ,t.create_date ".
						" FROM t_call_trans t ".
						" LEFT OUTER JOIN t_calllist c ON t.calllist_id = c.calllist_id ".
						" WHERE t.agent_id = ".dbNumberFormat($tmp['uid'])." ".
  						" AND t.campaign_id = ".dbNumberFormat($_POST['cmpid'])." ";
						" ORDER BY t.create_date ";

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			
			  	$tmp6[$count] = array(
			  	      			"cid"  => nullToEmpty($rs['call_id']),
						        "cname"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
								"wid"  => nullToEmpty( wrapupdtl($rs['wrapup_id'])),
							    "wdtl"  => nullToEmpty($rs['wrapup_note']),
							    "cdate"  => getDatetimeFromDatetime($rs['create_date'])						  	 
						);   
				$count++;  
			}
		    if($count==0){
			$tmp6 = array("result"=>"empty");
			} 
			
			
			$data = array( "cfield" => $tmp0 , "pfield"=>$tmp1 , "cmp" => $tmp2 , "clist" => $tmp3 , "totallist"=>$totallist , "cback"=> $tmp4 , "cfollow" => $tmp5 , "chistory"=> $tmp6 ,"fieldlength"=>$fieldlength);
			 
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
	     
  			$sql = " SELECT campaign_id,campaign_name,campaign_detail,start_date,end_date,status". 
						" FROM t_campaign ".
  						" WHERE campaign_id = ".dbNumberFormat( $_POST['id'] )." ";
					
			$count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			
			  	$tmp1 = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"cmpName"  => nullToEmpty($rs['campaign_name']),
							    "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
							    "cmpStartDate"  => dateDecode($rs['start_date']),
						  	 	"cmpEndDate"  => dateDecode($rs['end_date']),
						  		"cmpStatus"  => nullToEmpty($rs['status'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			 
			$data = array("data"=>$tmp1);
		
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	
	
	function wrapupdtl( $pipe_str){
	
		// $tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
	   
		$t = explode("|",$pipe_str);
		$ans = array();
		foreach( $t as $k => $v){
					if(empty($v)){
						break;
					}
					$sql = "SELECT wrapup_dtl FROM t_wrapup_code WHERE wrapup_code = ".$v;
					wlog("wrapup_dtl: ".$sql);
					$result = $dbconn->executeQuery($sql); 
					if($rs=mysql_fetch_array($result)){   
						array_push( $ans , $rs['wrapup_dtl'] );
						//echo $rs['wrapup_dtl']."|";					
					}
		
		}
		
	  // $dbconn->dbClose();
	   
	   /* 
	   //get last wrapup
	   if( empty($ans)){
	   		return "";
	   }else{
	 	  $last =  count($t)-1 ;
	 	  return $ans[$last];
	   }
	   */	
		
	
	   if( empty($ans)){
	   		return "";
	   }else{
	 	//  $last =  count($t)-1 ;
	 	  return $ans[0];
	   }
	   
				
	//echo print_r($ans);
		
		
			//$res = array("result"=>"success");
		//	echo json_encode($res);   
			
		

		
		
	}
	
	
