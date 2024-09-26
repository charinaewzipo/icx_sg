
<style>
	.profilebg{
		display:table-cell;
		border:1px solid red;
	}
	.avata-big{
		border-radius: 50%;
	    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
		padding:5px;
		width:100px;
		height:90px;
		background:#fff;	
	}
	
body{
	background-image: url('images/background.gif');
	margin-bottom:200px;
}
.image_cover{
	position:relative;
	background-image: url('profiles/cover_pic.png');
	height: 250px; 
	width: auto; 
}
.button_cover{
position:absolute;
z-index:1;
right:0px;
bottom:0px;
margin: 8px 8px;
}

 
 #profile-setting-menu{
    margin:0;
    padding:0px; 
    list-style:none; 	
 }
  #profile-setting-menu li{
  	padding:7px;
 	
  	border:1px solid #fff;
  	border-bottom:1px solid #E2E2E2;
  }
 #profile-setting-menu li:hover{
  	background-color:#F2F2F2;
  	border:1px dashed #E2E2E2;
  	cursor:pointer;
  }
  #profile-setting-menu li.active {
  	color:#428bca;
  }  
 #profile-setting-menu li h3{
 	margin:0;
 	padding:0;
 }
</style>


<div class="container">
	<div class="row">
		<!-- <a href="home.php">Back</a>  -->
		<div style="padding: 5px 5px;">
				<div style="display:inline-block; position:relative; top:-12px;">
				</div>
				<div style="display:inline-block; position:relative; float:right">
				        <span id="profile-close" class="ion-ios-close-outline close-model" style=""></span>
				</div>
				<div style="clear:both"></div>
		</div>
		
		 <ul class="nav nav-tabs" role="tablist" style="">
	  		<li class="active" style="margin-left:10%; vertical-align:bottom; font-size:16px;"> <a href="#myprofile-tab1" role="tab" data-toggle="tab" ><span class="ion-ios-contact-outline" style="font-size:26px;"></span>&nbsp; My Profile </a></li>
	  		<li style="vertical-align:bottom; font-size:16px;"> <a href="#myprofile-tab2" role="tab" data-toggle="tab" ><span class="ion-ios-gear-outline" style="font-size:26px;"></span>&nbsp;  My Settings  </a></li>
			<!-- <li style="vertical-align:bottom; font-size:16px;"> <a href="#myprofile-tab3" role="tab" data-toggle="tab" ><span class="	ion-ios-pie-outline size-34" style="font-size:26px;"></span>&nbsp;  My Report  </a></li> -->
		</ul>
	   	   <div class="tab-content" style="border-width:0px 1px 1px 1px; border-style:solid; border-color:#E2E2E2; ">
	 			<!--  tab1 my call list -->
	    		<div id="myprofile-tab1" class="tab-pane active" style="background-color:#fff; padding:20px;"  >
	    		
	    				<div style="width:60%;  padding:20px;  background-color:#f1f1f1; display:inline-block; float:right">
	    				<h2 style="text-align:center; font-family:raleway; font-weight:300"> My Profile </h2>
	    					<table class="stack-tab" style="margin:0px; background-color:#f1f1f1; width:100%">
								<thead>
									<tr>
										<td colspan="2">&nbsp;Name </td>
									</tr>
									<tr >
										<td style="padding-top:6px;"> <input type="text" name="ufirstname" style="width:100%" placeholder="First Name" autocomplete="off"> </td>
										 <td style="padding-top:6px;"> <input type="text" name="ulastname" style="width:100%" placeholder="Last Name" autocomplete="off"> </td>
									</tr>
									<tr>
										<td style="padding-top:20px;" colspan="2">&nbsp;Nick Name </td>
									
									</tr>
									<tr>
										<td style="padding-top:6px;" colspan="2"> <input type="text" name="unickname" style="width:100%" placeholder="Nick Name" autocomplete="off"></td>
									</tr>
									<tr>
										<td style="padding-top:20px;" colspan="2">&nbsp;Birthday  </td>
									</tr>
									<tr>
										<td  style="padding-top:6px;" colspan="2">
									
											<input type="hidden" name="umm">
											<div id="dd" class="drop wrapper-dropdown-5" style="width:48%;display:inline-block" >
													<span class="span-placeholder">Month</span>
															<ul class="dropdown"  id="umonth">
																<li id="1"><a href="#">January</a></li>
																<li id="2"><a href="#">February</a></li>
																<li id="3"><a href="#">March</a></li>
																<li id="4"><a href="#">April</a></li>
																<li id="5"><a href="#">May</a></li>
																<li id="6"><a href="#">June</a></li>
																<li id="7"><a href="#">July</a></li>
																<li id="8"><a href="#">August</a></li>
																<li id="9"><a href="#">September</a></li>
																<li id="10"><a href="#">October</a></li>
																<li id="11"><a href="#">November</a></li>
																<li id="12"><a href="#">December</a></li>
															</ul>
													</div>
												<input type="text" name="udd" placeholder="day" autocomplete="off" style="width:25%">												
												<input type="text" name="uyy" placeholder="year"  autocomplete="off" style="width:25%"> 
												
												 
										 </td>
									</tr>
									<tr>
											<td style="padding-top:20px;" colspan="2">&nbsp;Gender  </td>
									</tr>
									<tr>
										<td  style="padding-top:6px;" colspan="2">
										<input type="hidden" name="ugender" >
										<div id="dd" class="drop wrapper-dropdown-5 "  style="width:100%;display:inline-block" >
													<span class="span-placeholder">I am...</span>
															<ul class="dropdown"  id="gender">
																<li id="m"><a href="#">Male</a></li>
																<li id="f"><a href="#">Female</a></li>
															</ul>
													</div>
										<!-- 
												<div style="width:100%; position:relative; border:1px solid #eee">
												<input type="text" name="ugender"  readonly style="width:inherit;border-right:0" placeholder="I am..." autocomplete="off" > 
											
														<div style="position:absolute; width:inherit">
															 	<ul style="list-style:none; background-color:#fff; margin:0; padding:0 ; border: 0 1px 0 1px solid #E2E2E2">
															 		<li style="padding:5px 15px 5px 15px;border-bottom:1px solid #E2E2E2"> Male </li>
															 		<li style="padding:5px 15px 5px 15px;border-bottom:1px solid #E2E2E2"> Female </li>
															 	</ul>
														</div>
											  </div>  
			 							-->
										</td>
									</tr>
									<tr>
										<td style="padding-top:20px;" colspan="2">&nbsp;Mobile  </td>
									</tr>
										<tr>
										<td  style="padding-top:6px;" colspan="2"> <input type="text" name="umobile"  style="width:100%" placeholder="+66" autocomplete="off"></td>
									</tr>
									<tr>
										<td style="padding-top:20px;" colspan="2">&nbsp; My Quote  </td>
									</tr>
									<tr>
										<td  style="padding-top:6px;" colspan="2"> <input type="text" name="uquote"  style="width:100%" placeholder="some words for yourself... " autocomplete="off"></td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="padding-top:20px; text-align:right" colspan="2"> <button class="btn btn-success save_myprofile"> Update Profile </button> </td>
									</tr>
								</tbody>
							</table>
						</div>
						<div style="width:40%;   ; display:inline-block; float:left; ">
								<div style="margin:0px 10px 20px 20px;  padding-top:20px; ">
							  <!--  background : url('profiles/bg31.jpg');  background-size: 100% 100%;   -->
									  <div style="position:relative; text-align:center; ">
									 		<div id="myimg-edit" class='ion-ios7-upload-outline' style='font-size:65px; position:absolute;left:45%;z-index:21;color:#fff; cursor:pointer; display:none'></div>
									  		<img id="myimg" class="avata-big"  style="height:100px; position:relative;  cursor:pointer;">
									  </div>
									  	
									  	<div style="position:relative; text-align:center; top:10px;">
											<span style="font-family:lato; font-size:25px; display:block; " id="preview_nname"></span>
											<span style="font-family:lato; font-size:25px; display:block; " id="preview_uname"></span>
											<span style="font-family:lato; font-size:16px; display:block; " id="preview_group"></span>
										</div>
										<div class="blockquote"><p id="preview_quote"></p></div>
										<div style="position:relative;bottom:-180px; ">
												<span style="font-family:lato; font-size:16px; display:block; color:#666" id="preview_email"> Email  </span>
												<span style="font-family:lato; font-size:16px; display:block; color:#666" id="preview_mobile"> Mobile </span>
												<span style="font-family:lato; font-size:16px; display:block; color:#666" id="preview_extension"> Extension  </span>
										</div>
										
							  </div>
						</div> 
						<div style="clear:both"></div>
				
	    		</div>
	    		<!--  end tab1 -->
	    		
	    		
	    		<!--  tab2 my settings -->
	    		<div id="myprofile-tab2" class="tab-pane" style="background-color:#fff" >
			    					<div style="width:60%;  padding:20px;  display:inline-block; float:right">
			    					
			    					  <!-- Login  setting -->
			    					  <div id="acc-setting-pane" style="padding:20px 20px 1px 20px;background-color:#f1f1f1; min-height:340px;">
			    					  	<h2 style="text-align:center; font-family:raleway; font-weight:300"> Account Setting </h2>
			    					  	<span style='color:red; font-size:12px; visibility:hidden' id="upasswd-error-msg"> &nbsp; </span>
											<table class="table">
											<thead>
												<tr>
													<td style="width:50%;vertical-align:middle"> Login Name </td>
													 <td style="width:50%;"> <input type="text" name="ulogin" style="border:1px solid #E2E2E2; color:#666" readonly> </td>
												</tr>
												<tr>
													<td style="vertical-align:middle"> Your new password </td>
													 <td> <input type="password" name="upasswd"> </td>
												</tr>
												<tr>
													<td style="vertical-align:middle"> Confirm your password</td>
													 <td> <input type="password" name="re-upasswd"> </td>
												</tr>
											</thead>
										<tbody>
												<tr>
													<td style="padding-top:20px; text-align:right" colspan="2"> <button class="btn btn-success save_setting"> Save Change </button> </td>
												</tr>
											</tbody>
										</table>
										</div>
										<!--  end login setting -->
										
										<!--  extension setting -->
										  <div id="ext-setting-pane" style="padding:20px 20px 1px 20px;background-color:#f1f1f1; min-height:340px; display:none">
										  		<h2 style="text-align:center; font-family:raleway; font-weight:300"> Extension Setting </h2>
										  			  		<table class="table">
																<thead>
																	<tr>
																		<td style="vertical-align:middle; width:50%;"> Phone Extension</td>
																		 <td style="width:50%;"> <input type="text" name="uextension" autocomplete="off" placeholder="Extension number" > </td>
																	</tr>
																	</thead>
																		<tbody>
																			<tr>
																				<td style="padding-top:20px; text-align:right" colspan="2"> <button class="btn btn-success save_extension"> Save Change </button> </td>
																			</tr>
																		</tbody>
																		
																</table>
										</div>
										<!--  end extension setting -->						
									</div>
				
					<!--  left menu -->
						<div style="width:40%; padding:20px; display:inline_block; float:left;">
								<ul id="profile-setting-menu" >
									<li class="active" id="acc-setting">
										<h3> Account Setting </h3>
										<span style="font-size:12px;"> Change your new login password  </span>
									</li>
									<li id="ext-setting">
									    <h3>Extension Setting </h3>
										<span style="font-size:12px;"> Create or change your phone extension </span>
									</li>
								</ul>
						</div>
						<!--  end left menu  -->
						<div style="clear:both"></div>
						
	    		</div>
	    	  <!--  end div tab2 -->
	    	  
	    	  <!--  div tab3 -->
	    	  	<div id="myprofile-tab3" class="tab-pane " style="background-color:#fff; "  >
	    				Login-Logout Report <br/>
	    				Outbound campaign <br/>
	    				Avg talk time...
	    				<!--  left menu -->
	    	  			<div style="width:40%; padding:20px; display:inline_block; float:left;">
	    	  				 Total This Week  Online 40 hr.  
	    	  			</div>
	    	  			<!--  end left menu -->
	    				<!--  right menu  -->
	    				<div style="width:60%;  padding:20px;   display:inline-block; float:right">
	    					<table style="width:100%;" class="table table-bordered" id="logon-report-table">
	    						<thead>
	    							<tr>
	    								<td colspan="4"> Login Logout Report  &nbsp;&nbsp;&nbsp;  |  Weekly | Monthly  ( config weekly -range mon to fri or sat ) </td>
	    							</tr>
	    							<tr>
	    								<td style="width:40%"> Date </td>
	    								<td style="width:20%" class="text-center"> Login Time </td>
	    								<td style="width:20%" class="text-center"> Logout Time </td>
	    								<td style="width:20%" class="text-center"> Logon Time </td>
	    							</tr>
	    						</thead>
	    						<tbody>
	    						</tbody>
	    					</table>
	    	  			</div>
	    	  			<!--  end right menu -->
	    	  			<div style="clear:both"></div>
	    	  		</div>
	    	  	<!--  end div tab3 -->
	    </div>
		<!-- end div tab-content -->
	</div>
</div>



<script type="text/javascript" src="js/dropzone.min.js"></script> 
<script type="text/javascript" src="js/myprofile.js"></script>
<script>
	$(function(){

			$(document).keyup(function(e) {
			  		if(e.keyCode == 27){ 
			  			 $('#profile-close').trigger('click');
				    }  
			});
		
 			$('#profile-setting-menu li').click( function(){
				 $(this).siblings().removeClass('active') 
				 $(this).addClass('active');
 	 		});

 	 		$('#ext-setting').click( function(){
 	 			$('#acc-setting-pane').hide();
 	 			$('#ext-setting-pane').show();
 	 			$('[name=uext]').focus(); //focus curosr
 	 			
 	 	 	});

 	 		$('#acc-setting').click( function(){
 	 			$('#ext-setting-pane').hide();
 	 			$('#acc-setting-pane').show();
 	 			$('[name=upasswd]').focus(); //focus curosr
 	 	 	});


 	 		$('[name=uextension]').keyup( function(e){
				if( e.which == 13 ){
				 	$('.save_extension').trigger('click');
				}
 			});

 	 	 	$('.save_extension').click( function(e){
					e.preventDefault();
			 		  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  url = "myprofile_process.php";
					  $.post(url , { "action" : "save_setting" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.myprofile.load();
							          $('#show-name').text('Ext '+$('[name=uext]').val());
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
 	 	 	 });

 	 	 	$('.save_setting').click( function(e){
			 	 	 	 e.preventDefault();
			
						//check password matching if keyin
			 	 	 	var rp = $('[name=re-upasswd]').val();
			 	 	 	var p =  $('[name=upasswd]').val();

						//check password input
						if( p.length != 0  && rp.length == 0 ){
							$('#upasswd-error-msg').text('').text('** Please confirm your password.').css('visibility','visible');
							$('[name=re-upasswd]').focus();
							return;
						}
						//check repassword input
						if( rp.length != 0 && p.length == 0 ){
							$('#upasswd-error-msg').text('').text('** Please enter your password.').css('visibility','visible');
							$('[name=upasswd]').focus();
							return;
						}

			 	 	 	//check password is match
			 	 	 	if(rp.length !=0 && p.length != 0 ){
							//check 
							if( rp != p ){
							 	$('#upasswd-error-msg').text('').text('** Your password not match : Please enter your password again.').css('visibility','visible');
							 	return;
							}
			 	 	 	}
	
			 	 		  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
						  url = "myprofile_process.php";
						  $.post(url , { "action" : "save_setting" , "data": formtojson  }, function( result ){
							    var response = eval('('+result+')');  
								    if(response.result=="success"){
								  
								          $.myprofile.load();
								          $('#show-name').text('Ext '+$('[name=uext]').val());
								          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
								    }
						 });
					
 	 	 	 });

 	 		 $('[name=re-upasswd],[name=upasswd]').keyup( function(e){
					if( e.which == 13 ){
					 	$('.save_setting').trigger('click');
					}
	 		});
 		 	

	 	 	 //when click tab setttings foucs cursor on password
	 	 	 $('[ahref=#tab2]').click( function(e){
					e.preventDefault();
					$('[name=upasswd]').focus();
		 	  });

	 	 
	 	
	});
</script>

