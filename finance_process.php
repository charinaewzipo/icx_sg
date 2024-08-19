<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php


   	if(isset($_POST['action'])){ 
	 
         switch( $_POST['action']){
            	case "cal" : cal(); break; 
		 }
	}
	
	function cal(){
		$tmp = json_decode( $_POST['data'] , true); 

	     
	     $tmp['loan_interest_mode'];
	     
	      $tmp['loan_amount'];
	    
	      $tmp['pay_monthly'];
	      $tmp['loan_interest_rate'];
	      
	      $size = parseInt($tmp['loan_month']);
	       
	      $count = 0;
	      for ($i = 0; $i < $size; $i++) {
	      	
	      	 	$tmp1[$count]= array(
			  		"seq"  => nullToEmpty($i),
	      	 	);
				$count++;  
	      }
	      
	  
  			$data = array("result"=>"success", "cal"=>$tmp1);
			echo json_encode( $data ); 
					
	}
	
	