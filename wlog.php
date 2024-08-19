<?php 
        //write log file
        //configuration 
        
 	    date_default_timezone_set('Asia/Bangkok');
		function wlog( $str ){
		   
		       
				 //echo get_current_user_id();
		       $path = dirname(__FILE__) .'/logs/log';
			   $today = date("Y-m-d");
			   $path = $path."_".$today.".txt"; 
			
			   //file name is log_pmsheet_2011-12-27.txt
			   //log detail
			   //2011-02-15 19:01:55 StandardContext[/balancer] 
			  // $currentDateTime  =  date("Y-m-d H:i:s:U");
			   $currentDateTime  =  date("Y-m-d H:i:s");
			   $fh = fopen($path, 'a+') or die("can't open file");
			   fwrite($fh, $currentDateTime." ".$str."\r\n");   
			   fclose($fh); 
			    
		}
		
		
	
		
		class write{
			private $fname;
			public function __construct($fname){
				$this->fname = $fname;
			}
			public function xset($fname){
				$this->fname = $fname;
			}
			public function xget(){
				return  $this->fname;
			}
			public function xwrite($str){
				   $filename = $this->fname;
				   echo $filename;
				   $path = dirname(__FILE__) .'/logs/'.$filename.'.txt';
				   $x = fopen($path, 'a');
				   fwrite($x, $str);
				   fclose($x); 
			}
			
		}
		
/*
		$abc = new write('xxx');
		$abc->xwrite("test1\r\n");
		$abc->xwrite("test2\r\n");
		$abc->xwrite("test3\r\n");
		
		$abc->xset('xxx');
		$abc->xwrite("test4\r\n");
		$abc->xwrite("test5\r\n");
		$abc->xwrite("test6\r\n");
	*/	
		/*load data infile*/
		/*
		$sql = "LOAD DATA LOCAL INFILE ".$filename." INTO TABLE test_load ".
					"FIELDS TERMINATED BY ',' ( dat1 , dat2 ); ";
		*/
		
		
	
		/*
		$abc->xset('abc');
	$abc->xwrite("test1\r\n");
		$abc->xwrite('test2\r\n');
				$abc->xwrite('test3\r\n');
				*/
		//echo $abc->xget();
		
		/*
			$abc = new write();
		$abc->xset('xyz');
	$abc->xwrite("test1\r\n");
		$abc->xwrite('test2\r\n');
				$abc->xwrite('test3\r\n');
		echo $abc->xget();
		
		
		$abc = new write();
		$abc->xset('abc');
	$abc->xwrite("test1\r\n");
		$abc->xwrite('test2\r\n');
				$abc->xwrite('test3\r\n');
		echo $abc->xget();
	
			/*
		
		$filename = 'abc';
		  $path = dirname(__FILE__) .'/logs/'+$filename+'.txt';
		  $x = fopen($path, 'w');
		     $str = "test2";
		    fwrite($x, $str."\r\n");
		       fclose($x); 
		/*
		   $x = fopen($path, 'w');
		   $str = "test2";
		    fwrite($x, $str."\r\n");
		       $str = "test3";
		       	    fclose($x); 
		    fwrite($x, $str."\r\n");
		       $str = "test4";
		    fwrite($x, $str."\r\n");
	*/
		   
	
	
		   
		
	

?>
