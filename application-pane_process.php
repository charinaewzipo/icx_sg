<?php session_start(); ?>
<?php include "dbconn.php" ?>
<?php include "util.php"  ?>
<?php include "wlog.php"  ?>
<?php
include "./class/Encrypt.php";
?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//util
function dateEncodeSpace($input)
{
	$input = trim($input);
	if ($input != "") {
		$date = explode('/', $input);
		$ThaiToEngYear = ((int)$date[2]); // - 543;
		return "'" . $ThaiToEngYear . $date[1] . $date[0] . "'";  //reconfig
	} else {
		return "";
		//return null;
	}
}
function dateDecodeSpace($input)
{
	$input = trim($input);
	if ($input != "") {
		$y = substr($input, 0, 4);
		$m = substr($input, 4, 2);
		$d = substr($input, 6, 2);

		return $d . '/' . $m . '/' . $y;
	} else {
		return "";
		//return null;
	}
}

if (isset($_POST['action'])) {

	switch ($_POST['action']) {
		case "init":
			init();
			break;
		case "query":
			query();
			break;

		case "detail":
			detail();
			break;
		case "save":
			save();
			break;
		case "delete":
			delete();
			break;

		case "check":
			check();
			break;
		case "lock":
			takeaction();
			break;
		case "unlock":
			takeaction();
			break;
	}
}


function init()
{
	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//app falcon id == 3
	$sql = "SELECT ex_app_url , campaign_id  FROM t_external_app_register " .
		"WHERE ex_app_id = " . dbNumberFormat($tmp['exapp_id']) .
		" AND is_active = 1 ";

	wlog($sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$tmp1 = array(
			"cmpid"  => nullToEmpty($rs['campaign_id']),
			"url"  => nullToEmpty($rs['ex_app_url']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	$data = array("exapp" => $tmp1);
	$dbconn->dbClose();
	echo json_encode($data);
}

function query()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	//connect tubtim db
	//$dbconn->setDBName('Tubtim');
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$page = 0;
	$condition = "";
	$pagelength = 50; //row per page
	if (isset($_POST['page'])) {
		$page =  (intval($_POST['page']) - 1) * $pagelength;
	}

	$sql = "SELECT  DISTINCT app.id, app.policyId, app.productId, app.distributionChannel, app.producerCode, app.propDate, app.policyEffDate, 
       app.policyExpDate, app.campaignCode, app.ncdInfo, app.policyHolderInfo, app.insuredList, app.quoteNo, 
       app.premiumPayable, app.quoteLapseDate, app.type, app.remarksC, app.type_vouncher, app.vouncher_value, 
       app.incident_status, app.dont_call_ind, app.dont_SMS_ind, app.dont_email_ind, app.dont_Mail_ind, 
       app.agent_id, app.calllist_id, app.policyNo, app.policy_create_date, app.quote_create_date, 
       app.update_date, app.campaign_id, app.import_id, tasp.product_name
FROM t_aig_app app 
LEFT JOIN t_aig_sg_product tasp ON app.productId = tasp.product_id
LEFT JOIN t_agents  agent ON app.agent_id = agent.agent_id
LEFT OUTER JOIN  t_campaign campaign ON app.campaign_id = campaign.campaign_id 
WHERE 1 GROUP BY app.id
";
	//if level is agent where current agent id


	$lv =  intval($_SESSION['pfile']['lv']);  // set application
	// switch ($lv) {
	// 	case 1:
	// 		$condition = $condition . " AND (AppStatus != 'Submit' or AppStatus != 'Submit Re-Confirm'  ) AND app.agent_id =  " . dbNumberFormat($_SESSION["uid"]);
	// 		break;
	// 	case 2:
	// 		$condition = $condition . " AND (AppStatus != 'Success') AND agent.team_id = ( SELECT team_id FROM t_agents WHERE agent_id = " . dbNumberFormat($_SESSION["uid"]) . ") ";
	// 		break;
	// 	case 0:
	// 		$condition = $condition . "  AND agent.team_id = ( SELECT team_id FROM t_agents WHERE agent_id = " . dbNumberFormat($_SESSION["uid"]) . ") ";
	// 		break;
	// 	case 4:
	// 		$condition = $condition . "  AND agent.group_id = ( SELECT group_id FROM t_agents WHERE agent_id = " . dbNumberFormat($_SESSION["uid"]) . ") ";
	// 		break;
	// 	case 5:
	// 		$condition = $condition . " ";
	// 		break;
	// 	case 3:
	// 		$condition = $condition . " AND (AppStatus != 'Follow Doc') ";
	// 		break;
	// 	case 7:
	// 		$condition = $condition . " AND (AppStatus IN ('Approve','QC_Approved')) ";
	// 		break;
	// } //end switch

	/*
			if(  $lv == 1){
			     $condition = $condition."AND app.agent_id =  ".dbNumberFormat($_SESSION["uid"]   );
			 }else if( $l{
 			    //check level

			 		//	$condition = $condition." WHERE AgentID IS NOT NULL";
			 }
			 //check level
  			*/
	if ($tmp['search_cust'] != "") {
		$condition = $condition . " AND app.fullname LIKE '%" . trim($tmp['search_cust']) . "%' ";
	}
	// if ($tmp['search_agent'] != "") {
	// 	$condition = $condition . " AND app.agent_id = " . dbformat($tmp['search_agent']) . " ";
	// }
	if ($tmp['search_quono'] != "") {
		$condition = $condition . " AND app.quoteNo LIKE '%" . trim($tmp['search_quono']) . "%' ";
	}
	if ($tmp['search_sts'] != "") {
		$condition = $condition . " AND app.incident_status = " . dbformat($tmp['search_sts']) . " ";
	}
	if ($tmp['search_cred'] != "" & $tmp['search_endd'] != "") {
		$condition = $condition . " AND app.propDate BETWEEN '" . $tmp['search_cred'] . " 00:00:00' AND  '" . $tmp['search_endd'] . " 23:59:59'";
	}


	$sql = $sql . $condition;
	$sql .=  " ORDER BY app.propDate DESC ";
	//  " LIMIT ".$page." , ".$pagelength;

	wlog('[application-pane_process][query] query : ' . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$policyHolderInfo = json_decode($rs['policyHolderInfo'], true);

		$custname = "";
		if (isset($policyHolderInfo['individualPolicyHolderInfo']['fullName'])) {
			$custname = Encryption::decrypt($policyHolderInfo['individualPolicyHolderInfo']['fullName']);
		}
		$data[$count] = array(
			"id"  => nullToEmpty($rs['id']),
			"quono"  => nullToEmpty($rs['quoteNo']),
			"cname"  => nullToEmpty($custname),
			"camp" => nullToEmpty($rs['product_name']),
			"camp_id" => nullToEmpty($rs['campaign_id']),
			"saledt"  => nullToEmpty($rs['policy_create_date']),
			"appsts"  => nullToEmpty($rs['incident_status']),
			// "owner"  => nullToEmpty($rs['owner']),
			// "qc_name"  => nullToEmpty($rs['qc_name']),
			// "qa_name"  => nullToEmpty($rs['qa_name'])
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	//count row for paging
	$sql = " SELECT COUNT(id) AS total " .
		" FROM t_aig_app app LEFT OUTER JOIN  t_agents  agent ON app.agent_id = agent.agent_id ";
	//" FROM app a LEFT OUTER JOIN user u ON a.AgentID = u.Id ";
	$sql = $sql . $condition;

	// wlog( $sql );
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$total = nullToZero($rs['total']);
	}

	$data = array("data" => $data, "total" => $total);
	$dbconn->dbClose();
	echo json_encode($data);
}
function query2()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	//connect tubtim db
	//$dbconn->setDBName('Tubtim');
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$page = 0;
	$condition = "";
	$pagelength = 50; //row per page
	if (isset($_POST['page'])) {
		$page =  (intval($_POST['page']) - 1) * $pagelength;
	}

	$sql = " SELECT id, app_run_no, COALESCE(CONCAT(campaign.plancode,ProposalNumber),ProposalNumber) as quotation ,Firstname, Lastname, campaign.campaign_name as camp, " .
		" concat( agent.first_name ,' ', agent.last_name)  as owner , app.create_date as Sale_Date , AppStatus, app.campaign_id as camp_id, " .
		" (SELECT CONCAT(a.first_name,' ',a.last_name) FROM t_aig_qa_answer qa INNER JOIN t_agents a ON qa.create_by = a.agent_id WHERE col_id = 1 AND app_id = app.id LIMIT 1) as qc_name, " .
		" (SELECT CONCAT(a.first_name,' ',a.last_name) FROM t_aig_qa_answer qa INNER JOIN t_agents a ON qa.create_by = a.agent_id WHERE col_id = 2 AND app_id = app.id LIMIT 1) as qa_name " .
		" FROM t_aig_app app LEFT OUTER JOIN  t_agents  agent ON app.agent_id = agent.agent_id " .
		" LEFT OUTER JOIN  t_campaign campaign ON app.campaign_id = campaign.campaign_id " .
		" WHERE 1";

	//if level is agent where current agent id


	$lv =  intval($_SESSION['pfile']['lv']);  // set application
	switch ($lv) {
		case 1:
			$condition = $condition . " AND (AppStatus != 'Submit' or AppStatus != 'Submit Re-Confirm'  ) AND app.agent_id =  " . dbNumberFormat($_SESSION["uid"]);
			break;
		case 2:
			$condition = $condition . " AND (AppStatus != 'Success') AND agent.team_id = ( SELECT team_id FROM t_agents WHERE agent_id = " . dbNumberFormat($_SESSION["uid"]) . ") ";
			break;
		case 0:
			$condition = $condition . "  AND agent.team_id = ( SELECT team_id FROM t_agents WHERE agent_id = " . dbNumberFormat($_SESSION["uid"]) . ") ";
			break;
		case 4:
			$condition = $condition . "  AND agent.group_id = ( SELECT group_id FROM t_agents WHERE agent_id = " . dbNumberFormat($_SESSION["uid"]) . ") ";
			break;
		case 5:
			$condition = $condition . " ";
			break;
		case 3:
			$condition = $condition . " AND (AppStatus != 'Follow Doc') ";
			break;
		case 7:
			$condition = $condition . " AND (AppStatus IN ('Approve','QC_Approved')) ";
			break;
	} //end switch

	/*
			if(  $lv == 1){
			     $condition = $condition."AND app.agent_id =  ".dbNumberFormat($_SESSION["uid"]   );
			 }else if( $l{
 			    //check level

			 		//	$condition = $condition." WHERE AgentID IS NOT NULL";
			 }
			 //check level
  			*/
	if ($tmp['search_cust'] != "") {
		$condition = $condition . " AND ( Firstname LIKE '" . trim($tmp['search_cust']) . "%' OR Lastname LIKE '" . trim($tmp['search_cust']) . "%'  )";
	}
	if ($tmp['search_agent'] != "") {
		$condition = $condition . " AND app.agent_id = " . dbformat($tmp['search_agent']) . " ";
	}
	if ($tmp['search_quono'] != "") {
		$condition = $condition . " AND ProposalNumber LIKE '%" . trim($tmp['search_quono']) . "%' ";
	}
	if ($tmp['search_sts'] != "") {
		$condition = $condition . " AND AppStatus = " . dbformat($tmp['search_sts']) . " ";
	}
	if ($tmp['search_cred'] != "" & $tmp['search_endd'] != "") {
		$condition = $condition . " AND app.create_date BETWEEN '" . $tmp['search_cred'] . " 00:00' AND  '" . $tmp['search_endd'] . " 23:59'";
	}

	$sql = $sql . $condition;
	$sql = $sql . " ORDER BY app.create_date  DESC ";
	//  " LIMIT ".$page." , ".$pagelength;

	wlog('[application-pane_process][query] query : ' . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$custname = $rs['Firstname'] . ' ' . Encryption::decrypt($rs['Lastname']);
		$data[$count] = array(
			"id"  => nullToEmpty($rs['id']),
			"quono"  => nullToEmpty($rs['quotation']),
			"cname"  => nullToEmpty($custname),
			"camp" => nullToEmpty($rs['camp']),
			"camp_id" => nullToEmpty($rs['camp_id']),
			"saledt"  => nullToEmpty($rs['Sale_Date']),
			"appsts"  => nullToEmpty($rs['AppStatus']),
			"owner"  => nullToEmpty($rs['owner']),
			"qc_name"  => nullToEmpty($rs['qc_name']),
			"qa_name"  => nullToEmpty($rs['qa_name'])
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	//count row for paging
	$sql = " SELECT COUNT(id) AS total " .
		" FROM t_aig_app app LEFT OUTER JOIN  t_agents  agent ON app.agent_id = agent.agent_id ";
	//" FROM app a LEFT OUTER JOIN user u ON a.AgentID = u.Id ";
	$sql = $sql . $condition;

	// wlog( $sql );
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$total = nullToZero($rs['total']);
	}

	$data = array("data" => $data, "total" => $total);
	$dbconn->dbClose();
	echo json_encode($data);
}

function detail()
{

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}


	$sql = " SELECT agent_id,first_name,last_name,nickname,mobile_phone ,is_active, a.group_id , a.team_id,email,level_id,agent_login " .
		" FROM t_agents a " .
		" LEFT OUTER JOIN t_group g ON a.group_id = g.group_id " .
		" LEFT OUTER JOIN t_team t ON a.team_id = t.team_id " .
		" WHERE agent_id =  " . dbNumberFormat($_POST['id']) . " ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$data =  array(
			"aid"  => nullToEmpty($rs['agent_id']),
			"fname"  => nullToEmpty($rs['first_name']),
			"lname"  => nullToEmpty($rs['last_name']),
			"nickname"  => nullToEmpty($rs['nickname']),
			"mobilePhone"  => nullToEmpty($rs['mobile_phone']),
			"email"  => nullToEmpty($rs['email']),
			"gid"  => nullToEmpty($rs['group_id']),
			"tid"  => nullToEmpty($rs['team_id']),
			"loginid"  => nullToEmpty($rs['agent_login']),
			"level"  => nullToEmpty($rs['level_id']),
			"accStatus"  => nullToEmpty($rs['is_active']),
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$data = array("data" => $data);

	$dbconn->dbClose();
	echo json_encode($data);
}
//end query detail

function save()
{
	$mysalt = 'dH[vdc]h;18+';
	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = "SELECT agent_id FROM t_agents WHERE agent_id = " . dbNumberFormat($tmp['aid']) . " ";

	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		//update
		$sql = "UPDATE t_agents SET " .
			"first_name =" . dbformat($tmp['fname']) . "," .
			"last_name=" . dbformat($tmp['lname']) . "," .
			"nickname=" . dbformat($tmp['nname']) . "," .
			"mobile_phone=" . dbformat($tmp['mobilephone']) . "," .
			"email=" . dbformat($tmp['email']) . "," .
			"group_id=" . dbformat($tmp['gid']) . "," .
			"team_id=" . dbformat($tmp['tid']) . "," .
			"agent_login=" . dbformat($tmp['loginid']) . ",";
		if ($tmp['passwd'] != "") {
			$sql = $sql . "agent_password=" . dbformat(sha1($tmp['passwd'] . $mysalt)) . ",";
		}
		$sql = $sql . "level_id=" . dbformat($tmp['level']) . "," .
			"is_active=" . dbformat($tmp['accstatus']) . "," .
			"update_date =NOW()," .
			"update_user =" . dbformat($tmp['uid']) . " " .
			"WHERE agent_id = " . dbformat($tmp['aid']) . " ";

		$dbconn->executeUpdate($sql);
	} else {

		//insert
		$sql = " INSERT INTO t_agents( first_name,last_name,nickname,mobile_phone," .
			" email,group_id,team_id,agent_login,agent_password,level_id,is_active,img_path,create_user,create_date ) VALUES ( " .
			" " . dbformat($tmp['fname']) . " " .
			"," . dbformat($tmp['lname']) . " " .
			"," . dbformat($tmp['nname']) . " " .
			"," . dbformat($tmp['mobilephone']) . " " .
			"," . dbformat($tmp['email']) . " " .
			"," . dbNumberFormat($tmp['gid']) . " " .
			"," . dbNumberFormat($tmp['tid']) . " " .
			"," . dbformat($tmp['loginid']) . " " .
			"," . dbformat(sha1($tmp['passwd'] . $mysalt)) . " " .
			/*
				 			    if( $tmp['passwd'] != ""){
				 			         $sql = $sql.",".dbformat(sha1($tmp['passwd'].$mysalt))." ";
						     	}else{
						     		  $sql = $sql.",".dbformat(sha1($tmp['passwd'].$mysalt))." ";

						     	}
				 */
			"," . dbformat($tmp['level']) . " " .
			"," . dbformat($tmp['accstatus']) . " " .
			", 'profiles/agents/no_profile.png' " . //default image profile
			"," . dbNumberFormat($tmp['uid']) . " , NOW() )  ";

		$dbconn->executeUpdate($sql);
	}

	$dbconn->dbClose();
	$res = array("result" => "success");
	echo json_encode($res);
}

function delete()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " DELETE FROM t_agents WHERE agent_id IN (" . dbformat($tmp['aid']) . ") ";
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();

	$res = array("result" => "success");
	echo json_encode($res);
}

function check()
{

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	switch ($_POST['con']) {
		case "empid":
			$sql = "SELECT empid FROM t_agents WHERE empid = " . dbformat($_POST['val']) . " ";
			break;
		case "loginid":
			$sql = "SELECT agent_login FROM t_agents WHERE agent_login = " . dbformat($_POST['val']) . " ";
			break;
	}



	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$res = array("check" => "duplicate");
	} else {
		$res = array("check" => "pass");
	}

	$dbconn->dbClose();
	echo json_encode($res);
	return false;
}

function takeaction()
{
	$action = $_POST['action'];
	switch ($action) {
		case "lock":
			$action = "0";
			break;
		case "unlock":
			$action = "1";
			break;
	}

	$tmp = json_decode(true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " UPDATE t_agents SET is_active=" . dbNumberFormat($action) . " ," .
		" update_date = NOW()," .
		" update_user =" . dbNumberFormat($_POST['uid']) . " " .
		" WHERE agent_id = " . dbNumberFormat($_POST['aid']) . " ";

	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();

	$res = array("result" => "success");
	echo json_encode($res);
}


?>
