<!--  Agent Performance Report V1.0 Fri 20 2558  -->
<?php include "dbconn.php"?>
<?php include "util.php"  ?> 


<SCRIPT type=text/javascript>
	function verify() {
			if ($("#start_date").val()==""){
				alert("กรุณาระบุวันที่เริ่มต้น");
				frm.startdate.focus();
//				return false;
				}
				else{
					if ($("#end_date").val()==""){
						alert("กรุณาระบุวันที่สิ้นสุด");
						frm.enddate.focus();
//						return false;
						}

						else {
							$.post( "app/report/AgentSalePerformance.php",$( "#my_form" ).serialize(), function(data) {
								if(data)
								{
								 $("#divLinkDown").empty().append("<a href='app/report/Download.php?filename="+data+"'>Download</a>");
								 
								}
							});
							


						}
				 }
			}

  </SCRIPT>

<!-- Agent Permance Report  -->
<div id="agent-performance-pane">
		<ul style="width:100%; list-style:none; margin:0;padding:0;">
 			<li>
 				<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:60%;float:left; border-bottom:1px dashed #ddd">
 						<div style="position:relative;">
								<div id="agentreport-back-main" style="float:left; display:inline-block;cursor:pointer; ">
									<i class="icon-circle-arrow-left icon-3x" style="color:#666; "></i>
								</div>
								<div style="display:inline-block; float:left; margin-left:5px;">
								<h2 style="font-family:raleway; color:#666666; margin:0; padding:0">&nbsp;Agent - Sale Performance</h2>
								<div class="stack-subtitle" style="color:#777777; ">&nbsp; Report Agent - Sale Performance</div>
								</div>
								<div style="clear:both"></div>
						</div>
	 			</div>
	 			<div style="width:25%;float:left;">
	 			 &nbsp;
	 			</div>
	 			<div style="clear:both"></div>
 			</li>
 			<li style="padding:5px; margin-top:15px;">
	 			<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
<form class="form-horizontal" id="my_form" name="date" method="post">
 				<div style="width:35%;float:left;color:#666; font-size:16px;">
 				 	<span style="font-size:15px; line-height:30px;width:118px;display:inline-block;">   Start Date </span> :
 					<input type="text" id="start_date" name="startdate"  style="width:250px; " autocomplete="off" placeholder="วันที่คุ้มครอง จาก" class="text-center calendar_en">
 				</div>
 					<div style="width:50%;float:right;">
 					<div style="color:#666;">
 						 <span style="font-size:15px; line-height:30px;width:100px;display:inline-block;"> End Date</span> :
 						<input type="text" id="end_date" name="enddate"  style="width:250px;" autocomplete="off" placeholder="วันที่คุ้มครอง ถึง" class="text-center calendar_en">
 					</div>
 				</div>
                
 				<div style="clear:both"></div>
 			</li>
            
            
            <li style="padding:5px; margin-top:15px;">
            <div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:50%;float:right;">
 						<?php
 					    		session_start();
		 						$lv = $_SESSION["pfile"]["lv"];
								$uid = $_SESSION["uid"];
 						?>
 					<div>
 		 				<span style="font-size:15px; line-height:30px; color:#666">Agent Name &nbsp;&nbsp;: </span>
                        <select style="width:250px; height:30px;" name="search_agent">
                        <option value="">ALL</option>
                        <?php
            
                            $dbconn = new dbconn;
                            $res = $dbconn->createConn();
                            $sql = "SELECT agent_id , CONCAT( first_name,' ',last_name) as name FROM t_agents ";
                            switch( $lv ){
                                 case 1 :  $sql = $sql." WHERE app.agent_id =  ".dbNumberFormat($_SESSION["uid"]); break;
                                    case 2 :
                                 case 3 :  $sql = $sql." WHERE team_id = ( SELECT team_id FROM t_agents WHERE agent_id = ".dbNumberFormat($uid).") "; break;
                                 case 4 : $sql = $sql." WHERE group_id = ( SELECT group_id FROM t_agents WHERE agent_id = ".dbNumberFormat($uid).") "; break;
                            }//end switch
            
            
                            $result = $dbconn->executeQuery($sql);
                            while($rs=mysqli_fetch_array($result)){
                                echo "<option value='".$rs['agent_id']."'> ".$rs['name']."</option>";
                            }
            
                        ?>
        
                        </select>
 					</div>
 				</div>
 				<div style="width:35%;float:left;">
 						<?php
 					    		session_start();
		 						$lv = $_SESSION["pfile"]["lv"];
								$uid = $_SESSION["uid"];
 						?>
 					<div>
 		 				<span style="font-size:15px; line-height:30px; color:#666">Team &nbsp;&nbsp;: </span>
                        <select style="width:250px; height:30px;" name="search_team">
                        <option value="">ALL</option>
                        <?php
            
                            $dbconn = new dbconn;
                            $res = $dbconn->createConn();
                            $sql = "SELECT team_id , team_name FROM t_team ";                      
                            $result = $dbconn->executeQuery($sql);
                            while($rs=mysqli_fetch_array($result)){
                                echo "<option value='".$rs['team_id']."'> ".$rs['team_name']."</option>";
                            }
            
                        ?>
        
                        </select>
 					</div>
 				</div>
                
 				<div style="clear:both"></div>
 			</li>
            
            
 			<li style="text-align:center;padding:20px;">
 				<div>
 						 <input type="button" class="btn btn-primary" value="Export" onclick="verify()" style="border-radius:3px; width:110px;">   &nbsp;&nbsp;
    					 <button class="btn btn-default search-agentperfmance-btn-clear" style="border-radius:3px; width:110px;"> Clear </button>
 				</div>
</form>
<div style="margin: 20px 0 0 20px;">
   <div id="divLinkDown"></div>
</div>
 			</li>
 		</ul>
 		
 		<!-- 
 		<div style="padding:5px 0">
 				<button class="btn btn-default search-agentperformance-export" style="border-radius:3px; width:150px; background-color:#ff9800; color:#fff; border:1px solid #e2e2e2"><i class="icon-download" style="font-size:20px"></i> Excel Download </button> 
 		</div>
 	   -->
 	 


</div>

<!-- end agent performance report -->

<script>
 $(function(){

	 $('.calendar_en').datepicker({  dateFormat: 'dd/mm/yy' });
	 $.rpt.getcmp();
	 $.rpt.getgroup();
	 
	 $('[name=agentp_search_group]').change( function(){
		 var self = $(this);
			if( self.val() == ""){
				 var option = "<option value=''> &nbsp; </option>";
				 $('[name=agentp_search_team]').text('').append(option);
			}else{
				$.rpt.getteam( self.val() );
			}
	});

		
	 //agent report back to main menu
	 $('#agentreport-back-main').click( function(e){
			$('#agent-performance-pane').fadeOut( 'fast' , function(){
				$('#select-report').fadeIn('medium');
			})
	});


		//btn search agent permance
		//report1
		$('.search-agentpermance-btn').click( function(e){
				e.preventDefault();
				$.rpt.agent_performance_report();
		});

		$('.search-agentperfmance-btn-clear').click( function(e){
				e.preventDefault();
				//clear search
		});

		$('.search-agentperformance-export').click( function(e){
				e.preventDefault();
				$.rpt.agent_performance_export();
		});
		

 })
 </script>
