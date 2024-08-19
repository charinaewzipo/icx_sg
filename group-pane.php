

<div id="group-main-pane">
<input type="hidden" name="groupid">

<h2 class="page-title" style="display:inline-block;font-family:raleway; color:#666666;"> Group </h2>
<div class="stack-subtitle" style="color:#777777;">Group of user </div>
<hr style="border-bottom: 1px dashed #777777; "> 
  	 <button class="btn btn-success new_group"> <i class="fa fa-plus-circle"></i> Create Group </button> &nbsp;&nbsp;
     <button class="btn btn-danger  delete_group"> <i class="fa fa-minus-circle"></i> Delete Group   &nbsp;</button>
<br/>
<br/>
	
	<!-- 
	<div style="background-color:#fff; z-index:555; opacity:0.2; position:relative">
		<div class="ion-ios7-reloading size-38" style="position:absolute; left:50%;top:50%"></div> 
		 -->
		<table id="group-table" class="table table-bordered">
		<thead>
			<tr class="primary">
				<td class="text-center" style="width:5%"> # </td>
				<td class="text-center" style="width:35%"> Group Name </td>
				<td class="text-center" style="width:50%"> Group Member </td>
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
<div id="group-detail-pane" style="display:none">

	 <div style="display:inline-block" id="group-back-main"><i style="color:#666; cursor:pointer; position:relative; top:15px;" class="icon-circle-arrow-left icon-3x" id="campaign-back-main"></i></div>
	 <h2 style="font-family:raleway;display:inline-block;text-indent:10px; color:#666; ">Group Detail </h2> 
	 <div class="stack-subtitle" style="color:#777777; position:relative; top:-10px; text-indent:60px; font-family:raleway">Group Detail </div>
	 <hr style="border-bottom: 1px dashed #999999; position:relative; margin-top:0;"/>

 	   <div style="position:relative;margin-bottom:0px; top:-10px;" >
  		    <button class="btn btn-success new_group"> <i class="fa fa-plus-circle"></i> Create Group </button> &nbsp;&nbsp;
            <button class="btn btn-danger delete_group"> <i class="fa fa-minus-circle"></i>	Delete Group </button>
		</div>
					    
	
		<table class="table table-border">
			<thead>
						<tr >
							<td> Group Detail </td>
						</tr>
				</thead>
				<tbody>
						<tr>
							<td style="width:40%; text-align:right; vertical-align:middle"><span class="require" title="required field">*</span> Group Name</td>
							<td style="width:60%"> <input type="text" name="gname" autocomplete="off"><span id="errmsg"></span></td>
						</tr>
						<tr>
							<td style="width:40%;text-align:right; vertical-align:top" autocomplete="off"> Group Detail</td>
							<td style="width:60%"> 
								<textarea name="gdetail"></textarea>
							</td>
						</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" style="text-align:right"> 
								<button class="btn btn-success save_group"> Save </button>
								&nbsp;&nbsp;
								<button class="btn btn-default cancel_group"> Cancel </button>
						</td>
					</tr>
				</tfoot>
		</table>			  
	    

</div>
<!--  end group-detail-pane -->
<script type="text/javascript" src="js/group.js"></script>