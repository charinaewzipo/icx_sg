<?php 
   error_reporting(E_ALL);
ini_set('display_errors',1);

    if (!empty($_POST)){
    			echo "src :".$_POST["src"]." <br/> ";
    			echo "dst :".$_POST["dst"]." <br/> ";
    	
    	
        $server_manager[0]= "192.168.30.22"; //#IPServer manager
        $server_manager[1] = "admin"; //#username manager
        //$server_manager[2] = "amp111"; //#password manager
        $server_manager[2] = "password"; //#password manager
        $server_manager[3] = "5038"; //#port manager
        $manager_originate[0] = $_POST["src"]; //#extension_source
        $manager_originate[1] = $_POST["dst"]; //#extension_destination
        $uid = 1; //$_POST["uid"];
        
        
       function SIPshowpeer($server_manager,$peer)
        {
            $socket = fsockopen("$server_manager[0]","$server_manager[3]", $errno, $errstr, 10);
            fputs($socket, "Action: Login\r\n");
            fputs($socket, "UserName: $server_manager[1]\r\n");
            fputs($socket, "Secret: $server_manager[2]\r\n\r\n");
            fputs($socket, "Action: SIPShowPeer\r\n");
            fputs($socket, "Peer: $peer\r\n\r\n");
            fputs($socket, "Action: Logoff\r\n\r\n");

            while (!feof($socket)) {
                $wrets = fgets($socket, 100);
                if (strstr($wrets,"Callerid: " )) {
                    $callerid = substr($wrets,10);
                    break;
                }
            }
           // echo "Callerid: " . $callerid .'<br>';
            fclose($socket);
            return $callerid;
        }
        
        
       
            $callerid = SIPshowpeer($server_manager,$manager_originate[0]);
        
           // echo "Active SIPshowpeer = ".$callerid.'<br>';
            $socket = fsockopen("$server_manager[0]","$server_manager[3]", $errno, $errstr, 10);
                       // if(!$socket){
                         // echo "error can't connect to server";
                       // }
            fputs($socket, "Action: Login\r\n");
            fputs($socket, "UserName: $server_manager[1]\r\n");
            fputs($socket, "Secret: $server_manager[2]\r\n\r\n");
            fputs($socket, "Action: Originate\r\n");
            fputs($socket, "Channel: SIP/$manager_originate[0]\r\n");
            fputs($socket, "Context: from-internal\r\n");
            fputs($socket, "Exten: $manager_originate[1]\r\n");
            fputs($socket, "Priority: 1\r\n");
            fputs($socket, "CallerID: $callerid\r\n\r\n");
                        //fputs($socket, "Variable: testabc=1234\r\n\r\n");

            while (!feof($socket)) {
                $wrets = fgets($socket, 100);
                      //  wlog("originate: ".$wrets);
                                //echo $wrets."<br/>";  
                                if(strstr($wrets,"Channel: ")){

                                   // echo "channel : |".$wrets.'|<br>';
                                        $channel  = substr($wrets,9,17);
                                        //$channel = $wrets;
                                }


				                if (strstr($wrets,"Uniqueid: " )) {
				
				                    $uniqueid = substr($wrets,10);
				                   // echo "strlen Wrets: |" . strlen($wrets) .'<br>';
				                   // echo "Wrets: |" . $wrets .'<br>';
				                   // echo "Uniqueid: |" . $uniqueid .'<br>';
									  break;
				                }
            }
            fputs($socket, "Action: Logoff\r\n\r\n");
            //wlog("sys_ami".$channel."|".$uniqueid);
           // echo "Channel SIP Extension = " . $channel .'<br>';          
            fclose($socket);
            echo "start make call : ".$channel."|".$uniqueid;
  

		function ExtensionState($server_manager,$extension)
		{
		   $socket = fsockopen("$server_manager[0]","$server_manager[3]", $errno, $errstr, 10);
		    fputs($socket, "Action: Login\r\n");
            fputs($socket, "UserName: $server_manager[1]\r\n");
            fputs($socket, "Secret: $server_manager[2]\r\n\r\n");
			
            fputs($socket, "Action: ExtensionState\r\n");
			fputs($socket, "Context: from-internal\r\n");
			fputs($socket, "Exten: $extension\r\n\r\n"); 
			fputs($socket, "Action: Logoff\r\n\r\n");
			 
            while (!feof($socket)) {
                $wrets = fgets($socket, 100);
				echo $wrets."<br/>";
				/*
                if (strstr($wrets,"Status: " )) {
                    $response = substr($wrets,10);
                    break;
                }
				*/
            }
		  
           // echo "Callerid: " . $callerid .'<br>';
            fclose($socket);
            return $response;
		
		
		}
		 
		 
     
		
		
		
		
    }//end post

?>


<html>
	<head>
		<title> Telophony TEST </title>
	</head>
	<body>
	<form method="post">
		SRC : <input type="text" name="src" value="1001"> <br/>
		DST : <input type="text" name="dst" value="1002"> <br/>
		<input type="submit" value="make call"> 
	</form>	
	
	curl http://192.168.1.100:8888/hangup?ext=666
	</body>
</html>
