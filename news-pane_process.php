<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php


   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	//news
	        case "query"  : query(); break;
			case "detail"  : detail(); break;
			case "save"    : save(); break;
			case "delete"  : delete(); break;
			case "hide" : hide(); break;
			
			//comment
			case "queryment" : query_comment(); break;
			case "savement" : save_comment(); break;
			case "deletement" : delete_comment(); break;
			
			case "like" : like(); break;
			case "ulike" : ulike(); break;
 
		 }
	}
	
	
	function query(){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
	     $page = 0;
	     $pagelength = 8;
	     
	     wlog("page: ".$_POST['page']);
	     if( isset($_POST['page'])){
	     	 $pagelength = 8;
	    	 $page =  ( intval($_POST['page']) - 1 ) * $pagelength;
	     }
	    
  			$sql = " SELECT news_id , news_subject , news_detail , news_type , n.is_active, n.create_date, n.create_user , a.first_name , a.last_name , a.img_path ".
  						" FROM t_news n LEFT OUTER JOIN t_agents a ON a.agent_id = n.create_user ".
  						" WHERE a.group_id = ( SELECT group_id FROM t_agents WHERE agent_id = ".dbNumberFormat($tmp['uid'])." ) ".
			  			" ORDER BY n.create_date DESC ";
  			
  			/*
  			if( isset($_POST['option'])){
  				if( $_POST['option']=="current"){
  					$pagelength = intval($_POST['page']) * $pagelength;
  					$sql = $sql." LIMIT  0 , ".$pagelength; 
  				}else{
  					$sql = $sql." LIMIT ".$page." , ".$pagelength; 
  				}
  			}else{
  				$sql = $sql." LIMIT ".$page." , ".$pagelength; 
  			}
  				*/	
  			
  			wlog("news load sql :  ".$sql);
  			
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
				$nid = $rs['news_id']; 
			  	$data[$count] = array(
						        "nid"  => nullToEmpty($nid),
								"nsubject"  => nullToEmpty($rs['news_subject']),
							    "ndetail"  => nullToEmpty($rs['news_detail']),
			  					 "ntype"  => nullToEmpty($rs['news_type']),
								"nactive"  => nullToEmpty($rs['is_active']),
			  					"ncred"  => nullToEmpty($rs['create_date']),
			  					"ncreu" => nullToEmpty($rs['first_name']." ".$rs['last_name']), 
			  					"nim" => nullToEmpty( $rs['img_path']),
			  					"ncid" => nullToEmpty($rs['create_user']),
			  					"tment" => getcomment( $nid),
			  					"tlike" => getlike( $nid ),
						);   
				$count++;  
			}
		    if($count==0){
				$data = array("result"=>"empty");
			} 
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}
	
	//count comment
	function getcomment($newid){
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
			$sql = "SELECT COUNT(news_id) AS total FROM t_news_comment WHERE news_id = ".dbNumberFormat($newid);
			$result = $dbconn->executeQuery($sql);
			$total = 0;
			if($rs=mysqli_fetch_array($result)){
					$total = $rs['total']; 
			}
			return $total;
			
	}
	
	//get like
	function getlike($newid){
		
		$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
			$sql = "SELECT COUNT(*) AS total FROM t_news_like WHERE news_id  = ".dbNumberFormat($newid);
			$result = $dbconn->executeQuery($sql);
			$total = 0;
			if($rs=mysqli_fetch_array($result)){
					$total = $rs['total']; 
			}
		
			
			$sql = "SELECT agent_id FROM t_news_like WHERE news_id = ".dbNumberFormat($newid)." AND agent_id  = ".dbNumberFormat($tmp['uid']);
			$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){
					$tmp1 = "N";
			}else{
					$tmp1 = "Y";
			}
			
			$data = array("like"=>$total,"islike"=>$tmp1);
			return $data;
			
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
	     
	     		$sql = " SELECT news_id , news_subject , news_detail , news_type , n.is_active, n.create_date, n.create_user , a.first_name , a.last_name , a.img_path ".
	  						" FROM t_news n LEFT OUTER JOIN t_agents a ON a.agent_id = n.create_user ".
	  					   	" WHERE news_id =  ".dbNumberFormat($_POST['id'])." ".
				  			" ORDER BY n.create_date ";
	     	
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
				//$nid = $rs['news_id'];
			  	$data =  array(
				     		"nid"  => nullToEmpty($rs['news_id']),
							"nsubj"  => nullToEmpty($rs['news_subject']),
						    "ndetail"  => nullToEmpty($rs['news_detail']),
					  	    "ntype"  => nullToEmpty($rs['news_type']),
					  	    "nactive"  => nullToEmpty($rs['is_active']),
			  				"ncredate"  => nullToEmpty($rs['create_date']),
					  	    "ncred"  => getDatetimeFromDatetime($rs['create_date']),
			  	    		"ncreu"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
			  				"nim"  => nullToEmpty($rs['img_path']),
			  				"ncid" => nullToEmpty($rs['create_user']),
			  				"tment" => getcomment( $_POST['id'] ),
			  				"tlike" => getlike( $_POST['id'] ),
			  				"comment" => query_comment( $_POST['id']),
						);   
			   $count++;
			}
 		    if($count==0){
				$data = array("result"=>"empty");
			}  
			
	 
			$member = "";
			$nomember = "";
			 
		 //	$data = array("data"=>$data,"member"=>$member,"nomember"=>$nomember );	
			$dbconn->dbClose();	 
			echo json_encode( $data ); 
			
	
			
	}
	//end query detail
	function query_comment( $newsid ){
		$dbconn = new dbconn;  
        $dbconn->createConn();
	    $res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
   			$sql = " SELECT comment_id , comment_detail , comment_date , comment_user , a.first_name , a.last_name , a.img_path , c.comment_user ".
  						" FROM t_news_comment c LEFT OUTER JOIN t_agents a ON a.agent_id = c.comment_user ".  		
        		    	" WHERE news_id =  ".dbNumberFormat( $newsid )." ".
   						" ORDER BY comment_id ";
   			
   		
	        $count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$data[$count] =  array(
				     		"mid"  => nullToEmpty($rs['comment_id']),
							"mdetail"  => nullToEmpty($rs['comment_detail']),
			  	   			"mcred"  => getDatetimeFromDatetime($rs['comment_date']),
						    "mdate"  => nullToEmpty($rs['comment_date']),
			  				"muser"  => nullToEmpty($rs['first_name']." ".$rs['last_name']),
			  				"mcid"  => nullToEmpty($rs['comment_user']),
			  				"mim" => nullToEmpty($rs['img_path']),
						);   
			   $count++;
			}
 		    if($count==0){
				$data = array("result"=>"empty");
			}  
		
			return $data;
		
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
			 
				$sql = "SELECT news_id FROM t_news WHERE news_id = ".dbformat($tmp['nid'])." ";
		    	wlog( "[news-pane_process][save] check sql : ".$sql );
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update   
				
					$sql = "UPDATE t_news SET ".
								" news_subject = ".dbformat( $tmp['editnewssubj']).",".	
								" news_detail = ".dbformat( $tmp['editnewsdetail']).",".	
								" news_type = ".dbformat( $tmp['newstype']).",".	
								" is_active = ".dbformat( $tmp['newsstatus']).",".	
							//	" create_date = NOW(),".
							//	" create_user =".dbformat( $tmp['uid']).",".
								" update_date = NOW(),".
								" update_user =".dbformat( $tmp['uid'])." ".
								" WHERE news_id =  ".dbformat( $tmp['nid'])." ";	
					
					 wlog("[news-pane_process][save] update sql : ".$sql);
					$dbconn->executeUpdate($sql); 
					 
				}else{
				   //insert
				   $sql = " INSERT INTO t_news ( news_subject , news_detail , news_type , is_active, create_user , create_date ) VALUES ( ".
					   		   " ".dbformat( $tmp['newssubj'])." ".
							   ",".dbformat( $tmp['newsdetail'])." ".
				     		   ",".dbformat( $tmp['newstype'])." ".
				    		   ",".dbNumberFormat( $tmp['newsstatus'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				   
				    wlog("[news-pane_process][save] insert sql : ".$sql);
					$dbconn->executeUpdate($sql); 
				}		
				
		   //news permission 
		   //INSERT INTO t_news_permission ( news_id , agent_id ) VALUES ()

			//DELETE FROM t_news_permission WHERE news_id = AND agent_id = 
			
   		 
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
	  
	}
	
		function delete(){

	        $tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
		
			//delete news
			$sql = "DELETE FROM t_news WHERE news_id =  ".dbNumberFormat( $tmp['nid'])." ";
			wlog( $sql );
			$dbconn->executeUpdate($sql); 
			
			//delete comment
			$sql = "DELETE FROM t_news_comment WHERE news_id =  ".dbNumberFormat( $tmp['nid'])." ";
			wlog( $sql );
			$dbconn->executeUpdate($sql); 
			
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
	}
	
	function hide(){
		
		   $tmp = json_decode( $_POST['data'] , true); 
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
		
			$sql = " UPDATE  t_news SET is_active = 0 WHERE news_id =  ".dbNumberFormat( $tmp['nid'])." ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
	
		
	}
	
	
	
	function save_comment(){
		
			$tmp = json_decode( $_POST['data'] , true); 
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
			 
				$sql = "SELECT comment_id FROM t_news_comment WHERE comment_id = ".dbformat($tmp['mid'])." ";
		    	wlog( "comment : ".$sql );
				$result = $dbconn->executeQuery($sql); 
				if($rs=mysqli_fetch_array($result)){   
				   //update   
				
					$sql = "UPDATE t_news_comment SET ".
								" comment_detail = ".dbformat( $tmp['editcomment']).",".	
							//	" is_active = ".dbformat( $tmp['mactive']).",".
							//	" expire_date = ".dbformat( $tmp['newsexpiredate']).",".	
								" comment_date = NOW(),".
								" comment_user =".dbformat( $tmp['uid'])." ".
								" WHERE news_id =  ".dbformat( $tmp['nid'])." ".
								" AND comment_id = ".dbformat( $tmp['mid'])." ";
					wlog( "comment : ".$sql );
					$dbconn->executeUpdate($sql); 
					 
				}else{
				   //insert
				   $sql = " INSERT INTO t_news_comment ( news_id , comment_detail , is_active,  comment_user , comment_date ) VALUES ( ". 
					   		   " ".dbformat( $tmp['nid'])." ".
							   ",".dbformat( $tmp['comment'])." ".
				   				", 1 ".
				     		//   ",".dbformat( $tmp['mactive'])." ".
							   ",".dbNumberFormat($tmp['uid'])." , NOW() )  "; 
				   
				     wlog( "comment : ".$sql );
					$dbconn->executeUpdate($sql); 
				}		
				
		   //news permission 
		   //INSERT INTO t_news_permission ( news_id , agent_id ) VALUES ()

			//DELETE FROM t_news_permission WHERE news_id = AND agent_id = 
			
   		 
            $dbconn->dbClose(); 
		    $res = array("result"=>"success");
			echo json_encode($res);   
			
		
	}
	
	function delete_comment(){
	 
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
		
			$sql = " DELETE FROM t_news_comment WHERE comment_id = ".dbNumberFormat( $_POST['mid'])." ";
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
			
	}
	
		function like(){
	 
			$tmp = json_decode( $_POST['data'] , true); 
			
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
			
			$sql = "INSERT INTO t_news_like ( news_id , agent_id , is_like , create_date  ) VALUES (".
						" ".dbNumberFormat( $_POST['id'] )." ".
						",".dbNumberFormat( $tmp['uid'] )." ".
						", 1 , NOW() )  "; 
	  
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
			
	}
	
		function ulike(){
	 
			$tmp = json_decode( $_POST['data'] , true); 
			
			$dbconn = new dbconn; 
			$res = $dbconn->createConn();
			if($res==404){
			        $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
			}
		
			$sql = " DELETE FROM t_news_like WHERE  agent_id = ".dbNumberFormat($tmp['uid'])." AND news_id = ".dbNumberFormat($_POST['id']);
			$dbconn->executeUpdate($sql); 
			$dbconn->dbClose();
		
			$res = array("result"=>"success");
			echo json_encode($res);   
			
	}

?>