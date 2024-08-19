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
 <?php
$SQL = "select team_id,team_name from t_team where  group_id = '10'  " ;
$result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row = mysql_fetch_array($result))
{ 
	$team_id = $row['team_id'];
	$team_name = $row['team_name'];
?>

					
									<label for="id-date-range-picker-1">Team : <?php echo $team_name;?></label>
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
                                            	<th>Agent ID</th>
												<th>Agent Name</th>
												<th>List Total</th>
                                                <th>List Used New</th>
                                                <th>List Used Old</th>
                                                <th>List Remaining</th>
                                                <th>Submit AFYP</th>
                                                <th>Submit APP</th>
                                                <th>Approved AFYP</th>
                                                <th>Approved APP</th>
                                                <th>Success</th>
                                                <th>Un Success</th>
                                                <th>Follow Up</th>
                                                <th>Call Back</th>
                                                <th>No Contact</th>
                                                <th>Not Update</th>
                                                <th>Do Not Call List</th>
											</tr>
										</thead>
										<tbody>
  <?php
$SQL2 = "select agent_id,first_name,last_name,team_id from t_agents where is_active = '1' and team_id = '$team_id' " ;
$result2 = mysql_query($SQL2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	while($row2 = mysql_fetch_array($result2))
{ 
	$agent_id = $row2['agent_id'];
	
	$SQL_count=  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1'  ");
	$list_total = mysql_result($SQL_count, 0);
	
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and number_of_call = '1'  ");
	$list_used_new = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and number_of_call > '1'  ");
	$list_used_old = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and number_of_call <> '0'  ");
	$list_used_total = mysql_result($SQL_count, 0);
	
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and  (last_wrapup_option_id = '6'  )    ");
	$list_sale = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and  (last_wrapup_option_id = '7'  )    ");
	$list_unsale = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and  (last_wrapup_option_id = '9'  or  last_wrapup_option_id = '2' )    ");
	$list_follow = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and  (last_wrapup_option_id = '1'  )    ");
	$list_callback = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and  (last_wrapup_option_id = '8'  )    ");
	$list_nocontact = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and  (last_wrapup_option_id = '4'  )    ");
	$list_notupdate = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query(" SELECT COUNT(agent_id) AS total FROM t_calllist_agent where (assign_dt BETWEEN '$startdate' and '$enddate') and  agent_id = '$agent_id' and campaign_id = '1' and  (last_wrapup_option_id = '3'  )    ");
	$list_donotcall = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query("  select sum(INSTALMENT_PREMIUM) FROM app_mt where (Sale_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and  agent_id = '$agent_id' and PaymentFrequency = 'Monthly' ");
	$list_submit_afyp_m = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query("  select sum(INSTALMENT_PREMIUM) FROM app_mt where (Sale_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and  agent_id = '$agent_id' and PaymentFrequency <> 'Monthly' ");
	$list_submit_afyp_y = mysql_result($SQL_count, 0);
	
	$list_submit_afyp = ($list_submit_afyp_m*6)+$list_submit_afyp_y ;
	
	$SQL_count =  mysql_query("  select count(INSTALMENT_PREMIUM) FROM app_mt where (Sale_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and  agent_id = '$agent_id' ");
	$list_submit_no= mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query("  select sum(INSTALMENT_PREMIUM) FROM app_mt where (Approved_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and  agent_id = '$agent_id' and PaymentFrequency = 'Monthly' and AppStatus = 'Approved' ");
	$list_approved_afyp_m = mysql_result($SQL_count, 0);
	
	$SQL_count =  mysql_query("  select sum(INSTALMENT_PREMIUM) FROM app_mt where (Approved_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and  agent_id = '$agent_id' and PaymentFrequency <> 'Monthly' and AppStatus = 'Approved' ");
	$list_approved_afyp_y = mysql_result($SQL_count, 0);
	
	$list_approved_afyp = ($list_approved_afyp_m*6)+$list_approved_afyp_y;
	
	$SQL_count =  mysql_query("  select count(INSTALMENT_PREMIUM) FROM app_mt where (Approved_Date BETWEEN '$startdate1' and '$enddate1') and campaign_id = '1' and  agent_id = '$agent_id' ");
	$list_approved_no = mysql_result($SQL_count, 0);
	
	
	
?>                                    
                                        
                                        	<tr>
                                            	<td><?php echo  $agent_id;?></td>
                                                <td><?php echo  $row2['first_name'].' '.$row2['last_name']  ;?></td>
                                                <td><?php echo  $list_total;?></td>
                                                <td><?php echo  $list_used_new;?></td>
                                                <td><?php echo  $list_used_old;?></td>
                                                <td><?php echo  $list_total;?></td>
                                                <td><?php echo  $list_submit_afyp;?></td>
                                                <td><?php echo  $list_submit_no;?></td>
                                                <td><?php echo  $list_approved_afyp;?></td>
                                                <td><?php echo  $list_approved_no;?></td>
                                                <td><?php echo  $list_sale;?></td>
                                                <td><?php echo  $list_unsale;?></td>
                                                <td><?php echo  $list_follow;?></td>
                                                <td><?php echo  $list_callback;?></td>
                                                <td><?php echo  $list_nocontact;?></td>
                                                <td><?php echo  $list_notupdate;?></td>
                                                <td><?php echo  $list_donotcall;?></td>
                                            </tr>
                                            
                                        
                                        
                                        
<?php } ?>


                                        </tbody>
									</table>
<?php  
}  // end team group 

?>
										

										
								</div><!--/span-->
							</div><!--/row-->


	
