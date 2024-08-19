<?php  session_start(); ?>
<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php


   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
         	//list detail
         	//not use
            case "init" : query(); break;
            
            //table detail
	        case "load"  : query(); break;
			case "detail"  : detail(); break;
			
			case "save"    : save(); break;
			
			case "update" : update(); break;
			case "delete"  : delete(); break;
			
			//remove by check list
			case "remove_list" : 	delete(); break;
			
			//update status
			case "update_status" : update_status(); break;
			
			
			//check recently reminder
			case "alarm" : remineMe(); break;
			case "alarm_off" : alarm_off(); break; // turn off  all miss reminder
			
			case "miss_reminder" : missing_reminder(); break;
			
			//btn delete
			case "btn_delete" : btn_delete(); break;
			
 	   	    
		 }
	}
	
	function btn_delete(){
		
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
			
				$sql = "DELETE FROM t_reminder WHERE reminder_id = ".dbformat($tmp['reminderid'])." ";
				wlog( "[reminder_process][save] check sql : ".$sql );
		    
				$result = $dbconn->executeQuery($sql); 
			
			//reinitial - reminder alert 
			remineMe();	
				
            $dbconn->dbClose(); 
		    //$res = array("result"=>"success");
			//echo json_encode($res);   
	}
	
	//turn off miss reminder 
	function alarm_off(){
		
		$tmp = json_decode( $_POST['data'] , true);
		
		//clear miss reminder  from session too
		unset($_SESSION["pfile"]["miss"]);
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
				$sql = "UPDATE t_reminder SET ".
							" status = 0 ".
							"WHERE reminder_dt < NOW() ".
							" AND status = 1 ".
							" AND create_user =  ".dbNumberFormat($tmp['uid'])." ";
				
					 wlog("turn off reminder : ".$sql);
					 $dbconn->executeUPdate($sql);
					 
			$dbconn->dbClose();	 
			$data = array("result"=>"success");
		    echo json_encode( $data ); 
					
	}
	
	function missing_reminder(){
	
		$tmp = json_decode( $_POST['data'] , true); 
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
				//check is miss some reminder
					$sql = " SELECT COUNT(*) AS total_miss , MAX(reminder_dt) AS last_remind  FROM t_reminder WHERE reminder_dt < NOW() ".
								" AND status = 1 ".
								" AND create_user =  ".dbNumberFormat($tmp['uid'])." ";
					
					wlog("check reminder : ".$sql);
					$result = $dbconn->executeQuery($sql);
					$count = 0;
					if($rs=mysqli_fetch_array($result)){
						$count = $rs['total_miss'];
						$data= array(
											"total" => nullToZero($rs['total_miss']),
											"last_reminder" =>	allthaidate($rs['last_remind']),
											"last_re_time" =>	getTimeFromDatetime($rs['last_remind'])
									 );
					}
					
					if($count>0){
						$result = "miss";
					}else{
						$result = "empty";
					}
					
					wlog($result);
		   			$dbconn->dbClose();	 
					$data = array("result"=>$result,"data"=>$data);
				    echo json_encode( $data ); 
					
					
	     
	}
	
	 //remineMe();
	function remineMe(){
	
		$tmp = json_decode( $_POST['data'] , true); 
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
  			$sql = " SELECT r.reminder_id , r.reminder_dt , r.subject , r.detail , rt.reminder_desc ". 
						" FROM t_reminder r LEFT OUTER JOIN tl_reminder_type rt ON r.reminder_type_id = rt.reminder_type_id ".
						" WHERE r.create_user = ".dbNumberFormat($tmp['uid'])." ".
						" AND r.status = 1 ".
						" AND r.reminder_dt >= NOW() ".
						" ORDER BY r.reminder_dt ".
						" LIMIT 0 , 1 ";
  		
  		wlog("[reminder_process][remineMe] sql :".$sql);
  			
  			$reminddt = "";
  			$remindid = "";
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
				$remindid = $rs['reminder_id'];
				//show info
				$reminder = array(
					"rid" => nullToEmpty($rs['reminder_id']),
					"rsub" => nullToEmpty($rs['subject']),
					"rdtl" => nullToEmpty($rs['detail']),
					"rcat" => nullToEmpty($rs['reminder_desc']),
					"rt" => getTimeFromDatetime($rs['reminder_dt'])
				);
				
				$reminddt = $rs['reminder_dt'];
		 		wlog( $reminddt );
				//update current reminder to status 0 for next reminder
				if( isset($_POST['opt'])){
					if($_POST['opt']=="off"){
						wlog("off reminder");
						//$sql = "UPDATE t_reminder SET status = 0 WHERE reminder_id = ".$rs['reminder_id'];
						$sql = "UPDATE t_reminder SET status = 0 WHERE reminder_id = ".dbNumberFormat($_POST['off_reminderid']);
						wlog( "reminder update : ".$sql );
					    $dbconn->executeUpdate($sql);
					}
				}
				$count++;  
			}else{
				if( isset($_POST['opt'])){
					if($_POST['opt']=="off"){
						wlog("off reminder");
						//$sql = "UPDATE t_reminder SET status = 0 WHERE reminder_id = ".$rs['reminder_id'];
						$sql = "UPDATE t_reminder SET status = 0 WHERE reminder_id = ".dbNumberFormat($_POST['off_reminderid']);
						wlog( "reminder update : ".$sql );
					    $dbconn->executeUpdate($sql);
					}
				}
			}
			
		    if($count==0){
		    	//check empty or miss some reminder
		    	 wlog("reminder is empty");
		    		//default data is empty
				
					
					//check is miss some reminder
					$sql = " SELECT COUNT(*) AS total_miss , MAX(reminder_dt) AS last_remind  FROM t_reminder WHERE reminder_dt < NOW() ".
								" AND status = 1 ".
								" AND create_user =  ".dbNumberFormat($tmp['uid'])." ";
					
					wlog("check reminder : ".$sql);
					$result = $dbconn->executeQuery($sql);
					$count = 0;
					if($rs=mysqli_fetch_array($result)){
						$count = $rs['total_miss'];
						$data= array(
											"total" => nullToZero($rs['total_miss']),
											"last_reminder" =>	allthaidate($rs['last_remind']),
											"last_re_time" =>	getTimeFromDatetime($rs['last_remind'])
									 );
					}
					
					if($count>0){
						$result = "miss";
					}else{
						$result = "empty";
					}
					
										
			}else{
				
				
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
					
					$data  =  (($hour * 60 * 60 ) + ( $min * 60 ) + $sec ) *1000; 
			
					$result = "success";
					$data = array("alarm"=>$data,"remindid"=>$remindid);
					//echo $timeinsec * 1000 ;
					wlog("next remind ".$data);
			
			
			} 
			 
			
			/*
			session_start();
   			 if(isset($_SESSION["uid"])){
   			 	
   			 	wlog( "old value : ".$_SESSION['pfile']['remindMe'] );
   			 	
   			 	$_SESSION['pfile']['remindMe'] = $timeinsec;
   			 	
   			 		wlog( "current value : ".$_SESSION['pfile']['remindMe'] );
   			 }
			*/
			
			wlog($result);
   			$dbconn->dbClose();	 
			$data = array("result"=>$result,"data"=>$data,"remind"=>$reminder);
		    echo json_encode( $data ); 
	
	}

	
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
  			$sql = " SELECT reminder_id , reminder_dt , reminder_type_id , subject , detail , status   ". 
						" FROM t_reminder r LEFT OUTER JOIN tl_reminder_type t  ".
  						" ON r.reminder_type_id = t.reminder_type_id ".
						" WHERE create_user = ".dbNumberFormat($tmp['uid'])." ". 
  					//	" AND status = 1 ".
						" ORDER BY reminder_dt ";
  						//" LIMIT 0 , 10 ";
  						
  			//wlog("init".$sql);
			  		 
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			
			  	$data[$count] = array(
						        "reminderid"  => nullToEmpty($rs['reminder_id']),
								"reminderDate"  => getDatetimeFromDatetime($rs['reminder_dt']),
							    "reminderType"  => nullToEmpty($rs['reminder_type_id']),
			  	   				"reminderSubject"  => nullToEmpty($rs['subject']),
							    "reminderDesc"  => nullToEmpty($rs['detail']),
			  	 				"reminderStatus"  => nullToEmpty($rs['status']),
			  	
						);   
				$count++;  
			}
		    if($count==0){
			$data = array("result"=>"empty");
			} 
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
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
  			$sql = " SELECT reminder_id , reminder_dt , r.reminder_type_id , t.reminder_desc,  t.reminder_icon, subject , detail , r.status   ". 
						" FROM t_reminder r LEFT OUTER JOIN tl_reminder_type t  ".
  						" ON r.reminder_type_id = t.reminder_type_id ".
						" WHERE r.create_user = ".dbNumberFormat($tmp['uid'])." ". 
						//" AND r.status = 1 ".
						" ORDER BY r.reminder_dt ";
  						//" LIMIT 0 , 10 ";
			  		
  			wlog("[reminder_process][query] sql : ".$sql);
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			
			  	$data[$count] = array(
			  	
						        "reminderid"  => nullToEmpty($rs['reminder_id']),
			  	    			"reminderIcon"  => nullToEmpty($rs['reminder_icon']),
			  					"reminderStatus"  => nullToEmpty($rs['status']),
								"reminderDate"  => allthaidate($rs['reminder_dt']),
			  					"reminderTime"  => getTimeFromDateTime($rs['reminder_dt']),
			  					"reminderDT"  => getDatetimeFromDatetime($rs['reminder_dt']),
							    "reminderTypeID"  => nullToEmpty($rs['reminder_type_id']),
			  					"reminderTypeDesc"  => nullToEmpty($rs['reminder_desc']),
			  	 				"reminderSubj"  => nullToEmpty($rs['subject']),
							    "reminderDesc"  => nullToEmpty($rs['detail'])
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
		
		$tmp = json_decode(  true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
  			$sql = " SELECT reminder_id , reminder_dt , r.reminder_type_id , t.reminder_desc,  t.reminder_icon, subject , detail , r.status   ". 
						" FROM t_reminder r LEFT OUTER JOIN tl_reminder_type t  ".
  						" ON r.reminder_type_id = t.reminder_type_id ".
						" WHERE reminder_id = ".$_POST['id'];
  				
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
				
			  	$data = array(
			  	
						        "reminderid"  => nullToEmpty($rs['reminder_id']),
			  	    			"reminderIcon"  => nullToEmpty($rs['reminder_icon']),
			  	
								"reminderDate"  => getOnlyDate($rs['reminder_dt']),
							  	"reminderMonth"  => getOnlyMonth($rs['reminder_dt']),
							  	"reminderYear"  => getOnlyYear($rs['reminder_dt']),
							  	"reminderMM"  => getOnlyMin($rs['reminder_dt']),
							  	"reminderHH"  => getOnlyHour($rs['reminder_dt']),
			  	
							    "reminderTypeID"  => nullToEmpty($rs['reminder_type_id']),
			  					"reminderTypeDesc"  => nullToEmpty($rs['reminder_desc']),
			  	 				"reminderSubj"  => nullToEmpty($rs['subject']),
							    "reminderDesc"  => nullToEmpty($rs['detail']),
			  	 				"reminderStatus"  => nullToEmpty($rs['status']),
						);   
				$count++;  
			}
			
		    if($count==0){
				$data = array("result"=>"empty");
			} 
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	//update status on/off
	function update_status(){
		
			$tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn;  
			$res = $dbconn->createConn();
			if($res==404){
			    $res = array("result"=>"error","message"=>"Can't connect to database");
			    echo json_encode($res);		
			    exit();
			}

			$sql = " UPDATE t_reminder SET ".
						" `status` = ".dbNumberFormat($_POST['value'])." ".
						" WHERE reminder_id = ".dbNumberFormat($_POST['reminderid'])."";

			$dbconn->executeQuery($sql);
		    $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
	}
	
	
	 function save(){
	  
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
			
				$date = $tmp['reminderDate']."/".$tmp['reminderMonth']."/".$tmp['reminderYear'];
				
				$sql = "SELECT reminder_id FROM t_reminder WHERE reminder_id = ".dbformat($tmp['reminderid'])." ";
				wlog( "[reminder_process][save] check sql : ".$sql );
		    
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
					
				   //update   
					$sql = "UPDATE t_reminder SET ".
						        "reminder_dt =".dateTimeEncode( $date , $tmp['reminderHH'].":".$tmp['reminderMM'] ).",".
								"subject =".dbformat( $tmp['reminderSubj']).",".	
							    "detail =".dbformat( $tmp['reminderDesc']).",".	
					 		  	"reminder_type_id =".dbformat( $tmp['reminderType']).",".	
								"status =".dbformat( $tmp['reminderStatus']).",".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE reminder_id = ".dbformat( $tmp['reminderid'])." ";	
					
					 wlog( "[reminder_process][save] update sql : ".$sql );
					$dbconn->executeUpdate($sql); 
					 
				}else{
				   //insert
				   $sql = " INSERT INTO t_reminder( reminder_dt ,reminder_type_id ,subject ,detail , status , create_user, create_date ) VALUES ( ".
					   		   " ".dateTimeEncode( $date , $tmp['reminderHH'].":".$tmp['reminderMM'] )." ".
							   ",".dbformat( $tmp['reminderType'])." ".
				    		   ",".dbformat( $tmp['reminderSubj'])." ".
				   	   		   ",".dbformat( $tmp['reminderDesc'])." ".
				   	   		    ",".dbformat( $tmp['reminderStatus'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				   
				    wlog( "[reminder_process][save] insert sql : ".$sql );
					$dbconn->executeUpdate($sql); 
				}		
				
			//reinitial - reminder alert 
			remineMe();	
				
            $dbconn->dbClose(); 
		    //$res = array("result"=>"success");
			//echo json_encode($res);   
	  
	}
	
		function update(){
			
				$tmp = json_decode( $_POST['data'] , true); 
				
				$act = json_decode( $_POST['active'] , true); 
	 			$ina = json_decode( $_POST['inactive'] , true);
	 			 
		        $tmp1 = "(";
		        if( is_array($act)){
		        		for($i=0;$i<count($act);$i++){
		        				$tmp1 = $tmp1."".$act[$i].",";
		        		}
		        }
		        $tmp1 = $tmp1." null )";
		        
		        $tmp2 = "(";
		        if( is_array($ina)){
		        		for($i=0;$i<count($ina);$i++){
		        				$tmp2 = $tmp2."".$ina[$i].",";
		        		}
		        }
		        $tmp2 = $tmp2." null )";
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				
					//update  status to inactive
					$sql = "UPDATE t_reminder SET ".
								"status = 0 ,".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    " WHERE reminder_id IN ".$tmp2." ";	
					
					 wlog( "[reminder_process][save][inactive] update  sql : ".$sql );
					$dbconn->executeUpdate($sql); 
					
					//update  selected status to active
					$sql = "UPDATE t_reminder SET ".
								" status =1 ,".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE reminder_id IN ".$tmp1." ";	
					
					 wlog( "[reminder_process][save][active] update sql : ".$sql );
					$dbconn->executeUpdate($sql); 
					
				
			$dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
			 
		
		}
	
		function delete(){

	        $tmp = json_decode( $_POST['data'] , true); 
	       // echo var_dump($tmp);
	      //  echo count( $tmp );
	        //echo $tmp;
	        $data = "(";
	        if( is_array($tmp)){
	        		for($i=0;$i<count($tmp);$i++){
	        				//echo $tmp[$i];
	        				$data = $data."".$tmp[$i].",";
	        		}
	        		// $pice =  explode(",",$tmp);
	        		// echo $pice[0];
	        }
	        $data = $data." null )";
	        
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
				
			$sql = " DELETE FROM t_reminder WHERE reminder_id IN ".$data." ";
			wlog( "[reminder_process][delete] delete sql : ".$sql );
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	