<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);


		echo "xtest";
			$file_path = "/opt/Tubtim/temp/54aae21c0debf.csv";
			
			if( !file_exists($file_path)){
				echo( "[callList_process][csvReader] file  not found");
			}else{
				echo( "[callList_process][csvReader] file exist");
			}
			
			$file = fopen($file_path,"r") or die("can't open file");
			echo( $file );
			$line = str_to_utf8(fgets($file));
				echo("read line : ".$line);
			
			
	function str_to_utf8 ($str) {
		    if (mb_detect_encoding($str, 'UTF-8', true) === false) {
		  	  $str = utf8_encode($str);
		    }
		    return $str;
	}
	
	
?>