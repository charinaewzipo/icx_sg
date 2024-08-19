<!-- start agent-main-pane -->
<div id="tracking-main-pane">
<h2>Call List Agent Tracking </h2>
<hr/>
<!-- 
  	 <button class="btn btn-success new_callscript"> <i class="fa fa-plus-circle"></i> Create CallScript </button> &nbsp;&nbsp;
     <button class="btn btn-danger  delete_callscript"> <i class="fa fa-minus-circle"></i> Delete CallScript   &nbsp;</button>
<br/>
<br/>
 -->
<!-- 

	<tr>
				<td class="text-center" style="width:5%"> # </td>
				<td class="text-center" style="width:15%"> CallScript Name </td>
				<td class="text-center" style="width:40%"> CallScript Detail </td>
				<td class="text-center" style="width:20%"> Create Date </td>
				<td class="text-center" style="width:20%"> Create User </td>
			</tr>
 -->
 
		<table id="tracking-table" class="table table-bordered">
		<thead>
			<tr>
				<td>  Campaign </td>
				<td >
					<select name="search_campaign">
						<option></option>
					</select>
				</td>
			</tr>
			<tr>
				<td>  List </td>
				<td>
					<select name="search_list">
						<option></option>
					</select>
				</td>
				<td>  List Status </td>
				<td> 
					<select name="search_listStatus">
						<option></option>
					</select>
				</td>
			</tr>
			<tr>
				<td> Search Group </td>
				<td>
					<select name="search_group">
						<option></option>
					</select>
				</td>
				<td> Seach Team </td>
				<td>
					<select name="search_team">
						<option></option>
					</select>
				</td>
			</tr>
				<tr>
				<td> Search Agent </td>
				<td>
					<select name="search_agent">
						<option></option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="text-center">
					<button class="btn btn-primary">   Search   </button>
				</td>
			</tr>
		</thead>
		<tbody>
		 
		</tbody>
		<tfoot>
		</tfoot>
		</table>
		
			<table class="table table-bordered" id="result-table">
			<thead>
						<tr>
							<td colspan="8"> Search  Result  </td>
						</tr>
				</thead>
				<tbody>
					<tr>
						<td>#</td>
						<td> Campaign </td>
						<td> CallList ID </td>
						<td> Call List Status </td>
						<td> Agent Owner </td>
						<td> On agent hands </td>
						<td> Last Wrapup </td>
						<td> Last Wrapup Option </td>
					</tr>
				</tbody>
				<tfoot>
				</tfoot>
		</table>			  
	
</div>
<!--  end group-main-pane -->

<!-- start group-detail-pane -->
<div id="tracking-detail-pane">
<!-- 
<h2><i class="fa fa-arrow-circle-left fa-lg back-to-main" style="cursor:pointer"></i> CallScript Detail</h2>
<hr/>
 	   <div style="position:relative;margin-bottom:0px; top:-10px;" >
  		    <button class="btn btn-success new_callscript"> <i class="fa fa-plus-circle"></i> Create CallScript </button> &nbsp;&nbsp;
            <button class="btn btn-danger delete_callscript"> <i class="fa fa-minus-circle"></i>	Delete CallScript </button>
		</div>
-->
	
	<!--
	<h2> Search Result </h2>
		<table class="table table-border">
			<thead>
						<tr>
							<td>  Detail </td>
						</tr>
				</thead>
				<tbody>
						<tr>
							<td style="width:40%; text-align:right; vertical-align:middle"> Call Script Name</td>
							<td style="width:60%"> <input type="text" name="sname"></td>
						</tr>
						<tr>
							<td style="width:40%;text-align:right; vertical-align:middle"> Call Script Detail</td>
							<td style="width:60%"> 
								<textarea name="sdetail"></textarea>
							</td>
						</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" style="text-align:right"> 
								<button class="btn btn-success save_callscript"> Save </button>
								&nbsp;&nbsp;
								<button class="btn btn-default cancel_callscript"> Cancel </button>
						</td>
					</tr>
				</tfoot>
		</table>			  
	    
	 -->
	   

</div>
<!--  end group-detail-pane -->
 <script type="text/javascript" src="js/tracking.js"></script> 
<script>
$(function(){
		console.log("jquery start");
  })

</script>