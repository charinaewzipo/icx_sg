<!DOCTYPE html>
<html>

<?php
    session_start();
    if(!isset($_SESSION["uid"])){
       header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
		$pfile = $_SESSION["pfile"];
	}
 ?>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title> ICX </title>
<link href="css/ionicons.min.css" rel="stylesheet">
<link href="css/talkslab.css" rel="stylesheet">
<link href="css/default.css" rel="stylesheet">

<style>

#setting-ul{
	margin:0;
	padding:0;
}
#setting-ul li{
	display:block;
	padding:2px;
	border:0px solid #fff;
}



</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>

<script>

$(function(){

	$('.calc').click( function(e){
		e.preventDefault();

		var url = "finance_process.php";
  	    var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
        $.ajax({   'url' : url, 
        	   'data' : { 'action' : 'cal','data':formtojson }, 
			   'dataType' : 'html',   
			   'type' : 'POST' ,  
			   'beforeSend': function(){
				   //set image loading for waiting request
				   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
				},										
				'success' : function(data){ 
					
					//console.log( data );
					  var  result =  eval('(' + data + ')'); 


				console.log( result.cal.length );
						 
					    var $table = $('#financecal-table tbody'); 
						$table.find('tr').remove();
						
						var i=0;
						var txt = "";
//{"result":"empty","data":{"total":"0","last_reminder":"","last_re_time":""},"remind":null}
						console.log( result.cal[3].seq );
					//	console.log( result.cal[1].seq );
					
					console.log( result.cal.length );
								 for( i; i<10 ; i++){
							
								     txt +="<tr><td style='vertical-align:middle; text-align:center' >&nbsp;"+result.cal.seq+"&nbsp;</td>"+
								    		   "<td >&nbsp;</td>"+
								    		   "<td >&nbsp;</td>"+		
								    		   "<td >&nbsp;</td>"+		
								    		   "<td >&nbsp;</td>"+		
								    		   "<td >&nbsp;</td>"+		
								    		   "<td >&nbsp;</td>"+		
								    		   "<td >&nbsp;</td>"+		
								    		   "<td >&nbsp;</td>"+		
											   "<td >&nbsp;</td></tr>"; 
								     
								
								
								    } 
								 $table.append(txt);
					
					
				}//end success
				
        })//end ajax


        
	});
		
	    	
	
	
});

</script>

<body>
<form>
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">


<div class="navbar navbar-default navbar-fixed-top ">  

	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul>
				<li style="width:140px; text-align:center; vertical-align:middle; "> 	
					<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
						<span class="ion-ios7-telephone-outline size-24" ></span>Tubtim
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
          		<h3 style="color:#666666; display:block; margin-top:5px;">Arnon W </h3>
          </li>
          <li class="divider"></li>
          <li><a href="myprofile.php" ><i class="fa  fa-user"></i> &nbsp; My profile</a></li>
          <li><a href="mysetting.php"><i class="fa  fa-cog"></i> &nbsp; Settings </a></li>
          <li class="divider"></li>
          <li><a href="logout.php"> <i class="fa fa-lock"></i> &nbsp; Log out</a></li>
        </ul>
	</div>

	 
	<div class=" pull-right" style=" text-align:right;color:#fff; margin-top:3px; margin-right:4px;">
	 	<span id="show-name" class="header-user-profile"><?php echo  $pfile['uname']; ?></span>
		<span id="show-passion"class="header-user-detail"><?php echo  $pfile['dept']; ?></span>
	 </div>
	 
	 	<div class="pull-right" style="margin-top:-4px; margin-right:14px;"> 
			<div class="ion-ios7-alarm-outline size-38" style="color:#fff;cursor:pointer"></div>
			<div style="" class="stackbadge">
					9
			</div>
	  </div>
	
</div>

<!-- 
	<div class="header" style="margin-top:50px;">
			 <div class="bg-grayLighter metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  
 -->

	
	<div class="header" style="margin-top:50px;">

		
	</div>
	
	<div style="padding:2px 20px; border:0px solid #fff">
		<h2 style="magin:0;padding:0; font-family:raleway; font-weight:300; color:#555;"> Test Interest Rate </h2>
		
		<div style="float:left; width:20%; text-align:right;">
			<ul id="setting-ul" style="margin:0 20px;">
				<li>ประเภทดอกเบี้ย</li>
				<li>  <select name="loan_interest_mode" style="width:180px; height:28px; text-align:right;"><option value="2" > Effective Rate &nbsp;</option><option value="1"> Flat Rate &nbsp;</option></select></li>
				<li> เงินต้น/เงินกู้ (บาท)</li>
				<li> <input type="text" name="loan_amount" autocomplete="off" value=""></li>
				<li>จำนวนเดือน/งวด</li>
				<li> <input type="text" name="loan_month" autocomplete="off" value="10"></li>
				<li>ชำระต่อเดือน (บาท) </li>
				<li> <input type="text" name="pay_monthly" autocomplete="off" value=""></li>
				<li>อัตราดอกเบี้ย/ปี (%) </li>
				<li> <input type="text" name="loan_interest_rate" autocomplete="off" value=""></li>
				<!-- 
				<li>วิธีคำนวณดอกเบี้ย</li>
				<li> <input type="text" name="loan_interest_mode" autocomplete="off" value=""></li>
				 -->
				<li>วันที่เริ่มต้นคิดดอกเบี้ย</li>
				<li> <input type="text" name="pay_date" autocomplete="off" value=""></li>
				<li> <button class="btn btn-primary calc"> คำนวณ </button></li>
			</ul>
		</div>
		
			<div style="float:right; width:80%;">
					<table class="table table-border" >
						<tbody>
							<tr>
								<td>เงินต้น <br/>
								<span>฿2,800,000.00 </span>
								</td>
								<td>อัตราดอกเบี้ย<br/>
								<span>฿2,800,000.00 </span>
								</td>
								<td>ชำระต่อเดือน<br/>
								<span>฿2,800,000.00 </span>
								</td>
								<td>จำนวนเดือน / งวด<br/>
								<span>฿2,800,000.00 </span>
								</td>
							</tr>
							<tr>
								<td>รวมค่างวด <br/>
								<span>฿2,800,000.00 </span>
								</td>
								<td>รวมเงินต้น<br/>
								<span>฿2,800,000.00 </span>
								</td>
								<td>รวมดอกเบี้ย<br/>
								<span>฿2,800,000.00 </span>
								</td>
								<td>ยอดหนี้คงเหลือ<br/>
								<span>฿2,800,000.00 </span>
								</td>
							</tr>
						</tbody>
					</table>
					
					<table class="table table-bordered" id="financecal-table">
						<thead>
							<tr class="primary">
								<td colspan="10"> Calculation</td>
							</tr>
							<tr>
								<td class="text-center"> งวด </td>
								<td class="text-center"> กำหนดวันชำระ </td>
								<td class="text-center">วัน</td>
								<td class="text-center">เงินต้นยกมา</td>
								<td class="text-center">ต้น+ดอกเบี้ย</td>
								<td class="text-center">ดอกเบี้ย</td>
								<td class="text-center">ค่างวด</td>
								<td class="text-center">เป็นเงินต้น</td>
								<td class="text-center">เป็นดอกเบี้ย</td>
								<td class="text-center">คงเหลือ</td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
			</div>
		<div style="clear:both"></div>
	</div>
		
	
		
</form>
</body>

</html>