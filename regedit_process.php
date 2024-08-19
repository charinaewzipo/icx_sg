<?php include "dbconn.php"?>
<?php include "util.php"  ?>
<?php include "wlog.php" ?>
<?php 

	error_reporting(E_ALL);
	ini_set('display_errors',1);
	
	if(isset($_POST['action'])){
		switch( $_POST['action']){
			 
			case "uploadlicense" : uploadlicense(); break;
			
			//case "query"  : query(); break;
			
			
			
			//step1
			//case "getLicense" : getLicense(); break; //get .lic
			//case "updateLicense" : updateLicense(); break;
	
			//move from production
			//case "setLicense" : setLicense(); break;
			
			case "setLicense" : genCertificate(); break;
			
	
		}
	}
	
	function uploadlicense(){
		
		if (!empty($_FILES))
		{
			if ( $_FILES["file"]["error"] > 0)
			{
				wlog("[Error][regedit_process][upload] Error code : " . $_FILES["file"]["error"] );
				switch($_FILES["file"]["error"] ) {
					case 1 : wlog("[regedit_process][upload] Error : The uploaded file exceeds the upload_max_filesize directive in php.ini");
					break;
					case 2 : wlog("[regedit_process][upload] Error :The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form");
					break;
					case 3 : wlog("[regedit_process][upload] Error :  The uploaded file was only partially uploaded");
					break;
					case 4 : wlog("[regedit_process][upload] Error :  No file was uploaded");
					break;
					case 5 : wlog("[regedit_process][upload] Error : Missing a temporary folder");
					break;
					case 6 : wlog("[regedit_process][upload] Error : Failed to write file to disk");
					break;
					case 7 : wlog("[regedit_process][upload] Error : File upload stopped by extension");
					break;
					default : wlog("[regedit_process][upload] Error : Unknown upload error");
					break;
				}
			} else{
				wlog("[regedit_process][upload] file ok to upload ");
				$filename = basename($_FILES['file']['name']);
				$tempFile = $_FILES['file']['tmp_name'];
				move_uploaded_file($tempFile, "profiles/attach/".$filename);
				 
				// move_uploaded_file($tempFile, "profiles/attach/".$filename);
				wlog("[regedit_process][upload] license file upload success ");
				
				$tmp = readLicense();
				$data = array("ip"=>$tmp[0],"mac"=>$tmp[1],"comp"=>$tmp[2]);
				
				$res = array("result"=>"success","data"=>$data);
				echo json_encode($res);
					
		
			}//end else
		}//end if
		
		
	}
	
	//for read encrypt message from .lic
	function readLicense(){
		$readfile  = dirname(__FILE__) .'/profiles/attach/tubtim.lic';
		//readline util.php
		$str = readLine( $readfile , 0 );
		$str = base64_decode( $str );
		$tmp = explode(";", $str);
		//get parameter
		//$ip | $macaddr | $company
		// $tmp[0]."".$tmp[1]."".$tmp[2];
		return $tmp;
	}
	
	//remove function on production
	//function .lic to .cer
	//genCertificate();
	function genCertificate(){
		$readfile  = dirname(__FILE__) .'/profiles/attach/tubtim.lic';
		$writefile = dirname(__FILE__) .'/profiles/attach/tubtim.cer';
		$str = readLine( $readfile , 0 );
	
		//read file ( reald hole file )
		/*
		$file = fopen($readfile, "r");
		if ($file){
		while(!feof($file)){
		$line = fgets($file);
		// do same stuff with the $line
		$str = $line;
		//echo $str;
		}
		}else{
		//error opening the file.
		}
		fclose($file);
		*/
		//decode
		$str = base64_decode( $str );
		$tmp = explode(";", $str);
		 
		//get parameter
		//$ip | $macaddr | $company
		 
		$param = $tmp[0]."".$tmp[1]."".$tmp[2];
		 
		//encrypt parameter
		$algorithm = '6';
		$rounds = '9898';
		$cryptSalt = '$' . $algorithm . '$rounds=' . $rounds . '$' . $param;
		//start encrypt
	    $HashedPassword = crypt($param, $cryptSalt);
	   	//start write file
	    $str = ""; //clear string;
	    $x = fopen($writefile, 'w');
	    $str = "===== LICENSE(".$tmp[2].") ===== \r\n";
		// $str = $str.$HashedPassword;
   		$str = $str.substr(strrchr($HashedPassword,"$"),count($HashedPassword))."\r\n";
   		$str = $str.encrypt_decrypt('demo','')."\r\n";
   		$str = $str."===== ENF OF LICENSE ===== \r\n";
   		fwrite($x, $str);
   		fclose($x);
   		
   		wlog("write certificate success");
   		//sleep for 2 seconds waiting for write file
   		sleep(2);
   		//set license
   		setLicense();
			   				 
			   				 
	}

	//not on production
	function setLicense(){
	
		$tmp = json_decode( $_POST['data'] , true);
		$paramLicense = $tmp['lagent'].";".$tmp['lsup'].";".$tmp['lqc'].";".$tmp['lmanager'].";".$tmp['lproj'].";".$tmp['ladmin'];
		$license = encrypt_decrypt( 'encrypt' , $paramLicense );
		//echo $license;
		writelicense( $license );
	
		$res = array("result"=>"success");
		echo json_encode($res);
	
	}
	//not on production
	function writelicense( $license ){
	
		// opens a file and read some data
		$readfile  = dirname(__FILE__) .'/profiles/attach/tubtim.cer';
		 
		//read file ( reald hole file )
		$buff = "";
		$file = fopen($readfile, "r");
		if ($file){
			$count = 0;
			while(!feof($file)){
				$line = fgets($file);
				if($count==2){
					$buff = $buff.$license."\r\n";
				}else{
					$buff = $buff.$line;
				}
				$count++;
				//echo $str;
	
				if($count==10){
					echo "something wrong";
					break;
				}
	
			}
		}else{
			//error opening the file.
		}
			
		$file = fopen($readfile,"w");
		fwrite($file,$buff);
		fclose($file);
	}
	
	//encrypt
	//remove from  production
	//encrypt_decrypt( 'encrypt' , 'ABCDEF' );
	function encrypt_decrypt($action, $string) {
		$output = false;
		 
		//add unique for random but not use
		$uniqueid = uniqid();
		$string = $string.";".$uniqueid;
		//$plain_txt = "A3;S3;Q3;M3;P3;AD3";
		//$plain_txt = '2;1;0;0;0;1;'.$uniqueid;
		 
		 
		//store value md5 not md5() function for can't track encrypt algorithm in decrypt function
		//and rename decrypt function for hide the real function
		//$key = 'ht.co.tfosmitbuT';
		// $iv = md5( md5( $key )) 2 time md5 =  'e81d8295d0c0ea4864a897c539fa06a5'
		// $key = md5( $key ) 1 time md5 = 'd89fbd30939aa522b77533e5b45ce95a'
		// store md5
	
		// initialization vector
		$key = 'ht.co.tfosmitbuT';
		$iv = md5(md5($key));
		 
		//string should format
		//A3;S3;Q3;M3;P3;AD3
		//'2;1;0;0;0;1;'.$uniqueid; <== input tring ( demo license )
		//A=agent;S=supervisor;Q=qcqa;M=manager;P=projectManager;AD=admin
		 
		if($action=='demo'){
			$string='2;1;0;0;0;1;'.$uniqueid.';';
			$action = 'encrypt';
		}
		 
		if( $action == 'encrypt' ) {
			$output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'decrypt' ){
			$output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
			$output = rtrim($output, "");
		}
		return $output;
	}
	
	
	

?>