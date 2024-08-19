<?php
function getLicense(){
	return  100; 
}

//test
function isActivateLicense(){
		   $cer  = dirname(__FILE__) .'/temp/tubtim.cer';
			if(file_exists($cer)){
				
			}else{
				  return "License Not Activate"; 
			}
			echo "test";
		   $ip="192.168.1.100";
		   $mac="aa:bb:cc:00:11:22";
		   $comp="TK ONE CO.,LTD"; //get data from file .cer in ( )
		   $param = $ip."".$mac."".$comp;
		   
		
		    $xpatch = "";
		    $xcrypt = substr($ip.$mac,0,16).'$';
		    $str = trim('$6$rounds=9898$'.$xcrypt.xcode( $cer , 1));
			if (crypt($param, $str) == $str) {
				echo "match";
				if( xcrypt( $input ) != false ){
					
				}else{
					echo "license fail";
				}
				
			}else{
					echo "license not activate";
			}
		
	}
	


?>