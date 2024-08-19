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
<link href="css/ionicons.min.css" rel="stylesheet">
<!-- 
<link href="css/talkslab.css" rel="stylesheet">
 -->
 
 
<link href="css/default.css" rel="stylesheet">


<style>

  .onoffswitch {
    position: relative; width: 71px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    }
    .onoffswitch-checkbox {
    display: none;
    }
    .onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #FFFFFF; border-radius: 15px;
    }
    .onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
    -moz-transition: margin 0.3s ease-in 0s; -webkit-transition: margin 0.3s ease-in 0s;
    -o-transition: margin 0.3s ease-in 0s; transition: margin 0.3s ease-in 0s;
    }
    .onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block; float: left; width: 50%; height: 27px; padding: 0; line-height: 27px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
    }
    .onoffswitch-inner:before {
    content: "ON";
    padding-left: 10px;
    background-color: #A8F018; color: #FFFFFF;
    }
    .onoffswitch-inner:after {
    content: "OFF";
    padding-right: 10px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
    }
    .onoffswitch-switch {
    display: block; width: 19px; margin: 4px;
    background: #FFFFFF;
    border: 2px solid #FFFFFF; border-radius: 15px;
    position: absolute; top: 0; bottom: 0; right: 40px;
    -moz-transition: all 0.3s ease-in 0s; -webkit-transition: all 0.3s ease-in 0s;
    -o-transition: all 0.3s ease-in 0s; transition: all 0.3s ease-in 0s;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px;
    }
    
    .move-right{
    transform: translate(350px,0);
    -webkit-transform: translate(350px,0); /** Chrome & Safari **/
    -o-transform: translate(350px,0); /** Opera **/
    -moz-transform: translate(350px,0); /** Firefox **/
}
    
    .object {
    position: absolute;
    transition: all 1s ease-in-out;
    -webkit-transition: all 2s ease-in-out; /** Chrome & Safari **/
    -moz-transition: all 2s ease-in-out; /** Firefox **/
    -o-transition: all 2s ease-in-out; /** Opera **/
	}
	
	.active{
		opacity:1;
	}
	/*
    In:
moveFromLeftFade
Out:
moveToRightFade 
*/
.leftIn {
/*
    animation-duration: 6s;
    animation-fill-mode: both;
    z-index: 100;
   */ 
    animation: leftIn .6s ease both;
}
.leftOut{

   animation: leftOut .6s ease both;
}

@keyframes leftIn {
	0% {
	    opacity: 0;
	    transform: translateX(100%);
	}
	100% {
	    opacity: 0;
	    transform: translateX(0);
	}
}

@keyframes leftOut {
	0% {
	    opacity: 1;
	    transform: translateX(100%);
	}
	100% {
	    opacity: 0;
	    transform: translateX(0);
	}
}


/*
.fadeInRight {
    animation-name: fadeInRight;
}
*/

.moveFromRightFade{
		animation: moveFromRightFade .7s ease both;
}

@keyframes moveFromRightFade{
	0% {
	    opacity: 0;
	    transform: translateX(100%);
	}
	100% {
	    opacity: 1;
	      z-index:999;
	    transform: translateX(0);
	}
}
    
.moveToLeftFade {
		animation: moveToLeftFade .7s ease both;
}    

@keyframes moveToLeftFade {
	0% {
	    opacity: 1;
	    transform: translateX(0);
	}
	100% {
	    opacity: 0;
	    transform: translateX(-100%);
	}

}

@keyframes rightIn{
	0% {
	    opacity: 0;
	    transform: translateX(-100%);
	}
	100% {
	    opacity: 1;
	    transform: translateX(0%);
	}
}

.rightIn {
		animation: rightIn .7s ease both;
} 


@keyframes rightOut{
	0% {
	    opacity: 1;
	    transform: translateX(0%);
	}
	100% {
	    opacity: 0;
	    transform: translateX(100%);
	}
}

.rightOut {
		animation: rightOut .7s ease both;
} 

    
</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>

<script>
 $(function(){

	
	 		
	$('#test').fadeIn('slow');

	$('[name=campaign]').change( function(){
			console.log( $(this).val() );
			$('#smartpanel').text();
			var val = $(this).val();
			if(  val != ""){
				
				$('#smartpanel').fadeOut('slow' , function(){
					$('#smartpanel').text('');
					$(this).fadeIn('fast', function(){ $(this).html('<span> '+val+' </span>') });
				});
			}else{
				$('#smartpanel').fadeIn('slow' , function(){
						$(this).html('<span class="ion-ios7-telephone-outline size-24" ></span>TeleSmile');
				});
			
			}

			
	});

	$('#l').click( function(){

		
			$('#x1').addClass('moveFromRightFade');
			$('#x2').addClass('moveToLeftFade');

			$('#x1,#x2').removeClass('rightIn','rightOut');
		
	});

	$('#r').click( function(){

		$('#x1,#x2').removeClass('moveFromRightFade','moveToLeftFade');
		
		$('#x2').addClass('rightIn');
		$('#x1').addClass('rightOut');
	});

		
	
	
 })

</script>

<body>
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">


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
	<br/><br/><br/><br/><br/><br/><br/><br/>
	<?php  
	
 	//echo substr_replace("world,",";",-1);
	//test csv file
	/*
		$path = dirname(__FILE__) .'/profiles/attach/test.csv';
		$file = fopen($path,"r");
		$size = filesize( $path );
		echo "file: ".$file;
		echo "size : ".$size ;
	echo"<br/>";
	*/
	
	$x = -2;
	if( $x < 0 ){
		echo "negative";
	}
	
	
	?>
	<h2> TEST </h2>
	
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


<!--  table  -->


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

</body>

</html>