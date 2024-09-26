<?php
session_start();
if (!isset($_SESSION["uid"])) {
	header('Location:index.php');
} else {
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
	<link href="css/custom.css" rel="stylesheet">
	<style>
		/*
.blurcontent{

  display: block;
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  z-index: 10;
 background-color: rgba(255,255,255,0.85);
}
.focusme {
   position:fixed;
   top: 10%;
    left: 15%;
    width: 75%;

    height: auto;
    background-color: #2990ea;
    z-index: 201;

}
*/

		#select-report li.hover div:hover {
			background-color: #E2E2E2;
			cursor: pointer;
		}

		.a-middle {
			vertical-align: middle;
		}
	</style>

	<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.serialize-object.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/pace.min.js"></script>
	<script type="text/javascript" src="js/stack.notify.js"></script>
	<script type="text/javascript" src="js/stack.datetime.js"></script>
	<script type="text/javascript" src="js/checkswitch.js"></script>
	<script type="text/javascript" src="js/reminder.js"></script>
	<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript" src="js/report.js"></script>
	<script>
		$(function() {

			$body = $("body");
			$(document).on({
				ajaxStart: function() {
					$body.addClass("loading");
				},
				ajaxStop: function() {
					$body.removeClass("loading");
				}
			});

			function reportLoad(name) {
				$('#select-report').fadeOut('fast', function() {
					$('#report').fadeIn('medium').load(name);
				});
			}

			//agent report click ( report 1 )
			$('#agent-report').click(function(e) {
				reportLoad('report_agent_performance.php');
			});

			//agent report click ( report 1 )
			$('#agent-report-lead-list').click(function(e) {
				reportLoad('report_agent_performance_lead.php');
			});

			//Camp Performance click ( report 2 )
			$('#camp-report').click(function(e) {
				reportLoad('report_campaign_performance.php');
			});

			//Camp Performance click ( report 2 )
			$('#camp-report-lead-list').click(function(e) {
				reportLoad('report_campaign_performance_lead.php');
			});

			// DM Daily Sales report

			$('#dm-daily-sales-report').click(function(e) {
				reportLoad('report_DM_Daily_Sales_Report.php');
			});


			$('#callresult-report').click(function(e) {
				reportLoad('report_call_result.php');
			});

			$('#report4-report').click(function(e) {
				reportLoad('report_confirm_call.php');
			});

			// 	 $('#report5-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report5').fadeIn('medium').load('report5.php');
			// 			})
			// 	});

			// 	 $('#report6-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report6').fadeIn('medium').load('report6.php');
			// 			})
			// 	});

			// 	 $('#report7-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report7').fadeIn('medium').load('report7.php');
			// 			})
			// 	});
			$('#report8-report').click(function(e) {
				reportLoad('report8.php');
			});
			$('#report9-report').click(function(e) {
				reportLoad('report9.php');
			});
			$('#report-TPA-report').click(function(e) {
				reportLoad('report_tpa.php');
			});
			//   $('#report10-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report10').fadeIn('medium').load('report10.php');
			// 			})
			// 	});
			// 	 $('#report11-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report11').fadeIn('medium').load('report11.php');
			// 			})
			// 	});
			// 	$('#report12-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report12').fadeIn('medium').load('report12.php');
			// 			})
			// 	});

			// 	$('#report14-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report14').fadeIn('medium').load('report14.php');
			// 			})
			// 	});

			// 	$('#report15-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report15').fadeIn('medium').load('report15.php');
			// 			})
			// 	});

			// 	$('#report16-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report16').fadeIn('medium').load('report16.php');
			// 			})
			// 	});
			// 	$('#report17-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report17').fadeIn('medium').load('report17.php');
			// 			})
			// 	});
			// 	$('#report18-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report18').fadeIn('medium').load('report18.php');
			// 			})
			// 	});

			// 	$('#report19-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report19').fadeIn('medium').load('report19.php');
			// 			})
			// 	});

			// 	$('#report20-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report20').fadeIn('medium').load('report20.php');
			// 			})
			// 	});

			// 	$('#report21-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report21').fadeIn('medium').load('report21.php');
			// 			})
			// 	});

			// 	$('#report22-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report22').fadeIn('medium').load('report22.php');
			// 			})
			// 	});

			// 	$('#report23-report').click( function(e){
			// 			$('#select-report').fadeOut( 'fast' , function(){
			// 				$('#report23').fadeIn('medium').load('report23.php');
			// 			})
			// 	});






		})
	</script>

<body>
	<form>
		<input type="hidden" name="appname" value="report">
		<?php date_default_timezone_set('Asia/Bangkok'); ?>
		<input type="hidden" name="servertime" value="<?php echo time() ?>">
		<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
		<input type="hidden" name="serverdate" value="<?php echo  date('d') . "/" . date('m') . "/" . date('Y') ?>">
		<input type="hidden" name="uid" value="<?php echo $uid;  ?>">
		<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>">


		<div class="navbar navbar-default navbar-fixed-top navbar-header" style="z-index:100;">
			<div class="navbar-inner  pull-left" style="margin-left:15px; ">
				<ul class="header-profile">
					<li style="text-align:center; vertical-align:middle;padding-right:2px;">
						<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
							<span id="smartpanel-detail">
								<i class="icon-fire"></i> <span style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">ICX </span>
							</span>
						</span>
					</li>
					<li>
						<span style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;">
							<span id="show-name" class="header-user-profile">Ext <?php echo $pfile['uext']; ?></span>
							<span id="show-passions" class="header-user-detail"> Session ID : <?php echo  $pfile['tokenid']; ?> </span>
						</span>
					</li>
				</ul>
			</div>
			<div class="stack-date pull-right"></div>
			<div class="navbar-inner pull-right">
				<span class="ion-ios-arrow-down  dropdown-toggle profile-arrow" data-toggle="dropdown"></span>
				<ul class="dropdown-menu pull-right">
					<li class="text-center" style="padding:10px 10px 20px 10px;">
						<img src="<?php echo $pfile['uimg']; ?>" id="profile-dd-img" class="avatar-title">
					</li>
					<li class="divider"></li>
					<li><a href="#" id="loadprofile"><span class="ion-ios-contact-outline size-21"></span> &nbsp; My profile</a></li>
					<!-- <li><a href="#" id="loadreminder"><span class="ion-ios-alarm-outline size-21"></span> &nbsp; Reminder </a></li> -->
					<li class="divider"></li>
					<li><a href="logout.php"> <span class="ion-ios-locked-outline size-21"></span> &nbsp; Log out</a></li>
				</ul>
			</div>

			<div class=" pull-right" style=" text-align:right;color:#fff; margin-top:3px; margin-right:4px;">
				<span id="show-name" class="header-user-profile"><?php echo  $pfile['uname']; ?></span>
				<span id="show-passion" class="header-user-detail"><?php echo  $pfile['team']; ?></span>
			</div>

			<div class="pull-right" style="margin-top:-4px; margin-right:15px; ">
				<ul class="nav navbar-nav" style="margin:0;padding:0">
					<!--
			    <li class="dropdown" style="height:50px;">
			   		 <a class="dropdown-toggle" data-toggle="dropdown" style="margin:0;padding:8px 10px; ">
							<span class="ion-ios7-chatbubble-outline size-38" style="color:#fff;cursor:pointer;"></span>
							<span id="total_followup" class="stackbadge ">0</span>
				    </a>
			    </li>
			 -->
					<!--
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

		<div class=" header" style="margin-top:50px;">
			<div class="metro header-menu">
				<?php include("subMenu.php");  ?>
			</div>
		</div>
		<!-- div wrapper -->
		<div style="margin:0px 20px;">

			<div style="float:left; display:inline-block">
				<h2 style="display:inline-block;font-family:raleway; color:#666666; "> Report </h2>
				<div id="page-subtitle" style="font-family:raleway;color:#777777;position:relative; top:-10px; text-indent:2px;"> Summary Report </div>
			</div>
			<div style="clear:both"></div>
			<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px">

			<ul style="position:absolute; margin:0; padding:0; display:none">
				<li> Yes File Report </li>
				<li> DCR Report </li>
				<li> App Report </li>
				<li> รายงานขอดขาย Success
					<ul>
						<li> สถานะ + วันที่ </li>
					</ul>
				</li>
				<li> รายงานยอดขาย Approve </li>
				<li> KPI รวมของ TSR </li>
				<li> KPI รวมของ Datasource
					<ul>
						<li> เงื่อนไข : วันที่ ( default วันนี้ ) </li>
					</ul>
				</li>
			</ul>

			<!--  report main menu -->
			<ul style="width:100%; list-style:none; margin:0;padding:0; " id="select-report">
				<li>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px solid #666">
						<h3 style="font-family:raleway; color:#666; padding:10px; margin:0; float:left;"><i class="icon-bar-chart"></i> Select Report </h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="clear:both"></div>
				</li>
				<li class="hover" id="agent-report">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Agent Performance</h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="clear:both"></div>
				</li>
				<li class="hover" id="camp-report">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Campaign Performance</h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="clear:both"></div>
				</li>
				<!-- ============ TESTING ===================== -->
				<li class="hover" id="agent-report-lead-list">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Agent Performance By Lead List</h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="clear:both"></div>
				</li>

				<li class="hover" id="camp-report-lead-list">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Campaign Performance By Lead List</h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="clear:both"></div>
				</li>
				<!--
				<li class="hover" id="dm-daily-sales-report">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; DM Daily Sales Report</h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="clear:both"></div>
				</li>
				-->
				<!-- ============ TESTING ===================== -->
				<li class="hover" id="callresult-report">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Call Result</h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="clear:both"></div>
				</li>
				<!--
				<li class="hover" id="report4-report">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Confirm Call</h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="clear:both"></div>
				</li>
				
				<li class="hover" id="report8-report">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; TPA Happy Family Export </h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>

					<div style="clear:both"></div>
				</li>
				<li class="hover" id="report9-report">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; TPA Double Care Export </h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>

					<div style="clear:both"></div>
				</li>
				<li class="hover" id="report-TPA-report">
					<div style="width:25%;float:left;">
						&nbsp;
					</div>
					<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
						<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; TPA Export </h3>
					</div>
					<div style="width:25%;float:left;">
						&nbsp;
					</div>

					<div style="clear:both"></div>
				</li>
				-->
				<!--<li class="hover" id="report21-report">
 				<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
	 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Agent Performance</h3>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
	 		</li>

			 <li class="hover" id="report22-report">
 				<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
	 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Campaign Performance</h3>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report23-report">
 				<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
	 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Call Result</h3>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
	 		</li>

            
	 		<li class="hover" id="report16-report">
 				<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
	 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Daily Report (Generali)</h3>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report19-report">
 				<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
	 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Daily Report By Agent (Generali)</h3>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report17-report">
 				<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
	 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-tag"></i> &nbsp; Daily Detail Report (Ganerali)</h3>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report18-report">
 				<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
	 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Daily  Report (Motor) </h3>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report20-report">
 				<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd; padding-left:100px; ">
	 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; "><span class="ion-ios-people-outline" style="line-height:0px; font-size:34px;  position:relative;  top:4px; margin:0; padding:0"></span>&nbsp; Daily Report By Agent (Motor)</h3>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
	 		</li>
            
	 		
	 		

		 	<div style="clear:both"></div>
	 		</li>
			<li class="hover" id="report8-report">
	 				<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>
	 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
		 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; Yesfile  GenExclusive  </h3>
		 			</div>
		 			<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>

		 			<div style="clear:both"></div>
	 		</li>
			<li class="hover" id="report9-report">
	 				<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>
	 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
		 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; Yesfile  GenExclusive Plus </h3>
		 			</div>
		 			<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>

		 			<div style="clear:both"></div>
	 		</li>

      <li class="hover" id="report10-report">
	 				<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>
	 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
		 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; Yesfile Health Lump Sum </h3>
		 			</div>
		 			<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>

		 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report11-report">
	 				<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>
	 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
		 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; DCR GenExclusive </h3>
		 			</div>
		 			<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>

		 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report12-report">
	 				<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>
	 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
		 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; DCR GenExclusive  (เงินสด)</h3>
		 			</div>
		 			<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>

		 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report13-report">
	 				<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>
	 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
		 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; DCR GenExclusive Plus </h3>
		 			</div>
		 			<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>

		 			<div style="clear:both"></div>
	 		</li>
            
            <li class="hover" id="report14-report">
	 				<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>
	 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
		 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; DCR Health Lump Sum </h3>
		 			</div>
		 			<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>

		 			<div style="clear:both"></div>
	 		</li>
            <li class="hover" id="report15-report">
	 				<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>
	 				<div style="width:50%;float:left; border-bottom:1px dashed #ddd;  padding-left:100px">
		 					<h3 style="font-family:raleway; color:#444; padding:10px; margin:0; float:left;"><i class="icon-list-alt"></i> &nbsp; DCR Health Lump Sum (เงินสด)</h3>
		 			</div>
		 			<div style="width:25%;float:left;">
		 			 &nbsp;
		 			</div>

		 			<div style="clear:both"></div>
	 		</li> -->

			</ul>
			<!--  end report main menu -->
			<div id="report" style="display:none"></div>

			<!--
 <div id="tracking-pane" style="display:none"></div>

<div >
		<h2 style="font-family:raleway; color:#666666; font-weight:300">  Report    </h2>
		Report Topic
		 Average Talk Time , Call Completion Rate , AverageWrapTime
		 <br/>
		 Login Logout Agent <br/>
		 Talk time -> Answer Call , Average Talk Time , นับจำนวนสายที่คุยมากกว่าเท่านี้นาที ได้ <br/>

	     จำนวน list  ของ  Agent  ที่ได้รับ Group by month , group by agent , group by campaign <br/>
		 Busy <br/>
		 wrapup detail <br/>

		 customize report <br/>

		 manday ละ  10,000

		 ค่า  Design  Report : ต้องการอะไร ,  เก็บข้อมูล
		  ค่า Coding Report :
		  ค่า Test + Implement + UAT + Document
		 ค่า Design Program		0.5
		 ค่า Coding Program    1.5

		 2.0 = 30k

		 -->
		</div>
		<!-- end div wrapper -->

		<div id="profile-pane" class="content-overlay" style="display:none"></div>
	</form>
	<div class="modal"></div>
</body>

</html>