<?php
    session_start();
    $_SESSION['io'] = "php_session";
    /*
    if(!isset($_SESSION["uid"])){
    //   header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
		$pfile = $_SESSION["pfile"];
	}
	*/
 ?>
 <!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title> Tele Smile </title>
<link href="css/ionicons.min.css" rel="stylesheet">

<link href="css/default.css" rel="stylesheet">

<style>
.button-submit {
    background-color: #4d90fe;
    background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed);
    border: 1px solid #3079ed;
    color: #ffffff;
    text-shadow: 0 1px rgba(0, 0, 0, 0.1);
}
</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
 
<script>


 $(function(){



	/*
	 var COOKIE_NAME = 'test_cookie';
     var options = { path: '/', expires: 10 };

     function setCookie(){
         $.cookie(COOKIE_NAME, 'test', options);
         return false;
     }

     function getCookie(){
        // alert($.cookie(COOKIE_NAME));
         return $.cookie(COOKIE_NAME);
     }

     function deleteCookie(){
         $.cookie(COOKIE_NAME, null, options);
         return false;
     }

     setCookie();
     //console.log( getCookie() );
    */
  	$('#login').click( function(){
			window.location = "index.php";
  	 });


    $('body').bind('keypress', function(e){
    	   if ( e.keyCode == 13 ) {
    			window.location = "index.php";
    	   }
    });
	 

	
 })

</script>

<body>
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">

<table style="width:100%; top:0px; position:relative;">
	<tr>
		<td style="text-align:center;vertical-align:middle"> <div class="ion-ios-thunderstorm-outline" style="z-index:-1; font-size:220px; color:#999; position:relative; top:100px;"></div> </td>
	</tr>
	<tr>
		<td style="text-align:center;vertical-align:middle"><h2 style="color:#999">Your session has expired</h2> </td>
	</tr>
		<tr>
		<td style="text-align:center;vertical-align:middle;">
		<div style="position:relative; top:20px;">
		<button class="button-submit"  id="login"  name="login" style="cursor:pointer; font-size:15px; width:280px; height:40px; " > Login </button>
		</div>
	</tr>
</table>


</body>

</html>