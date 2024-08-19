<?php
/*
 *  NOT WORK why not ????
// your file to upload
$file = '/Users/ArnonW/WorkSpace/WorkSpace/profiles/profile_me.jpg';
header("Expires: 0");

header('Content-Description: File Transfer');

//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/octet-stream');
//header("Content-type: application/jpg");
// tell file size
header('Content-Length: '.filesize($file));
// set file name
header('Content-Disposition: attachment; filename='.basename($file));
readfile($file);
// Exit script. So that no useless data is output-ed.
exit;
*/

/* another example


header('Content-type: application/zip'); //this could be a different header
header('Content-Disposition: attachment; filename="'.$zipName.'"');

ignore_user_abort(true);

$context = stream_context_create();
$file = fopen($zipName, 'rb', FALSE, $context);
while(!feof($file))
{
    echo stream_get_contents($file, 2014);
}
fclose($file);
flush();
if (file_exists($zipName)) {
    unlink( $zipName );
}
*/
//security
//$path_parts = pathinfo($_GET['file']);
//$file_name  = $path_parts['basename'];
//$file_path  = '/mysecretpath/' . $file_name;

//right way http://www.mediadivision.com//the-right-way-to-handle-file-downloads-in-php/
        //$file = '/Users/ArnonW/WorkSpace/WorkSpace/attach/news/abc.jpg';

if(isset($_GET['p'])){
                        $file = dirname(__FILE__) .'/'.$_GET['p'];
                        //$file = dirname(__FILE__) .'/temp/tubtim.lic';
                        //$file = dirname(__FILE__) .'/logs/report.xlsx';


                  //  header('Content-Type: application/octet-stream');
                    //header("Content-type: application/vnd.ms-excel");
                    header("Content-type: text/plain");
                    header('Content-Description: File Transfer');
                    header('Content-Disposition: attachment; filename='.basename($file));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    ob_clean();
                    flush();
                    //option delete file after download
                    if(isset($_GET['o'])){
                        if($_GET['o']=="y"){

                                   if(readfile($file)){
                                                //remove this file after download
                                                //this should be option
                                                unlink($file);
                                   }

                        }
                    }

                   exit();
}
?>