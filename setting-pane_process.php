<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php

   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
         	//user field settings
         	case "ufeld_init" 		: ufield_init(); break;
        	case "ufield_detail"   : ufield_detail(); break;
         	case "ufield_save" 	: ufield_save(); break;
			case "ufield_delete"  : ufield_delete(); break;
			
			
			//external app settings
			case "exapp_init" : exapp_init(); break;
			case "exapp_detail" : exapp_detail(); break;
			case "exapp_save" : exapp_save(); break;
			case "exapp_delete" : exapp_delete(); break; 	
		
 
		 }
	}
	
	
	
	function ufield_init(){
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     $sql = " SELECT field_id , field_name , field_alias_name , field_type , field_detail , field_length , is_default , `status` , a1.first_name AS cfname , a1.last_name AS clname , fl.create_date , ".
	     			"  fl.update_date , a2.first_name AS ufname , a2.last_name  AS ulname ".
					" FROM ts_field_list fl ".
					" LEFT OUTER JOIN t_agents a1 ON fl.create_user = a1.agent_id ".
	     			" LEFT OUTER JOIN t_agents a2 ON fl.update_user = a2.agent_id ".
	     			" WHERE is_default = 0 ".
					" ORDER BY field_id";
	     
	     wlog( "[setting-pane_process][init] sql : ".$sql );

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1[$count] = array(
						        "fid"  => nullToEmpty($rs['field_id']),
								"fname"  => nullToEmpty($rs['field_name']),
							    "faname"  => nullToEmpty($rs['field_alias_name']),
			  					"ftype"  => nullToEmpty($rs['field_type']),			 
			  	  				"fdtl"  => nullToEmpty($rs['field_detail']),
								"flength"  => nullToEmpty($rs['field_length']),
							    "isdefault"  => nullToEmpty($rs['is_default']),
			  					"status"  => nullToEmpty($rs['status']),
			  					"cuser" => nulltoEmpty( $rs['cfname']." ".$rs['clname']),
			  					"cdate" => getDatetimeFromDatetime( $rs['create_date']),
			  					"uuser" =>  nulltoEmpty( $rs['ufname']." ".$rs['ulname']),
			  					"udate" => getDatetimeFromDatetime( $rs['update_date']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
	      
		 	$dbconn->dbClose();	 
		 	$data = array("sysfield"=>$tmp1 );		 	
			echo json_encode( $data ); 
		
		
	}
	 
	function ufield_detail(){

		$dbconn = new dbconn;  
	    $res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	        $sql = " SELECT field_id , field_name , field_alias_name , field_type , field_detail , field_length , is_default , `status` , a1.first_name AS cfname , a1.last_name AS clname , fl.create_date , ".
	     			"  fl.update_date , a2.first_name AS ufname , a2.last_name  AS ulname ".
					" FROM ts_field_list fl ".
					" LEFT OUTER JOIN t_agents a1 ON fl.create_user = a1.agent_id ".
	     			" LEFT OUTER JOIN t_agents a2 ON fl.update_user = a2.agent_id ".
	              	" WHERE field_id = ".dbNumberFormat( $_POST['fid'])." ";	
			
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$data =  array(
			  	             	"fid"  => nullToEmpty($rs['field_id']),
								"fname"  => nullToEmpty($rs['field_name']),
							    "faname"  => nullToEmpty($rs['field_alias_name']),
			  					"ftype"  => nullToEmpty($rs['field_type']),			 
			  	  				"fdtl"  => nullToEmpty($rs['field_detail']),
								"flength"  => nullToEmpty($rs['field_length']),
							    "isdefault"  => nullToEmpty($rs['is_default']),
			  					"status"  => nullToEmpty($rs['status']),
			  					"cuser" => nulltoEmpty( $rs['cfname']." ".$rs['clname']),
			  					"cdate" => getDatetimeFromDatetime( $rs['create_date']),
			  					"uuser" =>  nulltoEmpty( $rs['ufname']." ".$rs['ulname']),
			  					"udate" => getDatetimeFromDatetime( $rs['update_date']),
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

    function ufield_save(){
	  
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				 
				$field_type = "";
				$field_detail = "";  //if field detail  type phone it can make call from this field
				$field_length = "";
				//system auto field 
				switch($tmp['fieldtype']){
					case  "caption" : $field_type = "varchar"; 
												 $field_detail = "	text";
												 $field_length = "100";
												 break; 
					case  "text" 	   : $field_type = "varchar";	 
												 $field_detail = "text";
												 $field_length = "100";
												 break; 
					case "decimal" :  $field_type = "decimal"; 
						 						  $field_detail = "text";
						 						  $field_length = "(9,2)";
											  	  break;
					case "integer"    : $field_type = "integer"; 
												  $field_detail = "text";
												  $field_length = "9";
												  break;
												  
					case "percent"	 : $field_type = "integer"; 
						  						  $field_detail = "text";
						  						  $field_length = "3";
												   break;
					case "currency" : $field_type = "double";  
						 						  $field_detail = "currency";
						  						  $field_length = "(9,2)";
												break;
					case "email" : $field_type= "varchar";
												 $field_detail = "	email";
												 $field_length = "50";
												 break;
					
					case "phone" : 	$field_type = "varchar"; 
												$field_detail = "phone";
												 $field_length = "50";
												break;
					
					case "age" : $field_type = "integer" ; 
										$field_detail = "text";
										 $field_length = "3";
											break;
											
					case "date" : $field_type = "date" ;
										$field_detail = "text";
										 $field_length = "50";
											 break;
											 
					case "time" : $field_type = "time" ;
										  $field_detail = "text"; 
										  $field_length = "50";
										break;
												
					case "datetime" : $field_type = "datetime" ;
												  $field_detail = "text";
												  $field_length = "50";
										break;
				}
				
			
				$sql = "SELECT field_id FROM ts_field_list WHERE field_id = ".dbNumberFormat($tmp["fid"])." ";
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update 
					$sql = "UPDATE ts_field_list SET ".
						        "field_name =".dbformat( removeSpace($tmp['userdefine'] )).",".
							    "field_alias_name =".dbformat( $tmp['userdefine']).",".	
					        	"field_type = ".dbformat( trim($field_type) ).",".
							    "field_detail = ".dbformat( trim($field_detail) ).",".	
					   			"field_length =".dbformat( trim($field_length) ).",".
							    "is_default = 0 ,".	
					 			"`status` = 1 ,".	
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE field_id = ".dbNumberFormat( $tmp['fid'])." ";	
					
					wlog("[setting-pane_process][update] sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					 
				}else{

				   //insert
				$sql = " INSERT INTO  ts_field_list (  	field_name , field_alias_name , field_type , field_detail , field_length , is_default , `status` , create_user , create_date ) VALUES ( ".
							" ".dbformat( removeSpace($tmp['userdefine']))." ".
							",".dbformat( $tmp['userdefine'])." ".
							",".dbformat( trim($field_type) )." ".
							",".dbformat( trim($field_detail) )." ".
							",".dbformat( trim($field_length) )." ".
							",0 ".
							",1 ".
							",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				
					wlog("[setting-pane_process][insert] sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					
				}		
				
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
	  
	}
	
		function ufield_delete(){

	        $tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
				
			//check is status 
			//2 = in use
			//1 = active
			//0 = delete 
			
			$sql = "SELECT `status` FROM ts_field_list ".
						" WHERE field_id = ".dbNumberFormat( $tmp['fid'])." ";

				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
					//if status == 2 do update ( set to 0 ) 
					
					if($rs['status']==2){
						
								$sql = " UPDATE  FROM ts_field_list SET ".
											" `status` = 0 ".
											" WHERE field_id = ".dbNumberFormat( $tmp['fid'])." ";	
								wlog("[setting-pane_process][delete]  sql : ".$sql);
								$result = $dbconn->executeUpdate($sql); 
								
					}else{
						
								$sql = "DELETE FROM ts_field_list  WHERE field_id = ".dbNumberFormat( $tmp['fid'])." ";	
								wlog("[setting-pane_process][delete] sql : ".$sql);
								$result = $dbconn->executeUpdate($sql); 
						
					}
					
				}
			
			$dbconn->dbClose();
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	
	//register application section
	function exapp_init(){
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     $sql = " SELECT ex_app_id , r.campaign_id , c.campaign_name, ex_app_name , ex_app_url , r.is_active , a.first_name , a.last_name , r.create_date ".
					 " FROM t_external_app_register r LEFT OUTER JOIN t_agents a ON r.create_user = a.agent_id  ".
	     			" LEFT OUTER JOIN t_campaign c ON r.campaign_id = c.campaign_id ".
					 " ORDER BY ex_app_id ";
					
	     wlog( "[setting-pane_process][exapp_init] sql : ".$sql );

			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1[$count] = array(
			  	   				"exappid"  => nullToEmpty($rs['ex_app_id']),
						        "exappcname"  => nullToEmpty($rs['campaign_name']),
			  	  				"exappname"  => nullToEmpty($rs['ex_app_name']),
								"exappurl"  => nullToEmpty($rs['ex_app_url']),
							    "exappsts"  => nullToEmpty($rs['is_active']),
			  					"cuser" => nulltoEmpty( $rs['first_name']." ".$rs['last_name']),
			  					"cdate" => getDatetimeFromDatetime( $rs['create_date']),
						);   
				$count++;  
			}
		    if($count==0){
				$tmp1 = array("result"=>"empty");
			} 
			
			//query lookup campaign name
				$sql = " SELECT campaign_id,campaign_name".
							" FROM t_campaign".
							" ORDER BY campaign_id"; 
				
	     	$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp2[$count] = array(
			  	   				"id"  => nullToEmpty($rs['campaign_id']),
						        "value"  => nullToEmpty($rs['campaign_name'])
						);   
				$count++;  
			}
		    if($count==0){
				$tmp2 = array("result"=>"empty");
			} 
			
		 	$dbconn->dbClose();	 
		 	$data = array("total"=>$count, "exapp"=>$tmp1,"cmp"=>$tmp2 );		 	
			echo json_encode( $data ); 
		
	}
	
		function exapp_detail(){
		$dbconn = new dbconn;  
	    $res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	      $sql = " SELECT campaign_id , ex_app_id , ex_app_name , ex_app_icon ,  ex_app_url , r.is_active , a.first_name , a.last_name , r.create_date ".
					 " FROM t_external_app_register r LEFT OUTER JOIN t_agents a ON r.create_user = a.agent_id  ".
	          		 " WHERE ex_app_id = ".dbNumberFormat( $_POST['exappid']);
	      
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$data =  array(
			  	    			"exappcmpid"  => nullToEmpty($rs['campaign_id']),
			  	                "exappid"  => nullToEmpty($rs['ex_app_id']),
			  	  				"exappname"  => nullToEmpty($rs['ex_app_name']),
								"exappurl"  => nullToEmpty($rs['ex_app_url']),
			  					"exappicon"  => nullToEmpty($rs['ex_app_icon']),
							    "exappsts"  => nullToEmpty($rs['is_active']),
			  					"cuser" => nulltoEmpty( $rs['first_name']." ".$rs['last_name']),
			  					"cdate" => getDatetimeFromDatetime( $rs['create_date']),
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

   function exapp_save(){
  
			$tmp = json_decode( $_POST['data'] , true); 
		 
			$dbconn = new dbconn;  
			$res = $dbconn->createConn();
			if($res==404){
			    $res = array("result"=>"error","message"=>"Can't connect to database");
			    echo json_encode($res);		
			    exit();
			}
			
				$sql = "SELECT ex_app_id FROM t_external_app_register WHERE ex_app_id = ".dbNumberFormat($tmp["exappid"])." ";
				wlog( $sql );
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update 
					$sql = "UPDATE t_external_app_register SET ".
					     		"campaign_id =".dbNumberFormat( $tmp['exapp_campaign'] ).",".
						        "ex_app_name =".dbformat( removeSpace($tmp['exapp_name'] )).",".
							    "ex_app_url =".dbformat( $tmp['exapp_url']).",".
	  							"ex_app_icon =".dbformat( $tmp['exapp_icon']).",".
					 			" is_active = ".dbNumberFormat( $tmp['exapp_sts'] ).",".
							    "update_date =NOW(),".
							    "update_user =".dbformat( $tmp['uid'])." ".
							    "WHERE ex_app_id = ".dbNumberFormat( $tmp['exappid'])." ";	
					
					wlog("[setting-pane_process][exapp_save] UPDATE sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					 
				}else{

				   //insert
				$sql = " INSERT INTO  t_external_app_register (  campaign_id , ex_app_name , ex_app_url , ex_app_icon , is_active , create_user , create_date ) VALUES ( ".
							" ".dbNumberFormat( $tmp['exapp_campaign'] )." ".
							",".dbformat( $tmp['exapp_name'])." ".
							",".dbformat( $tmp['exapp_url'])." ".
							",".dbformat( $tmp['exapp_icon'])." ".
							",".dbNumberFormat( $tmp['exapp_sts'] )." ".
							",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				
					wlog("[setting-pane_process][exapp_save] INSERT sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					
				}		
				
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
   }
   
   function exapp_delete(){
   	
   			$tmp = json_decode( $_POST['data'] , true); 
		 
			$dbconn = new dbconn;  
			$res = $dbconn->createConn();
			if($res==404){
			    $res = array("result"=>"error","message"=>"Can't connect to database");
			    echo json_encode($res);		
			    exit();
			}
			
   			$sql = "DELETE FROM t_external_app_register  WHERE ex_app_id = ".dbNumberFormat( $tmp['exappid'])." ";	
			wlog("[setting-pane_process][exapp_delete] sql : ".$sql);
			$result = $dbconn->executeUpdate($sql); 
								
			$dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
   }

?>