<?php include "dbconn.php" ?>
<?php include "util.php" ?>
<?php include "wlog.php" ?>
<?php

if (isset($_POST['action'])) {

	switch ($_POST['action']) {
		case "query":
			query();
			break;
		case "save":
			save();
			break;
	}
}

function get_role($dbconn){
	$sql = " SELECT role_name,role_label,role_lv " .
		" FROM tl_role " .
		" WHERE status = 1 " .
		" ORDER BY role_seq ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp2[$count] = array(
			"name" => nullToEmpty($rs['role_name']),
			"label" => nullToEmpty($rs['role_label']),
			"lv" => nullToEmpty($rs['role_lv'])
		);
		$count++;
	}
	if ($count == 0) {
		$tmp2 = false;
	}
	return $tmp2;
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

	$role = get_role($dbconn);

	$role_names = array_column($role, 'name');

	$sel_name = implode(",",array_map(function($a){
		return "lv_".$a;
	},$role_names));

	$array_names = array_map(function($a){
		return array("lv_".$a,"lv".$a,$a);
	},$role_names);

	$sql = " SELECT module_id,module_name,app_name,$sel_name " .
		" FROM tl_module " .
		" WHERE status = 1 " .
		" ORDER BY module_seq ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1[$count] = array(
			"mid" => nullToEmpty($rs['module_id']),
			"mname" => nullToEmpty($rs['module_name']),
			"appname" => nullToEmpty($rs['app_name'])
		);
		$roles_arr = array();
		foreach ($array_names as $name){
			$roles_arr[$name[2]] = nullToZero($rs[$name[0]]);
		}
		$tmp1[$count] = array_merge($tmp1[$count],array("role" => $roles_arr));
		$count++;
	}
	if ($count == 0) {
		$tmp1 = array("result" => "empty");
	}

	

	$dbconn->dbClose();
	echo json_encode(array("level"=>$tmp1, "role"=>$role));

}

function save()
{

	$tmp = json_decode($_POST['data'], true);

	$dbconn = new dbconn;
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "error", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$role = get_role($dbconn);
	$role_names = array_column($role, 'name');
	$array_names = array_map(function($a){
		return array("lv_".$a,$a);
	},$role_names);

	for ($i = 0; $i < count($tmp['data']); $i++) {
		$sql = " UPDATE tl_module SET ";

		foreach($array_names as $name){
			$sql .= " ".$name[0]." =" . nullToZero($tmp['data'][$i][$name[1]]) . ",";
		}
		$sql = substr($sql,0,-1);
		$sql .=	" WHERE module_id = " . dbNumberFormat($tmp['data'][$i]['appid']) . " ";

		wlog("[permission_process][save] sql " . $sql);
		$dbconn->executeUpdate($sql);
	}

	$dbconn->dbClose();
	$res = array("result" => "success");
	echo json_encode($res);


}


?>