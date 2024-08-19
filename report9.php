
<SCRIPT type=text/javascript>
	function verify() {
				if ($("#start_date").val() == "") {
					alert("กรุณาใส่วันที่เริ่ม");
					$("#start_date").focus();
					return;
				}
				if ($("#end_date").val() == "") {
					alert("กรุณาใส่วันที่สิ้นสุด");
					$("#end_date").focus();
					return;
				}
				var formtojson = JSON.stringify($('#frmYesfile').serializeObject());
				$.post('app/aig/report/TPA_D2C_Export.php', {
					"data": formtojson
				}, function (result) {
					var response = eval('(' + result + ')');
					if (response.result == "success") {
						window.location = "app/aig/report/dw.php?p=temp/TPA_File_D2C.txt&o=y";
					}
				});
			}

  </SCRIPT>

<!-- QC Report  -->
<div id="report-pane">
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
								<h2 style="font-family:raleway; color:#666666; margin:0; padding:0">&nbsp;TPA Double Care Export</h2>
								<div class="stack-subtitle" style="color:#777777; ">&nbsp; TPA Double Care Export</div>
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

 					<div style="width:50%;float:right;">
 						<div>&nbsp;</div>
 					</div>
 				<div style="clear:both"></div>
 			</li>

 			<li style="padding:5px;">
	 			<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
<form class="form-horizontal" id="frmYesfile" action="app/aig/report/TPA_D2C_Export.php" name="date" method="post">
 				<div style="width:35%;float:left;color:#666; font-size:16px;">
 				 	<span style="font-size:15px; line-height:30px;width:118px;display:inline-block;">   Start Date </span> :
 					<input type="text" id="start_date" name="startdate"  style="width:250px; " autocomplete="off" placeholder="วันที่คุ้มครอง จาก" class="text-center calendar_en">
 				</div>
 					<div style="width:50%;float:right;">
 					<div style="color:#666;">
 						 <span style="font-size:15px; line-height:30px;width:100px;display:inline-block;"> End Date</span> :
 						<input type="text" id="end_date" name="enddate"  style="width:250px;" autocomplete="off" placeholder="วันที่คุ้มครอง ถึง" class="text-center calendar_en">
 					</div>
 				</div>
 				<div style="clear:both"></div>
 			</li>
 			<li style="text-align:center;padding:20px;">
 				<div>
 						 <input type="button" class="btn btn-primary" value="Export" onclick="verify()" style="border-radius:3px; width:110px;">   &nbsp;&nbsp;
    					 <button class="btn btn-default search-clear" style="border-radius:3px; width:110px;"> Clear </button>
 				</div>
</form>
<div style="margin: 20px 0 0 20px;">
   <div id="divLinkDown"></div>
</div>
 			</li>
 		</ul>



</div>

<!-- end agent performance report -->

<script>
 $(function(){

	 $('.calendar_en').datepicker({  dateFormat: 'dd/mm/yy' });
	 //$.rpt.getcmp();

	 //agent report back to main menu
	 $('.report-back-main').click( function(e){
			$('#report').fadeOut( 'fast' , function(){
				$('#select-report').fadeIn('medium');
				$(this).html('');
			});
	});

	$('.search-clear').click( function(e){
			e.preventDefault();
			$('#start_date').val('');
			$('#end_date').val('');
			//clear search
	});

 })
 </script>
