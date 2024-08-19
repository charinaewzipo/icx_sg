<!-- start agent-main-pane -->
<div id="callscript-main-pane">
<input type="hidden" name="scriptid">
<h2>Call Script</h2>
<hr/>
  	 <button class="btn btn-success new_callscript"> <i class="fa fa-plus-circle"></i> Create CallScript </button> &nbsp;&nbsp;
     <button class="btn btn-danger  delete_callscript"> <i class="fa fa-minus-circle"></i> Delete CallScript   &nbsp;</button>
<br/>
<br/>
	

		<table id="callscript-table" class="table table-bordered">
		<thead>
			<tr>
				<td class="text-center" style="width:5%"> # </td>
				<td class="text-center" style="width:15%"> CallScript Name </td>
				<td class="text-center" style="width:40%"> CallScript Detail </td>
				<td class="text-center" style="width:20%"> Create Date </td>
				<td class="text-center" style="width:20%"> Create User </td>
			</tr>
		</thead>
		<tbody>
		</tbody>
		<tfoot>
		</tfoot>
		</table>
		
	
</div>
<!--  end group-main-pane -->

<!-- start group-detail-pane -->
<div id="callscript-detail-pane">
<h2><i class="fa fa-arrow-circle-left fa-lg back-to-main" style="cursor:pointer"></i> CallScript Detail</h2>
<hr/>
 	   <div style="position:relative;margin-bottom:0px; top:-10px;" >
  		    <button class="btn btn-success new_callscript"> <i class="fa fa-plus-circle"></i> Create CallScript </button> &nbsp;&nbsp;
            <button class="btn btn-danger delete_callscript"> <i class="fa fa-minus-circle"></i>	Delete CallScript </button>
		</div>
					    
	
		<table class="table table-border">
			<thead>
						<tr>
							<td> CallScript Detail </td>
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
	    
	
	   

</div>
<!--  end group-detail-pane -->
<script type="text/javascript" src="js/salescript.js"></script>