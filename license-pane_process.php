<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php 

error_reporting(E_ALL);
ini_set('display_errors',1);

//step1 
//getLicense();  //get .lic
//step2 remove from prd
//upload .lic
//set license if not demo
//genCertificate(); //gen .lic to .cer
//step3
//testCer(); //test .cer is ok
//step4 remove from prd
//setLicense();  //set new license

  	if(isset($_POST['action'])){ 
        switch( $_POST['action']){
        	
         	case "query"  : query(); break;
         	//step1 
         	case "getLicense" : getLicense(); break; //get .lic
         	case "updateLicense" : updateLicense(); break;
         	
         	//move from production
         	case "setLicense" : setLicense(); break;
         	
		 }
	}
	
	 function query(){

		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }

	     //user in system
	     $sql =" SELECT  sum( a.lvl_agent ) as lvl_agent ".
	     			", sum( a.lvl_sup ) as lvl_sup ".
	     			", sum( a.lvl_qcqa ) as lvl_qcqa ".
			     	", sum( a.lvl_manager ) as lvl_manager ".
			     	", sum( a.lvl_project ) as lvl_project ".
			     	", sum( a.lvl_admin ) as lvl_admin ".
	     			 " FROM ( SELECT agent_id".
	     			" , CASE WHEN  level_id = 1 then 1 else 0 end AS lvl_agent ".
	     			" , CASE WHEN level_id =  2 then 1 else 0 end AS lvl_sup ".
	     			" , CASE WHEN level_id = 3 then 1 else 0 end AS lvl_qcqa ".
	     			" , CASE WHEN level_id = 4 then 1 else 0 end AS lvl_manager ".
	     			" , CASE WHEN level_id = 5 then 1 else 0 end AS lvl_project ".
	     			" , CASE WHEN level_id = 6 then 1 else 0 end AS lvl_admin ".
	     			" FROM t_agents ) AS a ";
		
	    wlog("[license-pane_process][query] get user in system sql : ".$sql);
	    $count = 0;
    	$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$tmp1= array(
			  	  				"agent" => nullToEmpty($rs['lvl_agent']),
						        "sup"  => nullToEmpty($rs['lvl_sup']),
			  					"qc"  => nullToEmpty($rs['lvl_qcqa']),
								"mgm"  => nullToZero($rs['lvl_manager']),
							    "proj"  => nullToZero($rs['lvl_project']),
							    "adm"  => nullToZero($rs['lvl_admin']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp1 = array("result"=>"empty");
		} 

			
	     //user in system
	       $sql = " SELECT s.agent_id as total_user  , ".
					  " CASE WHEN level_id = 1 then 1 else 0 end AS lvl_agent ,".
					  " CASE WHEN level_id = 2 then 1 else 0 end AS lvl_sup , ".
					  " CASE WHEN level_id = 3 then 1 else 0 end AS lvl_qcqa ,".
					  " CASE WHEN level_id = 4 then 1 else 0 end AS lvl_manager , ".
					  " CASE WHEN level_id = 5 then 1 else 0 end AS lvl_project ,".
					  " CASE WHEN level_id = 6 then 1 else 0 end AS lvl_admin".
					  " FROM t_session s LEFT OUTER JOIN t_agents a ON s.agent_id = a.agent_id".
 
	   wlog("[license-pane_process][query] get user in system sql : ".$sql);
	    $count = 0;
    	$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){   
			  	$tmp2 = array(
			  					"total" => nullToEmpty($rs['total_user']),
			  	  				"agent" => nullToEmpty($rs['lvl_agent']),
						        "sup"  => nullToEmpty($rs['lvl_sup']),
			  					"qc"  => nullToEmpty($rs['lvl_qcqa']),
								"mgm"  => nullToZero($rs['lvl_manager']),
							    "proj"  => nullToZero($rs['lvl_project']),
							    "adm"  => nullToZero($rs['lvl_admin']),
						);   
				$count++;  
			}
		    if($count==0){
			$tmp2 = array("result"=>"empty");
		} 
		
		   //get license
		   
		   $readfile = dirname(__FILE__) .'/temp/tubtim.cer';
	 
			if(file_exists($readfile)) {
			   $str = xcrypt(trim(readLine( $readfile , 2 )));
			   $t = explode(";", $str);
			   if( count($t) != 0){
			 		  $tmp3 = array( 
								"agent" => $t[0],
								"sup" => $t[1],
								"qc" => $t[2],
								"mgm" => $t[3],
								"proj" => $t[4],
								"adm" => $t[5],
							);
			   }else{
			  	 	$tmp3 = array("result"=>"empty");
			   }
			
			}else{
				$tmp3 = array("result"=>"empty");
			}
	
			$data = array("systemu"=>$tmp1, "online"=>$tmp2,"lic"=>$tmp3 );
			 
		 	$dbconn->dbClose();	 
			echo json_encode( $data ); 
					
	}

	//not used
	//test only
	function genlicense(){
		
		$ip="192.168.1.101";
		$mac="12:2f:b3:a2:da:7e";
		$code="tkone";
		
		 
		 $license = $ip."".$mac."".$code;
		 $algo = '6';
		 $rounds = '9898';
		 
		 $CryptSalt = '$' . $algo . '$rounds=' . $rounds . '$' . $license;
		 $HashedPassword = crypt($license, $CryptSalt);
		echo "===== LICENSE (mysite.com, mysite.com, valid thru 2005-12-29) ===== <br/>" 
		
		 .substr(strrchr($HashedPassword,"$"),count($HashedPassword) ).
		
		"<br/>". ($HashedPassword) . 
		"<br/> ===== ENF OF LICENSE ===== <br/>";
		
		//check
		$getip="192.168.1.101";
		$getmac="12:2f:b3:a2:da:7e";
		$getcode="tkone";
		
		 $xlicense = $getip."".$getmac."".$getcode;
		
		if (crypt($xlicense, $HashedPassword) == $HashedPassword) {
				echo "match";
		}else{
				echo "not match";
		}
		///test
		
		$hash = '$6$rounds=9898$192.168.1.10112:$5GTIcScnpiRL8r1Ht21bLAPaMkXcqnu/fKV.gAiDcZiEI14X1yiYZ8/yuVkHV.lNdfgBFb7BX1TOJKpoit0lf.';
		$rehash = 	substr(strrchr($HashedPassword,"$"),count($HashedPassword) );
		$xhash = '$6$rounds=9898$192.168.1.10112:$'.$rehash;
		echo "<br/>";
		if( $hash == $xhash ){
			echo "rehash match";
		}else{
			echo "rehash not match";
		}
		
		
		//test
		/*
		echo "<br/>";
		$str = "Hello, My Name is Tom";
		echo strtr($str,'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
		         				 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		
		$x =	strtr($str,'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
		         				 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		
		echo strtr($x,'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
		         				 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		
		*/
		
		
	}
	

	function updateLicense(){
	 	if (!empty($_FILES))
    	{
    	 		   if ( $_FILES["file"]["error"] > 0)
					{
						  	wlog("[Error][license-pane_process][upload] Error code : " . $_FILES["file"]["error"] );
					  	    switch($_FILES["file"]["error"] ) { 
					  	    	case 1 : wlog("[license-pane_process][upload] Error : The uploaded file exceeds the upload_max_filesize directive in php.ini");
					  	    				   break;
					  	    	case 2 : wlog("[license-pane_process][upload] Error :The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form");
					  	    				   break;
					  	    	case 3 : wlog("[license-pane_process][upload] Error :  The uploaded file was only partially uploaded");
					  	    				  break;
					  	    	case 4 : wlog("[license-pane_process][upload] Error :  No file was uploaded");
					  	    				  break;
					  	  		case 5 : wlog("[license-pane_process][upload] Error : Missing a temporary folder");
					  	    				   break;
					  	    	case 6 : wlog("[license-pane_process][upload] Error : Failed to write file to disk");
					  	    				  break;
					  	    	case 7 : wlog("[license-pane_process][upload] Error : File upload stopped by extension");
					  	    				  break;
					  	     	default : wlog("[license-pane_process][upload] Error : Unknown upload error");
					  	    				  break;
					  	   }
					} else{
						  wlog("[license-pane_process][upload] file ok to upload ");
						  $filename = basename($_FILES['file']['name']);
						  $tempFile = $_FILES['file']['tmp_name'];
			        	  move_uploaded_file($tempFile, "temp/".$filename);
			        	 
			        	// move_uploaded_file($tempFile, "profiles/attach/".$filename);
						 wlog("[license-pane_process][upload] license file upload success ");
						 
						 //call test function();
					   	 $res = array("result"=>"success");
		 				 echo json_encode($res);
						 
						
					}//end else
    	}//end if
	}
	
	//function process .lic
	function getLicense(){
		
		   $tmp = json_decode( $_POST['data'] , true); 
		   $ip= trim(getIP());
		   $mac= trim(getMac());
		   $comp= trim($tmp['licensefor']);
		   $str = $ip.';'.$mac.";".$comp;
		   $str = base64_encode( $str );
		   $file = dirname(__FILE__) .'/temp/tubtim.lic';
		   $x = fopen($file, 'w');
		   fwrite($x, $str);
		   fclose($x); 
		
		   $res = array("result"=>"success");
		   echo json_encode($res);   
		
	}
	
	
	//test
	function demo(){
		return md5("xx");
		
	}
	
	//test ceritficate
	//store on login
	//testCer();
	function testCer(){
			$cer  = dirname(__FILE__) .'/temp/tubtim.cer';
			preg_match('#\((.*?)\)#',xcode($cer,0),$m);
		/*
		   $ip="192.168.1.100";
		   $mac="aa:bb:cc:00:11:22";
		   $comp="TK ONE CO.,LTD"; //get data from file .cer in ( )
		   $param = $ip."".$mac."".$comp;
		  */ 
		   $ip=trim(getIP());
		   $mac=trim(getMac());
		   $comp=trim($m[1]);
		   $param = $ip."".$mac."".$comp;
		   
		   $xpatch = "";
		   $xcrypt = substr($ip.$mac,0,16).'$';
		    
		   // echo $xcrypt;
		   
		  // echo xcode($cer,1);
		    
		    /*
			$algorithm = '6';
		 	$rounds = '9898';
		 	$cryptSalt = '$' . $algorithm . '$rounds=' . $rounds . '$' . $param;
		 	//start encrypt
		   $HashedPassword = crypt($param, $cryptSalt);
		echo "XXX<br/>";
		   echo $HashedPassword;
			echo "<br/>";
			*/
		  
		     $str = trim('$6$rounds=9898$'.$xcrypt.xcode( $cer , 1));
			if (crypt($param, $str) == $str) {
				echo "match";
				/*
				if( xcrypt( $input ) != false ){
					
				}else{
					echo "license fail";
				}
				*/
			}else{
				echo "license not activate";
			}
		
	}
	
	function testLic(){
		
		
		
		$cer  = dirname(__FILE__) .'/temp/tubtim.cer';
		$line = trim(xcode($cer,2));
		//echo $line;
		echo "<br/>";
		//echo encrypt_decrypt('demo','');
		echo "<br/>";
		
		echo encrypt_decrypt('decrypt',$line);
		
		
	}
	
	//decrypt msg
	function xcrypt( $input ){
	   $output = false;
       $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, 'd89fbd30939aa522b77533e5b45ce95a', base64_decode($input), MCRYPT_MODE_CBC, 'e81d8295d0c0ea4864a897c539fa06a5');
       $output = rtrim($output, "");
       return $output;
	}
	

//??error if 2 linux lan card
function getIP(){
	$ip = $_SERVER['REMOTE_ADDR'];
	if($ip){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $ip;
	}
	return false;
}

//??error if 2 linux lan card
function getMac() {
  exec('netstat -ie', $result);
  if(is_array($result)) {
    $iface = array();
    foreach($result as $key => $line) {
      if($key > 0) {
        $tmp = str_replace(" ", "", substr($line, 0, 10));
        if($tmp <> "") {
          $macpos = strpos($line, "HWaddr");
          if($macpos !== false) {
            $iface[] = array('iface' => $tmp, 'mac' => strtolower(substr($line, $macpos+7, 17)));
          }
        }
      }
    }
    return $iface[0]['mac'];
  } else {
    return "notfound";
  }
}

	
	
?>