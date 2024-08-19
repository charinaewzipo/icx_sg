<?php include "dbconf.php"?>
<?php

  $path = dirname(__FILE__) .'/temp/tmp_table.sql';
  echo "start<br/>"; 
  $cmd = 'mysql -u '.$db_username.' -p'.$db_password.' -h '.$db_server_ip.' '.$db_name.'  < '.$path;
  $output = shell_exec($cmd);
  echo $cmd;

  
?>