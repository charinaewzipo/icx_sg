<?php
header("content-type: application/x-javascript; charset=utf-8");
include("function/StartConnect.inc");
//   05/21/2015 - 05/29/2015
$selectdate = $_POST["selectdate"];

$startdate1 = substr($selectdate, 6, 4).substr($selectdate, 0, 2).substr($selectdate, 3, 2)  ;
$enddate1 =  substr($selectdate, 19, 4).substr($selectdate, 13, 2).substr($selectdate, 16, 2)  ;

$startdate = substr($selectdate, 6, 4).'-'.substr($selectdate, 0, 2).'-'.substr($selectdate, 3, 2)  ;
$enddate =  substr($selectdate, 19, 4).'-'.substr($selectdate, 13, 2).'-'.substr($selectdate, 16, 2)  ;

$startdate = $startdate." 00:00:00";
$enddate = $enddate." 23:59:59";

$list_submit_sum = 0 ;
$list_approved_sum = 0;

?>

					<div class="row-fluid">
								<div class="span12">
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
                                        		<th>List ID</th>
											    <th>List Name</th>
												<th>List Total</th>
                                                <th>List Used</th>
                                                <th>Submit AFYP</th>
                                                <th>Approved AFYP</th>
                                                <th>Success</th>
                                                <th>Un Success</th>
                                                <th>Follow Up</th>
                                                <th>Call Back</th>
                                                <th>No Contact</th>
                                                <th>Not Update</th>
                                                <th>Do Not Call List</th>
										</thead>
										<tbody>
<?php  

$SQL = "select import_id from t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') GROUP BY import_id DESC" ;
$result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysql_fetch_array($result))
{ 
	$import_id = $row['import_id'];
	
	$SQL_listname =  mysql_query(" select list_name from t_import_list where import_id = '$import_id'   ");
	$listname = mysql_result($SQL_listname, 0);
	
	$SQL_count=  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where  import_id = '$import_id' and campaign_id = '1'    ");
	$list_total = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') and  import_id = '$import_id' and campaign_id = '1'    ");
	$list_uesd = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') and  import_id = '$import_id' and campaign_id = '1' and  (last_wrapup_option_id = '6'  )    ");
	$list_sale = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') and  import_id = '$import_id' and campaign_id = '1' and  (last_wrapup_option_id = '7'  )    ");
	$list_unsale = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') and  import_id = '$import_id' and campaign_id = '1' and  (last_wrapup_option_id = '9'  or  last_wrapup_option_id = '2' )    ");
	$list_follow = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') and  import_id = '$import_id' and campaign_id = '1' and  (last_wrapup_option_id = '1'  )    ");
	$list_callback = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') and  import_id = '$import_id' and campaign_id = '1' and  (last_wrapup_option_id = '8'  )    ");
	$list_nocontact = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') and  import_id = '$import_id' and campaign_id = '1' and  (last_wrapup_option_id = '4'  )    ");
	$list_notupdate = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(import_id) AS total FROM t_calllist_agent where (last_wrapup_dt BETWEEN '$startdate' and '$enddate') and  import_id = '$import_id' and campaign_id = '1' and  (last_wrapup_option_id = '3'  )    ");
	$list_donotcall = mysql_result($SQL_count, 0);
	
	
	$SQL_count =  mysql_query("  select sum(INSTALMENT_PREMIUM) FROM t_app where (Sale_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and import_id = '$import_id' and PaymentFrequency = 'รายเดือน' ");
	$list_submit_m = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query("  select sum(INSTALMENT_PREMIUM) FROM t_app where (Sale_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and import_id = '$import_id' and PaymentFrequency <> 'รายเดือน' ");
	$list_submit_y = mysql_result($SQL_count, 0);
	
	$list_submit = ($list_submit_m*6)+$list_submit_y;
	
	$SQL_count =  mysql_query("  select sum(INSTALMENT_PREMIUM) FROM t_app where (Approved_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and import_id = '$import_id' and PaymentFrequency = 'รายเดือน' and AppStatus = 'Success' ");
	$list_approved_m= mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query("  select sum(INSTALMENT_PREMIUM) FROM t_app where (Approved_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and import_id = '$import_id' and PaymentFrequency <> 'รายเดือน' and AppStatus = 'Success' ");
	$list_approved_y= mysql_result($SQL_count, 0);
	
	$list_approved = ($list_approved_m*6)+ $list_approved_y;
	
	$list_submit_sum = $list_submit_sum + $list_submit ;	
	$list_approved_sum = $list_approved_sum + $list_approved ;
	
?>
											<tr>
                                            	<td><?php echo  $import_id;?></td>
                                            	<td><?php echo  $listname;?></td>
                                                <td><?php echo  $list_total;?></td>
                                                <td><?php echo  $list_uesd;?></td>
                                                <td><?php echo  $list_submit; ?></td>
                                                <td><?php echo  $list_approved; ?></td>
                                                <td><?php echo  $list_sale;?></td>
                                                <td><?php echo  $list_unsale;?></td>
                                                <td><?php echo  $list_follow;?></td>
                                                <td><?php echo  $list_callback;?></td>
                                                <td><?php echo  $list_nocontact;?></td>
                                                <td><?php echo  $list_notupdate;?></td>
                                                <td><?php echo  $list_donotcall;?></td>
                                            </tr>
                                            
                                         
<?php }  ?> 
											
                                            <tr>
                                                    	<td style="font-weight:bold; text-align:center;">Sum</td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"><?php echo $list_submit_sum; ?></td>
                                                        <td style="font-weight:bold;"><?php echo $list_approved_sum; ?></td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"></td>
                                                        <td style="font-weight:bold;"></td>
                                                    </tr>

										</tbody>
									</table>
								</div><!--/span-->
							</div><!--/row-->


	
