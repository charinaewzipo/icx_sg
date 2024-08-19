<?php

$Firstname = $_POST["Firstname"];
$Lastname = $_POST["Lastname"];

$car_brand = $_POST["car_brand"];
$car_model = $_POST["car_model"];

$custname = 'คุณ'.$Firstname.' '.$Lastname ;
$car = $car_brand.' '.$car_model ;

require('fpdf.php');


 
$pdf=new FPDF();
 
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
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Huai Khwang, Bangkok 10310 t. +66 2159 8855  f. +66 2275 88392' ) );
 
$pdf->SetFont('angsana','B',16);
$pdf->setXY( 15, 50  );
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'ข้อเสนอ        เบี้ยประกันภัยรถยนต์' )  );
 
 $pdf->SetFont('angsana','B',16);
$pdf->setXY( 15, 60  );
$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'เรียน             '.$custname  )  );

$pdf->SetFont('angsana','',16);
$pdf->setXY( 15, 70  );
$pdf->Cell( 0  , 5 , iconv( 'UTF-8','cp874' , 'บริษัทขอขอบคุณท่านที่ให้โอกาสทางบริษัทนำเสนอเบี้ย และความคุ้มครองของรถท่าน' ),0,1,'C'  );

$pdf->SetFont('angsana','',16);
$pdf->setXY( 15, 78  );
$pdf->Cell( 0  , 5 , iconv( 'UTF-8','cp874' , 'รถ '.$car.' โดยมีความคุ้มครองและเบี้ย ตามข้อเสนอนี้ ' ),0,1,'C'  );

// container
$pdf->SetFont('angsana','',16);
$pdf->setXY( 15, 90  );
$pdf->Cell( 50  , 10 , iconv( 'UTF-8','cp874' , 'ความคุ้มครอง' ), 0 , 1 , 'C');
$pdf->Cell( 50  , 10 , iconv( 'UTF-8','cp874' , 'ความรับผิดชอบในวงเงิน' ) , 1);
$pdf->Cell( 50  , 10 , iconv( 'UTF-8','cp874' , 'ความรับผิดชอบในวงเงิน' ) , 1 );

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





$pdf->Output();
?>

