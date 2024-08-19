<?php
    session_start();
    if(!isset($_SESSION["uid"])){
       header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
		$pfile = $_SESSION["pfile"];
		$lvl = $_SESSION["pfile"]["lv"];
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
 .app-inbox{
 		list-style:none;
 		cursor:pointer;
 		margin:0;
 		padding:0;
 }
 
 .app-inbox li{
 	padding:1px10px;
 	margin:4px 25px;
 	border-bottom: 1px solid #ddd;
 		color: #555;
 }
 
  .app-inbox li:hover{
  	color: #888;
 }

.table-line tr:hover{
	background-color:#E2E2E2;
	cursor:pointer;
}

#inbox-caption:first-letter {
    text-transform: uppercase;
}

.remark-comment{
	list-style:none; 
	margin:0;
	padding:0;
}
 .remark-comment  li{
	background:#f1f1f1; 
	padding: 5px 15px 8px 0px;
	margin-bottom: 8px;
	border:1px dashed #E2E2E2;
}

.remark-title{
	vertical-align:top;
	display:table-cell;
	padding:2px;
}
.remark-comment-postbox{
	 display:table-cell;
	 padding: 6px;
}
	
.remark-comment-postbox-agent{
	display:inline-block;
	color:#555; 
	font-size:20px;
	 font-size:16px; 
}
.remark-comment-postbox-timestamp{
	display:inline-block;
	color:#888; 
	font-style:italic; 
	font-size: 14px;
	text-indent:12px;
}
.remark-comment-postbox-detail{
	 color:#777; 
	 font-size:14px; 
	width:100%;
}

.remark-avatar{
 	border-radius: 50%;
	padding:2px;
	width:50px;
	height:50px;
	margin-top:3px;
	margin-left:5px;
	position:relative;
	background:#fff;
	 box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
}


/* remark dropdown */
/* news dropdown */
.remark-dropdown-wrap{
	display:none;
	position:absolute;
	width:110px;
	left:-70px;
	border:1px solid #E2E2E2; 
	background-color:#F2F2F2;
	box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3), 0 3px 8px rgba(0, 0, 0, 0.2);
	padding:10px;

}

.remark-dropdown-wrap.active {
	display:block;
}
/*
.remark-dropdown-wrap > div:first-child {
	width: 0; 
	height: 0; 
	border-left: 6px solid transparent;
	border-right: 6px solid transparent;
	border-bottom: 6px solid #E2E2E2; 
	top:0px; 
	position:relative; 
	left:-2px;
}
*/
.remark-dropdown{
	list-style:none; 
	border:1px solid #E2E2E2; 
	margin:0; 
	padding:0; 
	position:absolute;
	left: -70px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3), 0 3px 8px rgba(0, 0, 0, 0.2);
}

.remark-dropdown li{
	padding:5px 10px; 
	text-align:left; 
	vertical-align:middle;
	width:110px;
	color:#000;
}

.edit_remark:hover , .remove_remark:hover{
	background-color: #F2F2F2;
	color: #e51400;
}
.remark-dropdown li:last-child{
	border-bottom:0px solid #E2E2E2; 
}


.tbl-prc-price {
    background-color: #303030;
    border-radius: 50%;
    color: #fff;
    display: inline-block;
    font-family: Raleway,Arial,sans-serif;
    font-size: 15px;
    height: 90px;
    line-height: 18px;
 	margin:5px;
    padding: 5px;
    width: 90px;
    
}

   
</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/jquery.timeago.js"></script>
<script type="text/javascript" src="js/reminder.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="js/jquery.browser.js"></script>

<script type="text/javascript" src="js/ticket.js"></script>
<script>
 $(function(){

	 //global function
	$(document).click( function(){
		 $('.remark-dropdown-wrap.active').removeClass('active');
	});
		
	
	 //initial setup
	 var lv = parseInt($('[name=lvl]').val());
	 //test only agent lv
	 switch(lv){
	 	case 1 : 	$('.qc').hide(); break;
		default : $('.agent').hide();
	 }


	 $('[name=checkallbox]').click( function(){
		
		 if( $(this).is(':checked') ){
				 console.log("check all box : checked ");
			}else{
				 console.log("check all box : not check");
		  }
		 /*
		 jQuery(':checkbox:not(:checked)').attr('checked', 'checked');
		 jQuery(':checkbox:checked').removeAttr('checked');
		 */
	});
	 // end 

	 	$('#test').click( function(e){
		 		e.preventDefault();

		 		$('#inbox-main-pane').hide();
				$('#inbox-detail-pane').show();

	
				
		        $('#ex-app').text('').load('Inapp/app_project.php');
		        
		 		var pane = $('#inbox-detail-pane');
		 		pane.removeClass('fadeInLeft');
				  setTimeout(function(){ 
					  pane.addClass('fadeInLeft');
				  }, 200);

		 });

		 $('#test-openapp').click( function(e){
				e.preventDefault(); 
		
				window.open("http://localhost:8088/smile/Inapp/app_project1.php");
		});

	

		//left navigate
		$('#inbox-new').click( function(e){
			e.preventDefault();
			$.ticket.load('inbox-new');
		});

		$('#inbox-submit').click( function(e){
			e.preventDefault();
			$.ticket.load('inbox-submit');
		});

		$('#inbox-inbox').click( function(e){
			e.preventDefault();
			$.ticket.load('inbox-inbox');
		});

		$('#inbox-inprogress').click( function(e){
			e.preventDefault();
			$.ticket.load('inbox-inprogress');
		});
		
    	$('#inbox-reconfirm').click( function(e){
    		e.preventDefault();
    		$.ticket.load('inbox-reconfirm');
		});

    	$('#inbox-approved').click( function(e){
    		e.preventDefault();
    		$.ticket.load('inbox-approved');
		});

     	$('#inbox-reject').click( function(e){
    		e.preventDefault();
    		$.ticket.load('inbox-reject');
		});

    	$('#inbox-trash').click( function(e){
    		e.preventDefault();
    		$.ticket.load('inbox-trash');
		});
		//end left navigate


		$('.save_remark').click( function(e){
			e.preventDefault();
			$.ticket.remark_save();
			
		});


	  $('#ticket_tracking').click( function(e){
			e.preventDefault();

			$('#inbox-main-pane').hide();
			$('#inbox-detail-pane').hide();

			$('#tracking-pane').load('ticket_tracking.php');
			
			
	  });

	  $('#export_yesfile').click( function(e){
			e.preventDefault();

			$('#inbox-main-pane').hide();
			$('#inbox-detail-pane').hide();

			$('#tracking-pane').load('ticket_export.php');
		});
    	//autoResize('exappabc');
 })
 /*
 function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
*/
</script>

<body>
<form>

<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="appname" value="app">
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>"> <!--  session -->
<input type="hidden" name="lvl"  value="<?php echo $lvl;  ?>"> <!--  agent level -->
<input type="hidden" name="tid"> <!--  ticket id -->
<input type="hidden" name="appid"> <!--  app id -->
<input type="hidden" name="cmpid"> <!--  campaign id --> 
<input type="hidden" name="curnav"> <!--  current  left nav -->



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
					<span id="show-passions"class="header-user-detail">  <?php echo  $pfile['tokenid']; ?> Phone Ready | Phone is not ready </span>
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
          <li><a href="#" id="loadreminder"><span class="ion-ios-alarm-outline size-21"></span> &nbsp; Reminder </a></li>
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
					  		<!-- 	<ul class="dd" id="reminder-list"></ul> -->
			  			  </div>
			    	</li>
			    </ul>
			    </li>
			</ul>
	  </div> 
</div>


	<!--  class header -->
	<div class="header" style="margin-top:50px;">
			 <div class="bg-grayLighter metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  
   <!--  end class header -->
   
<div style="margin:0px 20px 0px 20px;">
    
    
  	<div style="float:left; display:inline-block">
		<h2 class="page-title" style="display:inline-block;font-family:raleway; color:#666666;">  Application  </h2>
		<div class="stack-subtitle" style="color:#777777;position:relative; top:-10px; text-indent:2px;"> Hello.</div>
	</div>
	
	 <button class="btn btn-default" id="test-openapp">  Test New App </button>
	 
	<button class="tbl-prc-price pull-right" id="ticket_tracking"> <span class="ion-ios-pulse" style="font-size:22px; line-height:12px; font-weight:800 "></span><br/>Voice Search </button>
	<button class="tbl-prc-price pull-right" id="ticket_tracking"> <span class="ion-android-search" style="font-size:22px; line-height:12px; "></span><br/>App Tracking </button>
	<button class="tbl-prc-price  pull-right" id="export_yesfile"> <span class="ion-document" style="font-size:26px; line-height:10px;"></span><br/>Export Yes File </button>
	
	
 <div style="clear:both"></div>
<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px ; padding:0px; margin:10px 0"> 


<!-- 
  	  <h2 style="display:inline-block"> Application  </h2>
       <div style="display:inline-block;float:right;text-align:center; margin:10px 10px; border:1px dashed #000; padding:10px; width:150px; font-size:18px; font-family:lato"><span id="totalidea"> 0 </span><br/> Idea  </div>
       <div style="display:inline-block;float:right;text-align:center; margin:10px 10px; border:1px dashed #000; padding:10px; width:150px; font-size:18px; font-family:lato"><span id="totalchreq"> 0 </span><br/> Change Request </div>
      <div style="display:inline-block;float:right;text-align:center; margin:10px 10px; border:1px dashed #000; padding:10px; width:150px; font-size:18px; font-family:lato"> <span id="totalreq"> 0 </span><br/>  Request </div>
      <div style="display:inline-block;float:right;text-align:center; margin:10px 10px; border:1px dashed #000; padding:10px; width:150px; font-size:18px; font-family:lato"> <span id="totalbug"> 0 </span><br/> Bug </div>
  <div style="clear:both"></div>
     -->
    
    <div style="width:100%; " >
    
    	<div id="tracking-pane">
    	
    	</div>
    
    	<!-- start left  -->
    	<div class="pull-left" style="width:22%;">
    		 	<select name="ticket_campaign"> 
    		 	</select>
    	
    	 	<h4 style="font-weight:300; color:#666; font-family:raleway"> Application  </h4>
    	
    		 <ul class="app-inbox">
    		 	<li id="inbox-new"class="">New <span class="label label-warning pull-right" id="total-new"></span></li>
    		 	<li id="inbox-submit" class="agent">Submit <span class="label label-warning pull-right" id="total-submit"></span></li>
    		 	<li id="inbox-inbox" class="qc">Inbox <span class="label label-warning pull-right" id="total-inbox"></span></li>
    		 	<li id="inbox-inprogress" class="agent">Inprogress <span class="label label-warning pull-right" id="total-inprogress"></span></li>
    		 	<li id="inbox-reconfirm" class="" >Reconfirm <span class="label label-warning pull-right" id="total-reconfirm"></span></li>
    		 	 <li id="inbox-approved" class=""> Approved <span class="label label-warning pull-right" id="total-approved"></span></li>
    		 	 <li id="inbox-reject" class="">Reject <span class="label label-danger pull-right" id="total-reject"></span></li>
    		 	<li id="inbox-trash" class=""> Trash <span class="label label-warning pull-right" id="total-trash"></span></li> 
    		 </ul>
    		 <!-- 
    		  	<h5> Folder  </h5>
    			 <ul id="app-inbox">
    		 			<li> <span class="ion-ios7-circle-filled" style="color:blue"></span> New</li>
    		 	</ul>
    		  -->
    	</div>
    	<!--  end left  -->
    	<!-- start right -->
    	<div class="pull-right" style="width:78%;border:1px solid #e7eaec; background-color:#fff;">
	    				<div class="inbox-header" style="padding:0 20px">
	    						<h2 style="font-family:raleway; color:#666666;">&nbsp;<span style="display:inline-block" id="inbox-caption"></span></h2>
	    						
	    					
	    						<button class="btn btn-default ticket_nav-back btn-action" style="border-top-left-radius:3px; border-radius:3px;" ><span class="ion-ios7-arrow-thin-left" style="font-size:14px;"></span> Back  </button>
	    						
	    						<button class="btn btn-default ticket_refresh btn-action"  style="border-radius:3px;"><span class="ion-ios7-loop" style="font-size:14px;"></span> Refresh </button>
	    						<button class="btn btn-default ticket_takeowner btn-action"  style="border-radius:3px;"><span class="ion-ios7-heart-outline" style="font-size:14px;"></span> Take Owner </button>
	    				 		<button class="btn btn-default ticket_submit btn-action"  style="border-radius:3px;"><span class="ion-ios7-redo-outline" style="font-size:14px;"></span> Submit </button>
	    				 		<button class="btn btn-default ticket_reconf btn-action"  style="border-radius:3px;"><span class="ion-ios7-information-outline" style="font-size:18px; line-height:16px; "></span> ReConfirm </button>
	    				 		<button class="btn btn-default ticket_approved btn-action"  style="border-radius:3px;"><span class="ion-ios7-checkmark-empty" style="font-size:18px; line-height:16px; "></span> Approved </button>
	    				 		<button class="btn btn-default ticket_reject btn-action"  style="border-radius:3px;"><span class="ion-ios7-close-empty" style="font-size:18px; line-height:16px; "></span> Reject </button>
	    				 		<button class="btn btn-default ticket_transfer btn-action"  style="border-radius:3px;"><span class="ion-ios7-paperplane-outline" style="font-size:18px; line-height:16px; "></span> Transfer To </button>
	    				 
	    				 		<button class="btn btn-default btn-action"  style="border-radius:3px;" id="test"><span class="ion-android-clock" style="font-size:14px;"></span> Ticket History  </button>
	    						<button class="btn btn-default btn-action"  style="border-radius:3px;"><span class="ion-ios7-trash-outline" style="font-size:14px;"></span>  </button>
	    						
	    						<!-- 
	    						<div class="btn-group pull-right">
	    							<button class="btn btn-default" style="border-top-left-radius:3px; border-bottom-left-radius:3px;"><span class="ion-ios7-arrow-thin-left" style="font-size:14px;"></span> Back  </button>
	    							<button class="btn btn-default" style="border-top-right-radius:3px; border-bottom-right-radius:3px;"><span class="ion-ios7-arrow-thin-right" style="font-size:14px;"></span>  </button>
	    						</div>
	    						 -->
	    						<br/>
	    						 
	    						  <!--   	<input type="checkbox"> Auto take owner when I read msg  --> 
	    				</div>
	    				
    		<!--  ticket app inbox -->
	    	<div id="inbox-main-pane" style="margin:20px 20px; border-top:0px solid #666; min-height:250px;">
	    			 TIP : you can press alt key while click on row the checkbox infront of row will checked.Guess that!! double click on row to see detail. <br/>
	    			
	    	 		<!-- Simplify : คุณสามารถ กด ctrl หรือ alt หรือ command(apple) key แล้วคลิกที่ record  เพื่อจะทำการ check หรือ uncheckbox ได้ทันที   --> 
				    	<table class="table table-border" id="inbox-table">
			    			<thead>
			    				<tr style="border-bottom:2px solid #666;">
			    					<td style="width:5%;text-align:center" style='text-align:center'><input type="checkbox" name="checkallbox"></td>
			    					<td style="width:15%;text-align:center"> From </td>
			    					<td style="width:25%;text-align:center"> Customer Name </td>
			    					<td style="width:25%;text-align:center"> Campaign </td>
			    					<td style="width:20%;text-align:center"> Create Date </td>
			    					<td style="width:10%;text-align:center"> Status </td>
			    				</tr>
			    			</thead>
			    			<tbody class="table-line">
			    			</tbody>
			    			<tfoot>
			    			</tfoot>
			    		</table>
	    	</div>
	    	
	    	<!-- ticket app detail -->
	    	<div id="inbox-detail-pane" style="display:none; opacity:0; margin:20px 20px; background-color:; border-radius:2px;">
	    	
	   
	    	<table class="table table-border">
	    		<thead>
	    		<tr>
	    			<td> Create User </td>
	    			<td><span id="creu"></span></td>
	    			<td> Create Date</td>
	    			<td><span id="cred"></span></td>
	    		</tr>
	    		<tr>
	    			<td> Owner </td>
	    			<td><span id="owner"></span></td>
	    			<td> Ticket Status</td>
	    			<td><span id="tstatus"></span></td>
	    		</tr>
	    		</thead>
	    		<tbody>
	    		</tbody>
	    	</table>
	    	
	    
						
	    	<h1> Search : ไฟล์เสียง | มีวิธีหาอย่างไร (wrapup id? )</h1> 
	    	ตอบ หาจาก table  t_call_trans field uniqueid
	    	
	    	<div style="position:absolute; right:0;">
	    		 <audio id="voice" src="media/BackToDecember.mp3" type="audio/mp3" controls="controls"></audio>
	    		 <ul style="list-style:none; margin:0; padding:0" id="voice-list">
	    		 	<li style="border-bottom:1px solid #E2E2E2"> Total 5 voice  
	    		 			<div class="pull-right">  
	    		 		 	<span class="ion-ios7-download-outline" style="font-size:20px; line-height:16px; cursor:pointer"></span>
	    		 		</div>
	    		 		<div style="clear:both"></div>
	    		 	</li>
	    		 	<li> 
	    		 		<span class="ion-ios7-play" style="visibility:hidden"></span>
	    		 		<span>1. Call Date 12/12/2556 11:00 </span>
	    		 		<div class="pull-right">  
	    		 		 	<span class="ion-ios7-download-outline" style="font-size:20px; line-height:16px; cursor:pointer"></span>
	    		 		</div>
	    		 		<div style="clear:both"></div>
	    		 	</li>
	    		 	<li> 
	    		 		<span class="ion-ios7-play" style="visibility:hidden"></span>
	    		 		<span>2. Call Date 12/12/2556 12:00 </span>
	    		 		<div class="pull-right">  
	    		 		 	<span class="ion-ios7-download-outline" style="font-size:20px; line-height:16px; cursor:pointer"></span>
	    		 		</div>
	    		 		<div style="clear:both"></div>
	    		 	</li>
	    		 	<li> 
	    		 		<span class="ion-ios7-play" style="visibility:hidden"></span>
	    			<span>3. Call Date 12/12/2556 12:30 </span>
	    		 		<div class="pull-right">  
	    		 		 	<span class="ion-ios7-download-outline" style="font-size:20px; line-height:16px; cursor:pointer"></span>
	    		 		</div>
	    		 		<div style="clear:both"></div>
	    		 		 	
	    		 	</li>
	    		 </ul>
	    	</div>
	    
	    
	    	<iframe  id="ex-app" style="border:0; width:100%; overflow:hidden; margin:0;" ></iframe>
	    	<!-- 
	    	<div id="ex-apps">
	    		Load Inapp 
	    	</div>
	    	 -->
	    	 
	    	 
	    			<!-- remark detail -->
	    	  		<h3 style="font-weight:300">  Remark <span class="remark-count" style="font-size:20px;"></span> </h3>
	    			 <ul class="remark-comment"  id="ticket-remark-ul">
	    			 </ul>
	    	
	    			<!-- remark post -->
	    			<ul style="margin:0;padding:0; list-style:none; display:nones">
							<li></li>
							<li class="startnews" style="display:nones;"><textarea name="remark" style="width:100%; height:60px; " placeholder="Remark..." autocomplete="off"></textarea></li>
							<li class="startnews" style="display:nones; padding: 10px 0 10px 0px; "> 
			 				<button class="btn btn-primary save_remark">  Post  </button>
			 				</li>
					</ul>
	    	</div>
    	
    	
    	</div>
    	<!--  end right -->
    	<div style="clear:both"></div>
    </div>
   
 <!-- not use
     <ul class="remark-comments"  id="ticket-remark-ul" data-newsid="60">
			<li id="78">
				<div style="position:relative;">
					<div style="position:absolute; top:0; right:10px; cursor:pointer;" class="ion-ios7-arrow-down mypost">&nbsp;</div>
				</div>
				<div class="remark-title">
					<img id="abc" class="remark-avatar" src="profiles/agents/Xcode.png">
				</div>
				<div class="remark-comment-postbox">
				<span class="remark-comment-postbox-agent">Arnon Wongsantitamnukul</span>
				<span class="remark-comment-postbox-timestamp">
				25/10/2014 13:40  
				<span style="color:#e2e2e2">-</span>
				 2 months ago
				</span>
				<span class="remark-comment-postbox-detail">ทำเสร็จแล้วรอตรวจสอบความถูกต้อง</span>
				</div>
			</li>
			<li id="78">
				<div style="position:relative;">
					<div style="position:absolute; top:0; right:10px; cursor:pointer;" class="ion-ios7-arrow-down mypost">&nbsp;</div>
				</div>
				<div class="remark-title">
					<img id="abc" class="remark-avatar" src="profiles/agents/Xcode.png">
				</div>
				<div class="remark-comment-postbox">
				<span class="remark-comment-postbox-agent">Arnon Wongsantitamnukul</span>
				<span class="remark-comment-postbox-timestamp">
				25/10/2014 13:40  
				<span style="color:#e2e2e2">-</span>
				 2 months ago
				</span>
				<span class="remark-comment-postbox-detail">ทำเสร็จแล้วรอตรวจสอบความถูกต้อง</span>
				</div>
			</li>
			
			<li>
					<div id="add-comment" style="text-indent:5px;" data-remark="false">
						<a class="add-comment" href="#">
						<span class="ion-ios7-compose-outline" style="font-size:16px; margin-right:3px;"></span>
						<span id="add-comment-text">Add Remark </span>
						</a>
					</div>
					
					<div id="write-post" style="display: block;">
						<div class="news-comment-postbox-write">
						<img id="abc" class="avatar-title" src="profiles/agents/no_profile.png">
						</div>
						<div class="news-comment-postbox-write" style="padding: 10px 10px; width:100%">
						<textarea style="" name="comment"></textarea>
						<button class="btn btn-primary comment_post" style="margin-top:10px;"> Post </button>
						</div>

				</div>

			</li>
		</ul>
 -->

    				
   
</div> <!--  end div  -->



 <div id="profile-pane" class="content-overlay" style="display:none"></div>
</form>
</body>
</html>