<?php
header("content-type: application/x-javascript; charset=utf-8");
include("function/StartConnect.inc");
//   05/21/2015 - 05/29/2015
$selectdate = $_POST["selectdate"];
$startdate = substr($selectdate, 6, 4).substr($selectdate, 0, 2).substr($selectdate, 3, 2)  ;
$enddate =  substr($selectdate, 19, 4).substr($selectdate, 13, 2).substr($selectdate, 16, 2)  ;

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_Main_Menu = mysql_result($SQL, 0);

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '00:00:00' and '00:29:59')  ");
$WTS_00_00 = mysql_result($SQL, 0);
$WTS_00_00_p = number_format(($WTS_00_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '00:30:00' and '00:59:59')  ");
$WTS_00_002 = mysql_result($SQL, 0);
$WTS_00_00_p2 = number_format(($WTS_00_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '01:00:00' and '01:29:59')  ");
$WTS_01_00 = mysql_result($SQL, 0);
$WTS_01_00_p = number_format(($WTS_01_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '01:30:00' and '01:59:59')  ");
$WTS_01_002 = mysql_result($SQL, 0);
$WTS_01_00_p2 = number_format(($WTS_01_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '02:00:00' and '02:29:59')  ");
$WTS_02_00 = mysql_result($SQL, 0);
$WTS_02_00_p = number_format(($WTS_02_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '02:30:00' and '02:59:59')  ");
$WTS_02_002 = mysql_result($SQL, 0);
$WTS_02_00_p2 = number_format(($WTS_02_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '03:00:00' and '03:29:59')  ");
$WTS_03_00 = mysql_result($SQL, 0);
$WTS_03_00_p = number_format(($WTS_03_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '03:30:00' and '03:59:59')  ");
$WTS_03_002 = mysql_result($SQL, 0);
$WTS_03_00_p2 = number_format(($WTS_03_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '04:00:00' and '04:29:59')  ");
$WTS_04_00 = mysql_result($SQL, 0);
$WTS_04_00_p = number_format(($WTS_04_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '04:30:00' and '04:59:59')  ");
$WTS_04_002 = mysql_result($SQL, 0);
$WTS_04_00_p2 = number_format(($WTS_04_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '05:00:00' and '05:29:59')  ");
$WTS_05_00 = mysql_result($SQL, 0);
$WTS_05_00_p = number_format(($WTS_05_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '05:30:00' and '05:59:59')  ");
$WTS_05_002 = mysql_result($SQL, 0);
$WTS_05_00_p2 = number_format(($WTS_05_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '06:00:00' and '06:29:59')  ");
$WTS_06_00 = mysql_result($SQL, 0);
$WTS_06_00_p = number_format(($WTS_06_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '06:30:00' and '06:59:59')  ");
$WTS_06_002 = mysql_result($SQL, 0);
$WTS_06_00_p2 = number_format(($WTS_06_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '07:00:00' and '07:29:59')  ");
$WTS_07_00 = mysql_result($SQL, 0);
$WTS_07_00_p = number_format(($WTS_07_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '07:30:00' and '07:59:59')  ");
$WTS_07_002 = mysql_result($SQL, 0);
$WTS_07_00_p2 = number_format(($WTS_07_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '08:00:00' and '08:29:59')  ");
$WTS_08_00 = mysql_result($SQL, 0);
$WTS_08_00_p = number_format(($WTS_08_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '08:30:00' and '08:59:59')  ");
$WTS_08_002 = mysql_result($SQL, 0);
$WTS_08_00_p2 = number_format(($WTS_08_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '09:00:00' and '09:29:59')  ");
$WTS_09_00 = mysql_result($SQL, 0);
$WTS_09_00_p = number_format(($WTS_09_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '09:30:00' and '09:59:59')  ");
$WTS_09_002 = mysql_result($SQL, 0);
$WTS_09_00_p2 = number_format(($WTS_09_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '10:00:00' and '10:29:59')  ");
$WTS_10_00 = mysql_result($SQL, 0);
$WTS_10_00_p = number_format(($WTS_10_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '10:30:00' and '10:59:59')  ");
$WTS_10_002 = mysql_result($SQL, 0);
$WTS_10_00_p2 = number_format(($WTS_10_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '11:00:00' and '11:29:59')  ");
$WTS_11_00 = mysql_result($SQL, 0);
$WTS_11_00_p = number_format(($WTS_11_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '11:30:00' and '11:59:59')  ");
$WTS_11_002 = mysql_result($SQL, 0);
$WTS_11_00_p2 = number_format(($WTS_11_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '12:00:00' and '12:29:59')  ");
$WTS_12_00 = mysql_result($SQL, 0);
$WTS_12_00_p = number_format(($WTS_12_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '12:30:00' and '12:59:59')  ");
$WTS_12_002 = mysql_result($SQL, 0);
$WTS_12_00_p2 = number_format(($WTS_12_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '13:00:00' and '13:29:59')  ");
$WTS_13_00 = mysql_result($SQL, 0);
$WTS_13_00_p = number_format(($WTS_13_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '13:30:00' and '13:59:59')  ");
$WTS_13_002 = mysql_result($SQL, 0);
$WTS_13_00_p2 = number_format(($WTS_13_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '14:00:00' and '14:29:59')  ");
$WTS_14_00 = mysql_result($SQL, 0);
$WTS_14_00_p = number_format(($WTS_14_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '14:30:00' and '14:59:59')  ");
$WTS_14_002 = mysql_result($SQL, 0);
$WTS_14_00_p2 = number_format(($WTS_14_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '15:00:00' and '15:29:59')  ");
$WTS_15_00 = mysql_result($SQL, 0);
$WTS_15_00_p = number_format(($WTS_15_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '15:30:00' and '15:59:59')  ");
$WTS_15_002 = mysql_result($SQL, 0);
$WTS_15_00_p2 = number_format(($WTS_15_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '16:00:00' and '16:29:59')  ");
$WTS_16_00 = mysql_result($SQL, 0);
$WTS_16_00_p = number_format(($WTS_16_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '16:30:00' and '16:59:59')  ");
$WTS_16_002 = mysql_result($SQL, 0);
$WTS_16_00_p2 = number_format(($WTS_16_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '17:00:00' and '17:29:59')  ");
$WTS_17_00 = mysql_result($SQL, 0);
$WTS_17_00_p = number_format(($WTS_17_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '17:30:00' and '17:59:59')  ");
$WTS_17_002 = mysql_result($SQL, 0);
$WTS_17_00_p2 = number_format(($WTS_17_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '18:00:00' and '18:29:59')  ");
$WTS_18_00 = mysql_result($SQL, 0);
$WTS_18_00_p = number_format(($WTS_18_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '18:30:00' and '18:59:59')  ");
$WTS_18_002 = mysql_result($SQL, 0);
$WTS_18_00_p2 = number_format(($WTS_18_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '19:00:00' and '19:29:59')  ");
$WTS_19_00 = mysql_result($SQL, 0);
$WTS_19_00_p = number_format(($WTS_19_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '19:30:00' and '19:59:59')  ");
$WTS_19_002 = mysql_result($SQL, 0);
$WTS_19_00_p2 = number_format(($WTS_19_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '20:00:00' and '20:29:59')  ");
$WTS_20_00 = mysql_result($SQL, 0);
$WTS_20_00_p = number_format(($WTS_20_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '20:30:00' and '20:59:59')  ");
$WTS_20_002 = mysql_result($SQL, 0);
$WTS_20_00_p2 = number_format(($WTS_20_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '21:00:00' and '21:29:59')  ");
$WTS_21_00 = mysql_result($SQL, 0);
$WTS_21_00_p = number_format(($WTS_21_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '21:30:00' and '21:59:59')  ");
$WTS_21_002 = mysql_result($SQL, 0);
$WTS_21_00_p2 = number_format(($WTS_21_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '22:00:00' and '22:29:59')  ");
$WTS_22_00 = mysql_result($SQL, 0);
$WTS_22_00_p = number_format(($WTS_22_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '22:30:00' and '22:59:59')  ");
$WTS_22_002 = mysql_result($SQL, 0);
$WTS_22_00_p2 = number_format(($WTS_22_002*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '23:00:00' and '23:29:59')  ");
$WTS_23_00 = mysql_result($SQL, 0);
$WTS_23_00_p = number_format(($WTS_23_00*100)/$WTS_Main_Menu, 2, '.', '');

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu'
and (call_date BETWEEN '$startdate' and '$enddate') and (call_time BETWEEN '23:30:00' and '23:59:59')  ");
$WTS_23_002 = mysql_result($SQL, 0);
$WTS_23_00_p2 = number_format(($WTS_23_002*100)/$WTS_Main_Menu, 2, '.', '');

echo $SQL;
?>
                        	<div class="row-fluid">
								<div class="span12">
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Period Time</th>
												<th>จำนวนครั้ง</th>
                        <th>%</th>
											</tr>
										</thead>

										<tbody>
											<tr>
                                                <td>00:00 - 00:29</td>
                                                <td><?php echo $WTS_00_00; ?></td>
                                                <td><?php echo $WTS_00_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>00:30 - 00:59</td>
                                                <td><?php echo $WTS_00_002; ?></td>
                                                <td><?php echo $WTS_00_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>01:00 - 01:29</td>
                                                <td><?php echo $WTS_01_00; ?></td>
                                                <td><?php echo $WTS_01_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>01:30 - 01:59</td>
                                                <td><?php echo $WTS_01_002; ?></td>
                                                <td><?php echo $WTS_01_00_p2; ?></td>
											</tr>

                      <tr>
                                                <td>02:00 - 02:29</td>
                                                <td><?php echo $WTS_02_00; ?></td>
                                                <td><?php echo $WTS_02_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>02:30 - 02:59</td>
                                                <td><?php echo $WTS_02_002; ?></td>
                                                <td><?php echo $WTS_02_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>03:00 - 03:29</td>
                                                <td><?php echo $WTS_03_00; ?></td>
                                                <td><?php echo $WTS_03_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>03:30 - 03:59</td>
                                                <td><?php echo $WTS_03_002; ?></td>
                                                <td><?php echo $WTS_03_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>04:00 - 04:29</td>
                                                <td><?php echo $WTS_04_00; ?></td>
                                                <td><?php echo $WTS_04_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>04:30 - 04:59</td>
                                                <td><?php echo $WTS_04_002; ?></td>
                                                <td><?php echo $WTS_04_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>05:00 - 05:29</td>
                                                <td><?php echo $WTS_05_00; ?></td>
                                                <td><?php echo $WTS_05_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>05:30 - 05:59</td>
                                                <td><?php echo $WTS_05_002; ?></td>
                                                <td><?php echo $WTS_05_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>06:00 - 06:29</td>
                                                <td><?php echo $WTS_06_00; ?></td>
                                                <td><?php echo $WTS_06_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>06:30 - 06:59</td>
                                                <td><?php echo $WTS_06_002; ?></td>
                                                <td><?php echo $WTS_06_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>07:00 - 07:29</td>
                                                <td><?php echo $WTS_07_00; ?></td>
                                                <td><?php echo $WTS_07_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>07:30 - 07:59</td>
                                                <td><?php echo $WTS_07_002; ?></td>
                                                <td><?php echo $WTS_07_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>08:00 - 08:29</td>
                                                <td><?php echo $WTS_08_00; ?></td>
                                                <td><?php echo $WTS_08_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>08:30 - 08:59</td>
                                                <td><?php echo $WTS_08_002; ?></td>
                                                <td><?php echo $WTS_08_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>09:00 - 09:29</td>
                                                <td><?php echo $WTS_09_00; ?></td>
                                                <td><?php echo $WTS_09_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>09:30 - 09:59</td>
                                                <td><?php echo $WTS_09_002; ?></td>
                                                <td><?php echo $WTS_09_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>10:00 - 10:29</td>
                                                <td><?php echo $WTS_10_00; ?></td>
                                                <td><?php echo $WTS_10_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>10:30 - 10:59</td>
                                                <td><?php echo $WTS_10_002; ?></td>
                                                <td><?php echo $WTS_10_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>11:00 - 11:29</td>
                                                <td><?php echo $WTS_11_00; ?></td>
                                                <td><?php echo $WTS_11_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>11:30 - 11:59</td>
                                                <td><?php echo $WTS_11_002; ?></td>
                                                <td><?php echo $WTS_11_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>12:00 - 12:29</td>
                                                <td><?php echo $WTS_12_00; ?></td>
                                                <td><?php echo $WTS_12_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>12:30 - 12:59</td>
                                                <td><?php echo $WTS_12_002; ?></td>
                                                <td><?php echo $WTS_12_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>13:00 - 13:29</td>
                                                <td><?php echo $WTS_13_00; ?></td>
                                                <td><?php echo $WTS_13_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>13:30 - 13:59</td>
                                                <td><?php echo $WTS_13_002; ?></td>
                                                <td><?php echo $WTS_13_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>14:00 - 14:59</td>
                                                <td><?php echo $WTS_14_00; ?></td>
                                                <td><?php echo $WTS_14_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>14:00 - 14:29</td>
                                                <td><?php echo $WTS_14_00; ?></td>
                                                <td><?php echo $WTS_14_00_p; ?></td>
											</tr>
                                            <tr>
                                                <td>15:30 - 15:59</td>
                                                <td><?php echo $WTS_15_002; ?></td>
                                                <td><?php echo $WTS_15_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>16:00 - 16:29</td>
                                                <td><?php echo $WTS_16_00; ?></td>
                                                <td><?php echo $WTS_16_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>16:30 - 16:59</td>
                                                <td><?php echo $WTS_16_002; ?></td>
                                                <td><?php echo $WTS_16_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>17:00 - 17:29</td>
                                                <td><?php echo $WTS_17_00; ?></td>
                                                <td><?php echo $WTS_17_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>17:30 - 17:59</td>
                                                <td><?php echo $WTS_17_002; ?></td>
                                                <td><?php echo $WTS_17_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>18:00 - 18:29</td>
                                                <td><?php echo $WTS_18_00; ?></td>
                                                <td><?php echo $WTS_18_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>18:30 - 18:59</td>
                                                <td><?php echo $WTS_18_002; ?></td>
                                                <td><?php echo $WTS_18_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>19:00 - 19:29</td>
                                                <td><?php echo $WTS_19_00; ?></td>
                                                <td><?php echo $WTS_19_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>19:30 - 19:59</td>
                                                <td><?php echo $WTS_19_002; ?></td>
                                                <td><?php echo $WTS_19_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>20:00 - 20:29</td>
                                                <td><?php echo $WTS_20_00; ?></td>
                                                <td><?php echo $WTS_20_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>20:30 - 20:59</td>
                                                <td><?php echo $WTS_20_002; ?></td>
                                                <td><?php echo $WTS_20_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>21:00 - 21:29</td>
                                                <td><?php echo $WTS_21_00; ?></td>
                                                <td><?php echo $WTS_21_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>21:30 - 21:59</td>
                                                <td><?php echo $WTS_21_002; ?></td>
                                                <td><?php echo $WTS_21_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>22:00 - 22:29</td>
                                                <td><?php echo $WTS_22_00; ?></td>
                                                <td><?php echo $WTS_22_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>22:30 - 22:59</td>
                                                <td><?php echo $WTS_22_002; ?></td>
                                                <td><?php echo $WTS_22_00_p2; ?></td>
											</tr>
                      <tr>
                                                <td>23:00 - 23:29</td>
                                                <td><?php echo $WTS_23_00; ?></td>
                                                <td><?php echo $WTS_23_00_p; ?></td>
											</tr>
                      <tr>
                                                <td>23:30 - 23:59</td>
                                                <td><?php echo $WTS_23_002; ?></td>
                                                <td><?php echo $WTS_23_00_p2; ?></td>
											</tr>

                                                    <tr>
                                                    	<td style="font-weight:bold; text-align:center;">TOTAL</td>
                                                        <td style="font-weight:bold;"><?php echo $WTS_Main_Menu; ?></td>
                                                        <td style="font-weight:bold;">100%</td>
                                                    </tr>
										</tbody>
									</table>
								</div><!--/span-->
							</div><!--/row-->
