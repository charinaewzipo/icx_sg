<?php
ob_start();
session_start();
include("../function/checkSession.php");
include("../function/currentDateTime.inc");
include("../function/StartConnect.inc");
require_once("../dibi/dibi.php");
require_once("../Classes/PHPExcel.php");

try {
	$dbReport = new DibiConnection(array(
	'driver'   => 'mysql',
	'host'     => $ServerName,
	'username' => $User,
	'password' => $Password,
	'database' => $DatabaseName,
	'charset'  => 'utf8',
	'lazy'	    => true
	));

	$dbReport->query("SET character_set_client = utf8");
	$dbReport->query("SET character_set_results = utf8");
	$dbReport->query("SET character_set_connection = utf8");

	$result = $dbReport->query("SELECT * FROM `list` where active=1 order by list_id");

	$droot = "download/";


	if($result && $result->getRowCount()>0)
	{
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("../template/list_con.xls");
		$fname = "list_con_report_".strtotime("now").".xls";
		$baseRow = 8;
		$totalRow = $baseRow + $result->getRowCount();
		$dmcs = getDMC($dbReport);
		$unsuccesss = getSubLevel(array("12"),$dbReport,1);
		$ineffectives = getSubLevel(array("2","213"),$dbReport,1);
		$listloads = getValue("listload",$dbReport);
		$listuseds = getValue("listused",$dbReport);
		$listremains = getValue("listremain",$dbReport);
		$sales = getValue("sale",$dbReport,$row->list_id);
		$wrapup = getValue("getstatus",$dbReport);
		foreach ($result as $n => $row) {

			$listload = isset($listloads[$row->list_id])?$listloads[$row->list_id]:0;
			$listused = isset($listuseds[$row->list_id])?$listuseds[$row->list_id]:0;
			$listremain = isset($listremains[$row->list_id])?$listremains[$row->list_id]:0;
			$sale = isset($sales[$row->list_id]['Value'])?$sales[$row->list_id]['Value']:0;
			$afyp = isset($sales[$row->list_id]['AFYP'])?$sales[$row->list_id]['AFYP']:0;
			$dmc = 0;
			$unsuccess = 0;
			$ineffective = 0;

			foreach($dmcs as $value) {
				if(isset($wrapup[$row->list_id][$value]))
				{
					$amount = $wrapup[$row->list_id][$value];
					$dmc = $dmc + $amount->value;
				}
			}			

			foreach($unsuccesss as $value) {
				if(isset($wrapup[$row->list_id][$value]))
				{
					$amount = $wrapup[$row->list_id][$value];
					$unsuccess = $unsuccess + $amount->value;
				}
			}

			foreach($ineffectives as $value) {
				if(isset($wrapup[$row->list_id][$value]))
				{
					$amount = $wrapup[$row->list_id][$value];
					$ineffective = $ineffective + $amount->value;
				}
			}

			$dxrow = $baseRow + $n;
			$objPHPExcel->getActiveSheet()->insertNewRowBefore(($dxrow + 1),1);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$dxrow, trim($row->list_name))
						->setCellValue('B'.$dxrow, ($listused>0)?number_format(($sale/$listused)*100,2):0)
						->setCellValue('C'.$dxrow, ($listused>0)?number_format(($dmc/$listused)*100,2):0)
						->setCellValue('D'.$dxrow, ($dmc>0)?number_format(($sale/$dmc)*100,2):0)
						->setCellValue('E'.$dxrow, trim($listload))
						->setCellValue('F'.$dxrow, trim($listused))
						->setCellValue('G'.$dxrow, trim($listremain))
						->setCellValue('H'.$dxrow, trim($sale))
						->setCellValue('I'.$dxrow, ($listused>0)?number_format(($sale/$listused)*100,2):0)
						->setCellValue('J'.$dxrow, trim($afyp))
						->setCellValue('K'.$dxrow, trim($unsuccess))
						->setCellValue('L'.$dxrow, ($listused>0)?number_format(($unsuccess/$listused)*100,2):0)
						->setCellValue('M'.$dxrow, trim($sale))
						->setCellValue('N'.$dxrow, ($listused>0)?number_format(($sale/$listused)*100,2):0)
						->setCellValue('O'.$dxrow, trim($afyp))
						->setCellValue('P'.$dxrow, trim($ineffective))
						->setCellValue('Q'.$dxrow, ($listused>0)?number_format(($ineffective/$listused)*100,2):0)
				;
		}
		$objPHPExcel->getActiveSheet()->removeRow($totalRow);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($droot.$fname);
		print "<a id='linkload' class='btn btn-send' href='report/".$droot.$fname."' >Download</a></span>";
	}
	//var_dump($result);
} catch (DibiException $e) {
	print(get_class($e). ': '. $e->getMessage());
}


function getDMC($db)
{
	if($db){
		$return = array();
		$result = $db->query("SELECT wrapup_id FROM `wrapup` where active=1 and dmc=1");
		foreach ($result as $n => $row) {
				array_push($return,$row->wrapup_id);
		}
		return $return;
	} else {
		return false; 
	}
}

function getSubLevel($id,$db,$main = 0)
{
	if($db && count($id)>0){
		$lv++;
		$return = "f";
		$result = $db->query("SELECT sub_level FROM `wrapup` where wrapup_id in%in",$id);
		foreach ($result as $n => $row) {
			if(trim($row->sub_level) != "")
			{
				$return = $return.",".$row->sub_level;
			}
		}
		$return = str_replace("f,","",$return);
		$return = str_replace("f","",$return);
		$return = explode(",",$return);
		if(count($return)>0) {
			//var_dump($return);
			foreach ($id as $valueid) {
				if (($key = array_search($valueid, $return)) !== false) {
					unset($return[$key]);
				}
			}
			//var_dump($return);
			//$return = array_merge($return,getSubLevel($return,$db));
			$returnpre = getSubLevel($return,$db);
			if($returnpre != "")
			{
				$return = array_merge($return,$returnpre);
			}
			if($main) {
				$return = array_merge($id,$return);
			}
			$return = array_unique($return);
			return $return;
		} else {
			return $return;
		}
	}
	else {return false;}
}

function getValue($value,$db)
{
	if($db){
		if($value == "listload") {
			$result = $db->query("SELECT COUNT(list_dtl_id) as Value,list_id FROM `list_dtl` group by list_id");
			$return = $result->fetchPairs("list_id","Value");
			unset($result);
			return $return;
		} else if($value == "listused"){
			$result = $db->query("SELECT COUNT(A.list_dtl_id) as Value,A.list_id FROM list_dtl as A left outer join list_agent as B
										on (A.list_dtl_id=B.list_dtl_id) where B.list_status is not null group by A.list_id");
			$return = $result->fetchPairs("list_id","Value");
			unset($result);
			return $return;
		} else if($value == "listremain"){
			$result = $db->query("SELECT COUNT(A.list_dtl_id) as Value,A.list_id FROM list_dtl as A left outer join list_agent as B
										on (A.list_dtl_id=B.list_dtl_id) where B.list_status is null group by A.list_id");
			$return = $result->fetchPairs("list_id","Value");
			unset($result);
			return $return;
		} else if($value == "sale"){
			$result = $db->query("select COUNT(A.list_dtl_id) AS Value,
									SUM(case 
									when B.PaymentFrequency = 'Monthly' then B.PolicyPremium*12
									when B.PaymentFrequency = 'Annualy' then B.PolicyPremium
									else 0 end) AS AFYP,A.list_id
									from list_dtl as A inner join app_mt as B
										on (A.list_dtl_id=B.list_dtl_id) where B.RecordType='1' and B.AppStatus='Completed' group by A.list_id");
			$return = $result->fetchAssoc("list_id");
			unset($result);
			return $return;
		} else if($value == "getstatus") {
			$result = $db->query("SELECT list_id,wrapup_id,count(list_dtl_id) as value FROM `call` where call_id in(select max(call_id) from `call` group by list_dtl_id) group by  list_id,wrapup_id");
			$return = $result->fetchAssoc("list_id|wrapup_id");
			unset($result);
			return $return;
		}
	} else {
		return "";
	}
}
?>