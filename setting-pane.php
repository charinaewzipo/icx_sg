<!-- start agent-main-pane -->
<div id="settings-main-pane">

<input type="hidden" name="fid"> <!--  user field id -->
<input type="hidden" name="exappid"> <!--  external application id -->
<h2 class="page-title" style="display:inline-block;font-family:raleway; color:#666666;"> System Setting </h2>
<div class="stack-subtitle" style="color:#777777;">All System Setting</div>
<hr style="border-bottom: 1px dashed #777777; "> 

 
<!--  wrapper class -->
<div style="width:100%;height:100%; "> 
				<!-- vertical menu -->
				<div style="float:left; width:20%; display:block; border:0px solid #000;">
					<ul style="display:block; margin:0; padding:0; list-style:none" id="setting-menu" >
						<li id="setting-tab1" class="popup-vertical-menu setting-bg-white" style="padding:5px 5px 5px 15px; position:relative; ">
							<span style="font-size:16px; font-family:raleway; display:block; "> User Field Defined </span>
							<span style="font-size:12px; font-family:raleway; color:#666;"> Add field to system mapping field </span>
							<div id="setting-tab1-active" style=" position:absolute; top:10px;right:-18px; font-size:28px; color:#2196f3; z-index:1;" class="icon-play-alt"> </div>
						</li>
						<li id="setting-tab2" class="popup-vertical-menu"  style="padding:5px 5px 5px 15px; position:relative; ">
							<span style="font-size:16px; font-family:raleway; display:block; "> Register External App </span>
							<span style="font-size:12px; font-family:raleway; color:#666;"> Add New Application To Campaign</span>
							<div id="setting-tab2-active"  style="display:none;  position:absolute; top:10px;right:-18px; font-size:28px; color:#2196f3; z-index:1;" class="icon-play-alt"> </div>
						</li>
						<!-- 
						<li id="setting-tab3" class="popup-vertical-menu"  style="padding:5px 5px 5px 15px; position:relative; ">
							<span style="font-size:16px; font-family:raleway; display:block; "> Call Work Tab On Wrapup</span>
							<span style="font-size:12px; font-family:raleway; color:#666;"> Configuration Wrapup Category</span>
							<div id="setting-tab3-active"  style="display:none; position:absolute; top:10px;right:-18px; font-size:28px; color:#2196f3; z-index:1;" class="icon-play-alt"> </div>
						</li>
						<li id="setting-tab4" class="popup-vertical-menu"  style="padding:5px 5px 5px 15px;position:relative;  ">
							<span style="font-size:16px; font-family:raleway; display:block; "> Telephony Integration </span>
							<span style="font-size:12px; font-family:raleway; color:#666;"> Setting Asterisk Manager Interface</span>
							<div id="setting-tab4-active"  style="display:none; position:absolute; top:10px;right:-18px; font-size:28px; color:#2196f3; z-index:1;" class="icon-play-alt"> </div>
						</li>
						 -->
					</ul>
				</div>
				<!--  float right -->
				<div style="float:right; width:80%; display:block;border:0px solid #000;">
						<!--  start setting tab1 pane -->
						<div id="setting-tab1-pane" style="display:nones; padding:20px 25px; min-height:500px;" class="panel panel-default " >
									<h3 style="font-family:raleway;color:#555; margin:0; padding:0px"> User Field Defined </h3>
									<p style="font-family:raleway;color:#666;padding:5px 0;"> Add field to system mapping field </p>
									<hr style="margin:0 0 15px 0;padding:0"/>
									
									<!--  start -->
									<div style="margin:0 5px;" id="user-field-main-pane">
									
											<div style="margin:10px 0">
													<button class="btn btn-success new_ufield" style="width:100px;">  New </button>
													<button class="btn btn-danger delete_ufield" style="width:100px;"> Delete </button>
											</div>
											
											 <table class="table table-bordered" id="user-field-table">
											 	<thead>
											 		<tr class="primary">
											 			<td style="width:5%; text-align:center">Seq </td>
											 			<td style="width:15%; text-align:center"> Field Define Name </td>
											 			<td style="width:10%; text-align:center"> Field Type </td>
											 			<td style="width:10%; text-align:center"> Field Status  </td>
											 			<td style="width:15%; text-align:center"> Create User</td>
											 			<td style="width:15%; text-align:center"> Create Date</td>
											 		</tr>
											 	</thead>
											 	<tbody class="table-hover">
											 	</tbody>
											 	<tfoot>
											 	</tfoot>
											 </table>
										</div>	
											
											<div style="margin:0 5px; display:none" id="user-field-detail-pane" >
											<div style="position:relative;">
													<div id="user-defined-back-main" style="float:left; display:inline-block;cursor:pointer; ">
															<i style="color:#666;  " class="icon-circle-arrow-left icon-3x" ></i>
														</div>
														<div  style="display:inline-block; float:left; margin-left:5px;">
															 <h2 style="font-family:raleway; color:#666666;  margin:0; padding:0"> Back </h2>
														 	<div class="stack-subtitle" style="color:#777777; ">Back to user defined main menu</div>
														</div> 
													<div style="clear:both"></div>
											</div>
											  
											<div style="margin:10px 0">
													<button class="btn btn-success new_ufield" style="width:100px;">  New </button>
													<button class="btn btn-danger delete_ufield" style="width:100px;"> Delete </button>
											</div>
	
											  <table class="table table-bordered">
											  		<tbody>
											  				<tr>
											  			<td style="width:25%; text-align:right;vertical-align:middle"> Field Define as Name ( alias name ): </td>
											  			<td style="width:75%"> <input type="text" name="userdefine" autocomplete="off" maxlength="12"> 
											  			English character only <br/>
											  			(NOt allow any sign character except under score ) AND not duplicate with current field name 
											  			length not over 12 character
											  			</td>
											  			</tr>
											  			<tr>
											  				<td style="text-align:right;vertical-align:middle"> Field Type : </td>
											  				<td> 
											  					<select name="fieldtype"> 
											  						<option value="caption">Small Text </option>
											  						<option value="text"> Text </option>
											  						<option value="decimal"> Decimal </option>
											  						<option value="integer"> Integer </option>
											  						<option value="percent"> Percent </option>
											  						<option value="currency"> Currency </option>
											  						<option value="email"> Email </option>
											  						<option value="phone"> Phone </option>
											  						<option value="age"> Age </option>
											  						<option value="date"> Date </option>
											  						<option value="time"> Time </option>
											  						<option value="datetime"> DateTime </option>
											  					</select>
											  				</td>
											  			</tr>
											  		<tr>
											  				<td style="text-align:right;vertical-align:middle"> Field Status : </td>
											  				<td> 
											  					<select name="fieldstatus"> 
											  						<option value="1"> Active </option>
											  						<option value="0"> Inactive </option>
											  						</select>
											  				</td>
											  			</tr>
											  		</tbody>
											  </table>
											  
											  <button class="btn btn-primary save_ufield"> Save </button>
										</div> 
											  
											  
										<!--  end  -->
						</div>
				<!--  end setting tab1 pane -->
						
				<!--  start setting tab2 pane -->
						<div id="setting-tab2-pane" style="display:none; padding:20px 25px; min-height:500px;" class="panel panel-default " >
								<h3 style="font-family:raleway;color:#555; margin:0; padding:0px"> Register External Application </h3>
								<p style="font-family:raleway;color:#666;padding:5px 0;"> Add New Application </p>
								<hr style="margin:0 0 15px 0;padding:0"/>
								<!--  start  --> 
								
									<div style="margin:0 5px;" id="exapp-main-pane">
									
										<div style="margin:10px 0">
											<button class="btn btn-success new_exapp" style="width:100px">  New </button>
										 <!--  <button class="btn btn-danger delete_exapp" style="width:100px"> Delete </button>  -->
										</div>
										 
											 <table class="table table-bordered" id="exapp-table">
											 	<thead> 
											 		<tr class="primary">
											 			<td style="width:5%; text-align:center">Seq </td>
											 			<td style="width:15%; text-align:center"> Campaign Name </td>
											 			<td style="width:15%; text-align:center"> App Name </td>
											 			<td style="width:10%; text-align:center"> App URL </td>
											 			<td style="width:10%; text-align:center"> Status  </td>
											 			<td style="width:15%; text-align:center"> Create User</td>
											 			<td style="width:15%; text-align:center"> Create Date</td>
											 		</tr>
											 	</thead>
											 	<tbody class="table-hover">
											 	</tbody>
											 	<tfoot> 
											 	</tfoot>
											 </table>
										</div>	
											
											<div style="margin:0 5px; display:none" id="exapp-detail-pane" >
											<div style="position:relative;">
													<div id="exapp-back-main" style="float:left; display:inline-block;cursor:pointer; ">
															<i style="color:#666;  " class="icon-circle-arrow-left icon-3x" ></i>
														</div>
														<div  style="display:inline-block; float:left; margin-left:5px;">
															 <h2 style="font-family:raleway; color:#666666;  margin:0; padding:0"> Back </h2>
														 	<div class="stack-subtitle" style="color:#777777; ">Back to user defined main menu</div>
														</div> 
													<div style="clear:both"></div>
											</div>
											
											<div style="margin:10px 0">
												<button class="btn btn-success new_exapp" style="width:100px;">  New </button>
												<button class="btn btn-danger delete_exapp" style="width:100px;"> Delete </button>
											</div>
											
	
											  <table class="table table-bordered">
											  		<tbody>
											 			<tr>
											 				<td style="width:25%; text-align:right;vertical-align:middle"> External App Use In Campaign Name : </td>
												  			<td style="width:75%"> 
												  				<select name="exapp_campaign" >
												  				</select>
												  			</td>
											 			</tr>
											  		
											  			<tr>
												  			<td style="width:25%; text-align:right;vertical-align:middle"><span style="color:red"> * </span>  External Application Name : </td>
												  			<td style="width:75%"> 
												  				<input type="text" name="exapp_name" autocomplete="off" > 
												  			</td>
											  			</tr>
											  			<tr>
												  			<td style="width:25%; text-align:right;vertical-align:middle"> <span style="color:red"> * </span> External Application URL : </td>
												  			<td style="width:75%"> 
												  				<input type="text" name="exapp_url" autocomplete="off" > 
																<input type="file" name="file_upload" id="file_upload">
												  			</td>
											  			</tr>
											  			<tr>
												  			<td style="width:25%; text-align:right;vertical-align:middle"> External Application Icon : </td>
												  			<td style="width:75%"> 
												  				<input type="text" name="exapp_icon" autocomplete="off" > 
												  			</td>
											  			</tr>
											  			<tr>
												  			<td style="width:25%; text-align:right;vertical-align:middle"> External Application Status : </td>
												  			<td style="width:75%"> 
												  					<select name="exapp_sts">
												  						<option value="1"> Active </option>
												  						<option value="2"> Inactive </option>
												  					</select>
												  			</td>
											  			</tr>
											  		</tbody>
											  </table>
											  
											  <button class="btn btn-primary save_exapp" style="width:100px;"> Save </button>
										</div> 
											  
									
								<!-- end -->
						</div>
						<!--  end setting tab2 pane -->
						
						<!--  start setting tab3 pane -->
						<div id="setting-tab3-pane" style="display:none; padding:20px 25px; min-height:500px;"  class="panel panel-default " >
								<h3 style="font-family:raleway;color:#555; margin:0; padding:0px"> Call Work Tab On Wrapup  </h3>
								<p style="font-family:raleway;color:#666;padding:5px 0;"> Hello World</p>
								<hr style="margin:0;padding:0"/>
								แบ่งก่อนว่า remove ไม่ remove list
								ถ้าไม่ remove จัดไปอยู่ category ( tab  ไหน )
								
						</div>
						<!--  end setting tab3 pane -->
								
						<!--  start setting tab4 pane -->
						<div id="setting-tab4-pane" style="display:none; padding:20px 25px; min-height:500px;" class="panel panel-default " >
							<h3 style="font-family:raleway;color:#555; margin:0; padding:0px"> Telephony Integration  </h3>
								<p style="font-family:raleway;color:#666;padding:5px 0;"> Setting Asterisk Manager Interface</p>
								<hr style="margin:0;padding:0"/>
								
						</div>
						<!--  end setting tab4 pane -->
				
						
						
				</div>
</div>
<!--  end div wrapper -->
<div style="clear:both"></div>




<div style="display:none" id="setting-pane">
	
	
	
</div>



</div>
<!--  end agent-detail-pane -->
<script type="text/javascript" src="js/settings-userfield.js"></script>
<script type="text/javascript" src="js/settings-externalapp.js"></script>
<script>
$(function(){
	  
	//setting-pane click on tab  
	  $('#setting-tab1').click( function(e){
		  e.preventDefault();
		  $('#setting-menu li').removeClass('setting-bg-white');
		  $('#setting-tab1').addClass('setting-bg-white');
		  $('#setting-tab1-pane,#setting-tab2-pane,#setting-tab3-pane,#setting-tab4-pane').hide();
		  $('#setting-tab1-active,#setting-tab2-active,#setting-tab3-active,#setting-tab4-active').hide();
		  
		  $('#setting-tab1-pane').fadeIn('slow');
		  $('#setting-tab1-active').show();
	  })
	  
	   $('#setting-tab2').click( function(e){
		  e.preventDefault();
		  $('#setting-menu li').removeClass('setting-bg-white');
		  $('#setting-tab2').addClass('setting-bg-white');
		  $('#setting-tab1-pane,#setting-tab2-pane,#setting-tab3-pane,#setting-tab4-pane').hide();
		  $('#setting-tab1-active,#setting-tab2-active,#setting-tab3-active,#setting-tab4-active').hide();
		  
		  $('#setting-tab2-pane').fadeIn('slow');
		  $('#setting-tab2-active').show();
	  })
	  
	   $('#setting-tab3').click( function(e){
		  e.preventDefault();
		  $('#setting-menu li').removeClass('setting-bg-white');
		  $('#setting-tab3').addClass('setting-bg-white');
		  $('#setting-tab1-pane,#setting-tab2-pane,#setting-tab3-pane,#setting-tab4-pane').hide();
		  $('#setting-tab1-active,#setting-tab2-active,#setting-tab3-active,#setting-tab4-active').hide();
		  
		  $('#setting-tab3-pane').fadeIn('slow');
		  $('#setting-tab3-active').show();
	  })
	  
	   $('#setting-tab4').click( function(e){
		  e.preventDefault();
		  $('#setting-menu li').removeClass('setting-bg-white');
		  $('#setting-tab4').addClass('setting-bg-white');
		  $('#setting-tab1-pane,#setting-tab2-pane,#setting-tab3-pane,#setting-tab4-pane').hide();
		  $('#setting-tab1-active,#setting-tab2-active,#setting-tab3-active,#setting-tab4-active').hide();
		  
		  $('#setting-tab4-pane').fadeIn('slow');
		  $('#setting-tab4-active').show();
	  })
	  //end tab click
	  
	
})
</script>
