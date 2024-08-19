<?php

ob_start();

include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

?>
<!DOCTYPE html>
<html>
<head>
<style>
#table_premium  {
    text-align: center;
	width:100%;

}

#table_premium thead {
    text-align: center;
	color:#fff;
	background-color:#31bc86;
	width:100%;

} 

#table_premium tbody  {
    text-align: center;
	color:#000;
	background-color:#fff;
	width:100%;

} 


#table_premium td  {
	padding:0 5px 0 5px;
} 


</style>
</head>
<body>
<table id="table_premium">
<thead>
<tr>
	<th colspan="5" >รายละเอียดประกันภัย</th>
    <th colspan="6">ตางรางความคุ้มครอง</th>
    <th>&nbsp;</th>
</tr>
<tr>
	<th >บริษัทประกัน</th>
    <th >ประเภทประกัน</th>
    <th style="width: 150px;">ทุนคุ้มครอง</th>
    <th >ซ่อม</th>
    <th >ค่าเบี้ย</th>
    <th>ทรัพย์สิน</th>
    <th>บุคคล</th>
    <th>สูญหาย/ไฟไหม้</th>
    <th>อุบัติเหตุส่วนบุคคล</th>
    <th>ค่ารักษา</th>
    <th>ประกันตัวผู้ขับขี่</th>
    <th style="width: 100px;">Action</th>
</tr>
</thead>
<tbody>


<?php

$car_brand = $_POST['car_brand'] ;
$car_model = $_POST['car_model'] ;
$car_year = $_POST['car_year'] ;
$car_engine = $_POST['car_engine'] ;


											$strSQL = "SELECT * FROM t_motor_premium where car_brand = '$car_brand' and  car_model = '$car_model' and car_engine = '$car_engine' and  car_year_end >= '$car_year' and car_year_start <= '$car_year' and active = '1' ORDER BY insurer DESC   ";
											//echo  $strSQL;
                                            $objQuery = mysql_query($strSQL);
                                            while($objResuut = mysql_fetch_array($objQuery))
                                            {
											// check การซ่อม
											$premium_type_1_DG = $objResuut["premium_type_1_DG"];
											$premium_type_1_OG = $objResuut["premium_type_1_OG"];
											$premium_type_2 = $objResuut["premium_type_2"];
											$premium_type_2P = $objResuut["premium_type_2P"];
											$premium_type_3 = $objResuut["premium_type_3"];
											$premium_type_3P = $objResuut["premium_type_3P"];
											
											if($premium_type_1_DG != ''){
												$insure_type = 'ชั้น 1';
												$clame_type = 'ห้าง';
												$premium = $premium_type_1_DG;
												
											}elseif($premium_type_1_OG != ''){
												$insure_type = 'ชั้น 1';
												$clame_type = 'อู่';
												$premium = $premium_type_1_OG;
												
											}elseif($premium_type_2 != ''){
												$insure_type = 'ชั้น 2';
												$clame_type = '';
												$premium = $premium_type_2;
												
											}elseif($premium_type_2P != ''){
												$insure_type = 'ชั้น 2 Plus';
												$clame_type = '';
												$premium = $premium_type_2P;
												
											}elseif($premium_type_3 != ''){
												$insure_type = 'ชั้น 3';
												$clame_type = '';
												$premium = $premium_type_3;
												
											}elseif($premium_type_3P != ''){
												$insure_type = 'ชั้น 3 Plus';
												$clame_type = '';
												$premium = $premium_type_3P;
											}
											
											
											$sum_insured_start = $objResuut["sum_insured_start"];	
											$sum_insured_end = $objResuut["sum_insured_end"];
											
											$cover_asset = $objResuut["cover_asset"];
											if($cover_asset != ''){
												$cover_asset = number_format($cover_asset);
											}

											$cover_person = $objResuut["cover_person"];
											if($cover_person != ''){
												$cover_person = number_format($cover_person);
											}
											
										//	$cover_lost_fire = $objResuut["cover_lost_fire"];
										//	if($cover_lost_fire != ''){
									//			$cover_lost_fire = number_format($cover_lost_fire);
										//	}
											
									//		$cover_accident = $objResuut["cover_accident"];
									//		if($cover_accident != ''){
									//			$cover_accident = number_format($cover_accident);
									//		}
											
											$cover_bail_out = $objResuut["cover_bail_out"];
											if($cover_bail_out != ''){
												$cover_bail_out = number_format($cover_bail_out);
											}
											
											$cover_xxx = $objResuut["cover_medical_free"];
											if($cover_xxx != ''){
												$cover_xxx = number_format($cover_xxx);
											}
											
											
											
											$cover_pa = $objResuut["cover_pa"];
											if($cover_pa != ''){
												$cover_pa = number_format($cover_pa);
											}
											

											
														
                                            ?>
<tr>
	<td><?php echo $objResuut["insurer"]; ?></td>
    <td><?php echo $insure_type; ?></td>
    <td><?php echo number_format($objResuut["sum_insured_start"]).' - '.number_format($objResuut["sum_insured_end"]) ; ?></td>
    <td><?php echo $clame_type; ?></td>
    <td><?php echo number_format($premium); ?></td>
    <td><?php echo $cover_asset ; ?></td>
    <td><?php echo $cover_person ; ?></td>
    <td><?php echo $cover_lost_fire ; ?></td>
    <td><?php echo $cover_pa ; ?></td>
    <td><?php echo $cover_xxx ; ?></td>
    <td><?php echo $cover_bail_out ; ?></td>
    <td><input  type="checkbox"  name="insure[]" value="<?php echo $objResuut["id"]; ?>" /> </td>
</tr>



                                            <?php
                                            }


?>
 </tr>
</tbody>
</table>
<div style="margin: 20px 0 0 20px;">
<input name="print" type="button" onClick="JavaScript:fncSubmit('page2')" value=" พิมพ์ใบเสนอราคา ">
</div>
</select>
</body>
</html>