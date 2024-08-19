<?php
    session_start();
  echo $_SESSION['io'];
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


.embed-simple {
    background: linear-gradient(to top, rgba(23, 23, 23, 0) 0px, rgba(23, 23, 23, 0.7) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);

 
    left: 0;
   

  

    width: 100%;
    z-index: 2;
}

</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

<script>


 $(function(){

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

     //setCookie();
    // console.log( getCookie() );
     $('#x').text( getCookie()  );
  
  	$('#login').click( function(){
			window.location = "index.php";
  	 });

	
 })

</script>

<body>
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">


<div class="navbar embed-simple " style="z-index:100">  

	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul class="header-profile">
				<li style="text-align:center; vertical-align:middle;padding-right:2px;"> 	
					<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
						<span id="smartpanel-detail">
								<span class="ion-ios7-telephone-outline size-24" ></span>TeleSmile						
						</span>
					</span>
		 		</li>
				<li >
				<span style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;"> 
					<span id="show-name" class="header-user-profile">Ext <?php echo  $pfile['uext']; ?></span>
					<span id="show-passions"class="header-user-detail">  <?php echo  $pfile['tokenid']; ?> Phone Ready | Phone is not ready </span>
			 	</span>
				</li>
			</ul>
	</div>
	
	 <div class="stack-date pull-right"></div>
	<div class="navbar-inner pull-right" >
		<span class="ion-ios7-arrow-down  dropdown-toggle profile-arrow" data-toggle="dropdown"></span>
		<ul class="dropdown-menu pull-right">
          <li class="text-center" style="padding:10px 10px 20px 10px;">
          		<img src="<?php echo $pfile['uimg']; ?>" id="abc" class="avatar-title"> 
          </li>
          <li class="divider"></li>
          <li ><a href="#" id="loadprofile" ><span class="ion-ios7-contact-outline size-21"></span> &nbsp; My profile</a></li>
          <li><a href="#" id="loadreminder"><span class="ion-ios7-gear-outline size-21"></span> &nbsp; Reminder </a></li>
          <li  class="divider"></li>
          <li ><a href="logout.php"> <span class="ion-ios7-locked-outline size-21"></span> &nbsp; Log out</a></li>
        </ul>
	</div>

	<div class=" pull-right" style=" text-align:right;color:#fff; margin-top:3px; margin-right:4px;">
	 	<span id="show-name" class="header-user-profile"><?php echo  $pfile['uname']; ?></span>
		<span id="show-passion"class="header-user-detail"><?php echo  $pfile['team']; ?></span>
	 </div>
	 
	 	<div class="pull-right" style="margin-top:-4px; margin-right:15px; "> 
			<ul class="nav navbar-nav" style="margin:0;padding:0" >
			  <!-- 
			    <li class="dropdown" style="height:50px;">
			   		 <a class="dropdown-toggle" data-toggle="dropdown" style="margin:0;padding:8px 10px; ">
							<span class="ion-ios7-compose-outline size-38" style="color:#fff;cursor:pointer;"></span>
							<span id="total_followup" class="stackbadge ">0</span>
				    </a>
			    </li>
			   -->
				<li class="dropdown" style="height:50px;display:none" id="reminder">
				<a class="dropdown-toggle " data-toggle="dropdown" style="padding:8px 8px; ">
					    <span id="shake" class="ion-ios7-alarm-outline size-38 shake" style="color:#fff;cursor:pointer;"></span>
						<span class="stackbadge total_reminder" >0</span>
			    </a>
			    <ul class="dropdown-menu wrapdd">
			    	<li>
			    	   <div id="reminder_count" style='text-align:center; color:#666; padding:5px; font-family:lato; border-bottom:1px dashed #E2E2E2;'  > 
			    	   </div>
				    	    <div id="slimreminder" class="" >
					  		<!-- 	<ul class="dd" id="reminder-list"></ul> -->
			  			  </div>
			    	</li>
			    </ul>
			    </li>
			</ul>
	  </div> 
	
	
</div>


<table style="width:100%; top:0px; position:relative;">
	<tr>
		<td style="text-align:center;vertical-align:middle"> <div class="ion-ios7-thunderstorm-outline" style="z-index:-1; font-size:220px; color:#999; position:relative; top:100px;"></div> </td>
	</tr>
	<tr>
		<td style="text-align:center;vertical-align:middle"><h2 style="color:#999">Your session has expired</h2> </td>
	</tr>
		<tr>
		<td style="text-align:center;vertical-align:middle;">
		<div style="position:relative; top:20px;">
		<input id="login" class="button-submit" type="button" value=" Login " name="login" style="cursor:pointer; font-size:15px; width:280px; height:40px; ">
		</div>
	</tr>
</table>
<div id="x"></div>

</body>

</html>