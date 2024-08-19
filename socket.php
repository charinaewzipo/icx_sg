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
<title> Tele Smile </title>
<link href="css/default.css" rel="stylesheet">


<style>

</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>


<script src="http://192.168.1.100:8888/socket.io/socket.io.js"></script>

<script>
 $(function(){

	
	  var socket;

	  $('#connect').click( function(e){
		  	console.log("click connect");
	  			  socket  = io.connect('http://192.168.1.100:8888');	
			      socket.on('connect', function(){
			                     console.log("client connected");
			                    // $('#chat').show();
			                     //socket.emit('uregist', 'a'  , 'test' );
								var extension = $('[name=ext]').val();
			                     //send register msg
			                     var uid = jQuery('[name=uid]').val();
			                     var uext = jQuery('[name=uext]').val();
			                     socket.emit('ureg', { 'uid' : uid , 'ext' : extension });
								 socket.on('ureg', function( data ){
								var msg =  "agent id ["+data.uid+"] on extension ["+data.ext+"] register : "+data.msg+" ["+data.socketid+"]<br/>"; 

										 jQuery('#msg').append(msg)
								 
										console.log( data.msg );
								});


								socket.on('hangup', function(data){
										console.log( data.msg );
										 jQuery('#msg').append(data.msg+"|"+data.action+"<br/>");
										 if( data.action == "hanup"){

											 $('#hangup').trigger('click');
											 
										}
								});
									
			        }); //end socket on conenct

			        
	
					
		});//end click

	  /*
     socket.on('messageRecieve', function(data){
			console.log( data.msg );
		  if( data.msg === "200" ){
				//alert(" OK 200 ");
				$('#callpopup').fadeIn('slow');
		  }
		  if( data.msg === "404" ){
				$('#callpopup').fadeOut('slow');
		}
         
        // AppendMessage(data.msg);
        var div = document.getElementById('Messages');
        var newcontent = document.createElement('div');
        newcontent.innerHTML = data.msg;
        div.appendChild(newcontent);

      });
		*/

		$("#makecall").click( function(e){
				e.preventDefault();
				  socket  = io.connect('http://192.168.1.100:8888');	
				/*
				  socket  = io.connect('http://192.168.1.100:8888');	
			      socket.on('connection', function(){
			                     console.log("client connected");
			                    // $('#chat').show();
			                     //socket.emit('uregist', 'a'  , 'test' );
			
			                     //send register msg
			                     var uid = jQuery('[name=uid]').val();
			                     var uext = jQuery('[name=uext]').val();
			                     socket.emit('ureg', { 'uid' : uid , 'ext' : uext });
								 socket.on('ureg', function( data ){
								var msg =  "agent id ["+data.uid+"] on extension ["+data.ext+"] register : "+data.msg+"<br/>"; 

										 jQuery('#msg').append(msg)
								 
										console.log( data.msg );
								});
					*/

								socket.on('hangup', function(data){
									console.log("receive hangup msg");
										console.log( data.msg );
										 jQuery('#msg').append(data.msg)
										 if( data.action == "hangup"){
												jQuery('#msg').append("Hangup....<br/>");

												jQuery('#hangup').fadeOut('fast', function(){
													jQuery('#makecall').fadeIn('fast');
												});
										}
								});
									
			 //    }); //end socket on conenct
				$('#msg').append("make call....<br/>");

				$(this).fadeOut('fast', function(){
						$('#hangup').fadeIn('fast');
				});
		});


		$("#hangup").click( function(e){
			e.preventDefault();
			$('#msg').append("Hangup....<br/>");

			$(this).fadeOut('fast', function(){
					$('#makecall').fadeIn('fast');
			});
	});
	
	
 })

</script>

<body>
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">

<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="uext"  value="<?php echo $pfile['uext']; ;  ?>">

<div class="navbar navbar-default navbar-fixed-top ">  

	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul>
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
          		<h3 style="color:#666666; display:block; margin-top:5px;">Arnon W </h3>
          </li>
          <li class="divider"></li>
          <li><a href="myprofile.php" ><i class="fa  fa-user"></i> &nbsp; My profile</a></li>
          <li><a href="mysetting.php"><i class="fa  fa-cog"></i> &nbsp; Settings </a></li>
          <li class="divider"></li>
          <li><a href="logout.php"> <i class="fa fa-lock"></i> &nbsp; Log out</a></li>
        </ul>
	</div>

	 
	
	 
	 	<div class="pull-right" style="margin-top:-4px; margin-right:14px;"> 
			<div class="ion-ios7-alarm-outline size-38" style="color:#fff;cursor:pointer"></div>
			<div style="" class="stackbadge">
					9
			</div>
	  </div>
	
</div>


	
						
				

	<div style="margin:90px 20px;">
	
	  <h2> Socket io </h2>
	   <span style="font-size:22px;"> Extension Number : </span><input type="text" name="ext"> <br/><br/>
	   <input type="button" value=" connect io" id="connect"> 
	
	 <input id="makecall"  type="button" value=" make Call "  style="background-color: #147ef0; color:#fff">
	<input id="hangup" type="button" value=" Hangup "  style="display:none;background-color: #ff4f0f; color:#fff">
	 <div id="msg"> </div>
	</div>
	<!-- 
		<div style="width:200px ; height:200px; background-color: #147ef0; color:#fff"> abc</div>
		
		<div style="width:200px ; height:200px; background-color: #ff4f0f;color:#fff"> abc</div>

	<input type="button" value=" left " id="l">
	<input type="button" value=" right " id="r">
		<div style="position:relative; width:100%; height: 5000px; text-align:center" id="trans" >
	
				<div id="x1" style="position:absolute; border:1px solid #E2E2E2; opacity:1" class="">
						<h2> TEST page2 </h2>
						<div style="width:500px">
							TEST abc
						</div>
				</div>
				<div id="x2" style="position:absolute; border:1px solid #E2E2E2; opacity:0" class="" >
						<h2> TEST page1 </h2>
							<div style="width:500px">
							TEST กขค 
						</div>
				</div>
		</div>
	


	
	<div>
  <p>Hover Here</p>
  <p>Greetings!</p>
  <p><small>How Are You?</small></p>
</div>
	
	

	
	
		<div style="display:inline; margin:0; padding:0  ">
		 	<div style="display:inline-block; border:1px solid #000;">
								<input type="text" name="umobile"  style="width:50%;display:inline; margin:0; padding:0" placeholder="abc" autocomplete="off">
				</div><div style="display:table-row;  height:20px; position:relative;">
								<div class="ion-ios7-arrow-up" style="display:; border:1px solid #000; font-size:12px; width:12px;  margin:0; padding:0; position:relative; text-align:center"></div>
								<div class="ion-ios7-arrow-down" style="display:;  border:1px solid #000; font-size:12px; width:12px; margin:0; padding:0; position:relative; text-align:center"></div>
			</div>	
	</div>
	
			 <h2 style="margin:0;padding:0"> Software Feature  </h2> 
			 Touch Of Smile: We Build only Great App <br/>
			 
			 <h4 style="margin:0;padding:0"> Preview Dialer </h4>
			  	คือการแสดงข้อมูลลูกค้า ให้ agent เห็นก่อนที่จะทำการโทรออก <br/>
			  	<ul>
			  		<li> Agent Join ได้หลาย Campaign </li>
			  	</ul>
			
			 
			  <h4 style="margin:0;padding:0"> Auto Dialer </h4>
			    คือการโทรออกโดยอัตโนมัติจากระบบไปยังรายชื่อลูกค้า เมื่อโทรติดแล้ว ระบบจะแจ้งข้อมูลแก่ลูกค้า
			    
			     <h4 style="margin:0;padding:0">Predictive </h4>
			    คือการโทรออกโดยอัตโนมัติ โดนระบบจะคำนวณ สายที่จะต้องโทรในระบบ กับ สถิติการโทรของ agent <br/>
			     จากนั้นจะส่งสายให้ Agent โทรออก   โดยแสดงข้อมูลของลูกค้า  ทำให้ agent ไม่ต้องนั่งว่าง 
			   
	</div>  


ถ้า call ติดแต่ไม่ลง wrapup ?
โปรแกรมต้องบังคับให้ลง wrapup หรือไม่

ตอนกด makecall 
ต้อง handle script ด้วยว่าถ้า รอ response มากกว่า 6 sec
ให้ alert " phone not ready "

design  status การโทรด้วย
Make call ->  ปุ่มเปลี่ยนสถานะเป็น hangup เมื่อได้รับ channel_id กลับมา
		     ถ้าเป็นไปได้ ตอนที่กด makecall ให้ขึ้นเวลาที่ agent ใช้สายด้วย
		     ถ้าเป็นไปได้ แบ่งเป็น  2 ตอนคือ 1 ระหว่างรอสาย ( phone ring )
		     ระหว่างสนทนาสาย ( talk time ) 
		 be the best is 
		     แสดงสถานะระหว่าง make call ด้วย ringing 
		   

Hangup -> stop talk time count 
		 enable next list , 





  <div class="onoffswitch">
										    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
										    <label class="onoffswitch-label" for="myonoffswitch">
											    <span class="onoffswitch-inner"></span>
											    <span class="onoffswitch-switch"></span>
									   		 </label>
									    </div> 
									     
  
  <table class="table table-border">
  		<thead>
  			<tr>
  				<td style="text-align:center;vertical-align:middle"></td>
  			</tr>
  		</thead>
  		<tbody>
  			<tr>
  				<td></td>
  			</tr>
  		</tbody>
  		<tfoot>
  		</tfoot>
  </table>
 -->
</body>

</html>