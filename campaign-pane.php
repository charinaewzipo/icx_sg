<!-- start campaign-main-pane -->
<div id="campaign-main-pane" >
<h2 style="display:inline-block;font-family:raleway; color:#666666;"> Campaign </h2>
<div class="stack-subtitle" style="position:relative; color:#777777;top:-10px; text-indent:5px;">All Campaign  </div>
<hr style="position:relative;border-bottom: 1px dashed #777777; top:-10px;"> 
  	 <button class="btn btn-success new_campaign"> Create Campaign </button> &nbsp;&nbsp;
<br/>
<br/>
	
	<!-- 
	<div style="background-color:#fff; z-index:555; opacity:0.2; position:relative">
		<div class="ion-ios7-reloading size-38" style="position:absolute; left:50%;top:50%"></div> 
		 -->
		<table id="campaign-table" class="table table-bordered">
		<thead>
			<tr class="primary">
				<td class="text-center" style="width:5%"> # </td>
				<td class="text-center" style="width:35%"> Campaign Name </td>
				<td class="text-center" style="width:20%"> Campaign Start Date </td>
				<td class="text-center" style="width:20%"> Campaign End Date  </td>
				<td class="text-center" style="width:20%"> Status  </td>
			</tr>
		</thead>
		<tbody>
		</tbody>
		<tfoot>
		</tfoot>
		</table>
		<!-- 
	</div>		
	 -->
</div>
<!--  end campaign-main-pane -->

<!-- start campaign-detail-pane -->
<div id="campaign-detail-pane" style="display:none">
	<div style="position:relative;">
			<div id="campaign-back-main" style="float:left; display:inline-block;cursor:pointer; ">
					<i style="color:#666;  " class="icon-circle-arrow-left icon-3x" ></i>
				</div>
				<div  style="display:inline-block; float:left; margin-left:5px;">
					 <h2 style="font-family:raleway; color:#666666;  margin:0; padding:0"> Campaign Detail</h2>
				 	<div class="stack-subtitle" style="color:#777777; ">Campaign Detail</div>
				</div> 
			<div style="clear:both"></div>
	</div>
 <hr style="border-bottom: 1px dashed #999999; position:relative; "/>
 	   <div style="position:relative;margin-bottom:0px; top:-10px;" >
  		    <button class="btn btn-success new_campaign"> <i class="fa fa-plus-circle"></i> Create Campaign </button> &nbsp;&nbsp;
		</div>
					    
		 <ul class="nav nav-tabs" role="tablist">
			<li  class="active" style="vertical-align:bottom; font-size:16px;"> <a href="#tab1" role="tab" data-toggle="tab" ><span class="ion-ios-world-outline icon-2x" style=";"></span> &nbsp; Campaign Detail </a></li>
	  	  	 <li style="vertical-align:bottom; font-size:16px;"><a href="#tab3" role="tab" data-toggle="tab" ><span class="ion-ios-copy-outline icon-2x" style=""></span> &nbsp;  Campaign List </a></li>
	  	  	 <li style="vertical-align:bottom; font-size:16px;"><a href="#tab4" role="tab" data-toggle="tab" ><span class="ion-ios-albums-outline icon-2x" style=""></span> &nbsp;   Campaign Field </a></li>
	  	  	<li style="vertical-align:bottom; font-size:16px;" id="campaign-wrapup"> <a href="#tab2" role="tab" data-toggle="tab" ><span class="ion-ios-list-outline icon-2x" style=""></span> &nbsp;  Campaign Wrapup </a></li>
	  	  	<li style="vertical-align:bottom; font-size:16px;" id="campaign-summary"><a href="#tab5" role="tab" data-toggle="tab" > <span class="ion-ios-pie-outline icon-2x" style=""></span> &nbsp;  Campaign Summary </a></li>
	   </ul>
	    <div class="tab-content">
	 			<!--  tab1 Campaign Detail -->
	 		
	    		<div id="tab1" class="tab-pane active"  style="background-color:#fff">
	    		<!--  wrappper -->
	    			<div style="padding:20px;width:100%">
	    			<!--  float left -->
	    				<div style="float:left; width:60%;">
	    				
	    						<!-- start div padding -->
	    						<div style="margin-right:20px;padding:10px;background-color:#f2f2f2; border-radius:3px;">
	    							<h3 style="text-align:center;font-weight:300;" id="cmp-detail-name"></h3>
	    							<table border="0" style="width:100%;  ">
												<tbody>													
														<tr>
															<td colspan="2" style="padding:10px 50px 0px 50px;color:#aaa; text-align:right; border:0px solid #000;" >Campaign Status : <span id="cmpStatus" style="font-size:12px; color:#fff;  padding:2px 8px 2px 8px; border-radius:3px;"> In used</span></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:2px 50px 0px 50px; color:#aaa; text-align:right; border:0px solid #000;" >Create Date : <span id="cmpCreated" style="color:#888"></span></td>
														</tr> 
														<tr>
															<td colspan="2" style="padding:0px 50px 0px 50px; color:#aaa; text-align:right; border:0px solid #000;" >Create By : <span id="cmpCreateu" style="color:#888"></span></td>
														</tr> 
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px; color:#666" >&nbsp;Campaign Name 	</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="cmpName" style="width:100%;" placeholder="required field *"  autocomplete="off"></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px; color:#666" >&nbsp;Campaign Code 	</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="cmpCode" style="width:100%;" placeholder="campaign code"  autocomplete="off"></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Campaign Detail 	</td>
														</tr>
															<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><textarea type="text" name="cmpDetail" style="width:100%; height:100px;"  placeholder="describe about campaign name"></textarea></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Campaign Category</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><select name="cmpCat"></select></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 0px 50px;color:#666" >&nbsp; <input type="radio" name="cmpExpire" value="0"> &nbsp; This campaign has no expiry date.</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 0 5px 50px;color:#666" >&nbsp; <input type="radio" name="cmpExpire" value="1"> &nbsp; This campaign has expiry date. </td>
														</tr>
														<tr>
															<td style="padding:10px 0 5px 50px; color:#666" >&nbsp;Campaign Start Date 	</td>
															<td style="padding:10px 0 5px 10px; color:#666; text-align:left" >&nbsp;Campaign End Date </td>
														</tr>
														<tr> 
															<td style="padding:0px 0px 5px 50px; color:#666; " ><input type="text" name="cmpStartDate" style="width:100%;" ></td>
															<td style="padding:0px 50px 5px 10px; color:#666; "><input type="text" name="cmpEndDate" style="width:100%;" ></td>
														</tr>
														
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Campaign Sale Script 	</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><select name="scriptname"></select></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><textarea type="text" name="scriptdtl" style="width:100%; height:100px;"  placeholder="describe about campaign name" autocomplete="off" ></textarea></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Max Trying Call 	</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="cmpMaxCall" style="width:100%;" placeholder="input number only" autocomplete="off"></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Campaign Type 	</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><select name="cmpType" style="width:150px;">
																<option value="normal">Normal</option>
																<option value="confirm">Confirm Call</option>
															</select></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Campaign Status 	</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><select name="cmpStatus" style="width:150px;">
																<option value="1">New</option>
																<option value="2">Ready</option>
																<option value="3">In use</option>
																<option value="4">Stop</option>
																<option value="5">Expire</option>
															</select></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Genesys CampaignID 	</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="cmpGeneCampaign" style="width:100%;" placeholder="input genesys campaignid" autocomplete="off"></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;Genesys QueueID 	</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><input type="text" name="cmpGeneQueue" style="width:100%;" placeholder="input genesys queueid" autocomplete="off"></td>
														</tr>
														<tr>
															<td colspan="2" style="padding:10px 0 5px 50px;color:#666" >&nbsp;External Application</td>
														</tr>
														<tr>
															<td colspan="2" style="padding:0px 50px 5px 50px"  ><select name="cmpApp"></select></td>
														</tr>
														
														<tr>
															<td colspan="2" style="padding:20px 50px 20px 50px; text-align:right; "  >
																	<button class="btn btn-success update_campaign" style="border-radius:3px;">&nbsp;&nbsp; Save Changes &nbsp;&nbsp;</button>
															</td>
														</tr>
														<!--
														<tr>
														<td colspan="2"> Sale Script <a href="#" class="create_salescript"> Create Sale Script</a> </td>
														</tr>
														<tr>
															<td> Sale Script Name : </td>
															<td> 
																<select name="scriptname"></select>
															</td>
														</tr> 
														<tr>
															<td>  Sale Script Detail : </td>
															<td> <textarea name="scriptdtl"> </textarea></td>
														</tr> 
												</tbody>
												<tfoot>
													<tr>
														<td colspan="2" style="text-align:right"> 
																<button class="btn btn-success save_campaign"> Save </button>
																&nbsp;&nbsp;
																<button class="btn btn-default cancel_campaign"> Cancel </button>
														</td>
													</tr>
												</tfoot>
												 -->
										</table>			  
										<div id="salescript-pane" style="display:none"></div>
										
	    						</div>		
	    						<!-- end div padding -->
	    				
	    				</div>
	    				<!--  end float left -->
	    				<!--  float right -->
	    				<div style="float:right; width:40%; ">
	    					
	    					<div style="border:1px dashed #999; height:562px; display:table; width:100%;" >
	    							<div style="position:relative; display:table-cell; text-align:center; vertical-align:middle">
	    								
	    									<!--  stop campaign -->
	    									<div id="cmp-stop-pane" style="display:none">
	    									
	    											<p style="font-size:22px; color:#666;"> Stop Campaign </p>
						    						<div style="font-size:12px; color:#666;"> If campaign staus is "in use" after stop campaign already you can delete it. </div>
						    						<div style="font-size:12px; color:#666;"> effect to all agent that join this campaign they can't make call. </div>
						    						<br/>
						    						<br/>
						    						<p style="font-size:12px; color:#666;"> <input type="checkbox" name="confirm_stop_cmp"> I'm sure to stop this campaign now. </p>
				    								<button class="btn stopcmp" style="border-radius:2px; background-color:#ff9500; color:#fff;"> Stop Campaign  </button> <br/>
	    									
	    									</div>
	    					
	    									<!--  delete campaign -->
	    									<div id="cmp-delete-pane" style="display:none">
	    											<div style="font-size:22px; color:#666;"> Delete Campaign </div>
						    						<div style="font-size:12px; color:#666;"> Process delete this campaign.</div>
						    						<div style="font-size:12px; color:#ed5565;"> This action cannot be undone.  </div>
						    						<br/>
							    					<br/>
							    					<p style="font-size:12px; color:#666;"> <input type="checkbox" name="confirm_delete_cmp"> I'm sure to delete this campaign. </p>
				    								<button class="btn btn-danger deletecmp" style="border-radius:2px;"> Delete Campaign  </button> <br/>
	    									</div>
	    									
	    									<!--  start | delete campaign -->
	    										<div id="cmp-startdelete-pane" style="display:none;height:100%;">
	    										<table border="0" style="width:100%; height:400px;">
	    											<tr>
	    												<td style="width:50%; text-align:right; padding-right:20px;"> 
				    											<p style="font-size:22px; color:#666;"> Start Campaign </p>
				    											<div style="font-size:12px; color:#666; "> After start campaign all agent that join</div>
									    						<div style="font-size:12px; color:#666; ">  this campaign  they can continue call. </div>
									    						<br/>
									    						<p>&nbsp;</p>
							    								<button class="btn btn-success startcmp" style="border-radius:2px;"> Start Campaign </button> <br/>
	    												</td>
	    												<td style="width:0%;height:470px; margin-top: 5px; border-left:1px dashed #ccc; text-align;center;">
	    													<div style="position:relative;">
	    															<div style="position:absolute; top:-150px; left: -22px; font-size:30px; color:#666; background-color:#fff" > OR </div>
	    													</div>
	    												</td>
	    												<td style="width:50%;text-align:left;  padding-left:20px;"> 
	    													<p style="font-size:22px; color:#666; "> Delete Campaign </p>
								    						<div style="font-size:12px; color:#666;">  Process delete this campaign.</div>
								    						<div style="font-size:12px; color:#ed5565; "> This action cannot be undone.  </div>
							    							<br/>
							    							<p style="font-size:12px; color:#666;"> <input type="checkbox" name="">  I'm sure to delete this campaign. </p>
				    										<button class="btn btn-danger deletecmp" style="border-radius:2px;"> Delete Campaign  </button> <br/>
	    												
	    												</td>
	    											</tr>
	    										</table>
	    										
	    									
						    			
				    								
	    									</div>
	    									<!--  end test -->
	    									
	    							</div>
	    					</div>    			
	    					
	    						
	    				</div>
					 <!--  end float right -->
						<div style="clear:both"></div>	
	    			</div>
					<!--  end wrapper -->	
	    		</div>
	    		<!--  end tab1 -->
	    		
	   <!--   tab2 Campaign Wrapup -->
	   <div id="tab2" class="tab-pane "  >
				<!--  start tree  -->    		
				  <div style="padding:20px 0">
				  <!--  left pane -->
				  <div style="float:left; width:50%">
					  <ul class="tree">
						  	 <li> Start
						 		<ul id="wtree" > 	 </ul>
						    </li>
					   </ul>
				 </div>
				 <!--  end left pane -->
	 
				 <!--  right pane -->
				 <div style="right:left; width:50%">
						 <table style="width:100%;">
				    			 			<thead>
				    			 				<tr>
				    			 					<td style="text-align:right"> Wrapup Code &nbsp;</td>
				    			 					<td> <input type="text" name="wcode"></td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td style="text-align:right"> Wrapup detail &nbsp;</td>
				    			 					<td> <input type="text" name="wdtl"></td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td style="text-align:right"> Wrapup parent code &nbsp;</td>
				    			 					<td> <input type="text" name="pcode"></td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td style="text-align:right"> Wrapup seq &nbsp;</td>
				    			 					<td> <input type="text" name="seq"></td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td style="text-align:right"> Wrapup sts &nbsp;</td>
				    			 					<td> <input type="text" name="sts"></td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td style="text-align:right"> Wrapup IS Remove from new list [ 0=no , 1=yes ] &nbsp;</td>
				    			 					<td> <input type="text" name="rmlist"></td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td style="text-align:right"> Wrapup option id &nbsp;</td>
				    			 					<td> <input type="text" name="woptid"></td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td style="text-align:right"> Genesys Wrapup id &nbsp;</td>
				    			 					<td> <input type="text" name="genewid"></td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td colspan="2" style="text-align:center"><input type="button" name="save_tree" value="save">  |  <input type="button" name="del_tree" value="delete">     </td>
				    			 				</tr>
				    			 				<tr>
				    			 					<td colspan="2" style="text-align:center"> &nbsp; </td>
				    			 					</tr>
				    			 					<tr>
				    			 					<td colspan="2" style="text-align:center"> <input type="button" name="save_tree" value="cancel ( currently not support )">   </td>
				    			 				</tr>
				    			 			</thead>
				    			 		</table>
				 	</div>
				 	<!--  end right pane -->
				 </div>
				   <!--  end wrapup tree --> 		

	    	</div>
	    	<!--  end tab2  -->
	    		
	  		   <!-- tab3 Campaign List -->
	    		<div id="tab3"  class="tab-pane" style="background-color:#fff">
	    		
	    			<div style="width:100%">
	    					<div id="left-panel" style="float:left; width:58%; padding:0 10px; "> 
	    						<h3 style="font-weight:300;"> Campaign List </h3>
	    								<table class="table table-border" id="cmplist-mapped-table">
						    				<thead>
						    					<tr class="primary" >
						    						<td style="width:5%;text-align:center; vertical-align:middle"> # </td>
						    						<td style="width:40%;text-align:left; vertical-align:middle"> List Name </td>
						    						<td style="width:10%;text-align:center; vertical-align:middle"> Total List </td>
						    						<td style="width:10%;text-align:center; vertical-align:middle"> New List </td>
						    						<td style="width:10%;text-align:center; vertical-align:middle"> Used List </td>
						    						<td style="width:10%;text-align:center; vertical-align:middle"> Other List </td>
						    						<td style="width:15%;text-align:center; vertical-align:middle"> List Status</td>
						    					</tr>
						    				</thead>
						    				<tbody class="hover">
						    				</tbody>
						    				<tfoot>
						    				</tfoot>
						    			</table>
	    					</div>
	    					<div id="right-panel" style="position:relative; float:right; width:40%; margin:20px 10px; display:table; background-color:#fff; ">
	    					
			    						<div style="display:table-cell; vertical-align:middle;  text-align:center; border: 1px dashed #999; height:420px;">
			    						
			    						<!--  campaign list not ready -->
				    					<div id="cmplist-campaign-not-ready-pane" style="display:none;" >
				    							<span class="icon-exclamation-sign" style="font-size:80px; text-align:center; display:block;color:#888"> </span> 
				    							<span style="text-align:center; display:block; font-size:22px; color:#888"> Campaign Not Ready</span>
												<span style="text-align:center; display:block; font-size:12px; color:#888"> Please setup campaign field ( in campaign field tab ) before mapping list.</span>
				    					</div>
			    						
			    						<!--  campaign list expire -->
				    					<div id="cmplist-campaignexp-pane" style="display:none;" >
				    							<span class="icon-time" style="font-size:80px; text-align:center; display:block;color:#888"> </span> 
				    							<span style="text-align:center; display:block; font-size:22px; color:#888"> Campaign has expired </span>
												<span style="text-align:center; display:block; font-size:12px; color:#888"> All action has been stopped.</span>
				    					</div>
			    						
			    						<!--  list expire -->
				    					<div id="cmplist-listexp-pane" style="display:none;" >
				    							<span class="icon-eye-close" style="font-size:80px; text-align:center; display:block;color:#888"> </span> 
				    							<span style="text-align:center; display:block; font-size:22px; color:#888"> This list has expired </span>
												<span style="text-align:center; display:block; font-size:12px; color:#888"> All action has been stopped.</span>
				    					</div>
			    						
			    					
			    						<!--  no list  -->
				    					<div id="cmplist-nolist-pane" style="display:none;" >
				    							<span class="ion-ios-information-outline" style="font-size:80px; text-align:center; display:block;color:#888"> </span> 
				    							<span style="text-align:center; display:block; font-size:22px; color:#888"> No List Available </span>
												<span style="text-align:center; display:block; font-size:12px; color:#888"> No list available for mapped.</span>
				    					</div>
				    					
				    					<!--  list pause -->
				    					<div id="cmplist-pause-pane" style="display:none;" >
				    							<span class="icon-pause" style="font-size:80px; text-align:center; display:block;color:#888"> </span> 
				    							<span style="text-align:center; display:block; font-size:22px; color:#888"> Pause List </span>
												<span style="text-align:center; display:block; font-size:12px; color:#888"> This list now pause.</span>
												<br/>
				    							<button class="btn btn-success cmplist-start" style="border-radius:2px;"> Pause List </button>
				    					</div>
				    					
				    					<!--  list resume -->
				    					<div id="cmplist-resume-pane" style="display:none;" >
				    							<span class="icon-play" style="font-size:80px; text-align:center; display:block;color:#888"> </span> 
				    							<span style="text-align:center; display:block; font-size:22px; color:#888"> Resume List </span>
												<span style="text-align:center; display:block; font-size:12px; color:#888"> All action has been stopped.</span>
												<br/>
				    							<button class="btn btn-success cmplist-start" style="border-radius:2px;"> Resume List </button>
				    					</div>
				    					
				    					<!--  start mapping list -->
				    						<div id="cmplist-start-pane" style="display:none">
	    											<div style="font-size:22px; color:#666;">  Mapping  List </div>
						    						<div style="font-size:12px; color:#666;" id="cmplist-start-msg">
						    							 <span class="cmplist_ava" style="font-size:15px; background-color:#f8ac59; color:#fff; padding:2px 8px 2px 8px; border-radius:3px; position:relative; top:1px;"></span>&nbsp; List available for mapping.
						    						</div>
						    						<br/>
							    					<br/>
				    								<button class="btn btn-success cmplist-start" style="border-radius:2px;"> Start Mapping List </button> <br/>
	    									</div>
	    									
	    								<!--  mapping list -->
	    									<div id="cmplist-mapping-pane" style="display:none; vertical-align:top; text-align:left" > 
	    											<table style="width:100%; height:420px;">
	    												<tbody>
	    													<tr>
	    														<td style="width:60%; vertical-align:top; padding:10px;">
	    															<div style="border-top:2px solid #E2E2E2; border-bottom:0px solid #E2E2E2; padding:8px; background-color:#eee;">
																		<span style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#555; font-size:16px;"> Available List </span>
																		<span style="float:right; background-color:#f8ac59; color:#fff; padding:2px 8px 2px 8px; border-radius:3px; font-size:12px;" class="cmplist_ava"> 0 </span>
																	</div>
																		<ul  class="noorder" id="rightbox-ul" ></ul>	
																		<div id="rightbox-ul-empty" style="height:380px; border:1px dashed #999; position:relative;  display:none">
																		<div style="position:relative; display:block; top:15%; text-align:center;vertical-align:middle">
																				<span class="ion-ios7-information-outline" style="font-size:80px; text-align:center; display:block;color:#bbb"> </span>
																				<span style="text-align:center; display:block; font-size:22px; color:#999"> All List are already mapped.</span>
																				<span style="text-align:center; display:block; font-size:12px; color:#999"> </span>
																		</div>
																	</div>		
	    														
	    														</td>
	    														<td style="width:5%;  ">
	    																	<div style=" border-right: 1px solid #ccc; width:2px; height:300px; position:relative; left:5px; top:0;"></div>
	    														</td>
	    														<td style="width:35%;text-align:left; vertical-align:middle">
	    													
						    												<div style="font-size:22px; color:#666;"> Save Changes </div>
																			<div style="font-size:12px; color:#666;"> Save change for <span id="mapping-total-msg" style="color:#009688">  </span> mapping list.</div>
												    						<br/>
										    								<button class="btn btn-success cmplist-save" style="border-radius:2px;"> Save Changes </button>
	    														
	    														</td>
	    													</tr>
	    												</tbody>
	    											</table>
				    						</div>
				    						
				    						<!--  delete campaign list -->
	    									<div id="cmplist-delete-pane" style="display:none; ">
	    										<div style="position:absolute; top:0; left:10px; cursor:pointer;" class="back-to-mapping-pane">
	    										<span class="ion-ios-arrow-left" style="font-size:30px;"></span> 
	    										<span style="display:inline-block; font-size:12px; position:relative; top:-7px;" >&nbsp; back to mapping list</span>
	    										</div>
	    											<div style="font-size:22px; color:#666;"> Delete Mapped List </div>
						    						<div style="font-size:12px; color:#666;"> Effect to the list in this campaign only. </div>
						    						<div style="font-size:12px; color:#ed5565;"> This action cannot be undone.  </div>
						    						<br/>
							    					<br/>
							    					<p style="font-size:12px; color:#666;"> <input type="checkbox" name="confirm_delete_cmplist"> I'm sure to delete this mapped list. </p>
				    								<button class="btn btn-danger cmplist-remove" style="border-radius:2px;" > Delete Mapped List  </button> <br/>
	    									</div>
	    									
		    							</div>
		    							<!--  end div table-cell -->
		    							
	    						</div>
	    					<div style="clear:both"></div>
	    			</div>
	    		
	    		 
	  
	    		
	    		
	    		</div>
	    		<!--  end tab3  -->
	    		 
	    		   <!-- tab4 Campaign Field -->
	    		<div id="tab4"  class="tab-pane">
	    	
	    			
	    			    Campaign field : <br/>
	    			    		<button class="btn btn-success add_cmp_field"> Add Caption</button>
	    			    	    <button class="btn btn-danger remove_cmp_field"> Remove Caption</button>
	    			    	    
	    			    	    <button class="btn btn-default save_cmp_field"> Save </button>
	    			    <table class="table table-bordered" id="cmp-captionfield-table">
	    			    	<thead>
	    			    		<tr class="primary">
	    			    			<td style="width:5%" class="text-center"> #</td>
	    			    			<td style="width:25%" class="text-center"> Caption </td>
	    			    			<td style="width:20%" class="text-center"> Field Name </td>
	    			    			<td style="width:20%" class="text-center"> Field Option </td>
	    			    			<td style="width:15%" class="text-center"> Show In Call Work Page </td>
	    			    			<td style="width:15%" class="text-center"> Show In Profile Page </td>
	    			    		</tr>
	    			    	</thead>
	    			    	<tbody>
	    			    	</tbody>
	    			    	<tfoot>
	    			    	</tfoot>
	    			    </table>
	    
	    	<br/>
	    	<!-- 
	    	Create Custom field  <br/>
	    	
	    	<table class="table table-border">
	    		<thead>
	    			<tr>
	    				<td></td>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td> Field Name : </td>
	    				<td> <input type="text"></td>
	    			</tr>
	    			<tr>
	    				<td> Field Type : </td>
	    				<td>
	    					<select>
	    						<option></option>
	    						<option value="">Text</option>
	    						<option value="">Integer</option>
	    						<option value="">Decimal</option>
	    						<option value="">Currency</option>
	    						<option value="">Email</option>
	    						<option value="">Phone</option>
	    					</select>
	    				</td>
	    			</tr>
	    		</tbody>
	    		<tfoot>
	    			<tr>
	    				<td></td>
	    				<td><button class="btn btn-success"> Save </button></td>
	    			</tr>
	    		</tfoot>
	    	</table>
	    	 -->
	    		</div>
	    		
	    		 <!-- tab5 campaign summary up -->
	    		<div id="tab5"  class="tab-pane">
				
	    			<table class="table table-border">
	    				<thead>
	    					<tr>
	    						<td colspan="4"><h2 style="font-family:raleway; font-weight:300; color:#666"> Campaign Summary </h2></td>
	    					</tr>
	    				</thead>
	    				<tbody>
	    					<tr>
	    						<td style="color:#666; width:20%;"> Campaign Name </td>
	    						<td style="width:30%;"><span id="cmname"> </span></td>
	    						<td style="color:#666;width:20%;"> Campaign Current Status </td>
	    						<td style="width:30%;"><span id="cmstst"> </span></td>
	    					</tr>
	    					<tr>
	    						<td style="color:#666;"> Campaign Create Date </td>
	    						<td> <span id="cmdate"> </span></td>
	    						<td style="color:#666;">Campaign Create By </td>
	    						<td><span id="cmcre"> </span></td>
	    					</tr>
	    					<tr>
	    						<td style="color:#666;"> Campaign Start Date </td>
	    						<td><span id="cmsdate"> </span></td>
	    						<td style="color:#666;">Campaign End Date </td>
	    						<td><span id="cmedate"> </span></td>
	    					</tr>
	    				</tbody>
	    				<tfoot>
	    					<tr>
	    						<td colspan="4" ></td>
	    					</tr>
	    				</tfoot>
	    			</table>
	    			
	    			<!--  wrap -->
	    			<div style="">
	    				<h2 style="font-family:raleway; font-weight:300; color:#666"> Campaign List </h2>
	    				<!--  start left pane -->
	    				<div style="float:left; width:100%">
	    						<table class="table table-border" id="campaign-list-summary">
					    				<thead>
					    					<tr>
					    						<td style="width:40%"> List Name </td>
					    						<td style="width:8%;text-align:center"> Total List </td>
					    						<td style="width:8%;text-align:center"> New List </td>
					    						<td style="width:8%;text-align:center"> Call Back </td>
					    						<td style="width:8%;text-align:center"> Follow up  </td>
					    						<td style="width:8%;text-align:center"> Bad List</td>
					    						<td style="width:8%;text-align:center"> Sales </td>
					    						<td style="width:12%"> List Performance </td>
					    					</tr>
					    				</thead>
					    				<tbody>
					    				</tbody>
					    				<tfoot>
					    				</tfoot>
					    			</table>
					    			
	    				</div>
	    				<!--  end left pane -->
	    				<!--  start right pane 
	    				<div style="float:right; width:30% ; background-color:#fff; border-radius:3px">
	    					<table class="table table-border">
					    				<thead>
					    					<tr>
					    						<td style="width:"> Agent Name</td>
					    						<td style="width:"> Total  </td>
					    						<td style="width:"> New  </td>
					    						<td style="width:"> Call Back  </td>
					    						<td style="width:"> Follow up  </td>
					    						<td style="width:"> Bad  </td>
					    						<td style="width:"> Sales  </td>
					    					</tr>
					    				</thead>
					    			</table>
	    				</div>
	    				<!--  end right pane -->
	    				
	    			</div>
	    			<!--  end wrap -->
	    		
	    		
	    			
	    			
	    		</div>
	    </div>
		<!--  end div tab -->

</div>
<!--  end group-detail-pane -->
<script type="text/javascript" src="js/campaign.js"></script>
<script>
 $(function(){

	 	$('#campaign-summary').click( function(e){
				e.preventDefault();
				//click for update current value( not realtime )
				console.log("summary click");
				$.campaign.summary();
		 });

		 $('#campaign-wrapup').click( function(e){
				e.preventDefault();
			console.log("wrapup tab click");
				$.campaign.wrapup();
		});

		$('[name=save_tree]').click( function(e){
				e.preventDefault();
				$.campaign.save_wrapup();
		});
	 
	 
		$('.create_salescript').click( function(e){
			e.preventDefault();
			  //init page
			$('#salescript-pane').load('saleScript-pane.php' , function(){
					$(this).fadeIn('slow');
			 });
		
		});

		$('.add_list').click( function(e){
			e.preventDefault();
			
		});

		$('.stopcmp_list').click( function(e){
			e.preventDefault();
			console.log('stop list click');
			$('#map_cmplist','#map_cmplist_detail').hide();
	   		$('#delete_cmplist').fadeOut('fast', function(){
					$('#delete_cmplist_detail').fadeIn('fast');
	   		});		
		});
/*
		$('.stopcmp_list').click( function(e){
				e.preventDefault();
				$('#map_cmplist','#map_cmplist_detail').hide();
		   		$('#delete_cmplist').fadeOut('fast', function(){
						$('#delete_cmplist_detail').fadeIn('fast');
		   		});		
		});
*/
		$('.stopcmp_list_cancel').click( function(e){
			e.preventDefault();
			$('#map_cmplist','#map_cmplist_detail').hide();
	   		$('#delete_cmplist_detail').fadeOut('fast', function(){
					$('#delete_cmplist').fadeIn('fast');
	   		});		
	});

		$('.startcmp_list').click( function(e){
				e.preventDefault();
				$('#delete_cmplist','#delete_cmplist_detail').hide();
		   		$('#map_cmplist').fadeOut('fast', function(){
						$('#map_cmplist_detail').fadeIn('fast');
		   		});		
		});

		$('.startcmp_list_cancel').click( function(e){
			e.preventDefault();
			$('#delete_cmplist','#delete_cmplist_detail').hide();
	   		$('#map_cmplist_detail').fadeOut('fast', function(){
					$('#map_cmplist').fadeIn('fast');
	   		});		
		});

		$('.startcmp_list_save').click( function(e){
			e.preventDefault();
			$('#delete_cmplist','#delete_cmplist_detail').hide();
			/*
	   		$('#map_cmplist_detail').fadeOut('fast', function(){
					$('#map_cmplist').fadeIn('fast');
	   		});
	   		*/		
		});
		
		
});

</script>
