<?php 
		require_once("dbconn.php");
		// Session Timeout
		//Read the request time of the user
		$time = $_SERVER['REQUEST_TIME'];
		// var_dump($_SERVER);
		//Check the user's session exist or not
		if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > DURATION_TIMEOUT) {
?>
			<script type="text/javascript">
				window.location="logout.php";
			</script>
<?php 		}
		//Set the time of the user's last activity
		$_SESSION['LAST_ACTIVITY'] = $time;

		$dbconn = new dbconn;  
        $dbconn->createConn();
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"error","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
			$lv = $pfile['lv'];

			$sql = " SELECT role_name,role_lv".
			" FROM tl_role".
			" WHERE role_lv='".$lv."'";

			$result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
				$lv = "lv_".$rs["role_name"];
			}

			// switch($lv){
			// 	case "1" :	 $lv ="lv_agent = 1 "; break;
			// 	case "2" : $lv ="lv_sup = 1"; break;
			// 	case "3" : $lv ="lv_qcqa = 1"; break;
			// 	case "4" : $lv ="lv_manager = 1"; break;
			// 	case "5" : $lv ="lv_project = 1"; break;
			// 	case "6" : $lv ="lv_admin = 1"; break; 
			// }

			$sql = " SELECT module_id,module_name,path,icon,app_name".
						" FROM tl_module".
						" WHERE ".$lv." AND status = 1 ".
						" ORDER BY module_seq ";
			
			$count = 0;    
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
	//			echo  '<a href="'.$rs['path'].'" class="shortcut" data-role="'.$rs['app_name'].'" style="font-family:raleway; font-size:15px; line-height:24px; font-weight:400"><span class="'.$rs['icon'].'" style="font-size:34px;"></span><br/> '.$rs['module_name'].' </a> ';
					echo  '<a href="'.$rs['path'].'" class="shortcut" data-role="'.$rs['app_name'].'" style="font-family:raleway; font-size:15px; line-height:24px; "><i class="'.$rs['icon'].'" style="line-height:8px; "></i>'.$rs['module_name'].' </a> ';
	
			}
			
			//default module
			//echo '<a href="#" class="shortcut" data-role="logout"  style="font-family:raleway; font-size:15px;line-height:24px;"><span class="ion-ios7-locked-outline size-34" ></span><br/> Logout </a> '; 
				echo '<a href="#" class="shortcut" data-role="logout"  style="font-family:raleway; font-size:15px;line-height:24px;"><i class="icon-lock" style="line-height:8px;"></i> Logout </a> '; 
		
			
		    
		 	$dbconn->dbClose();	 
		

?>
