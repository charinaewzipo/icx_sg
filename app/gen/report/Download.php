<?php                                                                
header('Content-type: text/plain');                             

// What file will be named after downloading                                  
header('Content-Disposition: attachment; filename="'.$_REQUEST['filename'].'"');

// File to download                                
readfile('temp/'.$_REQUEST['filename']);                                            
?>