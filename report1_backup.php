<!--  Agent Performance Report V1.0 Fri 20 2558  -->

<!-- Agent Permance Report  -->
<div id="agent-performance-pane">
		<ul style="width:100%; list-style:none; margin:0;padding:0;">
 			<li>
 				<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:60%;float:left; border-bottom:1px dashed #ddd">
 						<div style="position:relative;">
								<div id="agentreport-back-main" style="float:left; display:inline-block;cursor:pointer; ">
									<i class="icon-circle-arrow-left icon-3x" style="color:#666; "></i>
								</div>
								<div style="display:inline-block; float:left; margin-left:5px;">
								<h2 style="font-family:raleway; color:#666666; margin:0; padding:0">&nbsp;Agent Performance Report</h2>
								<div class="stack-subtitle" style="color:#777777; ">&nbsp; KPI Agent Performance</div>
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
	 			<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left; ">
 					 <span style="font-size:15px; line-height:30px; color:#666">Campaign Name &nbsp;&nbsp;: </span> 
 					 <input type="text" name="search_cust" style="width:250px;" autocomplete="off" placeholder="ระบุชื่อลูกค้า">
 				</div>
 					<div style="width:50%;float:right;">
 					
 					<div>
 						 <span style="font-size:15px; line-height:30px; color:#666">Owner Name &nbsp;&nbsp;: </span> 
 					 <input type="text" name="search_agent" style="width:250px;" autocomplete="off" placeholder="ระบุชื่อพนักงาน">
 					</div>
 				
 				</div>
 				<div style="clear:both"></div>
 			</li>
 			<li style="padding:5px; ">
	 			<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left; ">
 					 <span style="font-size:15px; line-height:30px; color:#666">Quotation No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span> 
 					 <input type="text" name="search_quono" style="width:250px;" autocomplete="off" placeholder="ระบุหมายเลข Quotation">
 				</div>
 					<div style="width:50%;float:right;">
 					<div>
 						 <span style="font-size:15px; line-height:30px;color:#666">App Status  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span> <select style="width:250px; height:30px;" name="search_sts"><option></option><option>abc</option></select>
 					</div>
 				</div>
 				<div style="clear:both"></div>
 			</li>
 			<li style="padding:5px; ">
 				<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left; ">
	 			 <span style="font-size:15px; line-height:28px;color:#444">  Application Create Date  </span>  
	 			</div>
	 			<div style="clear:both"></div>
 			</li>
 			<li style="padding:0 5px;">
	 			<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left;color:#666; font-size:16px;">
 				 	<span style="font-size:15px; line-height:30px;width:118px;display:inline-block;">   Start Date </span> :  
 					<input type="text" name="search_cred"  style="width:250px; " autocomplete="off" placeholder="เลือกวันที่เริ่มสร้าง app" class="text-center calendar_en"> 
 				</div>
 					<div style="width:50%;float:right;">
 					<div style="color:#666;">
 						 <span style="font-size:15px; line-height:30px;width:100px;display:inline-block;"> End Date</span> : 
 						<input type="text" name="search_endd"  style="width:250px;" autocomplete="off" placeholder="เลือกวันที่สิ้นสุดการสร้าง app" class="text-center calendar_en"> 
 					</div>
 				</div>
 				<div style="clear:both"></div>
 			</li>
 				<li style="padding:0 5px; ">
 				<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left; ">
	 			 <span style="font-size:15px; line-height:28px;color:#444">  Application Payment Date  </span>  
	 			</div>
	 			<div style="clear:both"></div>
 			</li>
 			
 			<li style="padding:5px;">
	 			<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left; color:#666;font-size:15px;">
 					 <span style="line-height:30px;width:118px;display:inline-block;">   Start Date </span> :  
 					<input type="text" name="search_paidcred"  style="width:250px; " autocomplete="off" placeholder="เลือกวันที่เริ่มเก็บเงิน" class="text-center calendar_en"> 
 				</div>
 					<div style="width:50%;float:right;">
 					<div style="color:#666;">
 						 <span style="font-size:15px; line-height:30px;width:100px;display:inline-block;"> End Date</span>  : 
 						<input type="text" name="search_paidendd"  style="width:250px;" autocomplete="off" placeholder="เลือกวันที่สิ้นสุดการเก็บเงิน" class="text-center calendar_en"> 
 					</div>
 				</div>
 				<div style="clear:both"></div>
 			</li>
 			<li style="text-align:center;padding:20px;">
 				<div>
 						 <button class="btn btn-primary search-agentpermance-btn" style="border-radius:3px; width:110px;"> Search </button> &nbsp;&nbsp;
    					 <button class="btn btn-default search-agentperfmance-btn-clear" style="border-radius:3px; width:110px;"> Clear </button> 
 				</div>
 			</li>
 		</ul>
 		
 		<div style="padding:5px 0">
 				<button class="btn btn-default search-agentperformance-export" style="border-radius:3px; width:150px; background-color:#ff9800; color:#fff; border:1px solid #e2e2e2"><i class="icon-download" style="font-size:20px"></i> Excel Download </button> 
 		</div>
 	
 		<table class="table table-bordered zebra" id="agent-performance-table">
 			<thead>
 				<tr class="primary">
 					<td class="text-center"> Group Name </td>
 					<td class="text-center"> Team Name </td>
 					<td class="text-center"> Agent Name</td>
 					<td class="text-center"> Date  </td>
 					<td class="text-center"> Transfer List </td>
 					<td class="text-center"> Revoke List </td>
 					<td class="text-center"> On-hands List </td>
 					<td class="text-center"> New List </td>
 					<td class="text-center"> No Contact</td>
 					<td class="text-center"> Call Back</td>
 					<td class="text-center"> Follow UP </td>
 					<td class="text-center"> Follow Doc </td>
 					<td class="text-center"> Do Not Call List </td>
 					<td class="text-center"> Bad List  </td>
 					<td class="text-center"> Close Sales  </td>
 					<td class="text-center"> Unclsoe Sales </td>
 					<td class="text-center"> Over limit trying call</td>
 				</tr>
 			</thead>
 			<tbody>
 				<tr>
 					<td colspan="17" class="text-center"> No data found </td>
 				</tr>
 			</tbody>
 			<tfoot>
 			</tfoot>
 		</table>

</div>

<!-- end agent performance report -->

<script>
 $(function(){
	 
	 //agent report back to main menu
	 $('#agentreport-back-main').click( function(e){
			$('#agent-performance-pane').fadeOut( 'fast' , function(){
				$('#select-report').fadeIn('medium');
			})
	});


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
		

 })
 </script>
