<?php include "dbconn.php"?>
<?php include "util.php"  ?> 
<?php include "wlog.php"  ?> 
<?php

		//run report
			report_list_conversion();
			report_agent_performance_daily();


function report_list_conversion(){
	 
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
		$sql = " INSERT INTO rpt_t_list_conversion ".
					" SELECT  CURRENT_DATE AS transaction_dt ".  
					" ,campaign_id ".
					" ,campaign_name ".
					" ,import_id ".
					" ,list_name ".
					" ,list_load ".
					" ,list_used ".
					" ,list_used_percent ".
					" ,list_remain ".
					" ,list_remain_percent ".
					" ,list_dmc ".
					" ,list_dmc_percent ".
					" ,list_success ".
					" ,list_success_percent ".
					" ,list_unsuccess ".
					" ,list_unsuccess_percent ".
					" ,list_app ".
					" ,list_app_percent ".
					" ,list_ineffective ".
					" ,list_ineffective_percent ".
					" ,list_inprogress ".
					" ,list_inprogress_percent ".
					" ,list_callback ".
					" ,list_callback_percent ".
					" ,list_followup ".
					" ,list_followup_percent ".
					" ,list_badlist ".
					" ,list_badlist_percent ". 
					" FROM v_list_conversion ";
	
		wlog("[crontab][report_list_conversion] run sql  : ".$sql);
    	$dbconn->executeUpdate($sql);

	
}

function report_agent_performance_daily(){
	
		$dbconn = new dbconn;  
		$res = $dbconn->createConn();
	 	if($res==404){
				    $res = array("result"=>"dberror","message"=>"Can't connect to database");
				    echo json_encode($res);		
				    exit();
	     }
	     
		$sql = "insert into rpt_t_agent_performance_daily ".
					" select * from v_agent_performance_daily; ";
					
		wlog("[crontab][report_agent_performance_daily] run sql  : ".$sql);
    	$dbconn->executeUpdate($sql);
	
}

//not used
function campaign_expire(){

				$dbconn = new dbconn;  
				$res = $dbconn->createConn();
			 	if($res==404){
						    $res = array("result"=>"dberror","message"=>"Can't connect to database");
						    echo json_encode($res);		
						    exit();
			     }
			     
			$sql = "UPDATE t_campaign SET is_expire = 1 ". 
						" WHERE campaign_id = ( SELECT campaign_id FROM t_campaign WHERE end_date >= NOW() ) ";
			
			 		//SELECT * FROM t_campaign WHERE end_date >= NOW()

			
			
			wlog( "[campaign-pane_process][detail] query detail : ".$sql );
			$count = 0;
		    $result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){   
			  	$tmp1 = array(
						        "cmpid"  => nullToEmpty($rs['campaign_id']),
								"cmpName"  => nullToEmpty($rs['campaign_name']),
							    "cmpDetail"  => nullToEmpty($rs['campaign_detail']),
							    "cmpStartDate"  => dateDecode($rs['start_date']),
						  	 	"cmpEndDate"  => dateDecode($rs['end_date']),
						  		"cmpStatus"  => nullToEmpty($rs['status']),
			  					"cmpStatusDtail"  => nullToEmpty($rs['status_detail']),
			  					"cmpStatusColor"  => nullToEmpty($rs['status_color']),
			  					"callscriptid"  => nullToEmpty($rs['script_id']),
			  					"callscriptdtl"  => nullToEmpty($rs['script_detail']),
			  					"cmpApp"  => nullToEmpty($rs['app_id']),
			  					"maxCall"  => nullToEmpty($rs['maximum_call']),
			  				   "created"  => getDatetimeFromDatetime($rs['create_date']),
			  					"createu" => nulltoEmpty($rs['first_name']." ".$rs['last_name']),
						);   
				$count++;  
			}
}
			     
?>