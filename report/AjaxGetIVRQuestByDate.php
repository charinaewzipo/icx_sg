<?php
header("content-type: application/x-javascript; charset=utf-8");
include("function/StartConnect.inc");
//   05/21/2015 - 05/29/2015
$selectdate = $_POST["selectdate"];
$startdate = substr($selectdate, 6, 4).substr($selectdate, 0, 2).substr($selectdate, 3, 2)  ;
$enddate =  substr($selectdate, 19, 4).substr($selectdate, 13, 2).substr($selectdate, 16, 2)  ;

$SQL = mysql_query(" SELECT COUNT(ans) AS total FROM questionnaire WHERE  (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_Total = mysql_result($SQL, 0);
?>

					<div class="row-fluid">
								<div class="span12">
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Date</th>
                                                <th>Total</th>
												<th>5 Point</th>
                                                <th>5 Point (%)</th>
                                                <th>4 Point</th>
                                                <th>4 Point (%)</th>
                                                <th>3 Point</th>
                                                <th>3 Point (%)</th>
                                                <th>2 Point</th>
                                                <th>2 Point (%)</th>
                                                <th>1 Point </th>
                                                <th>1 Point (%)</th>
											</tr>
										</thead>
										<tbody>
<?php  
$WTS_Point5 = 0 ;
$WTS_Point4 = 0 ;
$WTS_Point3 = 0 ;
$WTS_Point2 = 0;
$WTS_Point1 = 0;
$Total = 0;

$sum_total = 0;
$sum_WTS_Point5 = 0;
$sum_WTS_Point4 = 0;
$sum_WTS_Point3 = 0;
$sum_WTS_Point2 = 0;
$sum_WTS_Point1 = 0;

$SQL = "SELECT call_date from questionnaire where  (call_date between '$startdate' and '$enddate') GROUP BY call_date" ;
$result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysql_fetch_array($result))
{ 
	$call_date = $row['call_date'];
	
	$SQLTotal =  mysql_query(" SELECT COUNT(ans) AS total FROM questionnaire WHERE  call_date = '$call_date'  ");
	$Total = mysql_result($SQLTotal, 0);
	
	$SQLPoint5 =  mysql_query(" SELECT COUNT(ans) AS total FROM questionnaire WHERE ans = 'WTS_ANS5' and call_date = '$call_date'  ");
	$WTS_ANS5 = mysql_result($SQLPoint5, 0);
	$WTS_ANS5_p = number_format(($WTS_ANS5*100)/$Total, 2, '.', '');
	
	$SQLPoint4 =  mysql_query(" SELECT COUNT(ans) AS total FROM questionnaire WHERE ans = 'WTS_ANS4' and call_date = '$call_date'  ");
	$WTS_ANS4 = mysql_result($SQLPoint4, 0);
	$WTS_ANS4_p = number_format(($WTS_ANS4*100)/$Total, 2, '.', '');
	
	$SQLPoint3 =  mysql_query(" SELECT COUNT(ans) AS total FROM questionnaire WHERE ans = 'WTS_ANS3' and call_date = '$call_date'  ");
	$WTS_ANS3 = mysql_result($SQLPoint3, 0);
	$WTS_ANS3_p = number_format(($WTS_ANS3*100)/$Total, 2, '.', '');
	
	$SQLPoint2 =  mysql_query(" SELECT COUNT(ans) AS total FROM questionnaire WHERE ans = 'WTS_ANS2' and call_date = '$call_date'  ");
	$WTS_ANS2 = mysql_result($SQLPoint2, 0);
	$WTS_ANS2_p = number_format(($WTS_ANS2*100)/$Total, 2, '.', '');
	
	$SQLPoint1 =  mysql_query(" SELECT COUNT(ans) AS total FROM questionnaire WHERE ans = 'WTS_ANS1' and call_date = '$call_date'  ");
	$WTS_ANS1 = mysql_result($SQLPoint1, 0);
	$WTS_ANS1_p = number_format(($WTS_ANS1*100)/$Total, 2, '.', '');
	
	$sum_total = $sum_total + $Total;
	$sum_WTS_Point5 = $sum_WTS_Point5 + $WTS_ANS5 ;
	$sum_WTS_Point4 = $sum_WTS_Point4 + $WTS_ANS4 ;
	$sum_WTS_Point3 = $sum_WTS_Point3 + $WTS_ANS3 ;
	$sum_WTS_Point2 = $sum_WTS_Point2 + $WTS_ANS2 ;
	$sum_WTS_Point1 = $sum_WTS_Point1 + $WTS_ANS1 ;
	
?>

											<tr>
                                            	<td><?php echo $row['call_date'];?></td>
                                                <td><?php echo $Total; ?></td>
                                                <td><?php echo $WTS_ANS5; ?></td>
                                                <td><?php echo $WTS_ANS5_p; ?></td>
                                                <td><?php echo $WTS_ANS4; ?></td>
                                                <td><?php echo $WTS_ANS4_p; ?></td>
                                                <td><?php echo $WTS_ANS3; ?></td>
                                                <td><?php echo $WTS_ANS3_p; ?></td>
                                                <td><?php echo $WTS_ANS2; ?></td>
                                                <td><?php echo $WTS_ANS2_p; ?></td>
                                                <td><?php echo $WTS_ANS1; ?></td>
                                                <td><?php echo $WTS_ANS1_p; ?></td>
                                            </tr>
<?php } 

$sum_WTS_Point5_p = number_format(($sum_WTS_Point5*100)/$sum_total, 2, '.', '');
$sum_WTS_Point4_p = number_format(($sum_WTS_Point4*100)/$sum_total, 2, '.', '');
$sum_WTS_Point3_p = number_format(($sum_WTS_Point3*100)/$sum_total, 2, '.', '');
$sum_WTS_Point2_p = number_format(($sum_WTS_Point2*100)/$sum_total, 2, '.', '');
$sum_WTS_Point1_p = number_format(($sum_WTS_Point1*100)/$sum_total, 2, '.', '');


?>
                                                    <tr>
                                                    	<td style="font-weight:bold; text-align:center;">Sum</td>
                                                        <td style="font-weight:bold;"><?php echo $sum_total; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point5; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point5_p; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point4; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point4_p; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point3; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point3_p; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point2; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point2_p; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point1; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $sum_WTS_Point1_p; ?></td>
                                                    </tr>
										</tbody>
									</table>
								</div><!--/span-->
							</div><!--/row-->r>


	
