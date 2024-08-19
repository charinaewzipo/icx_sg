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


</style>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/checkswitch.js"></script>
<script type="text/javascript" src="js/reminder.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

<!--  <script type="text/javascript" src="js/report.js"></script> -->
<script>
 $(function(){
	 
	  //init page
	$('#tracking-pane').load('tracking-pane.php' , function(){
			$(this).fadeIn('slow');
	 });

 	 $('.calendar_en').datepicker({  dateFormat: 'dd/mm/yy' });

	/*
			//test media element
  $('video,audio').mediaelementplayer({
      success: function (mediaElement, domObject) {
          mediaElement.addEventListener('ended', function (e) {
              mejsPlayNext(e.target);
          }, false);
      },
      keyActions: []
  });

  $('.mejs-list li').dblclick(function() {
      $(this).addClass('current').siblings().removeClass('current');
      var audio_src = $(this).text();
     // console.log( audio_src );
      $('audio#mejs:first').each(function(){
        //  console.log( this );
          this.player.pause();
          this.player.setSrc(audio_src);
          this.player.play();
      });
  });

  function mejsPlayNext(currentPlayer) {
      if ($('.mejs-list li.current').length > 0){ // get the .current song
          var current_item = $('.mejs-list li.current:first'); // :first is added if we have few .current classes
          var audio_src = $(current_item).next().text();
          $(current_item).next().addClass('current').siblings().removeClass('current');
          console.log('if '+audio_src);
      }else{ // if there is no .current class
          var current_item = $('.mejs-list li:first'); // get :first if we don't have .current class
          var audio_src = $(current_item).next().text();
          $(current_item).next().addClass('current').siblings().removeClass('current');
          console.log('elseif '+audio_src);
      }

      if( $(current_item).is(':last-child') ) { // if it is last - stop playing
          $(current_item).removeClass('current');
      }else{
          currentPlayer.setSrc(audio_src);
          currentPlayer.play();
      }
  }
	 */

	 //list conversion
	$.rpt.getcmp();
	$('[name=listconv_search_campaign]').change( function(e){
			var self = $(this);
			if( self.val() == ""){
				 var option = "<option value=''> &nbsp; </option>";
				 $('[name=listconv_search_lead]').text('').append(option);
			}else{
				$.rpt.getlead( self.val() );
			}
			
	 });

	 //agent report click
	 $('#agent-report').click( function(e){
				$('#select-report').fadeOut( 'fast' , function(){
					$('#agent-performance-pane').fadeIn('medium');
				})
	 });

	 //agent report back to main menu
	 $('#agentreport-back-main').click( function(e){
			$('#agent-performance-pane').fadeOut( 'fast' , function(){
				$('#select-report').fadeIn('medium');
			})
	});

	 
	 //list conversion report click
	 $('#listconv-report').click( function(e){
				$('#select-report').fadeOut( 'fast' , function(){
					$('#listconv-pane').fadeIn('medium');
				})
	 });
	 
	 //list conversion report back to main menu
	 $('#listconvreport-back-main').click( function(e){
			$('#listconv-pane').fadeOut( 'fast' , function(){
				$('#select-report').fadeIn('medium');
			})
	});

	 /*
	 //wrapup report click
	 $('#listconv-report').click( function(e){
				$('#select-report').fadeOut( 'fast' , function(){
					$('#listconv-pane').fadeIn('medium');
				})

					$('#wrapup-pane').
		
	 });
	 
	 //wrapup report back to main menu
	 $('#listconvreport-back-main').click( function(e){
			$('#listconv-pane').fadeOut( 'fast' , function(){
				$('#wrapup-pane').fadeIn('medium');
			})
	});
*/

	 

		//btn search agent permance
		//report1
		$('.search-agentpermance-btn').click( function(e){
				e.preventDefault();
				$.rpt.agent_performance_report();
		});

		$('.search-agentperfmance-btn-clear').click( function(e){
				e.preventDefault();
				//clear search
			
		});

		$('.search-agentperformance-export').click( function(e){
				e.preventDefault();
				$.rpt.agent_performance_export();
		});

  	//btn list conversion btn
  	//report2
		$('.search-listconversion-btn').click( function(e){
			e.preventDefault();
			$.rpt.list_conversion_report();
		});

		$('.search-listconversion-btn-clear').click( function(e){
			e.preventDefault();
			//clear search
		});

		$('.search-listconversion-btn-export').click( function(e){
			e.preventDefault();
			$.rpt.agent_performance_export();
	});

 	//btn wrapup detail btn
	 
 })

</script>

<body>
<form>
<input type="hidden" name="appname" value="tracking">
<?php  date_default_timezone_set('Asia/Bangkok');?>
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
								<i class="icon-fire" ></i> <span style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">Tubtim </span>						
						</span>
					</span>
		 		</li>
				<li >
				<span style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;"> 
					<span id="show-name" class="header-user-profile">Ext <?php echo  $pfile['uext']; ?></span>
					<span id="show-passions"class="header-user-detail">  <?php echo  $pfile['tokenid']; ?> </span>
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


	<div class="header" style="margin-top:50px;">
			 <div class="bg-grayLighter metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  
	
	<!-- div wrapper -->
	<div style="margin:0px 20px;">
	<!--  start tracking main pane -->
	<div id="tracking-main-pane">
		<div style="float:left; display:inline-block">
			<h2 style="display:inline-block;font-family:raleway; color:#666666; "> Lead Tracking </h2>
			<div id="page-subtitle" style="font-family:raleway;color:#777777;position:relative; top:-10px; text-indent:2px;"> Lead Tracking </div>
		</div>
		<div style="clear:both"></div>
		<hr style="border-bottom: 1px dashed #666; position:relative; top:-10px">
 					 
		<div style="width:75%; margin:0 auto">
				<table style="width:100%; " >
					<thead>
						<tr>
							<td colspan="4"><h3 style="color:#666"><i class="icon-search"></i> ค้นหาข้อมูล </h3>
							<hr style="border-bottom: 1px solid #ddd; position:relative; top:-10px"/>
							 </td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="width:20%; text-align:right; padding:5px 0;">First Name : &nbsp; </td>
							<td style="width:20%; color:#666; padding:5px 0;font-size:13px;"> <input type="text" name="search_firstname" style="width:250px;" autocomplete="off" placeholder="ชื่อจริง"></td>
							<td style="width:20%; text-align:right;padding:5px 0;"> Last Name : &nbsp;</td>
							<td style="width:40%; color:#666;padding:5px 0;"><input type="text" name="search_lastname" style="width:250px;" autocomplete="off" placeholder="นามสกุล"></td>
						</tr>
						<tr style="">
							<td style="width:20%; text-align:right; padding:5px 0;">Tel : &nbsp; </td>
							<td style="width:20%; color:#666; font-size:13px; padding:5px 0;" colspan="3"> <input type="text" name="search_firstname" style="width:752px;" autocomplete="off" placeholder="เบอร์โทรศัพท์"></td>
						</tr>
						<tr>
							<td style="width:20%; text-align:right; padding:5px 0;">ID Card Number : &nbsp; </td>
							<td style="width:20%; color:#666; font-size:13px; padding:5px 0;"> <input type="text" name="search_firstname" style="width:250px;" autocomplete="off" placeholder="หมายเลขบัตรประชาชน"></td>
							<td style="width:20%; text-align:right; padding:5px 0;">Credit Card Number : &nbsp;</td>
							<td style="width:40%; color:#666; padding:5px 0;"><input type="text" name="search_lastname" style="width:250px;" autocomplete="off" placeholder="หมายเลขบัตรเครดิต"></td>
						</tr>
						<tr>
					
							<td style="width:50%; color:#666; font-size:13px; padding:25px 0px; text-align:center;" colspan="4">
									 <button class="btn btn-primary search-listconversion-btn" style="border-radius:3px; width:140px;"> Search </button>
									 	&nbsp;&nbsp;&nbsp;
									 				&nbsp;&nbsp;&nbsp;
										 <button class="btn btn-default search-listtconversion-btn-clear" style="border-radius:3px; width:110px;"> Clear </button> 
							</td>
						
						</tr>
					</tbody> 
				</table>
		</div>
		
		
		Search Result :
	<table class="table table-bordered">
		<thead>
			<tr class="primary">
				<td> #  </td>
				<td> First Name </td>
				<td> Last Name </td>
				<td> Tel </td>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
		
		 
	</div>
	<!--  end tracking main pane -->
	
	<!--  start tracking detail pane -->
	<div id="tracking-detail-pane">
	
			<div style="position:relative;">
						<div id="agentreport-back-main" style="float:left; display:inline-block;cursor:pointer; ">
							<i class="icon-circle-arrow-left icon-3x" style="color:#666; "></i>
						</div>
						<div style="display:inline-block; float:left; margin-left:5px;">
							<h2 style="font-family:raleway; color:#666666; margin:0; padding:0">&nbsp;คุณ หนามเตย วงศ์จันทร์</h2>
							<div class="stack-subtitle" style="color:#777777; ">&nbsp; Lead Tracking &gt; Tracking detail </div>
						</div>
						<div style="clear:both"></div>
				</div>
				<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px">
						
						
						 <!-- wrapper -->
    <div style="float:left;" >
    	<div style="float:left; width:50%;">
    	    Detail : 
    <br/>
    Found IN 2 Campaign  <br/>
    แสดงเป็น Tab ตามแต่ละ Campaign หากกด Detail
    Incampaign :
    <br/>
    	  In Campaign 
    	   		<button class="btn btn-success"> Save Changes </button>
    	       	   <button class="btn btn-success"> Delete  </button>
    	       	   
    	     <input type="checkbox" > Set Do not call
    	<table class="table table-border">
    		<thead>
    		<tr>
    			<td>
    				Dynamic Lead
    				</td>
    			</tr>
    		</thead>
    		<tbody>
    		
    		</tbody>
    	</table>
    	
    	
    	</div>
    	<div style="float:right; width:50%;">
    	
    		<table class="table table-bordered">
			    	<thead>
			    		<tr>
			    			<td colspan="2"> Lead Import Detail</td>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<tr>
			    			<td>  lead name : </td>
			    			<td> <input type="text" name="leadname"></td>
			    		</tr>
			    		<tr>
			    			<td>  lead detail : </td>
			    			<td> <input type="text" name="leadname"></td>
			    		</tr>
			    		<tr>
			    			<td>  lead import from file name  : </td>
			    		<td> <input type="text" name="leadname"></td>
			    		</tr>
			    			<tr>
			    			<td>  lead import from file type  : </td>
			    		<td> <input type="text" name="leadname"></td>
			    		</tr>
			    	</tbody>
			    </table>
    
    	 ตอนนี้ข้อมูลล่าสุดอยู่ที่น้องคนไหน   calllist agent detail 
    	 Owner This list 
    	 
    	 SELECT * FROM t_calllist_agent
      			<table class="table table-bordered">
			    	<thead>
			    		<tr>
			    			<td> Lead On hands </td>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<tr>
			    			<td> ไม่พอข้อมูลการลง Wrapup </td>
			    		</tr>
			    	</tbody>
			    </table>
			    
			    SELECT campaign_id , agent_id , wrapup_id , wrapup_note , wrapup_option_id , create_date 
FROM t_call_trans t
WHERE calllist_id = 66012
			    
    		  calltrans detail 		รายละเอียดการลง wrapup โทร  
    		 	<table class="table table-bordered">
			    	<thead>
			    		<tr>
			    			<td> Lead Call Transaction </td>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<tr>
			    			<td> ไม่พอข้อมูลการลง Wrapup </td>
			    		</tr>
			    	</tbody>
			    </table>
			    
			    Lead Transfer Date !!! OMG BiG DATA
			    <table class="table table-bordered">
			    	<thead>
			    		<tr>
			    			<td> Lead Call Transaction </td>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<tr>
			    			<td> ไม่พอข้อมูลการลง Wrapup </td>
			    		</tr>
			    	</tbody>
			    </table>
    	
    	</div>
    </div>
    <div style="clear:both"></div>
						
						
	
	</div>
	<!--  end start tracking end pane -->
		

 	
 	
 	<table>
 		<thead>
 			<tr>
 				<td></td>
 			</tr>
 		</thead>
 		<tbody>
 		</tbody>
 	</table>
	
	
	

    
  
    
    
    
   
    
    
    detail ที่ต้องบอก มีอะไรบ้าง
    calllist detail
 
    
  
    
  
    
    !===
    งานค้างหน้า popup ต้อง design  ให้เป็น popup overlay สามารถกดโทรออกได้เลย ( จากหน้าไหนก็ได้ )
    
    

</div>
<!-- end div wrapper -->
		
<div id="profile-pane" class="content-overlay" style="display:none"></div>
</form>
</body>

</html>