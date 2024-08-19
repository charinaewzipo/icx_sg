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
body {
  position: relative; /* needed if you position the pseudo-element absolutely */
}

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


/* css over lay */
.confirmOverlay{
	border:0px solid #000;
    width:20%;
    height:20%;
    position:fixed;
    bottom:10%;
    left:5%;
    z-index:1;
    
}

.confirmOverlay  div{
   overflow:hidden;
    border-radius:2px;
    background-color: rgba(255,255,255,0.95);
 		-moz-box-shadow: 0px 5px 8px 5px rgba(255,255,255,0.6);
		-webkit-box-shadow:  0px 5px 8px 5px  rgba(255,255,255,0.6);
		box-shadow: 0px 0px 8px 5px rgba(255,255,255,0.6);
		margin-top:25px;
}

#agent-performance{
 font-family:raleway;
 color:#fff;

}


/* start used */
#dashboard-main{
	width:100%;
	border:1px solid black;
	margin:0; padding:0;
	list-style:none;
	text-align:center;
} 

#dashboard-main li{
	display:inline-block;
	padding:0px;
	margin:0;
	position:relative;
	border:1px solid red;
	width: 24%;
	height: 200px;
	background-color:#fff;
}

.online {
    background-color: #8cbf26;
    border-radius: 3px;
    color: #fff;
    font-size: 15px;
    padding: 1px 4px;
}

.offline{
 	background-color: #7f8c8d;
    border-radius: 3px;
    color: #fff;
    font-size: 15px;
    padding: 1px 4px;
}

</style>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

<script>
 $(function(){
	  //init page
		$('#tracking-pane').load('tracking-pane.php' , function(){
				$(this).fadeIn('slow');
		 });
		$('.calendar_en').datepicker({  dateFormat: 'dd/mm/yy' });

		
		console.log("test abc");
		
		var x = "";
		$('.confirmOverlay').fadeIn('slow', function(){
		 x = setInterval(function(){
					console.log("delay 2 sec");
					for( i=0;i<5; i++){
						console.log( i );
						 var a = $('<div class="" style="margin-bottom:'+i+'%"><h1>Hi</h1><p>Hello!'+i+'</p> </div>');
						 $('.confirmOverlay').append(  a );
					}
					//$('.confirmOverlay').fadeOut('slow');
					 clearTimeout(x);
			},3000);
		
		});

		$('.confirmOverlay').click( function(){
			console.log( $(this) );
			 $(this).find('h1').text('Good Morning');
		});

		//test form key press
		$(document).on('keypress', function(event) {
			console.log( event.which );
		    if( event.which === 8721 && event.altKey ) {
		   	 clearTimeout(x);
		    }
		});

		$('#small-screen').click( function(e){
			e.preventDefault();
			console.log("resize to small");
			$('#header-bar').fadeIn('slow'); 
		});

		$('#full-screen').click( function(e){
			e.preventDefault();
			console.log("resize full");
			$('#header-bar').fadeOut('slow'); 
			setTimeout(function(){  
					$('body').css('background-image','url(images/bg-black.jpg)');
			}, 1200);
			
		});

		start_dashboard();
		function start_dashboard(){
			url = "dashboard_process.php";
			var  formtojson =  JSON.stringify( $('form').serializeObject() );  
			   $.ajax({   'url' : url, 
				   'data' : { 'action' : 'init' , 'data' : formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 

					     var  result =  eval('(' + data + ')');

					       //online offline
						 	$('#dash-agent-online').text('').text( result.login.online );
						 	$('#dash-agent-offline').text('').text(  result.login.offline );

						 	//main board
							$('#dash-today-assign').text('').text( 1 );
							$('#dash-today-revoke').text('').text( 2 );
							
							$('#dash-today-old-assign').text('').text( 43 );
							$('#dash-today-old-revoke').text('').text( 4 );
							
							$('#dash-today-usedlist-new').text('').text( 5 );
							$('#dash-today-usedlist-old').text('').text( 6);
							
							$('#dash-today-newlist').text('').text( 7 );
							$('#dash-today-nocontact').text('').text( 8 );
							$('#dash-today-callback').text('').text( 9 );
							$('#dash-today-followup').text('').text( 10 );
							
							$('#dash-today-submit').text('').text( 11);
							//$('#dash-today-complete').text('').text("N/A");
							
							//agent board
							 var $tbody = $('#agent-dash-table tbody'); 
							   		$tbody.find('tr').remove();
							var i = 0;
							 for( i ; i< result.hands.length ; i++){

									var total = parseInt(result.hands[i].nl) + parseInt( result.hands[i].nc ) + parseInt( result.hands[i].cb ) + parseInt( result.hands[i].fu );
								     var row = "<tr>"+
								    		 		  "<td style=''>"+
								    		 		  "<div style='display:inline-block; float:left;'><img  class='avata-big' style='height:75px; width:75px; position:relative; margin:0; ' src='"+result.hands[i].aimg+"'></div>"+
								    		 		  "<div style='display:inline-block; text-indent:15px; position:relative; margin-top:5px; '>"+
								 							"<h4 style='padding:2px; margin:0; line-height:0px; font-weight:400; '>"+result.hands[i].an+" </h4>"+
								 							"<p style='padding:0; margin:0;font-size:14px; display:block; top:6px; position:relative; color:#666;'>"+result.hands[i].gn+" , "+result.hands[i].tn+" </p>"+
								 							"<p style='padding:0; margin:0;font-size:14px; display:block; top:6px; position:relative; color:#666;'>"+result.hands[i].o+" Extension : "+result.hands[i].ex+" </p>"+
								 							"<p style='padding:0; margin:0;font-size:14px; display:block; top:6px; position:relative; color:#666;'> List Naem abcde sdfsdfds </p>"+
								 						"</div>"+
								    		 		  "</td>"+
 
								    		 	      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+total+"</td>"+		
								    		 		   "<td class='text-center' style='font-size:30px; vertical-align:middle;'>"+result.hands[i].nl+"</td>"+		
								    		 		   "<td class='text-center' style='font-size:30px; vertical-align:middle;'>"+result.hands[i].nc+"</td>"+		
									    		      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+result.hands[i].cb+"</td>"+		
									    		      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+result.hands[i].fu+"</td>"+		
												      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+total+"</td></tr>";	 
												      
									$tbody.append(row);
								     
								    } 
					
							   		
						
					}//end success
			   });//end ajax
	  }//end function

		function agent_performance(){
		//init 
			url = "dashboard_process.php";
			var  formtojson =  JSON.stringify( $('form').serializeObject() );  
			   $.ajax({   'url' : url, 
				   'data' : { 'action' : 'init' , 'data' : formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 
						
		                var  result =  eval('(' + data + ')');  
		           	    var $tbody = $('#agent-dash-table tbody'); 
					    $tbody.find('tr').remove();
						var i=0;
						
						var total = 0;
						var tnew = 0;
						var tcallback = 0;
						var tfollow = 0;

					 for( i ; i< result.hands.length ; i++){

						var total = parseInt(result.hands[i].tnew) + parseInt( result.hands[i].tcallback ) + parseInt( result.hands[i].tfollow ) + parseInt( result.hands[i].tnocont );
						 
					     $row = $("<tr>"+
					    		 		  "<td style=''>"+
					    		 		  "<div style='display:inline-block; '><img class='avatar' src='"+result.hands[i].aimg+"'></div>"+
					    		 		  "<div style='display:inline-block; text-indent:25px; position:relative; '>"+
					 							"<h4 style='padding:2px; margin:0; line-height:0px; font-weight:400; '>"+result.hands[i].aname+" </h4><p style='font-size:14px; display:block; top:6px; position:relative; color:#666;'>"+result.hands[i].agroup+" , "+result.hands[i].ateam+" </p>"+
					 							" Campaign , List "+
					 						"</div>"+
					    		 		  "</td>"+
					    		 	      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+total+"</td>"+		
					    		 		   "<td class='text-center' style='font-size:30px; vertical-align:middle;'>"+result.hands[i].tnew+"</td>"+		
					    		 		   "<td class='text-center' style='font-size:30px; vertical-align:middle;'>"+result.hands[i].tnocont+"</td>"+		
						    		      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+result.hands[i].tcallback+"</td>"+		
						    		      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+result.hands[i].tfollow+"</td>"+		
						    		      
						    		      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+result.hands[i].tsubmit+"</td>"+	
									      "<td class='text-center'  style='font-size:30px; vertical-align:middle'>"+total+"</td></tr>");	 
					     $row.appendTo($tbody);
					     
				
					    } 
					 
		
						    var $tfoot = $('#agent_onhands tfoot'); 
						    $tfoot.find('tr').remove();
						    $tfoot.append("<tr>"+
								    		 		  "<td style='width:50%; text-align:right;'> Total </td>"+
								    		 	      "<td class='text-center'  style='width:10%; font-size:20px; vertical-align:middle'>"+total+"</td>"+		
								    		 		   "<td class='text-center' style='width:10%; font-size:20px; vertical-align:middle;'>"+tnew+"</td>"+		
									    		      "<td class='text-center'  style='width:10%; font-size:20px; vertical-align:middle'>"+tcallback+"</td>"+		
									    		      "<td class='text-center'  style='width:10%; font-size:20px; vertical-align:middle'>"+tfollow+"</td>"+		
												      "<td class='text-center'  style='width:10%; font-size:20px; vertical-align:middle'></td></tr>");	 

	                   

					}//end success

			   });//end ajax

		}
		/*
		setInterval(function(){
				agent_performance();
		},3000);
*/


/*
 	agent_performance();
	$('body').css('background-image','url(images/bg-black.jpg)');
	*/
 })

</script>

<body>
<form>

<input type="hidden" name="appname" value="dashboard">
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="uim" value="<?php echo $pfile['uimg']; ?>">
<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>">
<input type="hidden" name="ulvl" value="<?php echo $pfile['lv']; ?>">

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
<div style="padding:20px;" >
<!-- 
	<h2>  อย่าลืม PE ICON FONT นะ download มาแล้ว </h2>
	Dashboard

//condition
--team
--group
-- date 

//count agent online/off line 

//New list assign today 
SELECT SUM(transfer_total) as total FROM t_calllist_transfer
WHERE transfer_date BETWEEN 
AND transfer_type = 1
AND transfer_on_status = 1
AND transfer_to_id IN ( SELECT FROM t_agents WHERE team_id = )

//Used list assign today
SELECT SUM(transfer_total) as total FROM t_calllist_transfer
WHERE transfer_date BETWEEN 
AND transfer_type = 1
AND transfer_on_status <> 1
AND transfer_to_id IN ( SELECT FROM t_agents WHERE team_id = )

//New list used มีการใช้ list ใหม่ไปเท่าไหร่
SELECT 
FROM t_calllist_agent
WHERE last_wrapup_option_id IS NOT NULL

//Used list used มีการใช้ list ที่ถูกใช้ไปแล้วเท่าไหร่
????

//call list on each status
SELECT FROM t_calllist_agent
WHERE assign_dt BETWEEN
where ตาม last_wrapup_option_id

//submit complete
SELECT FROM t_calllist_agent
WHERE  //close sales = 6

 





	
	
	
	<div style="background-color:#fff; height: 100px; ">
	IF LEVEL is manager can see it
	<h3 style="margin:0; padding:0; font-family:raleway; font-weight:300; color:#666; font-size:26px;"> DashBoard </h3>
			SELECT Condition <br/>
			Group : <select> </select>
			Team : <select> </select>
			<button class="btn btn-success"> Start </button>
	</div>
-->
	
	<div style="">
				<div style="position:relative; width:100%; border:0px solid #000;">
							<div style="">
								<div style="display:inline-block; float:left; padding:0 15px;">
									<img  src="images/falcon-app.gif" id="awall-img" class="avata-big"  style="height:75px; width:75px; position:relative;">
								</div>
								
								<div style="display:inline-block; float:left">
									<ul style="list-style:none; margin:0; padding:0; border:0px solid #000">
										<li style=""><h3 style="margin:0; padding:0; font-family:raleway; font-weight:300; color:#666; font-size:26px;">Group : Falcon ,  Team <span id="awall-agent" >Campaign X</span> </h3> </li>
										<li style="font-size:16px; font-weight:300; color:#666; padding-top:5px;">Agent Online : <span id="dash-agent-online"  class="online">0</span> &nbsp; Agent Offline : <span  id="dash-agent-offline" class="offline"> 0 </span> </li> <!-- is online stauts -->
										<!-- <li style="font-size:14px;  font-weight:300; color:#777;">Team <span id="awall-group-team" ></span> &nbsp; Ext. <span  id="awall-ext"></span> </li> -->
										<li style="font-size:15px; font-weight:300; color:#666;"></li>
									</ul>
								</div>
								
							</div>
						</div>
					
						<div style="clear:both"></div>
						<ul>
							<li> Today Assing List ใหม่ <span id="dash-today-assign"> </span></li>
							<li> Today Revoke List  ใหม่ <span id="dash-today-revoke"> </span></li>
							<li><br/> </li>
							<li> Today Assing List เก่า <span id="dash-today-old-assign"> </span></li>
							<li> Today Assing List เก่า <span id="dash-today-old-revoke"> </span></li>
							<li> ---- </li>
							<li> Today ใช้  List ใหม่  <span id="dash-today-usedlist-new"> </span></li>
							<li> Today ใช้ List เก่า <span id="dash-today-usedlist-old"> </span></li>
							
							<li> ---- </li>
							<li> New List <span id="dash-today-newlist"> </span></li>
							<li> No Contact <span id="dash-today-nocontact"> </span></li>
							<li> Call Back<span id="dash-today-callback"> </span></li>
							<li> Follow up <span id="dash-today-followup"> </span></li>
							
								<li> ---- </li>
							<li> Submit <span id="dash-today-submit"> </span></li>
							<li> Complete <span id="dash-today-complete"> N/A</span></li>
							
							
						</ul>
						
						 
						
						
						<div style="clear:both"></div>
						<div style="position:relative; width:100%; border:0px solid #000;">
							<ul id="dashboard-main">
								<li> 
								<h4 class="text-success" style='font-family:"Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;'> Today Assigned List </h4>
								<br/>
								<span>Assign List ใหม่   </span> <br/>
								<span>Revoke List ใหม่   </span> <br/>
					   		<br/>
								<span>Assign List เก่า   </span> <br/>
								<span>Revoke List เก่า   </span> <br/>
								<hr/>
								<div style="clear:both"></div>
								<div style="background: none repeat scroll 0 0 #f7f9fa; position:absolute; bottom:0; left:0; width:100%; color:#666; font-size:12px; height:34px; line-height:34px; border:1px solid #E2E2E2;"> Last assigned list on  </div>
							</li>
							<li> 
								<span style='font-family:"Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;'> Today Used List </span>
								<h3 class="text-success">List ใหม่ ที่ถูกใช้ </h3>
									<h3 class="text-success">List เก่าที่ถูกใช้ </h3>
			
									<div style="clear:both"></div>
								<div style="background: none repeat scroll 0 0 #f7f9fa; position:absolute; bottom:0; left:0; width:100%; color:#666; font-size:12px; height:34px; line-height:34px; border:1px solid #E2E2E2;"> Footer Here </div>
							</li>
							<li> 
								<span style='font-family:"Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;'> Call Status  </span>
									<div class="text-success">New List </div>
									<div class="text-success">No Contact </div>
									<div class="text-success">Call Back </div>
									<div class="text-success">Follow up </div>
								<div style="background: none repeat scroll 0 0 #f7f9fa; position:absolute; bottom:0; left:0; width:100%; color:#666; font-size:12px; height:34px; line-height:34px; border:1px solid #E2E2E2;"> Footer Here </div>
							</li>
								<li> 
								<span style='font-family:"Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;'> Call Status  </span>
								<h3 class="text-success"> Submit </h3>
								<h3 class="text-success"> Complete อยู่อีกระบบ</h3>
				
					
									<div style="clear:both"></div>
								<div style="background: none repeat scroll 0 0 #f7f9fa; position:absolute; bottom:0; left:0; width:100%; color:#666; font-size:12px; height:34px; line-height:34px; border:1px solid #E2E2E2;"> Footer Here </div>
							</li>
							</ul>
						
						
						</div>
						
	</div>
	
	
	<br/>
	<br/><br/>
	
	
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	
	<br/>
	<br/><br/>
	
	
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	Group by Campaign | 
	<table class="table table-border" id="agent-dash-table">
	<thead>
		<tr>
			<td style="width:25%"> Agent </td>
			<td class="text-center"> Total </td>
			<td class="text-center"> New List </td>
			<td class="text-center"> No Contact </td>
			<td class="text-center"> Call Back </td>
			<td class="text-center"> Follow up </td>
			<!-- 
			<td class="text-center"> Submit </td>
			<td> Complete </td>
			 -->
			<td> Today Assign List </td>
			<td> Today Revoket List </td>
			<td> AVG Talk time </td>
			<td> List Name </td>
			<td> Campaign </td>
		</tr>
	</thead>
	<tbody>
	</tbody>
	</table>
	
	
	
	
	<br/>
	<br/><br/>
	
	
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	 
	<button class="btn btn-default" id="full-screen"><i class="icon-resize-full" style="font-weight:400;"></i></button>
	<button class="btn btn-default" id="small-screen"><i class="icon-resize-small" style="font-weight:400;"></i></button>

	<!-- start dash board -->
	<div style="display:nones">
		<!--  left pane -->
		<div style="float:left; width:30%;">
	
			<h2 style="font-family:raleway; font-weight:400; color:#666; margin-top:0; padding-top:0;"> Campaign Name </h2>
		Start Date - End Date :  <br/>
		<select> 
			<option>All time </option>
		</select>
			
		
		</div>
		<!--  end left pane -->
		<!-- right pane -->
		<div style="float:right; width:70%;">
				<div class="row">
						<div class="col-md-4">
							<div style="border:1px solid #fff; background-color:green">
								Overall Sales  <br/>
								Yesterday's |  Today's | 	All Sales
								<br/>
								4% higher  than yesterday
							
								
								
							</div>
						</div>
						<div class="col-md-4">
							<div style="border:1px solid #fff; background-color:green">
									Overall List Performance <br/>
									Total List | 
							</div>
						</div>
						<div class="col-md-4">
							<div style="border:1px solid #fff; background-color:green">
									Overall Agent Performance <br/>
									Total Agent | 
									Agent Name 
							</div>
						</div>
				</div>
		</div>
		<!-- end right pane -->
		<div style="clear:both"></div>
	</div>
	<!--  end dash board -->
	
	<!-- start -->
	<div style="position:relative; text-align:center">
	 	<div class="shadow"  style="text-align:left;width:240px; height:70px; display:inline-block;  border:1px solid #00acec; border-radius: 3px; background-color:#00acec; position:relative; ">
									  					<div style="line-height:20px; vertical-align:bottom; display:inline-block;float:left;width:50%;  padding:5px;  margin-top:10px; height:100%;  position:relative; border:0px solid #000; font-size:17px; font-family:raleway;  color:#fff">
									  					<span style="font-weight:600;"> Overall <br/> Sales</span> 
									  					</div>
									  					<div style="color:#fff; text-align:center;display:inline-block;float:right;border:0px solid #000; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2); height:100%; width:45%; ">
									  						<div style="font-size:45px; position:relative; margin-top:10px;" class="totalIncoming">0 </div>
									  					</div>
									  					<div style="clear:both"></div>
									  		</div>
									  		&nbsp;
									  		<div class="shadow"  style="text-align:left;width:240px; height:70px; display:inline-block;  border:1px solid #8bc34a; border-radius: 3px; background-color:#8bc34a; position:relative; ">
									  					<div style="line-height:20px; vertical-align:bottom; display:inline-block;float:left;width:55%;  padding:5px;  margin-top:10px; height:100%;  position:relative; border:0px solid #000; font-size:17px; font-family:raleway;  color:#fff">
									  						<span style="font-weight:600;">Today <br/> Sales </span> 
									  					</div>
									  					<div style="color:#fff; text-align:center;display:inline-block;float:right;border:0px solid #000; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2); height:100%; width:35%; ">
									  						<div style="font-size:45px; position:relative; margin-top:10px; " class="totalAgent"> 0 </div>
									  					</div>
									  					<div style="clear:both"></div> 
									  		</div>
									  		&nbsp;																																				
									  			<div class="shadow"  style="text-align:left;width:240px; height:70px; display:inline-block;  border:1px solid #ef6c00; border-radius: 3px; background-color:#ef6c00; position:relative; ">
									  					<div style="line-height:20px; vertical-align:bottom; display:inline-block;float:left;width:49%;  padding:5px;  margin-top:10px; height:100%;  position:relative; border:0px solid #000; font-size:16px; font-family:raleway;  color:#fff">
									  						<span style="font-weight:600;"> List  <br/> Remain </span> 
									  					</div>
									  					<div style="color:#fff; text-align:center;display:inline-block;float:right;border:0px solid #000; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2); height:100%; width:44%; ">
									  						<div style="font-size:45px; position:relative; margin-top:10px; margin-right:5px;"  class="totalQueue"> 0 </div>
									  					</div>
									  					<div style="clear:both"></div>
									  		</div>
									  		&nbsp;
									  		<div class="shadow"  style="text-align:left;width:240px; height:70px; display:inline-block;  border:1px solid #f44336; border-radius: 3px; background-color:#f44336; position:relative; ">
									  					<div style="line-height:20px; vertical-align:bottom; display:inline-block;float:left;width:46%;  padding:5px;  margin-top:10px; height:100%;  position:relative; border:0px solid #000; font-size:17px; font-family:raleway;  color:#fff">
									  					<span style="font-weight:600;"> Agent <br/> Online </span> 
									  					</div>
									  					<div style="color:#fff; text-align:center;display:inline-block;float:right;border:0px solid #000; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.2); height:100%; width:48%; ">
									  						<div style="font-size:45px; position:relative; margin-top:10px; margin-right:5px;" class="totalAbandon"> 0</div>
									  					</div>
									  					<div style="clear:both"></div>
									  		</div>
	</div>
	<!-- end  -->
	<div id="agent-performance-pane">
		 <table class="table table-border" style="" id="agent-performance">
			 <thead>
			 <tr style="border-bottom:2px solid #fff;">
			 		 <td style="width: 30%; font-size:18px;"> Agent </td>
			 		 <td style="width: 10%; font-size:18px;" class="text-center"> Total List </td>
			 		 <td style="width: 10%; font-size:18px;" class="text-center"> New List </td>
			 		 <td style="width: 10%; font-size:18px;" class="text-center"> Call Back</td>
			 		 <td style="width: 10%; font-size:18px;" class="text-center"> Follow up </td>
			 		 <td style="width: 10%; font-size:18px;" class="text-center"> Sale  </td>
			 		 <td style="width: 20%; font-size:18px;" class="text-center"> Call Progress </td>
			 </tr>
			 </thead>
			 <tbody>
			 <tr>
			 	<td>
			 		
			 	</td>
			 	<td></td>
			 	<td></td>
			 	<td></td>
			 	<td></td>
			 	<td></td>
			 	<td></td>
			 </tr>
			 </tbody>
		 </table>
		 	
	
	</div>
	<!-- end agent-pane -->
		
		<!-- <div class="loader" >Loading...</div>  -->
		  <select><option> Top Sale </option><option> 10% of sale list </option><option> Maximum call</option></select> Day | Week | Month | Year
	
	
	</div>
	<!--  end div center -->
	

 </form>
</body>

</html>