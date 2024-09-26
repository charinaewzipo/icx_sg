
<div class="container">
	<div class="row">
	
		<div style="padding: 5px 5px;">
				<div style="display:inline-block; position:relative; top:-12px;">
				</div>
				<div style="display:inline-block; position:relative; float:right">
				        <span id="newcmp-close" class="ion-ios-close-outline close-model" style=""></span>
				</div>
				<div style="clear:both"></div>
		</div>
		
			<!--  wrappper -->
	    			<div style="padding:0px;width:100%">
	    			<!--  float left -->
	    				<div style="float:left; width:60%;">
	    				
	    						<!-- start div padding -->
	    						<div style="margin-right:10px;padding:10px; padding-top:0; background-color:#f2f2f2; border-radius:3px;">
	    								<h3 style="text-align:center; font-weight:300;">Create New Campaign </h3>
	    								
												<table border="0" style="width:100%;  ">
														<tbody>
																<tr>
																	<td colspan="2" style="padding:10px 0 5px 50px; color:#666" >Campaign Name</td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:0 0 5px 50px; color:#666" ><span style="color:red; font-size:12px; display:none" id="ncmpName-msg"></span></td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="ncmpName" style="width:100%;" placeholder="required field *" autocomplete="off" ></td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:10px 0 5px 50px; color:#666" >Campaign Code</td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="ncmpCode" style="width:100%;" placeholder="campaign code" autocomplete="off" ></td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Campaign Detail 	</td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:0px 50px 5px 50px"  ><textarea type="text" name="ncmpDetail" style="width:100%; height:100px;"  placeholder="describe about campaign name" autocomplete="off" ></textarea></td>
																</tr>
																<tr>
																	<td style="padding:10px 0 5px 50px; color:#666" >Campaign Category</td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:0px 50px 5px 50px"  ><select name="ncmpType"><option></option></select></td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:10px 0 0px 50px;color:#666" ><input type="radio" name="ncmpExpire" checked value="0"> &nbsp; This campaign has no expiry date.</td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:0px 0 5px 50px;color:#666" ><input type="radio" name="ncmpExpire" value="1"> &nbsp; This campaign has expiry date. </td>
																</tr>
																<tr>
																	<td style="padding:10px 0 5px 50px; color:#666" >Campaign Start Date 	</td>
																	<td style="padding:10px 0 5px 10px; color:#666; text-align:left" > Campaign End Date </td>
																</tr>
																<tr>
																	<td style="padding:0px 0px 0px 50px; color:#666" ><span style="color:red; font-size:12px; display:none" id="ncmpStartDate-msg"></span></td>
																	<td style="padding:0px 0px 0px 10px; color:#666; text-align:left" ><span style="color:red; font-size:12px; display:none" id="ncmpEndDate-msg"></span></td>
																</tr>
																<tr> 
																	<td style="padding:0px 0px 5px 50px; color:#666; " ><input type="text" name="ncmpStartDate" style="width:100%;" class="calendar_en"></td>
																	<td style="padding:0px 50px 5px 10px; color:#666; "><input type="text" name="ncmpEndDate" style="width:100%;" class="calendar_en"></td>
																</tr>
																	<tr>
																		<td style="padding:10px 0 5px 50px; color:#666" >Max trying call </td>
																	</tr>
																	<tr>
																			<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type='text'  style="width:100%;" name="ncmpMaxCall" placeholder="input number only"></td>
																	</tr>
																	<tr>
																		<td style="padding:10px 0 5px 50px;color:#666" >Genesys CampaignID </td>
																	</tr>
																	<tr>
																		<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="ncmpGeneCampaign" style="width:100%;" placeholder="input genesys campaignid" autocomplete="off"></td>
																	</tr>
																	<tr>
																		<td style="padding:10px 0 5px 50px;color:#666" >Genesys QueueID </td>
																	</tr>
																	<tr>
																		<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="ncmpGeneQueue" style="width:100%;" placeholder="input genesys queueid" autocomplete="off"></td>
																	</tr>
																	<tr>
																		<td style="padding:10px 0 5px 50px; color:#666" >External Application</td>
																	</tr>
																	<tr>
																		<td colspan="2" style="padding:0px 50px 5px 50px"  ><select name="ncmpApp"><option></option></select></td>
																	</tr>
																<tr>
																	<td colspan="2" style="padding:20px 50px 20px 50px; text-align:right; "  >
																			<button class="btn btn-success create_campaign" style="border-radius:3px;">&nbsp;&nbsp; Save Changes &nbsp;&nbsp;</button>
																	</td>
																</tr>
																</tbody>
													</table>
								</div>		
	    						<!-- end div padding -->
	    				
	    				</div>
	    				<!--  end float left -->
	    				<!--  float right -->
	    				<div style="float:right; width:40%;">
	    					<div style="border:1px dashed #999; height:600px; display:nones; width:100%;"  >
	    							<div style="position:relative;">
    											<h3 style="text-align:center; font-weight:300; "> Sale Script </h3>
    												<table border="0" style="width:100%;  ">
													<tbody>
															<tr>
																<td colspan="2" style="padding:10px 0 5px 30px; color:#666" >&nbsp;Campaign Sale Script</td>
															</tr>
															<tr>
																<td colspan="2" style="padding:10px 0 5px 30px; color:#666" ><select name="nscriptname"><option></option></select></td>
															</tr>
															<tr>
																<td colspan="2" style="padding:0px 30px 5px 30px"  ><textarea type="text" name="nscriptdtl" style="width:100%; height:440px;"  placeholder="campaign sale script detail"></textarea></td>
															</tr>
													</tbody>
												</table>
	    							</div>
	    					</div>
	    					
	    				</div>
					 <!--  end float right -->
						<div style="clear:both"></div>	
	    			</div>
					<!--  end wrapper -->	
		
		</div>
		<!--  end div row -->
</div>
<!--  end div container -->
<script>
	$(function(){

		//init campaign
		$.campaign.init();

		  //change sale script in create campaign page
		 $('[name=nscriptname]').change( function(){
			 var id = $(this).val();
			 if( id != "" ){
				    $.ajax({   'url' : "saleScript-pane_process.php", 
					   'data' : { 'action' : 'detail','id': id }, 
				
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
						   'beforeSend': function(){
							   //set image loading for waiting request
							   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
							},										
							'success' : function(data){ 
							//remove image loading 
							//$('#loading').html('').append("Project Management Sheet");
				
			                 var  result =  eval('(' + data + ')'); 
			
			                 $('[name=nscriptdtl]').val(result.data.sdetail);
			                 
							}//end success
						});//end ajax 
			 }else{
				  $('[name=nscriptdtl]').val("");
			}
		 })

		 //check new campaign 
		  $('[name=ncmpName]').focusout( function(){
				if( $('[name=cmpuniqueid]').val() == "" ){

						//check dupcliate name
					    $.ajax({   'url' : "campaign-pane_process.php", 
											   'data' : { 'action' : 'check','cmpname':  $('[name=ncmpName]').val() }, 
											   'dataType' : 'html',   
											   'type' : 'POST' ,  
												'success' : function(data){ 
												//remove image loading 
												//$('#loading').html('').append("Project Management Sheet");
									
								                 var  result =  eval('(' + data + ')'); 

													if(result.result == "duplicate"){
															$('#ncmpName-msg').text('').text('* This camapign name already taken. Please change to another name.')
															.fadeIn('medium', function(){
																$('[name=ncmpName]').focus();
															});
													}else{
														$('#ncmpName-msg').fadeOut('fast');
													}
										         		
								                 
												}//end success
											});//end ajax 
				}
		  })
		  

		  //init calendar
		  $('.calendar_en').datepicker({
		        dateFormat: 'dd/mm/yy'
		    });
		    
		  //btn close page new campaign
		  $('#newcmp-close').click( function(){
				$('#new-campaign-pane').fadeOut('slow');
			});
			
		  //save new campaign button
		  $('.create_campaign').click( function(e){
		  		e.preventDefault();
				//1. check campaign name is empty 
				if( $('[name=ncmpName]').val() == "" ){
						$('#ncmpName-msg').text('').text('* Camapign name can not empty. Please fill the campaign name.')
						.fadeIn('medium', function(){
							$('[name=ncmpName]').focus();
						});
						return;
				}

				//2. check is name is already taken
		  		
		  		//3. check start_date , end_date
		  		if( $('[name=ncmpStartDate]').val() != "" ){
		  				if( $('[name=ncmpEndDate]').val() == ""){
			  				
		  					$('#ncmpEndDate-msg').text('').text('*Please fill campaign end date.')
							.fadeIn('medium', function(){
								$('[name=ncmpEndDate]').focus();
							});
		  					return;
			  			}
			  	}
		  		if( $('[name=ncmpEndDate]').val() != "" ){
	  				if( $('[name=ncmpStartDate]').val() == ""){

	  					$('#ncmpStartDate-msg').text('').text('*Please fill campaign start date.')
						.fadeIn('medium', function(){
							$('[name=ncmpStartDate]').focus();
						});
	  					return;
		  			}
		  		}
		  		
		  		//4. check start_date , end_date date format
		  		
		  		
		  		//all ok then save
				$.campaign.create();
		  });

	

			
	});
</script>

	