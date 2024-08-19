<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php

   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
         	
         	case "init" : init(); break;
	        case "query"  : query(); break;	       
			case "detail"  : detail(); break;
			case "save"    : save(); break;
			case "delete"  : delete(); break;
 
		 }
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
      	/*
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
		//$tmp = json_decode( $_POST['data'] , true); 
		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
  		
	     
	        $sql = " SELECT issue_id , subject , detail , solution , cat1 , cat2 , status , a.first_name , a.last_name , s.create_date   ".
						" FROM t_issues s LEFT OUTER JOIN t_agents a ON s.create_user = a.agent_id ".
	        			" WHERE  s.status != 3 ".
			  			" ORDER BY s.create_date  ";
  			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$data[$count] = array(
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
			 
				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
				if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
				}
			
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