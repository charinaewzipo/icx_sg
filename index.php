<?php  	
	date_default_timezone_set('Asia/Bangkok'); 
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title> iCX </title>
<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">
<link href="css/index.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/stack.time.js"></script> 
<script type="text/javascript" src="js/jquery.cookie.js"></script> 
<script type="text/javascript" src="js/index.js"></script> 
<script type="text/javascript" src="js/getToken.js"></script> 
<style>



</style>
<script type="text/javascript">
$(function(){

	
			 /*
	$('[name=passwd],[name=uid]').on('keypress', function(e) {
	   if(e.keyCode==13){ 
		   $('#login').trigger('click');
	   }
	});  
*/
	

	 $('#logins').click( function(){ 
		
	 	 if( $('[name=uid]').val()=="" &&  $('[name=id]').val() == "" ) { 
				  $('#loginStatus').text('Login Fail, Please try again.').fadeIn('slow');  
				  $('[name=uid]').focus();
		  
		  }else{
		    	
			  	if(  $('[name=id]').val() != "" ){
			  		 $('[name=uid]').val( $('[name=id]').val() ); 
				 }
		 
		     $.post('index_process.php' , { "login" :  $('[name=uid]').val() , "passwd" :  $('[name=passwd]').val()  }, function( data ){ 
			 var response =  eval('(' +data+ ')'); 
	
			   switch( response.result ){
		  		case "error"	  :  
					$('#error').text( response.message );
			  		$('#error').show();
			  		$('#stack-msg').show();
			  		
			    break;
		  		//console.log(":/ Can't connect to database");  break;
		  		
		  		case "success" :  window.location = "home.php";  break;
		  		case "fail" :   $('#loginStatus').html(response.message); 
		  		
		  		 $('[name=passwd]').val('');
				 $('[name=uid]').focus();
		  		break;
		  		case "warning" :   
                    $('#loginStatus').html('');
			  		$("<p>"+response.message+"</p>").appendTo('#loginStatus');
			  		$('<input type="button" class="button-submit" name="kick" value="  Kick session  ">').click( function(){
			  			 $.post('index_process.php' , { "kick" :  $('[name=uid]').val() ,  "passwd" :  $('[name=passwd]').val()  }, function( data ){ 
			  				       var response =  eval('(' +data+ ')'); 
									if(response.result=="success"){
										//keep to cookie;
								  	    window.location = "home.php";
									}  
			  			 });
				
				    }).appendTo('#loginStatus');
				    $('.show_login').hide();
				 
				    $('#loginStatus').append('&nbsp;&nbsp;');
			  		$('<input type="button" class="button-cancel" name="cancelKick" value="  Cancel  ">').click( function(){
		
					    $('#userid').show();
					    $('#iuserid').show();
					    $('#password').show();
					    $('#ipassword').show();
					    $('#blogin').show();
					    $('#loginStatus').text('');
					    $('[name=uid]').val('');
					    $('[name=passwd]').val('');

					    $('[name=uid]').focus();

					    $('.show_login').show();
					    
				    }).appendTo('#loginStatus');
          

				    $('#userid').hide();
				    $('#iuserid').hide();
				    $('#password').hide();
				    $('#ipassword').hide();
				    $('#blogin').hide();
		  		break;
		  		                
			         }//end switch
	          });//end post
		  }//end else
	 }); //end click function

	 //console.log( $('[name=id]').val() );
	 /*
	 if( $('[name=id]').val()!=""){
			$('.cursession').show();
			$('.curuser').hide();
			$('[name=passwd]').focus();
	}
 	*/
});

</script>
</head>
<body >
<div id="stack-msg" class="shadow" style="position:fixed; padding-left: 8px; display:none; background-color:#9A1616; color:#ffffff; width:100%; height:52px;  z-index:+2000" >
  <div style="position:relative;  top:6px; padding-left:10px; font-size:20px;   font-weight: 860;" id="stack-msg-dtl"> : /  Database connection failed. </div>
  <div style="position:relative; top:6px;  font-size: 11px; margin-left: 30px; margin-top: -2px;"> Please contact your administrator.</div>
  <div style="position:relative; float:right; padding: 5px 25px 5px 15px; top: -30px; "><span class="ion-ios7-close-outline" id="stack-msg-close" style="cursor:pointer; font-size:26px;"> </span></div>
</div>
<form>

<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="kicking">

    <div style="position:relative; height:100%;  " class="shadow img">
      <!-- 
	    <img src="images/logo.png" style="width:150px; height:60px;"> <span style="font-size:14px; color:#fff;position:relative; top:-25px;">by RSY Leasing </span>
	      	   -->
	      <div style="z-index:10; padding:40px 0;background-color:rgba(255,255,255,0);position:relative;  margin-left: 0%; text-align:center; height:70%px; top:10%; "  > 
						<div style="z-index:21; "> <!-- margin-left:50%  -->
			    			<div style="display: inline-block;">
			    					<table class="login-table"  style="min-width:400px;">
											<tr>
											  	<td class="title-h1" style="text-align:center;  height:50px; font-family:raleway"><i class="icon-fire" ></i> iCX  <sup style="font-family:lane; font-size:12px;"> </sup> </td>
											</tr>
											<tr>
												<td style="text-align:center" >
													<div style="display:none;height:140px; margin-top:15px;" class="show_session"  >
													    <img id="uimg" src="profiles/agents/no_profile.png" class="icon-circle2" style="width:75px; height:75px; position:relative; top:5px;"><br/>
													    <p>
													    <span id="uname" style=" font-size:24px; font-weight:400; font-family:lato"></span>
													    </p>
												  </div>
												</td>
											</tr>
											<tr > 
											  	<td style="text-align:center" ><div id="loginStatus" class="small" style="color:#e51c23; font-family:lato"> &nbsp; </div></td>
											</tr>
											<tr>
											  	<td style="text-align:center" >
											  		<div class="show_user">
												  		<div style="background-color:#fff; width:260px; position:relative;left:18%" class="show_login">
												  			<i class="icon-user"  style="color:#999; font-size:16px;"></i>&nbsp;&nbsp;
												  			<span  style="color:#666; font-size:25px; border-right:1px solid #EAEAEA; position:relative; top:4px;"></span>
												  			<input type="text" name="uid" class="d small"  autocomplete="off" style="height:40px; margin-left:10px; font-family:raleway; font-weight:400; "  placeholder="User ID">
												  		</div>
											  		</div>
											  </td>
											</tr>
										
											<tr>
											  	<td style="text-align:center">
											  		<div style="background-color:#fff; width:260px;position:relative;left:18%; border-radius:2px; " class="show_login">
											  			<i class="icon-unlock-alt"  style="color:#999; font-size:16px;"></i>&nbsp;&nbsp;
											  			<span  style="color:#666; font-size:25px; border-right:1px solid #EAEAEA; position:relative; top:4px;"></span>
											  			<input type="password" name="passwd" class="d small" autocomplete="off"  style="height:40px; margin-left:10px; font-family:raleway; font-weight:400" placeholder="Password"> 
											  		</div>
											  	</td>
											</tr>
											<!-- 
											<tr>
											  	<td style="text-align:center"></td>
											</tr>
											 -->
											<tr style="display:none;">
											  	<td style="text-align:center">
											  		<div style="background-color:#fff; width:260px;position:relative;left:18%; border-radius:2px;" class="show_login">
											  			<i class="icon-phone"  style="color:#999; font-size:16px;"></i>&nbsp;&nbsp;
											  			<span  style="color:#666; font-size:25px; border-right:1px solid #EAEAEA; position:relative; top:4px;"></span>
											  			<input type="text" name="extension" class="d small" autocomplete="off"  style="height:40px; margin-left:10px; font-family:raleway; font-weight:400" placeholder="Extension Number"> 
											  		</div>
											  	</td>
											</tr>
											<!-- 
											<tr>
											  	<td style="text-align:center"></td>
											</tr>
											 -->
											 <tr>
											  	<td style="text-align:center"></td>
											</tr>
											<tr>
											  	<td style="text-align:center"></td>
											</tr>
											<tr>
										   		<td style="text-align:center" >
										   				<div style="background-color:#fff; width:260px;position:relative;left:18%; border-radius:2px;" class="show_login">
										   				<input type="button" id="login"  style="cursor:pointer; width:260px; font-size:15px; width:260px; height:40px; font-family:raleway; " name="login" value=" Login " class="button-submit">
										   				</div>
										   		</td>
										   	</tr>
										   		<tr>
											  	<td style="text-align:center" > </td>
											</tr>
											<tr>
											  	<td style="text-align:center">
												  	<div class="show_session show_login" style="display:none">
												 	 	&nbsp;&nbsp;  <input type="button" value="Login with different account" style="font-size:18px; font-weight:400; font-family:lato; background:transparent; border:0; color:#fff; cursor:pointer; margin-top:5px;" id="logout"> 
												  	</div>
											  	</td>
											</tr>
								  </table>
			    			</div>
						</div>
				       
		 </div>
		 <div style="clear:both"></div>
		 
		     <div style="position:absolute; bottom:5%; left:5%; border:0px solid #E2E2E2; ">
			      		<div style="text:right">
				                 <table border="0"  cellspacing="0" cellpadding="0" >
									  <tr style="line-height: 60px;">
										   <td class="dow" style="font-family:lane;"> 
										   <?php 	
											 $dow = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
											  echo $dow[date("w")];
								        	?>
										   </td>
									      <td style="vertical-align:middle; font-family:lato;" valign="top" rowspan="2"><div style="position:relative; top:0px; margin: 0 10px; padding: 0 10px;" class="clock">&nbsp;&nbsp;</div></td>
									   </tr>
									   <tr style="line-height: 30px; " > 
									   		<td class="date" style="font-family:lato;"> <?php echo  date('d')." ".date('M')." ".date('Y');	?> </td>
									   </tr>
								  </table>
					   </div>
	           </div>
	           
	 </div>
 <center>
 <span style="font-size:12px;   color:#ffffff;  font-family:raleway; opacity:0.7;"> There is a will , There is a way : )</span>
</center>
  
 </form>
</body>
</html>