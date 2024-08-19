<?php

ob_start();
session_start();

include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");
//include("../../function/checkSession.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />

<link href="../../css/smoothness/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css"/>

<script src="../../scripts/jquery-1.4.2.min.js"></script>
<script src="../../scripts/jquery-ui-1.8.2.custom.min.js"></script>

<title>บทยืนยัน Gen Exclusive</title>
<script type="text/javascript" src="../scripts/function.js"></script>



</head>

<body>

<?php

$Id = $_GET["Id"];

$SQL = "select  * from t_app where ProposalNumber = '$Id'" ;
  $result = mysqli_query($Conn, $SQL) or die ("ไม่สามารถเรียกดูข้อมูลได้");
  	  	while($row = mysqli_fetch_array($result))
	 { 
 		$custname =  $row["Firstname"].' '.$row["Lastname"];
		
		$sum_insure =  $row["COVERAGE_NAME"];
		$premium_payment =  $row["INSTALMENT_PREMIUM"];
		$ProductCode =  $row["ProductCode"];
		
		
		if($sum_insure == '250000.00'){
			$icu = '4,000';
			$opd = '800';
		}elseif ($sum_insure == '500000.00'){
			$icu = '6,000';
			$opd = '1,000';
		}elseif ($sum_insure == '750000.00'){
			$icu = '8,000';
			$opd = '1,200';
		}elseif ($sum_insure == '1000000.00'){
			$icu = '10,000';
			$opd = '1,500';
		}
		
		$AccountType = $row["AccountType"];
		if($AccountType == 'CC01'){
			$Account = 'Visa';
		}else{
			$Account = 'Master';
		}
		
		if($ProductCode == 'IPD,OPD'){
			$opd =  $opd;
		}else{
			$opd =  '0';
		}
		

		$SQL2 = "select  * from t_gen_exclusive where sum_insure = '$sum_insure' and premium_payment = '$premium_payment'    " ;
			$result2 = mysqli_query($Conn, $SQL2) or die ("ไม่สามารถเรียกดูข้อมูลได้");
  	  		while($row2 = mysqli_fetch_array($result2))
			 { 
			 	$premium_payment2 = $row2["premium_payment2"];
				$premium = $row2["premium"];
			 }

	?>


<div id="content">

        <div id="top-detail">
       	  <div id="app-detail">
<table>
                	<tr>
                    	<td><h1>บทยืนยัน Gen Exclusive </h1></td>
                    </tr>
            </table>
          </div>
        </div>

        <!--start  form 1 -->
        <div>
        <fieldset id="form-content" >
        <p>บริษัท เจนเนอราลี่ ประกันภัย (ไทยแลนด์) จำกัด (มหาชน) ขอขอบคุณ คุณ<b><?php  echo $custname;?></b> ที่มอบความไว้วางใจในการทำประกันภัย บริษัทฯ พิจารณารับประกันภัยโดยอาศัยหลักความสุจริตใจอย่างยิ่งตามประมวลกฎหมายแพ่งและพาณิชย์ มาตรา 865 และคุณ<b><?php  echo $custname;?></b> มีสิทธิขอยกเลิกกรมธรรม์ภายใน 30 วัน นับแต่วันที่คุณ<b><?php  echo $custname;?></b>ได้รับกรมธรรม์
		</p>
        </br>
        <p>
        ผม/ดิฉัน................ใบอนุญาตเป็นตัวแทนประกันวินาศภัยเลขที่................ขออนุญาตบันทึกเสียงเพื่อยืนยันการสมัครรับความคุ้มครองโดยไม่ต้องกรอกเอกสารการสมัครใดๆ ทั้งสิ้น
        </p>
        </br>
        <p>
        ปัจจุบันคุณ<b><?php  echo $custname;?></b> มีอายุ <b><?php  echo $row["ADE_AT_RCD"];?></b> ปี ซึ่งอยู่ระหว่าง ............... ปี คุณ<b><?php  echo $custname;?></b> ต้องการสมัครทำประกันภัยแบบ Gen Exclusiveกับบริษัท เจนเนอราลี่ ประกันภัย (ไทยแลนด์) จำกัด (มหาชน) ซึ่งได้รับอนุมัติแบบประกันจากคณะกรรมการกำกับและส่งเสริมการประกอบธุรกิจประกันภัย 
        </p>
        <br />
        <p>
        ผม/ดิฉันขออนุญาตยืนยันเงื่อนไข และผลประโยชน์ที่คุณ<b><?php  echo $custname;?></b> จะได้รับความคุ้มครอง ดังนี้<br />
1.	การเสียชีวิต สูญเสียอวัยวะ สายตา หรือทุพพลภาพถาวรสิ้นเชิงเนื่องจากอุบัติเหตุ จะได้รับความคุ้มครอง 2,000,000 บาท<br />
2.	การเสียชีวิต สูญเสียอวัยวะ สายตา หรือทุพพลภาพถาวรสิ้นเชิงเนื่องจากอุบัติเหตุสาธารณะ จะได้รับความคุ้มครอง 4,000,000 บาท<br />
3.	การถูกฆาตกรรม ลอบทำร้าย จนเป็นเหตุให้เสียชีวิต สูญเสียอวัยวะ สายตา หรือทุพพลภาพถาวรสิ้นเชิงจะได้รับความคุ้มครอง 400,000 บาท<br />
4.	การเสียชีวิต สูญเสียอวัยวะ สายตา หรือทุพพลภาพถาวรสิ้นเชิงเนื่องจากการขับขี่หรือซ้อนท้ายจักรยานยนต์ จะได้รับความคุ้มครอง 400,000 บาท<br />
5.	ค่ารักษาพยาบาลจากอุบัติเหตุต่อครั้ง สูงสุดถึง 100,000 บาท<br />
6.	ค่าชดเชยรายได้ (ต่อวัน) วันละ 2,000 บาท สูงสุดถึง 365 วัน<br />
7.	ค่าชดเชยรายได้สำหรับห้อง ICU (ต่อวัน) วันละ 4,000 บาท สูงสุดถึง 30 วัน<br />
8.	ค่าปลงศพ (เสียชีวิตจากอุบัติเหตุหรือการเจ็บป่วย) ได้รับ 10,000 บาท<br />
        </p>
        <br />
        <p>
        คุณ<b><?php  echo $custname;?></b> ตกลงที่จะชำระเบี้ยประกันภัยเป็นรายเดือน โดยเดือนที่ 1 เป็นเงินจำนวน <b><?php  echo $row["INSTALMENT_PREMIUM"];?></b> บาท และเดือนที่ 2 – 12 เป็นเงินจำนวน <b><?php  echo $premium_payment2 ;?></b> บาท (เป็นรายปี เป็นเงินจำนวนงวดละ <b><?php  echo $premium ;?></b> บาท) ซึ่งคุณ<b><?php  echo $custname;?></b> เป็นผู้ถือบัตรเครดิตนี้ และอนุญาตให้หักเบี้ยประกันภัยผ่านบัตรเครดิตธนาคาร <b><?php  echo $row["Bank"];?></b> ประเภท <b><?php  echo $Account ;?></b> เลขที่บัตร <b><?php  echo $row["AccountNo"];?></b> วันหมดอายุ<b><?php  echo $row["ExpiryDate"];?></b> โดยการชำระเบี้ยประกันภัยในงวดถัดไป ทางบริษัทฯจะขอทำการหักชำระเบี้ยประกันภัยผ่านบัตรเครดิตของคุณ<b><?php  echo $custname;?></b> ทุกวันที่ <b><?php  echo $row["Approved_Date"];?></b> (วันที่เริ่มมีผลความคุ้มครอง) ของทุกเดือน รบกวนคุณ<b><?php  echo $custname;?></b> ตอบคำว่า "ตกลง" สำหรับผลประโยชน์ที่ได้รับด้วยครับ/ค่ะ
        </p>
        </br>
<p><h1>(กรณีโอนเงิน)</h1></br>
คุณ<b><?php  echo $custname;?></b> ยินดีชำระเบี้ยประกันภัยโดยโอนเงินผ่านบัญชี บ.เจนเนอราลี่ ประกันภัย (ไทยแลนด์) จำกัด มหาชน ธนาคารกสิกรไทย ประเภทออมทรัพย์ เลขที่บัญชี 709-2394-772/ไทยพาณิชย์ ประเภทออมทรัพย์ เลขที่บัญชี 155-201-7185  ซึ่งครั้งแรกจะเรียกเก็บค่าเบี้ย 2 เดือนเพื่อเป็นเงินสำรองค่าเบี้ยประกันภัยเป็นจำนวนเงิน<b><?php  echo $row["INSTALMENT_PREMIUM"];?></b>  บาท เดือนที่ 3-12 เดือนละ <b><?php  echo $premium_payment2 ;?></b> บาท  รบกวนคุณ<b><?php  echo $custname;?></b> ตกลงตามข้อความที่กล่าวมาทั้งหมดนะคะ            
</p>
</br>
<p><h1>Yes File</h1></br>
เนื่องจากคุณ<b><?php  echo $custname;?></b> ตอบคำถามสุขภาพ 3 ข้อว่า "ไม่เคย" ทั้งหมด คุณ<b><?php  echo $custname;?></b> จะได้รับความคุ้มครองทันทีเมื่อบริษัทพิจารณารับประกันภัย และเรียกเก็บเบี้ยประกันภัยได้ ซึ่งคุณ<b><?php  echo $custname;?></b> จะได้รับกรมธรรม์ภายใน 15 วันทำการ นับจากวันที่บริษัทพิจารณารับประกันภัย และเรียกเก็บเบี้ยประกันภัยได้ หากคุณ<b><?php  echo $custname;?></b> มีข้อสงสัยสามารถสอบถามข้อมูลได้ที่เบอร์โทรศัพท์ 02-6129888 ในวันและเวลาทำการครับ/ค่ะ          
</p>
</br>
<p><h1>Pending File</h1></br>
เนื่องจากคุณ<b><?php  echo $custname;?></b> ตอบคำถามสุขภาพ 3 ข้อว่า "เคย" ในข้อใดข้อหนึ่ง ฝ่ายพิจารณารับประกันภัยของบริษัท              ขออนุญาตฯ พิจารณาอีกครั้ง หากบริษัทพิจารณารับประกันภัย  คุณ<b><?php  echo $custname;?></b> จะได้รับความคุ้มครองทันทีเมื่อบริษัทเรียกเก็บเบี้ยประกันภัยได้ ซึ่งคุณ<b><?php  echo $custname;?></b> จะได้รับกรมธรรม์ภายใน 15 วันทำการ นับจากวันที่บริษัทพิจารณารับประกันภัย และเรียกเก็บเบี้ยประกันภัยได้ กรณีบริษัทไม่สามารถรับประกันภัยได้ ทางบริษัทจะจัดส่งหนังสือแจ้งให้คุณ<b><?php  echo $custname;?></b> ทราบหากคุณ<b><?php  echo $custname;?></b> มีข้อสงสัยสามารถสอบถามข้อมูลได้ที่เบอร์โทรศัพท์ 02-6129888 ในวันและเวลาทำการครับ/ค่ะ        
</p>
</br>
<p><h1>(กรณีผู้ถือบัตรเครดิต ไม่ใช่ผู้เอาประกันภัย)</h1></br>
คุณ<b><?php  echo $custname;?></b> ตกลงที่จะชำระเบี้ยประกันภัยเป็นรายเดือน โดยเดือนที่ 1 เป็นเงินจำนวน <b><?php  echo $row["INSTALMENT_PREMIUM"];?></b>  บาท และเดือนที่ 2 – 12 เป็นเงินจำนวน <b><?php  echo $premium_payment2 ;?></b> บาท (เป็นรายปี เป็นเงินจำนวนงวดละ <b><?php  echo $premium ;?></b> บาท) ให้กับคุณ<b><?php  echo $custname;?></b> ซึ่งเป็นผู้เอาประกันภัย โดยที่คุณ<b><?php  echo $custname;?></b> เป็นผู้ถือบัตรเครดิตนี้ และอนุญาตให้หักเบี้ยประกันภัยผ่านบัตรเครดิต ธนาคาร <b><?php  echo $row["Bank"];?></b> ประเภท <?php  echo $Account ;?></b> เลขที่บัตร <b><?php  echo $row["AccountNo"];?></b> วันหมดอายุ <b><?php  echo $row["ExpiryDate"];?></b>
รบกวนคุณ<b><?php  echo $custname;?></b> ตอบคำว่า "ตกลง" สำหรับการอนุญาตให้หักเบี้ยประกันภัยผ่านบัตรเครดิตด้วยครับ/ค่ะ  
</p>
<br /><br />
<p>
การลงทะเบียนเรียบร้อยแล้วครับ/ค่ะ บริษัทต้องขอขอบพระคุณ คุณ<b><?php  echo $custname;?></b> ที่สละเวลาเข้าร่วมโครงการและขอให้สุขภาพร่างกาย สมบูรณ์แข็งแรงตลอดไปครับ/ค่ะ    สวัสดีครับ/ค่ะ
</p>

</br>
</br>
</br>
        </fieldset>
 		</div>
        <!--end  form 1 -->
<?php };?>
</div>
</body>
</html>
