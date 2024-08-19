<?php include "dbconn.php" ?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php
/*
    session_start();
    if(!isset($_SESSION["uid"])){
       header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
	}
	*/

if (isset($_POST['action'])) {

	switch ($_POST['action']) {

		case "importcalllist":
			import_callList();
			break;


		case "upload":
			upload();
			break;
		case "init":
			init();
			break;

			//case "import" : import(); break;

			//test 
		case "import":
			mapdbfield();
			break;

			//test2
		case "mapping":
			mappingfield();
			break;

			//show result after mapping and import data
		case "query":
			query();
			break;

			//show result from import list
		case "summaryresult":
			summary_result();
			break;

			//export list that duplicate to excel format
		case "export_excel_duplist":
			export_excel_dup();
			break;
	}
}

//import from temptable to calllist table
function import_callList()
{
	//use select insert

	$tmp = json_decode($_POST['data'], true);
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$field = array();
	$sql = "SELECT field_name FROM t_list_field WHERE list_id = " . $tmp['lid'] . " ORDER BY rowid ";
	wlog("[import_process][import_callList] sql : " . $sql);
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		// $rs['field_name'];
		array_push($field, $rs['field_name']);
	}

	$fields = implode(",", $field);


	$sql = " INSERT INTO t_calllist (" . $fields . ", `status` , import_id , create_date ) " .
		" SELECT " . $fields . " ,1, " . $tmp['impid'] . ", NOW() " .
		" FROM tmp_table" . $tmp['lid'] . " " .
		" ORDER BY seq ";
	$result = $dbconn->executeQuery($sql);
	wlog("sql : " . $sql . " [" . $result . "] ");
	$dbconn->dbClose();
	$res = array("result" => "success");
	echo json_encode($res);
}

//export duplicate record to excel file
function export_excel_dup()
{
	//		

}

function summary_result()
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

	$sql = " SELECT SUM(excel_dup) AS exceldup , SUM(callist_dup)  AS callistdup FROM tmp_table5  ";
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$rs['excel_dup'];
		$rs['callistdup'];
	}

	$sql = "SELECT FROM ";




	wlog("[call-pane_process][init] sql :" . $sql);
}

//step1 
//read excel header file
//and show with default field
//replate by init
function showExcelMapField()
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

	$excelfile_path = "";

	$sql = "  SELECT file_path   " .
		" FROM t_import_list " .
		" WHERE import_id = " . dbNumberFormat($tmp['impid']);

	//read path of excel from database
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$excelfile_path = $rs['file_path'];
	}

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Bangkok');

	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	//$fileName = "06largescale.xlsx";
	//$fileName = "callList.xls";
	//$objPHPExcel = PHPExcel_IOFactory::load("profiles/attach/".$fileName );

	$objPHPExcel = PHPExcel_IOFactory::load("profiles/attach/" . $excelfile_path);

	$worksheet = $objPHPExcel->setActiveSheetIndex(0);

	$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);


	//for ($row = 0; $row <= $highestRow; $row++) {

	//read from row 0 ( header );
	//$data = "";
	$count = 0;
	for ($col = 0; $col < $highestColumnIndex; $col++) {
		$cell = $worksheet->getCellByColumnAndRow($col, 0);
		$val = $cell->getValue();

		$data[$count] = array(
			"header"  => nullToEmpty($val)
		);
		$count++;
		/*
							if( !empty($val)){
								$data = $data."".dbformat($val).",";
							}
							*/
	}

	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

function loadlist()
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

	$sql = "  SELECT import_id , file_name , file_size , create_date  " .
		" FROM t_import_list " .
		" WHERE list_id =   " .
		" ORDER BY create_date";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$data[$count] = array(
			"impid"  => nullToEmpty($rs['import_id']),
			"filename"  => nullToEmpty($rs['file_name']),
			"filesize"  => nullToEmpty($rs['file_size']),
			"credate"  => getDatetimeFromDatetime($rs['create_date'])
		);
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}

	$dbconn->dbClose();
	echo json_encode($data);
}

//
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



	//query header
	//test concept
	$sql = " SELECT caption_name , field_name FROM t_list_field WHERE list_id = 1 " .
		" ORDER BY rowid ";

	wlog("[call-pane_process][init] sql :" . $sql);


	$field = array();

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {

		$data[$count] = array(
			"caption"  => nullToEmpty($rs['caption_name']),
		);

		array_push($field, $rs['field_name'] . " ");
		$count++;
	}
	if ($count == 0) {
		$data = array("result" => "empty");
	}



	$fields = implode(",", $field);


	//loop field_name
	for ($i = 0; $i < count($field); $i++) {
		//	echo "field[".$i."]: ".$field[$i]."<br/>";
	}


	//to string 
	//query data
	$sql = "SELECT " . $fields . " FROM t_calllist WHERE import_id = 1 ";
	//echo $sql;
	//	echo $sql;

	$result = $dbconn->executeQuery($sql);
	$count = 0;

	//abc is ok same as data output
	$abc = array();
	//test
	//loop all resut
	while ($rs = mysqli_fetch_row($result)) {
		//test
		$data[$count] = array(
			"f0"  => nullToEmpty($rs[0]),
			"f1"  => nullToEmpty($rs[1])
		);
		//end   
		//echo $rs[$i];
		$test = array();
		//loop only column
		for ($i = 0; $i < count($field); $i++) {
			$foo[$count] = array("f" . $i  => nullToEmpty($rs[$i]));
			$test = $test + $foo;
		}
		$abc = $abc + $test;
		// $data[$count]  = array_push( $test  , $datatmp );

		$count++;
	}

	echo "new <br/>";
	echo var_dump($abc);
	echo "<br/>";
	echo "old <br/>";
	echo var_dump($data);

	for ($j = 0; $j < count($abc); $j++) {
		echo $abc[$j]['f0'] . "<br/>";
	}

	//test
	/*
	
	     */
	/*
	  

			while($rs=mysqli_fetch_array($result)){   
			
	
				//get filed
			for( $i=0; $i < count($field) ; $i++){
				
						  echo $rs[ $field[$i] ];
						$i++;
					//echo $rs['first_name']."<br/>";
			}
			
			
	
	
				$count++;  
			}
			*/
	/*
				$tmp2[$count] = array(
					"f".$count  => nullToEmpty($rs[$field[$count]]),
					);   
				*/


	if ($count == 0) {
		$tmp2 = array("result" => "empty");
	}


	$dbconn->dbClose();
	echo json_encode($data);
}


//for test
function testSpeed()
{
	/*
				$i = 10;
				for( $i ; $i > 0 ; $i--){
					 echo $i."<br/>";
				}
				echo "end<br/>";
		*/
	$time_start = microtime(true);
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Bangkok');

	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$fileName = "06largescale.xlsx";
	$fileName = "callList.xls";
	$objPHPExcel = PHPExcel_IOFactory::load("profiles/attach/" . $fileName);

	//get header
	$worksheet = $objPHPExcel->setActiveSheetIndex(0);

	//tt
	$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	echo "highest column " . $highestColumnIndex . "<br/>";

	//$time = $time_end - $time_start;
	//echo 'Script load took '.$time.' seconds to execute'."<br/>";

	$time_start = microtime(true);
	//$objPHPExcel->getActiveSheet()->removeColumn('A',1);
	//$objPHPExcel->getActiveSheet()->removeColumn('A',1);
	/*
				$objPHPExcel->getActiveSheet()->removeColumn('E',1);	
				$objPHPExcel->getActiveSheet()->removeColumn('D',1);
			//$objPHPExcel->getActiveSheet()->removeColumn('B',1);
			//$test = array(0,1);
			*/
	$objPHPExcel->getActiveSheet()->removeColumnByIndex(4, 1);
	$objPHPExcel->getActiveSheet()->removeColumnByIndex(3, 1);
	$objPHPExcel->getActiveSheet()->removeColumnByIndex(2, 1);
	$objPHPExcel->getActiveSheet()->removeColumnByIndex(1, 1);
	$objPHPExcel->getActiveSheet()->removeColumnByIndex(0, 1);

	$time_end = microtime(true);
	//Subtract the two times to get seconds
	$time = $time_end - $time_start;
	echo 'Script delete  took ' . $time . ' seconds to execute' . "<br/>";
	//removeColumnByIndex

	$time_start = microtime(true);

	$count = 0;

	//get highestrow
	$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);




	echo "total row : " . $highestRow;
	echo "<br/>";
	echo "total column : " . $highestColumn;
	echo "<br/>";

	for ($row = 0; $row <= $highestRow; ++$row) {

		for ($col = 0; $col < $highestColumnIndex; ++$col) {

			$cell = $worksheet->getCellByColumnAndRow($col, $row);
			$val = $cell->getValue();
			if (!empty($val)) {
				echo $val . "|";
			}
		}
		echo "<br/>";
	}
	// $test  =   $worksheet->getCellByColumnAndRow(0, 1)->getValue();


	//Create a variable for end time
	$time_end = microtime(true);
	//Subtract the two times to get seconds
	$time = $time_end - $time_start;
	echo 'Script load took ' . $time . ' seconds to execute';
}

function mappingfield()
{

	$tmp = json_decode($_POST['data'], true);
	$mapp = json_decode($_POST['mapping'], true);

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}


	//delete current mapping list field 
	$sql = "DELETE FROM t_list_field WHERE list_id = " . dbNumberFormat($tmp['lid']) . " ";
	wlog("[import_process][mapdbfield] delete current mapping sql : " . $sql);
	$dbconn->executeUpdate($sql);

	//check if exist delete it
	$sql = "DROP TABLE IF EXISTS tmp_table" . $tmp['lid'];
	wlog("[import_process][mapdbfield] drop table  : " . $sql);
	$dbconn->executeUpdate($sql);

	//creatab is sql command for create temp table
	//insert is sql command for insert data into temp table
	$insert = "INSERT INTO tmp_table" . $tmp['lid'] . " (  seq,";

	$createtab = " CREATE TABLE tmp_table" . $tmp['lid'] . " ( seq int(7), ";
	for ($i = 0; $i < count($mapp); $i++) {
		//wlog( $mapp[$i]['key']."|".$mapp[$i]['value'] );
		if ($mapp[$i]['value'] != "0") {
			$createtab = $createtab . " " . $mapp[$i]['value'] . " varchar(255), ";
			$insert = $insert . "" . $mapp[$i]['value'] . ",";
		}
	} //end loop for

	$insert = $insert . "excel_dup,calllist_dup ) VALUES (   ";

	$createtab = $createtab . " excel_dup tinyint(1), calllist_dup tinyint(1) ";
	$createtab = $createtab . " ) ";

	wlog($createtab);
	wlog($insert);

	//create temp table
	$dbconn->executeUpdate($createtab);

	//end for prepare table for import data 


	//start process excel file
	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$sql = " SELECT file_path , file_name  " .
		" FROM t_import_list " .
		" WHERE import_id = " . dbNumberFormat($tmp['impid']);

	wlog($sql);
	//read path of excel from database
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$path_excelfile = $rs['file_path'] . "/" . $rs['file_name'];
	}

	$objPHPExcel = PHPExcel_IOFactory::load($path_excelfile);
	$worksheet = $objPHPExcel->setActiveSheetIndex(0);

	wlog("start remove column ");
	//algorithm for remove do not map field
	$i = count($mapp) - 1;
	wlog("start with length :  " . $length);
	for ($i; $i >= 0; $i--) {
		wlog("loop : i " . $i);
		wlog(" column index " . $mapp[$i]['key'] . " column name " . $mapp[$i]['value']);

		if ($mapp[$i]['value'] == "0") {
			wlog(" !!remove column index " . $mapp[$i]['key'] . " column name " . $mapp[$i]['value']);
			$objPHPExcel->getActiveSheet()->removeColumnByIndex($mapp[$i]['key'], 1);
		}
	} //end loop for


	//start read excel
	$highestRow            = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	//echo "total remain column ".$highestColumnIndex;


	// $row == 1 don't map header 
	$count = 1;
	$badlist = 0;

	wlog("[excel process] highestRow : " . $highestRow);
	wlog("[excel process] highestColumn : " . $highestColumn);
	wlog("[excel process] highestColumnIndex : " . $highestColumnIndex);


	for ($row = 2; $row <= $highestRow; ++$row) {
		$ttt = "";

		$sql = $count . ",";
		for ($col = 0; $col <= $highestColumnIndex; ++$col) {

			$cell = $worksheet->getCellByColumnAndRow($col, $row);
			$val = $cell->getValue();
			$ttt = $ttt . "| column [" . $col . "]" . $val . ";";

			if (!empty($val)) {
				$sql = $sql . "" . dbformat($val) . ",";
			}
		}

		//prepare sql statement before excecute
		$sql = $insert . $sql . " null , null )";
		wlog(" insert: " . $sql . " [ " . $result . " ]");
		$result = $dbconn->executeUpdate($sql);
		if ($result != 1) {
			$badlist++;
		}

		wlog("excel row [" . $row . "]  val : " . $ttt);
		$count++;
	}

	//check in list (excel) duplicate
	$sql = " UPDATE tmp_table" . $tmp['lid'] . " a" .
		" , ( SELECT min(seq) as seq ,first_name , last_name , tel1" .
		" FROM tmp_table" . $tmp['lid'] . "  " .
		" GROUP BY first_name , last_name , tel1 ) b" .
		" SET a.excel_dup = 1" .
		" WHERE a.first_name = b.first_name" .
		" and a.last_name = b.last_name" .
		" and a.tel1  = b.tel1  " .
		" and a.SEQ <> b.SEQ ";
	//$result = $dbconn->executeUpdate($sql);

	//check in database duplicate
	$sql = "UPDATE tmp_table5 tmp , t_calllist c" .
		" SET tmp.calllist_dup = 1 " .
		" WHERE tmp.first_name = c.first_name " .
		" and tmp.last_name = c.last_name " .
		" and tmp.tel1  = c.tel1 ";
	$result = $dbconn->executeUpdate($sql);
}


//insert or update used old algorithm delete before insert
//create temp table
//mapping field between excel and dabase
function mapdbfield()
{

	$tmp = json_decode($_POST['data'], true);
	$mapp = json_decode($_POST['mapping'], true);
	$field = json_decode($_POST['field'], true);

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}


	//delete current mapping list field 
	$sql = "DELETE FROM t_list_field WHERE list_id = " . dbNumberFormat($tmp['lid']) . " ";
	wlog("[import_process][mapdbfield] delete current mapping sql : " . $sql);
	$dbconn->executeUpdate($sql);

	//check if exist delete it
	$sql = "DROP TABLE IF EXISTS tmp_table" . $tmp['lid'];
	wlog("[import_process][mapdbfield] drop table  : " . $sql);
	$dbconn->executeUpdate($sql);

	//create temp table
	//prepare insert statement
	$data = explode(',', $field['field']);
	$sql = " CREATE TABLE tmp_table" . $tmp['lid'] . " ( seq int(7), ";
	$insert = "INSERT INTO tmp_table" . $tmp['lid'] . " (  seq,";
	for ($i = 0; $i < count($data); $i++) {
		if ($data[$i] != "0") {
			$sql = $sql . " " . $mapp[$i]['value'] . " varchar(255), ";
			$insert = $insert . "" . $data[$i] . ",";
		}
	}
	$insert = $insert . "excel_dup,calllist_dup ) VALUES (   ";
	$sql = $sql . " excel_dup tinyint(1), calllist_dup tinyint(1) ";
	$sql = $sql . " ) ";

	//create temp table
	$dbconn->executeUpdate($sql);

	wlog($sql);
	wlog($insert);

	for ($i = 0; $i < count($mapp); $i++) {
		//insert mapping list field

		$xsql =  "INSERT INTO t_list_field ( list_id , caption_name , field_name , create_user , create_date ) VALUES ( " .
			" " . dbNumberFormat($tmp['lid']) . " " .
			"," . dbformat($mapp[$i]['key']) . " " .
			"," . dbformat($mapp[$i]['value']) . " " .
			"," . dbNumberFormat($tmp['uid']) . " , NOW() )  ";

		$dbconn->executeUpdate($xsql);
	}






	//insert excel to temp table
	//can't handler insert fail !!!
	// import_temptable( $insert );

	//update in-list duplicate
	/*
			$sql = " UPDATE tmp_table".$tmp['lid']." a ".
						" , ( SELECT min(seq) as seq ,first_name , last_name , tel1 ". 
						" FROM tmp_table".$tmp['lid']." ".
						" GROUP BY first_name , last_name , tel1 ) b ".
						" SET a.excel_dup = 1".
						" WHERE a.first_name = b.first_name ".
						" and a.last_name = b.last_name ".
						" and a.tel1  = b.tel1  ";
			  wlog("[import_process][mapdbfield] check list duplicate :".$sql);
			  $dbconn->executeUpdate($sql); 
			  */
	//update in-db duplicate





	$data = array("result" => "success");
	echo json_encode($data);
	$dbconn->dbClose();
	wlog("close conn");
}

//insert excel data to temp table
function import_temptable($insert)
{

	$tmp = json_decode($_POST['data'], true);
	$field = json_decode($_POST['field'], true);
	$field = explode(',', $field['field']);

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$time_start = microtime(true);
	//	error_reporting(0);
	/*
			error_reporting(E_ALL);
			ini_set('display_errors', TRUE);
			ini_set('display_startup_errors', TRUE);
			*/
	date_default_timezone_set('Asia/Bangkok');

	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$sql = " SELECT file_path , file_name  " .
		" FROM t_import_list " .
		" WHERE import_id = " . dbNumberFormat($tmp['impid']);
	wlog($sql);
	//read path of excel from database
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$path_excelfile = $rs['file_path'] . "/" . $rs['file_name'];
	}

	$objPHPExcel = PHPExcel_IOFactory::load($path_excelfile);
	$worksheet = $objPHPExcel->setActiveSheetIndex(0);

	//algorithm for remove do not map field
	$i = count($field) - 1;
	/*
				$del = "";
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
			   	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					*/

	wlog("count maximum selected field : " . $i);

	//$objPHPExcel->getActiveSheet()->removeColumn('A',1);

	$objPHPExcel->getActiveSheet()->removeColumn('E', 1);
	$objPHPExcel->getActiveSheet()->removeColumn('D', 1);
	$objPHPExcel->getActiveSheet()->removeColumn('C', 1);
	$objPHPExcel->getActiveSheet()->removeColumn('B', 1);
	$objPHPExcel->getActiveSheet()->removeColumn('A', 1);
	/*
					$objPHPExcel->getActiveSheet()->removeColumnByIndex( 0 ,1);
				
					$objPHPExcel->getActiveSheet()->removeColumnByIndex( 1 ,1);
					//test
					/*
					$objPHPExcel->getActiveSheet()->removeColumnByIndex(6 ,1);
						$objPHPExcel->getActiveSheet()->removeColumnByIndex( 5 ,1);
						$objPHPExcel->getActiveSheet()->removeColumnByIndex( 4 ,1);
						$objPHPExcel->getActiveSheet()->removeColumnByIndex( 3 ,1);
						$objPHPExcel->getActiveSheet()->removeColumnByIndex( 2 ,1);
						$objPHPExcel->getActiveSheet()->removeColumnByIndex( 1 ,1);
						$objPHPExcel->getActiveSheet()->removeColumnByIndex( 0 ,1);
					*/
	//	$objPHPExcel->getActiveSheet()->removeColumnByIndex( $i ,1);

	for ($i; $i >= 0; $i--) {
		wlog("start loop i [" . $i . "]");


		if ($field[$i] == "0") {
			wlog("remove field " . $field[$i]);

			//remove do not map field
			// solution remove from max value to min value 
			$objPHPExcel->getActiveSheet()->removeColumnByIndex($i, 1);
			//$del = $del."|".$data[$i];	
			//echo "delete : ".$i."<br/>";
		}
	}

	//after remove column finished
	//start import data 
	$highestRow            = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	//echo "total remain column ".$highestColumnIndex;


	// $row == 1 don't map header 
	$count = 1;
	$badlist = 0;

	wlog("[excel process] highestRow : " . $highestRow);
	wlog("[excel process] highestColumn : " . $highestColumn);
	wlog("[excel process] highestColumnIndex : " . $highestColumnIndex);

	for ($row = 2; $row <= $highestRow; $row++) {
		//clear
		$data = $count . ",";
		for ($col = 0; $col < $highestColumnIndex; $col++) {

			$cell = $worksheet->getCellByColumnAndRow($col, $row);
			$val = $cell->getValue();
			if ($field[$col] != "0") {
				wlog("[excel process] process on column : [" . $col . "] row : [" . $row . "] value : " . $val);
				if (!empty($val)) {
					//echo $val."|";
					//$data = $data."".dbformat($val).",";
				}
			}
			if (!empty($val)) {
				//echo $val."|";
				$data = $data . "" . dbformat($val) . ",";
			} else {
				//	$data = $data." null ,";
			}
		}
		//echo "<br/>";
		$data = $data . " null , null )";
		$sql = $insert . $data;

		$result = $dbconn->executeUpdate($sql);
		if ($result != 1) {
			$badlist++;
		}

		//if result != 1 Error
		//bad value  , bad syntax
		wlog(" insert: " . $sql . " [ " . $result . " ]");
		$count++;
	}

	//update  import_list info
	$sql = " UPDATE t_import_list SET " .
		" total_records = " . dbNumberFormat($count) . " , " .
		" bad_list = " . dbNumberFormat($badlist) . " " .
		" inlist_dup = ( SELECT COUNT(excel_dup) from tmp_table" . $tmp['lid'] . " )" .
		" indb_dup = ( SELECT COUNT(calllist_dup) from tmp_table" . $tmp['lid'] . " )" .
		" WHERE import_id = " . dbNumberFormat($tmp['impid']);
	$dbconn->executeUpdate($sql);
}




//import();
//algorithm read excel data then import to db
function import()
{


	$tmp = json_decode($_POST['field'], true);
	$data = explode(',', $tmp['field']);

	//mapping
	$time_start = microtime(true);
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Bangkok');

	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$fileName = "callList.xls";
	$objPHPExcel = PHPExcel_IOFactory::load("profiles/attach/" . $fileName);

	//$objPHPExcel->setReadDataOnly(true);
	//get header
	$worksheet = $objPHPExcel->setActiveSheetIndex(0);


	$time_start = microtime(true);

	$count = 0;


	$testd = "";


	//algorithm for remove do not map field
	$i = count($data) - 1;
	$del = "";
	$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	//	echo "total before column ".$highestColumnIndex;


	for ($i; $i > 0; $i--) {
		if ($data[$i] == "0") {
			//remove do not map field
			// solution remove from max value to min value 
			$objPHPExcel->getActiveSheet()->removeColumnByIndex($i, 1);
			//$del = $del."|".$data[$i];	
			//echo "delete : ".$i."<br/>";
		}
	}

	//after remove column finished
	//start import data 
	$highestRow            = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	//echo "total remain column ".$highestColumnIndex;



	//	echo "test: ".$testd;

	$testd = "";
	$sql = "INSERT INTO t_calllist ( import_id , ";
	for ($i = 0; $i < count($data); $i++) {
		if ($data[$i] != "0") {
			$sql = $sql . "" . $data[$i] . ",";
		}
	}
	$sql = $sql . " create_date ) VALUES ( 1 ,  ";


	/*
		echo "total row : ".$highestRow;
		echo "<br/>";
		echo "total column : ".$highestColumn;
		echo "<br/>";
		*/
	$data = "";

	//get highestrow
	$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

	/*
	  	echo "total row : ".$highestRow;
		echo "<br/>";
		echo "total column : ".$highestColumn;
		echo "<br/>";
	  	*/

	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}



	// $row == 1 donot map header 
	for ($row = 1; $row <= $highestRow; $row++) {

		//clear
		$data = "";
		for ($col = 0; $col < $highestColumnIndex; $col++) {
			$cell = $worksheet->getCellByColumnAndRow($col, $row);
			$val = $cell->getValue();
			if (!empty($val)) {
				//echo $val."|";
				$data = $data . "" . dbformat($val) . ",";
			}
		}
		//echo "<br/>";
		$data = $data . " NOW() )";
		$x = $sql . $data;

		//test insert data here;
		//	echo $sql;
		echo $sql;


		//	$dbconn->executeUpdate($x);


	}

	$dbconn->dbClose();

	// $test  =   $worksheet->getCellByColumnAndRow(0, 1)->getValue();
	//echo $testd;

	//Create a variable for end time
	$time_end = microtime(true);
	//Subtract the two times to get seconds
	$time = $time_end - $time_start;
	//echo 'Script load took '.$time.' seconds to execute';

	$count = 0;

	$res = array("result" => "sql " . $sql);

	echo json_encode($res);

	//row loop
	/*
		foreach ($worksheet->getRowIterator() as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);
		
				//cell loop
				$index = 0;
				foreach( $cellIterator as $key => $cell ){
				 //0,1,3	
				    
				//	   echo $key;
				//	 echo $cell->getValue();
				
				      
				}
				
				 foreach ($cellIterator as $cell){
				 	
				 	echo $index;
				 	echo $cell->getIndex();
				 
					 		$tmp2[$count] = array(
				  				"seq" => nullToEmpty($count),
				  				"value" => nullToEmpty($cell->getValue())
							);   
							$count++;  
				
				 	
				 	$index++;
			   		//	 echo 'value: ' . $cell->getValue() . '' . "<br/>";
				  }
	  	      
		
		}
			*/

	//$data = array("init"=>$tmp1,"header" => $tmp2 );		 	
	//echo json_encode( $data ); 

	//$dbconn->dbClose();	 



}




//ok
// show excel header and mapping field
function init()
{

	//mapping field
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$excelfile_path = "";

	$tmp = json_decode($_POST['data'], true);

	//init system field 
	$sql = " SELECT field_name , field_alias_name " .
		" FROM  ts_field_list " .
		" WHERE status = 1 ";

	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1[$count] = array(
			"id" => nullToEmpty($rs['field_name']),
			"alias" => nullToEmpty($rs['field_alias_name']),
		);
		$count++;
	}

	$sql = "  SELECT file_path , file_name  " .
		" FROM t_import_list " .
		" WHERE import_id = " . dbNumberFormat($tmp['impid']);


	//read path of excel from database
	$result = $dbconn->executeQuery($sql);
	if ($rs = mysqli_fetch_array($result)) {
		$excelfile_path = $rs['file_path'] . "/" . $rs['file_name'];
	}

	//mapping
	$time_start = microtime(true);
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Bangkok');

	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	//$fileName = "callList.xls";
	//$objPHPExcel = PHPExcel_IOFactory::load("profiles/attach/".$fileName );
	wlog($excelfile_path);
	$objPHPExcel = PHPExcel_IOFactory::load($excelfile_path);


	//get header
	$worksheet = $objPHPExcel->setActiveSheetIndex(0);



	$count = 0;
	foreach ($worksheet->getRowIterator() as $row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);

		foreach ($cellIterator as $cell) {
			$tmp2[$count] = array(
				"seq" => nullToEmpty($count),
				"value" => nullToEmpty($cell->getValue())
			);
			$count++;

			//	 echo 'value: ' . $cell->getValue() . '' . "<br/>";
		}

		break;
	}


	$data = array("init" => $tmp1, "header" => $tmp2);
	echo json_encode($data);

	$dbconn->dbClose();
}


function upload()
{

	if (!empty($_FILES)) {
		/*
    	  $path = $_POST['data'];
    	  if($path=="profiles"){
    	  	  $targetPath ='profiles/';
    	  	  
    	  }else{
    	  	  $targetPath ='attach/'.$path.'';
    	  }
    	  */

		$targetPath = dirname(__FILE__) . '/attach/';

		$tempFile = $_FILES['file']['tmp_name'];

		$targetFile = $targetPath . $_FILES['file']['name'];
		move_uploaded_file($tempFile, $targetFile);

		//upload security 

		$info = pathinfo($targetFile);
		// echo( $info["extension"] ); 

		// $userimg = $uid.".".$info["extension"]; 

		//create myown name
		//echo $userimg;
		// move_uploaded_file($userimg, $targetFile);
		// save data in database (if you like!)



		//save( $targetFile );

	}
}

function testExcel()
{


	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Bangkok');

	//echo dirname(__FILE__);
	/** PHPExcel */
	//require_once 'plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$fileName = "callList.xls";
	$objPHPExcel = PHPExcel_IOFactory::load("attach/" . $fileName);

	$lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
	echo $lastRow;

	/*
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				
					$highestRow         = $worksheet->getHighestRow(); // e.g. 10
					$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				
			}
			*/

	//mapping field
	$dbconn = new dbconn;
	$dbconn->createConn();
	$res = $dbconn->createConn();
	if ($res == 404) {
		$res = array("result" => "dberror", "message" => "Can't connect to database");
		echo json_encode($res);
		exit();
	}

	$sql = " SELECT field_id , field_alias_name " .
		" FROM  ts_field_list " .
		" WHEE status = 1 ";


	$count = 0;
	$result = $dbconn->executeQuery($sql);
	while ($rs = mysqli_fetch_array($result)) {
		$tmp1[$count] = array(
			"id" => nullToEmpty($rs['field_id']),
			"alias" => nullToEmpty($rs['field_alias_name']),
		);
		$count++;
	}
}


function mapping()
{
	//Create a variable for start time
	$time_start = microtime(true);
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Bangkok');

	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$fileName = "callList.xls";
	$objPHPExcel = PHPExcel_IOFactory::load("profiles/attach/" . $fileName);

	//get header
	$worksheet = $objPHPExcel->setActiveSheetIndex(0);

	foreach ($worksheet->getRowIterator() as $row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		foreach ($cellIterator as $cell) {
			echo 'value: ' . $cell->getValue() . '' . "<br/>";
		}

		break;
	}
} //end function mapping

function insertdb()
{


	//Create a variable for start time
	$time_start = microtime(true);

	//https://blog.mayflower.de/561-Import-and-export-data-using-PHPExcel.html

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Bangkok');

	//echo dirname(__FILE__);
	/** PHPExcel */
	//require_once 'plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	require_once dirname(__FILE__) . '/app/PHPExcel/Classes/PHPExcel.php';

	$fileName = "callList.xls";
	$objPHPExcel = PHPExcel_IOFactory::load("profiles/attach/" . $fileName);


	$lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
	echo "maximum row: " . $lastRow . "<br/>";


	//require_once 'import /PHPExcel_1.7.8/Classes/PHPExcel/IOFactory.php';
	//require_once dirname(__FILE__) . '/plugin/PHPExcel1.8.0/Classes/PHPExcel.php';
	//$objPHPExcel = PHPExcel_IOFactory::load("uploads/".$fileName );

	/*
	$sheet = $objPHPExcel->getActiveSheet();
	foreach($rowIterator as $row){
		  $rowIndex = $row->getRowIndex ();
		
	}
	*/

	//get header
	$worksheet = $objPHPExcel->setActiveSheetIndex(0);

	foreach ($worksheet->getRowIterator() as $row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		foreach ($cellIterator as $cell) {
			echo 'value: ' . $cell->getValue() . '' . "<br/>";
		}

		break;
	}

	echo "<br/><br/>";
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		$worksheetTitle     = $worksheet->getTitle();
		$highestRow         = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		$nrColumns = ord($highestColumn) - 64;
		///echo "<br>The worksheet ".$worksheetTitle." has ";
		////echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
		//echo ' and ' . $highestRow . ' row.';
		//echo '<br> <table border="1"><tr>'; 
		//if insert fail what r u doing!!!

		//	$dbconn = new dbconn;	
		//$ignore_header = true;
		$success = 1;
		//dont' understand why start at 1
		for ($row = 1; $row <= $highestRow; ++$row) {
			//echo '<tr>';
			echo "row";
			//read header 
			for ($col = 0; $col < $highestColumnIndex; ++$col) {
				$cell = $worksheet->getCellByColumnAndRow($col, $row);
				$val = $cell->getValue();

				echo "field : " . $val . "<br/>";
			}

			if ($success == 1) {
				break;
			}
			$success++;
			/*
			$cellData = array();
			for ($col = 0; $col < $highestColumnIndex; ++ $col) {
				$cell = $worksheet->getCellByColumnAndRow($col, $row);
				$val = $cell->getValue();
				//$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
				//cho '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
				  //echo '<td>' . $val .'</td>';
				  array_push ( $cellData, $val );
				   
			}
			//echo '</tr>';
			$import_id = 1;
	        $import_userid = 22;
		 
		 
					if( isset($cellData[0]) && isset($cellData[1]) && isset($cellData[2]) && isset($cellData[3]) && isset($cellData[4]) ){
					//	echo "<br/> check empty[0] ".$cellData[0]."".$cellData[1]."".$cellData[2]."".$cellData[3]."".$cellData[4]."";
					  $sql = " INSERT INTO out_calllist( import_id, first_name , last_name , tel1 , tel2 , address , import_dt , import_userid ) VALUES ( ". "  
							   ".$import_id.",
							   ".dbformat( $cellData[0] ).",
							   ".dbformat( $cellData[1] ).",
							   ".dbformat( $cellData[2]).",
							   ".dbformat( $cellData[3]).",
							   ".dbformat( $cellData[4]).",
							   NOW() ,
							   ".$import_userid.")  ";
						$dbconn->executeUpdate($sql); 
						$success = $success +1;
					  
					}
					*/
		} //end for2



		echo "<br/> record success : " . $success . "<br/>";
		//$dbconn->dbClose(); 
		//echo '</table>';  
		//echo 'end loop--------------------------------------';

	}

	//Create a variable for end time
	$time_end = microtime(true);
	//Subtract the two times to get seconds
	$time = $time_end - $time_start;
	echo 'Script took ' . $time . ' seconds to execute';
}
