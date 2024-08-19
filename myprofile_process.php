<?php session_start(); ?>
<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php" ?>
<?php

   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
	        case "detail"  : detail(); break;
			case "save"    : save(); break;
			case "avatar"  : upload_avatar(); break;
			
			case "save_setting" : save_setting(); break;

		 }
	}
	
	function save_setting(){
		
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				
				$sql = " UPDATE t_agents SET ";
								
				$mysalt = 'dH[vdc]h;18+';
				if( $tmp['upasswd'] !="" ){
					$sql = $sql." agent_password = ".dbformat( sha1($tmp['upasswd'].$mysalt))." "; 
				}
				
				if( $tmp['uextension'] != "" ){
					$sql = $sql." , extension = ".dbformat( $tmp['uextension'] )." ";
				}
				
					$sql = $sql." WHERE agent_id = ".dbNumberFormat( $tmp['uid'])." ";
				      
				wlog("[myprofile_process][save_setting] sql : ".$sql);
				$dbconn->executeUpdate($sql); 
				
				//write back to session
				if( $tmp['uextension']){
						$_SESSION['pfile']['uext'] =$tmp['uextension']; 
				}
				
					
	            $dbconn->dbClose(); 
			    $res = array("result"=>"success");
				echo json_encode($res);   
	  
		
	}


	function detail(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
	    $res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     	//profile detail
  		    $sql = " SELECT agent_login,first_name,last_name,nickname,mobile_phone,img_path,email,extension, group_name , team_name , quote ".
						" FROM t_agents a LEFT OUTER JOIN t_group g ON a.group_id = g.group_id ".
  		    			" LEFT OUTER JOIN t_team t ON a.group_id = t.team_id ".
        		       " WHERE agent_id =  ".dbNumberFormat($tmp['uid'])." ";
      
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$tmp1 =  array(
			  					"ulogin"  => nullToEmpty($rs['agent_login']),
			  	      			"ufirstname"  => nullToEmpty($rs['first_name']),
								"ulastname"  => nullToEmpty($rs['last_name']),
							    "unickname"  => nullToEmpty($rs['nickname']),
			  					"umobile"  => nullToEmpty($rs['mobile_phone']),
			  					"uemail"  => nullToEmpty($rs['email']),
								"uimg"  => nullToEmpty($rs['img_path']),
							    "uext"  => nullToEmpty($rs['extension']),
							  	"ugroup"  => nullToEmpty($rs['group_name']),
							  	"uteam"  => nullToEmpty($rs['team_name']),
			  					"uquote"  => nullToEmpty($rs['quote']),
						);   
			   $count++;
			}
 		    if($count==0){
				$tmp1 = array("result"=>"empty");
			}  
			
			$sql = " SELECT agent_id , create_date ".
						" ,ifnull( login_dt,'N/A') AS login_dt ".
						" ,ifnull( logout_dt,'N/A')  AS logout_dt ".
						" ,ifnull( TIMESTAMPDIFF(second,login_dt,logout_dt) ,0) AS total_sec ".
						" ,ifnull( SEC_TO_TIME(TIMESTAMPDIFF(second,login_dt,logout_dt)),'N/A') AS logon_time ".
						" FROM t_agent_log  ".
					 	" WHERE agent_id =  ".dbNumberFormat($tmp['uid'])." ".
					//	" AND create_date BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now() ".
						" ORDER BY agent_id ,  login_dt DESC ".
						" LIMIT 0,25";
			
			
   			$count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp2[$count] =  array(
			  					"date"  => getDayDateFromDatetime($rs['create_date']),
			  	      			"login"  => getTimeFromDatetime($rs['login_dt']),
								"logout"  => getTimeFromDatetime($rs['logout_dt']),
							    "logon"  => nullToEmpty($rs['logon_time']),
						);   
			   $count++;
			}
 		    if($count==0){
				$tmp2 = array("result"=>"empty");
			}
			
			$data = array("profile"=>$tmp1,"logon"=>$tmp2);
			$dbconn->dbClose();	 
			echo json_encode( $data ); 
			
	}
	//end query detail

    function save(){
	  
				$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
				
				$sql = " UPDATE t_agents SET ".
				      		" first_name =".dbformat( $tmp['ufirstname']).",".
						    " last_name =".dbformat( $tmp['ulastname']).",".	
						    " nickname =".dbformat( $tmp['unickname']).",".	
							" mobile_phone =".dbformat( $tmp['umobile']).",".	
							" quote = ".dbformat($tmp['uquote']).",".
						    " update_date =NOW(),".
						    " update_user =".dbformat( $tmp['uid'])." ".
						    " WHERE agent_id = ".dbNumberFormat( $tmp['uid'])." ";
				$dbconn->executeUpdate($sql); 
				
			 	//write back to session
				$_SESSION['pfile']['uname'] = $tmp['ufirstname']." ".$tmp['ulastname'];
					
	            $dbconn->dbClose(); 
			    $res = array("result"=>"success");
				echo json_encode($res);   
	  
	}
	
	function upload_avatar(){
		
		 wlog("[callList_process][upload] start profile upload  ");
		if (!empty($_FILES))
    	{
    		
    	
    		 
			        //booking id = 
    	 		   if ($_FILES["file"]["error"] > 0)
					{
						  echo "Error: " . $_FILES["file"]["error"] . "<br>";
					} else{
				
				/*		 
						  $filename = basename($_FILES['file']['name']);
						  $fileid = getCurrentDateTime();
						  $filesize = display_filesize($_FILES["file"]["size"]);
						  $filepath = dirname(__FILE__) .'/profiles';
						  $filetype = $_FILES["file"]["type"];
						  
						 $tempFile = $_FILES['file']['tmp_name'];
			        	 $targetFile = getCurrentDateTime()."_".$_FILES['file']['name'];
				*/
			        	// move_uploaded_file($tempFile, "profiles/attach/".$targetFile);
			        	
				 		$path = dirname(__FILE__)."/profiles/agents";
					  	if (!file_exists($path)) {
						    mkdir( $path , 0777, true);
						    wlog("[myprofile_process][upload_avatar] Create profile for agent :  ".$_POST['uid']." - success ");
						}
					
					 //keep user extension files
					 $ext = explode('.',$_FILES['file']['name']);
					 $ext = $ext[1];

					  $path = "profiles/agents/".$_POST['uid'].".".$ext;
			          $tempFile = $_FILES['file']['tmp_name'];
			     
			        //  $targetFile = $targetPath . $_FILES['file']['name'];
			          move_uploaded_file($tempFile, $path);
			
		        
				        $dbconn = new dbconn;  
				        $dbconn->createConn();
						$res = $dbconn->createConn();
					 	if($res==404){
								    $res = array("result"=>"dberror","message"=>"Can't connect to database");
								    echo json_encode($res);		
								    exit();
					     }
				     
				     //mkdir for agent if not
				     // path is profiles/agents/[agent-id]
				     
				     //store image to path /profiles/agents/[agent-id]
	     
				    $aimg = "profiles/agents/".$_POST['uid'].".".$ext;
				    $sql = " UPDATE t_agents SET img_path = ".dbformat($aimg)." ".
				    			" WHERE agent_id = ".dbNumberFormat($_POST['uid'])." ";
				
					 wlog("[myprofile_process][upload] upload file sql : ".$sql);
					 
					 	  
					$dbconn->executeUpdate($sql); 
			    	$dbconn->dbClose();	 
			    	
			    	//write back to session
					$_SESSION['pfile']['uimg'] = $aimg;
				
						
					//return result 
						$data = array("result"=>"success","path"=>$aimg);
						//$data = array(  "filename"=>$filename , "return "=> "profiles/attach/".$targetFile );
						echo json_encode( $data ); 
					}//end else
					
          
    		}//end if
		
		
	}
	

	

?>
