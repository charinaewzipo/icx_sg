<?php
    session_start();
	require_once("bypasslogin.php");
    if(!isset($_SESSION["uid"])){
       header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
		$pfile = $_SESSION["pfile"];
		$genesysid = $pfile["genesysid"];
	}
 ?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta charset="utf-8" />
	<title> ICX</title>
	<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">
	<link href="css/jquery.tabSlideOut.css" rel="stylesheet">
	<link href="css/default.css" rel="stylesheet">
	<link href="css/softphone.css" rel="stylesheet">
	<link href="css/jquery-steps.css" rel="stylesheet">
	<link href="css/jquery.datetimepicker.min.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<link href="js/DataTables/datatables.min.css" rel="stylesheet">
	<link href="js/DataTables/Responsive-2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
	<link href="js/DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
	
	<style>
		table.dataTable tbody tr:hover{
			background-color:#E2E2E2;
			cursor:pointer;
		}

		div.dt-buttons {
			float:right;
		}

		.fadeInUp {
			animation: fadeInUp 1s ease both;
			position: relative;

		}

		@keyframes fadeInUp {
			0% {
				opacity: 0;
				transform: translateY(10px);
			}

			100% {
				opacity: 1;
				transform: translateY(0px);
				visibility: visible;
			}
		}


		.animated {
			animation-duration: 1s;
			animation-fill-mode: both;
			z-index: 100;
		}

		@keyframes fadeInRight {
			0% {
				opacity: 0;
				transform: translateX(20px);
			}

			100% {
				opacity: 1;
				transform: translateX(0px);
			}
		}

		.fadeInRight {
			animation-name: fadeInRight;
		}


		table>tbody.hover>tr:hover {
			background-color: #E2E2E2;
			cursor: pointer;
		}

		table.bg {
			background-color: #fdfdfd;
		}

		/*
table > tfoot > tr > td{
	color:#676a6c;
	font-size: 14px;
	font-family : "open sans","Helvetica Neue",Helvetica,Arial,sans-serif;
}
*/
		#callstatic-table {
			width: 100%;
		}

		#callstatic-table tr td {
			border-bottom: 1px solid #e2e2e2;
			line-height: 1.42857;
			padding: 7px;
		}

		#callstatic-table tr td:last {
			background-color: #E2E2E2;
		}

		#popup-menu {}

		#popup-menu li:hover {
			color: #fff;
			background-color: rgba(43, 129, 208, 1);
		}

		#popup-menu li.active {
			color: #fff;
			background-color: rgba(78, 185, 255, 1);
		}

		.circle-hover:hover {
			background-color: rgba(244, 244, 244, 0.4);
		}

		.row-record-slide li {
			display: inline-block;
		}


		.triangle-right {
			width: 0;
			height: 0;
			border-top: 21px solid transparent;
			border-left: 21px solid #8cbf26;
			border-bottom: 21px solid transparent;
			top: 5px;
		}


		#cmpprofile-table tr td {
			padding: 8px;
		}

		#wrapup-table tr td {
			padding: 8px;
		}

		.popup-vertical-menu {
			cursor: pointer;
			border-width: 0px 0 1px 1px;
			border-style: solid;
			border-color: #E2E2E2;
			text-align: center;
			vertical-align: middle;
			min-height: 49px;
		}


		/* table call list color */
		#calllist-table tbody tr td {
			/* background-color: rgba(139, 195, 74, 0.2); */
		}

		/* zebra line popup call history table */
		#popup_history-table tbody tr:nth-child(odd) {
			background-color: #FAFAFA;
		}

		#campaign-exapp li {
			display: inline-block;
			background-color: rgba(255, 255, 255, 0.45);
		}

		#campaign-exapp li:hover {
			background-color: rgba(255, 255, 255, 0.8);
		}
	</style>

	<script>
		localStorage.removeItem('voiceid');
		localStorage.removeItem('lastInteraction');
		var uid = <?php echo $_SESSION["uid"]; ?>;
		var pfile = <?php echo json_encode($pfile); ?>;
	</script>
	<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.serialize-object.min.js"></script>
	<script type="text/javascript" src="js/jquery-steps.min.js"></script>
	<script type="text/javascript" src="js/timer.jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/pace.min.js"></script>
	<script type="text/javascript" src="js/stack.notify.js"></script>
	<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="js/stack.datetime.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript" src="js/jquery.timeago.js"></script>
	<script type="text/javascript" src="js/jquery.tabSlideOut.js"></script>
	<script type="text/javascript" src="js/DataTables/datatables.min.js"></script>
	<script type="text/javascript" src="js/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="js/DataTables/Responsive-2.5.0/js/responsive.dataTables.min.js"></script>
	
	<!--  <script src="http://192.168.0.101:8888/socket.io/socket.io.js"></script> -->
	<script type="text/javascript" src="js/call.js?v=<?=time();?>"></script>

	<!-- <script type="text/javascript" src="js/reminder.js"></script> -->

	<script>
		$(function () {

			$("#time_wait").timer({
				format: '%M:%S'
			});
			$("#time_talk").timer({
				format: '%M:%S'
			}).timer('pause');
			$("#time_wrap").timer({
				format: '%M:%S'
			}).timer('pause');

			$('#step-wrapup').steps({
				showFooterButtons: false,
				onFinish: function () {
					alert('complete');
				}
			});

			$('.softphone').tabSlideOut({
				tabLocation: 'bottom',
				clickScreenToClose: false,
				// action: 'hover',
				offset: '10px',
				// otherOffset: '1500px',
				bounceTimes: 20,
				bounceDistance: '10px',
				bounceSpeed: 100,
				offsetReverse: true
			});

			if ($.QueryString.hasOwnProperty("listid") && $.QueryString["listid"] != "") {
				var listid = $.QueryString["listid"];
				var voiceid = ($.QueryString.hasOwnProperty("voiceid") && $.QueryString["voiceid"] != "") ? $
					.QueryString["voiceid"] : "";
				$('[name=listid]').val(listid);
				$('[name=voiceid]').val(voiceid);
				$.call.loadpopup_content(listid);
			}

			$(document).click(function () {
				$('.wrapper-dropdown-5').removeClass('active');
			});

			$('.drop').click(function (e) {
				e.preventDefault();
				$('.wrapper-dropdown-5').removeClass('active');
				$(this).toggleClass('active');
				e.stopPropagation();
			});

			//reminder on popup
			$('#reminder-on > li').click(function (e) {
				e.preventDefault();
				e.stopPropagation();

				var id = $(this).attr('id');
				//console.log( $(this).attr('id') );
				//console.log( $(this).parent().attr('class') );
				//console.log( $(this).parent().parent().hasClass('active') );
				$('.wrapper-dropdown-5').removeClass('active');

				$(this).parent().parent().removeClass('active');
				$(this).parent().parent().children('span').text($(this).text());

				$('[name=pop_reminderOn]').val(id);


			});

			//reminder on popup
			$('#reminder-cat > li').click(function (e) {
				e.preventDefault();
				e.stopPropagation();

				var id = $(this).attr('id');
				//console.log( $(this).attr('id') );
				//console.log( $(this).parent().attr('class') );
				//console.log( $(this).parent().parent().hasClass('active') );
				$('.wrapper-dropdown-5').removeClass('active');

				$(this).parent().parent().removeClass('active');
				$(this).parent().parent().children('span').text($(this).text());

				$('[name=pop_reminderType]').val(id);


			});

			//calendar
			var minDateTime = new Date();
			minDateTime.setMinutes(minDateTime.getMinutes() + 5);
			$('.calendar_en').datetimepicker({
				format: 'Y-m-d H:i',
				minDateTime: minDateTime,
				todayButton: true,
				closeOnWithoutClick: true,
				scrollInput: false,
				closeOnDateTimeSelect: true,
				defaultTime: minDateTime.getHours() + ":" + minDateTime.getMinutes()
			});



			$('#popup_history_search-btn').click(function (e) {
				e.preventDefault();
			});


			//popup btn
			$('#wrapup-click').click(function (e) {
				e.preventDefault();
				$('#wrapup-box').show();
				$('#call-box').hide();
				$('#history-box').hide();
				$('#reminder-box').hide();

				$('#panel-wrapup-header').show();
				$('#panel-history-header').hide();
				$('#panel-popup-header').hide();
				$('#panel-reminder-header').hide();
			});

			$('#makecall-click').click(function (e) {
				e.preventDefault();
				$('#call-box').show();
				$('#wrapup-box').hide();
				$('#history-box').hide();
				$('#reminder-box').hide();

				$('#panel-wrapup-header').hide();
				$('#panel-history-header').hide();
				$('#panel-popup-header').show();
				$('#panel-reminder-header').hide();
			});

			$('#history-click').click(function (e) {
				e.preventDefault();
				$('#history-box').show();
				$('#call-box').hide();
				$('#wrapup-box').hide();
				$('#reminder-box').hide();

				$('#panel-wrapup-header').hide();
				$('#panel-history-header').show();
				$('#panel-popup-header').hide();
				$('#panel-reminder-header').hide();

			});

			$('#reminder-click').click(function (e) {
				e.preventDefault();
				$('#history-box').hide();
				$('#call-box').hide();
				$('#wrapup-box').hide();
				$('#reminder-box').show();

				$('#panel-wrapup-header').hide();
				$('#panel-history-header').hide();
				$('#panel-popup-header').hide();
				$('#panel-reminder-header').show();
			});


			//popup header left and right arrow
			$('#turn-left').click(function (e) {
				e.preventDefault();
				$.call.prevlist();
			});

			$('#turn-right').click(function (e) {
				e.preventDefault();
				$.call.nextlist();
			});

			//popup vertical menu
			$('#popup-menu li').click(function () {
				$('#popup-menu').children().removeClass('active');
				$(this).addClass('active');
				//console.log("menu click");
			});

			// popup page show or hide salescript
			$('#salescript').click(function () {
				self = $(this);
				if (self.attr('data-status') == "show") {
					self.attr('data-status', 'hide');
					self.children().hide();
					self.css('background-color', 'transparent');
					$('#salescript-dtl').slideUp('fast');

				} else {
					self.attr('data-status', 'show');
					self.children().show();
					self.css('background-color', '#16a085');

					$('#salescript-dtl').slideDown('fast');
				}
			});

			/*
					 $('#reminder-pane').load('reminder-pane.php' , function(){
							$(this).fadeIn('fast');
							 $('#reminder-pane').css({'height':(($(document).height()))+'px'});
					   			window.scrollTo(0, 0);
					 }); 
				*/


			$('#makecall').click(function (e) {
				e.preventDefault();

				//get call number
				var call = $('.active-number').attr('data-id'); //text();
				var callnumber = $('.active-number').text();
				//set active status to button
				$('#makecall').attr('data-status', 'active');
				$('#wrapup-msg').hide(); // hide wrapup save msg	
				$('#reminder-link').hide(); // hide reminder link
				$('#reminder-msg').hide(); // hide reminder save msg
				$.call.makeCall(call, callnumber);


			});

			$('#transfer').click(function (e) {
				e.preventDefault();
				$(this).prop( "disabled", true );
				$.call.transfer("5f2bf79c-c0fe-4047-b728-7bd37289fb18").then((data)=>{
					let response = eval('(' + data + ')');
					if(!response.result){
						$(this).prop( "disabled", false );
					}
				});
			});
			//end action make call

			//hangup call
			$('#hangup').click(function (e) {
				e.preventDefault();

				//remove active status to button
				$('#makecall').removeAttr('data-status');
				$.call.hangupCall();


			});
			//end hangup call

			$('#open-callscriptfull').click(function (e) {
				e.preventDefault();

				var self = $(this);
				window.open(self.attr('data-script'));
				//window.open('callscriptfull.php','callscriptfull','');
			});

			/*
			$('#open-app1').click( function(e){
					e.preventDefault();
					var self = $(this);
					window.open('http://localhost:8088/smile/agents.php?campaign_id=3&callist_id=1&agent_id=5&import_id=20');
			});
			*/
		});
	</script>

<body>
	<form>
		<input type="hidden" name="appname" value="call">
		<?php  date_default_timezone_set('Asia/Bangkok');?>
		<input type="hidden" name="servertime" value="<?php echo time() ?>">
		<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
		<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
		<input type="hidden" name="uid" value="<?php echo $uid;  ?>">
		<input type="hidden" name="genesysid" value="<?php echo $genesysid;  ?>">
		<input type="hidden" name="cmpid">
		<input type="hidden" name="cmptype">
		<input type="hidden" name="queueid">
		<input type="hidden" name="queuecallbackid">
		<input type="hidden" name="lastInteraction"> <!--  when click call list  for make  call  -->
		<input type="hidden" name="listid"> <!--  when click call list  for make  call  -->
		<input type="hidden" name="voiceid"> <!--  when click call list  for make  call  -->
		<input type="hidden" name="contactid"> <!--  when click call list  for make  call  -->
		<input type="hidden" name="contactlistid"> <!--  when click call list  for make  call  -->
		<input type="hidden" name="currentInteraction"> <!--  when click call list  for make  call  -->
		<input type="hidden" name="uext" value="<?php echo  $pfile['uext']; ?>">
		<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>">
		<div class="navbar navbar-default navbar-fixed-top navbar-header" style="z-index:100;">
			<div class="navbar-inner  pull-left" style="margin-left:15px; ">
				<ul class="header-profile">
					<li style="text-align:center; vertical-align:middle;padding-right:2px;">
						<span
							style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;"
							id="smartpanel">
							<span id="smartpanel-detail">
								<i class="icon-fire"></i> <span
									style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">ICX
								</span>
							</span>
						</span>
					</li>
					<li>
						<span
							style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;">
							<span id="show-name" class="header-user-profile">Ext <?php echo  $pfile['uext']; ?></span>
							<span id="show-passions" class="header-user-detail"> Session ID :
								<?php echo  $pfile['tokenid']; ?> </span>
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
					<li><a href="#" id="loadprofile"><span class="ion-ios-contact-outline size-21"></span> &nbsp; My
							profile</a></li>
					<!-- <li><a href="#" id="loadreminder"><span class="ion-ios-alarm-outline size-21"></span> &nbsp; Reminder </a></li> -->
					<li class="divider"></li>
					<li><a href="logout.php"> <span class="ion-ios-locked-outline size-21"></span> &nbsp; Log out</a>
					</li>
				</ul>
			</div>

			<div class=" pull-right" style=" text-align:right;color:#fff; margin-top:3px; margin-right:4px;">
				<span id="show-name" class="header-user-profile"><?php echo  $pfile['uname']; ?></span>
				<span id="show-passion" class="header-user-detail"><?php echo  $pfile['team']; ?></span>
			</div>

			<div class="pull-right" style="margin-top:-4px; margin-right:15px; ">
				<!-- 
			<ul class="nav navbar-nav" style="margin:0;padding:0" >
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
			</ul>
			-->
			</div>
		</div>

		<div class="header" style="margin-top:50px;">
			<div class="bg-grayLighter metro header-menu">
				<?php require_once("subMenu.php");  ?>
			</div>
		</div>

		<div style="margin:0px 20px;">
			<div>
				<div style="float:left; display:inline-block">
					<h2 style="display:inline-block;font-family:raleway; color:#666666; "> Call Work </h2>
					<div id="page-subtitle"
						style="font-family:raleway;color:#777777;position:relative; top:-10px; text-indent:2px;"> Call
						Work </div>
				</div>
				<div style="float:right; display:inline-block;">
					<div style="display:none; float:right; margin-top:15px;" id="callwork-mon">
						<div class="shadow"
							style="border-radius:2px; margin-left:2px; width:160px; height:60px; display:inline-block; background-color:#4a53c3; position:relative;">
							<div style="float:left; display:inline-block; font-size:20px; margin-left:10px;">
								<span style="display:block; font-family: lato; font-size:24px; color:#fff;"
									id="time_wait"> 0</span>
								<span
									style="display:block; line-height: 16px; font-family: raleway; font-size:16px; font-weight:bold; color:#fff; ">
									Wait Time </span>
							</div>
							<div
								style=" float:right; display:inline-block; padding-left:6px; padding-bottom:2px; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2); ">
								<span style="font-size:40px; color:#fff; padding:8px; margin-right:8px;"
									class="ion-ios-timer-outline"></span></div>
						</div>
						<div class="shadow"
							style="border-radius:2px; margin-left:2px; width:160px; height:60px; display:inline-block; background-color:#8bc34a; position:relative;">
							<div style="float:left; display:inline-block; font-size:20px; margin-left:10px;">
								<span style="display:block; font-family: lato; font-size:24px; color:#fff;"
									id="total_diallist"> 0</span>
								<span
									style="display:block; line-height: 16px; font-family: raleway; font-size:16px; font-weight:bold; color:#fff; ">
									New list </span>
							</div>
							<div
								style=" float:right; display:inline-block; padding-left:6px; padding-bottom:2px; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2); ">
								<span style="font-size:40px; color:#fff; padding:8px; margin-right:8px;"
									class="ion-ios-telephone-outline"></span></div>
						</div>
						<div class="shadow"
							style="border-radius:2px; margin-left:2px; width:170px; height:60px; display:inline-block; background-color:#F2B50F; position:relative;">
							<div style="float:left; display:inline-block; font-size:20px; margin-left:10px;">
								<span style="display:block; font-family: lato; font-size:24px; color:#fff;"
									id="total_nocontact"> 0</span>
								<span
									style="display:block; line-height: 16px; font-family: raleway; font-size:16px; font-weight:bold; color:#fff; ">No
									Contact </span>
							</div>
							<div
								style=" float:right; display:inline-block; padding-left:5px; padding-bottom:2px; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2); ">
								<span
									style="position:relative; left:4px;font-size:40px; color:#fff; padding:3px; margin-right:3px;"
									class="ion-ios-telephone-outline"></span><span
									style="position:relative; color:#fff; font-size:16px;  left:-10px;  top:-18px;"
									class=icon-comments></span></div>
						</div>
						<div class="shadow"
							style="border-radius:2px;margin-left:2px; width:160px; height:60px; display:inline-block;  background-color:#ef6c00; position:relative;">
							<div
								style="float:left; display:inline-block; font-size:20px; font-family: lato; margin-left:10px;">
								<span style="display:block; font-family: lato; font-size:24px; color:#fff;"
									id="total_callback"> 0 </span>
								<span
									style="display:block; line-height: 16px; font-family: raleway; font-size:16px; font-weight:bold; color:#fff">
									Call Back</span>
							</div>
							<div
								style="float:right; display:inline-block; padding-left:6px; padding-bottom:2px;  background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2);">
								<span class="ion-ios-telephone-outline"
									style="font-size:40px; color:#fff; "></span><span
									style="left:-5px; top:-8px; position:relative; color:#fff;  font-size:20px;"
									class="icon-reply"></span></div>
						</div>
						<div class="shadow"
							style="border-radius:2px;margin-left:2px; width:160px; height:60px; display:inline-block; background-color:#2196f3; position:relative;">
							<!--  #2e8bcc -->
							<div
								style="float:left; display:inline-block; font-size:20px; font-family: lato; margin-left:10px;">
								<span style="display:block; font-family: lato; font-size:24px; color:#fff;"
									id="total_followup"> 0 </span>
								<span
									style="display:block; line-height: 16px; font-family: raleway; font-size:16px; font-weight:bold; color:#fff">
									Follow Up </span>
							</div>
							<div
								style="float:right; display:inline-block; padding-left:10px; padding-bottom:2px; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2);">
								<span
									style="position:relative; left:4px;font-size:40px; color:#fff; padding:3px; margin-right:3px;"
									class="ion-ios-telephone-outline"></span><span
									style="position:relative; color:#fff; font-size:16px;  left:-10px;  top:-18px;"
									class=icon-refresh></span></div>
						</div>

					</div>
					<div style="clear:both"></div>
				</div>
			</div>
			<div style="clear:both"></div>
			<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px">
			<div id="callcampaign-pane" style="display:none"></div>
			<div id="callwork-pane" style="display:none"></div>
		</div>

		<!--  start popup pane -->
		<div id="popup" class="content-overlay" style="display:none">
			<input type="hidden" name="callbackNumbers">
			<div class="container">
				<div class="row">
					<div style="float:left; width:35%;  height:50px; background-color: #999;">
						<ul class="header-profile">
							<li style="vertical-align:middle; display:inline-block">
								<span
									style="font-size:21px; font-weight: 0; font-family: lato;  color:#fff; display:block; padding:10px; margin-bottom:15px;"
									id="show-cmp">
									Campaign Name
								</span>
							</li>
							<li>
								<span
									style="display:inline-block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;">
									<span id="show-name" class="header-user-profile">Ext
										<?php echo  $pfile['uext']; ?></span>
									<span id="phone-status"
										style="display:block; margin-right:5px;	font-size: 12px;	line-height:18px;">Ready
										to call...</span>
								</span>
							</li>

						</ul>
					</div>

					<!-- overlay header  -->
					<div style="float:left; width:30%; height:50px; text-align:center; background-color:#999; ">
						<ul style="margin:0;padding:0;list-style:none; position:relative;font-size: 0;">
							<li class="popup-header"
								style="position:relative; display:inline-block; height:50px; padding:0 10px; background-color:#8cbf26">
								<div id="turn-left" class="circle-hover"
									style=" visibility:hidden; top:10px; position:relative; border:1px solid #fff;  cursor:pointer; padding-right:2px; -moz-border-radius: 50%;-webkit-border-radius: 50%;border-radius: 50%; height:30px; width:30px;">
									<span class="ion-ios-arrow-left " style="font-size:23px; color:#fff; "> </span>
								</div>
							</li>
							<!-- 
			 -->
							<li class="popup-header"
								style="display:inline-block; height:50px; background-color:#8cbf26">
								<div
									style="top:8px; position:relative; display:inline-block; color:#fff; margin:0 10px;">
									<span style=" font-size:18px; font-family:raleway" id="popup-title"> Dial list
									</span>
									<div id="popup-subtitle" style="position:relative; visibility:hidden">Record <span
											id="popup-current-row" style="position:relative; visibility:hidden"></span>
										of <span id="popup-total-row"
											style="position:relative; visibility:hidden"></span></div>
								</div>
							</li>
							<!-- 
			 -->
							<li class="popup-header"
								style="position:relative; display:inline-block; height:50px; padding:0 10px; background-color:#8cbf26">
								<div id="turn-right" class="circle-hover"
									style=" visibility:hidden; top:10px; position:relative; border:1px solid #fff;  cursor:pointer; padding-right:2px; -moz-border-radius: 50%;-webkit-border-radius: 50%;border-radius: 50%; height:30px; width:30px;">
									<span class="ion-ios-arrow-right" style="font-size:23px; color:#fff;"> </span>
								</div>
							</li>
						</ul>
					</div>
					<div style="float:right; width:35%;height:50px;  background-color:#999">
						<div style="width:100%;">
							<div class="pull-left" style="background:#4a53c3;width:85px;">
								<div style="font-family: lato;">
									<span
										style="display:block; font-family: lato; font-size:24px; color:#fff;text-align:center;"
										id="time_talk"></span>
									<span
										style="display:block; line-height: 16px; font-family: raleway; font-size:16px; font-weight:bold; color:#fff;text-align:center; ">
										Talk time </span>
								</div>
							</div>
							<div class="pull-left" style="background:#4a53c3;width:85px;margin-left:10px;">
								<div style="font-family: lato;">
									<span
										style="display:block; font-family: lato; font-size:24px; color:#fff;text-align:center;"
										id="time_wrap"></span>
									<span
										style="display:block; line-height: 16px; font-family: raleway; font-size:16px; font-weight:bold; color:#fff;text-align:center; ">
										Wrap time </span>
								</div>
							</div>
							<div class="stack-date pull-right"></div>
						</div>
					</div>
					<div style="clear:both"></div>
					<!-- Show  Recently  Call -->
					<!-- 
	<div id="popup-recently-calls" style="display:none;font-size:12px; background-color:#fff; border:1px dashed #e2e2e2; text-indent:5px; height:20px;">
			<div style="float:left; width:50%; display:inline-block;height:inherit;"> 
				 <span style="color:#8cbf26" id="lastwrapup_dt">This call list last recently wrapup on 12 ตุลาคม 2557 12:23  &nbsp; </span>
			</div>
			<div style="float:right; width:50%; display:inline-block; text-align:right; padding-right:2px;">
				<span style="color:rgba(255, 0, 151, 1); " id="lastreminder_dt"> !! Reminder call back on 12 ตุลาคม 2557 13:00  &nbsp;</span>
			</div>
		
	</div>
	-->
					<div style="clear:both"></div>
					<!-- 
	<div style="width:100%; font-size:12px; background-color:#fff; border:1px dashed #e2e2e2; text-indent:5px; display:nones ;"> <span style="color:rgba(255, 0, 151, 1); "> !! Reminder call back on 12/12/2556 13:00  </span></div> 
	<!--  end overlay header -->

					<div style="padding: 0 5px 5px 0;">
						<div style="display:inline-block; position:relative;">
							<!--  
				<span style="margin:10px; color:#8cbf26; ">This call list is recently wrapup on 12/12/2556 12:23  </span> <br/>
				<span style="margin:10px; color:#ff0097; ">Reminder call back on 12/12/2556 13:00 </span> <br/> -->
							<!--
						<div id="popup-recently-calls" style="display:nones">
								<div style="display:inline-block; position:relative; background-color:#8cbf26; top:-5px;" >
								 <span class="ion-ios7-checkmark-outline" style="font-size:30px; color:#fff; display:inline-block; position:relative; padding-left:10px;"></span>
									
									<span style="margin:10px; color:#fff">This call list is recently wrapup on 12/12/2556 12:23 
									 </span>
								
								</div><div style="display:inline-block; position:relative;" class="triangle-right"></div>
						 </div>
						 -->
						</div>
						<div style="display:inline-block; position:relative; float:left;margin:10px 0;">

							<ul style="list-style:none; margin:0; padding:0" id="campaign-exapp">
								<li style="width:60px; text-align:center; border-radius:8px; color:#666; cursor:pointer; padding:2px 5px 2px 5px;"
									id="open-callscriptfull">
									<span class="icon-bullhorn" style="font-size:26px; "></span>
									<p style="font-size:12px; margin:0; padding:0"> CallScript </p>
								</li>


								<!-- 
			 			<li style="width:100px; text-align:center; border-radius:8px; color:#666; cursor:pointer; padding:2px 5px 2px 5px;" id="open-app1">
			 				<span class="icon-plus-sign-alt" style="font-size:26px; "></span> 
			 					 <a href="http://www.w3schools.com/" target="_blank" style="font-size:12px; display:block;  color:#666;">Gen Life 10/20</a>
			 				<p style="font-size:12px; margin:0; padding:0"> </p>
			 			</li>
			 			-->
							</ul>

						</div>
						<div style="display:inline-block; position:relative; float:right; top:5px;">
							<span id="popup-close" class="ion-ios-close-outline close-model"></span>
						</div>
						<div style="clear:both"></div>
					</div>

					<div id="popup-body">
						<div style="float:left; width:45%">
							<div style="width:100%;height:100%; padding-right:40px; ">
								<!-- 
			<h3 style="margin:0; padding:0; font-weight:200; text-indent:5px;" id="show-cmp"> Campaign Preview </h3>
			<span style="color:#676a6c; text-indent:6px; display:block" id="show-cmp-dtl"> Camapign Detail </span>
			<hr style="margin:5px 0;padding:0; border-top:1px dashed #aaa"/>
		 -->
								<h3 style="margin:0; padding:0; font-family:raleway; color:#777"> Campaign List Detail
								</h3>
								<hr style="margin:5px 0;padding:0; border-top:1px dashed #aaa" />
								<table id="cmpprofile-table" style="width:100%;">
									<thead>
										<!-- 
								<tr> 
									<td style="width:22%;color:#676a6c; vertical-align:top; position:relative;">
							
										<div style="display:inline-block; position:absolute;top:0;left:0; padding:6px; margin-top:5px;">
										<div id="salescript" data-status="show" style="float:left; position: relative; display:inline-block; border:1px solid #16a085; width:22px; height:22px; cursor:pointer; background-color:#16a085">
											<span class="ion-ios-checkmark-empty" style="font-size:36px; position:relative; top:-16px; left:4px; color:#fff"></span>
										</div>
										<div style="float:left;display:inline-block; color:#999; font-size:13px;padding:2px;">&nbsp;Call Script  </div> 
										</div>
										<div style="clear:left"></div>
									
									</td>
									<td style="width:88%">
										<div id="salescript-dtl">
											<textarea name="salescript" style="width:100%; height:80px; font-size:18px; border:1px dashed #fff;" readonly > </textarea>&nbsp;
										</div>
										</td>
								</tr>
								-->
									</thead>
									<tbody>
									</tbody>
								</table>

							</div>
						</div>
						<div style="float:right; width:55%">
							<div style="width:100%;height:100%; ">
								<!-- vertical menu -->
								<div style="float:left; width:10%; display:block; border:0px solid #000;">
									<ul style="display:block; margin:0; padding:0; list-style:none" id="popup-menu">
										<li id="makecall-click" class="popup-vertical-menu active"
											style="border-top:1px solid #E2E2E2;">
											<div class="ion-ios-telephone-outline"
												style="font-size:30px; font-weight:400"></div>
										</li>
										<li id="history-click" class="popup-vertical-menu">
											<div class="ion-ios-clock-outline" style="font-size:30px; font-weight:400">
											</div>
										</li>
										<!-- <li id="wrapup-click" class="popup-vertical-menu"><div class="ion-ios-list-outline" style="font-size:30px; font-weight:400"></div></li>-->
										<li id="wrapup-click" class="popup-vertical-menu">
											<div class="ion-ios-list-outline" style="font-size:30px; font-weight:400">
											</div>
										</li>
									</ul>
								</div>
								<!--  float right -->
								<div style="float:right; width:90%; display:block;border:0px solid #000;">
									<div class="panel panel-default " style="min-height:500px;">
										<div class="panel-heading" style="background-color:#ccc;">
											<div style="" id="panel-popup-header">
												<h3
													style="display:inline-block; margin:0; padding:0; font-family:raleway;  color:#666">
													Call Popup</h3>
											</div>
											<div style="display:none" id="panel-history-header">
												<h3
													style="display:inline-block; margin:0; padding:0; font-family:raleway; color:#666">
													Call History</h3>
											</div>
											<div style="display:none;" id="panel-wrapup-header">
												<h3
													style="display:inline-block; margin:0; padding:0; font-family:raleway;  color:#666">
													Call Wrapup</h3>
											</div>
											<div style="display:none;" id="panel-reminder-header">
												<h3
													style="display:inline-block; margin:0; padding:0; font-family:raleway;  color:#666">
													Reminder</h3>
											</div>
										</div>
										<div class="panel-body" id="call-box">
											<!--  make call  -->
											<div id="calllistmsg"
												style="width:100%; margin:2px; position:relative; background-color:#ed5565;border-radius: 4px; display:none">
												<span class="ion-ios7-information"
													style="font-size:32px; color:#fff; display:inline-block; text-indent: 5px; "></span>
												<span
													style=" font-family: 'lato'; font-size:16px; display:inline-block; top:-5px; position:relative; text-indent: 5px; color:#fff">
													This account is set to DO NOT call list </span>
											</div>
											<div style="color:#999">Make call...</div>
											<div style="float:left; width:80%;display:inline-block;">
												<ul id="calllistphone">
													<!-- 
							 	 <li id="test1">083-XXXX-5069</li>
							 	 <li style="background-color:#e2e2e2;">083-XXXX-5070</li>
							 	 <li id="test2">083-XXXX-5071</li>
							-->
												</ul>
											</div>
											<div style="float:right;width:20%; display:inline-block;">
												<div style="position:relative; text-align:center; ">
													<button id="makecall"
														style="-moz-border-radius: 50%;-webkit-border-radius: 50%;border-radius: 50%; height:50px; width:50px; background-color:#8bc34a;border:2px solid #8bc34a;">
														<span class="ion-ios-telephone"
															style="font-size:38px;display:block; color:#fff; top:-5px;position:relative"></span>
													</button>
													<button id="hangup"
														style="display:none;-moz-border-radius: 50%;-webkit-border-radius: 50%;border-radius: 50%; height:50px; width:50px; background-color:#e51c23;border:3px solid #e51c23;">
														<span class="ion-ios-telephone"
															style="text-indent:-1px; font-size:38px;display:block; color:#fff;  -ms-transform: rotate(134deg);  -webkit-transform: rotate(134deg); transform: rotate(134deg); top:-5px;position:relative"></span>
													</button>
												</div>
											</div>
											<div style="clear:both"></div>
										</div>

										<!--  call history -->
										<div class="panel-body" style="display:none" id="history-box">
											<div style="position:relative; text-align:right; font-size:14px;">

												<span
													style="font-family:raleway; font-size:14px; font-weight:400; color:#777">
													Total Call : </span><span
													style="padding:5px; background-color:#00bcd4; color:#fff; border-radius:3px;"
													id="call-history_total_popup_call"> 0</span>

												<!--
									<span >&nbsp;&nbsp;&nbsp;</span>
									<span style="font-family:raleway; font-size:14px; font-weight:400; color:#777"> Total Call Duration : </span><span style="padding:5px; background-color:#00bcd4; color:#fff; border-radius:3px;"> 0</span> 
								
								 <input type="text" placeholder="search name..." autocomplete="off" name="popup_history_search">
									<button class="btn" style="background-color: #16a085 ; color:#fff;  font-size:12px;  border-top-right-radius:3px; border-bottom-right-radius:3px;  height:34px;" id="popup_history_search-btn"> Search  </button>
									 -->
											</div>
											<table class="table table-bordered" style="margin-top:10px;"
												id="popup_history-table">
												<thead>
													<tr class="primary" style="color:#676a6c; font-size:12px;">
														<td class="text-center"> # </td>
														<td class="text-center"> Call Date/Time</td>
														<!--
												<td class="text-center"> Call Type </td>
												<td class="text-center"> Call Duration </td>
												-->
														<td class="text-center"> Last Wrapup </td>
														<td class="text-center"> Note</td>
													</tr>
												</thead>
												<tbody class="hover">
													<tr>
														<td class="text-center" style="color:#676a6c; font-size:12px;">
															1 </td>
														<td class="text-center" style="color:#676a6c; font-size:12px;">
															12/12/2557 12:12</td>
														<td class="text-center" style="color:#676a6c; font-size:12px;">
															0838045070</td>
														<td class="text-center" style="color:#676a6c; font-size:12px;">
															No Answer </td>
														<td class="text-center" style="color:#676a6c; font-size:12px;">
															3 Sec </td>
														<td class="text-center" style="color:#676a6c; font-size:12px;">
															Last Wrapup </td>
													</tr>
												</tbody>
												<tfoot>
												</tfoot>
											</table>
										</div>

										<!--  wrapup  -->
										<div class="panel-body"
											style="display:none; margin:0;padding:0;position:relative;top:-1px;  "
											id="wrapup-box">
											<div id="wrapup-require"
												style="width:100%; background-color:#e51c23; color:#fff; padding:2px 4px 2px 4px; font-size:12px; border-top:1px solid #ccc; display:none">
												Please fill in wrapup call with all (3)level of wrapup</div>
											<div id="wrapup-msg"
												style="width:100%; background-color:#8cbf26; color:#fff; padding:2px 4px 2px 4px; font-size:12px; border-top:1px solid #ccc; display:none">
												Wrapup has been saved </div>
											<!--  Wrapup :   Parameter  list-id  |  campaign-id  | agent-id  -->
											<div style=" padding:15px;">
												<table style="width:100%;" id="wrapup-table">
													<thead>
														<tr>
															<td style="text-align:center;vertical-align:middle"></td>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td colspan=2>
																<div class="step-app" id="step-wrapup">
																	<ul class="step-steps">
																		<li data-step-target="step1">Level 1</li>
																		<li data-step-target="step2">Level 2</li>
																		<li data-step-target="step3">Level 3</li>
																	</ul>
																	<div class="step-content">
																		<div class="step-tab-panel wrapup"
																			data-step="step1">
																			<ul id="wrapup1">
																			</ul>
																		</div>
																		<div class="step-tab-panel wrapup"
																			data-step="step2">
																			<ul id="wrapup2">
																			</ul>
																		</div>
																		<div class="step-tab-panel wrapup"
																			data-step="step3">
																			<ul id="wrapup3">
																			</ul>
																		</div>
																	</div>
																	<div class="step-footer">
																		<button data-step-action="prev"
																			class="step-btn">Previous</button>
																		<button data-step-action="next"
																			class="step-btn">Next</button>
																		<button data-step-action="finish"
																			class="step-btn">Finish</button>
																	</div>
																</div>
															</td>
														</tr>
														<!-- <tr>
								  				<td style="color:#666;text-align:right;width:16%;"> Wrapup 1  </td>
								  				<td>
										  				<input type="hidden" name="wrapup1">
										  				<div id="dd" class="drop wrapper-dropdown-5 " tabindex="1" >
																	<span>&nbsp;</span>
																	<ul class="dropdown" id="wrapup1">
																		<li></li>
																	</ul>
														</div>
								  				</td>
								  			</tr>
								  				<tr>
								  				<td style="color:#666;text-align:right"> Wrapup 2  </td>
								  				<td>
										  				<input type="hidden" name="wrapup2">
										  				<div id="dd" class="drop wrapper-dropdown-5 " tabindex="1">
														<span>&nbsp;</span>
																<ul class="dropdown"  id="wrapup2">
																	<li></li>
																</ul>
														</div>
								  				</td>
								  			</tr>
								  			<tr>
								  				<td style="color:#666;text-align:right"> Wrapup 3  </td>
								  				<td>
								  						<input type="hidden" name="wrapup3">
														<div id="dd" class="drop wrapper-dropdown-5 " tabindex="1">
														<span>&nbsp;</span>
																<ul class="dropdown"  id="wrapup3">
																	<li></li>
																</ul>
														</div>
								  				</td>
								  			</tr> -->
														<!--<tr>
															 <td
																style="color:#666;vertical-align:middle; text-align:right;">
																Transfer to survey
															</td> 
															<td>
																<button id="transfer"
																	style="-moz-border-radius: 50%;-webkit-border-radius: 50%;border-radius: 50%; height:50px; width:50px; background-color:#32c5d2;border:2px solid #32c5d2;">
																	<span class="ion-ios-arrow-forward"
																		style="font-size:25px;display:block; color:#fff; position:relative"></span>
																</button>
															</td>
														</tr>-->
														<tr>
															<td style="color:#666;vertical-align:middle; text-align:right;">
																Type of Voucher
															</td>
															<td>
																<select name="typeOfVoucher"></select>
															</td>
														</tr>
														<tr>
															<td style="color:#666;vertical-align:middle; text-align:right;">
																Voucher Value
															</td>
															<td>
																<select name="voucherValue"></select>
															</td>
														</tr>
														<tr>
															<td style="color:#666;vertical-align:middle; text-align:right;">
																Dont_call_ind
															</td>
															<td>
																<input name="Dont_call_ind" type="radio" value="1"> Yes
																<input name="Dont_call_ind" type="radio" value="0"> No
															</td>
														</tr>
														<tr>
															<td style="color:#666;vertical-align:middle; text-align:right;">
																Dont_SMS_ind
															</td>
															<td>
																<input name="Dont_SMS_ind" type="radio" value="1"> Yes
																<input name="Dont_SMS_ind" type="radio" value="0"> No
															</td>
														</tr>
														<tr>
															<td style="color:#666;vertical-align:middle; text-align:right;">
																Dont_email_ind
															</td>
															<td>
																<input name="Dont_email_ind" type="radio" value="1"> Yes
																<input name="Dont_email_ind" type="radio" value="0"> No
															</td>
														</tr>
														<tr>
															<td style="color:#666;vertical-align:middle; text-align:right;">
																Dont_Mail_ind
															</td>
															<td>
																<input name="Dont_Mail_ind" type="radio" value="1"> Yes
																<input name="Dont_Mail_ind" type="radio" value="0"> No
															</td>
														</tr>
														<tr>
															<td
																style="color:#666;vertical-align:middle; text-align:right;">
																Schedule Time
															</td>
															<td>
																<input type="text" name="schedule_time"
																	class="calendar_en" style="width:50%"
																	autocomplete="off" />
															</td>
														</tr>
														<tr>
															<td style="color:#666;vertical-align:top; text-align:right">
																Detail </td>
															<td>
																<textarea name="wrapupdtl"
																	style="width:100%; height:80px;"></textarea>
															</td>
														</tr>
														<tr>
															<td> &nbsp; </td>
															<td>
																<span><button class="btn btn-success save_wrapup"> Save
																	</button> </span>
																<!--  <span id="reminder-link" style="margin-left:18px; display:none; "><button class="btn btn-success" id="reminder-click">  Add to reminder </button>	</span>  -->
															</td>
														</tr>
													</tbody>
													<tfoot>
													</tfoot>
												</table>
												<!-- <button class="btn btn-primary new-app" > Create New Application</button> -->
												<!--  <h4> External Web app : <a href="" id="extweb" target="_blank"> External Web App</a></h4>  -->
											</div>
										</div>
										<!--  end wrapup -->

										<!--  reminder  -->
										<div class="panel-body"
											style="display:none; margin:0;padding:0;position:relative;top:-1px;  "
											id="reminder-box">
											<div id="reminder-msg"
												style="width:100%; background-color:#8cbf26; color:#fff; padding:2px 4px 2px 4px; font-size:12px; border-top:1px solid #ccc; display:none">
												Reminder has been saved </div>
											<!--  Wrapup :   Parameter  list-id  |  campaign-id  | agent-id  -->
											<div style=" padding:15px;">
												<table style="width:100%; ">
													<tr>
														<td style="width:86%"></td>
														<td style="width:14%;">
															<div class="onoffswitch">
																<input type="checkbox" name="pop_reminderStatus"
																	class="onoffswitch-checkbox" id="myonoffswitch1"
																	value="1" checked>
																<label class="onoffswitch-label" for="myonoffswitch1">
																	<span class="onoffswitch-inner"></span>
																	<span class="onoffswitch-switch"></span>
																</label>
															</div>
														</td>
													</tr>
												</table>

												<table style="width:100%; " id="wrapup-table">
													<tbody>
														<tr>
															<td style="color:#666;text-align:right;width:20%;"> Reminder
																On </td>
															<td style="width:80%;">
																<div class="drop wrapper-dropdown-5">
																	<span>&nbsp;</span>
																	<ul class="dropdown" id="reminder-on">
																		<li id=""><a href='#'>&nbsp;</a></li>
																		<li id="1"><a href='#'> 30 นาที </a></li>
																		<li id="2"><a href='#'> 45 นาที </a></li>
																		<li id="3"><a href='#'> 1 ชั่วโมง </a></li>
																		<li id="4"><a href='#'> 1 ชั่วโมง 30 นาที</a>
																		</li>
																		<li id="5"><a href='#'> 2 ชั่วโมง</a></li>
																		<li id="6"><a href='#'> 3 ชั่วโมง</a></li>
																		<li id="7"><a href='#'> 5 ชั่วโมง</a></li>
																		<li id="8"><a href='#'> 8 ชั่วโมง</a></li>
																		<li id="9"><a href='#'>เวลานี้
																				ของวันพรุ่งนี้</a></li>
																		<li id="10"><a href='#'>กำหนดเอง</a></li>
																	</ul>
																</div>
																<div>


																	<input type="hidden" name="pop_reminderOn">
																	<input type="hidden" name="pop_reminderid">
																	<!--  use after save for update -->

																	<input type="hidden" name="pop_reminderDtime">
																	<input type="hidden" name="pop_reminderHH">
																	<input type="hidden" name="pop_reminderMM">
																	<input type="hidden" name="pop_reminderDate">
																	<input type="hidden" name="pop_reminderMonth">
																	<input type="hidden" name="pop_reminderYear">

																	<input type="hidden" name="pop_reminderType">

																	<!--
											<div style="display:nones" id="reminder_custom">				
													<div  class="drop wrapper-dropdown-5 " style="width:20%;display:inline-block">
														<span>ปี</span>
																<ul class="dropdown"  id="reminder-on">
																	<li id="1"><a href='#'> 30 นาที </a></li>
																</ul>
													</div>
														<div class="drop wrapper-dropdown-5 "  style="width:58%;display:inline-block">
														<span>เดือน</span>
																<ul class="dropdown"  id="reminder-on">
																	<li id="1"><a href='#'> 30 นาที </a></li>
																</ul>
													</div>
														<div  class="drop wrapper-dropdown-5 "   style="width:20%;display:inline-block">
														<span>วัน</span>
																<ul class="dropdown"  id="reminder-on">
																	<li id="1"><a href='#'> 30 นาที </a></li>
																</ul>
													</div>
											
												<div  class="drop wrapper-dropdown-5 " style="width:50%;display:inline-block; margin-top: 5px;">
														<span>ชั่วโมง</span>
																<ul class="dropdown"  id="reminder-on">
																	<li id="1"><a href='#'> 01 </a></li>
																	<li id="2"><a href='#'> 02 </a></li>
																	<li id="3"><a href='#'> 03 </a></li>
																	<li id="4"><a href='#'> 04 </a></li>
																	<li id="5"><a href='#'> 05 </a></li>
																	<li id="6"><a href='#'> 06 </a></li>
																	<li id="7"><a href='#'> 07 </a></li>
																	<li id="8"><a href='#'> 08 </a></li>
																	<li id="9"><a href='#'> 09 </a></li>
																	<li id="10"><a href='#'> 10 </a></li>
																	<li id="11"><a href='#'> 11 </a></li>
																	<li id="12"><a href='#'> 12 </a></li>
																	<li id="13"><a href='#'> 13 </a></li>
																	<li id="13"><a href='#'> 14 </a></li>
																	<li id="13"><a href='#'> 15 </a></li>
																	<li id="13"><a href='#'> 16 </a></li>
																	<li id="13"><a href='#'> 17 </a></li>
																	<li id="13"><a href='#'> 18 </a></li>
																	<li id="13"><a href='#'> 19 </a></li>
																	<li id="13"><a href='#'> 20 </a></li>
																	<li id="13"><a href='#'> 21 </a></li>
																	<li id="13"><a href='#'> 22 </a></li>
																	<li id="13"><a href='#'> 23 </a></li>																											
																</ul>
													</div>
													<div class="drop wrapper-dropdown-5 " style="width:49%;display:inline-block;margin-top: 5px;">
														<span>นาที</span>
																<ul class="dropdown"  id="reminder-ons">
																	<li id="1"><a href='#'> 5 </a></li>
																	<li id="1"><a href='#'> 10 </a></li>
																	<li id="1"><a href='#'> 15 </a></li>
																	<li id="1"><a href='#'> 20 </a></li>
																	<li id="1"><a href='#'> 25 </a></li>
																	<li id="1"><a href='#'> 30 </a></li>
																	<li id="1"><a href='#'> 45 </a></li>
																	<li id="1"><a href='#'> 50 </a></li>
																</ul>
													</div>
											</div>
												 -->
																</div>
															</td>
														</tr>
														<tr>
															<td style="color:#666;text-align:right;width:20%;"> Category
															</td>
															<td>
																<div class="drop wrapper-dropdown-5">
																	<span>&nbsp;</span>
																	<ul class="dropdown" id="reminder-cat">
																		<li id=""><a href='#'>&nbsp;</a></li>
																		<li id="1"><a href='#'> Call Back </a></li>
																		<li id="2"><a href='#'> Followup </a></li>
																	</ul>
																</div>
															</td>
														</tr>
														<tr>
															<td style="color:#666;text-align:right;width:20%;"> Subject
															</td>
															<td>
																<input type="text" name="pop_reminderSubj"
																	style="width:100%" autocomplete="off">
															</td>
														</tr>
														<tr>
															<td
																style="color:#666;text-align:right;width:20%; vertical-align:top;">
																Detail </td>
															<td>
																<textarea style="width:100%;height:200px;"
																	name="pop_reminderDesc"></textarea>
															</td>
														</tr>
														<tr>
															<td> &nbsp; </td>
															<td>
																<span><button
																		class="btn btn-success save_reminder_onpopup">
																		Save </button> </span>
																<span id="wrapup-link"
																	style="margin-left:18px; display:none; "><button
																		class="btn btn-success" id="backto-wrapup"> Back
																		to wrapup </button> </span>
															</td>
														</tr>
													</tbody>
												</table>

											</div>

										</div><!--  end div reminder -->


									</div>
									<!--  end make call box -->

								</div>
								<!--  end float right -->
								<div style="clear:both"></div>
							</div>

						</div>
					</div>


				</div> <!--  end div row -->
			</div> <!--  end div container -->
		</div> <!--  end div popup -->


		<div id="profile-pane" class="content-overlay" style="display:none"></div>
		<!-- <div id="reminder-pane" class="content-overlay" style="display:none"></div> -->

	</form>
	<div class="softphone" >
		<a class="handle ui-slideouttab-handle-rounded">Phone <i class="io ion-ios-telephone"
				aria-hidden="true"></i></a>
		<iframe id="softphone" allow="camera *; microphone *; autoplay *"
			src="https://apps.mypurecloud.jp/crm/embeddableFramework.html"></iframe>
	</div>
	<div class="modal"></div>
</body>

</html>