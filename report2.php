<!--  List Conversion Report V1.0 Fri 20 2558 -->

<!-- List Conversion Report  -->
<div id="report-pane" style="">
		<ul style="width:100%; list-style:none; margin:0;padding:0;">
 			<li>
 				<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:60%;float:left; border-bottom:1px dashed #ddd">
 						<div style="position:relative;">
								<div class="report-back-main" style="float:left; display:inline-block;cursor:pointer; ">
									<i class="icon-circle-arrow-left icon-3x" style="color:#666; "></i>
								</div>
								<div style="display:inline-block; float:left; margin-left:5px;">
								<h2 style="font-family:raleway; color:#666666; margin:0; padding:0">&nbsp;List Conversion Report</h2>
								<div class="stack-subtitle" style="color:#777777; ">&nbsp; List Conversion</div>
								</div>
								<div style="clear:both"></div>
						</div>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
 			</li>
 			
 				<li style="padding:5px; margin-top:15px;">
	 					<div style="width:30%;float:left;">
			 			 &nbsp;
			 			</div>
		 				<div style="width:40%;float:left; ">
		 					 <span style="font-size:15px; line-height:30px; color:#666">Campaign Name &nbsp;&nbsp;: </span> 
		 					 	<select name="listconv_search_campaign" style="width:250px;  height:30px;">
		 					 			<option></option>	
		 					 </select>
		 				</div>
		 					<div style="width:15%;float:right;">
		 				</div>
		 				<div style="clear:both"></div>
 				</li>
 					<li style="padding:5px; margin-top:5px;">
	 					<div style="width:30%;float:left;">
			 			 &nbsp;
			 			</div>
		 				<div style="width:40%;float:left; ">
		 					  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;<span style="font-size:15px; line-height:30px; color:#666">Lead Name&nbsp;&nbsp;: </span> 
		 			 			<select name="listconv_search_lead" style="width:250px;  height:30px;">
		 					 			<option></option>	
		 					 </select>
		 				</div>
		 					<div style="width:15%;float:right;">
		 				</div>
		 				<div style="clear:both"></div>
 				</li>
 				<!-- 
 					<li style="padding:5px; margin-top:5px;">
	 					<div style="width:30%;float:left;">
			 			 &nbsp;
			 			</div>
		 				<div style="width:40%;float:left; ">
		 				&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
		 					  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;<span style="font-size:15px; line-height:30px; color:#666">Date&nbsp;&nbsp;: </span> 
		 			 			<input type="text" name="listconv_search_date"  style="width:250px; " autocomplete="off" placeholder="" class="text-center calendar_en">
		 				</div>
		 					<div style="width:15%;float:right;">
		 				</div>
		 				<div style="clear:both"></div>
 				</li>
 				 -->
 			<li style="text-align:center;padding:15px;">
 				<div>
 						 <button class="btn btn-primary search-listconversion-btn" style="border-radius:3px; width:110px;"> Search </button> &nbsp;&nbsp;
    					 <button class="btn btn-default search-listtconversion-btn-clear" style="border-radius:3px; width:110px;"> Clear </button> 
 				</div>
 			</li>
 		</ul>
 		
 		<!-- 
 		<div style="padding:5px 0">
 				<button class="btn btn-default search-listconversion-btn-export" style="border-radius:3px; width:150px; background-color:#ff9800; color:#fff; border:1px solid #e2e2e2"><i class="icon-download" style="font-size:20px"></i> Excel Download </button> 
 		</div>
 		 -->
 		 
	<!--  List Conversion Report -->
 			<table class="table table-bordered zebra" id="list-conversion-table">
 			<thead>
 				<tr class="primary">
 					<td class="text-center" style="vertical-align:middle" rowspan="2"> List Name </td>
 					<td class="text-center" style="vertical-align:middle" rowspan="2"> List Load </td>
 					<td class="text-center" colspan="2"> List Used </td>
 					<td class="text-center" colspan="2"> List Remain </td>
 					<td class="text-center" colspan="2"> List DMC </td>
 					<td class="text-center" colspan="2"> List Success </td>
 					<td class="text-center" colspan="2"> List Unsuccess </td>
 					<td class="text-center" colspan="2"> List App </td>
 					<td class="text-center" colspan="2"> Ineffective Contact </td>
 					<td class="text-center" colspan="2"> List Inprogress </td>
 					<td class="text-center" colspan="2"> List Callback </td>
 					<td class="text-center" colspan="2"> List Followup </td>
 					<td class="text-center" colspan="2"> Bad List </td>
					<td class="text-center" colspan="2"> Allowance </td>
 				</tr>
 				<tr class="primary">
 				
 					<!--  list used -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 					<!--  list remain  -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 					<!--  DMC -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 					<!--  list success -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 					<!--  list unsuccess -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 					<!--  list app -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 			
 					<!--  Ineffective contact  -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 					<!--  list inprogress  -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 					<!--  list callback  -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 					<!--  list followup  -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>
 					
 						<!-- Bad list  -->
 					<td class="text-center" >Total </td>
 					<td class="text-center"> % </td>

					<!-- Bad list  -->
 					<td class="text-center" >Submit </td>
 					<td class="text-center"> Inforce </td>
 					
 				</tr>
 			</thead>
 			<tbody>
 				<tr>
 					<td colspan="26" class="text-center"> No data found </td>
 				</tr>
 			</tbody>
 			<tfoot>
 			</tfoot>
 		</table>
 		

</div>
<!-- end list conversion  report -->

<script>
$(function(){

	 //list conversion report back to main menu
	 $('.report-back-main').click( function(e){
			$('#report').fadeOut( 'fast' , function(){
				$('#select-report').fadeIn('medium');
				$(this).html('');
			});
	});

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
			 
	 //after select campaign
		$('[name=listconv_search_campaign]').change( function(){
			  var self = $(this).val();
			  $.rpt.getlead(self);
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

		
	
})
</script>
