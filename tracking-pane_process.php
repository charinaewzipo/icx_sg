<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php


   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
            case "init" : init(); break;
             
	        case "query"  : query(); break;
			case "detail"  : detail(); break;
			
			case "save"    : save(); break;
			case "delete"  : delete(); break;
			
			
			case "loadcaption" : load_caption(); break; 
			case "savecaption" : save_caption(); break;

			case "joinList" : join_list(); break;
			case "unjoinList" : unjoin_list(); break;
 	   	    
		 }
	}
	
	function search(){
		
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	      //search
			$sql = " SELECT first_name , last_name , tel1 , tel2 ,tel3 ,tel4 , tel5 ,tel6   ".
						" FROM t_calllist ";
			
			if( $tmp['search_firstname'] != "" ){
					$sql = $sql." AND first_name LIKE '%".$tmp['search_firstname']."%' ";
			}
			if( $tmp['search_lastname'] != ""){
				$sql = $sql." AND first_name LIKE '%".$tmp['search_lastname']."%' ";
			}
			if( $tmp['search_tel'] != "" ){
				$sql = $sql." AND first_name LIKE '%".$tmp['search_tel']."%' ";
			}
				$sql = $sql." ORDER BY first_name , last_name  ";
			
			
			wlog("[tracking-pane_process][search] sql ".$sql);
			
		
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp1[$count] = array(
						        "fn"  => nullToEmpty($rs['first_name']),
								"ln"  => nullToEmpty($rs['last_name']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
	     
			$data = array("search"=>$tmp1);
			
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
	
	function searchdetail(){
	
			$dbconn = new dbconn;  
			$res = $dbconn->createConn();
		 	if($res==404){
					    $res = array("result"=>"dberror","message"=>"Can't connect to database");
					    echo json_encode($res);		
					    exit();
		     }
		     
		     //select in 2 campaign 
		     
		     //not depend on campaign
		     $sql = " SELECT import_id , import_key , list_name , list_detail , file_name , file_size , file_type ".
		     			" FROM t_import_list ".
						" WHERE  import_id = ".dbNumberFormat($tmp['impid'])."  ";
		     
		     //step1 find lead join in what campaign
		     $sql = "SELECT campaign_id FROM t_campaign_list WHERE import_id = ".dbNumberFormat($tmp[''])." ";
		     
		     //from step1 find campaign dynamic field ( they can one more campaign ) 
		     $sql = "";
		     
		     //query data show in dynamic field
		     $sql = "";
		     
		     //depend on camapign 
		     //find this lead on agent hands
		     $sql = " SELECT * FROM t_calllist_agent WHERE calllist_id = ".dbNumberFormat($tmp[''])." ";
		     
		     //depend on campaign
		     //find  call wrapup history for this campaign
		     $sql= " SELECT campaign_id , agent_id , wrapup_id , wrapup_note , wrapup_option_id , create_date ".
		     			" FROM t_call_trans t WHERE calllist_id = ".dbNumberFormat($tmp[''])." ";
		    
		     
			wlog("[tracking-pane_process][search] sql ".$sql);
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp1[$count] = array(
						        "fn"  => nullToEmpty($rs['first_name']),
								"ln"  => nullToEmpty($rs['last_name']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
	     
			$data = array("search"=>$tmp1);
			
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	}
	
	
	function init(){
	
		//$tmp = json_decode( $_POST['data'] , true); 
		
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     //init campaign field
		$sql = " SELECT campaign_id , campaign_name  ".
					" FROM t_campaign ".
					" ORDER BY campaign_id ".
					" AND status = 1 ";
		
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp1[$count] = array(
						        "id"  => nullToEmpty($rs['campaign_id']),
								"value"  => nullToEmpty($rs['campaign_name'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			
			//query list
				$sql = " SELECT list_id , list_name ".
							" FROM t_list ".
							" WHERE status = 1 ".
							" ORDER BY list_id  ";
		
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp2[$count] = array(
			  				    "id"  => nullToEmpty($rs['list_id']),
								"value"  => nullToEmpty($rs['list_name'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
			
			//query group
			$sql = " SELECT group_id , group_name".
						" FROM t_group ".
						" ORDER By group_id ";
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp3[$count] = array(
			  				    "id"  => nullToEmpty($rs['group_id']),
								"value"  => nullToEmpty($rs['group_name'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp3 = array("result"=>"empty");
			} 
			
			//query team
			$sql = " SELECT team_id , team_name ".
						" FROM t_team ".
						" ORDER BY team_id ";
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp4[$count] = array(
			  				    "id"  => nullToEmpty($rs['team_id']),
								"value"  => nullToEmpty($rs['team_name'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp4 = array("result"=>"empty");
			} 
			
			//query agent
			$sql = " SELECT agent_id , first_name , last_name ".
						" FROM t_agents ".
						" WHERE is_active = 1 ".
						" ORDER BY agent_id ";
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
			  	$tmp5[$count] = array(
			  				    "id"  => nullToEmpty($rs['agent_id']),
								"value"  => nullToEmpty($rs['first_name']." ".$rs['last_name'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp5 = array("result"=>"empty");
			} 
			
			
			$data = array("cmp"=>$tmp1,"list"=>$tmp2,"group"=>$tmp3,"team"=>$tmp4,"agent"=>$tmp5);
			
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
	
	
	}
	
	function join_list(){
		
		$tmp = json_decode( $_POST['data'] , true); 
	    $dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     $sql = "INSERT INTO t_campalign_list ( campaign_id , list_id , join_user , join_date) VALUES ( ".
	     			 ",".dbNumberFormat( $tmp['cmpid'])." ".
	      			 ",".dbNumberFormat( $tmp['lid'])." ".
	     			 ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
	     
	    $success = $dbconn->executeUpdate($sql);
	    if($success){
	    	
	    }
	   	$dbconn->dbClose();	 
	   	
	   	$data = array("result"=>"success");
		echo json_encode( $data ); 
		
	     
	}
	
	function unjoin_list(){
		$tmp = json_decode( $_POST['data'] , true); 
	    $dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	        $sql = "DELETE FROM  t_campalign_list WHERE campaign_id= ".dbNumberFormat($tmp['cmpid'])." AND list_id = ".dbNumberFormat($tmp['lid'])." ";
	     	$success = $dbconn->executeUpdate( $sql );
	     	if($success){
	     	
	     	}
	      	$dbconn->dbClose();	 
	   	
		   	$data = array("result"=>"success");
			echo json_encode( $data ); 
	     
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
	     
  			$sql = " SELECT campaign_id,campaign_name,campaign_detail,start_date,end_date,status". 
						" FROM t_campaign ".
						" ORDER BY campaign_id ";
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
				$status = $rs['status'];   
		 
			   if($status==1){
			   		$status = "Active";
			   }else
			   if($status==0){
			   		$status = "Inactive";
			   }
			  	$data[$count] = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"cmpName"  => nullToEmpty($rs['campaign_name']),
							    "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
							    "cmpStartDate"  => dateDecode($rs['start_date']),
						  	 	"cmpEndDate"  => dateDecode($rs['end_date']),
						  		"cmpStatus"  => $status
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
	     
  			$sql = " SELECT campaign_id,campaign_name,campaign_detail,start_date,end_date,status,c.script_id,s.script_detail ". 
						" FROM t_campaign c LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id ".
  						" WHERE campaign_id = ".dbNumberFormat( $_POST['id'] )." ";
					
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
			  					"callscriptid"  => nullToEmpty($rs['script_id']),
			  					"callscriptdtl"  => nullToEmpty($rs['script_detail']),
			  	
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
			 
			$data = array("data"=>$tmp1,"callscript"=>$tmp2);
		
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
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
		
				$sql = "SELECT campaign_id FROM t_campaign WHERE campaign_id = ".dbformat($tmp['cmpid'])." ";
		    
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
					
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
					 
				}else{
				   //insert
				   $sql = " INSERT INTO t_campaign( campaign_name,campaign_detail, start_date,end_date,status , script_id, create_user, create_date ) VALUES ( ".
					   		   " ".dbformat( $tmp['cmpName'])." ".
							   ",".dbformat( $tmp['cmpDetail'])." ".
				   	   		   ",".dateEncode( $tmp['cmpStartDate'])." ".
						   	   ",".dateEncode( $tmp['cmpEndDate'])." ".
						   	   ",".dbformat( $tmp['cmpStatus'])." ".
				     		   ",".dbNumberFormat( $tmp['scriptname'])." ".
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
				
			$sql = " DELETE FROM t_campaign WHERE campaign_id = ".dbNumberFormat( $tmp['cmpid'])." ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	