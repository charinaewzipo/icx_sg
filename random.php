
<html>
<head>
  <title> Test Random</title>
</head>

<body>
<form action="random.php" method="post">

  Total List : <input type="text" name="list" value="55"> <br/>
  Total agent : <input type="text" name="agent" value="7">
 <input type="submit" value=" test "> 


<?php 

 	
 	
 	$list = $_POST['list'];
 	$agent = $_POST['agent'];
 	
 	$arr_agent = array();
 	$size = intval( $agent );
 	//test create agent id
 	for($i=1;$i< $size ;$i++){
 		array_push($arr_agent ,"a".$i);	
 	
 	}
 	
 	//echo var_dump( $arr_agent);
 	
 	$list_per_agent = floor($list / $agent);
 	$list_flag = ($list%$agent);
 	 
 	echo "<br/>";
 	echo "total list : ".$list ;
 	echo "<br/>";
 	echo "total agent : ".$agent;
 	echo "<br/>";
 	echo "each agent get ".$list_per_agent;
 	echo "<br/>";
 	echo "list flag is ".$list_flag;
 	echo "<br/>";
 	
 	//step1 check is flag
 	if($list_flag!=0){
 		
 		$winner = array();
 		$tmp_agent = $arr_agent;
 		
 		for($i=0;$i<$list_flag;$i++){
 			 $win = array_rand($tmp_agent);
 			 array_push($winner,$win);
 			 unset($tmp_agent[$win]);
 		}
 		//get winner
 	
 		 $size = count($winner);
 		for( $i=0;$i<$size;$i++){
 		 	echo "winner agent : ".$arr_agent[$winner[$i]];
 		 	echo "<br/>";
 		}
 			
 	}
 	
 
 	 $search_array = array(7=> 'helloworld', 8=> 0 ,9=>0);
 	 $search_array[7] = "7893333";
 	 
 	 for( $i=0; $i<3; $i++){
 	 	 $search_array[$i] = 123;
 	 }
 	$size= count( $search_array );
 	  for( $i=0; $i<$size; $i++){
 				echo "array at ".$i." return value : ".$search_array[$i]."<br/>";
 	  }
 	echo "<br/>";
 	echo "count : ".count( $search_array);
 		// echo array_keys($search_array, 7);
 	 	echo "<br/>";
 	 	
 	 	echo ++$search_array[0];
 	 		echo "<br/>";
 		 //echo array_search(7, $search_array);
 	
 	foreach ($search_array as $k => $v) {
 		 //echo $k;

 		if(isset( $search_array[$k] )){
 			echo "fond";
 		}else{
 			echo "notfound";
 		}
 		
 	
    //echo "\$a[$k] => $v.\n";
	}
 	


 	
 
 	
 	
 	
 	


?>

</form>
</body>
</html>