<?php include "../dbconn.php"?>
<?php include "../util.php"  ?> 
<?php include "../wlog.php"  ?> 
<?php


   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         
            case "init"		: init(); 		break; 
            
	        case "query"  : query();  break;
			case "save"    : save();   break;
			
 	   	    
		 }
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
	     
	     switch( $action ){
	     	case "callfrom_ticket" : 
	     			  $sql = "SELECT app_unique_id FROM t_ticket WHERE ticket_id = ".dbNumberFormat( $_POST['data'] )." "; 
	     			  break;
	     	case "callform_wrapup" : 
	     			  $sql = "SELECT app_unique_id FROM t_ticket WHERE calllist_id = ".dbNumberFormat( $_POST['data'] )." "; 
	     			  break;	
	     }
	     
	     	$id = "";
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysql_fetch_array($result)){   
					$id =	 $rs['app_unique_id'];
			}
			
			if( $id != "" ){
				 	$sql = " SELECT first_name , last_name , mobile , gender , product ,  create_user , create_date ".
								" FROM tc_app_project ".
								" WHERE app_uniqued = ".dbformat($id)." ";
				 	
				 	$result = $dbconn->executeQuery($sql);
					if($rs=mysql_fetch_array($result)){   
					 	$tmp1 = array(
								        "fname"  => nullToEmpty($rs['first_name']),
										"lname"  => nullToEmpty($rs['last_name']),
									 	"mobile"  => nullToEmpty($rs['mobile']),
									 	"gender"  => nullToEmpty($rs['gender']),
									 	"prod"  => nullToEmpty($rs['product']),
									 	"cuser"  => nullToEmpty($rs['create_user']),
									 	"cdate"  => nullToEmpty($rs['create_date']),
								);   
					}
					
			}//end if $id
	     	else{
	     		$tmp1 = array("result"=>"empty");
	     	}
			
			$data = array("data"=>$tmp1);
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
	     
	   //  $sql = "SELECT app_uniqueid FROM tc_app_project WHERE app_uniqueid = ".dbNumberFormat( $tmp['uniqueid'] )." ";
	     
		$sql = " SELECT first_name,last_name,mobile,gender,product,create_user,create_date,update_user,update_date ".
					" FROM  tc_app_project ".
					" WHERE app_uniqueid =  ".dbformat( $tmp['uniqueid'] )." "; 

		wlog("[app_project_process][query] sql : ".$sql);
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysql_fetch_array($result)){   
			  	$tmp1 = array(
						     //   "appid"  => nullToEmpty($rs['app_id']),
								"fname"  => nullToEmpty($rs['first_name']),
			  	     			"lname"  => nullToEmpty($rs['last_name']),
								"mobile"  => nullToEmpty($rs['mobile']),
			  	     			"gender"  => nullToEmpty($rs['gender']),
								"product"  => nullToEmpty($rs['product']),
			  	     			"cuser"  => nullToEmpty($rs['create_user']),
								"cdate"  => nullToEmpty($rs['create_date']),
			  	     			"uuser"  => nullToEmpty($rs['update_user']),
								"udate"  => nullToEmpty($rs['update_date']),
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
	
	function save(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
				$sql = "SELECT row_id FROM tc_app_project WHERE app_uniqueid = ".dbformat($tmp['uniqueid'])." ";
				wlog("[app_project_process][save] sql : ".$sql);
				
		
				
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysql_fetch_array($result)){   
				   //update   
					$sql = "UPDATE tc_app_project SET ".
								"app_uniqueid = ".dbformat($key).",".
							   "first_name =".dbformat( $tmp['firstname']).",".						
							   "last_name=".dbformat( $tmp['lastname']).",".
							   "mobile=".dbformat( $tmp['mobile']).",".
							   "gender=".dbformat( $tmp['gender']).",".
							   "product=".dbformat( $tmp['product']).",".
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE app_uniqueid = ".dbformat( $tmp['uniqueid'])." ";	
			 		wlog("[app_project_process][save] update sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					 
				}else{
					
					$key = uniqid();
					wlog("[app_project_process][save] insert get key : ".$key);
				
				   //insert
				   $sql = " INSERT INTO tc_app_project( app_uniqueid, first_name, last_name,mobile,gender,product,create_user,create_date ) VALUES ( ".
				     		   " ".dbformat($key)." ". 
							   ",".dbformat( $tmp['firstname'])." ".
							   ",".dbformat( $tmp['lastname'])." ".						
							   ",".dbformat( $tmp['mobile'])." ".
							   ",".dbformat($tmp['gender'])." ".
							   ",".dbformat( $tmp['product'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
					wlog("[app_project_process][save] insert sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					
					
				}		
				
			//after insert success insert to ticket_api
			$key;
			$sql = "INSERT INTO t_ticket ( ticket_status , app_id , app_uniqueid , cust_fname, cust_lname , calllist_id , campaign_id , is_active , owner_id , create_user , create_date ) VALUES ( ".
						"1".  //new ( default status )
				 		",".dbNumberFormat($tmp['appid'])." ". 
				 		",".dbformat($key)." ". 
						
					    ",".dbformat( $tmp['firstname'])." ".
					    ",".dbformat( $tmp['lastname'])." ".			
			
					    ",".dbNumberFormat( $tmp['clid'])." ".
					    ",".dbNumberFormat($tmp['cmpid'])." ".
						",1".  // ( default status )
					    ",".dbNumberFormat( $tmp['uid'])." ".
					    ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
			
			wlog("[app_project_process][save] ticket insert sql : ".$sql);
			$dbconn->executeUpdate($sql); 
				
			
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
	  
		
		
	}

	
?>