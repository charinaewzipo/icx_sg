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
<title> ICX </title>
<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">
<link href="css/default.css" rel="stylesheet">
<style>
/* setting pane */
#setting-menu li{
 border-top:1px solid #E2E2E2;
 border-left:1px solid #E2E2E2;
 border-bottom:1px solid #E2E2E2;
}

#setting-menu li:hover{
 background-color:#E2E2E2;
 cursor:pointer;
}
.setting-bg-white{
  background-color:#FFF;
}

.table-hover tr:hover{
  background-color:#E2E2E2;
   cursor:pointer;
}



#agent-table tbody tr.strip-onhover:hover{
    background-color:#E2E2E2;
   cursor:pointer;
}
.agent-profile-img{
   height: 28px;
    margin-bottom: 4px;
    margin-left: 2px;
    width: 28px;
  	border-radius: 50%;
}


/* not used */
.agent-header-group{
    background-color: #f5f5f5;
    background-image: -moz-linear-gradient(center top , #f6f6f6, #f3f3f4);
    background-repeat: repeat-x;
    border-bottom: 1px solid #dddddd;
    border-color: #ffffff rgba(0, 0, 0, 0.1) #dddddd;
    border-top: 1px solid #ffffff;
    color: #444444;
    padding: 5px;
    text-shadow: 0 1px #ffffff;
}

</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<!--  <script type="text/javascript" src="js/reminder.js"></script> -->
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
<script>
 $(function(){

	 

/*
	     $('.dropdown').on('show.bs.dropdown', function(e){
		    $(this).find('.dropdown-menu').first().stop(true, true).slideDown("fast", "easeInOutExpo");
		  });

		  // ADD SLIDEUP ANIMATION TO DROPDOWN //
		  $('.dropdown').on('hide.bs.dropdown', function(e){
		    $(this).find('.dropdown-menu').first().stop(true, true).slideUp("fast", "easeInOutExpo");
		  });
*/	  

	  //init page
		$('#agent-pane').load('agent-pane.php' , function(){
				$(this).fadeIn('slow');
		 });

	  	//left menu action
		   $('#nav-agent').click( function(e){
			    e.preventDefault();
				$('div[id$="-pane"]').hide();
				$('#agent-pane').show().load('agent-pane.php' , function(){
					$(this).fadeIn('slow');
				});
		   });
		   $('#nav-group').click( function(e){
			    e.preventDefault();
				$('div[id$="-pane"]').hide();
				$('#group-pane').show().load('group-pane.php' , function(){
					$(this).fadeIn('slow');
				});
		   });
		   $('#nav-team').click( function(e){
			    e.preventDefault();
				$('div[id$="-pane"]').hide();
				$('#team-pane').show().load('team-pane.php' , function(){
					$(this).fadeIn('slow');
				});
		   });
		   $('#nav-permission').click( function(e){
			    e.preventDefault();
				$('div[id$="-pane"]').hide();
				$('#permission-pane').show().load('permission-pane.php' , function(){
					$(this).fadeIn('slow');
				});
		   });
		   $('#nav-setting').click( function(e){
			   e.preventDefault();
				$('div[id$="-pane"]').hide();
				$('#setting-pane').show().load('setting-pane.php' , function(){
					$(this).fadeIn('slow');
				});
		   });
		   $('#nav-license').click( function(e){
			   e.preventDefault();
				$('div[id$="-pane"]').hide();
				$('#license-pane').show().load('license-pane.php' , function(){
					$(this).fadeIn('slow');
				});
		   });
		   

	
 })

</script>

<body style="	background-image: none; background-color:#eee;">
<form>

<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="appname" value="admin">
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>">


<div class="navbar navbar-default navbar-fixed-top navbar-header" style="z-index:100;">  
	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul class="header-profile">
				<li style="text-align:center; vertical-align:middle;padding-right:2px;"> 	
					<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
						<span id="smartpanel-detail">
								<i class="icon-fire" ></i> <span style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">ICX </span>				
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
	 
	 	<div class="pull-right" style="margin-top:-4px; margin-right:15px; "> 
			<ul class="nav navbar-nav" style="margin:0;padding:0" >
			 <!-- 
			    <li class="dropdown" style="height:50px;">
			   		 <a class="dropdown-toggle" data-toggle="dropdown" style="margin:0;padding:8px 10px; ">
							<span class="ion-ios7-chatbubble-outline size-38" style="color:#fff;cursor:pointer;"></span>
							<span id="total_followup" class="stackbadge ">0</span>
				    </a>
			    </li>
			
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
			    -->
			</ul>
	  </div> 
</div>

<div class="mainwrapper" >

	<!--  class header -->
	<div class="header" style="margin-top:50px;">
			 <div class="metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  
   <!--  end class header -->
  
		 					
  <!--  left panel  -->
   <div class="leftpanel">
    <ul  class="stack-nav" style="margin:0; padding:0;">
    <?php 
     			$lv = $_SESSION["pfile"]["lv"];
		 		if($lv == 2 || $lv==4 || $lv == 5 || $lv == 6 ){
	?>
		 	<li style="height:80px; text-align:center; margin-top:20px; cursor:pointer" id="nav-agent" >
	          		<span style="display:inline-block; color:#0087e6;  border-radius:50%; border:2px solid #aaa; margin:8px; width:55px; height:55px; "><span class="ion-ios-person-outline" style=" font-size:34px;margin-left:3px;"></span></span>
	        		<span style="display:block; color:#0087e6; position:relative; top:-5px; font-family:raleway; font-size:15px;" >User </span>
	    			 <div class="nav-circle-selected"></div>
	        </li>
        
	<?php 
		 		}
    ?>
   		
   <?php  	if( $lv==4 || $lv == 5 || $lv == 6 ){	?>
         <li style="height:80px; text-align:center; margin-top:20px; cursor:pointer" id="nav-team">
          		<span style="display:inline-block; color:#aaa;  border-radius:50%; border:2px solid #aaa; margin:8px; width:55px; height:55px; "><span  class="ion-ios-people-outline" style="font-size:34px; margin-left:3px; "></span> </span>
        		<span style="display:block; color:#aaa; position:relative; top:-5px; font-family:raleway; font-size:15px;" >Team</span>
        </li>
 
         <li style="height:80px; text-align:center; margin-top:20px; cursor:pointer" id="nav-group">
          		<span style="display:inline-block; color:#aaa;  border-radius:50%; border:2px solid #aaa; margin:8px; width:55px; height:55px; "><span  class="icon-sitemap" style="position:relative; font-size:30px; margin-left:3px; top:7px; "></span> </span>
        		<span style="display:block; color:#aaa; position:relative; top:-5px; font-family:raleway; font-size:15px;" >Group</span>
        </li>
         <li style="height:80px; text-align:center; margin-top:20px; cursor:pointer" id="nav-permission">
          		<span style="display:inline-block; color:#aaa;  border-radius:50%; border:2px solid #aaa; margin:8px; width:55px; height:55px; "><span  class="ion-ios-checkmark-outline" style="font-size:34px; margin-left:3px; "></span> </span>
        		<span style="display:block; color:#aaa; position:relative; top:-5px; font-family:raleway; font-size:15px;" >Permission</span>
        </li>
         <li style="height:80px; text-align:center; margin-top:20px; cursor:pointer" id="nav-setting">
          		<span style="display:inline-block; color:#aaa;  border-radius:50%; border:2px solid #aaa; margin:8px; width:55px; height:55px; "><span  class="ion-ios-settings" style="font-size:34px; margin-left:3px; "></span> </span>
        		<span style="display:block; color:#aaa; position:relative; top:-5px; font-family:raleway; font-size:15px;" >Settings</span>
        </li>
  
     <?php  } ?>
     <!--
           <li style="height:80px; text-align:center; margin-top:20px; cursor:pointer" id="nav-license">
          		<span style="display:inline-block; color:#aaa;  border-radius:50%; border:2px solid #aaa; margin:8px; width:55px; height:55px; "><span  class="icon-link" style="display:inline-block; position:relative; font-size:30px; margin-top:10px; margin-left:2px;"></span> </span>
        		<span style="display:block; color:#aaa; position:relative; top:-5px; font-family:raleway; font-size:15px;" >License</span>
        </li>-->
     
     
    </ul>
   </div>
   
<!--  right panel -->
<div class="rightpanel">
	 <div class="container-fluid">
		<div class="row">
				<div class="col-md-12">
			 	
			 			<div id="admin-pane" style="display:none"></div>
						<div id="agent-pane" style="display:none"></div>
						<div id="group-pane" style="display:none"></div>
						<div id="team-pane" style="display:none"></div>
						<div id="permission-pane" style="display:none"></div>						
						<div id="setting-pane"style="display:none"></div>
						<div id="license-pane" style="display:none"></div>
				
				</div>
		</div>
		</div> <!--  end container -->

	</div>
<!-- end right panel -->
   
</div> <!--  end div mainwrapper -->

<div id="profile-pane" class="content-overlay" style="display:none"></div>

</form>
</body>

</html>