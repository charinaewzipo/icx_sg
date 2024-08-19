<!-- start agent-main-pane -->
<div id="reminder-main-pane">
<input type="hidden" name="reminderid">
	<div class="container">
		<div class="row">
	
		<div style="padding: 5px 5px;">
				<div style="display:inline-block; position:relative; top:-12px;">
				</div>
				<div style="display:inline-block; position:relative; float:right">
				        <span id="reminder-close" class="ion-ios-close-outline close-model" style=""></span>
				</div>
				<div style="clear:both"></div>
		</div>
		
		 <h2 style="font-family:raleway; font-weight:300; color:#666666"> Reminder </h2>
		 <div style="color:#777777;position:relative; top:-10px; text-indent:2px;">Total 4 Reminders </div>
		<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px ; padding:0px; margin:10px 0"> 
		
  <button type="button" class="btn btn-default" style="border-radius:4px; font-weight:400; font-family:roboto" id="btn-new-reminder"><span class="ion-ios-plus-outline" style="font-size:18px;"></span> New Reminder  </button>
  <button type="button" class="btn btn-default" style="border-radius:4px; font-weight:400; font-family:roboto" id="btn-rem-reminder"><span class="ion-ios-trash-outline" style="font-size:18px;"></span></button>
 

		<div style="position:relative">
			<div style="float:left; width:20%;">
			&nbsp;
			</div>
			 <div id="reminder-main-layout" style="float:left; width:60%; display:nones;"> 
				<ul style="list-style:none; margin:0; padding:0; width:100%;" id="reminder-ul-list">
					<li style="border-bottom:1px solid #A2A2A2;color:#666; font-size:22px; margin-top:15px;"> 
						<div class="ion-ios7-calendar-outline" style="display:inline-block;  margin-left:10px; font-size:22px; "> 15 August 2007</div>  
						<div style="display:inline-block; float:right; margin-right:10px; font-size:18px; line-height:32px;"> 1 รายการ </div>
					</li>
					<li style="border-bottom:1px dashed #A2A2A2;  background-color:#fff; ">
					<div style="float:left; display:inline-block; width:10%; font-size: 40px; line-height:30px; margin:5px; padding:15px; border-right:1px solid #E2E2E2; " ><span class="ion-ios7-checkmark-outline" style="cursor:pointer "></span></div>
						<div style="float:left; display:inline-block; width:15%; font-size: 40px; line-height:30px; padding:25px 0; color:#0087e6">15:00</div>
						<div style="float:left; display:inline-block;width:50%; padding:5px;"> 
							<div ><h3 style="margin:0; padding:0; font-weight:400; color:#ff0097;font-family:raleway;  ">  Call Back </h3></div>
							<div style="font-size:17px;"> โทรกลับหาคุณคิม  </div>  
							<div style="font-size:14px; color:#555;"> โทรกลับไปด่าคุณ คิม เขียนโปรแกรมได้ปัญญาอ่อนมาก  </div>
						</div>
						<div style="float:left; display:inline-block;width:20%; padding:25px;"> 
						
							    <div class='onoffswitch'>
									   <input type='checkbox' name='onoffswitch"+ result[i].reminderid +"' class='onoffswitch-checkbox' id='myonoffswitch"+ result[i].reminderid +"' class='ch'  >
									    <label class='onoffswitch-label' for='myonoffswitch"+ result[i].reminderid +"'>
										    <span class='onoffswitch-inner'></span>
										    <span class='onoffswitch-switch'></span>
								   		 </label>
								    </div> 		    
						</div>
						<div style="clear:both"></div>
					</li>
						<li style="border-bottom:1px dashed #A2A2A2; background-color:#fff; ">
								<div style="float:left; display:inline-block; width:10%; font-size: 40px; line-height:30px; margin:5px; padding:15px;  border-right:1px solid #E2E2E2; " ><span class="ion-ios7-checkmark-outline" style="cursor:pointer "></span></div>
					<div style="float:left; display:inline-block; width:15%; font-size: 40px; line-height:30px; padding:25px 0; color:#0087e6">16:30</div>
						<div style="float:left; display:inline-block;width:50%; padding:5px;"> 
							<div ><h3 style="margin:0; padding:0; font-weight:400; color:#ff0097;font-family:raleway; ">  Call Back </h3></div>
							<div style="font-size:17px; color:#555"> โทรกลับหาคุณคิม  </div>
							<div style="font-size:14px;  color:#777"> โทรกลับไปด่าคุณ คิม เขียนโปรแกรมได้ปัญญาอ่อนมาก  </div>
						</div>
						<div style="float:left; display:inline-block;width:20%; padding:25px;"> 
						
							    <div class='onoffswitch'>
									   <input type='checkbox' name='onoffswitch"+ result[i].reminderid +"' class='onoffswitch-checkbox' id='myonoffswitch"+ result[i].reminderid +"' class='ch'  >
									    <label class='onoffswitch-label' for='myonoffswitch"+ result[i].reminderid +"'>
										    <span class='onoffswitch-inner'></span>
										    <span class='onoffswitch-switch'></span>
								   		 </label>
								    </div> 		    
						</div>
						<div style="clear:both"></div>
					</li>
				
					<li style="border-bottom:1px solid #A2A2A2;color:#666666; font-size:22px; margin-top:15px;"> <div class="ion-ios7-calendar-outline" style="margin-left:10px; color:#0087e6;font-size:22px; "> 16 August 2007</div>  </li>
					<li style="border-bottom:1px dashed #A2A2A2">
					<div style="float:left; display:inline-block; width:10%; font-size: 40px; line-height:30px; padding:20px; color:#ff0097; border:1px solid #000" class="ion-ios7-checkmark-outline"></div>
						<div style="float:left; display:inline-block; width:20%; font-size: 40px; line-height:30px; padding:20px; color:#ff0097">15:00</div>
						<div style="float:left; display:inline-block;width:50%; padding:5px;"> 
							<div ><h3 style="margin:0; padding:0; font-weight:400 ">  Call Back </h3></div>
							<div style="font-size:17px;"> โทรกลับหาคุณคิม  </div>
							<div style="font-size:14px;"> โทรกลับไปด่าคุณ คิม เขียนโปรแกรมได้ปัญญาอ่อนมาก  </div>
						</div>
						<div style="float:left; display:inline-block;width:20%; padding:25px;"> 
						
							    <div class='onoffswitch'>
									   <input type='checkbox' name='onoffswitch"+ result[i].reminderid +"' class='onoffswitch-checkbox' id='myonoffswitch"+ result[i].reminderid +"' class='ch'  >
									    <label class='onoffswitch-label' for='myonoffswitch"+ result[i].reminderid +"'>
										    <span class='onoffswitch-inner'></span>
										    <span class='onoffswitch-switch'></span>
								   		 </label>
								    </div> 		    
						</div>
						<div style="clear:both"></div>
					</li>
						<li style="border-bottom:1px dashed #A2A2A2">
						<div style="float:left; display:inline-block; width:20%; font-size: 40px; line-height:30px; padding:20px; color:#ff0097">16:00</div>
						<div style="float:left; display:inline-block;width:60%; padding:5px;"> 
							<div ><h3 style="margin:0; padding:0; font-weight:400 ">  Call Back </h3></div>
							<div style="font-size:17px;"> โทรกลับหาคุณคิม  </div>
							<div style="font-size:14px;"> โทรกลับไปด่าคุณ คิม เขียนโปรแกรมได้ปัญญาอ่อนมาก  </div>
						</div>
						<div style="float:left; display:inline-block;width:20%; padding:25px;"> 
						
							    <div class='onoffswitch'>
									   <input type='checkbox' name='onoffswitch"+ result[i].reminderid +"' class='onoffswitch-checkbox' id='myonoffswitch"+ result[i].reminderid +"' class='ch'  >
									    <label class='onoffswitch-label' for='myonoffswitch"+ result[i].reminderid +"'>
										    <span class='onoffswitch-inner'></span>
										    <span class='onoffswitch-switch'></span>
								   		 </label>
								    </div> 		    
						</div>
						<div style="clear:both"></div>
					</li>
				</ul>
			</div>
			 <!-- 
			<div style="display:nones; float:right; width:40%; border:1px solid #000;">
			 

			 right pane 
	 
			
  
			</div>
			-->
			 <div id="reminder-detail-layout" style="float:left; width:60%; display:none; border:1px solid #000;">
			 
			 <input type="button" value="back" id="back-to-reminder-main">
			 <!--     <input type='checkbox' name="reminderStatus" name='onoffswitch"+ result[i].reminderid +"' class='onoffswitch-checkbox' id='myonoffswitch"+ result[i].reminderid +"' class='ch'  > -->
			  		Redminder detail
    					<table style="width:100%">
					  	<tbody>
					  		<tr>
					  			<td>
					  			<!-- 
					  			<select style="width:60%" ><option value="1"> On </option><option value="0"> Off </option></select>
					  			 -->
					  			 
					  				
					  			
					  			
					  			</td>
					  		</tr>
					  		
					  			<tr>
					  			
					  			<td style="padding:20px 20px 0 0px; text-align:right;  vertical-align:top;"> Remind me on :</td>			
					  			<td style="padding:20px 20px 0 0px; vertical-align:middle;">
					  				 <div style='vertical-align:middle; display:inline-block; '>
							  			    <div class='onoffswitch'>
												   <input type='checkbox' name="reminderStatus" class='onoffswitch-checkbox' id='reminderStatus' >
												    <label class='onoffswitch-label' for='reminderStatus'>
													    <span class='onoffswitch-inner'></span>
													    <span class='onoffswitch-switch'></span>
											   		 </label>
											    </div> 
							  			  </div>
					  			</td>		  		
					  		</tr>
					  			<tr>
					  			<td style="padding:20px 20px 0 20px; text-align:right;  vertical-align:middle;"> Date :</td>
					  			<td style="padding:20px 20px 0 20px; ">
					  				<input type="text" name="reminderDate" style="width:15%" autocomplete="off" placeholder="day">
					  				<input type="text" name="reminderMonth" style="width:28%" autocomplete="off" placeholder="month"> 
					  				<input type="text" name="reminderYear" style="width:15%" autocomplete="off" placeholder="year">
					  			</td>
					  		</tr>
					  		<tr>
					  			<td style="padding:20px 20px 0 20px; text-align:right;  vertical-align:middle;"> Time :</td>
					  			<td style="padding:20px 20px 0 20px; ">
					  				<input type="text" name="reminderHH" style="width:29%" autocomplete="off" placeholder="hour">
					  				<input type="text" name="reminderMM" style="width:29%" autocomplete="off" placeholder="minute"> 
					  			</td>
					  		</tr>
					  	
					  		 <tr >
					  			<td style="padding:20px 20px 0 20px; text-align:right; vertical-align:middle; width:30%;"> Category : </td>
					  			<td style="padding:20px 20px 0 20px; width:70%;"> <select style="width:60%" name="reminderType"><option></option><option value="1"> Call back</option><option value="2"> Follow up</option></select></td>
					  		</tr>
					  	
					  		<tr >
					  			<td style="padding:0 20px 0 20px; text-align:right; vertical-align:middle; width:30%;"> Subject : </td>
					  			<td style="padding:0 20px 0 20px; width:70%;"><input type="text" name="reminderSubj"></td>
					  		</tr>
					  		<tr>
					  			<td style="padding:20px 20px 0 20px; text-align:right;  vertical-align:top;"> Detail :</td>
					  			<td style="padding:20px 20px 0 20px; "><textarea style="width:60%; height:80px;" name="reminderDesc"></textarea></td>
					  		</tr>
					  			<tr>
					  			<td colspan="4" style="text-align:right;padding:20px 20px 0 20px;">
					  				<!-- 	<button class="btn btn-success create_reminder"> New Reminder </button>  -->
					  					<button class="btn btn-success save_reminder"> Save Reminder </button>
										<!--  <button class="btn btn-danger delete_reminder"> Delete Reminder </button>  -->
					  			</td>
					  		</tr>
					  	</tbody>
					  
					  </table>
			 </div>
			
		</div>
	<!-- end position relative -->
	


 

  <!-- 
  Reminder date : <input type="text" name="reminderDate" class="calendar_en"> <br/>
  Reminder Time :  hh : 
  <select name="">
  			<option></option>
  			<option>00</option>
  			<option>01</option>
  			<option>02</option>
  			<option>03</option>
  			<option>04</option>
  			<option>05</option>
  			<option>06</option>
  			<option>07</option>
  			<option>08</option>
  			<option>09</option>
  			<option>10</option>
  			<option>11</option>
  			<option>12</option>
  			<option>13</option>
  			<option>14</option>
  			<option>15</option>
  			<option>16</option>
  			<option>17</option>
  			<option>18</option>
  			<option>19</option>
  			<option>20</option>
  			<option>21</option>
  			<option>22</option>
  			<option>23</option>
  	</select> 
  
  mm: 
  		<select name="">
  			<option></option>
  			<option>00</option>
  			<option>15</option>
  			<option>30</option>
  			<option>45</option>
  	</select> 
  
  	  <br/>
  Reminder Type : <select ><option></option><option value="1"> Call Back</option></select> <br/>
  Reminder Subject : <input type="text" > <br/>
  Reminder Detail : <textarea ></textarea> <br/>

  <br/><br/>

 <br/>
  -->
 
 
 </div>

</div>
</div>

<!--  end agent-detail-pane -->
<script type="text/javascript" src="js/reminder-pane.js"></script> 