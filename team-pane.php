<!-- start agent-main-pane -->
<div id="team-main-pane">
<input type="hidden" name="teamid">

<h2 class="page-title" style="display:inline-block;font-family:raleway; color:#666666;"> Team </h2>
<div class="stack-subtitle" style="color:#777777;">Sub class of group </div>
<hr style="border-bottom: 1px dashed #777777; "> 

  	 <button class="btn btn-success new_team"> <i class="fa fa-plus-circle"></i> Create Team </button> &nbsp;&nbsp;
     <button class="btn btn-danger  delete_team"> <i class="fa fa-minus-circle"></i> Delete Team   &nbsp;</button>
<br/>
<br/>
	<!-- 
	<div style="background-color:#fff; z-index:555; opacity:0.2; position:relative">
		<div class="ion-ios7-reloading size-38" style="position:absolute; left:50%;top:50%"></div> 
		 -->
		<table id="team-table" class="table table-bordered">
		<thead>
			<tr class="primary">
				<td class="text-center" style="width:5%"> # </td>
				<td class="text-center" style="width:30%"> Team Name </td>
				<td class="text-center" style="width:15%"> In Group  </td>
				<td class="text-center" style="width:50%"> Team Member </td>
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

<!--  end group-main-pane -->

<!-- start group-detail-pane -->
<div id="team-detail-pane" style="display:none">

 <div style="display:inline-block" id="team-back-main"><i style="color:#666; cursor:pointer; position:relative; top:15px;" class="icon-circle-arrow-left icon-3x" id="campaign-back-main"></i></div>
	 <h2 style="font-family:raleway;display:inline-block;text-indent:10px; color:#666; ">Team Detail </h2> 
	 <div class="stack-subtitle" style="color:#777777; position:relative; top:-10px; text-indent:60px; font-family:raleway">Team Detail </div>
	 <hr style="border-bottom: 1px dashed #999999; position:relative; margin-top:0;"/>
	 
 	   <div style="position:relative;margin-bottom:0px; top:-10px;" >
  		    <button class="btn btn-success new_team"> <i class="fa fa-plus-circle"></i> Create Team </button> &nbsp;&nbsp;
            <button class="btn btn-danger delete_team"> <i class="fa fa-minus-circle"></i>	Delete Team </button>
		</div>
					    
	
		<table class="table table-border">
			<thead>
						<tr>
							<td> Team Detail </td>
						</tr>
				</thead>
				<tbody>
					<tr>
							<td style="width:40%; text-align:right; vertical-align:middle"> Group Name</td>
							<td style="width:60%">
								<select name="tgid">
									<option></option>
								</select>
							</td>
						</tr>
						<tr>
							<td style="width:40%; text-align:right; vertical-align:middle"> Team Name</td>
							<td style="width:60%"> <input type="text" name="tname"></td>
						</tr>
						<tr>
							<td style="width:40%;text-align:right; vertical-align:middle"> Team Detail</td>
							<td style="width:60%"> 
								<textarea name="tdetail"></textarea>
							</td>
						</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" style="text-align:right"> 
								<button class="btn btn-success save_team"> Save </button>
								&nbsp;&nbsp;
								<button class="btn btn-default cancel_team"> Cancel </button>
						</td>
					</tr>
				</tfoot>
		</table>			  
	    

</div>
<!--  end group-detail-pane -->
<script type="text/javascript" src="js/team.js"></script>