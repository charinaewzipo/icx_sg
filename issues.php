<?php
    session_start();
    if(!isset($_SESSION["uid"])){
       header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
		$pfile = $_SESSION["pfile"];
	}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title> TeleSmile 2 </title>
<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">
<link href="css/default.css" rel="stylesheet">
<style>


</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/reminder.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>

<script type="text/javascript" src="js/issues.js"></script>
<script>
 $(function(){
 	
	
 })

</script>

<body>
<form>

<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="appname" value="issue">
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>">

<input type="hidden" name="isid">

<div class="navbar navbar-default navbar-fixed-top navbar-header" style="z-index:100">  

	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul class="header-profile">
				<li style="width:140px; text-align:center; vertical-align:middle; "> 	
					<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
						<span class="ion-ios7-telephone-outline size-24" ></span>TeleSmile
					</span>
		 		</li>
				<li > 
				<span style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;"> 
					<span id="show-name" class="header-user-profile">  Ext. 2001</span>
					<span id="show-passion"class="header-user-detail">  Phone. Status </span>
			 </span>
				</li>
			</ul>
	</div>
	
	<div class="stack-date pull-right"></div>
	<div class="navbar-inner pull-right" >
		<span class="ion-ios7-arrow-down  dropdown-toggle" data-toggle="dropdown"  style="font-size:16px; font-weight:bold; cursor:pointer; display:block; margin-right: 8px; margin-top:16px;"></span>
		<ul class="dropdown-menu pull-right">
          <li class="text-center" style="margin:5px 0px;">
          		<img src="profiles/Xcode.png" id="abc" class="avatar-title"> 
          		<!-- <h3 style="color:#666666; display:block; margin-top:5px;">Arnon Wongsantitamnukul </h3>  -->
          </li>
         <li class="divider"></li>
          <li><a href="myprofile.php" ><span class="ion-ios7-contact-outline size-21"></span> &nbsp; My profile</a></li>
          <li><a href="mysetting.php"><span class="ion-ios7-gear-outline size-21"></span> &nbsp; Settings </a></li>
          <li class="divider"></li>
          <li><a href="logout.php"> <span class="ion-ios7-locked-outline size-21"></span> &nbsp; Log out</a></li>
        </ul>
	</div>

	<div class=" pull-right" style=" text-align:right;color:#fff; margin-top:3px; margin-right:4px;">
	 	<span id="show-name" class="header-user-profile"><?php echo  $pfile['uname']; ?></span>
		<span id="show-passion"class="header-user-detail"><?php echo  $pfile['team']; ?></span>
	 </div>
	 
	 <div class="pull-right" style="margin-top:-4px; margin-right:15px; "> 
			<ul class="nav navbar-nav" style="margin:0;padding:0" >
				<li class="dropdown" style="height:50px;">
				<a class="dropdown-toggle " data-toggle="dropdown" style="padding:8px 8px; ">
					    <span id="shake" class="ion-ios7-alarm-outline size-38 shake" style="color:#fff;cursor:pointer;"></span>
						<span class="stackbadge total_reminder" >0</span>
			    </a>
			    <ul class="dropdown-menu wrapdd">
			    	<li>
			    	  <div>
			  			<ul class="dd" id="reminder-list"></ul>
		  			</div>
			    	</li>
			    </ul>
			    </li>
			</ul>
	  </div> 
	  
</div>



	<!--  class header -->
	<div class="header" style="margin-top:50px;">
			 <div class="bg-grayLighter metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  
   <!--  end class header -->
   
<div style="margin:0px 20px;">
    
  	  <h2 style="display:inline-block"> Issues </h2>
       <div style="display:inline-block;float:right;text-align:center; margin:10px 10px; border:1px dashed #000; padding:10px; width:150px; font-size:18px; font-family:lato"><span id="totalidea"> 0 </span><br/> Idea  </div>
       <div style="display:inline-block;float:right;text-align:center; margin:10px 10px; border:1px dashed #000; padding:10px; width:150px; font-size:18px; font-family:lato"><span id="totalchreq"> 0 </span><br/> Change Request </div>
      <div style="display:inline-block;float:right;text-align:center; margin:10px 10px; border:1px dashed #000; padding:10px; width:150px; font-size:18px; font-family:lato"> <span id="totalreq"> 0 </span><br/>  Request </div>
      <div style="display:inline-block;float:right;text-align:center; margin:10px 10px; border:1px dashed #000; padding:10px; width:150px; font-size:18px; font-family:lato"> <span id="totalbug"> 0 </span><br/> Bug </div>
  <div style="clear:both"></div>
    
    <button class="btn btn-default new_issue"> New Issue </button> 
    
    <table class="table table-bordered" id="issues-table">
    	<thead>
    		<tr class="primary">
    			<td style="width:5%; text-align:center"> # </td>
    			<td style="width:10%;text-align:center;"> System</td>
    			 <td style="width:10%;text-align:center;"> Type </td>
    			<td style="width:35%;text-align:center"> Issue Detail </td>
    			<td style="width:10%;text-align:center"> Status </td>
    			<td style="width:15%; text-align:center"> Create Date </td>
    			<td style="width:15%; text-align:center"> Create User </td>
    			
    		</tr>
    	</thead>
    	<tbody>
    	
    	</tbody>
    </table>
    
    
    <button class="btn btn-default new_issue"> New Issue </button> | <button class="btn btn-default delete_issue"> Delete  Issue </button>
    <table class="table table-border">
    	<thead>
    		<tr>
    			<td></td>
    		</tr>
    	</thead>
    	<tbody>
    
    	  <tr>
    			<td style="width:20%;font-size:14px; font-family:raleway; vertical-align:middle"> Create Date </td>
    			<td style="width:30%;"><input type="text" style="width:100%" name="credate" readonly></td>
    			<td style="font-size:14px; font-family:raleway; vertical-align:middle"> Create By </td>
    			<td style="width:30%;"><input type="text" style="width:100%" name="creuser" readonly></td>
    		</tr>
    			<!-- 
    		<tr>
    			<td style="width:20%;font-size:14px; font-family:raleway"> Assigned To  </td>
    			<td style="width:30%;">
    				<select>
    					<option></option>
    				</select>
    			</td>
    			<td style="font-size:14px; font-family:raleway"> Owner Name </td>
    			<td style="width:30%;"></td>
    		</tr>
    		 -->
    		 	 <tr>
    		 	<td style="width:20%;font-size:14px; font-family:raleway; vertical-align:middle"> Category1 </td>
    		 	<td style="width:30%;">
    		 		<select name="cat1" style="width:100%">
    					<option value=""></option>
    					<option value="1">Admin</option>
    					<option value="2">Home</option>
    					<option value="3">Campaign</option>
    					<option value="4">Call List</option>
    					<option value="5">Manage List</option>
    					<option value="6">Call Work</option>
    					<option value="7">Report</option>
    					<option value="8">Dash Board</option>
    					<option value="9">--- Asterisk ---</option>
    					<option value="10">--- Database ---</option>
    					<option value="11">Other</option>
    				</select>
    		 	</td>
        		<td style="width:20%; font-size:14px; font-family:raleway"></td>
    		 	<td style="width:30%;"></td>
    		 </tr>
    		 <tr>
    		 	<td style="width:20%;font-size:14px; font-family:raleway; vertical-align:middle"> Category2 </td>
    		 	<td style="width:30%;">
    		 		<select name="cat2" style="width:100%">
    					<option value=""></option>
    					<option value="1">Bug</option>
    					<option value="2">Request</option>
    					<option value="3">Change Request</option>
    					<option value="4">Idea</option>
    				</select>
    		 	</td>
        		<td style="width:20%; font-size:14px; font-family:raleway"></td>
    		 	<td style="width:30%;"></td>
    		 </tr>
    		<tr>
    			<td style="width:20%;font-size:14px; font-family:raleway; vertical-align:middle"> Status </td>
    			<td style="width:30%;"> 
    				<select name="status" style="width:100%">
    					<option value=""></option>
    					<option value="1" >New</option>
    					<option value="2" >Inprogress</option>
    					<option value="3" >Close</option>
    				</select>
    			</td>
    			<td style="width:20%;">&nbsp;</td>
    		 	<td style="width:30%;">&nbsp;</td>
    		</tr>
    		<tr>
    			<td style="font-size:14px; font-family:raleway; vertical-align:middle"> Subject </td>
    			<td colspan="3" ><input type="text" name="sub" style="width:100%"></td>
    		</tr>
    	  <tr>
    			<td style="font-size:14px; font-family:raleway; vertical-align:middle"> Detail </td>
    			<td colspan="3" style=""><textarea name="det" style="width:100%; height:100px;"></textarea> </td>
    		</tr>
    		  <tr>
    			<td style="font-size:14px; font-family:raleway; vertical-align:middle"> Solution </td>
    			<td colspan="3" style=""> Select From KB | FAQ <br/> 
    			 <textarea name="sol" style="width:100%; height:100px;"></textarea>
    			
    			</td>
    		</tr>
    		<tr>
    			<td></td>
    			<td> <button class="btn btn-success save_issue"> Save </button></td>
    		</tr>
    	</tbody>
    	
    </table>
    
   
</div> <!--  end div  -->

</form>
</body>

</html>