<!--  agent-pane v1.0  Mon April 6 2557 -->

<!-- start agent-main-pane -->
<div id="agent-main-pane">
<input type="hidden" name="aid">
<input type="hidden" name="sess_loginid">
<h2 class="page-title" style="display:inline-block;font-family:raleway; color:#666666;"> User </h2>
<div class="stack-subtitle" style="color:#777777;">User in this system</div>
<hr style="border-bottom: 1px dashed #777777; "> 
 	   <div style="">
  		    <button class="btn btn-success new_agent" style="background-color:#05ae0e; border-radius:3px"> <i class="icon-plus-sign-alt" style="font-size:15px"></i> Create User </button> &nbsp;&nbsp;
            <!-- <button class="btn btn-danger delete_agent" style="background-color:#ff3b30; border-radius:3px"> <i class="fa fa-minus-circle"></i>	Delete Agent </button> -->
		</div>
<br/>
<div style="float:left; padding:5px 2px; position:relative; top:5px;">
   		<?php 
   				session_start();
     			$lv = $_SESSION["pfile"]["lv"];
     			if( $lv == 5 || $lv == 6 ){
		?>
		Group : <select name="search_group" style="width:180px; height:30px;"></select> 
		&nbsp;&nbsp;&nbsp;
		<?php 
		 		}
		 		if($lv==4 || $lv == 5 || $lv == 6 ){
		?>
		Team : <select name="search_team" style="width:180px; height:30px;"></select> 
	  	<?php 
		 		}
	  	?>
</div>
<div style="float:right; padding:5px 2px;">
<input type="text" style="width:200px;" name="search_name" autocomplete="off" placeholder="search name..."><!-- 
 --><button id="search-btn" class="btn" style="background-color: #16a085 ; color:#fff; font-size:12px; border-top-right-radius:3px; border-bottom-right-radius:3px; height:34px;"> Search </button>
<button id="search-clear" class="btn" style="background-color: #9e9e9e ; color:#fff; font-size:12px; border-radius:3px; height:34px;"> Clear </button>
</div>

<table id="agent-table" class="table table-border" style="background-color:#fff;">
<thead>
	<tr class="primary">
		<td class="text-center" style="width:5%"> # </td>
		<td class="text-center" style="width:18%"> Name </td>
		<td class="text-center" style="width:10%"> Group </td>
		<td class="text-center" style="width:10%"> Team </td>
		<td class="text-center" style="width:10%"> Login ID </td>
		<td class="text-center" style="width:10%"> Level </td>
		<td class="text-center" style="width:10%"> Status</td>
		<td class="text-center" style="width:10%"> Last Login</td>
		<td class="text-center" style="width:17%"> Action </td>
	</tr>
</thead>
<tbody>
</tbody>
<tfoot>
</tfoot>
</table>


</div>
<!--  end agent-main-pane -->

<!-- start agent-detail-pane -->
<div id="agent-detail-pane" style="display:none">

<div style="position:relative;padding:15px 0px">
	<div id="agent-back-main" style="float:left; display:inline-block;cursor:pointer; ">
		<i class="icon-circle-arrow-left icon-3x" style="color:#666; "></i>
	</div>
	<div style="display:inline-block; float:left; margin-left:10px;">
		<h2 style="font-family:raleway; color:#666666; margin:0; padding:0" id="user-detail-header"> </h2>
		<div class="stack-subtitle" style="color:#777777; ">User Detail </div>
	</div>
	<div style="clear:both"></div>
	 <hr style="border-bottom: 1px dashed #999999;"/>
</div>

 <!-- 
	 <div style="display:inline-block" id="agent-back-main"><i style="color:#666; cursor:pointer; position:relative; top:15px;" class="icon-circle-arrow-left icon-3x" id="campaign-back-main"></i></div>
	 <h2 style="font-family:raleway;display:inline-block;text-indent:10px; color:#666; " id="user-detail-header"> </h2> 
	 <div class="stack-subtitle" style="color:#777777; position:relative; top:-10px; text-indent:60px; font-family:raleway">User Detail </div>
	 -->
	 
	 
 	   <div style="">
  		    <button class="btn btn-success new_agent" style="background-color:#05ae0e; border-radius:3px"> <i class="icon-plus-sign-alt" style="font-size:15px"></i> Create User </button> &nbsp;&nbsp;
            <button class="btn btn-danger delete_agent" style="background-color:#ff3b30; border-radius:3px"> <i class="fa fa-minus-circle"></i>	Delete Agent </button>
		</div>
					   
		<table class="table" style="width:100%; margin-top:20px;">
			<thead>
						<tr>
							<td style="background-color:#eee; padding:10px; border-bottom:2px solid #4390df" colspan="2"><h4 style="margin:0; padding:0; font-family:raleway; font-weight:600; color:#555"> User Detail </h4></td>
						</tr>
				</thead>
				<tbody>
						<tr>
							<td style="padding-top:20px; width:40%; text-align:right; vertical-align:middle"><span style="color:#666"> * </span> First Name English: </td>
							<td style="padding-top:20px; width:60%"> <input type="text" name="fname" autocomplete="off" placeholder="" ></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"><span style="color:#666"> * </span> Last Name English: </td>
							<td style=""> <input type="text" name="lname"  autocomplete="off" placeholder=""></td>
						</tr>
						<!--
						<tr>
							<td style="text-align:right; vertical-align:middle"><span style="color:#666"> * </span> First Name Thai: </td>
							<td style=""> <input type="text" name="fname_th" autocomplete="off" placeholder="" ></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"><span style="color:#666"> * </span> Last Name Thai: </td>
							<td style=""> <input type="text" name="lname_th"  autocomplete="off" placeholder=""></td>
						</tr>
						-->
						<tr>
							<td style="text-align:right; vertical-align:middle"><span style="color:#666"> * </span> Genesys Id: </td>
							<td style=""> <input type="text" name="genesysid"  autocomplete="off" placeholder=""></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> NickName : </td>
							<td style=""> <input type="text" name="nname"  autocomplete="off" placeholder=""></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> Mobile : </td>
							<td style=""> <input type="text" name="mobilephone"  autocomplete="off"></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> Email : </td>
							<td style=""> <input type="text" name="email"  autocomplete="off"></td>
						</tr>
						<tr>
							<td style="background-color:#eee; padding:10px;  border-bottom:2px solid #4390df" colspan="2"><h4 style="margin:0; padding:0; font-family:raleway; font-weight:600; color:#666"> Group Detail </h4></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> Group : </td>
							<td style="padding-top:20px;"> 
									<select name="gid" style="width:180px; height:30px;"><option></option></select>
							</td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> Team : </td>
							<td style=""> 
									<select name="tid"  style="width:180px; height:30px;"><option></option></select>
							</td>
						</tr>
					    <tr>
							<td colspan="2" style="background-color:#eee; padding:10px;  border-bottom:2px solid #4390df"> <h4 style="margin:0; padding:0; font-family:raleway; font-weight:600; color:#666"> User Login Detail</h4>  </td>
						</tr>
						<tr>
							<td style="padding-top:20px; text-align:right; vertical-align:middle"><span style="color:#666"> * </span> Login ID : </td>
							<td style="padding-top:20px; vertical-algin:bottom;"> <input type="text" name="loginid"  autocomplete="off" placeholder="">
								<span id="err-loginid" style="display:inline-block; text-indent:10px; position:relative; top:5px; color:red"></span>
							</td>
						</tr>
						<tr>
							<td style=";text-align:right; vertical-align:middle"><span style="color:#666"> * </span> Password : </td>
							<td style=""> <input type="password" name="passwd"  autocomplete="off" placeholder=""></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> Retype Password : </td>
							<td style=""> <input type="password" name="repasswd"  autocomplete="off">
								<span id="err-passwd" style="display:inline-block; text-indent:10px; position:relative; top:5px; color:red"></span>
							</td>
						</tr>
					    <tr>
							<td style=";text-align:right; vertical-align:middle"  autocomplete="off"><span style="color:#666"> * </span>  Level : </td>
							<td style="">
									<select name="level" style="width:180px; height:30px;">
									<option value="" ></option>
									</select>
						
						</tr>
						  <tr>
							<td style=";text-align:right; vertical-align:middle"><span style="color:#666"> * </span> Status : </td>
							<td style="">
									<select name="accstatus" style="width:180px; height:30px;">
										<option value="" >  </option>
										<option value="1" selected> Active </option>
										<option value="5" > Locked </option>
										<option value="0"> Disabled</option>
									</select>
						</tr>
						<tr>
							<td style="background-color:#eee; padding:10px;  border-bottom:2px solid #4390df" colspan="2"><h4 style="margin:0; padding:0; font-family:raleway; font-weight:600; color:#666"> Sales License Information </h4></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> Agent Code : </td>
							<td style=""> <input type="text" name="sagent_code"  autocomplete="off" placeholder=""></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> Agent Name : </td>
							<td style=""> <input type="text" name="sagent_name"  autocomplete="off" placeholder=""></td>
						</tr>
					
						<tr>
							<td style="text-align:right; vertical-align:middle"> License Code : </td>
							<td style=""> <input type="text" name="slicense_code"  autocomplete="off" placeholder=""></td>
						</tr>
						<tr>
							<td style="text-align:right; vertical-align:middle"> License Name : </td>
							<td style=""> <input type="text" name="slicense_name"  autocomplete="off" placeholder=""></td>
						</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" style="text-align:right"> 
								<button class="btn btn-primary save_user" style="border-radius: 3px;  background-color:#3472f7; width:100px;">  Save </button>
								&nbsp;&nbsp;
								<button class="btn btn-default cancel_user" style="border-radius: 3px;"> Cancel </button>
						</td>
					</tr>
				</tfoot>
		
		</table>			  
					    

</div>
<!--  end agent-detail-pane -->
<script type="text/javascript" src="js/agent.js"></script>