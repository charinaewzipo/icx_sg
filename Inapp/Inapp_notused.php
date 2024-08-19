<?php
    session_start();
    if(!isset($_SESSION["uid"])){
       header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
		$pfile = $_SESSION["pfile"];
	}
?>
 <!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>TeleSmile 2 </title>
<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">

	 <script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
	 <script type="text/javascript" src="js/app.js"></script>
	 <script>
	 $(function(){
	 	$('#app-pane').load('app_project.php');
		//initial config
		//$('[name=appid]').val()
	 	
	 });
	 </script>

</head>
<body>
<form>

<input type="hidden" name="appname" value="home">
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="text" name="uid" value="10">

		<div id="app-pane">
		
		</div>
		
</form>
</body>
</html>