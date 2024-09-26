<?php include "dbconn.php" ?>
<?php include "util.php" ?>
<?php include "wlog.php" ?>
<?php


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

		//case "save"    : save(); break;
		//save -> insert , update
		case "check":
			check_cmpname();
			break;
		case "create":
			create();
			break;
		case "update":
			update();
			break;
		// move to deletecmp ( in the same )
		//case "delete"  : delete(); break;


		case "loadcaption":
			load_caption();
			break;
		case "savecaption":
			save_caption();
			break;

		case "saveWrapup":
			save_wrapup();
			break;
		case "deleteWrapup":
			delete_wrapup();
			break;

		// campaign control
		case "stopcmp":
			stop_cmp();
			break;
		case "startcmp":
			start_cmp();
			break;
		case "removecmp":
			delete_cmp();
			break;

		// cmpaign list control
		case "savelist":
			save_list();
			break;
		case "removelist":
			delete_list();
			break;

		//campaign summary
		case "summary":
			summary();
			break;
		case "wrapup":
			wrapup();
			break; //query wrapup
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

	//query script 
	$sql = " SELECT script_id , script_name  " .
		" FROM t_callscript " .
		" ORDER BY script_name ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1[$count] = array(
			"id" => nullToEmpty($rs['script_id']),
			"value" => nullToEmpty($rs['script_name'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	$sql = " SELECT ex_app_id , ex_app_name   " .
		" FROM t_external_app_register " .
		" WHERE is_active = 1 ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$tmp2[$count] = array(
			"id" => nullToEmpty($rs['ex_app_id']),
			"value" => nullToEmpty($rs['ex_app_name']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp2 = array("result" => "empty");
	}

	$sql = "SELECT id,description FROM t_aig_sg_lov WHERE name='campaignType'";
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$tmp3[$count] = array(
			"id" => nullToEmpty($rs['id']),
			"value" => nullToEmpty($rs['description']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp3 = array("result" => "empty");
	}

	$dbconn->dbClose();
	$data = array("script" => $tmp1, "app" => $tmp2, "campaign_type" => $tmp3);
	echo json_encode($data);

}


function summary()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//query  campaign 
	$sql = " SELECT campaign_name , campaign_detail , start_date , end_date , `status`, status_detail , c.create_date , a.first_name , a.last_name " .
		" FROM t_campaign c " .
		" LEFT OUTER JOIN t_agents a ON c.create_user = a.agent_id " .
		" LEFT OUTER JOIN ts_campaign_status s ON s.status_id = c.status " .
		" WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']) . " ";

	wlog("[campaign-pane_process][summary] campaign sql : " . $sql);

	$result = $dbconn->executeQuery($sql);
	$count = 0;
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1 = array(
			"cmpname" => nullToEmpty($rs['campaign_name']),
			"cmpdtl" => nullToEmpty($rs['campaign_detail']),
			"startdate" => getDateFromDatetime($rs['start_date']),
			"enddate" => getDateFromDatetime($rs['end_date']),
			"status" => nullToEmpty($rs['status']),
			"statusdtl" => nullToEmpty($rs['status_detail']),
			"cred" => getDatetimeFromDatetime($rs['create_date']),
			"cname" => nullToEmpty($rs['first_name'] . " " . $rs['last_name'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	//query campaign list
	$sql = " SELECT l.import_id , i.list_name , i.list_detail , total_records , bad_list , inlist_dup ,  indb_dup " .
		" FROM t_campaign_list l LEFT OUTER JOIN t_import_list i ON l.import_id = i.import_id " .
		" WHERE l.campaign_id = " . dbNumberFormat($tmp['cmpid']) . " " .
		" ORDER BY i.list_name ";

	wlog("[campaign-pane_process][summary] campaign list  sql : " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp2[$count] = array(
			"impid" => nullToEmpty($rs['import_id']),
			"lname" => nullToEmpty($rs['list_name']),
			"ldtl" => nullToEmpty($rs['list_detail']),
			"total" => nullToZero($rs['total_records']),
			"bad" => nullToZero($rs['bad_list']),
			"listdup" => nullToZero($rs['inlist_dup']),
			"indbdup" => nullToZero($rs['indb_dup']),
		);
		$count++;
	}

	if ($count == 0) {
		$tmp2 = array("result" => "empty");
	}



	$dbconn->dbClose();
	$data = array("cmp" => $tmp1, "data" => $tmp2);
	echo json_encode($data);

}

function save_list()
{

	$tmp = json_decode($_POST['data'], true);
	$list = json_decode($_POST['list'], true);


	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$size = count($list);
	for ($i = 0; $i < $size; $i++) {
		$sql = "INSERT INTO t_campaign_list( campaign_id , import_id , join_status ,  join_user , join_date) VALUES ( " .
			" " . dbNumberFormat($tmp['cmpid']) . " " .
			"," . dbNumberFormat($list[$i]) . " " .
			", 2 " . //set default status to inuse
			"," . dbNumberFormat($tmp['uid']) . " , NOW() )  ";
		wlog("[campaign-pane_process][save_list] insert sql : " . $sql);
		$dbconn->executeUpdate($sql);

	}

	//after join list to campaign
	//update campagin status 
	/* deprecate
			 $status = check_cmpstatus();
					  if( $status == 0){
						  //check is another list that join this campaign 
						  $sql = "SELECT COUNT(import_id) AS total  FROM t_campaign_list WHERE campaign_id = ".dbNumberFormat($tmp['cmpid']); 
						  $result = $dbconn->executeQuery($sql);
						 if($rs=mysqli_fetch_array($result)){
							 if($rs['total'] > 0 ){
								 $status = 2;
								 //$sql = " UPDATE t_campaign SET `status` = 2 ";
							 }else{
								 $status = 1;
								 //$sql = " UPDATE t_campaign SET `status` = 1 ";
							 }
						 }
					  }
					  
					  
					  $sql = "UPDATE t_campaign SET `status` = ".dbNumberFormat($status)." WHERE campaign_id = ".dbNumberFormat($tmp['cmpid']); 
					 wlog("[campaign-pane_process][save_list] sql : ".$sql);
					 //update sql;
					  $dbconn->executeUpdate($sql);
			  */

	$dbconn->dbClose();
	$data = array("result" => "success");
	echo json_encode($data);

}

function delete_list()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = "DELETE FROM  t_campaign_list WHERE campaign_id= " . dbNumberFormat($tmp['cmpid']) . " AND import_id = " . dbNumberFormat($_POST['list']) . " ";
	wlog("[campaign-pane_process][delete_list] DELETE CAMPAIGN LIST sql : " . $sql);
	$success = $dbconn->executeUpdate($sql);
	if ($success) {
		//after join list to campaign
		//update campagin status 
		$status = check_cmpstatus();
		if ($status == 0) {
			//check is another list that join this campaign 
			$sql = "SELECT COUNT(import_id) AS total  FROM t_campaign_list WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
			$result = $dbconn->executeQuery($sql);
			if ($rs = mysqli_fetch_array($result)) {
				if ($rs['total'] > 0) {
					$status = 2;
					//$sql = " UPDATE t_campaign SET `status` = 2 ";
				} else {
					$status = 1;
					//$sql = " UPDATE t_campaign SET `status` = 1 ";
				}
			}
		}
		/*
					   else{
							  $sql = " UPDATE t_campaign SET `status` = ".dbNumberFormat($status)." ";
					  }
					  */

		$sql = "UPDATE t_campaign SET `status` = " . dbNumberFormat($status) . " WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
		wlog("[campaign-pane_process][delete_list] sql : " . $sql);
		//update sql;
		$dbconn->executeUpdate($sql);
	}
	$dbconn->dbClose();

	$data = array("result" => "success");
	echo json_encode($data);

}

//check campaign shoud be status
function check_cmpstatus()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//check campaign current status;
	$skip = true;
	$status = 0; //default status set to new
	//check is expired
	//expired status == 5
	//?
	$sql = "SELECT DATEDIFF(end_date,NOW() ) AS df  FROM t_campaign WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']) . " AND is_expire = 1 ";
	wlog($sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		if ($rs['df'] < 0) {
			$status = 5;
			$skip = false;
		}
	}

	//check is in use
	//inuse status == 3
	//?
	if ($skip) {
		$sql = "SELECT COUNT(*) AS total FROM t_calllist_agent WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
		wlog($sql);
		$result = $dbconn->executeQuery($sql);
		if ($rs = mysqli_fetch_array($result)) {
			if ($rs['total'] >= 1) {
				$status = 3;
				$skip = false;
			}
		}
	}


	//check is active 
	//active status == 2
	//?
	if ($skip) {
		$sql = "SELECT COUNT(*) AS total FROM t_campaign_field WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
		$result = $dbconn->executeQuery($sql);
		if ($rs = mysqli_fetch_array($result)) {
			if ($rs['total'] >= 1) {
				$status = 2;
				$skip = false;
			}
		}

	}

	//check is active 
	//active status == 1
	//?
	if ($skip) {
		$sql = "SELECT COUNT(*) AS total FROM t_campaign_list WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
		$result = $dbconn->executeQuery($sql);
		if ($rs = mysqli_fetch_array($result)) {
			if ($rs['total'] >= 1) {
				$status = 2;
				$skip = false;
			}
		}
	}



	//if status == 0 mean not thing from above
	wlog("[campaign-pan_process][check_cmpstatus] return status : [" . $status . "]");
	return $status;

}

function stop_cmp()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//report all info abount campagin 


	//update campaign
	//stop status == 4   
	$sql = "UPDATE t_campaign SET " .
		"`status` = 4 ," .
		"update_date =NOW()," .
		"update_user =" . dbformat($tmp['uid']) . " " .
		"WHERE campaign_id = " . dbformat($tmp['cmpid']) . " ";

	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();
	$res = array("result" => "success");
	echo json_encode($res);

}

function start_cmp()
{

	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//check campaign current status;
	$skip = true;
	$status = 0; //default status set to new
	//check is expired
	//expired status == 5
	//?
	$sql = "SELECT DATEDIFF(end_date,NOW() ) AS df  FROM t_campaign WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']) . " AND is_expire = 1 ";
	wlog($sql);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		if ($rs['df'] < 0) {
			$status = 5;
			$skip = false;
		}
	}

	//check is in use
	//inuse status == 3
	//?
	if ($skip) {
		$sql = "SELECT COUNT(*) AS total FROM t_calllist_agent WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
		wlog($sql);
		$result = $dbconn->executeQuery($sql);
		if ($rs = mysqli_fetch_array($result)) {
			if ($rs['total'] >= 1) {
				$status = 3;
				$skip = false;
			}
		}
	}


	//check is active 
	//active status == 2
	//?
	if ($skip) {
		$sql = "SELECT COUNT(*) AS total FROM t_campaign_list WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
		wlog($sql);
		$result = $dbconn->executeQuery($sql);
		if ($rs = mysqli_fetch_array($result)) {
			if ($rs['total'] >= 1) {
				$status = 2;
				$skip = false;
			}
		}
	}

	//else
	// new status == 1
	if ($status == 0) {
		$status = 1;
	}

	//update date to campaign status
	$sql = " UPDATE t_campaign SET " .
		" `status` = " . dbNumberFormat($status) . ", " .
		" update_date =NOW()," .
		" update_user =" . dbformat($tmp['uid']) . " " .
		" WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']) . " ";
	wlog($sql);
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();
	$res = array("result" => "success");
	echo json_encode($res);
}

function delete_cmp()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " DELETE FROM t_campaign WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']) . " ";
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();

	$res = array("result" => "success");
	echo json_encode($res);

}



function init_wrapup()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}
	$sql = " SELECT wrapup_code , wrapup_dtl , parent_code , seq_no , `status` , remove_list , option_id  " .
		" FROM t_wrapup_code where campaign_id like  '%" . dbNumberFormat($tmp['cmpid']) . "%'   ";
	" ";

	wlog("[campaign-pane_process][init_wrapup] sql : " . $sql);
	$result = $dbconn->executeQuery($sql);
	$count = 0;
	while ($rs = mysqli_fetch_array($result)) {
		/*
				   $data[$count] = array( 
						   $rs['wrapup_code'];
						   $rs['wrapup_dtl'];
						   $rs['parent_code'];
						   $rs['seq_no'];
						   $rs['status'];
						   $rs['remove_list'];
						   $rs['option_id'];
				   
				   );
				   */
	}

	$dbconn->dbClose();
}


// save campaign caption 
function save_caption()
{
	//used old algorithm delete all then insert
	$tmp = json_decode($_POST['data'], true);


	wlog("SAVE CAPTION");


	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//delete
	$sql = "DELETE FROM t_campaign_field WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
	$dbconn->executeUpdate($sql);

	//insert
	$count = 0;
	if (isset($tmp["seq[]"])) {
		for ($i = 0; $i < count($tmp['seq[]']); $i++) {
			$count++;
			$seq = dbNumberFormat($tmp['seq[]'][$i]);
			$cmpid = dbNumberFormat($tmp['cmpid']);
			$caption = dbformat($tmp['cmpn[]'][$i]);
			$field = dbformat($tmp['cmpf[]'][$i]);
			$option = dbformat($tmp['cmpo[]'][$i]);
			$workpage = (in_array($i+1,$tmp['cmpsw[]']))?1:0;
			$profilepage = (in_array($i+1,$tmp['cmpsp[]']))?1:0;
			$uid =  dbNumberFormat($tmp['uid']);
			$sql = " INSERT INTO t_campaign_field( seq , campaign_id , caption_name , field_name,  caption_option  , show_on_callwork , show_on_profile, create_user, create_date ) VALUES ( " .
				" " . $seq . " " .
				"," . $cmpid. " " .
				"," . $caption . " " .
				"," . $field . " " .
				"," . $option . " " .
				"," . $workpage . " " .
				"," . $profilepage . " " .
				"," . $uid . " , NOW() )  ";
			$dbconn->executeUpdate($sql);
		}
	}


	//check current status if status new update to ready 
	//but if status is ready do nothing
	$sql = "SELECT `status` FROM t_campaign WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {

		wlog("current campaign status : " . $rs['status']);

		if (nullToZero($rs['status']) == 1) {
			//and output from field  mapping is not empty
			if ($count != 0) {
				$sql = "UPDATE t_campaign SET `status` = 2 WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
				wlog("[campaign-pane_process][save_caption]  CHANGE campaign status FROM 1 to 2 : " . $sql);
				$dbconn->executeUpdate($sql);
			}
		} //end if status == 1

		//if current status is ready
		if (nullToZero($rs['status']) == 2) {
			//and no field insert 
			if ($count == 0) {
				//update status back to new
				$sql = "UPDATE t_campaign SET `status` = 1 WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']);
				wlog("[campaign-pane_process][save_caption]  CHANGE campaign status BACK FROM 2 to 1 : " . $sql);
				$dbconn->executeUpdate($sql);
			}
		} //end if status == 2

	}


}

//initial configuration for caption field
function load_caption()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//init caption field
	$sql = "SELECT field_name , field_alias_name" .
		" FROM ts_field_list " .
		" ORDER BY field_name";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1[$count] = array(
			"id" => nullToEmpty($rs['field_name']),
			"value" => nullToEmpty($rs['field_alias_name'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}


	//query current campaign caption
	$sql = " SELECT rowid , caption_name, caption_option , field_name , show_on_callwork , show_on_profile " .
		" FROM t_campaign_field " .
		" WHERE campaign_id = " . dbNumberFormat($tmp['cmpid']) . " " .
		" ORDER BY seq ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp2[$count] = array(
			"id" => nullToEmpty($rs['rowid']),
			"capn" => nullToEmpty($rs['caption_name']),
			"capopt" => nullToEmpty($rs['caption_option']),
			"fieldn" => nullToEmpty($rs['field_name']),
			"callwork" => nullToZero($rs['show_on_callwork']),
			"profile" => nullToZero($rs['show_on_profile'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp2 = array("result" => "empty");
	}

	$data = array("caption" => $tmp1, "data" => $tmp2);


	$dbconn->dbClose();
	echo json_encode($data);

}


function query()
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

	$sql = " SELECT campaign_id,campaign_name,campaign_code,campaign_detail,start_date,end_date,c.status, st.status_detail, st.status_color " .
		" FROM t_campaign c " .
		" LEFT OUTER JOIN ts_campaign_status st ON c.status = st.status_id " .
		" ORDER BY campaign_id ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$data[$count] = array(
			"cmpid" => nullToEmpty($rs['campaign_id']),
			"cmpName" => nullToEmpty($rs['campaign_name']),
			"cmpCode" => nullToEmpty($rs['campaign_code']),
			"cmpDetail" => nullToEmpty($rs['campaign_detail']),
			"cmpStartDate" => dateDecode($rs['start_date']),
			"cmpEndDate" => dateDecode($rs['end_date']),
			"cmpStatus" => nullToEmpty($rs['status']),
			"cmpStatusDetail" => nullToEmpty($rs['status_detail']),
			"cmpStatusColor" => nullToEmpty($rs['status_color'])
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);

}

function detail()
{

	//$tmp = json_decode( $_POST['data'] , true); 
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT campaign_id,campaign_name,campaign_code,campaign_detail,cp_type,campaign_type,is_expire, app_id , maximum_call, genesys_queueid, genesys_campaignid , start_date,end_date, c.status, st.status_detail, st.status_color , c.script_id,s.script_detail, " .
		" a.first_name , a.last_name , c.create_date " .
		" FROM t_campaign c LEFT OUTER JOIN t_callscript s ON c.script_id = s.script_id " .
		" LEFT OUTER JOIN ts_campaign_status st ON c.status = st.status_id " .
		" LEFT OUTER JOIN t_agents a ON a.agent_id = c.create_user " .
		" WHERE campaign_id = " . dbNumberFormat($_POST['id']) . " ";

	wlog("[campaign-pane_process][detail] query detail : " . $sql);
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1 = array(
			"cmpid" => nullToEmpty($rs['campaign_id']),
			"cmpName" => nullToEmpty($rs['campaign_name']),
			"cmpCode" => nullToEmpty($rs['campaign_code']),
			"cmpDetail" => nullToEmpty($rs['campaign_detail']),
			"cmpCat" => nullToEmpty($rs['cp_type']),
			"cmpType" => nullToEmpty($rs['campaign_type']),
			"cmpExpire" => nullToEmpty($rs['is_expire']),
			"cmpStartDate" => dateDecode($rs['start_date']),
			"cmpEndDate" => dateDecode($rs['end_date']),
			"cmpStatus" => nullToEmpty($rs['status']),
			"cmpStatusDtail" => nullToEmpty($rs['status_detail']),
			"cmpStatusColor" => nullToEmpty($rs['status_color']),
			"callscriptid" => nullToEmpty($rs['script_id']),
			"callscriptdtl" => nullToEmpty($rs['script_detail']),
			"cmpApp" => nullToEmpty($rs['app_id']),
			"cmpGeneQueue" => nullToEmpty($rs['genesys_queueid']),
			"cmpGeneCampaign" => nullToEmpty($rs['genesys_campaignid']),
			"maxCall" => nullToEmpty($rs['maximum_call']),
			"created" => getDatetimeFromDatetime($rs['create_date']),
			"createu" => nulltoEmpty($rs['first_name'] . " " . $rs['last_name']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	$sql = " SELECT script_id , script_name  " .
		" FROM t_callscript " .
		" ORDER BY script_name ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp2[$count] = array(
			"id" => nullToEmpty($rs['script_id']),
			"value" => nullToEmpty($rs['script_name'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp2 = array("result" => "empty");
	}


	//fixbug
	$sql = " SELECT campaign_id , campaign_name ,import_id ,list_name,list_detail,join_date,status_id,status_detail,status_color, total_list  , other_list " .
		" , COUNT( DISTINCT assign_list ) AS assign_list " .
		" , SUM( unassign_list ) AS unassign_list " .
		" FROM ( " .

		" SELECT c.campaign_id , c.campaign_name , cl.import_id " .
		" , iml.list_name  ,iml.list_detail , cl.join_date " .
		" , cl.join_status as status_id ,ls.status_detail as status_detail , ls.status_color " .
		" ,cla.calllist_id " .
		" , iml.total_records as total_list " .
		" , ( iml.bad_list + iml.inlist_dup + iml.indb_dup ) as other_list " .
		" ,CASE WHEN cla.agent_id  IS NOT NULL THEN cla.calllist_id END AS assign_list " .
		" ,CASE WHEN cla.assign_dt IS NULL AND cl.import_id  IS NOT NULL THEN 1 else 0 END AS unassign_list " .

		" FROM t_campaign c LEFT OUTER JOIN t_campaign_list cl " .
		" ON ( c.campaign_id = cl.campaign_id ) " .
		" LEFT OUTER JOIN ts_map_list_status ls " .
		" ON (  cl.join_status = ls.status_id ) " .
		" LEFT OUTER JOIN t_import_list iml " .
		" ON ( cl.import_id =  iml.import_id ) " .

		" LEFT OUTER JOIN t_calllist_agent cla " .
		" ON ( c.campaign_id = cla.campaign_id AND cla.import_id = iml.import_id ) " .
		" ) AS A " .
		" WHERE campaign_id = " . dbNumberFormat($_POST['id']) .
		" GROUP BY campaign_id , campaign_name ,import_id ,list_name,list_detail,join_date,status_id,status_detail,status_color,total_list  ,other_list " .
		" ORDER BY  campaign_id , campaign_name ,import_id ";

	wlog("[campaign-pane_process][detail] " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {


		$isexpire = checkListExp($rs['import_id']);
		$tmp3[$count] = array(
			"cmpid" => nullToEmpty($rs['campaign_id']),
			"joinstausid" => nullToEmpty($rs['status_id']),
			"joinstausdtl" => nullToEmpty($rs['status_detail']),
			"stscolor" => nullToEmpty($rs['status_color']),

			"isexpireid" => $isexpire[0],
			"isexpiredtl" => $isexpire[1],
			"isexpirecolor" => $isexpire[2],

			"jdate" => getDatetimeFromDatetime($rs['join_date']),
			"impid" => nullToEmpty($rs['import_id']),
			"cmpname" => nullToEmpty($rs['campaign_name']),
			"lname" => nullToEmpty($rs['list_name']),
			"ldtl" => nullToEmpty($rs['list_detail']),
			"total" => nullToZero($rs['total_list']),
			"assign" => nullToZero($rs['assign_list']),
			"unassign" => nullToZero($rs['unassign_list']),
			"other" => nullToZero($rs['other_list'])


		);
		$count++;
	}
	if ($count == 0) {
		$tmp3 = array("result" => "empty");
	}

	//list ava for mapping
	$sql = " SELECT i.import_id , i.list_name , i.total_records " .
		" FROM t_import_list  i WHERE `status` = 1 AND import_id NOT IN ( SELECT import_Id FROM t_campaign_list WHERE campaign_id = " . dbNumberFormat($_POST['id']) . " ) ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp4[$count] = array(
			"impid" => nullToEmpty($rs['import_id']),
			"lname" => nullToEmpty($rs['list_name']),
			"total" => nullToEmpty($rs['total_records']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp4 = array("result" => "empty");
	}

	/*	
		   $data = array("cmplist"=>$tmp);
			  
			  //campaign list
			  $sql = "SELECT l.campaign_id , c.campaign_name , i.import_id,i.list_name  ".
						  " ,CASE WHEN l.campaign_id IS NOT NULL THEN 1 ELSE 0 END AS is_exists ". 
						  " ,COUNT(cl.calllist_id) AS totallist ".
						  " FROM t_import_list i ".
						  " LEFT OUTER JOIN t_campaign_list l ON (  i.import_id = l.import_id  AND l.campaign_id = ".dbNumberFormat( $_POST['id'] )." )   ".
						  " LEFT OUTER JOIN t_campaign c ON ( l.campaign_id = c.campaign_id  ) ". 
						  " LEFT OUTER JOIN t_calllist cl  ON ( cl.import_id = i.import_id   ) ".
						  " WHERE i.list_name IS NOT NULL ".
						  " GROUP BY l.campaign_id , c.campaign_name  , i.import_id,i.list_name ,i.total_records , ". 
						   " CASE WHEN l.campaign_id IS NOT NULL THEN 1 ELSE 0 END ".
						  " ORDER BY i.import_id DESC ";
			  
			  wlog($sql);
			  $result = $dbconn->executeQuery($sql);
			  $count = 0;
			  while($rs=mysqli_fetch_array($result)){   
					$tmp3[$count] = array(
								  "cmpid"  => nullToEmpty($rs['campaign_id']),
								  "cmpname"  => nullToEmpty($rs['campaign_name']),
									"total"  => nullToZero($rs['totallist']),
									"impid"  => nullToEmpty($rs['import_id']),
									"lname"  => nullToEmpty($rs['list_name']),
									"exist"  => nullToEmpty($rs['is_exists']),
									"unava" => count_cmplistagent( $_POST['id'] )
						  );   
				  $count++;  
			  }
			  if($count==0){
				  $tmp3 = array("result"=>"empty");
			  } 
			  */
	/*
			  //tab summary list in campaign
			  $sql = " SELECT list_name , list_detail, count( calllist_id ) as total_call ".
						  " , sum( newlist_cnt ) as newlist_cnt ". 
						 " , sum( callback_cnt ) as callback_cnt ".
						 " , sum( followup_cnt ) as followup_cnt ".
						 " , sum( dnd_cnt ) as dnd_cnt ".
						 " , sum( badlist_cnt ) as badlist_cnt ". 
						 " , sum( maxtry_cnt ) as maxtry_cnt ".
						 " , sum( sales_cnt ) as sales_cnt ".
						 " from ( ".
										 " select a.calllist_id , list_name , list_detail ".
										  " ,case when last_wrapup_option_id is null then 1 else 0 end as newlist_cnt ". 
										 " ,case when last_wrapup_option_id = 1 then 1 else 0 end as callback_cnt ". 
										 " ,case when last_wrapup_option_id = 2 then 1 else 0 end as followup_cnt ".
										 " ,case when last_wrapup_option_id = 3 then 1 else 0 end as dnd_cnt ".
										 " ,case when last_wrapup_option_id = 4 then 1 else 0 end as badlist_cnt ". 
										 " ,case when last_wrapup_option_id = 5 then 1 else 0 end as maxtry_cnt ".
										 " ,case when last_wrapup_option_id = 6 then 1 else 0 end as sales_cnt ".
										 " from t_calllist_agent a ".
											  " left outer join t_calllist c on a.calllist_id = c.calllist_id".
											  " left outer join t_import_list i on i.import_id = c.import_id".
										 " where a.campaign_id = ".dbNumberFormat( $_POST['id'] )." ".
						 " ) as tmp ";		
		  
			  $result = $dbconn->executeQuery($sql);
			  $count = 0;
			 while($rs=mysqli_fetch_array($result)){
					 $tmp3[$count] = array(
						 "lid" => nullToEmpty($rs['list_name']),
						 "ldetail" => nullToEmpty($rs['list_detail']),
						 "total" => nullToEmpty($rs['total_call']),
						 "newlist" => nullToEmpty($rs['newlist_cnt']),
						 "cback" => nullToEmpty($rs['callback_cnt']),
						 "follow" => nullToEmpty($rs['followup_cnt']),
						 "dnd" => nullToEmpty($rs['dnd_cnt']),
						 "blist" => nullToEmpty($rs['badlist_cnt']),
						 "maxtry" => nullToEmpty($rs['maxtry_cnt']),
						 "sales" => nullToEmpty($rs['sales_cnt']),
					 );					
					 $count++;
			 }
			 
		 
			 if($count==0){
				 $tmp3 = array("result"=>"empty");
			 } 
			 
			 
			 
			  */


	$sql = " SELECT ex_app_id , ex_app_name   " .
		" FROM t_external_app_register " .
		" WHERE is_active = 1 ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$tmp5[$count] = array(
			"id" => nullToEmpty($rs['ex_app_id']),
			"value" => nullToEmpty($rs['ex_app_name']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp5 = array("result" => "empty");
	}

	$sql = "SELECT id,description FROM t_aig_sg_lov WHERE name='campaignType'";
	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$tmp6[$count] = array(
			"id" => nullToEmpty($rs['id']),
			"value" => nullToEmpty($rs['description']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp6 = array("result" => "empty");
	}



	$data = array("data" => $tmp1, "callscript" => $tmp2, "cmplist" => $tmp3, "listava" => $tmp4, "app" => $tmp5, "cp_type" => $tmp6);

	$dbconn->dbClose();
	echo json_encode($data);

}

//helper function from detail
function checkListExp($impid)
{
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT l.status , s.status_detail , s.status_color " .
		" FROM t_import_list l LEFT OUTER JOIN ts_map_list_status s ON l.status = s.status_id " .
		" WHERE l.import_id= " . dbNumberFormat($impid) . "  ";

	$result = $dbconn->executeQuery($sql);
	$sts = array(); //default status == 1 ( available )
	$sts[0] = 1;
	if ($rs = mysqli_fetch_array($result)) {
		$sts[0] = $rs['status'];
		$sts[1] = $rs['status_detail'];
		$sts[2] = $rs['status_color'];
	}
	return $sts;
}

function save_wrapup()
{
	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	//update   
	$sql = "UPDATE t_wrapup_code SET " .
		"wrapup_dtl =" . dbformat($tmp['wdtl']) . "," .
		"genesys_wrapup_id =" . dbformat($tmp['genewid']) . "," .
		"parent_code =" . dbformat($tmp['pcode']) . "," .
		"seq_no =" . dbNumberFormat($tmp['seq']) . "," .
		"status =" . dbNumberFormat($tmp['sts']) . "," .
		"remove_list =" . dbNumberFormat($tmp['rmlist']) . "," .
		"option_id =" . dbNumberFormat($tmp['woptid']) . " " .
		"WHERE wrapup_code = " . dbformat($tmp['wcode']) . " ";

	wlog("[campaign-pane_process][save_wrapup] update wrapup sql : " . $sql);
	$dbconn->executeUpdate($sql);
	$tmp1 = getWrapup($tmp['cmpid'], $dbconn);
	$dbconn->dbClose();
	$res = array("result" => "success", "wrapup" => $tmp1);
	echo json_encode($res);

}

function delete_wrapup()
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
	$sql = "SELECT FROM ";
	wlog("[campaign-pane_process][delete_wrapup] sql : " . $sql);

	$success = $dbconn->executeUpdate($sql);
	if ($success) {

	}

}

//query wrapup config
function wrapup()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$tmp1 = getWrapup($tmp['cmpid'], $dbconn);

	$data = array("wrapup" => $tmp1);

	$dbconn->dbClose();
	echo json_encode($data);

}

function getWrapup($cmpid, $dbconn)
{
	$sql = " SELECT wrapup_code , wrapup_dtl , parent_code , seq_no , `status` , remove_list , option_id, genesys_wrapup_id " .
		" FROM t_wrapup_code WHERE campaign_id like '%" . dbNumberFormat($cmpid) . "%'  ";

	wlog("[campaign-pane_process][select_wrapup] sql : " . $sql);

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$tmp1[$count] = array(
			"wcode" => nullToEmpty($rs['wrapup_code']),
			"wdtl" => nullToEmpty($rs['wrapup_dtl']),
			"pcode" => nullToEmpty($rs['parent_code']),
			"seq" => nullToEmpty($rs['seq_no']),
			"sts" => nullToEmpty($rs['status']),
			"rmlist" => nullToEmpty($rs['remove_list']),
			"woptid" => nullToEmpty($rs['option_id']),
			"genewid" => nullToEmpty($rs['genesys_wrapup_id']),
		);
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	return $tmp1;
}


//count list that distribute to agents
/*
   function count_cmplistagent( $cmpid ){
   
			   $dbconn = new dbconn;  
			   $res = $dbconn->createConn();
			   if($res==404){
				   $res = array("result"=>"error","message"=>"Can't connect to database");
				   echo json_encode($res);		
				   exit();
			   }
	   
			   //count between campaign and campaign agent 
			   $sql = "SELECT COUNT(calllist_id) AS totallist FROM t_calllist_agent WHERE campaign_id = ".dbNumberFormat($cmpid)." ";
		   
			   $total = 0;
			   $result = $dbconn->executeQuery($sql); 
			   if($rs=mysqli_fetch_array($result)){   
						 $total= nullToZero($rs['totallist']);
			   }
   
		   return $total;
			   
   }
   */
// is campaign name duplicate
function check_cmpname()
{
	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = "SELECT campaign_id FROM t_campaign WHERE campaign_name = " . dbformat($_POST['cmpname']) . " ";
	$result = $dbconn->executeQuery($sql);
	$res = "";
	if ($rs = mysqli_fetch_array($result)) {
		$res = "duplicate";
	}

	$dbconn->dbClose();
	$res = array("result" => $res);
	echo json_encode($res);


}

//insert campaign
function create()
{

	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}



	//check is save again ( fix user alway save with same data );
	wlog("check campaign unique id : " . $tmp['cmpuniqueid']);
	if ($tmp['cmpuniqueid'] != "") {

		//query campaign id from uniqueid
		$sql = "SELECT campaign_id FROM t_campaign WHERE campaign_uniqueid = " . dbformat($tmp['cmpuniqueid']) . " ";
		$result = $dbconn->executeQuery($sql);
		if ($rs = mysqli_fetch_array($result)) {
			$cmpid = nullToEmpty($rs['campaign_id']);
		}

		//update   
		$sql = "UPDATE t_campaign SET " .
			"campaign_name =" . dbformat($tmp['ncmpName']) . "," .
			"campaign_detail =" . dbformat($tmp['ncmpDetail']) . "," .
			"start_date =" . dateEncode($tmp['ncmpStartDate']) . "," .
			"end_date =" . dateEncode($tmp['ncmpEndDate']) . "," .
			"status = 1," .
			"maximum_call =" . dbNumberFormat($tmp['ncmpMaxCall']) . "," .
			"genesys_queueid =" . dbformat($tmp['ncmpGeneQueue']) . "," .
			"genesys_campaignid =" . dbformat($tmp['ncmpGeneCampaign']) . "," .
			"script_id =" . dbNumberFormat($tmp['nscriptname']) . "," .
			"update_date =NOW()," .
			"update_user =" . dbformat($tmp['uid']) . " " .
			"WHERE campaign_id = " . dbNumberFormat($cmpid) . " ";

		//set uniqueid
		$uniqueid = $tmp['cmpuniqueid'];

	} else {
		//gen uniqueid 
		$uniqueid = uniqid();

		//insert new campaign
		$sql = " INSERT INTO t_campaign( campaign_uniqueid, campaign_name, campaign_code, campaign_detail, cp_type, is_expire , start_date,end_date, maximum_call, genesys_queueid, genesys_campaignid,status , script_id, create_user, create_date ) VALUES ( " .
			" " . dbformat($uniqueid) . " " .
			"," . dbformat($tmp['ncmpName']) . " " .
			"," . dbformat($tmp['ncmpCode']) . " " .
			"," . dbformat($tmp['ncmpDetail']) . " " .
			"," . dbformat($tmp['ncmpType']) . " " .
			"," . dbformat($tmp['ncmpExpire']) . " " .
			"," . dateEncode($tmp['ncmpStartDate']) . " " .
			"," . dateEncode($tmp['ncmpEndDate']) . " " .
			"," . dbNumberFormat($tmp['ncmpMaxCall']) . " " .
			"," . dbformat($tmp['ncmpGeneQueue']) . " " .
			"," . dbformat($tmp['ncmpGeneCampaign']) . " " .
			", 1 " . //new status == 1
			"," . dbNumberFormat($tmp['scriptname']) . " " .
			"," . dbNumberFormat($tmp['uid']) . " , NOW() )  ";


	}


	wlog("[campaign-pane_process][create] create campaign sql : " . $sql);
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();
	$res = array("result" => "success", "cmpuniqueid" => $uniqueid);
	echo json_encode($res);

}

//update campaign
function update()
{

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}


	//update   
	$sql = "UPDATE t_campaign SET " .
		"campaign_name =" . dbformat($tmp['cmpName']) . "," .
		"campaign_code =" . dbformat($tmp['cmpCode']) . "," .
		"campaign_detail =" . dbformat($tmp['cmpDetail']) . "," .
		"cp_type =" . dbformat($tmp['cmpCat']) . "," .
		"campaign_type =" . dbformat($tmp['cmpType']) . "," .
		"is_expire =" . dbformat($tmp['cmpExpire']) . "," .
		"start_date =" . dateEncode($tmp['cmpStartDate']) . "," .
		"end_date =" . dateEncode($tmp['cmpEndDate']) . "," .
		"status =" . dbformat($tmp['cmpStatus']) . "," .
		"script_id =" . dbNumberFormat($tmp['scriptname']) . "," .
		"app_id =" . dbNumberFormat($tmp['cmpApp']) . "," .
		"maximum_call =" . dbNumberFormat($tmp['cmpMaxCall']) . "," .
		"genesys_queueid =" . dbformat($tmp['cmpGeneQueue']) . "," .
		"genesys_campaignid =" . dbformat($tmp['cmpGeneCampaign']) . "," .
		"update_date =NOW()," .
		"update_user =" . dbformat($tmp['uid']) . " " .
		"WHERE campaign_id = " . dbformat($tmp['cmpid']) . " ";

	wlog("[campaign-pane_process][update] update campaign sql : " . $sql);
	$dbconn->executeUpdate($sql);
	$dbconn->dbClose();
	$res = array("result" => "success");
	echo json_encode($res);

}