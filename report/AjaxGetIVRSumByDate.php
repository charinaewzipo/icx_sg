<?php
header("content-type: application/x-javascript; charset=utf-8");
include("function/StartConnect.inc");
//   05/21/2015 - 05/29/2015
$selectdate = $_POST["selectdate"];
$startdate = substr($selectdate, 6, 4).substr($selectdate, 0, 2).substr($selectdate, 3, 2)  ;
$enddate =  substr($selectdate, 19, 4).substr($selectdate, 13, 2).substr($selectdate, 16, 2)  ;

$SQL = mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu' and (call_date BETWEEN '$startdate' and '$enddate') ");
$WTS_Main_Menu = mysql_result($SQL, 0);
?>

					<div class="row-fluid">
								<div class="span12">
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Date</th>
												<th>Incoming Call</th>
                                                <th>IVR Call</th>
                                                <th>Transfer call to Agent (Total)</th>
                                                <th>Transfer call to Agent (In Service)</th>
                                                <th>Transfer call to Agent (Out Service)</th>
											</tr>
										</thead>
										<tbody>
<?php  
$WTS_Incoming_Sum = 0 ;
$WTS_IVR_Sum = 0 ;
$WTS_ACD_Sum = 0 ;
$WTS_TimeOut_Sum = 0;

$SQL = "SELECT call_date from ivr_log where ivr_menu = 'WTS_Main_Menu' and (call_date between '$startdate' and '$enddate') GROUP BY call_date" ;
$result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysql_fetch_array($result))
{ 
	$call_date = $row['call_date'];
	$SQLcall_date =  mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_Main_Menu' and call_date = '$call_date'  ");
	$WTS_Incoming = mysql_result($SQLcall_date, 0);
	$WTS_Incoming_Sum =  $WTS_Incoming_Sum + $WTS_Incoming ;
	
	$SQL_IVR =  mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE (ivr_menu = 'WTS_menu_1' or
	ivr_menu = 'WTS_menu_2' or
	ivr_menu = 'WTS_menu_3' or
	ivr_menu = 'WTS_menu_4' )
	 and call_date = '$call_date'  ");
	$WTS_IVR = mysql_result($SQL_IVR, 0);
	$WTS_IVR_Sum =  $WTS_IVR_Sum + $WTS_IVR ;
	
	$SQL_ACD =  mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_ACD' and call_date = '$call_date'  ");
	$WTS_ACD = mysql_result($SQL_ACD, 0);
	$WTS_ACD_Sum =  $WTS_ACD_Sum + $WTS_ACD ;
	
	$SQL_ACD_TimeOut =  mysql_query(" SELECT COUNT(ivr_menu) AS total FROM ivr_log WHERE ivr_menu = 'WTS_TimeOut' and call_date = '$call_date'  ");
	$WTS_TimeOut = mysql_result($SQL_ACD_TimeOut, 0);
	$WTS_TimeOut_Sum =  $WTS_TimeOut_Sum + $WTS_TimeOut ;
	
	$WTS_Transfer_Total = $WTS_TimeOut + $WTS_ACD; 
	$WTS_Transfer_Total_Sum = $WTS_TimeOut_Sum + $WTS_ACD_Sum; 
	
?>
											<tr>
                                            	<td><?php echo $row['call_date'];?></td>
                                                <td><?php echo $WTS_Incoming; ?></td>
                                                <td><?php echo $WTS_IVR; ?></td>
                                                <td><?php echo $WTS_Transfer_Total; ?></td>
                                                <td><?php echo $WTS_ACD; ?></td>
                                                <td><?php echo $WTS_TimeOut; ?></td>
                                            </tr>
<?php } 

?>
                                                    <tr>
                                                    	<td style="font-weight:bold; text-align:center;">Sum</td>
                                                        <td style="font-weight:bold;"><?php echo $WTS_Incoming_Sum; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $WTS_IVR_Sum; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $WTS_Transfer_Total_Sum; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $WTS_ACD_Sum; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $WTS_TimeOut_Sum; ?></td>
                                                    </tr>
										</tbody>
									</table>
								</div><!--/span-->
							</div><!--/row-->r>


	
