<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>IVR REPORT CENTER</title>

		<meta name="description" content="Static &amp; Dynamic Tables" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!--basic styles-->

		<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
		<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
        
        
        <link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
		<link rel="stylesheet" href="assets/css/chosen.css" />
		<link rel="stylesheet" href="assets/css/datepicker.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="assets/css/daterangepicker.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!--page specific plugin styles-->

		<!--fonts-->

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

		<!--ace styles-->

		<link rel="stylesheet" href="assets/css/ace.min.css" />
		<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
        
        <script src="function/function.js" type="text/javascript"></script>

		<!--inline styles related to this page-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a href="#" class="brand">
						<small>
							<i class="icon-leaf"></i>
							IVR Report Center
						</small>
					</a><!--/.brand-->

					<ul class="nav ace-nav pull-right">
						

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									User
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
								<li>
									<a href="#">
										<i class="icon-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="#">
										<i class="icon-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="#">
										<i class="icon-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul><!--/.ace-nav-->
				</div><!--/.container-fluid-->
			</div><!--/.navbar-inner-->
		</div>

		<div class="main-container container-fluid">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>

			<div class="sidebar" id="sidebar">

				<ul class="nav nav-list">
                    <li>
						<a href="report.php">
							<i class="icon-dashboard"></i>
							<span class="menu-text"> IVR Hit Menu</span>
						</a>
					</li>
                    <li>
						<a href="report_ivr_usage_by_period.php">
							<i class="icon-dashboard"></i>
							<span class="menu-text">IVR Usage By Period</span>
						</a>
					</li>
                    <li>
						<a href="report_ivr_summary.php">
							<i class="icon-dashboard"></i>
							<span class="menu-text"> IVR Summary By Date</span>
						</a>
					</li>

					
				</ul><!--/.nav-list-->

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>

			<div class="main-content">
				

				<div class="page-content">
					<div class="page-header position-relative">
						<h1>
							Report
							<small>
								<i class="icon-double-angle-right"></i>
								Report IVR Usage By Period
							</small>
						</h1>
					</div><!--/.page-header-->
                    <div class="row-fluid">
                    			<div class="span4">
									<label for="id-date-range-picker-1">ระบุวันที่ เริ่มต้น - สิ้นสุด</label>
											<div class="control-group">
													<div class="row-fluid input-prepend">
															<span class="add-on">
																<i class="icon-calendar"></i>
															</span>
															<input class="span10" type="text" name="selectdate" id="id-date-range-picker-1" />
                                                            <button class="btn btn-purple btn-small" style="margin-left:15px;" OnClick="JavaScript:doCallAjax_IVRUsagePeriod();">
															View Report
															<i class="icon-search icon-on-right bigger-110"></i>
														</button>
													</div>
												</div>
                    				</div>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
							<div id="mySpan">
							<div class="row-fluid">
								<div class="span12">
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Period Time</th>
												<th>จำนวนครั้ง</th>
                                                <th>%</th>
											</tr>
										</thead>

										<tbody>
											<tr>
                                                <td>00:00 - 00:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>01:00 - 01:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>02:00 - 02:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>03:00 - 03:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>04:00 - 04:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>05:00 - 05:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>06:00 - 06:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>07:00 - 07:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>08:00 - 08:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>09:00 - 09:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>10:00 - 10:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>11:00 - 11:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>12:00 - 12:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>13:00 - 13:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>14:00 - 14:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>15:00 - 15:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>16:00 - 16:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>17:00 - 17:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>18:00 - 18:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>19:00 - 19:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>20:00 - 20:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>21:00 - 21:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>22:00 - 22:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            <tr>
                                                <td>23:00 - 23:59</td>
                                                <td>0</td>
                                                <td>0%</td>
											</tr>
                                            
                                                    <tr>
                                                    	<td style="font-weight:bold; text-align:center;">TOTAL</td>
                                                        <td style="font-weight:bold;">0</td>
                                                        <td style="font-weight:bold;">0%</td>
                                                    </tr>
										</tbody>
									</table>
								</div><!--/span-->
							</div><!--/row-->
                            
                            </div> <!-- End   mySpan-->

							<div class="hr hr-18 dotted hr-double"></div>

							<h4 class="pink">
								<i class="icon-hand-right icon-animated-hand-pointer blue"></i>
								<a href="#" role="button" class="green" data-toggle="modal"> Export to Excel </a>
							</h4>

							<div class="hr hr-18 dotted hr-double"></div>

							
							</div><!--PAGE CONTENT ENDS-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

				
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
			<i class="icon-double-angle-up icon-only bigger-110"></i>
		</a>

		<!--basic scripts-->

		<!--[if !IE]>-->

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

		<!--<![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

		<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!--<![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!--page specific plugin scripts-->
        <script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
		<script src="assets/js/fuelux/fuelux.spinner.min.js"></script>
		<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/date-time/moment.min.js"></script>
		<script src="assets/js/date-time/daterangepicker.min.js"></script>
		<script src="assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="assets/js/jquery.knob.min.js"></script>
		<script src="assets/js/jquery.autosize-min.js"></script>
		<script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/bootstrap-tag.min.js"></script>
        
        

		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

		<!--ace scripts-->

		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!--inline scripts related to this page-->

		<script type="text/javascript">
			$(function() {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null, null,
				  { "bSortable": false }
				] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
				
				
				$('#id-date-range-picker-1').daterangepicker().prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
	</body>
</html>
