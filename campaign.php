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
<title> Tubtim </title>
<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">
<link href="css/default.css" rel="stylesheet">
<style>


table tbody.hover tr:hover{
	background-color:#E2E2E2;
	cursor:pointer
}


/* left right box */
.noorder{
	list-style:none;
	margin:0;
	padding:0;
}
.noorder li{
	padding:8px 5px 5px 5px;
	margin:5px 2px 5px 2px;
	border:1px dashed #bbb;
	vertical-align:middle;
}

.noorder li:hover{
	background-color:#f2f2f2;
	cursor:pointer;
}

.back-to-mapping-pane{
	color:#999;	
}
.back-to-mapping-pane:hover{
	color:#555;	
}


/* tree */

.tree,
.tree ul {
 cursor:pointer;
 background-color:#fff;
  margin:0;
  padding:0;
  list-style:none;
}

.tree ul {
  margin-left:1em; /* indentation */
  position:relative;
}

.tree ul ul {margin-left:.5em} /* (indentation/2) */

.tree ul:before {
  content:"";
  display:block;
  width:0;
  position:absolute;
  top:0;
  bottom:0;
  left:0;
  border-left:1px solid;
}

.tree li {
  margin:0;
  padding:0 1.5em; /* indentation + .5em */
  line-height:2em; /* default list item's `line-height` */
  color:#369;
  font-weight:bold;
  position:relative;
}

.tree ul li:before {
  content:"";
  display:block;
  width:10px; /* same with indentation */
  height:0;
  border-top:1px solid;
  margin-top:-1px; /* border top width */
  position:absolute;
  top:1em; /* (line-height/2) */
  left:0;
}

.tree ul li:last-child:before {
  background:white; /* same with body background */
  height:auto;
  top:1em; /* (line-height/2) */
  bottom:0;
}

</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<!-- <script type="text/javascript" src="js/reminder.js"></script> -->
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>

<script type="text/javascript" src="js/plugin/defiant.js"></script>
<script type="text/javascript" src="js/plugin/json.search.js"></script>
<script type="text/javascript" src="js/plugin/json.toXML.js"></script>
<script type="text/javascript" src="js/plugin/node.select.js"></script>
<script type="text/javascript" src="js/plugin/node.serialize.js"></script>
<script type="text/javascript" src="js/plugin/node.toJSON.js"></script>
<script>
 $(function(){

	  //init page
		$('#campaign-pane').load('campaign-pane.php' , function(){
				$(this).fadeIn('slow');
		 });
	
 })

</script>

<body>
<form>
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="appname" value="campaign" >
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="remineme"  value="<?php echo $pfile['remindMe'];  ?>">
<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>"> <!-- login key -->
<input type="hidden" name="cmpid">
<input type="hidden" name="cmpuniqueid">


<div class="navbar navbar-default navbar-fixed-top navbar-header" style="z-index:100;">  
	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul class="header-profile">
				<li style="text-align:center; vertical-align:middle;padding-right:2px;"> 	
					<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
						<span id="smartpanel-detail">
							<i class="icon-fire" ></i> <span style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">Tubtim </span>				
						</span>
					</span>
		 		</li>
				<li >
				<span style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;"> 
					<span id="show-name" class="header-user-profile">Ext <?php echo  $pfile['uext']; ?></span>
					<span id="show-passions"class="header-user-detail"> Session ID : <?php echo  $pfile['tokenid']; ?> </span>
			 	</span>
				</li>
			</ul>
	</div>
	 <div class="stack-date pull-right"></div>
	<div class="navbar-inner pull-right" >
		<span class="ion-ios-arrow-down  dropdown-toggle profile-arrow" data-toggle="dropdown"></span>
		<ul class="dropdown-menu pull-right">
          <li class="text-center" style="padding:10px 10px 20px 10px;">
          		<img src="<?php echo $pfile['uimg']; ?>" id="profile-dd-img" class="avatar-title"> 
          </li>
          <li class="divider"></li>
          <li ><a href="#" id="loadprofile" ><span class="ion-ios-contact-outline size-21"></span> &nbsp; My profile</a></li>
          <!-- <li><a href="#" id="loadreminder"><span class="ion-ios-alarm-outline size-21"></span> &nbsp; Reminder </a></li> -->
          <li  class="divider"></li>
          <li ><a href="logout.php"> <span class="ion-ios-locked-outline size-21"></span> &nbsp; Log out</a></li>
        </ul>
	</div>

	<div class=" pull-right" style=" text-align:right;color:#fff; margin-top:3px; margin-right:4px;">
	 	<span id="show-name" class="header-user-profile"><?php echo  $pfile['uname']; ?></span>
		<span id="show-passion"class="header-user-detail"><?php echo  $pfile['team']; ?></span>
	 </div>
	 <!-- 
	 	<div class="pull-right" style="margin-top:-4px; margin-right:15px; "> 
			<ul class="nav navbar-nav" style="margin:0;padding:0" >
				<li class="dropdown " style="height:50px;" id="reminder">
				<a class="dropdown-toggle " data-toggle="dropdown" style="padding:8px 8px; ">
					    <span id="shake" class="ion-ios-alarm-outline size-38 shake" style="color:#fff;cursor:pointer;"></span>
						<span class="stackbadge total_reminder"></span>
			    </a>
			    <ul class="dropdown-menu wrapdd">
			    	<li>
			    	   <div style='text-align:center; color:#666; padding:5px; font-family:roboto; font-weight: 500;  border-bottom:1px dashed #ccc; margin:5px 8px;'  > 
			    	   				<span id="reminder_count" style="cursor:pointer" class="alink" data-open="open-reminder"></span>
			    	   </div>
				    	    <div id="slimreminder" class="" >
			  			  </div>
			    	</li>
			    </ul>
			    </li>
			</ul>
	  </div> 
	  -->
</div>

	<div class="header" style="margin-top:50px;">
			 <div class="metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  

	<div style="padding:0 20px;">
			<div id="campaign-pane" style="display:none"></div>
	</div>
	
<div id="new-campaign-pane" class="content-overlay" style="display:none"></div>
<div id="profile-pane" class="content-overlay" style="display:none"></div>
<div id="reminder-pane" class="content-overlay" style="display:none"></div>
<div  id="reminder-popup" class="ns-box shadow" style="display:none"></div>

</form>
</body>
</html>