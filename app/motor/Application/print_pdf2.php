<?php

include("../../function/StartConnect.inc");

$today = 'วันที่ '.date("d/m/Y");

$Firstname = $_POST["Firstname"];
$Lastname = $_POST["Lastname"];

$car_brand = $_POST["car_brand"];
$car_model = $_POST["car_model"];

$car_cover = $_POST["car_cover"];

$car_license = $_POST["car_license"];
$body_no = $_POST["body_no"];
$engine_no = $_POST["engine_no"];
$car_regit_year = $_POST["car_regit_year"];

$car = $car_brand.' '.$car_model ;


$AddressNo1 = $_POST["AddressNo1"];
$building1 = $_POST["building1"];
$Moo1 = $_POST["Moo1"];
$Soi1 = $_POST["Soi1"];
$Road1 = $_POST["Road1"];
$Sub_district1 = $_POST["Sub_district1"];
$district1 = $_POST["district1"];
$province1 = $_POST["province1"];
$zipcode1 = $_POST["zipcode1"];
$Mobile1 = $_POST["Mobile1"];

if($AddressNo1 != ''){
	$AddressNo = ''.$AddressNo1 ;
}
if($Moo1 != ''){
	$Moo = ' ม.'.$Moo1 ;
}
if($Soi1 != ''){
	$Soi = ' ซ.'.$Soi1 ;
}
if($Road1 != ''){
	$Road = ' ถ.'.$Road1 ;
}
if($Sub_district1 != ''){
	$Sub_district = ' '.$Sub_district1 ;
}
if($district1 != ''){
	$district = ' '.$district1 ;
}
if($Mobile1 != ''){
	$Mobile = ' โทร '.$Mobile1 ;
}

$address = $AddressNo.' '.$building1.$Moo.$Soi.$Road.$Sub_district.$district.' '.$province1.' '.$zipcode1.' '.$Mobile ;

$custname = 'คุณ'.$Firstname.' '.$Lastname ;


$data_insure1 = $_POST["insure"][0];
$data_insure2 = $_POST["insure"][1];
$data_insure3 = $_POST["insure"][2];

$SQL_Insure1 = "SELECT * FROM t_motor_premium WHERE id = '$data_insure1' ";
		$result= mysql_query($SQL_Insure1);
		while($objResult = mysql_fetch_array($result))
		{
			$insurer1 = $objResult["insurer"] ;
			$sum_insured_end1 = number_format($objResult["sum_insured_end"]) ;

			$cover_person1 = number_format($objResult["cover_person"]) ;
			$cover_bodylife1 = number_format($objResult["cover_bodylife"]) ;
			$cover_asset1 = number_format($objResult["cover_asset"]) ;
			
			$cover_pa1 = number_format($objResult["cover_pa"]) ;
			$cover_medical_free1 = number_format($objResult["cover_medical_free"]) ;
			$cover_bail_out1 = number_format($objResult["cover_bail_out"]) ;
			
			$premium_type_1_DG = $objResult["premium_type_1_DG"] ;
			$premium_type_1_OG = $objResult["premium_type_1_OG"] ;
			$premium_type_2 = $objResult["premium_type_2"] ;
			$premium_type_2P = $objResult["premium_type_2P"] ;
			$premium_type_3 = $objResult["premium_type_3"] ;
			$premium_type_3P = $objResult["premium_type_3P"] ;
			
			if($premium_type_1_DG != ''){
				$premium_total = ($premium_type_1_DG) ;
				$insurer_type = 'ชั้น 1 ซ่อมห้าง' ;
			}
			if($premium_type_1_OG != ''){
				$premium_total = ($premium_type_1_OG) ;
				$insurer_type = 'ชั้น 1 ซ่อมอู่' ;
			}
			if($premium_type_2 != ''){
				$premium_total = ($premium_type_2) ;
				$insurer_type = 'ชั้น 2' ;
			}
			if($premium_type_2P != ''){
				$premium_total = ($premium_type_2P) ;
				$insurer_type = 'ชั้น 2+' ;
			}
			if($premium_type_3 != ''){
				$premium_total = ($premium_type_3) ;
				$insurer_type = 'ชั้น 2' ;
			}
			if($premium_type_3P != ''){
				$premium_total = ($premium_type_3P) ;
				$insurer_type = 'ชั้น 3+' ;
			}
			
			$premium_net = number_format($premium_total / 1.07428) ;
			
			
			$car_type = $objResult["car_type"] ;
			switch ($car_type) {
    			case "110":
        			$premium_prb = "645.21";
        			break;
    			case "320":
        			$premium_prb = "967.28";
        			break;
   				case "210":
        			$premium_prb = "967.28";
        			break;
				case "220":
        			$premium_prb = "1182.35";
        			break;
				case "230":
        			$premium_prb = "2493.28";
        			break;
			}
			
			$premium_sum = $premium_total + $premium_prb;	
			$premium_sum = number_format($premium_sum);
			$premium_total = number_format($premium_total);	
			
			
		}
		

$SQL_Insure2 = "SELECT * FROM t_motor_premium WHERE id = '$data_insure2' ";
		$result= mysql_query($SQL_Insure2);
		while($objResult = mysql_fetch_array($result))
		{
			$insurer2 = $objResult["insurer"] ;
			$sum_insured_end2 = number_format($objResult["sum_insured_end"]) ;

			$cover_person2 = number_format($objResult["cover_person"]) ;
			$cover_bodylife2 = number_format($objResult["cover_bodylife"]) ;
			$cover_asset2 = number_format($objResult["cover_asset"]) ;
			
			$cover_pa2 = number_format($objResult["cover_pa"]) ;
			$cover_medical_free2 = number_format($objResult["cover_medical_free"]) ;
			$cover_bail_out2 = number_format($objResult["cover_bail_out"]) ;
			
			$premium_type_1_DG2 = $objResult["premium_type_1_DG"] ;
			$premium_type_1_OG2 = $objResult["premium_type_1_OG"] ;
			$premium_type_22 = $objResult["premium_type_2"] ;
			$premium_type_2P2 = $objResult["premium_type_2P"] ;
			$premium_type_32 = $objResult["premium_type_3"] ;
			$premium_type_3P2 = $objResult["premium_type_3P"] ;
			
			if($premium_type_1_DG2 != ''){
				$premium_total2 = ($premium_type_1_DG2) ;
				$insurer_type2 = 'ชั้น 1 ซ่อมห้าง' ;
			}
			if($premium_type_1_OG2 != ''){
				$premium_total2 = ($premium_type_1_OG2) ;
				$insurer_type2 = 'ชั้น 1 ซ่อมอู่' ;
			}
			if($premium_type_22 != ''){
				$premium_total2 = ($premium_type_22) ;
				$insurer_type2 = 'ชั้น 2' ;
			}
			if($premium_type_2P2 != ''){
				$premium_total2 = ($premium_type_2P2) ;
				$insurer_type2 = 'ชั้น 2+' ;
			}
			if($premium_type_32 != ''){
				$premium_total2 = ($premium_type_32) ;
				$insurer_type2 = 'ชั้น 3' ;
			}
			if($premium_type_3P2 != ''){
				$premium_total2 = ($premium_type_3P2) ;
				$insurer_type2 = 'ชั้น 3+' ;
			}
			
			$premium_net2 = number_format($premium_total2 / 1.07428) ;
			
			$car_type2 = $objResult["car_type"] ;
			switch ($car_type2) {
    			case "110":
        			$premium_prb2 = "645.21";
        			break;
    			case "320":
        			$premium_prb2 = "967.28";
        			break;
   				case "210":
        			$premium_prb2 = "967.28";
        			break;
				case "220":
        			$premium_prb2 = "1182.35";
        			break;
				case "230":
        			$premium_prb2 = "2493.28";
        			break;
			}
			
			$premium_sum2 = $premium_total2 + $premium_prb2;	
			$premium_sum2 = number_format($premium_sum2);
			$premium_total2 = number_format($premium_total2);	
			
			
		}

$SQL_Insure3 = "SELECT * FROM t_motor_premium WHERE id = '$data_insure3' ";
		$result= mysql_query($SQL_Insure3);
		while($objResult = mysql_fetch_array($result))
		{
			$insurer3 = $objResult["insurer"] ;
			$sum_insured_end3 = number_format($objResult["sum_insured_end"]) ;

			$cover_person3 = number_format($objResult["cover_person"]) ;
			$cover_bodylife3 = number_format($objResult["cover_bodylife"]) ;
			$cover_asset3 = number_format($objResult["cover_asset"]) ;
			
			$cover_pa3 = number_format($objResult["cover_pa"]) ;
			$cover_medical_free3 = number_format($objResult["cover_medical_free"]) ;
			$cover_bail_out3 = number_format($objResult["cover_bail_out"]) ;
			
			$premium_type_1_DG3 = $objResult["premium_type_1_DG"] ;
			$premium_type_1_OG3 = $objResult["premium_type_1_OG"] ;
			$premium_type_23 = $objResult["premium_type_2"] ;
			$premium_type_2P3 = $objResult["premium_type_2P"] ;
			$premium_type_33 = $objResult["premium_type_3"] ;
			$premium_type_3P3 = $objResult["premium_type_3P"] ;
			
			if($premium_type_1_DG3 != ''){
				$premium_total3 = ($premium_type_1_DG3) ;
				$insurer_type3 = 'ชั้น 1 ซ่อมห้าง' ;
			}
			if($premium_type_1_OG3 != ''){
				$premium_total3 = ($premium_type_1_OG3) ;
				$insurer_type3 = 'ชั้น 1 ซ่อมอู่' ;
			}
			if($premium_type_23 != ''){
				$premium_total3 = ($premium_type_23) ;
				$insurer_type3 = 'ชั้น 2' ;
			}
			if($premium_type_2P3 != ''){
				$premium_total3 = ($premium_type_2P3) ;
				$insurer_type3 = 'ชั้น 2+' ;
			}
			if($premium_type_33 != ''){
				$premium_total3 = ($premium_type_33) ;
				$insurer_type3 = 'ชั้น 3' ;
			}
			if($premium_type_3P3 != ''){
				$premium_total3 = ($premium_type_3P3) ;
				$insurer_type3 = 'ชั้น 3+' ;
			}
			
			
			$premium_net3 = number_format($premium_total3 / 1.07428) ;
			
			
			$car_type3 = $objResult["car_type"] ;
			switch ($car_type) {
    			case "110":
        			$premium_prb3 = "645.21";
        			break;
    			case "320":
        			$premium_prb3 = "967.28";
        			break;
   				case "210":
        			$premium_prb3 = "967.28";
        			break;
				case "220":
        			$premium_prb3 = "1182.35";
        			break;
				case "230":
        			$premium_prb3 = "2493.28";
        			break;
			}
	
			$premium_sum3 = $premium_total3 + $premium_prb3;	
			$premium_sum3 = number_format($premium_sum3);
			$premium_total3 = number_format($premium_total3);	
			
		}


	if($car_cover != ''){
		
		$sum_insured_end3 = number_format($car_cover) ;
		$sum_insured_end2 = number_format($car_cover) ;
		$sum_insured_end1 = number_format($car_cover) ;	
	}

require('fpdf.php');

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Simple table
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40, 35, 40, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}


$pdf = new PDF();

// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsana','','angsa.php');
 
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsana','B','angsab.php');
 
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsana','I','angsai.php');
 
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsana','BI','angsaz.php');
 
//สร้างหน้าเอกสาร
$pdf->AddPage();

$pdf->Image('images/logo_ark.png',15,8,30,0,'','');
 
// Header
$pdf->SetFont('angsana','',12);
$pdf->setXY( 50, 20  );
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'ARK Insure Broker Co., Ltd. 288/3     Soi Rung Rueang, Ratchadaphisek Rd., Samsen Nok,' ) );

$pdf->setXY( 50, 25  );
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Huai Khwang, Bangkok 10310 t. +66 2159 8855  f. +66 2275 8839' ) );

$pdf->SetFont('angsana','B',14);
$pdf->setXY( 150, 40  );
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $today )  );
 
$pdf->SetFont('angsana','B',14);
$pdf->setXY( 15, 50  );
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'ข้อเสนอ        เบี้ยประกันภัยรถยนต์' )  );
 
$pdf->SetFont('angsana','B',14);
$pdf->setXY( 15, 57  );
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'เรียน             '.$custname  )  );

$pdf->SetFont('angsana','',14);
$pdf->setXY( 15, 64 );
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'ที่อยู่             '.$address  )  );


// Footer
$pdf->SetFont('angsana','',14);
$pdf->setXY( 50, 250  );
$pdf->Cell( 0  , 5 , iconv( 'UTF-8','cp874' , 'จึงเรียนมาเพื่อโปรดพิจารณา' ),0,1,'L'  );

$pdf->SetFont('angsana','',14);
$pdf->setXY( 50, 258  );
$pdf->Cell( 0  , 5 , iconv( 'UTF-8','cp874' , 'หากท่านมีข้อสงสัย กรุณาติดต่อหมายเลข 02-159-8855 ต่อ 3503 คุณพัชรา' ),0,1,'L'  );

$pdf->SetFont('angsana','',14);
$pdf->setXY( 150, 270  );
$pdf->Cell( 0  , 5 , iconv( 'UTF-8','cp874' , 'ขอแสดงความนับถือ' ),0,1,'L'  );

$col1 = '90';
$col2 = '30';
$col3 = '30';
$col4 = '30';

// container
$pdf->SetFont('angsana','',14);
$pdf->setXY( 15, 72 );    
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'ยี่ห้อ                               รุ่น                               ปีจดทะเบียน       ทะเบียน         เลขเครื่องยนต์                         เลขตัวถัง '  )  );

$pdf->SetFont('angsana','',14);
$pdf->setXY( 15, 75  );
$pdf->Cell( 30 , 10 , iconv( 'UTF-8','cp874' , $car_brand  ), 1 , '', 'C' );
$pdf->Cell( 30  , 10 , iconv( 'UTF-8','cp874' , $car_model ) , 1 , '' , 'C');
$pdf->Cell( 20  , 10 , iconv( 'UTF-8','cp874' , $car_regit_year ) , 1 , '' , 'C');
$pdf->Cell( 20 , 10 , iconv( 'UTF-8','cp874' , $car_license ) , 1 , '', 'C' );
$pdf->Cell( 40  , 10 , iconv( 'UTF-8','cp874' , $engine_no ) , 1 , '' , 'C');
$pdf->Cell( 40 , 10 , iconv( 'UTF-8','cp874' , $body_no ) , 1 , 1 , 'C' );

$pdf->SetFont('angsana','B',14);
$pdf->setXY( 15, 90  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ความคุ้มครอง' ), 1 , '', 'C' );
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $insurer3 ) , 1 , '' , 'C');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $insurer2 ) , 1 , '' , 'C');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $insurer1 ) , 1 , 1 , 'C' );

$pdf->SetFont('angsana','',14);
$pdf->setXY( 15, 100  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ประเภทความคุ้มครอง' ),'LR',0,'C');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $insurer_type3 ),'LR',0,'C');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $insurer_type2) ,'LR',0,'C');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $insurer_type ) ,'LR',0,'C');

$pdf->SetFont('angsana','',14);
$pdf->setXY( 15, 110  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ความคุ้มครองความรับผิดชอบต่อบุคคลภายนอก' ),'LR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , '' ),'LR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , '' ) ,'LR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , '' ) ,'LR',0,'R');

$pdf->setXY( 15, 120  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ความเสียหายต่อชีวิตร่างการ / อนามัย / คน' ),'LR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $cover_person3 ),'LR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $cover_person2 ) ,'LR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $cover_person1 ) ,'LR',0,'R');

$pdf->setXY( 15, 130  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ความเสียหายต่อชีวิต / อนามัย / ครั้ง' ),'LR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $cover_bodylife3 ),'LR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $cover_bodylife2 ) ,'LR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $cover_bodylife1 ) ,'LR',0,'R');

$pdf->setXY( 15, 140  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ความเสียหายต่อทรัพย์สิน / ครั้ง' ),'LR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $cover_asset3 ),'LR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $cover_asset2 ) ,'LR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $cover_asset1 ) ,'LR',0,'R');

$pdf->setXY( 15, 150  );
$pdf->Cell( $col1  , 20 , iconv( 'UTF-8','cp874' , 'ความคุ้มครองตามกรมธรรม์แนบท้าย' ),'LR',0,'L');
$pdf->Cell( $col2  , 20 , iconv( 'UTF-8','cp874' , '' ),'LR',0,'R');
$pdf->Cell( $col3  , 20 , iconv( 'UTF-8','cp874' , '' ) ,'LR',0,'R');
$pdf->Cell( $col4  , 20 , iconv( 'UTF-8','cp874' , '' ) ,'LR',0,'R');

$pdf->setXY( 15, 165  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'อุบัติเหตุส่วนบุคคลสำหรับผู้ขับขี่ และผู้โดยสาร คนละ' ),'LR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $cover_pa3 ),'LR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $cover_pa2 ) ,'LR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $cover_pa1 ) ,'LR',0,'R');

$pdf->setXY( 15, 175  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ค่ารักษาพยาบาล  ต่อคน' ),'LR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $cover_medical_free3 ),'LR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $cover_medical_free2 ) ,'LR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $cover_medical_free1 ) ,'LR',0,'R');

$pdf->setXY( 15, 185  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ประกันตัวผู้ขับขี่' ),'LBR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $cover_bail_out3 ),'LBR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $cover_bail_out2 ) ,'LBR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $cover_bail_out1 ) ,'LBR',0,'R');

$pdf->SetFont('angsana','B',14);
$pdf->setXY( 15, 195  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'ทุนประกัน' ), 1 , '', 'C' );
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $sum_insured_end3 ) , 1 , '' , 'C');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $sum_insured_end2 ) , 1 , '' , 'C' );
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $sum_insured_end1 ) , 1 , 1 , 'C' );

$pdf->SetFont('angsana','',14);
$pdf->setXY( 15, 205  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'เบี้ยประกันรถยนต์สุทธิ' ),'LR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $premium_net3 ),'LR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $premium_net2 ) ,'LR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $premium_net ) ,'LR',0,'R');

$pdf->setXY( 15, 215  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'เบี้ยประกันรวมภาษี' ),'LR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $premium_total3 ),'LR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $premium_total2 ) ,'LR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $premium_total ) ,'LR',0,'R');

$pdf->setXY( 15, 225  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'เบี้ยประกัน พรบ.' ),'LBR',0,'L');
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $premium_prb3 ),'LBR',0,'R');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $premium_prb2 ) ,'LBR',0,'R');
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $premium_prb ) ,'LBR',0,'R');

$pdf->SetFont('angsana','B',14);
$pdf->setXY( 15, 235  );
$pdf->Cell( $col1  , 10 , iconv( 'UTF-8','cp874' , 'เบี้ยประกันรวมทั้งสิ้น' ), 1 , '', 'C' );
$pdf->Cell( $col2  , 10 , iconv( 'UTF-8','cp874' , $premium_sum3 ) , 1 , '' , 'C');
$pdf->Cell( $col3  , 10 , iconv( 'UTF-8','cp874' , $premium_sum2 ) , 1 , '' , 'C' );
$pdf->Cell( $col4  , 10 , iconv( 'UTF-8','cp874' , $premium_sum ) , 1 , 1 , 'C' );

$pdf->Output();


?>










