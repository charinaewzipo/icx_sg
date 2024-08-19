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
<link href="css/smile-notify.css" rel="stylesheet">

<style>
   /* http://speckyboy.com/2012/02/15/how-to-build-a-stylish-css3-search-box/ */
   .cf:before, .cf:after{
    content:"";
    display:table;
	}
 
	.cf:after{
	    clear:both;
	}
	 
	.cf{
	    zoom:1;
	}    
	/* css reminder */
	 #reminder_count:hover{
	 	color: #ff0097;
	 }
	 
	 .fadeInDown{
		animation: fadeInDown 1s ease both;
		
	}    

	@keyframes fadeInDown {
		0% {
		    opacity: 0;
		    transform: translateY(-20px);
		}
		100% {
		    opacity: 1;
		    transform: translateY(10px);
		    visibility:visible;
		}
	}
	
 
	 /*used*/
	 .strip-onhover:hover{
			 background-color:#E2E2E2;
	 }
	 .online{
	 	border-radius:3px; 
	 	padding:1px 4px; 
	 	background-color:#8cbf26; 
	 	color:#fff; 
	 	font-size:12px;
	 }
	 .offline{
	 	border-radius:3px; 
	 	padding:1px 4px; 
	 	background-color:#7f8c8d; 
	 	color:#fff; 
	 	font-size:12px;
	 }
	 
	 .awall-normal{
	 	font-size:15px; 
	 	color:#666;
	 }
	 
	 
	 #awall-condition li{
	 	display: inline-block;
	 	cursor:pointer;
	 }
	 #awall-condition li.link:hover{
	 	text-decoration: underline;
	 }
	 #awall-condition li.active{
	 	color:#2196f3;
	 }

</style>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<!-- <script type="text/javascript" src="js/reminder.js"></script>  -->
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="js/jquery.easypiechart.min.js"></script>
<script type="text/javascript" src="js/jquery.animateNumber.min.js"></script>


<script>
 $(function(){

	
	$('#news-pane').load('news-pane.php' , function(){
  				$(this).fadeIn('fast');
	});
	

  /*
	$('#agentwall-pane').load('agentwall-pane.php',function(){
				$(this).fadeIn('fast');
	});
*/
//test
/*
	 $('#profile-pane').load('myprofile.php' , function(){
			$(this).fadeIn('fast');
			 $('#profile-pane').css({'height':(($(document).height()))+'px'});
	   			window.scrollTo(0, 0);
	 }); 
	 /**/ 

	//test
/*
	 $('#reminder-pane').load('reminder-pane.php' , function(){
			$(this).fadeIn('fast');
			 $('#reminder-pane').css({'height':(($(document).height()))+'px'});
	   			window.scrollTo(0, 0);
	 }); 
*/

/*
if($('[name=missing]').val()=="miss"){
	//console.log("found missing reminder from login");
	  $.reminder.missing_reminder();
}
*/

 //test 

 //livestat
	function livestat(){
		var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
		 $.ajax({   'url' : 'home_process.php', 
			        	   'data' : { 'action' : 'query' , 'data' : formtojson }, 
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
						   'beforeSend': function(){
							   //set image loading for waiting request
							   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
							},										
							'success' : function(data){ 
					                        var  result =  eval('(' + data + ')'); 
										    var $table = $('#callmonitor-table tbody'); 
											$table.find('tr').remove();
											var i=0;
											var txt = "";
											var size = result.callsts.length; 
											var tmp = "";
											if( result.callsts.result != "empty"){
											for( i ; i<size ; i++){ 
													 if( tmp != result.callsts[i].cmpid ){
														  tmp = result.callsts[i].cmpid
														   txt +=   '<tr><td style=" vertical-align:middle">'+result.callsts[i].cmpn+'</td>'+
																		'<td style="color:#666;text-align:center">New List</td>'+
																		'<td style="color:#666;text-align:center">No Contact</td>'+
																		'<td style="color:#666;text-align:center">Call Back</td>'+
																		'<td style="color:#666;text-align:center">Follow up</td>'+
																		'<td style="color:#666;text-align:center">Total List</td>'+
																		'</tr>';
													  }
													   txt +=   '<tr class="strip-onhover">'+
														 			'<td style=" vertical-align:middle">'+ 
														 				'<div style="display:inline-block; float:left; position:relative; "> <img class="avatar-title nav-agentwall" data-agent="'+result.callsts[i].aid+'"  data-cmp="'+result.callsts[i].cmpid+'" src="'+result.callsts[i].aimg+' "></div>'+
														 				'<div style="float:left; text-indent:15px;">'+
														 						'<span style="display:block">   '+result.callsts[i].aname+' &nbsp;</span>'+
														 						'<span style="display:block; color:#777;">  '+result.callsts[i].agroup+'  '+result.callsts[i].ateam+' &nbsp;</span>'+
														 					    '<span style="display:block"> <span class="'+result.callsts[i].isonline+'">'+result.callsts[i].isonline+'</span>  Ext.'+result.callsts[i].aext+' &nbsp; </span>'+
														 				'</div>'+
														 				'<div style="clear:both"></div>'+
														 			'</td>'+
														 			'<td style="vertical-align:middle; font-size:20px; font-family:lato;" class="text-center"> '+result.callsts[i].tnew+' </td>'+
														 			'<td style="vertical-align:middle; font-size:20px; font-family:lato" class="text-center"> '+result.callsts[i].tnoc+'</td>'+
														 			'<td style="vertical-align:middle; font-size:20px; font-family:lato" class="text-center">  '+result.callsts[i].tcallback+'</td>'+
														 			'<td style="vertical-align:middle; font-size:20px; font-family:lato" class="text-center">'+result.callsts[i].tfollow+'</td>'+
														 			'<td style="vertical-align:middle; font-size:20px; font-family:lato" class="text-center"> '+result.callsts[i].tcall+'</td>'+
														 		'</tr>';
															  }
													 $table.html( txt );

												   //overlay agent-wall
													 $('.nav-agentwall').click( function(){
														 	var aid = $(this).attr('data-agent');
														 	var cmp = $(this).attr('data-cmp');
															$('#agentwall-pane').load('agentwall-pane.php',{ 'aid': aid , 'cmp' : cmp },function(){
																$(this).fadeIn('fast');
															}); 
													});

													
													 
											}else{
											    var $table = $('#callmonitor-table tbody'); 
														$table.find('tr').remove();
														   txt +=   '<tr><td style="vertical-align:middle; text-align:center;color:#666" colspan="6"><i class="icon-info-sign"></i> No call list assigned to me </td></tr>';
														 $table.html( txt );
											}
											 
									 }   
								});//end ajax 
	}

	livestat();
	// if level is  supervisor or higher show realtime stat
	 if( parseInt($('[name=ulvl]').val()) != 1 ){
	//	setInterval(function(){	livestat(); }, 50000);
	 }


 })
 
 

</script>

<body>
<form>

<input type="hidden" name="appname" value="home">
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="uim" value="<?php echo $pfile['uimg']; ?>">
<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>">
<input type="hidden" name="ulvl" value="<?php echo $pfile['lv']; ?>">
<input type="hidden" name="missing" value="<?php echo $pfile['miss']; ?>">


<div class="navbar navbar-default navbar-fixed-top navbar-header" style="z-index:100;">  
	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul class="header-profile">
				<li style="text-align:center; vertical-align:middle;padding-right:2px;"> 	
					<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
						<span id="smartpanel-detail">
								<i class="icon-fire" ></i> <span style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">iCX </span>						
						</span>
					</span>
		 		</li>
				<li >
				<span style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;"> 
					<span id="show-name" class="header-user-profile">Ext <?php echo $pfile['uext']; ?></span>
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


<!--  wrapup all element -->
<div style="padding:0 20px;" >

  	<div style="float:left; display:inline-block">
		<h2 class="page-title" style="display:inline-block;font-family:raleway; color:#666666;">  Home  </h2>
		<div class="stack-subtitle" style="color:#777777;position:relative; top:-10px; text-indent:2px;"> Hello.</div>
	</div>
 <div style="clear:both"></div>
<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px ; padding:0px; margin:10px 0"> 

<!-- 
งานค้าง

agent |
Campaign | Current Call | Call Back | Follow up |   Report -> Average Talk time , Login Logout  
 -->
 
 <!-- 
 	 		<div style="width:50%; position:relative; border:1px solid #eee; display:table">
					<div style="position:relative; width:100%; border:1px solid #fff; ">
						<input type="text" name="ugender"  readonly style="width:inherit; border-right:0" placeholder="I am..." autocomplete="off" > 
					<div class="ion-ios7-arrow-down" id="box-w" style="  background-color:#fff; cursor:pointer; display:inline-block;  border-width:1px 1px 1px 0; border-style:solid; border-color: #e5e9ec; font-size:12px;  width:auto; padding:9px 9px 2px 9px; height:37px;line-height:15px;"></div>
					
						<div style="position:absolute; width:inherit">
							 	<ul style="list-style:none; background-color:#fff; margin:0; padding:0 ; border: 0 1px 0 1px solid #E2E2E2">
							 		<li style="padding:5px 15px 5px 15px;border-bottom:1px solid #E2E2E2"> Male </li>
							 		<li style="padding:5px 15px 5px 15px;border-bottom:1px solid #E2E2E2"> Female </li>
							 	</ul>
						</div>
						</div>		
			</div>   
  -->
<div>
	  			  
	<div style="display:inline-block; float:left; width:45%; border:0px solid #000;">
	 	<!--  start reminder -->
			<div id="news-pane"></div>
		<!--  end reminder -->
		
	<!-- 
	<div style="position:relative;">
									<input class="month" type="text" name=""  style="width:100%" placeholder="abc" autocomplete="off" >
											<div style="position:absolute;  border:1px solid #E2E2E2; width: 50%;   -moz-transform: translateX(50%) translateY(-50%); display:none">
													<ul style="list-style:none; margin:0; padding:0">
														<li style="border-bottom:1px solid #E2E2E2; padding:10px; background-color:#fff; color:#777;"> January </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> February </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> March</li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> April </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> May </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> June </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> July </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> August </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> September </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> October </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> November </li>
														<li style="border-bottom:1px solid #E2E2E2; padding:10px;background-color:#fff; color:#777;"> December </li>
													</ul>
											</div>
									</div>
		-->				
		<!-- 
		<table class="table table-border">
			<thead> 
				<tr>
					<td > <span class="ion-ios7-alarm-outline" style="font-size:20px; color:#666"> Reminder </span>  </td>
				</tr>
			</thead>			
			<tbody>
				
				<tr>
					<td  colspan="2"> 
									
									
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
				</tr>
			</tbody>
		</table>
		
	 
		<div style="display:inline; margin:0; padding:0  ">
		 	<div style="display:inline-block; border:0px solid #000;">
								<input type="text" name=""  class="spin" style="width:100%;display:inline; margin:0; padding:0" placeholder="abc" autocomplete="off">
				</div><div style="display:table-row; position:relative; top:-5px;">
								<div class="ion-ios7-arrow-up spinup"  style="display:; border:1px solid #E2E2E2; font-size:11px; width:14px; height:18px; top:-3px; margin:0; padding:0; position:relative; text-align:center;cursor:pointer"></div>
								<div class="ion-ios7-arrow-down spindown" style="display:;  border:1px solid #E2E2E2; font-size:11px; width:14px; height:19px;top:-3px; margin:0; padding:0; position:relative; text-align:center;cursor:pointer"></div>
			</div>	
	</div>
	-->
	
	</div>
	<!--  div right -->
	<div style="display:inline-block; float:right; width:54%; border:0px solid #000">
	
			<!-- 
			---- ทำ อันนี้ไปใส่ไว้ในหน้า home ของ agent  แต่ละคนได้ ----
ทำอย่างไรถึง sup ถึงจะรู้ว่าตอนนี้ call list ที่อยู่ในมือของ  agent คนนี้เป็นยังไง
โดยรวมทุก campaign , ทุก list

			Current Call work [ Sup | Agent ]
			
			if( sub not where agent_id = ) <br/>
			 -->
			<table class="table table-border" id="callmonitor-table">
				<thead>
					<tr>
						<td style="font-size:20px; color:#666" colspan="6">
							<i class="icon-bar-chart "></i> Call In Progress
						</td>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6">&nbsp;</td>
					</tr>
				</tfoot>
			</table>
			
		
			<!--  Reminder -->
			<!-- 
			<table class="table table-border">
			<thead> 
				<tr>
					<td > <span class="ion-ios7-alarm-outline" style="font-size:20px; color:#666"> Reminder </span>  </td>
				</tr>
			</thead>	
			<tbody>
				<tr>
					<td colspan="2">
					<ul class='remind-list dd'>
						<li  class='ch'>
					  			 <div style='padding:2px 15px; vertical-align:middle;  display:inline-block; font-size:30px; cursor:pointer' data-action='' class='ch ion-ios7-circle-outline circle-check' data-id=""></div>
					  			 <div style='vertical-align:middle; display:inline-block; margin: 2px 0px;'>
							  			<span style='display:block; font-size:20px; '><a  href='#' class='alink' style='font-family:raleway; color:#ff0097'>  Call Back </a> </span> 
							  			<span style='display:block;color:#777;font-size:15px;'>07/07/2557 12:12</span>
					  			 </div>
					  			  <div style='vertical-align:middle; display:inline-block; margin-left:25px;'>
					  			  
					  			     <div class="onoffswitch">
										    <input type="checkbox" name="onoffswitch2" class="onoffswitch-checkbox" id="myonoffswitch1">
										    <label class="onoffswitch-label" for="myonoffswitch1">
											    <span class="onoffswitch-inner"></span>
											    <span class="onoffswitch-switch"></span>
									   		 </label>
									    </div> 
					  			  </div>
					  		</li>
				  		<li  class='ch'>
					  			 <div style='padding:2px 15px; vertical-align:middle;  display:inline-block; font-size:30px; cursor:pointer' data-action='' class='ch ion-ios7-circle-outline circle-check' data-id=""></div>
					  			 <div style='vertical-align:middle; display:inline-block; margin: 2px 0px;'>
							  			<span style='display:block; font-size:20px; '><a  href='#' class='alink' style='font-family:raleway; color:#ff0097'>  Call Back </a> </span> 
							  			<span style='display:block;color:#777;font-size:15px;'>07/07/2557 12:12</span>
					  			 </div>
					  			  <div style='vertical-align:middle; display:inline-block; margin-left:25px;'>
					  			  
					  			     <div class="onoffswitch">
										    <input type="checkbox" name="onoffswitch1" class="onoffswitch-checkbox" id="myonoffswitch2" >
										    <label class="onoffswitch-label" for="myonoffswitch2">
											    <span class="onoffswitch-inner"></span>
											    <span class="onoffswitch-switch"></span>
									   		 </label>
									    </div> 
									    
					  			   
					  			  </div>
					  		</li>
				  	</ul>
				
					</td>
				</tr>
			</tbody>
		</table>
			-->
			
	</div>
	<!--  end div right -->
	<div style="clear:both"></div>

	
	<!-- 
	<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px ; padding:0px; margin:10px 0"> 
	<div style="position:relative; color:#777; left:50%">
	  user Quote :
		The BEST or NOTHING
	</div>
	
	<div class="blockquote">
		<p> TEST </p>
	</div>
	 -->
</div>

</div>

 
<!-- 
		ใช้ effect นี้ 
		https://github.com/pea/wankyPages
		  <h3 style="font-family:'kunlasatri';">รอยยิ้มทำให้โลกน่าอยู่มากขึ้น </h3>
		  	<div style="width:100px; height:100px; border-radius:50%; color:#888; position:absolute; left:20px; border:2px solid #888"> Start </div>
		  introduce <br/>
		  setup profile <br/>
		  ขอบคุณ thanks you <br/>
		  ยิ้มหน่อยนะให้ 5 บาท ยิ้มมากมากให้บาทเดียว  <br/>
		  <br/><br/>
		   -->

 <!-- <div id="smile-pane" ></div> -->
 
  <div id="agentwall-pane" ></div>
 <div id="news-pane" class="content-overlay" style="display:none"></div>
<div id="profile-pane" class="content-overlay" style="display:none"></div>
<!-- <div id="reminder-pane" class="content-overlay" style="display:none"></div> -->
<div  id="reminder-popup" class="ns-box shadow" style="display:none">

	<!-- 
    <div class="ns-box-inner">
    <div class="ns-thumb" style="display:none"></div>
  	  <div class="ns-content">
  			<div style=" float:left; margin-left:0px; padding-right:8px;  display:inline-block; font-family:roboto; font-weight:600; text-align:center; ">
  					<h3 style="margin:0;padding:0; font-weight:300; padding:2px">Today </h3>
  					<h3 style="margin:0;padding:0; font-weight:400" id="retime">21:30</h3>
  	  		</div>
  	  		<div style=" padding-left:8px; margin-right:12px; display:inline-block; border-left:1px solid rgba(255,255,255,0.55);  ">
  	  			<span style="display:block; font-family:roboto; font-weight:400; font-size:18px;" id="rcat">Call Back</span>
        	    <span style="display:block; font-family:roboto; font-weight:400; font-size:12px;"><a href="#" style="color:#fff" id="rsub"> ติดต่อกลับ คุณคิม</a></span>
        	    <span style="display:block; font-family:roboto; font-weight:400; font-size:12px;" id="rdetail"> โทรกลับไปด่าคุณคิม เขียนโค้ดยังไง ปัญญาอ่อนมาก </span>
  	  		</div>
  	  		<div style="clear:both"></div>
  	  </div>
    </div>
    <span class="ns-close"></span>
    -->
</div> 

<!-- 
<div  id="reminder-popup" class="ns-box shadow" style="display:none">
    <div class="ns-box-inner">
    <div class="ns-thumb" style="display:none"></div>
  	  <div class="ns-content">
  			<div style=" float:left; margin-left:0px; padding-right:8px;  display:inline-block; font-family:roboto; font-weight:600; text-align:center; ">
  				
  				<span class="ion-ios7-alarm-outline" style="font-size:46px; padding:0 6px; "></span> 
  	  		</div>
  	  		<div style=" padding-left:8px; margin-right:12px; display:inline-block; border-left:1px solid rgba(255,255,255,0.55);  ">
  	  			<span style="display:block; font-family:roboto; font-weight:400; font-size:18px;" id="rcat">You miss 2 reminder</span>
        	    <span style="display:block; font-family:roboto; font-weight:400; font-size:12px;">Your last reminder is on 22 Jan 2014</span>
        	    <span style="display:block; font-family:roboto; font-weight:400; font-size:12px;" id="rdetail"><a href="#" style="color:#fff" id="rsub"> click here</a> for detail  </span>
  	  		</div>
  	  		<div style="clear:both"></div>
  	  </div>
    </div>
    <span class="ns-close"></span>
</div> 

 -->


<!-- 
<div class="ns-box1 ns-show shadow" style="display:none" id="reminder-popupd">
    <div class="ns-box-inner">
        <p>This is a chat  Hello World  Hi How alsdkfjlsdfkjsldfkj lsdkjfsldfjlsdkjfklsdj message</p>
    </div>
    <span class="ns-close"></span>
</div> 
-->

</form>
</body>

<script>
 

</script>
</html>