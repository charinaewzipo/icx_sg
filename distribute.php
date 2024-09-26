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

.strip-line tr:hover{
	cursor:pointer;
	background-color:#E2E2E2;
}

.ul-result{
	border-top:8px solid #ccc;
	list-style:none;
	margin:0;
	padding:0;
}
.ul-result li{
	padding:10px 10px 15px 10px;
	border-bottom:1px dashed #E2E2E2;
	background-color:#fff;
	
}
/*
.avatar-title{
 	border-radius: 50%;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
	width:55px;
	height:55px;
	padding:10px;
	border:1px solid #fff;
	background:#fff;
	cursor:pointer;
	position:relative;
}
*/


/* campaign list */
#cmp-list li{
	/* background-color:#eef9f8; */
		background-color:#F2F2F2;
}
#cmp-list li:hover{ 
	background-color:#D2D2D2;
	cursor:pointer;
}

#revoke-search thead tr td{
 border-top:0;
}
/*
.ui-slider .ui-slider-handle { position: absolute; z-index: 2; width: 1.2em; height: 1.2em; cursor: default; }
*/

.ul-no-order{
	list-style:none;
}


.strip-onhover:hover{
	cursor:pointer;
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
	 
	 #transfer-menu{
	 	list-style:none;
	 	margin:0;
	 	padding:0;
	 }
	 
	 #transfer-menu li{
	 	display:inline-block;
	 	vertical-align:top;

	 }
	 
	

</style>
 
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/distribute.js"></script>
<!-- <script type="text/javascript" src="js/reminder.js"></script> -->
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
<script>
  $(function(){

	  	$.dst.init();

		$('#select_source_lead').click( function(e){
 			e.preventDefault();

 			//main step panel
 			$('#main-step1').hide();
 			$('#main-step2').fadeIn('slow');
 			 
 			$('#agentsource-pane').hide();
			$('#leadsource-pane').fadeIn('slow');
		
			$('.transferlead').show(); 	//show button
			$('.transferagent').hide(); //hide button
			//clear current value
			$('[name=leadsource_campaign]').val('');
			$('[name=leadsource_list]').val('');
			$('[name=leadsource_team]').val('');

			//set transfer type to 1
			$('[name=transfer_type]').val('1');
			
 	 	});

 		$('#select_source_agent').click( function(e){
 			e.preventDefault();

 			//main step panel
 			$('#main-step1').hide();
 			$('#main-step2').fadeIn('slow');

 			
 			$('#leadsource-pane').hide();
			$('#agentsource-pane').fadeIn('slow');
			
			$('.transferagent').show(); 	//show button
			$('.transferlead').hide(); //hide button

			//set transfer type to 2
			$('[name=transfer_type]').val('2');
			
 	 	});

 	 	
		  //check level first
			var lv = parseInt($('[name=ulvl]').val());
			switch(lv){
					case 1 : //agent 
								  //denied
								 break; 
					case 2 : //supervisor 
								$('#select_source_agent').trigger('click');
								 break;
					case 3 : //qcqa
								  //denied
								 break;
					case 4 : //manager 
								break;
					case 5 :  //project maanger
									break;
					case 6 : //admin
									break;
			}


		//select campaign on left
 		$('[name=leadsource_campaign]').change( function(){
			 	var self = $(this);
			 	$.dst.lead_getlist( self.val() );
		 });
		 
		//select lead on left	  
 		$('[name=leadsource_list]').change( function(){
		 	var self = $(this);

			//check transfer type
			switch( parseInt($('[name=transfer_type]').val()) ){
				case 1 :   	//from db to agent
									if( self.val() != "" ){
										$('#leadsource-name-title').show();
										$('#leadsource-name').text('').text( $('[name=leadsource_list] :selected').text() );
									 }else{
										$('#leadsource-name-title').hide();
										$('#leadsource-name').text('');
									}
									$.dst.lead_gettotallist( self.val() );
							   break;
				case 2 : 		//from agent to agent
									// pm , admin [ select : group , team ]
							 		// man [ select : team ]
							 		 // sup [ ]
									 if( $('[name=ulvl]').val() == 2 ){
										 $.dst.agentworking_list();
									 }else{
												var fromteam =  $('[name=agentssource_fromteam]').val();
												if( fromteam != "" ){
													$.dst.agentsource_fromteam_select( fromteam );
												}
												var toteam =  $('[name=agentssource_toteam]').val() 
												if( toteam != "" ){
													 $.dst.agentsource_toteam_select( toteam );
												}
									}
								break;
			}
		
			
	 });//end select list

 		//mange from table
		$('#agentsource-fromagent-table thead tr').on('click','td', function(){
			var self =$(this);
			var totable = $('#agentsource-toagent-table thead tr');
			 
			var id = self.attr('data-transferid'); 
			if( id != undefined ){
				//remove other class check
				self.parent().children().find('i').removeClass('icon-ok-circle').addClass('icon-circle-blank');
				self.find('i').removeClass('icon-circle-blank').addClass('icon-ok-circle');

				//hight all column
				$.dst.transferstatus_selected(id);
				 
				//to-table
				 totable.parent().children().find('i').removeClass('icon-circle-arrow-down').addClass('icon-circle-blank'); 
				 $('#agentsource-toagent-table thead tr :nth-child('+id+')').find('i').removeClass('icon-circle-blank').addClass('icon-circle-arrow-down');
				//console.log( 	 $('#agentsource-toagent-table thead tr :nth-child(1)') );
				
				//;
				//totable.find('i').removeClass('icon-circle-blank').addClass('icon-circle-arrow-down');
				//hide all column
				/*
				$('.col2,.col3,.col4,.col5').hide();
				switch( parseInt(id) ){
					case 2 : $('.col2').show(); break;
					case 3 : $('.col3').show(); break;
					case 4 : $('.col4').show(); break;
					case 5 : $('.col5').show(); break;
				}
				*/
			}

	});

	 //input transfer amount
		$('[name=transfer_amount]').keyup(function() {
	  	 	if(/[^0-9]/g.test(this.value)){
		  		this.value = this.value.replace(/[^0-9]/g,'')
		  	 } 
			  self = $(this);
			  var max = parseInt($('[name=transfer_max_amount]').val());
			  if( parseInt(self.val()) > max ){
				  self.val( max );
			  }
	  })


	//submit agent transfer
		$('.transferagent').click( function(e){
				e.preventDefault();
				//check
				
				if( $('[name=transfer_source]').val() == "" &&  $('[name=transfer_source]').val() == 0 ){
						alert("กรุณาระบุจำนวนลีสต้นทาง");
						$('[name=transfer_source]').focus();
						return;
				}
				
				if( $('[name=transfer_amount]').val() == "" && $('[name=transfer_amount]').val() == 0  ){
					alert("กรุณาระบุจำนวนลีสที่ต้องการแจก/ต่อคน");
					$('[name=transfer_amount]').focus();
					return;
				}

				$.dst.agent_transferprocess();
			});

		//select all from agent
		$('[name=selectall_fromagent]').click( function(){
			var self = $(this);
			if( self.is(':checked')){
				
						var target = $('[name=transfer_fromagent]');
						var tr = target.parent().closest('tr');
						if( target.is(':checked') ){
						    	target.prop('checked', this.checked);  
							 	tr.addClass("selected-row");
						}else{
							target.prop('checked', this.checked);  
							tr.addClass("selected-row");
						}
						//recalculate total list transfer
						$.dst.cal_agenttransfer();
			}else{
				var target = $('[name=transfer_fromagent]');
				var tr = target.parent().closest('tr');
				if( target.is(':checked') ){
						target.removeAttr('checked');
					 	tr.removeClass("selected-row");
				}
				//recalculate total list transfer
				$.dst.cal_agenttransfer();
			}
		});

		//select all to agent
		$('[name=selectall_toagent]').click( function(){
			var self = $(this);
			if( self.is(':checked')){
				
						var target = $('[name=transfer_toagent]');
						var tr = target.parent().closest('tr');
						if( target.is(':checked') ){
						    	target.prop('checked', this.checked);  
							 	tr.addClass("selected-row");
						}else{
							target.prop('checked', this.checked);  
							tr.addClass("selected-row");
						}
						//recalculate total list transfer
						$.dst.cal_agenttransfer();
			}else{
				var target = $('[name=transfer_toagent]');
				var tr = target.parent().closest('tr');
				if( target.is(':checked') ){
						target.removeAttr('checked');
					 	tr.removeClass("selected-row");
				}
				//recalculate total list transfer
				$.dst.cal_agenttransfer();
			}
		});


		//select all lead to agent
		$('[name=selectalllead_transfer_toagent]').click( function(){
				var self = $(this);
				if( self.is(':checked')){
				
							var target = $('[name=lead_transfer_toagent]');
							var tr = target.parent().closest('tr');
							if( target.is(':checked') ){
							    	target.prop('checked', this.checked);  
								 	tr.addClass("selected-row");
							}else{
								target.prop('checked', this.checked);  
								tr.addClass("selected-row");
							}
							//recalculate total list transfer
							$.dst.cal_leadtransfer();
				}else{
					var target = $('[name=lead_transfer_toagent]');
					var tr = target.parent().closest('tr');
					if( target.is(':checked') ){
							target.removeAttr('checked');
						 	tr.removeClass("selected-row");
					}
					//recalculate total list transfer
					$.dst.cal_leadtransfer();
				}
		});

		//select from group
		$('[name=agentssource_fromgroup]').change( function(){
			var self = $(this); 
			$.dst.showteam( self.val() , "agent_fromteam" );
		});

		//select from team
		$('[name=agentssource_fromteam]').change( function(){
			var self =$(this);
			$.dst.agentsource_fromteam_select( self.val() );
		});

		//select to group
		$('[name=agentssource_togroup]').change( function(){
			var self = $(this);
			$.dst.showteam( self.val() , "agent_toteam" );
		});
		
		//	select to team
		$('[name=agentssource_toteam]').change( function(){
			var self =$(this);
			 $.dst.agentsource_toteam_select( self.val() );
		});


		//db to agent
			//select group
			$('[name=leadsource_togroup]').change( function(){
					var self = $(this);
					$.dst.showteam( self.val() , "lead_toteam" );
			});

			//select team
			$('[name=leadsource_toteam]').change( function(){
					var self =$(this);
					$.dst.leadsource_team_select( self.val() );
			}); 
			
			//submit lead transfer
			$('.transferlead').click( function(e){
				e.preventDefault();
				
				//check
				if( $('[name=transfer_amount]').val() == "" && $('[name=transfer_amount]').val() == 0  ){
					alert("กรุณาระบุจำนวนลีสที่ต้องการแจก/ต่อคน");
					$('[name=transfer_amount]').focus();
					return;
				}
				$.dst.lead_transferprocess();
			});
				
		$('#distribute-back-main').click( function(){
			location.reload();
		});
	
});
</script>

<body>
<form>
<input type="hidden" name="appname" value="listmgm">
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="ulvl" value="<?php echo $pfile['lv']; ?>">
<input type="hidden" name="uteamid" > <!--  teamid -->
<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>">

<input type="hidden" name="transfer_type" > <!--  1 from db-to-agent | 2 from agent-to-agent -->

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
	<!--  panel main step1 -->
	<div style="" id="main-step1">
			<div style="float:left; display:inline-block">
				<h2 style="display:inline-block;font-family:raleway; color:#666666; ">  Manage List </h2>
				<div id="page-subtitle" data-page="diallist" style="font-family:raleway;color:#777777;position:relative; top:-10px; text-indent:2px;"> Manage Call List </div>
			</div>
			<div style="clear:both"></div>
			<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px"> 
	
			<h4 style="font-family:raleway; color:#555;"> Step1 : Select Transfer Type</h4>
			<p style="margin:0; padding:0;color:#777; line-height:10px; font-size:14px;">  </p>
			<div style="float:left;width:50%; border-right:1px dashed #666; text-align:right;">
				<div style="padding:0 25px">
						<h2 style="font-family:raleway; color:#666; margin-bottom:0;">Assign List </h2>
						<h4>Transfer list from lead sorce to agent </h4> <br/>
						<button class="btn btn-primary transfer_source-btn" id="select_source_lead"> Lead Source </button>
				</div>
			</div>
			<div style="float:right;width:50%; text-align:left">
					<div style="padding:0 25px">
							<h2 style="font-family:raleway; color:#666;"> Transfer List</h2>
							<h4> Transfer list from agent to agent </h4> 	<br/>
							<button class="btn btn-primary transfer_source-btn agent-btn" id="select_source_agent" > Agent Source </button>
					</div>
			</div>
			
	</div>
	<div style="clear:both"></div>
	<!--  end panel main step1 -->
	
	<!--  panel main step 2 -->
	<div style="float:left; width:100%; display:none; margin-bottom:100px;" id="main-step2">
	 
			<div style="position:relative;">
						<div id="distribute-back-main" style="float:left; display:inline-block;cursor:pointer; position:relative; margin-top:22px;">
							<i style="color:#666;  "class="icon-circle-arrow-left icon-3x" ></i>
						</div>
						<div  style="display:inline-block; float:left; margin-left:5px;">
							 <h2 style="font-family:raleway; color:#666666;  margin-bottom:0; padding:0"> Manage List </h2>
						 	<div class="stack-subtitle" style="color:#777777; ">Transfer list from lead sorce to agent</div>
						</div> 
					<div style="clear:both"></div>
			</div>
		 <hr style="border-bottom: 1px dashed #999999; position:relative; "/>
		 
 			<h4 style="font-family:raleway; color:#666;"> Step 2: Transfer List</h4>
				<p style="margin:0; padding:0;color:#777; line-height:10px; font-size:14px;">  </p>
			<br/>
		
			<div ></div>
			  <!--  start wrapper -->
					<div style="float:left; width:100%; background-color:#fff; padding-bottom:15px; ">
					
						<div style="padding:15px;">
							<div style="width:100%; background-color:#e2e2e2; padding:10px 15px; float:left;">
								<div style="display:inline-block; float:left;">
									<table style="width:100%;">
										<thead>
											<tr>
												<td class="text-right" > Campaign Name : </td>
												<td > &nbsp;&nbsp; <select name="leadsource_campaign" style="width:250px; height:30px;"></select>  </td>
											</tr>
											<tr>
												<td class="text-right">  Lead Name : </td>
												<td> &nbsp;&nbsp;  <select name="leadsource_list" style="width:250px; height:30px;"></select>  </td>
											</tr>
											
										</thead>
									</table>
								</div>
								 
								<input type="hidden" name="selected_agent"> 
								<input type="hidden" name="transfer_source"> 
								<input type="hidden" name="transfer_max_amount" >
								
								<div style="display:inline-block;  text-align:right; width:60%; float:right; ">
											<ul id="transfer-menu" >
												<li> 
													<div style="color:#777">Total Selected Lead </div>
													<div style="color:#777"></div>
													<div style="font-size:26px; padding:4px 0; border-bottom:1px solid #666; text-align:right" id="total_trasfer_lead"> 0 </div>
												</li>
												<li style="margin-left:30px;"> 
													<div style="color:#777">Max Transfer Lead Per Agent </div>
													<div style="color:#777"></div>
													<div style="font-size:26px; padding:4px 0; border-bottom:1px solid #666; text-align:right;" id="max_transfer_lead"> 0 </div>
												</li>
													<li style="margin-left:40px;"> 
													<div style="color:#777">Transfer Lead Per Agent </div>
													<div style="color:#777"></div>
													<div style="font-size:26px; padding:4px 0; border-bottom:1px solid #666;"><input type="text" name="transfer_amount" autocomplete="off" style="text-align:right;"> </div>
												</li>
												
												<li style="margin-left:30px; vertical-align:bottom;"> 
													<div style="padding:10px 0; text-align:right;"> 
											  				<button class="btn btn-success transferlead" style="display:none;">
														  	 Transfer <i class="icon-arrow-right"></i> 
														  	 </button>
															<button class="btn btn-success transferagent" style="display:none;"> 
															Transfer <i class="icon-arrow-right"></i>  
															</button>
													 </div>
												</li>
											</ul>
									</div>
							</div>
							<div style="clear:both"></div>
												
					</div>
						
					
					<!--  start lead source -->
					<div style="display:none; padding:0 18px;" id="leadsource-pane">
						<div style="float:left; width:49%; background-color:#f2f2f2; padding:20px; border-radius:4px; padding-bottom: 55px;">
							
									<div style="width:100%;height:100%; display:nones" id="source_lead_detail">
													<h3 style="margin-bottom:90px;"> Step1 :   Source Transfer</h3>
													<hr style="border-bottom: 1px dashed #aaa; position:relative;"/> 
									</div>
									
										<ul style="margin:0; padding:0; list-style:none">
											<li style="width:100%;">
												<div style="display:inline-block; width:75%; float:left;">
														<i class="icon-list-alt" style="font-size:80px; color:#777; float:left;"></i> 
														<span style="margin-left:15px; position:relative; top:15px; display:none; color:#666" id="leadsource-name-title" > Lead Source Name </span><br/>
														<span style="margin-left:15px; position:relative; top:15px; font-size:18px;" id="leadsource-name"> </span>
												</div>
												<div style="display:inline-block; height:90px; width:25%; float:right; text-align:center; background-color: rgba(0,0,0,0.1); border-radius:3px" >
															<span style="font-size:40px; color:#2196f3" id="newlist-db"> 0 </span>
															<div >  New List </div> 
												</div>	
												<div style="clear:both"></div>
											</li>
										</ul>
						</div>
						
						<div style="float:right; width:49%; background-color:#f2f2f2; padding:20px; border-radius:4px;">
							 <h3> Step2 :  Select Destinations</h3>
								<!--  agent transfer to  -->
								    	<?php 
						    			 	  $lvl = $_SESSION["pfile"]["lv"];
						    			      if(  $lvl == 5 || $lvl==6 ){
						    			?>
								   			  To Group&nbsp;: &nbsp;<select name="leadsource_togroup" style="width:250px; height:30px;"></select> </br>
										<?php 
						    			     	}
											  if( $lvl == 4 || $lvl == 5 || $lvl==6  ){
										?>
											   	To Team &nbsp;:  &nbsp;<select name="leadsource_toteam" style="width:250px; height:30px;"></select>
										<?php  } ?>
										
									<hr style="border-bottom: 1px dashed #aaa; position:relative;"/> 	
									
									<div style="text-align:right; float:right;">
								  	Agent <div style="padding:2px 4px; display:inline-block;" id="leadagent_selecting-total"> 0 </div> / <div style="padding:2px 4px; display:inline-block;" id="leadagent_selected-total"> 0 </div> 
								  </div>
								  
									<table class="table table-border" id="leadsource_team-table">
									<thead>
										  <tr style="height:80px;">
										  		<td style="vertical-align:middle; cursor:pointer; vertical-align:bottom;  width:32%;">
										  		 	<span  id="show_selectall-lead_transfer_toagent" style="display:none"><input type="checkbox" value="all" name="selectalllead_transfer_toagent" style="width:20px;height:20px;"> Select All</span>
										  		</td>
												<td style="background-color: rgba(1,1,1, 0.05);color:#8bc34a;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%;" data-transferid="2" >
														<i class="icon-circle-arrow-down" style="font-size:30px; position:relative; top:-10px;"></i>
												<br/>New List
												</td>
												<td style="color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:16%;"  data-transferid="3">
														<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px; visibility:hidden"></i>
													<br/>No Contact
												</td>
												<td style="color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%;" data-transferid="4">
														<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px; visibility:hidden"></i>
													<br/>Call Back
												</td>
												<td style="color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%;" data-transferid="5">
													<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px; visibility:hidden"></i>
													<br/>Follow up
												</td>
												<td style="color:#aaa;text-align:center; vertical-align:bottom; ">Total </td>
											</tr>
											
									</thead>
									<tbody>
									</tbody>
						</table>
						
						
						</div>
					</div>
					<!--  end lead source -->
				
					<!--  start agent source -->
					<div style="display:none; padding:0 18px;" id="agentsource-pane">
					
						   <div style="float:left; width:49%; background-color:#f2f2f2; padding:20px; ">
								<input type="hidden"  name="transfer_liststatus">
							
								   <h3> Step1 :  Select Source</h3> 
								     	<?php 
						    			 	  $lvl = $_SESSION["pfile"]["lv"];
						    			      if(  $lvl == 5 || $lvl==6 ){
						    			?>
						    				  From Group&nbsp;: &nbsp;<select name="agentssource_fromgroup" style="width:250px; height:30px;"></select> </br>
										<?php 
						    			     	}
											  if( $lvl == 4 || $lvl == 5 || $lvl==6  ){
										?>
											  From Team &nbsp;:  &nbsp;<select name="agentssource_fromteam" style="width:250px; height:30px;"></select>
										<?php  } ?>
								  <hr style="border-bottom: 1px dashed #aaa; position:relative;"/>
							
								  <div style="text-align:right; float:right;">
								  	Agent <div style="padding:2px 4px; display:inline-block;" id="fromagent_selecting-total"> 0 </div> / <div style="padding:2px 4px; display:inline-block;" id="fromagent_selected-total"> 0 </div> 
								  </div>
						   
								  	<table class="table table-border" id="agentsource-fromagent-table" style="border:0px solid #000; width:100%; margin-top:10px;"> 
										<thead>
										  <tr style="height:80px;">
										  		<td style="border-bottom:1px solid #888; margin:4px 1px; padding:4px 1px; vertical-align:middle; cursor:pointer; vertical-align:bottom;  width:32%;">
										  		 	<span id="show_selectall-fromagent" style="display:none"><input type="checkbox" value="all" name="selectall_fromagent" style="width:20px;height:20px;"> Select All</span>
										  		</td>
												<td style="border-bottom:1px solid #888;margin:4px 1px; padding:4px 1px; color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%;" data-transferid="2" >
														<i class="icon-ok-circle" style="font-size:30px; position:relative; top:-10px;"></i>
												<br/>New List
												</td>
												<td style="border-bottom:1px solid #888;margin:4px 1px; padding:4px 1px; color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:16%;"  data-transferid="3">
														<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px;"></i>
													<br/>No Contact
												</td>
												<td style="border-bottom:1px solid #888;margin:4px 1px; padding:4px 1px; color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%;" data-transferid="4">
														<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px;"></i>
													<br/>Call Back
												</td>
												<td style="border-bottom:1px solid #888;margin:4px 1px; padding:4px 1px; color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%;" data-transferid="5">
													<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px;"></i>
													<br/>Follow up
												</td>
												<td style="border-bottom:1px solid #888;margin:4px 1px; padding:4px 1px; color:#aaa;text-align:center; vertical-align:bottom; ">Total </td>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
							</div>
							<div style="float:right; width:49%; padding:20px; background-color:#f2f2f2; ">
							   		<h3> Step2 :  Select Destination</h3>
							   		   <?php 
						    			 	  $lvl = $_SESSION["pfile"]["lv"];
						    			      if(  $lvl == 5 || $lvl==6 ){
						    			?>
											To Group&nbsp;: &nbsp;<select name="agentssource_togroup" style="width:250px; height:30px;"></select> </br>
										<?php 
						    			     	}
											  if( $lvl == 4 || $lvl == 5 || $lvl==6  ){
										?>
											   	To Team &nbsp;:  &nbsp;<select name="agentssource_toteam" style="width:250px; height:30px;"></select>				
										<?php  } ?>
										
									  <hr style="border-bottom: 1px dashed #aaa; position:relative;"/>
									   <div style="text-align:right; float:right;">
									  	Agent <div style="padding:2px 4px; display:inline-block;" id="toagent_selecting-total"> 0 </div> / <div style="padding:2px 4px; display:inline-block;" id="toagent_selected-total"> 0 </div> 
										</div>
									<table class="table table-border" id="agentsource-toagent-table" style="border:0px solid #000; width:100%; margin-top:10px;">
										<thead>
											  <tr style="height:80px;">
											  		<td style="border-bottom:1px solid #888;vertical-align:middle; cursor:pointer; vertical-align:bottom; width:32%;"><!-- 
											  				 --><span id="show_selectall-toagent" style="display:none"><input type='checkbox' name='selectall_toagent' value='all' style="width:20px;height:20px;"> Select All</span> 
											  		</td>
											  		<td style="border-bottom:1px solid #888;color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%;" data-trasnferid="2" class="col2" >
															<i class="icon-circle-arrow-down" style="font-size:30px; position:relative; top:-10px;"></i>
															<br/>New List
													</td>
													 <td style="border-bottom:1px solid #888; color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:16%;" data-trasnferid="3" class="col3" >
																<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px;"></i>
															<br/>No Contact 
													</td>
													 <td style="border-bottom:1px solid #888; color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%; " data-trasnferid="4" class="col4" >
															<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px;"></i>
															<br/>Call Back 
													</td>
													 <td style="border-bottom:1px solid #888; color:#aaa;text-align:center;cursor:pointer; border-radius: 4px; vertical-align:bottom; width:14%;" data-trasnferid="5" class="col5" >
														<i class="icon-circle-blank" style="font-size:30px; position:relative; top:-10px;"></i>
															<br/>Follow up 
													</td>
													<td style="border-bottom:1px solid #888; color:#aaa;text-align:center; vertical-align:bottom; ">Total </td>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
							</div>
							<div style="clear:both"></div>
					</div>
					<!--  end agent source -->
					
				</div>
				<!-- end wrapper -->
			
			
	</div>

</div>

<div id="profile-pane" class="content-overlay" style="display:none"></div>
<!--  <div id="reminder-pane" class="content-overlay" style="display:none"></div> -->
</form>
</body>

</html>