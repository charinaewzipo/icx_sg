<!-- start agent-main-pane -->
<?php include "dbconn.php"?>
<?php include "util.php"  ?>
<div id="app-main-pane">

<input type="hidden" name="aid">

  	<div style="">
  		<div style="display:inline-block;float:left;"> <img src="images/logo_motor.png" style="width:66px; height:66px; border-radius:50%; border:3px solid #fff;" class="shadow"></div>
  		<div style="display:inline-block;float:left;  ">
	  		<h2 class="page-title" style="font-family:raleway; margin:0; padding:5px; text-indent:8px;"> Motor  Insurance </h2>
			<div class="stack-subtitle" style="color:#777777;position:relative; top:-5px; text-indent:15px;">Application Order</div>
  		</div>
  		<!--<div style="float:right; margin-top:15px;">
  		 		<button class="btn btn-success  new-app" style="border-radius:3px"> Create New Application </button>
  		</div>-->
  		<div style="clear:left"></div>
	</div>
 		<hr style="border-bottom: 1px dashed #777777; ">
 		<ul style="width:100%; list-style:none; margin:0;padding:0;">
 			<li>
 				<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:60%;float:left; border-bottom:1px dashed #ddd">
	 					<h3 style="font-family:raleway; color:#666; padding:10px; margin:0; float:left;"><i class="icon-search"></i> Search</h3>
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
 				<div style="width:35%;float:left; ">
 					 <span style="font-size:15px; line-height:30px; color:#666">Customer Name &nbsp;&nbsp;: </span>
 					 <input type="text" name="search_cust" style="width:250px;" autocomplete="off" placeholder="">
 				</div>
 					<div style="width:50%;float:right;">
 						<?php
 					    		session_start();
		 						$lv = $_SESSION["pfile"]["lv"];
								$uid = $_SESSION["uid"];
								$lv = 6;
		 						if($lv > 1){
 						?>
 					<div>
 						 <span style="font-size:15px; line-height:30px; color:#666">Owner Name &nbsp;&nbsp;: </span>
           <select style="width:250px; height:30px;" name="search_agent">
		<option value="">ALL</option>
			<?php

				$dbconn = new dbconn;
				$res = $dbconn->createConn();
				$sql = "SELECT agent_id , CONCAT( first_name,' ',last_name) as name FROM t_agents ";
				switch( $lv ){
				    // case 1 :  $sql = $sql." WHERE app.agent_id =  ".dbNumberFormat($uid); break;
					// case 1 :  '' ; break;
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
 					  <?php
 								}
 					   ?>
 				</div>
 				<div style="clear:both"></div>
 			</li>
 			<li style="padding:5px; ">
	 			<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left; ">
 					 <span style="font-size:15px; line-height:30px; color:#666">Quotation No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span>
 					 <input type="text" name="search_quono" style="width:250px;" autocomplete="off" placeholder="">
 				</div>
 					<div style="width:50%;float:right;">
 					<div>
 						 <span style="font-size:15px; line-height:30px;color:#666">App Status  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span>
             <select style="width:250px; height:30px;" name="search_sts">
        			  <option value="">ALL</option>
        			  <option value="Submit" >Submit</option> 
                      <option value="Follow">Follow Doc</option>
<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	//$lv = 6;
	if($lv > 1){
?>
					  <option value="Success">Success</option>
                      <option value="Completed">Completed</option>
        			  <option value="Cancel">Cancel</option>
<?php } ?>
		        </select>
 					</div>
 				</div>
 				<div style="clear:both"></div>
 			</li>
 			<li style="padding:5px; ">
 				<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left; ">
	 			 <span style="font-size:15px; line-height:28px;color:#444">  Application Create Date  </span>
	 			</div>
	 			<div style="clear:both"></div>
 			</li>
 			<li style="padding:0 5px;">
	 			<div style="width:15%;float:left;">
	 			 &nbsp;
	 			</div>
 				<div style="width:35%;float:left;color:#666; font-size:16px;">
 				 	<span style="font-size:15px; line-height:30px;width:118px;display:inline-block;">   Start Date </span> :
 					<input type="text" name="search_cred"  style="width:250px; " autocomplete="off" placeholder="" class="text-center calendar_en">
 				</div>
 					<div style="width:50%;float:right;">
 					<div style="color:#666;">
 						 <span style="font-size:15px; line-height:30px;width:100px;display:inline-block;"> End Date</span> :
 						<input type="text" name="search_endd"  style="width:250px;" autocomplete="off" placeholder="" class="text-center calendar_en">
 					</div>
 				</div>
 				<div style="clear:both"></div>
 			</li>
 			<li style="text-align:center;padding:20px;">
 				<div>
 						 <button class="btn btn-primary search-app" style="border-radius:3px; width:110px;"> Search </button> &nbsp;&nbsp;
    					 <button class="btn btn-default search-clear" style="border-radius:3px; width:110px;"> Clear </button>  &nbsp;&nbsp;
<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	//$lv = 6;
	if($lv > 1){
?>       
                         <a class="btn btn-success " href="app/motor/Application/newApp.php?campaign_id=2&calllist_id=0&agent_id=<?php echo $uid ?>&import_id=0" target="_blank" style="border-radius:3px; width:110px;"> New App </a>
 <?php } ?>
 				</div>
 			</li>
 		</ul>

<br/>
<br/>

<table id="app-table" class="table table-bordered" style="background-color:#fff;">
<thead>
	<tr class="primary">
		<td class="text-center" style="width:5%"> # </td>
		<td class="text-center" style="width:10%"> Quotation NO </td>
		<td class="text-center" style="width:15%"> Customer Name </td>
		<td class="text-center" style="width:10%"> ทะเบียนรถ </td>
		<td class="text-center" style="width:10%"> ยี่ห้อรถ </td>
		<td class="text-center" style="width:10%"> App Status</td>
		<td class="text-center" style="width:15%"> Owner</td>
		<td class="text-center" style="width:20%"> Action </td>
	</tr>
</thead>
<tbody>

<!--  end agent-main-pane -->

<!-- start agent-detail-pane -->

<?php

$condition = '';
 			 $sql = " SELECT  car_license , car_brand, car_model, app_run_no , app_number as quotation , concat(Firstname,' ',Lastname) as custname ,  ".
			"	concat( agent.first_name ,' ', agent.last_name)  as owner , AppStatus  ".
			"  FROM t_motor_app app LEFT OUTER JOIN  t_agents  agent ON app.agent_id = agent.agent_id  ".
			" WHERE 1 ";
			
			$lv =  intval($_SESSION['pfile']['lv']); 
			//$lv = 6;
			//echo  "LV= ".$lv; 
			
			switch( $lv ){
			   //case 1 :  $condition = $condition." "; break;  	
			   //case 1 :  $condition = $condition."  "; break;
			   case 1 :  $condition = $condition." AND app.agent_id =  '".dbNumberFormat($_SESSION["uid"])."'"; break;
			   case 2 :  $condition = $condition." AND agent.team_id = ( SELECT team_id FROM t_agents WHERE agent_id = ".dbNumberFormat($_SESSION["uid"]).") "; break;
   			   case 0 : $condition = $condition."  AND agent.team_id = ( SELECT team_id FROM t_agents WHERE agent_id = ".dbNumberFormat($_SESSION["uid"]).") "; break;
			   case 4 : $condition = $condition."  AND agent.group_id = ( SELECT group_id FROM t_agents WHERE agent_id = ".dbNumberFormat($_SESSION["uid"]).") "; break;
			   case 5 : $condition = $condition." "; break; 
			   case 6 : $condition = $condition." "; break; 
 
			}
			
			 $sql = $sql.$condition;
			 $sql = $sql." ORDER BY app_number  DESC ";
			 
			
			//echo $sql;
			$result = $dbconn->executeQuery($sql);
			while($rs=mysqli_fetch_array($result)){
					 
				$app_number = $rs['quotation'];
				$link_product = 'app/motor/Application/appDetail.php?Id='.$app_number ;
				

?>
<tr>
   <td><?php echo  $rs['app_run_no'];?></td>
    <td><?php echo  $rs['quotation'];?></td>
    <td><?php echo  $rs['custname'];?></td>
    <td><?php echo  $rs['car_license'];?></td>
    <td><?php echo  $rs['car_brand'];?></td>
    <td><?php echo  $rs['AppStatus'];?></td>
    <td><?php echo  $rs['owner'];?></td>
    <td><a style='border-radius:4px; margin:0 10px; background-color:#2196f3' class='btn btn-primary  btn-sm' href='<?php echo $link_product; ?>' target='_blank'>Open App</a>
    </td>
</tr>

<?php }?>
</tbody>
</table>


</div>

<script type="text/javascript" src="js/app2.js"></script>

