<?php
require_once("class/OutboundGenesys.php");
require_once("class/dataTableClass.php");
require_once("dbconn.php");
require_once("util.php");
require_once("wlog.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['action'])) {
	switch ($_POST['action']) {

		case "init":
			init();
			break; //load select campaign

		//may deprecate 
		case "query":
			query_newlist();
			break;
		case "query_dashboard":
			query_dashboard();
			break;
		case "query_newlist":
			query_newlist();
			break;
		case "query_nocontact":
			query_nocontact();
			break;
		case "query_callback":
			query_callback();
			break;
		case "query_followup":
			query_followup();
			break;
		case "query_reconfirm":
			query_reconfirm();
			break;
		case "query_callhistory":
			query_callhistory();
			break;

		//is used
		case "detail":
			detail();
			break;

		case "cmp_initial":
			cmp_initial();
			break;
		case "cmp_joinlog":
			cmp_joinlog();
			break;

		//case "save"    : save(); break;
		//case "delete"  : delete(); break;
		//test only
		//case "save_reminder" : save_reminder(); break;

		//test only
		//start lv1 of wrapup ( should keep to session )
		case "initwrapup":
			init_wrapup();
			break;
		// query other level of wrapup
		case "querywrapup":
			query_wrapup();
			break;
		// save wrapup 
		case "savewrapup":
			save_wrapup();
			break;
		//load popup content
		case "loadpopup_content":
			loadpopup_content();
			break;

		//search calllist
		//case "search_calllist" : search_calllist(); break;
		case "search_calllist":
			query_newlist();
			break;
		case "search_nocontact":
			query_nocontact();
			break;
		//search popup callhistory
		case "search_popupcallhistory":
			search_popupcallhistory();
			break;
		case "save_reminder":
			save_reminder();
			break;

		//genesys integration
		case "geneGetleadfromcontactid":
			geneGetleadfromcontactid();
			break;
		// transfer
		case "geneTransfer":
			geneTransfer();
			break;
		// genesys recording
		case "geneRecording":
			geneRecording();
			break;
		// genesys recording
		case "geneCallLog":
			geneCallLog();
			break;
		// call trans
		case "addCallTrans":
			addCallTrans();
			break;
		// get Queue From Calllist
		case "getQueueFromCalllist":
			getQueueFromCalllist();
			break;
		// active calllist status
		case "activeList":
			activeList();
			break;
		// get Last Wrapup
		case "getLastWrapup":
			getLastWrapup();
			break;
		// update Call Trans
		case "updateCallTrans":
			updateCallTrans();
			break;
		case "queryMultiProductCampaignName":
			queryMultiProductCampaignName();
			break;	
		case "queryCheckAppIdByCalllistId":
			queryCheckAppIdByCalllistId();
			break;	
	}
}

function query_all()
{


}

function save_reminder()
{

	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$dtime = "";
	$id = $tmp['pop_reminderOn'];

	switch ($id) {
		case 1:
			$dtime = "ADDTIME(now(), '00:30:00')";
			break;
		case 2:
			$dtime = "ADDTIME(now(), '00:45:00')";
			break;
		case 3:
			$dtime = "ADDTIME(now(), '01:30:00')";
			break;
		case 4:
			$dtime = "ADDTIME(now(), '01:30:00')";
			break;
		case 5:
			$dtime = "ADDTIME(now(), '02:00:00')";
			break;
		case 6:
			$dtime = "ADDTIME(now(), '03:00:00')";
			break;
		case 7:
			$dtime = "ADDTIME(now(), '05:00:00')";
			break;
		case 8:
			$dtime = "ADDTIME(now(), '08:00:00')";
			break;
		case 9:
			$dtime = "NOW()+INTERVAL 1 DAY";
			break;
		case 10:
			$dtime = "";
			break;
	}

	wlog($dtime);
	//$date = $tmp['reminderDate']."/".$tmp['reminderMonth']."/".$tmp['reminderYear'];

	$sql = "SELECT reminder_id FROM t_reminder WHERE reminder_id = " . dbformat($tmp['pop_reminderid']) . " ";
	wlog("[reminder_process][save] check sql : " . $sql);

	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {

		//update   
		$sql = "UPDATE t_reminder SET " .
			"reminder_dt =" . $dtime . "," .
			"subject =" . dbformat($tmp['pop_reminderSubj']) . "," .
			"detail =" . dbformat($tmp['pop_reminderDesc']) . "," .
			"reminder_type_id =" . dbformat($tmp['pop_reminderType']) . "," .
			"status =" . dbformat($tmp['pop_reminderStatus']) . "," .
			"calllist_id =" . dbformat($tmp['listid']) . "," .
			"update_date =NOW()," .
			"update_user =" . dbformat($tmp['uid']) . " " .
			"WHERE reminder_id = " . dbformat($tmp['pop_reminderid']) . " ";

		wlog("[call-pane_process][save_reminder] update sql : " . $sql);
		$dbconn->executeUpdate($sql);

	} else {
		//insert
		$sql = " INSERT INTO t_reminder( reminder_dt ,reminder_type_id ,subject ,detail , calllist_id , status , create_user, create_date ) VALUES ( " .
			" " . $dtime . " " .
			"," . dbformat($tmp['pop_reminderType']) . " " .
			"," . dbformat($tmp['pop_reminderSubj']) . " " .
			"," . dbformat($tmp['pop_reminderDesc']) . " " .
			"," . dbformat($tmp['listid']) . " " .
			"," . dbformat($tmp['pop_reminderStatus']) . " " .
			"," . dbNumberFormat($tmp['uid']) . " , NOW() )  ";

		wlog("[call-pane_process][save_reminder] insert sql : " . $sql);
		$dbconn->executeUpdate($sql);
	}

	//get current reminderid ( use for update )
	$sql = "SELECT reminder_id FROM t_reminder WHERE calllist_id = " . $tmp['listid'];
	wlog("[call-pane_process][get_current redminderid]  sql : " . $sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$current_reminderid = $rs['reminder_id'];
	}

	//reinitial - reminder alert 
	remineMe($current_reminderid);

	$dbconn->dbClose();
	//$res = array("result"=>"success");
	//echo json_encode($res);   

}

//remineMe();
function remineMe($current_reminderid)
{

	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT reminder_id , reminder_dt " .
		" FROM t_reminder " .
		" WHERE create_user = " . dbNumberFormat($tmp['uid']) . " " .
		" AND status = 1 " .
		" AND reminder_dt >= NOW() " .
		" ORDER BY reminder_dt " .
		" LIMIT 0 , 1 ";



	$reminddt = "";
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$reminddt = $rs['reminder_dt'];
		wlog($reminddt);
		//update current reminder to status 0 for next reminder
		if (isset($_POST['opt'])) {
			if ($_POST['opt'] == "off") {
				$sql = "UPDATE t_reminder SET status = 0 WHERE reminder_id = " . $rs['reminder_id'];
				wlog("reminder update : " . $sql);
				$dbconn->executeUpdate($sql);
			}
		}


		$count++;
	}




	if ($count == 0) {
		$data = array("result" => "empty");
	}

	//echo $reminddt;
	date_default_timezone_set('Asia/Bangkok');

	$datetime1 = new DateTime();
	$datetime2 = new DateTime($reminddt);
	$interval = $datetime1->diff($datetime2);
	$elapsed = $interval->format(' %y years %m months %a days %h hours %i minutes %S seconds');
	//echo $elapsed."<br/>";
	$hour = $interval->format('%h');
	$min = $interval->format('%i');
	$sec = $interval->format('%S');

	$timeinsec = (($hour * 60 * 60) + ($min * 60) + $sec) * 1000;

	//echo $timeinsec * 1000 ;
	wlog("next reminde " . $elapsed);

	$dbconn->dbClose();
	$data = array("result" => "success", "data" => $timeinsec, "remid" => $current_reminderid);
	echo json_encode($data);

}

function search_popupcallhistory()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT create_date FROM t_call_trans t " .
		" WHERE  campaign_id = " . dbNumberFormat($tmp['cmpid']) . " ";
	" AND agent_id = " . dbNumberFormat($tmp['uid']) . " ";


	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		//get dynamic field for query data
		array_push($fields, $rs['field_name']);
		$data[$count] = array(
			"cd" => getDatetimeFromDatetime($rs['create_date']),

		);
		$count++;
	}

	if ($count == 0) {
		$data = array("result" => "empty");
	}


	$dbconn->dbClose();
	echo json_encode($data);

}


function search_calllist()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	/*
			  $sql =  " SELECT fl.field_name ".
							  " FROM t_campaign_field f LEFT OUTER JOIN ts_field_list fl ".
							  " ON f.field_name = fl.field_name ".
							  " WHERE f.campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
						   " AND fl.field_detail = 'name' ";
			  
			   $search = " AND ( ";
			   $result = $dbconn->executeQuery($sql);
			   while($rs=mysqli_fetch_array($result)){
					   $search = $search.$rs['field_name']." LIKE '%".$tmp['newlist_search']."%' OR ";
			   }   
			   $search = substr($search, 0, strripos($search, 'OR'));
			   $search = $search." ) ";
			   
			   wlog("search condition : ".$sql);
			   */

	//normal query 
	$sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  " . dbNumberFormat($tmp['cmpid']) . " " .
		" AND c.show_on_callwork = 1 ";

	wlog("normal query : " . $sql);

	//system field ( customer system provide field )
	$fields = array("a.calllist_id");
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		//get dynamic field for query data
		array_push($fields, $rs['field_name']);
		$tmp0[$count] = array(
			"cn" => nullToEmpty($rs['caption_name']),
			"fn" => nullToEmpty($rs['field_name']),
		);
		$count++;
	}


	//get dynamic field  from db
	$field = implode(",", $fields);

	//query agent call list
	//call list
	$sql = " SELECT " . $field . " " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) . " " .
		" AND campaign_id = " . dbNumberFormat($tmp['cmpid']) . " " .
		" AND a.status = 1 " .
		" AND ( c.first_name  LIKE '%" . $tmp['newlist_search'] . "%' OR c.last_name LIKE '%" . $tmp['newlist_search'] . "%' ) ";


	wlog("query agent call list " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);

	$fieldlength = count($fields);
	while ($rs = mysqli_fetch_row($result)) {
		$a = array();
		for ($i = 0; $i < count($fields); $i++) {
			$a['f' . $i] = nullToEmpty($rs[$i]);
		}
		$tmp3[$count] = $a;
		$count++;
	}

	if ($count == 0) {
		$tmp3 = array("result" => "empty");
	}

	$data = array("result" => "success", "clist" => $tmp3);

	$dbconn->dbClose();
	echo json_encode($data);

}

function loadpopup_content()
{

	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	/*
			 $test = 1;
			 //check calllist current status is a do not call status
			  $sql = " SELECT calllist_id FROM t_calllist WHERE calllist_id = ".dbNumberFormat($tmp['listid'])." AND  status = 3 ";
			$count = 0;    
			$result = $dbconn->executeQuery($sql);
				if($rs=mysqli_fetch_array($result)){   
					$tmp = array("status"=>"dnc");
				}else{
					$tmp = array("status"=>"normal");
				} 	
				*/
	$confirm_id = $_POST['listid'];
	$field = array();
	// profile field data
	/*
				  $sql = " SELECT caption_name , field_name ".
							  " FROM t_campaign_field ".
							  " WHERE campaign_id =   ".dbNumberFormat($tmp['cmpid'])." ".
							  " AND show_on_profile = 1 ";
				  */

	$sql = " SELECT f.caption_name , f.field_name , f.caption_option, s.field_detail  " .
		" FROM t_campaign_field f LEFT OUTER JOIN ts_field_list s " .
		" ON f.field_name = s.field_name " .
		" WHERE campaign_id =   " . dbNumberFormat($tmp['cmpid']) . " " .
		" AND (show_on_profile = 1 OR f.field_name = 'conCallistid')";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	$fields = "";

	while ($rs = mysqli_fetch_array($result)) {
		/*
								  $tmp1[$count] = array(
													"cn"  => nullToEmpty($rs['caption_name']),
												"fn"  => nullToEmpty($rs['field_name']),
										);
										*/
		$count++;

		$fields = $fields . " " . $rs['field_name'] . ",";
		array_push($field, $rs['field_detail'] . "|" . $rs['field_name'] . "|" . $rs['caption_option']);
	}
	//."|".$rs['caption_option']

	// if($count==0){

	//	} 

	$sql = "SELECT " . $fields . " status,conCallistid FROM t_calllist WHERE calllist_id =  " . dbNumberFormat($_POST['listid']) . " "; //$tmp['listid']
	wlog($sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_row($result)) {

		for ($i = 0; $i < count($field); $i++) {

			//wlog( "fetch : ".$field[$i]."|".$rs[$i] );
			$tmp1[$count] = array(
				"key" => nullToEmpty($field[$i]),
				"value" => nullToEmpty($rs[$i]),
			);

			$count++;
		}

		//status field 
		$tmp1[$count] = array(
			"key" => "status|status",
			"value" => nullToEmpty($rs[$count]),
		);
		//confirmid field 
		$count++;
		$confirm_id = (!empty($rs[$count]) && $tmp['cmptype'] == "confirm") ? $rs[$count] : $confirm_id;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	//recently wrapup history
	$sql = " SELECT a.last_wrapup_dt ,  r.reminder_dt  " .
		" FROM t_calllist_agent a LEFT OUTER JOIN t_reminder r ON a.reminder_id = r.reminder_id " .
		" WHERE a.campaign_id = " . dbNumberFormat($tmp['cmpid']) . "  " .
		" AND a.agent_id =  " . dbNumberFormat($tmp['uid']) . "" .
		" AND a.calllist_id = " . dbNumberFormat($_POST['listid']);

	wlog($sql);

	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$tmp2 = array(
			"lastwrapupdt_th" => allthaidatetime($rs['last_wrapup_dt']),
			"lastwrapupdt" => nullToEmpty($rs['last_wrapup_dt']),
			"lastreminderdt_th" => allthaidatetime($rs['reminder_dt']),
			"lastreminderdt" => nullToEmpty($rs['reminder_dt'])
		);
	} else {
		$tmp2 = array("result" => "empty");
	}

	//query wrapup history NO paging 
	/*
				   $sql = " SELECT t.create_date , t.wrapup_id , cdr.billsec , cdr.disposition ".
							   " FROM t_call_trans t LEFT OUTER JOIN cdr cdr ON cdr.uniqueid = t.uniqueid ".
							   " WHERE t.agent_id = ".dbNumberFormat($tmp['uid'])." ".
								 " AND t.campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
							   " AND t.calllist_id = ".dbNumberFormat( $_POST['listid'] ).
							   " ORDER BY t.create_date DESC ";
				   */
	$sql = " SELECT COALESCE(CONVERT_TZ(t.create_date, '+00:00', '+08:00'), '0000-00-00 00:00:00') AS create_date,t.wrapup_id,t.wrapup_note," .
	"(SELECT wrapup_dtl FROM t_wrapup_code WHERE wrapup_code = 
	(
	CASE 
	WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(t.wrapup_id, '|', 3), '|', -1) != '' THEN 
		SUBSTRING_INDEX(SUBSTRING_INDEX(t.wrapup_id, '|', 3), '|', -1)
	WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(t.wrapup_id, '|', 2), '|', -1) != '' THEN 
		SUBSTRING_INDEX(SUBSTRING_INDEX(t.wrapup_id, '|', 2), '|', -1)
	ELSE 
		SUBSTRING_INDEX(t.wrapup_id, '|', 1)
	END
	) )AS wrapup_dtl " .
	" FROM t_call_trans t " .
	" WHERE t.agent_id = " . dbNumberFormat($tmp['uid']) . " " .
	" AND t.campaign_id = " . dbNumberFormat($tmp['cmpid']) . " " .
	" AND t.calllist_id = " . dbNumberFormat($_POST['listid']) .
	" ORDER BY create_date DESC ";

	wlog("[call-pane_process][loadpopup_content] cal history sql : " . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		//wlog("[call-pane_process][loadpopup_content] cal history sql : " . $rs['create_date']);
		$tmp3[$count] = array(
			//"cred" => allthaidatetime_short($rs['create_date']),
			"cred" => nullToEmpty($rs['create_date']),
			"wup" => nullToEmpty($rs['wrapup_dtl']),
			"note" => nullToEmpty($rs['wrapup_note']),
			//"bill" => nullToEmpty($rs['billsec']) ,
			//"disp" => nullToEmpty($rs['disposition']) 
		);
		//wlog("[call-pane_process][loadpopup_content] cal history sql : " . nullToEmpty($rs['create_date']));
		$count++;
	}

	if ($count == 0) {
		$tmp3 = array("result" => "empty");
	}

	//current campaign list name
	$sql = "SELECT external_web_url FROM t_campaign WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']) . " ";
	wlog("[call-pane_process][loadpopup_content] cal external_web_url sql : " . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$tmp4 = nullToEmpty($rs['external_web_url']);
		$count++;
	}

	if ($count == 0) {
		$tmp4 = array("result" => "empty");
	}


	//external app
	$sql = " SELECT ex_app_name , ex_app_url , ex_app_icon " .
		" FROM t_external_app_register " .
		" WHERE campaign_id =  " . dbNumberFormat($tmp['cmpid']) . "  " .
		" AND is_active = 1 ";

	wlog("[call-pane_process][loadexternal_app] sql : " . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp5[$count] = array(
			"appn" => nullToEmpty($rs['ex_app_name']),
			"appu" => nullToEmpty($rs['ex_app_url']),
			"appi" => nullToEmpty($rs['ex_app_icon']),
		);
		$count++;
	}

	if ($count == 0) {
		$tmp5 = array("result" => "empty");
	}

	$sql = "SELECT import_id FROM t_calllist WHERE calllist_id =  " . dbNumberFormat($_POST['listid']) . " ";
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$tmp6 = array(
			"id" => nullToEmpty($rs['import_id'])
		);
		$count++;
	}

	if ($count == 0) {
		$tmp6 = array("result" => "empty");
	}

	$sql = "SELECT id,description FROM t_aig_sg_lov WHERE name='typeOfVoucher'";
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp7[$count] = array(
			"id" => nullToEmpty($rs['id']),
			"value" => nullToEmpty($rs['description']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp7 = array("result" => "empty");
	}

	$sql = "SELECT id,description FROM t_aig_sg_lov WHERE name='voucherValue'";
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp8[$count] = array(
			"id" => nullToEmpty($rs['id']),
			"value" => nullToEmpty($rs['description']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp8 = array("result" => "empty");
	}

	$sql = "SELECT type_of_vouncher,vouncher_value,dont_call_ind,dont_sms_ind,dont_email_ind,dont_mail_ind FROM t_calllist WHERE calllist_id = ".dbNumberFormat($_POST['listid'])."";
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp9[$count] = array(
			"type_of_vouncher" => nullToEmpty($rs['type_of_vouncher']),
			"vouncher_value" => nullToEmpty($rs['vouncher_value']),
			"dont_call_ind" => nullToEmpty($rs['dont_call_ind']),
			"dont_sms_ind" => nullToEmpty($rs['dont_sms_ind']),
			"dont_email_ind" => nullToEmpty($rs['dont_email_ind']),
			"dont_mail_ind" => nullToEmpty($rs['dont_mail_ind']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp9 = array("result" => "empty");
	}

	//campaign data
	if ($confirm_id)
		$data = array("calllist" => $tmp1, "wrapuphist" => $tmp2, "listhist" => $tmp3, "script" => $tmp4, "exapp" => $tmp5, "impid" => $tmp6, "confirm_id" => $confirm_id, "typeOfVoucher" => $tmp7, "voucherValue" => $tmp8, "calllist_data" => $tmp9);


	//$data = array("empty");
	$dbconn->dbClose();
	echo json_encode($data);

}

function init_wrapup()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT wrapup_code , wrapup_dtl " .
		" FROM t_wrapup_code " .
		" WHERE status = 1 " .
		" and parent_code = 0 " .
		" and campaign_id like '%,".dbNumberFormat($tmp['cmpid']).",%' ".
		" ORDER BY seq_no ";

	wlog("[call-pane_process-Wrapup][init] sql :" . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$data[$count] = array(
			"wcode" => nullToEmpty($rs['wrapup_code']),
			"wdtl" => nullToEmpty($rs['wrapup_dtl']),
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);

}

function query_wrapup()
{

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT wrapup_code , wrapup_dtl " .
		" FROM t_wrapup_code " .
		" WHERE status = 1 " .
		" AND parent_code = " . dbNumberFormat($_POST['wrapupcode']) . " " .
		" ORDER BY seq_no ";

	//wlog("[call-pane_process][init] sql :".$sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$data[$count] = array(
			"wcode" => nullToEmpty($rs['wrapup_code']),
			"wdtl" => nullToEmpty($rs['wrapup_dtl']),
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

function getImportID($listid, $dbconn)
{
	$importid = null;
	if ($listid) {
		$sql = "SELECT import_id from t_calllist where calllist_id = {$listid}";
		$result = $dbconn->executeQuery($sql);
		$rs = mysqli_fetch_array($result);
		$importid = $rs['import_id'];
	}
	return $importid;
}

function autoTransfer($listid, $uid, $cmpid, $dbconn)
{
	if ($listid && $uid && $cmpid) {
		$impid = getImportID($listid, $dbconn);
		$sql = "SELECT campaign_id,calllist_id from t_calllist_agent where status=1 and campaign_id = " . dbNumberFormat($cmpid) . " and calllist_id = " . dbNumberFormat($listid);
		$result = $dbconn->executeQuery($sql);
		$rs = mysqli_fetch_array($result);
		if (!$rs) {
			$uniqid = uniqid();
			//log transfer
			$sql = " INSERT INTO t_calllist_transfer_history ( unique_id , calllist_id , transfer_from_id , transfer_to_id , transfer_by_id , transfer_date , " .
				" transfer_type , transfer_type_dtl , transfer_on_status , transfer_on_status_dtl , " .
				" transfer_cmpid , transfer_import_id ) VALUES (  " .
				" " . dbformat($uniqid) . "," .
				" " . dbNumberFormat($listid) . "," .
				"  null ," .
				" " . dbNumberFormat($uid) . "," . //transfer_to_id
				" " . dbNumberFormat(99999) . "," . //transfer_by_id
				" NOW() , " .
				"  1 , " . //transfer type
				" 'transfer' , " . // transfer type_dtl
				" 1 , " . // transfer on status
				" 'newlist', " . //transfer on status dtl
				" " . dbNumberFormat($cmpid) . ", " . //transfer campaign id
				" " . dbNumberFormat($impid) . " ) "; //transfer  import id 

			//wlog( "[distribute_process][save] LOG TRANSFER sql : ".$sql  );
			$dbconn->executeUpdate($sql);
			wlog("[call-pane_process][bypass_assign] log transfer : " . $sql);
			$sql = "INSERT INTO t_calllist_agent ( campaign_id , import_id , agent_id , calllist_id ,  status , assign_dt , assign_id  ) VALUES ( " .
				" " . dbNumberFormat($cmpid) . ", " .
				" " . dbNumberFormat($impid) . ", " .
				" " . dbNumberFormat($uid) . ", " .
				" " . dbNumberFormat($listid) . ", " .
				" 1 ,  NOW() , " .
				" " . dbNumberFormat(99999) . " ) ";
			$dbconn->executeUpdate($sql);
			wlog("[call-pane_process][bypass_assign] transfer : " . $sql);
			//insert transection log to sumary table
			$sql = " INSERT INTO t_calllist_transfer   (transfer_from_id , transfer_to_id , transfer_total ,transfer_date " .
				" ,transfer_type , transfer_type_dtl , transfer_on_status , transfer_on_status_dtl , transfer_cmpid ,transfer_import_id ) " .
				" SELECT transfer_from_id , transfer_to_id , COUNT(calllist_id) AS transfer_total  " .
				" ,max( transfer_date ) as transfer_date " .
				" ,transfer_type , transfer_type_dtl , transfer_on_status , transfer_on_status_dtl , transfer_cmpid ,transfer_import_id " .
				" FROM t_calllist_transfer_history " .
				" WHERE unique_id = " . dbformat($uniqid) . " " .
				" GROUP BY  transfer_from_id , transfer_to_id ,transfer_type , transfer_type_dtl , transfer_on_status , transfer_on_status_dtl , transfer_cmpid ,transfer_import_id " .
				" ORDER BY transfer_to_id,transfer_import_id ";

			wlog("[call-pane_process][bypass_assign] summary log : " . $sql);
			$dbconn->executeUpdate($sql);

		} else {
			$sql = " UPDATE t_calllist_agent SET " .
				" agent_id = " . dbNumberFormat($uid) .
				" WHERE campaign_id =  " . dbNumberFormat($cmpid) . " " .
				" AND calllist_id = " . dbNumberFormat($listid);
			wlog("[call-pane_process][bypass_save_wrapup] update last wrapup : " . $sql);
			$dbconn->executeUpdate($sql);
		}
	}
}

function save_wrapup()
{

	$tmp = json_decode($_POST['data'], true);

	wlog("[call-pane_process][save_wrapup] : queueid = " . $tmp['queueid'] . ", queuecallbackid = " . $tmp['queuecallbackid']);

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	$option = null;
	
	//integration genesys
	$lastwrapup = null;
	$genesys_wrapup = null;
	$convsersationId = ($tmp['voiceid']) ? $tmp['voiceid'] : $tmp['lastInteraction'];
	$queueid = $tmp['queueid'];
	$queuecallbackid = $tmp['queuecallbackid'];
	$listid = $tmp['listid'];
	$genesysUID = $tmp['genesysid'];
	$callbackNumbers = $tmp['callbackNumbers'];
	$schedule_tile = (trim($tmp['schedule_time']) != "") ? date(DATE_ISO8601, strtotime($tmp['schedule_time'])) : "";
	try{
		$gene = new OutboundGenesys();
		$participants = $gene->getPaticipants($convsersationId);
	}
	catch(Exception $e){
		wlog("[call-pane_process][save_wrapup] OutboundGenesys error : " . $e);
	}
	if ($tmp['wrapup3']) {
		$lastwrapup = $tmp['wrapup3'];
	} else if ($tmp['wrapup2']) {
		$lastwrapup = $tmp['wrapup2'];
	} else if ($tmp['wrapup1']) {
		$lastwrapup = $tmp['wrapup1'];
	}
	// $sql = "SELECT genesys_wrapup_id  FROM t_wrapup_code WHERE wrapup_code = ".dbNumberFormat($lastwrapup);
	// $result = $dbconn->executeQuery($sql); 
	// if($rs=mysqli_fetch_array($result)){   
	// 	$genesys_wrapup = (!empty($rs['genesys_wrapup_id']))?$rs['genesys_wrapup_id']:null; 
	// }
	//auto transfer lead from genesys

	autoTransfer($listid, $tmp['uid'], $tmp['cmpid'], $dbconn);

	//check remove call list  from worklist or not, and option
	$sql = "SELECT remove_list, option_id, genesys_wrapup_id FROM t_wrapup_code WHERE wrapup_code = " . dbNumberFormat($lastwrapup) . "  ";
	wlog("[call-pane_process][save_wrapup] check remove list from working list sql : " . $sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$option = $rs['option_id'];
		$genesys_wrapup = (!empty($rs['genesys_wrapup_id'])) ? $rs['genesys_wrapup_id'] : null;
		if ($rs['remove_list'] == 1) {
			$sql = " UPDATE t_calllist_agent SET status = 0 WHERE calllist_id = " . dbNumberFormat($listid) . "  " .
				" AND campaign_id =  " . dbNumberFormat($tmp['cmpid']) . " " .
				" AND calllist_id = " . dbNumberFormat($listid) . " " .
				" AND agent_id = " . dbNumberFormat($tmp['uid']) . " ";
			wlog("[call-pane_process][save_wrapup] update list from working list  sql : " . $sql);
			$dbconn->executeUpdate($sql);
		}
	}

	//check wrapup option 
	// $option = null;
	// $sql = "SELECT option_id  FROM t_wrapup_code WHERE wrapup_code = ".dbNumberFormat($tmp['wrapup1'])."  ";
	// $result = $dbconn->executeQuery($sql); 
	// if($rs=mysqli_fetch_array($result)){   
	// 	$option = $rs['option_id']; 
	// }

	$wrapupid = nullToEmpty($tmp['wrapup1']) . "|" . nullToEmpty($tmp['wrapup2']) . "|" . nullToEmpty($tmp['wrapup3']);

	$currentInteraction = ($tmp['currentInteraction']) ? $tmp['currentInteraction'] : $convsersationId;

	$import_id = "";
	$sql = "SELECT import_id FROM t_calllist WHERE calllist_id = ".dbNumberFormat($listid)." LIMIT 1;";
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$import_id = $rs['import_id'];
	}
	$import_query = "";
	if($import_id != ""){
		$import_query = " import_id =" . dbformat($import_id) . ",";
	}

	$sql = "UPDATE t_call_trans SET " . $import_query .
	" wrapup_id =" . dbformat($wrapupid) . "," .
	" wrapup_note =" . dbformat($tmp['wrapupdtl']) . "," .
	" wrapup_option_id =" . dbNumberFormat($option) . "," .
	" update_date =NOW() " .
	" WHERE voice_id =  " . dbformat($currentInteraction);
	wlog("[call-pane_process][save_wrapup] update current call transaction sql :" . $sql);
	$dbconn->executeUpdate($sql);

	//check if uniqueid is the same  update
	//prevent change wrapup and save again
	if (isset($_POST['uniq'])) {

		$uniq = $_POST['uniq'];
		$sql = "SELECT uniqueid FROM t_call_trans WHERE uniqueid = " . dbformat($uniq);
		wlog("[call-pane_process][save_wrapup] select unique id sql :" . $sql);

		$result = $dbconn->executeQuery($sql);
		if ($rs = mysqli_fetch_array($result)) {
			
			//update calllist last wrapup ( no + number of call )
			$sql = " UPDATE t_calllist_agent SET " . $import_query .
				" last_wrapup_id = " . dbformat($wrapupid) . "," .
				" last_wrapup_detail = " . dbformat($tmp['wrapupdtl']) . "," .
				" last_wrapup_option_id = " . dbNumberFormat($option) . "," .
				" last_wrapup_dt = NOW() ," .
				" WHERE campaign_id =  " . dbNumberFormat($tmp['cmpid']) . " " .
				" AND calllist_id = " . dbNumberFormat($listid) . " " .
				" AND agent_id = " . dbNumberFormat($tmp['uid']) . " ";

			wlog("[call-pane_process][save_wrapup] update last wrapup : " . $sql);
			$dbconn->executeUpdate($sql);

		} else {
			//insert call transaction
			/*
			$sql = " INSERT INTO t_call_trans ( number_of_call , campaign_id , import_id , calllist_id , agent_id , uniqueid , wrapup_option_id , wrapup_id , wrapup_note, voice_id , create_date ) VALUES ( (SELECT " .
				" MAX(number_of_call) FROM t_calllist_agent WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']) . " " .
				" AND calllist_id = " . dbNumberFormat($listid) . " " .
				" AND agent_id = " . dbNumberFormat($tmp['uid']) . ") " .
				", " . dbNumberFormat($tmp['cmpid']) . " " .
				"," . dbNumberFormat($_POST['impid']) . " " . // add import id
				"," . dbNumberFormat($listid) . " " .
				"," . dbNumberFormat($tmp['uid']) . " " .
				"," . dbformat($_POST['uniq']) . " " .
				"," . dbNumberFormat($option) . " " .
				"," . dbformat($wrapupid) . " " .
				"," . dbformat($tmp['wrapupdtl']) . " " .
				"," . dbformat($convsersationId) . ", NOW() )";


			wlog("[call-pane_process][save_wrapup] insert call transaction sql :" . $sql);
			$dbconn->executeUpdate($sql);
			*/

			$sql = " UPDATE t_calllist_agent SET " . $import_query .
				" last_wrapup_id = " . dbformat($wrapupid) . "," .
				" last_wrapup_detail = " . dbformat($tmp['wrapupdtl']) . "," .
				" last_wrapup_option_id = " . dbNumberFormat($option) . "," .
				" last_wrapup_dt = NOW() ," .
				" number_of_call = number_of_call + 1" .
				" WHERE campaign_id =  " . dbNumberFormat($tmp['cmpid']) . " " .
				" AND calllist_id = " . dbNumberFormat($listid) . " " .
				" AND agent_id = " . dbNumberFormat($tmp['uid']) . " ";

			wlog("[call-pane_process][save_wrapup] update last wrapup : " . $sql);
			$dbconn->executeUpdate($sql);

		}
		//update wrapupcode genesys
		if ($genesys_wrapup) {
			foreach ($participants as $participant) {
				$tmp_val = (object) [
					"wrapup" => (object) [
						"code" => $genesys_wrapup
					]
				];
				$gene->patchParticipants($convsersationId, $participant, $tmp_val);
			}
			if ($callbackNumbers && $schedule_tile) {
				if($queuecallbackid == ""){
					$sql = "SELECT genesys_callback_queueid FROM t_campaign WHERE campaign_id = ".dbNumberFormat($tmp['cmpid']);
					wlog("[call-pane_process][save_wrapup] get callback queueid : " . $sql);
					$result = $dbconn->executeQuery($sql);
					if ($rs = mysqli_fetch_array($result)) {
						$queuecallbackid = $rs['genesys_callback_queueid'];
					}
				}
				$tmp_val = (object) [
					// "queueId"=> $queueid,
					"callbackNumbers" => [
						//"+66" . substr($callbackNumbers, 1, strlen($callbackNumbers) - 1)
						"+65".$callbackNumbers
					],
					"routingData" => (object) [
						//"queueId" => "99b42124-be5f-4c54-a424-caa0571e06d1",
						"queueId" => $queuecallbackid,
						// "preferredAgentIds" => [
						// 	$genesysUID
						// ],
						"scoredAgents" => [
							(object) [
								"agent" => (object) [
									"id" => $genesysUID
								],
								"score" => 100
							]
						],
						"routingFlags" => [
							"AGENT_OWNED_CALLBACK"
						]
					],
					"callbackScheduledTime" => $schedule_tile,
					"data" => (object) [
						"PT_SearchValue" => $listid
					]
				];
				$gene->postCallbacks_new($tmp_val);
			}
		}

	}

	//check campaign condition if  max trying call != 0 and over limit 
	//remove from list too
	$sql = " UPDATE t_calllist_agent a " .
		" , t_campaign b " .
		" SET a.status = 0 " .
		" WHERE a.campaign_id = b.campaign_id " .
		" and ifnull(b.maximum_call,0) > 0 " .
		" and a.number_of_call >= ifnull(b.maximum_call,0) " .
		" and a.campaign_id =  " . dbNumberFormat($tmp['cmpid']) . " " .
		" AND a.calllist_id = " . dbNumberFormat($tmp['listid']) . " " .
		" AND a.agent_id = " . dbNumberFormat($tmp['uid']) . " ";

	wlog("[call-pane_process][save_wrapup] update last wrapup : " . $sql);
	$dbconn->executeUpdate($sql);

	//Update calllist data
	$sql = " UPDATE t_calllist SET ".
		" type_of_vouncher = ".dbformat($tmp['typeOfVoucher'])." ".
		" ,vouncher_value = ".dbformat($tmp['voucherValue'])." ".
		" ,dont_call_ind = ".dbformat($tmp['Dont_call_ind'])." ".
		" ,dont_sms_ind = ".dbformat($tmp['Dont_SMS_ind'])." ".
		" ,dont_email_ind = ".dbformat($tmp['Dont_email_ind'])." ".
		" ,dont_mail_ind = ".dbformat($tmp['Dont_Mail_ind'])." ".
		" WHERE calllist_id = ".dbNumberFormat($tmp['listid'])." ";
	wlog("[call-pane_process][save_wrapup] update calllist data : " . $sql);
	$dbconn->executeUpdate($sql);

	//Update Expire Date
	$sql = " CALL sp_update_expire_day_from_wrapup ($lastwrapup,".dbNumberFormat($tmp['listid']).")";
	wlog("[call-pane_process][save_wrapup] update expire date : " . $sql);
	$dbconn->executeUpdate($sql);


	/*
				   //insert call transaction
				   $sql = " INSERT INTO t_call_trans  ( campaign_id , calllist_id , agent_id ,  uniqueid , wrapup_option_id , wrapup_id , wrapup_note ,  create_date ) VALUES (".
								  " ".dbNumberFormat( $tmp['cmpid'])." ".
							   ",".dbNumberFormat( $tmp['listid'])." ".
									 ",".dbNumberFormat( $tmp['uid'])." ".
									  ",".dbformat( $_POST['uniq'] )." ".
									 ",".dbNumberFormat( $option )." ".
								  ",".dbformat( $wrapupid )." ".
								  ",".dbformat( $tmp['wrapupdtl'])." , NOW() )  ";
				   
					wlog("[call-pane_process][save_wrapup] insert call transaction : ".$sql);
					$dbconn->executeUpdate($sql); 
					*/

	//update calllist last wrapup
	/*
					  $sql = " UPDATE t_calllist_agent SET ".
									" last_wrapup_id = ".dbformat($wrapupid).",".
									" last_wrapup_detail = ".dbformat($tmp['wrapupdtl']).",".
									 " last_wrapup_option_id = ".dbNumberFormat( $option ).",".
										" last_wrapup_dt = NOW() ,".
									 " number_of_call = number_of_call + 1".
									 " WHERE campaign_id =  ".dbNumberFormat( $tmp['cmpid'])." ".
									 " AND calllist_id = ".dbNumberFormat( $tmp['listid'])." ".
									 " AND agent_id = ".dbNumberFormat( $tmp['uid'])." ";
					  
					   wlog("[call-pane_process][save_wrapup] update last wrapup : ".$sql);
					   $dbconn->executeUpdate($sql); 
					*/
	$dbconn->dbClose();
	$res = array("result" => "success");
	echo json_encode($res);
	wrapupCallStatus(dbNumberFormat($tmp['cmpid']),$listid,dbNumberFormat($tmp['uid']),$lastwrapup);
	geneRemoveQueue($listid, dbNumberFormat($tmp['uid']));
}

//show campaign for agent
function init()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}


	$sql = " SELECT COUNT(calllist_id) AS total , j.agent_id , c.campaign_id , c.campaign_name , c.campaign_detail, c.genesys_queueid, genesys_callback_queueid, c.campaign_type , last_join_date  " .
		" , COUNT( a.CNT_NEW_LIST ) AS TOT_NEW_LIST " .
		" , COUNT( a.CNT_NOCONTACT ) AS TOT_NOCONTACT " .
		" , COUNT( a.CNT_CALLBACK ) AS TOT_CALLBACK " .
		" , COUNT( a.CNT_FOLLOWUP ) AS TOT_FOLLOWUP " .
		" FROM " .
		" t_campaign c " .
		" left outer join ( " .
		" SELECT calllist_id , agent_id , campaign_id " .
		" ,CASE WHEN last_wrapup_option_id IS NULL THEN calllist_id END AS CNT_NEW_LIST " .
		" ,CASE WHEN last_wrapup_option_id = 1   THEN calllist_id END AS CNT_CALLBACK " .
		" ,CASE WHEN last_wrapup_option_id  IN ( 2,9 ) THEN calllist_id END AS CNT_FOLLOWUP " .
		" ,CASE WHEN last_wrapup_option_id = 8 THEN calllist_id END AS CNT_NOCONTACT " .
		" FROM t_calllist_agent " .
		" WHERE agent_id = '".dbNumberFormat($tmp['uid'])."'".
		" AND status = 1 ) a  on ( c.campaign_id = a.campaign_id )" .
		" left outer JOIN (SELECT agent_id,campaign_id,last_join_date FROM t_agent_join_campaign WHERE agent_id='".dbNumberFormat($tmp['uid'])."') j on ( c.campaign_id = j.campaign_id ) " .
		" WHERE c.status=2 " .
		" GROUP BY j.agent_id , c.campaign_id , c.campaign_name , c.campaign_detail , last_join_date";

	wlog("[call-pane_process][init] sql :" . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$total = nullToZero($rs['TOT_NEW_LIST']) + nullToZero($rs['TOT_NOCONTACT']) + nullToZero($rs['TOT_FOLLOWUP']) + nullToZero($rs['TOT_CALLBACK']);
		$data[$count] = array(
			"cmpid" => nullToEmpty($rs['campaign_id']),
			"cmpName" => nullToEmpty($rs['campaign_name']),
			"cmpDetail" => nullToEmpty($rs['campaign_detail']),
			"cmpGeneQueue" => nullToEmpty($rs['genesys_queueid']),
			"cmpGeneCallbackQueue" => nullToEmpty($rs['genesys_callback_queueid']),
			"cmpType" => nullToEmpty($rs['campaign_type']),
			"total" => nullToZero($total),
			"nlist" => nullToZero($rs['TOT_NEW_LIST']),
			"ncont" => nullToZero($rs['TOT_NOCONTACT']),
			"clsit" => nullToZero($rs['TOT_CALLBACK']),
			"flist" => nullToZero($rs['TOT_FOLLOWUP']),
			"jdate" => getDatetimeFromDatetime($rs['last_join_date']),
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);

}

function cmp_joinlog()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//insert agent join campaign log time
	$sql = " SELECT agent_id  FROM t_agent_join_campaign " .
		" WHERE agent_id = " . dbNumberFormat($tmp['uid']) . " " .
		" AND campaign_id =  " . dbNumberFormat($_POST['cmpid']) . " ";

	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$sql = "UPDATE t_agent_join_campaign SET " .
			" last_join_date = NOW() " .
			" WHERE agent_id = " . dbNumberFormat($tmp['uid']) . " " .
			" AND campaign_id =  " . dbNumberFormat($_POST['cmpid']) . " ";
		$dbconn->executeUpdate($sql);
	} else {
		$sql = "INSERT INTO t_agent_join_campaign (  last_join_date  , agent_id , campaign_id ) VALUES (" .
			" NOW() , " .
			" " . dbNumberFormat($tmp['uid']) . ", " .
			" " . dbNumberFormat($_POST['cmpid']) . "  ) ";
		$dbconn->executeUpdate($sql);
	}

	$dbconn->dbClose();
	$data = array("result" => "success");

	echo json_encode($data);


}

function cmp_initial()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	//initial campaign dynamic from setting
	//init data ( show field in profile );
	$sql = " SELECT caption_name , field_name " .
		" FROM t_campaign_field " .
		" WHERE campaign_id =   " . dbNumberFormat($_POST['cmpid']) . " " .
		" AND show_on_profile = 1 " .
		" ORDER BY seq ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1[$count] = array(
			"cn" => nullToEmpty($rs['caption_name']),
			"fn" => nullToEmpty($rs['field_name']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	//prepare campaign action 
		$sql = " SELECT campaign_name ,campaign_code, campaign_detail ,is_multiproduct,multiproduct_udf_field, external_web_url , script_detail, campaign_type, genesys_queueid, genesys_callback_queueid " .
		" FROM t_campaign c " .
		" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id " .
		" WHERE c.campaign_id =  " . dbNumberFormat($_POST['cmpid']) . " ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {

	$tmp2 = array(
			"cmpName" => nullToEmpty($rs['campaign_name']),
			"cmpDetail" => nullToEmpty($rs['campaign_detail']),
			"cmpCode" => nullToEmpty($rs['campaign_code']),
			"cmpisMultiProduct" => nullToEmpty($rs['is_multiproduct']),
			"cmpisMultiProduct_udf_field" => nullToEmpty($rs['multiproduct_udf_field']),
			"cmpType" => nullToEmpty($rs['campaign_type']),
			"geneQueueid" => nullToEmpty($rs['genesys_queueid']),
			"exturl" => nullToEmpty($rs['external_web_url']),
			"saleScript" => nullToEmpty($rs['script_detail']),
			"geneCallbackQueueid" => nullToEmpty($rs['genesys_callback_queueid']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp2 = array("result" => "empty");
	}
	$dt = new DataTable();
	$dt->setcampid($_POST['cmpid']);
	$dt->setuid($tmp['uid']);
	$tmp3 = $dt->getColumn();
	$dt->settabindex(2);
	$tmp4 = $dt->getColumn();
	$dt->settabindex(99);
	$tmp5 = $dt->getColumn();
	$data = array("pfield" => $tmp1, "cmp" => $tmp2, "cfield" => $tmp3, "cfield2" => $tmp4, "cfield3" => $tmp5);
	$dbconn->dbClose();
	echo json_encode($data);
}

//count newlist , no contact , call back , follow up to dashboard
function query_dashboard()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT COUNT(a.calllist_id) AS total " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) .
		" AND a.status = 1 " .
		" AND campaign_id = " . dbNumberFormat($_POST['cmpid']) .
		" AND a.last_wrapup_option_id IS NULL ";

	wlog("[call-pane_process][query_dashboard] NEW LIST sql  : " . $sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$total_newlist = nullToZero($rs['total']);
	}

	$sql = " SELECT COUNT(a.calllist_id) AS total " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) . " " .
		" AND campaign_id = " . dbNumberFormat($_POST['cmpid']) . " " .
		" AND a.status = 1 " .
		" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 2 ) "; //no contact is tab_id = 2 in ts config

	wlog("[call-pane_process][query_dashboard] NO CONTACT LIST sql  : " . $sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$total_nocontact = nullToZero($rs['total']);
	}

	//count  call back
	$sql = " SELECT COUNT(a.calllist_id) AS total " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) .
		" AND campaign_id = " . dbNumberFormat($_POST['cmpid']) .
		" AND a.status = 1 " .
		" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 3 ) "; //call back is tab_id = 3 in ts config
	wlog("[call-pane_process][query_dashboard] CALL BACK LIST sql  : " . $sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$total_callback = nullToZero($rs['total']);
	}
	//count followup
	$sql = " SELECT COUNT(a.calllist_id) AS total " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) .
		" AND campaign_id = " . dbNumberFormat($_POST['cmpid']) .
		" AND a.status = 1 " .
		" AND last_wrapup_option_id IN ( SELECT option_id FROM ts_call_tab_wrapup WHERE tab_id = 4 ) "; //followup  is tab_id = 4 in ts config
	wlog("[call-pane_process][query_dashboard] FOLLOWUP LIST sql  : " . $sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$total_followup = nullToZero($rs['total']);
	}

	$data = array("tnewlist" => $total_newlist, "tnocont" => $total_nocontact, "tcallback" => $total_callback, "tfollowup" => $total_followup);

	$dbconn->dbClose();
	echo json_encode($data);


}

//query new call list
function query_newlist()
{
	$tmp = json_decode($_POST['data'], true);
	$dt = new DataTable();
	$dt->setcampid($tmp['cmpid']);
	$dt->setuid($tmp['uid']);
	echo $dt->getDetail($_POST);
}

//no contact list
function query_nocontact()
{

	$tmp = json_decode($_POST['data'], true);
	$dt = new DataTable();
	$dt->setcampid($tmp['cmpid']);
	$dt->setuid($tmp['uid']);
	$dt->settabindex($_POST['tabindex']);
	echo $dt->getDetail($_POST);

}


//call back list
function query_callback()
{
	$tmp = json_decode($_POST['data'], true);
	$dt = new DataTable();
	$dt->setcampid($tmp['cmpid']);
	$dt->setuid($tmp['uid']);
	$dt->settabindex($_POST['tabindex']);
	echo $dt->getDetail($_POST);

}

//no contact list
function query_followup()
{
	$tmp = json_decode($_POST['data'], true);
	$dt = new DataTable();
	$dt->setcampid($tmp['cmpid']);
	$dt->setuid($tmp['uid']);
	$dt->settabindex($_POST['tabindex']);
	echo $dt->getDetail($_POST);

}

function query_reconfirm()
{

	$tmp = json_decode($_POST['data'], true);
	$dt = new DataTable();
	$dt->setcampid($tmp['cmpid']);
	$dt->setuid($tmp['uid']);
	$dt->settabindex($_POST['tabindex']);
	echo $dt->getDetail($_POST);

}

function query_callhistory()
{
	$tmp = json_decode($_POST['data'], true);
	$dt = new DataTable();
	$dt->setcampid($tmp['cmpid']);
	$dt->setuid($tmp['uid']);
	$dt->settabindex($_POST['tabindex']);
	echo $dt->getDetail($_POST);
}

//query call list for agent
function query()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	/*
			 //insert agent join campaign 
			 $sql = " SELECT agent_id  FROM t_agent_join_campaign ".
						  " WHERE agent_id = ".dbNumberFormat($tmp['uid']). " ".
						 " AND campaign_id =  ".dbNumberFormat($tmp['cmpid'])." ";
			 
			$result = $dbconn->executeQuery($sql);
			if($rs=mysqli_fetch_array($result)){
						$sql = "UPDATE t_agent_join_campaign SET ".
									" last_join_date = NOW() ".
									" WHERE agent_id = ".dbNumberFormat($tmp['uid']). " ".
									 " AND campaign_id =  ".dbNumberFormat($tmp['cmpid'])." ";
						 $dbconn->executeUpdate($sql);
			}else{
						$sql = "INSERT INTO t_agent_join_campaign (  last_join_date  , agent_id , campaign_id ) VALUES (".
									" NOW() , ".
									" ".dbNumberFormat($tmp['uid']). ", ".
									 " ".dbNumberFormat($tmp['cmpid'])."  ) ";
						 $dbconn->executeUpdate($sql);
			}
			 */

	//campaign detail
	//init data ( show field in call work );

	$sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  " . dbNumberFormat($_POST['cmpid']) . " " .
		" AND c.show_on_callwork = 1 ";

	//system field ( customer system provide field )
	$fields = array("a.calllist_id");
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		//get dynamic field for query data
		array_push($fields, $rs['field_name']);
		$tmp0[$count] = array(
			"cn" => nullToEmpty($rs['caption_name']),
			"fn" => nullToEmpty($rs['field_name']),
		);
		$count++;
	}

	//debug fields
	/*
				   for( $i=0;$i< count($fields); $i++){
				   wlog( $fields[$i]);
				   }
				   */

	//system field ( customer system provide field )
	//array_push( $fields , "a.number_of_call"); 

	if ($count == 0) {
		$tmp0 = array("result" => "empty");
	}

	//init data ( show field in profile );
	$sql = " SELECT caption_name , field_name " .
		" FROM t_campaign_field " .
		" WHERE campaign_id =   " . dbNumberFormat($_POST['cmpid']) . " " .
		" AND show_on_profile = 1 ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1[$count] = array(
			"cn" => nullToEmpty($rs['caption_name']),
			"fn" => nullToEmpty($rs['field_name']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	//prepare campaign action 
	$sql = " SELECT campaign_name , campaign_detail , external_web_url , script_detail " .
		" FROM t_campaign c " .
		" LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id " .
		" WHERE c.campaign_id =  " . dbNumberFormat($_POST['cmpid']) . " ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {

		$tmp2 = array(
			"cmpName" => nullToEmpty($rs['campaign_name']),
			"cmpDetail" => nullToEmpty($rs['campaign_detail']),
			"exturl" => nullToEmpty($rs['external_web_url']),
			"saleScript" => nullToEmpty($rs['script_detail']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp2 = array("result" => "empty");
	}

	//add system field for query value 
	//array_push( $fields , "a.calllist_id");

	//get dynamic field  from db
	$field = implode(",", $fields);


	//calculate call list paging
	$page = 0;
	if (isset($_POST['calllistpage'])) {
		$pagelength = 5;
		$page = (intval($_POST['calllistpage']) - 1) * $pagelength;
	}

	//query agent call list
	//call list
	$sql = " SELECT " . $field . " " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) . " " .
		" AND campaign_id = " . dbNumberFormat($_POST['cmpid']) . " " .
		" AND a.status = 1 " .
		" LIMIT " . $page . " , 5 ";

	wlog("query agent call list " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);

	$fieldlength = count($fields);
	while ($rs = mysqli_fetch_row($result)) {
		$a = array();
		for ($i = 0; $i < $fieldlength; $i++) {
			$a['f' . $i] = nullToEmpty($rs[$i]);
		}
		$tmp3[$count] = $a;
		$count++;
	}

	if ($count == 0) {
		$tmp3 = array("result" => "empty");
	}

	//count total calllist for paging
	$sql = " SELECT COUNT(*) AS totallist " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) . " " .
		" AND campaign_id = " . dbNumberFormat($_POST['cmpid']) . " " .
		" AND a.status = 1 ";
	$totallist = 0;
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$totallist = $rs['totallist'];
	}



	// callback list

	//callback system field
	array_push($fields, "a.last_wrapup_id", "a.last_wrapup_detail", "a.number_of_call", "a.last_wrapup_dt");
	$field = implode(",", $fields);

	$sql = " SELECT " . $field . " " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) . " " .
		" AND campaign_id = " . dbNumberFormat($_POST['cmpid']) . " " .
		" AND a.status = 1 " .
		" AND last_wrapup_option_id = 1 ";

	// callback list
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	$dt_field = count($fields) - 1;
	$wrapup_field = count($fields) - 4;
	while ($rs = mysqli_fetch_row($result)) {
		$a = array();
		$size = count($fields);
		for ($i = 0; $i < $size; $i++) {
			// change format for datetime field
			if ($i == $dt_field) {
				$a['f' . $i] = getDatetimeFromDatetime($rs[$i]);
			} else if ($i == $wrapup_field) {
				$a['f' . $i] = nullToEmpty(wrapupdtl($rs[$i]));
			} else {
				$a['f' . $i] = nullToEmpty($rs[$i]);
			}

			/*
											 if( $i== $dt_field){
												 $a['f'.$i] = getDatetimeFromDatetime($rs[$i]);
											 }else{
												 $a['f'.$i] = nullToEmpty($rs[$i]);
											 }
											 */
		}
		$tmp4[$count] = $a;
		$count++;

	}

	if ($count == 0) {
		$tmp4 = array("result" => "empty");
	}

	//followup list ;
	$sql = " SELECT " . $field . " " .
		" FROM t_calllist_agent a " .
		" LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id " .
		" WHERE a.agent_id = " . dbNumberFormat($tmp['uid']) . " " .
		" AND campaign_id = " . dbNumberFormat($_POST['cmpid']) . " " .
		" AND a.status = 1 " .
		" AND last_wrapup_option_id = 2 ";
	/*
					  $sql = " SELECT a.calllist_id , c.first_name , c.last_name , c.tel1 , c.tel2 ".
							  " FROM t_calllist_agent a ". 
							  " LEFT OUTER JOIN t_calllist c ON a.calllist_id = c.calllist_id ".
							  " WHERE a.agent_id = ".dbNumberFormat($tmp['uid'])." ".
								" AND campaign_id = ".dbNumberFormat($tmp['cmpid'])." ".
							  " AND last_wrapup_option_id = 2 ";
					*/

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$a = array();
		$size = count($fields);
		for ($i = 0; $i < $size; $i++) {
			// change format for datetime field
			if ($i == $dt_field) {
				$a['f' . $i] = getDatetimeFromDatetime($rs[$i]);
			} else if ($i == $wrapup_field) {
				$a['f' . $i] = nullToEmpty(wrapupdtl($rs[$i]));
			} else {
				$a['f' . $i] = nullToEmpty($rs[$i]);
			}
		}
		$tmp5[$count] = $a;
		$count++;
		/*
							   $tmp5[$count] = array(
												 "f0"  => nullToEmpty($rs['calllist_id']),
											 "f1"  => nullToEmpty($rs['first_name']),
											 "f2"  => nullToEmpty($rs['last_name']),
											 "f3"  => nullToEmpty($rs['tel1']),
											 "f4"  => nullToEmpty($rs['tel2'])						  	 
									 );   
							 $count++;  
							 */
	}
	if ($count == 0) {
		$tmp5 = array("result" => "empty");
	}


	//call history list  ( in this campaign );
	$sql = " SELECT t.call_id,c.first_name,c.last_name,t.wrapup_id,t.wrapup_note,t.create_date, " .
			"(SELECT wrapup_dtl FROM t_wrapup_code WHERE wrapup_code = 
			(
			CASE 
			WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(t.wrapup_id, '|', 3), '|', -1) != '' THEN 
				SUBSTRING_INDEX(SUBSTRING_INDEX(t.wrapup_id, '|', 3), '|', -1)
			WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(t.wrapup_id, '|', 2), '|', -1) != '' THEN 
				SUBSTRING_INDEX(SUBSTRING_INDEX(t.wrapup_id, '|', 2), '|', -1)
			ELSE 
				SUBSTRING_INDEX(t.wrapup_id, '|', 1)
			END
			) )AS wrapup_dtl " .
		" FROM t_call_trans t " .
		" LEFT OUTER JOIN t_calllist c ON t.calllist_id = c.calllist_id " .
		" WHERE t.agent_id = " . dbNumberFormat($tmp['uid']) . " " .
		" AND t.campaign_id = " . dbNumberFormat($_POST['cmpid']) . " ";
	" ORDER BY t.create_date ";
	wlog("[call-pane_process][call history] sql: " . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$tmp6[$count] = array(
			"cid" => nullToEmpty($rs['call_id']),
			"cname" => nullToEmpty($rs['first_name'] . " " . $rs['last_name']),
			"wid" => nullToEmpty(wrapupdtl($rs['wrapup_id'])),
			"wdetail" => nullToEmpty(wrapupdtl($rs['wrapup_dtl'])),
			"wdtl" => nullToEmpty($rs['wrapup_note']),
			"cdate" => getDatetimeFromDatetime($rs['create_date'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp6 = array("result" => "empty");
	}


	$data = array("cfield" => $tmp0, "pfield" => $tmp1, "cmp" => $tmp2, "clist" => $tmp3, "totallist" => $totallist, "cback" => $tmp4, "cfollow" => $tmp5, "chistory" => $tmp6, "fieldlength" => $fieldlength);

	$dbconn->dbClose();
	echo json_encode($data);

}

function detail()
{
	//$tmp = json_decode( $_POST['data'] , true); 
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT campaign_id,campaign_name,campaign_detail,start_date,end_date,status" .
		" FROM t_campaign " .
		" WHERE campaign_id = " . dbNumberFormat($_POST['id']) . " ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$tmp1 = array(
			"cmpid" => nullToEmpty($rs['campaign_id']),
			"cmpName" => nullToEmpty($rs['campaign_name']),
			"cmpDetail" => nullToEmpty($rs['campaign_detail']),
			"cmpStartDate" => dateDecode($rs['start_date']),
			"cmpEndDate" => dateDecode($rs['end_date']),
			"cmpStatus" => nullToEmpty($rs['status'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	$data = array("data" => $tmp1);

	$dbconn->dbClose();
	echo json_encode($data);

}


function wrapupdtl($pipe_str)
{
try{
	// $tmp = json_decode( $_POST['data'] , true); 
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$cachename = 'wrapupdtl|' . $pipe_str;
	$cachettl = 300;

	// Check if the data is cached in APCu
	$ans = apcu_fetch($cachename);

	if (!$ans) {
		$t = explode("|", $pipe_str);
		$ans = array();
		
		foreach ($t as $k => $v) {
			if (empty($v)) {
				break;
			}
			
			$sql = "SELECT wrapup_dtl FROM t_wrapup_code WHERE wrapup_code = " . $v;
			wlog("[call-pane_process][integration] wrapup_dtl: " . $sql);
			
			$result = $dbconn->executeQuery($sql);
			if ($rs = mysqli_fetch_array($result)) {
				array_push($ans, $rs['wrapup_dtl']);
			}
		}
		// Store data in APCu cache
		apcu_store($cachename, $ans, $cachettl);
	}

	// Return the first element of $ans or an empty string if it's empty
	return !empty($ans) ? $ans[0] : "";
}
catch(Exception $e) {
	return "";
}

}

// Genesys GetData
function geneGetleadfromcontactid()
{
	$tmp = json_decode($_POST['data'], true);
	$contactid = isset($tmp['contactid']) ? $tmp['contactid'] : null;
	$contactlistid = isset($tmp['contactlistid']) ? $tmp['contactlistid'] : null;
	$uid = isset($tmp['uid']) ? $tmp['uid'] : null;
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	$ret = null;
	if ($contactid && $contactlistid) {
		$ret = geneCheckcontactid($contactid, $dbconn);
		if (!$ret) {
			$gene = new OutboundGenesys();
			$gene->setcontactListId($contactlistid);
			$ret = $gene->getContactData($contactid);
			if ($ret->status != 404) {
				$ret = $ret->data;
				$ret = $ret->{'Customer ID'};
			}
			$insert_q = "INSERT INTO t_calllist_integration (calllist_id, genesys_id, genesys_contactListId, create_date, create_user) VALUES";
			$insert_q .= " ( " . dbNumberFormat($ret) . ", " . dbformat($contactid) . ", " . dbformat($contactlistid) . ", NOW(), " . dbNumberFormat($uid) . " )";
			wlog("[call-pane_process][integration] insertLog : " . $insert_q);
			$dbconn->executeUpdate($insert_q);
		}
	} else if ($contactid) {
		$ret = geneCheckcontactid($contactid, $dbconn);
	}
	$dbconn->dbClose();
	if ($ret) {
		$ret2 = getCalllistDetail($ret);
		$data = array("result" => "success", "data" => $ret, "data2" => $ret2);
	} else {
		$data = array("result" => false, "data" => "");
	}
	echo json_encode($data);
}


function geneCheckcontactid($contactid, $dbconn)
{
	if (empty($contactid))
		return false;
	$value = false;
	//$sql = " SELECT calllist_id FROM t_calllist_integration WHERE genesys_id = " . dbformat($contactid) . " OR calllist_id = " . dbformat($contactid);
	$sql = "SELECT DISTINCT IFNULL(tci.calllist_id, tc.calllist_id) AS calllist_id
        FROM t_calllist tc
        LEFT JOIN t_calllist_integration tci ON tc.calllist_id = tci.calllist_id
        WHERE tc.calllist_id = " . dbformat($contactid) . "
        OR tci.genesys_id = " . dbformat($contactid) . "
        OR tci.calllist_id = " . dbformat($contactid) . ";";
	wlog("[call-pane_process][geneCheckcontactid] sql : " . $sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$value = $rs['calllist_id'];
	}
	return $value;
}


function geneTransfer()
{
	$queueid = isset($_POST['queueid']) ? $_POST['queueid'] : null;
	$cmpName = isset($_POST['cmpName']) ? $_POST['cmpName'] : null;
	$convsersationId = ($_POST['voiceid']) ? $_POST['voiceid'] : $_POST['lastInteraction'];
	$gene = new OutboundGenesys();
	$participants = $gene->getPaticipants($convsersationId);
	$result = false;
	wlog("[call-pane_process][integration] geneTransfer : " . print_r($_POST, true));
	// var_dump($convsersationId, $participants);
	// exit();
	foreach ($participants as $participant) {
		$tmp_val = (object) [
			"queueId" => $queueid
		];
		$result = $gene->postTransfer($convsersationId, $participant, $tmp_val);
	}
	if (property_exists($result, 'message') || !$result) {
		$result = array("result" => false, "data" => $result->message);
	} else {
		$result = array("result" => true, "data" => "Transfer success");
	}
	echo json_encode($result);
}

function geneRemoveQueue($calllist_id,$userid)
{
	$call_count = 0;
	$lead_limit = 100;

	$calllist_detail = getCalllistDetail($calllist_id);
	$campaignid = $calllist_detail["campaign_id"];
	$genesys_queue_id = $calllist_detail["genesys_queue_id"];

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = "SELECT COUNT(DISTINCT calllist_id) AS call_count, IFNULL(c.lead_limit,0) AS lead_limit, a.genesysid AS user_genesysid, c.genesys_queueid 
	FROM t_call_trans t INNER JOIN t_agents a ON t.agent_id = a.agent_id
	INNER JOIN t_campaign c ON t.campaign_id = c.campaign_id
	WHERE t.agent_id = '$userid' AND t.campaign_id = '$campaignid' AND DATE(t.create_date) = CURDATE() AND 1 = 
	(IF(
		EXISTS(
		  SELECT 1
		  FROM t_call_trans h
		  WHERE DATE(h.create_date) < DATE(t.create_date) AND h.calllist_id = t.calllist_id
		),
		'0',
		'1'
	 ))";
	
	wlog("[call-pane_process][integration] geneRemoveQueue : sql=".$sql);
	
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$call_count = $rs['call_count'];
		$lead_limit = $rs['lead_limit'];
		$user_genesysid = $rs['user_genesysid'];
		$genesys_queueid = $rs['genesys_queueid'];
	}

	$dbconn->dbClose();

	wlog("[call-pane_process][integration] geneRemoveQueue Result: genesys_queue_id=$genesys_queue_id call_count=$call_count lead_limit=$lead_limit genesys_queueid=$genesys_queueid");

	if($call_count >= $lead_limit && $call_count > 0 && $lead_limit > 0){
		if($genesys_queue_id == ""){
			$genesys_queue_id = $genesys_queueid;
		}
		$gene = new OutboundGenesys();
		$tmp_val = (object) [
			"joined" => "false"
		];
		$result = $gene->patchUserQueue($user_genesysid, $genesys_queue_id, $tmp_val);
		if (property_exists($result, 'message') || !$result) {
			$result = array("result" => false, "data" => $result->message);
		} else {
			$result = array("result" => true, "data" => "geneRemoveQueue success");
		}
		//echo json_encode($result);
	}
	
}

function geneCallLog(){
	$listid = isset($_POST['listid']) ? $_POST['listid'] : null;
	$voiceid = isset($_POST['voiceid']) ? $_POST['voiceid'] : null;
	$agentid = isset($_POST['agentid']) ? $_POST['agentid'] : null;

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	if ($voiceid &&  $listid) {
		$sql = "INSERT INTO t_gen_call_logs (  calllist_id  , voice_id, agent_id ) VALUES (" .
			" " . dbNumberFormat($listid) . ", " .
			" " . dbNumberFormat($voiceid) . ", ".
			" " . dbNumberFormat($agentid).
			"  ) ";
		$dbconn->executeUpdate($sql);
	}

	$dbconn->dbClose();
	$data = array("result" => "success");

	echo json_encode($data);
}

function addCallTrans(){
	$campaign_id = isset($_POST['campaign_id']) ? $_POST['campaign_id'] : null;
	$calllist_id = isset($_POST['calllist_id']) ? $_POST['calllist_id'] : null;
	$agent_id = isset($_POST['agent_id']) ? $_POST['agent_id'] : null;
	$voice_id = isset($_POST['voice_id']) ? $_POST['voice_id'] : null;

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	
	$sql = "CALL sp_call_trans ('$voice_id',$campaign_id,$agent_id,$calllist_id,null,null,null,null);";
	wlog("[call-pane_process][addCallTrans] sql : " . $sql);
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();
	$data = array("result" => "success");
	echo json_encode($data);
}

function getCalllistDetail($id){
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	$sql = "SELECT il.import_id,c.campaign_id,c.campaign_name,c.campaign_type,IF(il.genesys_queue_id IS NOT NULL,il.genesys_queue_id,c.genesys_queueid) AS genesys_queue_id,c.genesys_callback_queueid
	FROM t_calllist l 
	LEFT JOIN t_calllist_integration ci ON l.calllist_id = ci.calllist_id
	INNER JOIN t_import_list il ON l.import_id = il.import_id
	INNER JOIN t_campaign_list cl ON il.import_id = cl.import_id
	INNER JOIN t_campaign c ON cl.campaign_id = c.campaign_id
	WHERE ci.genesys_id = '$id' OR l.calllist_id = '$id'";
	wlog("[call-pane_process][getCalllistDetail] sql : " . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1 = array(
			"import_id" => nullToEmpty($rs['import_id']),
			"campaign_id" => nullToEmpty($rs['campaign_id']),
			"campaign_name" => nullToEmpty($rs['campaign_name']),
			"campaign_type" => nullToEmpty($rs['campaign_type']),
			"genesys_queue_id" => nullToEmpty($rs['genesys_queue_id']),
			"genesys_callback_queueid" => nullToEmpty($rs['genesys_callback_queueid'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "");
	}
	$dbconn->dbClose();
	return $tmp1;
}

function getQueueFromCalllist(){
	$calllist_id = isset($_POST['calllist_id']) ? $_POST['calllist_id'] : null;
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	$sql = "SELECT il.import_id,c.campaign_id,c.campaign_name,c.campaign_type,IF(il.genesys_queue_id IS NOT NULL,il.genesys_queue_id,c.genesys_queueid) AS genesys_queue_id,c.genesys_callback_queueid
	FROM t_calllist l 
	INNER JOIN t_import_list il ON l.import_id = il.import_id
	INNER JOIN t_campaign_list cl ON il.import_id = cl.import_id
	INNER JOIN t_campaign c ON cl.campaign_id = c.campaign_id
	WHERE l.calllist_id = '$calllist_id'";
	wlog("[call-pane_process][getQueueFromCalllist] sql : " . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1 = array(
			"import_id" => nullToEmpty($rs['import_id']),
			"campaign_id" => nullToEmpty($rs['campaign_id']),
			"campaign_name" => nullToEmpty($rs['campaign_name']),
			"campaign_type" => nullToEmpty($rs['campaign_type']),
			"genesys_queue_id" => nullToEmpty($rs['genesys_queue_id']),
			"genesys_callback_queueid" => nullToEmpty($rs['genesys_callback_queueid'])
		);
		$count++;
	}
	$dbconn->dbClose();
	if ($count == 0) {
		$data = array("result" => "empty");
	}
	else {
		$data = array("result" => "success", "data" => $tmp1);
	}
	echo json_encode($data);
}

function wrapupCallStatus($campaign_id,$calllist_id,$agent_id,$wrapup_code){
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	
	$sql = "CALL sp_wrapup_call_status ($campaign_id,$calllist_id,$agent_id,$wrapup_code)";
	wlog("[call-pane_process][wrapupCallStatus] sql : " . $sql);
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();
	$data = array("result" => "success");
}

function activeList(){
	$call_id = isset($_POST['call_id']) ? $_POST['call_id'] : null;

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	
	$sql = "CALL sp_active_callist_agent ($call_id)";
	wlog("[call-pane_process][activeList] sql : " . $sql);
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();
	$data = array("result" => "success");
}

function getLastWrapup(){
	$calllist_id = isset($_POST['calllist_id']) ? $_POST['calllist_id'] : null;
	$agent_id = isset($_POST['agent_id']) ? $_POST['agent_id'] : null;
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	$sql = "SELECT last_wrapup_id FROM t_calllist_agent WHERE calllist_id = '$calllist_id' AND agent_id = '$agent_id'";
	wlog("[call-pane_process][getLastWrapup] sql : " . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1 = array(
			"last_wrapup_id" => nullToEmpty($rs['last_wrapup_id'])
		);
		$count++;
	}
	$dbconn->dbClose();
	if ($count == 0) {
		$data = array("result" => "empty");
	}
	else {
		$data = array("result" => "success", "data" => $tmp1);
	}
	echo json_encode($data);
}

function updateCallTrans(){
	$voice_id = isset($_POST['voice_id']) ? $_POST['voice_id'] : null;

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	
	$sql = "UPDATE t_call_trans SET update_date = NOW() WHERE voice_id = '$voice_id' AND update_date IS NULL;";
	wlog("[call-pane_process][updateCallTrans] sql : " . $sql);
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();
	$data = array("result" => "success");
	echo json_encode($data);
}
function queryMultiProductCampaignName() {
	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$res = $dbconn->createConn();

	if ($res == 404) {
		echo json_encode(["result" => "dberror", "message" => "Can't connect to database"]);
		exit();
	}

	$calllist_id = intval($tmp['calllist_id']); 
	$cmpisMultiProduct_udf_field = $tmp['cmpisMultiProduct_udf_field']; // เช่น "udf15,udf16,udf17"

	if (empty($cmpisMultiProduct_udf_field)) {
		exit();
	}
	// ดึงข้อมูล udf จาก calllist
	$sql_udf = "SELECT $cmpisMultiProduct_udf_field FROM t_calllist WHERE calllist_id = '$calllist_id'";
	$result = $dbconn->executeQuery($sql_udf);
	$rs = mysqli_fetch_assoc($result);

	$conditions = [];
	$order_values = [];
	foreach ($rs as $val) {
		$val = trim($val);
		if ($val !== '') {
     	$safe_val = addslashes($val);
      $conditions[] = "campaign_name_from_udf LIKE '$safe_val'";
      $order_values[] = "'$safe_val'";
		}
	}

	if (empty($conditions)) {
		echo json_encode(["result" => "empty", "message" => "No UDF values found"]);
		$dbconn->dbClose();
		exit();
	}

	// สร้าง SQL สำหรับค้นหาใน t_campaign
	$where_clause = implode(' OR ', $conditions);
	$order_clause = implode(', ', $order_values);
	$sql_campaign = "SELECT * FROM t_campaign WHERE $where_clause ORDER BY FIELD(campaign_name_from_udf, $order_clause)";

	$result_campaign = $dbconn->executeQuery($sql_campaign);
	$data = [];

	while ($row = mysqli_fetch_assoc($result_campaign)) {
		$data[] = $row;
	}

	if (empty($data)) {
		$data = ["result" => "empty"];
	}

	$dbconn->dbClose();
	echo json_encode($data);
}
function queryCheckAppIdByCalllistId() {
	$tmp = json_decode($_POST['data'], true);
	
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	
	if ($res == 404) {
			$res = array("result" => "dberror", "message" => "Can't connect to database");
			echo json_encode($res);
			exit();
	}

	// $campaign_id = dbNumberFormat($tmp['campaign_id']);
	$calllist_id = dbNumberFormat($tmp['calllist_id']);
	// $agent_id = dbNumberFormat($tmp['agent_id']);

	// Check if campaign_id, calllist_id, and import_id are stored as comma-separated values
	// $sql = "SELECT id, quoteNo 
	// FROM t_aig_app 
	// WHERE campaign_id = '$campaign_id' 
	// 	AND calllist_id = '$calllist_id' 
	// 	AND agent_id = '$agent_id' 
	// ";
	$sql = "SELECT * from t_aig_app where calllist_id='$calllist_id' and is_reject_product='1'";


	wlog("[call-pane_process-Wrapup][init] sql: " . $sql);

	$result = $dbconn->executeQuery($sql);

	$data = [];

	
	while ($rs = mysqli_fetch_assoc($result)) {
			$data[] =$rs;
	}
	if (empty($data)) {
			$data = ["result" => "empty"];
	}
	$dbconn->dbClose();
	echo json_encode($data);
}