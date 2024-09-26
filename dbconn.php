<?php
/** dbconn.php 
     include database config file ( dbconf.php)
     this class easy for query , insert , update to database
**/
    include ("dbconf.php");
	
    //ini_set('mysql.connect_timeout', 5);
    //ini_set('default_socket_timeout', 5);
	 
	class dbconn{
	 
	      var $db_host;
		  var $db_user;
		  var $db_pass;
		  var $db_name;
		  var $dbconn;
		  		  
			function __construct(){
			
				global $db_server_ip;
				global $db_username;
				global $db_password;
				global $db_name;
			
			    $this->db_host  = $db_server_ip;
				$this->db_user  = $db_username;
				$this->db_pass  = $db_password;
				$this->db_name = $db_name;
				  
				//$this->createConn();
				   
			}        
			
		   
				function createConn(){
				
					 $this->dbconn = @mysqli_connect( $this->db_host, $this->db_user, $this->db_pass,$this->db_name);
					 //@mysqli_select_db($this->db_name,$this->dbconn)or die("Could not select database");
					 if(!@mysqli_select_db($this->dbconn, $this->db_name)){
					 	return "404";
					 }
					 //@mysqli_query("SET NAMES utf8");
					  
					  $cs1 = "SET character_set_results=utf8";
					  $cs2 = "SET character_set_client =utf8";
					  $cs3 = "SET character_set_connection=utf8";
					  @mysqli_query($this->dbconn, $cs1) or die('Error query: ' . mysqli_error());   
					  @mysqli_query($this->dbconn, $cs2) or die('Error query: ' . mysqli_error());   
					  @mysqli_query($this->dbconn, $cs3) or die('Error query: ' . mysqli_error()); 
				} 
				
			function executeQuery( $sql){
				 $result = mysqli_query($this->dbconn, $sql) or die("Query failed : " . mysqli_error()."  Or connection may be closed");
				 return $result;
			}
			function executeUpdate( $sql ){ 	
				/*
				$result = mysqli_query($sql) or die("Query failed : " . mysqli_error()."  Or connection may be closed");       
				return $result;
				*/
				$result = mysqli_query($this->dbconn, $sql);
				return $result;
				  /*
				if (!$result = mysqli_query($sql)) {
				        throw new Exception('You fail: ' . mysqli_error($db));
				}

				try{
						$result = @mysqli_query($sql);
						if(!$result){
							die('invalid query: '.mysqli_error());
						}
				}catch(Exception $e){
					
				}
	*/			
			}
			
		 
			function dbClose(){
				mysqli_close($this->dbconn);
			}
						
			function getConnectionInfo(){
			   $info = "";
			   $info .= " serverIP : ". $this->db_host;
			   $info .= " dbName : ". $this->db_name;
			   $info .= " userName : ".$this->db_user;
			   $info .= " dbPassword : ".$this->db_pass;
			   return $info;
			}
			
			function setDBServerIP($dbServerIP){
			    $this->db_host  = $dbServerIP;		
			}
			
			function setDBName($dbName){
				$this->db_name = $dbName;
			}
			
			function setDBUserName($dbUserName){
				$this->db_user  = $dbUserName;			
			}
			
			function setDBPassword($dbPassword){
				$this->db_pass  = $dbPassword;
			}
	
	}
	  
	 // how to use
	 
	 /*
     $x = new dbconn();  //create new connection
	// $x->createConn();
	  $sql = "insert into test values('8','����')";
	  $x->executeUpdate($sql);
	  
	 $sql = "select project_id , project_name from test ";
	 $query = $x->executeQuery($sql);
	 $x->dbClose();  
	 
	$obj = Array();
	$count = 0; 
	while($rs=mysqli_fetch_array( $query)){
	   $obj[$count]->project_id               = $rs["project_id"];
	   $obj[$count]->project_name        = $rs["project_name"];
       $count++;
	}   
	
	 for($i=0; $i<count($obj); $i++){
	      echo $obj[ $i ] ->project_id;
		  echo $obj[$i]->project_name; 
	 }
	 */
	 //
	 
	  
	?> 