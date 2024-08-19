<?php include "dbconn.php" ?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php require_once("class/Encrypt.php"); ?> 
<?php


if (isset($_POST['action'])) {

	switch ($_POST['action']) {
			// ===== TESTING =====
		case "getleadbycmp":
			getLeadListByCampaign();
			break;
			// ===== TESTING =====

		case "getcmp":
			getCampaign();
			break;
		case "getlead":
			getLead();
			break;

		case "getgroup":
			getGroup();
			break;
		case "getteam":
			getTeam();
			break;

			//agent performance report
		case "agent_performance_report":
			agent_performance_report();
			break;
		case "agent_performance_report_export":
			agent_performance_report_export();
			break;

			//list conversion report
		case "list_conversion_report":
			list_conversion_report();
			break;
		case "list_conversion_report_export":
			list_conversion_report_export();
			break;

			//call wrapup report
		case "call_wrapup_report":
			call_wrapup_report();
			break;
		case "call_wrapup_report_export":
			call_wrapup_report_export();
			break;

			//confirm call report
		case "confirm_call_report":
			confirm_call_report();
			break;
		case "confirm_call_report_export":
			confirm_call_report_export();
			break;
	}
}

function getGroup()
{

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT group_id , group_name FROM t_group " .
		" ORDER BY group_name ";

	wlog("[report_process][getGroup] sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$data[$count] = array(
			"id"  => nullToEmpty($rs['group_id']),
			"val"  => nullToEmpty($rs['group_name']),
		);
		$count++;
	}

	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

function getTeam()
{

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT team_id , team_name FROM t_team " .
		" WHERE group_id = " . dbNumberFormat($_POST['groupid']) .
		" ORDER BY team_name ";

	wlog("[report_process][getTeam] sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$data[$count] = array(
			"id"  => nullToEmpty($rs['team_id']),
			"val"  => nullToEmpty($rs['team_name']),
		);
		$count++;
	}

	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}


function getCampaign()
{

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT campaign_id , campaign_name FROM t_campaign " .
		" ORDER BY campaign_id ";

	wlog("[report_process][init] sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$data[$count] = array(
			"id"  => nullToEmpty($rs['campaign_id']),
			"val"  => nullToEmpty($rs['campaign_name']),
		);
		$count++;
	}

	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}


// ================= TESTING =======================
function getLeadListByCampaign()
{
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	// Get the selected campaign_ids from the HTML select element
	$selectedCampaignIds = isset($_POST['campaign_id_selected']) ? $_POST['campaign_id_selected'] : array();

	// Use the selected campaign_ids to dynamically build the WHERE condition
	$whereCondition = !empty($selectedCampaignIds) ? "AND t_campaign.campaign_id IN (" . implode(",", $selectedCampaignIds) . ")" : "";

	$sql = "SELECT t_campaign.campaign_id, t_campaign.campaign_name, t_campaign_list.import_id, t_import_list.list_name
	FROM t_campaign AS t_campaign 
	JOIN t_campaign_list ON t_campaign.campaign_id = t_campaign_list.campaign_id
	JOIN t_import_list ON t_campaign_list.import_id = t_import_list.import_id
	WHERE 1 " . $whereCondition . "
	ORDER BY t_campaign.campaign_id";

	wlog("[report_process][getLeadListByCampaign] sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$data[$count] = array(
			"campaign_id"  => nullToEmpty($rs['campaign_id']),
			"campaign_name"  => nullToEmpty($rs['campaign_name']),
			"import_id"  => nullToEmpty($rs['import_id']),
			"list_name"  => nullToEmpty($rs['list_name']),
		);
		$count++;
	}

	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

// ================= TESTING =======================

function getLead()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT i.import_id , i.list_name  " .
		" FROM t_import_list i , t_campaign_list c " .
		" WHERE i.import_id = c.import_id " .
		" AND c.campaign_id = " . $_POST['cmpid'] . " " .
		" ORDER BY i.import_id ";

	wlog("[report_process][getLead] sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$data[$count] = array(
			"id"  => nullToEmpty($rs['import_id']),
			"val"  => nullToEmpty($rs['list_name']),
		);
		$count++;
	}

	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

function agent_performance_report()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT list_name, group_name,team_name,first_name,last_name,transaction_dt,transfer_total_rec,revoke_total_rec,  list_onhand " .
		" ,list_new,call_nocontact,call_callback,call_followup,call_followdoc,call_donotcall,call_badlist,call_closedsales " .
		" ,call_unclosedsales,call_overlimit  " .
		" FROM rpt_t_agent_performance_daily_by_list " .
		//  " FROM v_agent_performance_daily_by_list ".
		" WHERE transaction_dt IS NOT NULL ";


	if ($tmp['agentp_search_campaign'] != "") {
		$sql = $sql . " AND campaign_id =  " . dbNumberFormat($tmp['agentp_search_campaign']) . " ";
	}
	if ($tmp['agentp_search_group'] != "") {
		$sql = $sql . " AND group_id =  " . dbNumberFormat($tmp['agentp_search_group']) . " ";
	}
	if ($tmp['agentp_search_team'] != "") {
		$sql = $sql . " AND team_id =  " . dbNumberFormat($tmp['agentp_search_team']) . " ";
	}
	if ($tmp['agentp_search_agent'] != "") {
		$sql = $sql . " AND agent_id =  " . dbNumberFormat($tmp['agentp_search_agent']) . " ";
	}
	if ($tmp['agentp_search_cred'] != "") {
		if ($tmp['agentp_search_endd'] != "") {
			$sql = $sql . " AND transaction_dt BETWEEN " . dateEncode($tmp['agentp_search_cred']) . " AND " . dateEncode($tmp['agentp_search_endd']) . "  ";
		}
	}

	wlog("[report_process][agent_performance_report]  sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$nid = $rs['news_id'];
		$data[$count] = array(
			"lname"  => nullToEmpty($rs['list_name']),
			"gname"  => nullToEmpty($rs['group_name']),
			"tname"  => nullToEmpty($rs['team_name']),
			"aname" => nullToEmpty($rs['first_name'] . " " . $rs['last_name']),
			"cred"  => dateDecode($rs['transaction_dt']),
			"transfertotal"  => nullToZero($rs['transfer_total_rec']),
			"revoketotal"  => nullToZero($rs['revoke_total_rec']),
			"lonhand"  => nullToZero($rs['list_onhand']),
			"lnew"  => nullToZero($rs['list_new']),
			"nocont" => nullToZero($rs['call_nocontact']),
			"callback" => nullToZero($rs['call_callback']),
			"followup"  => nullToZero($rs['call_followup']),
			"followdoc"  => nullToZero($rs['call_followdoc']),
			"donotcall"  => nullToZero($rs['call_donotcall']),
			"callbadlist"  => nullToZero($rs['call_badlist']),
			"closedsales"  => nullToZero($rs['call_closedsales']),
			"unclosedsales" => nullToZero($rs['call_unclosedsales']),
			"overlimit" => nullToZero($rs['call_overlimit']),

		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

function agent_performance_report_export()
{

	//echo dirname(__FILE__);
	/** PHPExcel */
	//require_once 'plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	date_default_timezone_set('Asia/Bangkok');
	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';


	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = "SELECT REVERSE(SUBSTRING( REVERSE(AGENT),instr( REVERSE(AGENT),'-')+1,LENGTH(AGENT))) AS AGENT " .
		" , queuename , q_date  " .
		" ,min( DATE_FORMAT(LOGIN_TIME, '%d/%m/%Y %H:%i:%s') )  AS LOGIN_TIME " .
		" ,max( DATE_FORMAT(LOGOUT_TIME, '%d/%m/%Y %H:%i:%s') ) AS LOGOUT_TIME " .
		",COUNT( DISTINCT ANSWER_CALL) AS ANSWER_CALL " .
		",COUNT( DISTINCT ABD_CALL)  AS ABD_CALL " .
		",COUNT( BUSY_CALL)  AS BUSY_CALL " .
		",SEC_TO_TIME( IFNULL(SUM(COMPLETEAGENT)/COUNT( DISTINCT ANSWER_CALL) ,0) ) AS AVG_TALKTIME " .
		" FROM V_AGENT_PERFORMANCE " .
		" WHERE q_date between " . dateStart($tmp['search_start']) . " and " . dateEnd($tmp['search_end']) . " ";



	if ($tmp['search_agent'] != "all") {
		$sql = $sql . "AND  REVERSE(SUBSTRING( REVERSE(AGENT),instr( REVERSE(AGENT),'-')+1,LENGTH(AGENT)))  collate latin1_swedish_ci  LIKE '" . $tmp['search_agent'] . "%' ";
	}

	if ($tmp['search_qname'] != "all") {
		$sql = $sql . " AND  queuename collate latin1_swedish_ci = " . dbformat($tmp['search_qname']) . " ";
	}

	$sql = $sql . " GROUP BY REVERSE(SUBSTRING( REVERSE(AGENT),instr( REVERSE(AGENT),'-')+1,LENGTH(AGENT))) , queuename , q_date " .
		" ORDER BY q_date , agent ,queuename,  LOGIN_TIME ";

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->setTitle('Agent Performance');
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Group Name');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Team Name');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Agent Name');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Date');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Transfer List');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Revoke List ');
	$objPHPExcel->getActiveSheet()->setCellValue('G1', 'On-hands List');
	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'New List');
	$objPHPExcel->getActiveSheet()->setCellValue('I1', 'No Contact');
	$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Call Back');
	$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Follow Up');
	$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Follow Doc');
	$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Do Not Call List');
	$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Bad List');
	$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Close Sales');
	$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Unclsoe Sales');
	$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Over Limit Trying Call');

	foreach ($objPHPExcel->getActiveSheet()->getColumnDimension() as $col) {
		$col->setAutoSize(true);
	}
	$objPHPExcel->getActiveSheet()->calculateColumnWidths();


	$row = 2;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, nullToEmpty($rs['AGENT']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, nullToEmpty($rs['queuename']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, nullToZero($rs['q_date']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, nullToNA($rs['LOGIN_TIME']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, nullToNA($rs['LOGOUT_TIME']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, nullToZero($rs['ANSWER_SEC']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row,  nullToZero($rs['ABD_SEC']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row,  nullToZero($rs['BUSY_SEC']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row,  nullToZero($rs['AVG_TALKTIME']));
		$row++;
	}


	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); // Set excel version 2007
	$save_path = dirname(__FILE__) . '/temp/agent_performance.xlsx';
	$objWriter->save($save_path);  // Write file

	$result = array("result" => "success");
	echo json_encode($result);
}

function confirm_call_report()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$startdate = $tmp['startdate'];
	$enddate = $tmp['enddate'];
	$startdate = str_replace('/', '-', $startdate);
	$enddate = str_replace('/', '-', $enddate);
	$startdate = date('Y-m-d', strtotime($startdate));
	$enddate = date('Y-m-d', strtotime($enddate));
	$sql = " SELECT * FROM v_confirm_call_report " .
		//  " FROM v_agent_performance_daily_by_list ".
		//  " WHERE Appstatus='QC_Approved' and Approved_Date between '$startdate' and '$enddate' ";
		//" WHERE Appstatus='Approve' and Approved_Date between '$startdate' and '$enddate' AND flag = 2 ";
		" WHERE Appstatus='Approve' and DATE(tpa_upload_date) between '$startdate' and '$enddate' AND flag = 2 ";

	wlog("[report_process][confirm_call_report]  sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$cname = $rs["Firstname"] . " " . Encryption::decrypt($rs["Lastname"]);
		$data[$count] = array(
			"appid"  => nullToEmpty($rs['ProposalNumber']),
			"cname"  => nullToEmpty($cname),
			"aname"  => nullToEmpty($rs['Agent_Name']),
			"sdate" => nullToEmpty($rs['Sale_Date']),
			"adate"  => nullToEmpty($rs['Approved_Date']),
			"udate"  => nullToEmpty($rs['tpa_upload_date']),
			"astatus"  => nullToEmpty($rs['AppStatus']),
			"confirmid"  => nullToEmpty($rs['ConfirmID']),

		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

function confirm_call_report_export()
{

	//echo dirname(__FILE__);
	/** PHPExcel */
	//require_once 'plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	date_default_timezone_set('Asia/Bangkok');
	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';


	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$startdate = $tmp['startdate'];
	$enddate = $tmp['enddate'];
	$startdate = str_replace('/', '-', $startdate);
	$enddate = str_replace('/', '-', $enddate);
	$startdate = date('Y-m-d', strtotime($startdate));
	$enddate = date('Y-m-d', strtotime($enddate));
	$sql = " SELECT * FROM v_confirm_call_report " .
		//  " FROM v_agent_performance_daily_by_list ".
		//  " WHERE Appstatus='QC_Approved' and Approved_Date between '$startdate' and '$enddate' ";
		//" WHERE Appstatus='Approve' and Approved_Date between '$startdate' and '$enddate' AND flag = 2 ";
		" WHERE Appstatus='Approve' and DATE(tpa_upload_date) between '$startdate' and '$enddate' AND flag = 2 ";

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->setTitle('ConfirmCall');
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Policy');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Firstname');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Lastname');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Mobile');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ConfirmID');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Sale Date');

	foreach ($objPHPExcel->getActiveSheet()->getColumnDimension() as $col) {
		$col->setAutoSize(true);
	}
	$objPHPExcel->getActiveSheet()->calculateColumnWidths();


	$row = 2;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$appNo = $rs['plancode'] . $rs['ProposalNumber'];
		$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(0, $row, nullToEmpty(($appNo)));
		$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(1, $row, nullToEmpty($rs['Firstname']));
		$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(2, $row, nullToEmpty(Encryption::decrypt($rs["Lastname"])));
		$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(3, $row, nullToEmpty(Encryption::decrypt($rs['Mobile'])));
		$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(4, $row, nullToEmpty($rs['ConfirmID']));
		$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(5, $row, nullToEmpty($rs['Sale_Date']));
		$row++;
	}


	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); // Set excel version 2007
	$save_path = dirname(__FILE__) . '/temp/call_confirm.xlsx';
	$objWriter->save($save_path);  // Write file

	$result = array("result" => "success");
	echo json_encode($result);
}

function list_conversion_report()
{
	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//old
	/*
	     $sql = " SELECT campaign_name , list_name , list_load , list_used , list_used_percent , list_remain , list_remain_percent, list_dmc , list_dmc_percent, ".
					" list_success,list_success_percent,list_unsuccess,list_unsuccess_percent,list_app,list_app_percent,list_ineffective , list_ineffective_percent, ".
					" list_inprogress ,list_inprogress_percent, list_callback , list_callback_percent , list_followup , list_followup_percent , list_badlist , list_badlist_percent ".
					" FROM v_list_conversion ".
					" where campaign_id = 1 ";
	     */

	//new
	$sql = " SELECT r.campaign_id , r.campaign_name , r.import_id , r.list_name , r.list_load , r.list_used , r.list_used_percent , r.list_remain , r.list_remain_percent , r.list_dmc , " .
		" r.list_dmc_percent , r.list_success , r.list_success_percent , r.list_unsuccess , r.list_unsuccess_percent , r.list_app , r.list_app_percent , r.list_ineffective , r.list_ineffective_percent , " .
		" r.list_inprogress ,r.list_inprogress_percent , r.list_callback , r.list_callback_percent , r.list_followup , r.list_followup_percent , r.list_badlist , r.list_badlist_percent , r.policy_premium_approved , r.policy_premium_inforce " .
		" from v_list_conversion r";
	// " from rpt_t_list_conversion  r 

	/*
inner join ( 
select max(transaction_dt) as max_transaction_dt ,campaign_id,import_id
from rpt_t_list_conversion 
group by  campaign_id,import_id ) as m 
on ( r.transaction_dt = m.max_transaction_dt
and r.campaign_id = m.campaign_id
and r.import_id = m.import_id )   ";
*/
	if ($tmp['listconv_search_campaign'] != "") {
		$sql = $sql . " WHERE r.campaign_id = " . dbNumberFormat($tmp['listconv_search_campaign']);
	}
	if ($tmp['listconv_search_lead'] != "") {
		$sql = $sql . " AND r.import_id = " . dbNumberFormat($tmp['listconv_search_lead']);
	}


	wlog("[report_process][list_conversion_report]  sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$nid = $rs['news_id'];
		$data[$count] = array(
			"cname"  => nullToEmpty($rs['campaign_name']),
			"lanme"  => nullToEmpty($rs['list_name']),
			"lload"  => nullToEmpty($rs['list_load']),
			"lused"  => nullToEmpty($rs['list_used']),
			"lusedp"  => nullToEmpty($rs['list_used_percent']),
			"lremain"  => nullToEmpty($rs['list_remain']),
			"lremainp"  => nullToEmpty($rs['list_remain_percent']),
			"ldmc" => nullToEmpty($rs['list_dmc']),
			"ldmcp" => nullToEmpty($rs['list_dmc_percent']),
			"lsuccess"  => nullToEmpty($rs['list_success']),
			"lsuccessp"  => nullToEmpty($rs['list_success_percent']),
			"lunsuccess"  => nullToEmpty($rs['list_unsuccess']),
			"lunsuccessp"  => nullToEmpty($rs['list_unsuccess_percent']),
			"lapp"  => nullToEmpty($rs['list_app']),
			"lappp" => nullToEmpty($rs['list_app_percent']),
			"lineff" => nullToEmpty($rs['list_ineffective']),
			"lineffp" => nullToEmpty($rs['list_ineffective_percent']),
			"linp" => nullToEmpty($rs['list_inprogress']),
			"linpp" => nullToEmpty($rs['list_inprogress_percent']),
			"lcback" => nullToEmpty($rs['list_callback']),
			"lcbackp" => nullToEmpty($rs['list_callback_percent']),
			"lfollow" => nullToEmpty($rs['list_followup']),
			"lfollowp" => nullToEmpty($rs['list_followup_percent']),
			"lbad" => nullToEmpty($rs['list_badlist']),
			"lbadp" => nullToEmpty($rs['list_badlist_percent']),

			"policyapp" => nullToEmpty($rs['policy_premium_approved']),
			"policyinf" => nullToEmpty($rs['policy_premium_inforce'])
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	/*
				
				$sql = "SELECT  campaign_id , campaign_name ".  
							", sum( list_load ) as list_load, sum( list_used ) as list_used ".
							", (sum( list_used ) *100) / sum( list_load ) as list_used_percent ".
							", sum( list_remain ) as list_remain, (sum( list_remain ) *100) / sum( list_load ) as list_remain_percent ".
							", sum( list_dmc ) as list_dmc, (sum( list_dmc ) *100) / sum( list_used )  as list_dmc_percent ".
							", sum( list_success ) as list_success, (sum( list_success ) *100) / sum( list_used )as list_success_percent ".
							", sum( list_unsuccess ) as list_unsuccess, (sum( list_unsuccess ) *100) / sum( list_used ) as list_unsuccess_percent ".
							", sum( list_app ) as list_app, (sum( list_app ) *100) / sum( list_used )as list_app_percent ".
							", sum( list_ineffective ) as list_ineffective, (sum( list_ineffective ) *100) / sum( list_used ) as list_ineffective_percent ".
							", sum( list_inprogress ) as list_inprogress, (sum( list_inprogress ) *100) / sum( list_used ) as list_inprogress_percent ".
							", sum( list_callback ) as list_callback, (sum( list_callback ) *100) / sum( list_used ) as list_callback_percent ".
							", sum( list_followup ) as list_followup, (sum( list_followup ) *100) / sum( list_used ) as list_followup_percent ".
							", sum( list_badlist ) as list_badlist, (sum( list_badlist ) *100) / sum( list_used ) as list_badlist_percent ".
							" FROM v_list_conversion ";

	    if( $tmp['listconv_search_campaign'] != ""){
	     		$sql = $sql." WHERE campaign_id = ".dbNumberFormat($tmp['listconv_search_campaign']);
	     }
	     if( $tmp['listconv_search_lead'] != "" ){
	     		$sql = $sql." AND import_id = ".dbNumberFormat($tmp['listconv_search_lead']);
	     }
				$sql = $sql." GROUP BY campaign_id  , campaign_name ";
				
			$count = 0;    
	        $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
				  	$data2[$count] = array(
				  					"cname"  => nullToEmpty($rs['campaign_name']),
								    "lanme"  => nullToEmpty($rs['list_name']),
									"lload"  => nullToEmpty($rs['list_load']),
								    "lused"  => nullToEmpty($rs['list_used']),
				  					"lusedp"  => nullToEmpty($rs['list_used_percent']),
									"lremain"  => nullToEmpty($rs['list_remain']),
				  					"lremainp"  => nullToEmpty($rs['list_remain_percent']),
				  					"ldmc" => nullToEmpty( $rs['list_dmc']),
				  					"ldmcp" => nullToEmpty($rs['list_dmc_percent']),
				  					"lsuccess"  => nullToEmpty($rs['list_success']),
								    "lsuccessp"  => nullToEmpty($rs['list_success_percent']),
				  					 "lunsuccess"  => nullToEmpty($rs['list_unsuccess']),
									"lunsuccessp"  => nullToEmpty($rs['list_unsuccess_percent']),
				  					"lapp"  => nullToEmpty($rs['list_app']),
				  					"lappp" => nullToEmpty( $rs['list_app_percent']),
				  					"lineff" => nullToEmpty($rs['list_ineffective']),
				  					"lineffp" => nullToEmpty($rs['list_ineffective_percent']),
							  		"linp" => nullToEmpty($rs['list_inprogress']),
							  		"linpp" => nullToEmpty($rs['list_inprogress_percent']),
				  					"lcback" => nullToEmpty($rs['list_callback']),
				  					"lcbackp" => nullToEmpty($rs['list_callback_percent']),
							  		"lfollow" => nullToEmpty($rs['list_followup']),
							  		"lfollowp" => nullToEmpty($rs['list_followup_percent']),
				  	  				"lbad" => nullToEmpty($rs['list_badlist']),
							  		"lbadp" => nullToEmpty($rs['list_badlist_percent'])				
							);   
					$count++;  
				}
			    if($count==0){
					$data = array("result"=>"empty");
				} 
				*/

	$dbconn->dbClose();
	echo json_encode($data);
}

function list_conversion_report_export()
{

	//echo dirname(__FILE__);
	/** PHPExcel */
	//require_once 'plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	//date_default_timezone_set('Asia/Bangkok');
	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT campaign_name , list_name , list_load , list_used , list_used_percent , list_remain , list_remain_percent, list_dmc , list_dmc_percent, " .
		" list_success,list_success_percent,list_unsuccess,list_unsuccess_percent,list_app,list_app_percent,list_ineffective , list_ineffective_percent, " .
		" list_inprogress ,list_inprogress_percent, list_callback , list_callback_percent , list_followup , list_followup_percent " .
		" FROM v_list_conversion " .
		" where campaign_id = 1 ";

	wlog("[report_process][list_conversion_report_export]  sql :  " . $sql);

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->setTitle('List Conversion');
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'List Name');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'List Load');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'List Used');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'List Remain');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'List DMC');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'List Success');
	$objPHPExcel->getActiveSheet()->setCellValue('G1', 'List Unsuccess');
	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'List App');
	$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Ineffective Contact');
	$objPHPExcel->getActiveSheet()->setCellValue('J1', 'List Inprogress');
	$objPHPExcel->getActiveSheet()->setCellValue('K1', 'List Callback');
	$objPHPExcel->getActiveSheet()->setCellValue('L1', 'List Followup');
	$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Bad List');

	foreach ($objPHPExcel->getActiveSheet()->getColumnDimension() as $col) {
		$col->setAutoSize(true);
	}
	$objPHPExcel->getActiveSheet()->calculateColumnWidths();


	$row = 3;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, nullToEmpty($rs['campaign_name']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, nullToEmpty($rs['list_name']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, nullToEmpty($rs['list_load']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, nullToEmpty($rs['list_used']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, nullToEmpty($rs['list_used_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, nullToEmpty($rs['list_remain']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row,  nullToEmpty($rs['list_remain_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row,  nullToEmpty($rs['list_dmc']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row,  nullToEmpty($rs['list_dmc_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, nullToEmpty($rs['list_success']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row,  nullToEmpty($rs['list_success_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row,  nullToEmpty($rs['list_unsuccess']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row,  nullToEmpty($rs['list_unsuccess_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, nullToEmpty($rs['list_app']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row,  nullToEmpty($rs['list_app_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row,  nullToEmpty($rs['list_ineffective']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row,  nullToEmpty($rs['list_ineffective_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, nullToEmpty($rs['list_inprogress']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row,  nullToEmpty($rs['list_inprogress_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row,  nullToEmpty($rs['list_callback']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row,  nullToEmpty($rs['list_callback_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row,  nullToEmpty($rs['list_followup']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row,  nullToEmpty($rs['list_followup_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $row,  nullToEmpty($rs['list_badlist']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $row,  nullToEmpty($rs['list_badlist_percent']));

		$row++;
	}


	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); // Set excel version 2007

	//$save_path = dirname(__FILE__) .'/logs/test.xlsx';
	$save_path = dirname(__FILE__) . '/temp/list_conversion.xlsx';
	$objWriter->save($save_path);  // Write file

	$result = array("result" => "success");
	echo json_encode($result);
}


function call_wrapup_report()
{
	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//old
	/*
	     $sql = " SELECT campaign_name , list_name , list_load , list_used , list_used_percent , list_remain , list_remain_percent, list_dmc , list_dmc_percent, ".
					" list_success,list_success_percent,list_unsuccess,list_unsuccess_percent,list_app,list_app_percent,list_ineffective , list_ineffective_percent, ".
					" list_inprogress ,list_inprogress_percent, list_callback , list_callback_percent , list_followup , list_followup_percent , list_badlist , list_badlist_percent ".
					" FROM v_list_conversion ".
					" where campaign_id = 1 ";
	     */

	//new
	$sql = " SELECT campaign_id , campaign_name , import_id , list_name , list_load , list_used , list_used_percent , list_remain , list_remain_percent , list_dmc , " .
		" list_dmc_percent , list_success , list_success_percent , list_unsuccess ,list_unsuccess_percent , list_app , list_app_percent , list_ineffective , list_ineffective_percent , " .
		" list_inprogress ,list_inprogress_percent , list_callback , list_callback_percent , list_followup , list_followup_percent , list_badlist , list_badlist_percent " .
		" FROM v_list_conversion ";

	if ($tmp['listconv_search_campaign'] != "") {
		$sql = $sql . " WHERE campaign_id = " . dbNumberFormat($tmp['listconv_search_campaign']);
	}
	if ($tmp['listconv_search_lead'] != "") {
		$sql = $sql . " AND import_id = " . dbNumberFormat($tmp['listconv_search_lead']);
	}


	wlog("[report_process][list_conversion_report]  sql :  " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$nid = $rs['news_id'];
		$data[$count] = array(
			"cname"  => nullToEmpty($rs['campaign_name']),
			"lanme"  => nullToEmpty($rs['list_name']),
			"lload"  => nullToEmpty($rs['list_load']),
			"lused"  => nullToEmpty($rs['list_used']),
			"lusedp"  => nullToEmpty($rs['list_used_percent']),
			"lremain"  => nullToEmpty($rs['list_remain']),
			"lremainp"  => nullToEmpty($rs['list_remain_percent']),
			"ldmc" => nullToEmpty($rs['list_dmc']),
			"ldmcp" => nullToEmpty($rs['list_dmc_percent']),
			"lsuccess"  => nullToEmpty($rs['list_success']),
			"lsuccessp"  => nullToEmpty($rs['list_success_percent']),
			"lunsuccess"  => nullToEmpty($rs['list_unsuccess']),
			"lunsuccessp"  => nullToEmpty($rs['list_unsuccess_percent']),
			"lapp"  => nullToEmpty($rs['list_app']),
			"lappp" => nullToEmpty($rs['list_app_percent']),
			"lineff" => nullToEmpty($rs['list_ineffective']),
			"lineffp" => nullToEmpty($rs['list_ineffective_percent']),
			"linp" => nullToEmpty($rs['list_inprogress']),
			"linpp" => nullToEmpty($rs['list_inprogress_percent']),
			"lcback" => nullToEmpty($rs['list_callback']),
			"lcbackp" => nullToEmpty($rs['list_callback_percent']),
			"lfollow" => nullToEmpty($rs['list_followup']),
			"lfollowp" => nullToEmpty($rs['list_followup_percent']),
			"lbad" => nullToEmpty($rs['list_badlist']),
			"lbadp" => nullToEmpty($rs['list_badlist_percent'])
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

function call_wrapup_report_export()
{

	//echo dirname(__FILE__);
	/** PHPExcel */
	//require_once 'plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	//date_default_timezone_set('Asia/Bangkok');
	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT campaign_name , list_name , list_load , list_used , list_used_percent , list_remain , list_remain_percent, list_dmc , list_dmc_percent, " .
		" list_success,list_success_percent,list_unsuccess,list_unsuccess_percent,list_app,list_app_percent,list_ineffective , list_ineffective_percent, " .
		" list_inprogress ,list_inprogress_percent, list_callback , list_callback_percent , list_followup , list_followup_percent " .
		" FROM v_list_conversion " .
		" where campaign_id = 1 ";

	wlog("[report_process][list_conversion_report_export]  sql :  " . $sql);

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->setTitle('List Conversion');
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'List Name');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'List Load');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'List Used');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'List Remain');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'List DMC');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'List Success');
	$objPHPExcel->getActiveSheet()->setCellValue('G1', 'List Unsuccess');
	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'List App');
	$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Ineffective Contact');
	$objPHPExcel->getActiveSheet()->setCellValue('J1', 'List Inprogress');
	$objPHPExcel->getActiveSheet()->setCellValue('K1', 'List Callback');
	$objPHPExcel->getActiveSheet()->setCellValue('L1', 'List Followup');
	$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Bad List');

	foreach ($objPHPExcel->getActiveSheet()->getColumnDimension() as $col) {
		$col->setAutoSize(true);
	}
	$objPHPExcel->getActiveSheet()->calculateColumnWidths();


	$row = 3;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, nullToEmpty($rs['campaign_name']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, nullToEmpty($rs['list_name']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, nullToEmpty($rs['list_load']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, nullToEmpty($rs['list_used']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, nullToEmpty($rs['list_used_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, nullToEmpty($rs['list_remain']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row,  nullToEmpty($rs['list_remain_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row,  nullToEmpty($rs['list_dmc']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row,  nullToEmpty($rs['list_dmc_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, nullToEmpty($rs['list_success']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row,  nullToEmpty($rs['list_success_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row,  nullToEmpty($rs['list_unsuccess']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row,  nullToEmpty($rs['list_unsuccess_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, nullToEmpty($rs['list_app']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row,  nullToEmpty($rs['list_app_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row,  nullToEmpty($rs['list_ineffective']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row,  nullToEmpty($rs['list_ineffective_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, nullToEmpty($rs['list_inprogress']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row,  nullToEmpty($rs['list_inprogress_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row,  nullToEmpty($rs['list_callback']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row,  nullToEmpty($rs['list_callback_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row,  nullToEmpty($rs['list_followup']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row,  nullToEmpty($rs['list_followup_percent']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $row,  nullToEmpty($rs['list_badlist']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $row,  nullToEmpty($rs['list_badlist_percent']));

		$row++;
	}


	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); // Set excel version 2007

	//$save_path = dirname(__FILE__) .'/logs/test.xlsx';
	$save_path = dirname(__FILE__) . '/temp/list_conversion.xlsx';
	$objWriter->save($save_path);  // Write file

	$result = array("result" => "success");
	echo json_encode($result);
}


?>
