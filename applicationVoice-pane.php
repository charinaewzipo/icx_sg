<!-- start agent-main-pane -->
<?php
// Start output buffering
ob_start();

// Start the session at the very beginning of the script
session_start();

// Rest of your PHP code
?>

<?php include "dbconn.php" ?>
<?php include "util.php"  ?>
<div id="app-main-pane">

	<input type="hidden" name="aid">

	<div style="">
		<div style="float:left;height: 66px;display: flex;align-items: center;">
			<!-- <img src="images/generali.jpg" style="width:66px; height:66px; border-radius:50%; border:3px solid #fff;" class="shadow"> -->
			<i class="icon-calculator" style="line-height:8px;font-size: 3em;"></i>
		</div>
		<div style="display:inline-block;float:left;  ">
			<h2 class="page-title" style="font-family:raleway; margin:0; padding:5px; text-indent:8px;"> Application Non-Sale </h2>
			<div class="stack-subtitle" style="color:#777777;position:relative; top:-5px; text-indent:15px;">Application Order</div>
		</div>
		<!--<div style="float:right; margin-top:15px;">
  		 		<button class="btn btn-success  new-app" style="border-radius:3px"> Create New Application </button>
  		</div>-->
		<div style="clear:left"></div>
	</div>
	<hr style="border-bottom: 1px dashed #777777; ">
	<ul style="width:100%; list-style:none; margin:0;padding:0;">
		<li>
			<div style="width:15%;float:left;">
				&nbsp;
			</div>
			<div style="width:60%;float:left; border-bottom:1px dashed #ddd">
				<h3 style="font-family:raleway; color:#666; padding:10px; margin:0; float:left;"><i class="icon-search"></i> Search</h3>
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
				<div>
					<span style="font-size:15px; line-height:30px; color:#666">Agent Name &nbsp;&nbsp;: </span>
					<select style="width:250px; height:30px;" name="search_cust">
						<option value="">ALL</option>
						<?php

						$dbconn = new dbconn;
						$res = $dbconn->createConn();
						$sql = "SELECT agent_id,CONCAT(first_name,' ',last_name)as full FROM t_agents; ";
						// switch ($lv) {
						// 	case 1:
						// 		$sql = $sql . " WHERE app.agent_id =  " . dbNumberFormat($_SESSION["uid"]);
						// 		break;
						// 	case 2:
						// 		$sql = $sql . " WHERE team_id = ( SELECT team_id FROM t_agents WHERE agent_id = " . dbNumberFormat($uid) . ") ";
						// 		break;
						// 	case 3:
						// 		$sql = $sql . " WHERE team_id = ( SELECT team_id FROM t_agents WHERE agent_id = " . dbNumberFormat($uid) . ") ";
						// 		break;
						// 	case 4:
						// 		$sql = $sql . " WHERE group_id = ( SELECT group_id FROM t_agents WHERE agent_id = " . dbNumberFormat($uid) . ") ";
						// 		break;
						// } //end switch


						$result = $dbconn->executeQuery($sql);
						while ($rs = mysqli_fetch_array($result)) {
							echo "<option value='" . $rs['agent_id'] . "'> " . $rs['full'] . "</option>";
						}

						?>

					</select>
				</div>
			</div>
			<div style="width:50%;float:right;">
				<?php
				// session_start();
				$lv = $_SESSION["pfile"]["lv"];
				$uid = $_SESSION["uid"];
				if ($lv > 1) {
				?>
					<div>
						<span style="font-size:15px; line-height:30px; color:#666">Campaign Name &nbsp;&nbsp;: </span>
						<select style="width:250px; height:30px;" name="search_agent">
							<option value="">ALL</option>
							<?php

							$dbconn = new dbconn;
							$res = $dbconn->createConn();
							$sql = "SELECT campaign_id,campaign_name FROM t_campaign ";
							// switch ($lv) {
							// 	case 1:
							// 		$sql = $sql . " WHERE app.agent_id =  " . dbNumberFormat($_SESSION["uid"]);
							// 		break;
							// 	case 2:
							// 		$sql = $sql . " WHERE team_id = ( SELECT team_id FROM t_agents WHERE agent_id = " . dbNumberFormat($uid) . ") ";
							// 		break;
							// 	case 3:
							// 		$sql = $sql . " WHERE team_id = ( SELECT team_id FROM t_agents WHERE agent_id = " . dbNumberFormat($uid) . ") ";
							// 		break;
							// 	case 4:
							// 		$sql = $sql . " WHERE group_id = ( SELECT group_id FROM t_agents WHERE agent_id = " . dbNumberFormat($uid) . ") ";
							// 		break;
							// } //end switch


							$result = $dbconn->executeQuery($sql);
							while ($rs = mysqli_fetch_array($result)) {
								echo "<option value='" . $rs['campaign_id'] . "'> " . $rs['campaign_name'] . "</option>";
							}

							?>

						</select>
					</div>
				<?php
				}
				?>
			</div>
			<div style="clear:both"></div>
		</li>
		<!-- <li style="padding:5px; ">
			<div style="width:15%;float:left;">
				&nbsp;
			</div>
			<div style="width:35%;float:left; ">
				<span style="font-size:15px; line-height:30px; color:#666">Policy No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span>
				<input type="text" name="search_quono" style="width:250px;" autocomplete="off" placeholder="ระบุหมายเลข Quotation">
			</div>
			<div style="width:50%;float:right;">
				<div>
					<span style="font-size:15px; line-height:30px;color:#666">App Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span>
					<select style="width:250px; height:30px;" name="search_sts">
						<option value="">ALL</option>
						<option value="Follow-doc">Follow-doc</option>
						<option value="Submit">Submit</option>
						<option value="Re-submit">Re-submit</option>
						<?php
						// session_start();
						$lv = $_SESSION["pfile"]["lv"];
						if ($lv > 1) {
						?>
							<option value="Approve">Approve</option>
							<option value="Reconfirm">Reconfirm</option>
							<option value="Reconfirm-App">Reconfirm-App</option>
							<option value="Withdraw- CANNOT CONTACT CUSTOMER">Withdraw- CANNOT CONTACT CUSTOMER</option>
							<option value="Withdraw- CANCEL POLICY BY CUSTOMER">Withdraw- CANCEL POLICY BY CUSTOMER</option>
							<option value="Withdraw- CANCEL POLICY BY COMPANY">Withdraw- CANCEL POLICY BY COMPANY</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div style="clear:both"></div>
		</li> -->
		<li style="padding:5px; ">
			<div style="width:15%;float:left;">
				&nbsp;
			</div>
			<div style="width:35%;float:left; ">
				<span style="font-size:15px; line-height:28px;color:#444"> Application Create Date </span>
			</div>
			<div style="clear:both"></div>
		</li>
		<li style="padding:0 5px;">
			<div style="width:15%;float:left;">
				&nbsp;
			</div>
			<div style="width:35%;float:left;color:#666; font-size:16px;">
				<span style="font-size:15px; line-height:30px;width:118px;display:inline-block;"> Start Date </span> :
				<input type="text" name="search_cred" style="width:250px; " autocomplete="off" placeholder="เลือกวันที่เริ่มสร้าง app" class="text-center calendar_en">
			</div>
			<div style="width:50%;float:right;">
				<div style="color:#666;">
					<span style="font-size:15px; line-height:30px;width:100px;display:inline-block;"> End Date</span> :
					<input type="text" name="search_endd" style="width:250px;" autocomplete="off" placeholder="เลือกวันที่สิ้นสุดการสร้าง app" class="text-center calendar_en">
				</div>
			</div>
			<div style="clear:both"></div>
		</li>
		<li style="text-align:center;padding:20px;">
			<div>
				<button class="btn btn-primary search-app" style="border-radius:3px; width:110px;"> Search </button> &nbsp;&nbsp;
				<button class="btn btn-default search-clear" style="border-radius:3px; width:110px;"> Clear </button>
			</div>
		</li>
	</ul>

	<br />
	<br />
	<table id="app-table" class="table table-bordered" style="background-color:#fff;width: 100%;">
		<!-- <thead>
		<tr class="primary">
			<td class="text-center" style="width:5%"> # </td>
			<td class="text-center" style="width:10%"> Quotation NO </td>
			<td class="text-center" style="width:15%"> Customer Name </td>
			<td class="text-center" style="width:10%"> Product </td>
			<td class="text-center" style="width:10%"> Sale Date </td>
			<td class="text-center" style="width:10%"> App Status</td>
			<td class="text-center" style="width:15%"> Owner</td>
			<td class="text-center" style="width:20%"> Action </td>
		</tr>
	</thead>
	<tbody>
	<tr>

	</tr>
	</tbody> -->
		<!--
	<tfoot>
				<tr>

	</tfoot>
	-->
	</table>


</div>
<!--  end agent-main-pane -->

<!-- start agent-detail-pane -->
<div id="app-detail-pane" style="display:none">



</div>

<script type="text/javascript" src="js/appVoice.js"></script>

<?php
// Flush the output buffer and send output to the browser
ob_end_flush();
?>