<?php
header("content-type: application/x-javascript; charset=utf-8");
include("function/StartConnect.inc");
//   05/21/2015 - 05/29/2015
$selectdate = $_POST["selectdate"];
$startdate = substr($selectdate, 6, 4).substr($selectdate, 0, 2).substr($selectdate, 3, 2)  ;
$enddate =  substr($selectdate, 19, 4).substr($selectdate, 13, 2).substr($selectdate, 16, 2)  ;

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_Main_Menu = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_ACD' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_ACD = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_TimeOut' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_TimeOut = mysql_result($SQL, 0);

$WTS_TRANS = $WTS_ACD + $WTS_TimeOut ; 
$WTS_TRANS_p = number_format(($WTS_TRANS*100)/$WTS_Main_Menu, 2, '.', '');

$WTS_TimeOut_p = number_format(($WTS_TimeOut*100)/$WTS_TRANS, 2, '.', '');
$WTS_ACD_p = number_format(($WTS_ACD*100)/$WTS_TRANS, 2, '.', '');


//$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_1' and (call_date BETWEEN '$startdate' and '$enddate') ");
//$WTS_menu_1 = mysql_result($SQL, 0);
//$WTS_menu_1_p = number_format(($WTS_menu_1*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_1_1' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_1_1 = mysql_result($SQL, 0);
$WTS_menu_1_1_p = number_format(($WTS_menu_1_1*100)/$WTS_menu_1, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_1_1_0' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_1_1_0 = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_1_2' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_1_2 = mysql_result($SQL, 0);
$WTS_menu_1_2_p = number_format(($WTS_menu_1_2*100)/$WTS_menu_1, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_1_2_0' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_1_2_0 = mysql_result($SQL, 0);

// SUM Menu 1
$WTS_menu_1 = $WTS_menu_1_1 + $WTS_menu_1_2 ;
$WTS_menu_1_p = number_format(($WTS_menu_1*100)/$WTS_Main_Menu, 2, '.', '');


//$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2' and (call_date BETWEEN '$startdate' and '$enddate') ");
//$WTS_menu_2 = mysql_result($SQL, 0);
//$WTS_menu_2_p = number_format(($WTS_menu_2*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2_1' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_2_1 = mysql_result($SQL, 0);
$WTS_menu_2_1_p = number_format(($WTS_menu_2_1*100)/$WTS_menu_2, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2_1_0' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_2_1_0 = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2_2' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_2_2 = mysql_result($SQL, 0);
$WTS_menu_2_2_p = number_format(($WTS_menu_2_2*100)/$WTS_menu_2, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2_2_0' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_2_2_0 = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2_3' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_2_3 = mysql_result($SQL, 0);
$WTS_menu_2_3_p = number_format(($WTS_menu_2_3*100)/$WTS_menu_2, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2_3_0' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_2_3_0 = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2_4' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_2_4 = mysql_result($SQL, 0);
$WTS_menu_2_4_p = number_format(($WTS_menu_2_4*100)/$WTS_menu_2, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_2_4_0' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_2_4_0 = mysql_result($SQL, 0);

// SUM Menu 2
$WTS_menu_2 = $WTS_menu_2_1 + $WTS_menu_2_2 + $WTS_menu_2_3 + $WTS_menu_2_4 ;
$WTS_menu_2_p = number_format(($WTS_menu_2*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_3' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_3 = mysql_result($SQL, 0);
$WTS_menu_3_p = number_format(($WTS_menu_3*100)/$WTS_Main_Menu, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_3_0' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_3_0 = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_4' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_4 = mysql_result($SQL, 0);
$WTS_menu_4_p = number_format(($WTS_menu_4*100)/$WTS_Main_Menu, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_4_0' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_4_0 = mysql_result($SQL, 0);


//$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_5' and (call_date BETWEEN '$startdate' and '$enddate') ");
//$WTS_menu_5 = mysql_result($SQL, 0);
//$WTS_menu_5_p = number_format(($WTS_menu_5*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_5_1' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_5_1 = mysql_result($SQL, 0);
$WTS_menu_5_1_p = number_format(($WTS_menu_5_1*100)/$WTS_menu_5, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE (ivr_menu = 'WTS_menu_5_1_0' 
or ivr_menu = 'WTS_menu_5_1_1_0' 
or ivr_menu = 'WTS_menu_5_1_1_1_0' 
or ivr_menu = 'WTS_menu_5_1_1_2_0' 
or ivr_menu = 'WTS_menu_5_1_1_3_0' 
or ivr_menu = 'WTS_menu_5_1_2_0' 
or ivr_menu = 'WTS_menu_5_1_2_1_0' 
or ivr_menu = 'WTS_menu_5_1_2_2_0' 
or ivr_menu = 'WTS_menu_5_1_2_3_0' 
) and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_5_1_0 = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_5_2' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_5_2 = mysql_result($SQL, 0);
$WTS_menu_5_2_p = number_format(($WTS_menu_5_2*100)/$WTS_menu_5, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE (ivr_menu = 'WTS_menu_5_2_0' 
or ivr_menu = 'WTS_menu_5_2_1_0' 
or ivr_menu = 'WTS_menu_5_2_2_0' 
or ivr_menu = 'WTS_menu_5_2_3_0' 
)and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_5_2_0 = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_menu_5_3' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_5_3 = mysql_result($SQL, 0);
$WTS_menu_5_3_p = number_format(($WTS_menu_5_3*100)/$WTS_menu_5, 2, '.', '');
$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE (ivr_menu = 'WTS_menu_5_3_0' 
or ivr_menu = 'WTS_menu_5_3_1_0' 
or ivr_menu = 'WTS_menu_5_3_2_0' 
)and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_menu_5_3_0 = mysql_result($SQL, 0);
// SUM Menu 5
$WTS_menu_5 = $WTS_menu_5_1 + $WTS_menu_5_2 + $WTS_menu_5_3 ;
$WTS_menu_5_p = number_format(($WTS_menu_5*100)/$WTS_Main_Menu, 2, '.', '');

$total_hit = $WTS_TRANS  + $WTS_menu_1 + $WTS_menu_2 + $WTS_menu_3 + $WTS_menu_4 + $WTS_menu_5 ;


?>
	

						
                        
                        
                        
                        
                        	<div class="row-fluid">
								<div class="span12">
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th colspan="4">IVR MENU <?php echo $startdate.'-'.$enddate ;?></th>
												<th>จำนวนครั้ง</th>
                                                <th>%</th>
                                                <th>ฟังซ้ำ</th>
											</tr>
										</thead>

										<tbody>
											<tr>
												<td colspan="4">กด 0 ติดต่อเจ้าหน้าที่</td>
                                                <td><?php echo $WTS_TRANS ;?></td>
                                                <td><?php echo $WTS_TRANS_p;?></td>
                                                <td>0</td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">ในเวลาทำการ</td>
                                                <td><?php echo $WTS_ACD; ?></td>
                                                <td><?php echo $WTS_ACD_p; ?></td>
                                                <td>0</td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">นอกเวลาทำการ</td>
                                                <td><?php echo $WTS_TimeOut;?></td>
                                                <td><?php echo $WTS_TimeOut_p;?></td>
                                                <td>0</td>
											</tr>
                                            <tr>
												<td colspan="4">กด 1 ข้อมูลในการสมัครสมาชิก</td>
                                                <td><?php echo $WTS_menu_1;?></td>
                                                <td><?php echo $WTS_menu_1_p;?></td>
                                                <td>0</td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">1.1 เงื่อนไขการสมัครสมาชิก</td>
                                                <td><?php echo  $WTS_menu_1_1;?></td>
                                                <td><?php echo  $WTS_menu_1_1_p ;?></td>
                                                <td><?php echo  $WTS_menu_1_1_0;?></td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">1.2  วิธีการเปิดใช้งานบัตรสมาชิก</td>
                                                <td><?php echo  $WTS_menu_1_2;?></td>
                                                <td><?php echo  $WTS_menu_1_2_p;?></td>
                                                <td><?php echo  $WTS_menu_1_2_0;?></td>
											</tr>
                                             <tr>
												<td colspan="4">กด 2 สิทธิประโยชน์ของผู้ถือบัตรสมาชิก Watsons  </td>
                                                <td><?php echo $WTS_menu_2;?></td>
                                                <td><?php echo $WTS_menu_2_p;?></td>
                                                <td>0</td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">2.1 ต้องการทราบสิทธิประโยชน์ของสมาชิก</td>
                                                <td><?php echo $WTS_menu_2_1;?></td>
                                                <td><?php echo $WTS_menu_2_1_p;?></td>
                                                <td><?php echo $WTS_menu_2_1_0;?></td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">2.2 สอบถามวิธีการสะสมคะแนน</td>
                                                <td><?php echo $WTS_menu_2_2;?></td>
                                                <td><?php echo $WTS_menu_2_2_p;?></td>
                                                <td><?php echo $WTS_menu_2_2_0;?></td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">2.3  สอบถามวิธีการแลกคะแนนสะสม</td>
                                                <td><?php echo $WTS_menu_2_3;?></td>
                                                <td><?php echo $WTS_menu_2_3_p;?></td>
                                                <td><?php echo $WTS_menu_2_3_0;?></td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">2.4  สอบถามวิธีการตรวจสอบคะแนนสะสม</td>
                                                <td><?php echo $WTS_menu_2_4;?></td>
                                                <td><?php echo $WTS_menu_2_4_p;?></td>
                                                <td><?php echo $WTS_menu_2_4_0;?></td>
											</tr>
                                             <tr>
												<td colspan="4">กด 3 โปรโมชั่น</td>
                                                <td><?php echo $WTS_menu_3;?></td>
                                                <td><?php echo $WTS_menu_3_p;?></td>
                                                <td><?php echo $WTS_menu_3_0;?></td>
											</tr>
                                             <tr>
												<td colspan="4">กด 4 กิจกรรมพิเศษสำหรับสมาชิก</td>
                                                <td><?php echo $WTS_menu_4;?></td>
                                                <td><?php echo $WTS_menu_4_p;?></td>
                                                <td><?php echo $WTS_menu_4_0;?></td>
											</tr>
                                             <tr>
												<td colspan="4">กด 5 ซื้อสินค้าที่ Watsons eStore</td>
                                                <td><?php echo $WTS_menu_5;?></td>
                                                <td><?php echo $WTS_menu_5_p;?></td>
                                                <td>0</td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">กด1 วิธีการสั่งซื้อสินค้า</td>
                                                <td><?php echo $WTS_menu_5_1;?></td>
                                                <td><?php echo $WTS_menu_5_1_p;?></td>
                                                <td><?php echo $WTS_menu_5_1_0;?></td>
											</tr>
                                                <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">กด2 วิธีชําระค่าสินค้า</td>
                                                <td><?php echo $WTS_menu_5_2;?></td>
                                                <td><?php echo $WTS_menu_5_2_p;?></td>
                                                <td><?php echo $WTS_menu_5_2_0;?></td>
											</tr>
                                                <tr>
                                            	<td>&nbsp;</td> <!-- Colum 2-->
												<td colspan="3">กด3 การจัดส่งสินค้า</td>
                                                <td><?php echo $WTS_menu_5_3;?></td>
                                                <td><?php echo $WTS_menu_5_3_p;?></td>
                                                <td><?php echo $WTS_menu_5_3_0;?></td>
											</tr>
                                                    <tr>
                                                    	<td colspan="4" style="font-weight:bold; text-align:center;">TOTAL</td>
                                                        <td style="font-weight:bold;"><?php echo $total_hit?></td>
                                                        <td style="font-weight:bold;">100%</td>
                                                        <td style="font-weight:bold;" >0</td>
                                                    </tr>
										</tbody>
									</table>
								</div><!--/span-->
							</div><!--/row-->

	
