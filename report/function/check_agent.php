<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

$SQL_agent = "select * from t_agent where agent_id = '$agent_id' ";
$result_agent = mysql_query($SQL_agent,$Conn) or die ("ไม่สามารถติดต่อฐานข้อมูลได้");
 	while($row_agent = mysql_fetch_array($result_agent))
{    
	$agent_name = $row_agent["first_name"].' '.$row_agent["last_name"];
	$level_code = $row_agent["level_id"];
}

?>
                  <input type="hidden" name="campaign_id" value="<?php print $campaign_id ;?>" />
                  <input type="hidden" name="callist_id" value="<?php print $callist_id ;?>" />
                  <input type="hidden" name="agent_id" value="<?php print $agent_id ;?>" />
                  <input type="hidden" name="import_id" value="<?php print $import_id ;?>" />
                  
</body>
</html>