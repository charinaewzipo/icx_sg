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

	$result = $dbReport->query("select *,concat(Firstname,' ',Lastname) Fullname 
	from app_mt where RecordType='1' and AppStatus='Completed' and Sale_Date between ?",str_replace("-","",$_REQUEST['start_date'])," and ?",str_replace("-","",$_REQUEST['end_date'])," order by SalesOrderDate  asc");

	$droot = "download/";


	if($result && $result->getRowCount()>0)
	{
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("../template/sale_temp.xls");
		$fname = "sale_report_".strtotime("now").".xls";
		$baseRow = 2;
		$totalRow = $baseRow + $result->getRowCount();
		foreach ($result as $n => $row) {
			$dxrow = $baseRow + $n;
			$objPHPExcel->getActiveSheet()->insertNewRowBefore(($dxrow + 1),1);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$dxrow, trim($row->X_referencepolicynumber))
						->setCellValue('B'.$dxrow, trim($row->Fullname))
						->setCellValue('C'.$dxrow, trim($row->BenefitLevel))
						->setCellValue('D'.$dxrow, trim($row->PolicyPremium))
						->setCellValue('E'.$dxrow, getAgentName($dbReport,trim($row->Owner)))
						->setCellValue('F'.$dxrow, trim($row->SalesOrderDate));
			
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




function getAgentName($db,$userid)
{
	if($db){
		$result = $db->fetchSingle("select concat(first_name,' ',last_name) tsrname from staff where staff_id=?",$userid);
		return $result;
	} else {
		return "";
	}
}
?>