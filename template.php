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

<link href="css/default.css" rel="stylesheet">

<style>

/*
ul{
	margin:0;
	padding:0;
}
ul li{
	display:inline-block;
	border:0px solid #fff;
}
*/

.wrapper-dropdown-5 {
    background: none repeat scroll 0 0 #fff;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
    cursor: pointer;
    margin: 0 auto;
    outline: medium none;
    padding: 12px 15px;
    position: relative;
    transition: all 0.3s ease-out 0s;
    width: 200px;

}
.wrapper-dropdown-5:after {
    border-color: #1ab394 transparent;
    border-style: solid;
    border-width: 6px 6px 0;
    content: "";
    height: 0;
    margin-top: -3px;
    position: absolute;
    right: 15px;
    top: 50%;
    width: 0;
 
}
.wrapper-dropdown-5 .dropdown {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: none repeat scroll 0 0 #fff;
    border-color: -moz-use-text-color rgba(0, 0, 0, 0.2);
    border-image: none;
    border-style: none solid;
    border-width: medium 1px;
    left: 0;
    list-style: none outside none;
    max-height: 0;
    overflow: hidden;
    position: absolute;
    right: 0;
    top: 100%;
    padding:0;
    transition: all 0.3s ease-out 0s;
}
.wrapper-dropdown-5 .dropdown li {
    padding: 0;
}
.wrapper-dropdown-5 .dropdown li a {
    border-bottom: 1px solid #e6e8ea;
    color: #333;
    display: block;
    padding: 10px 10px;
    text-decoration: none;
    /* transition: all 0.3s ease-out 0s; */
}
.wrapper-dropdown-5 .dropdown li:hover a {
    color: #1ab394;
}

.wrapper-dropdown-5 .dropdown li:last-of-type a {
    border: medium none;
}
/*
.wrapper-dropdown-5 .dropdown li i {
    color: inherit;
    margin-right: 5px;
    vertical-align: middle;
}
*/

.wrapper-dropdown-5.active {
    background: none repeat scroll 0 0 #1ab394;
    border-bottom: medium none;

    box-shadow: none;
    color: white;

}
.wrapper-dropdown-5.active:after {
    border-color: #b2dfdb transparent;
}
.wrapper-dropdown-5.active .dropdown {
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    max-height: 400px;
}


.wrapper-demo {
    font-weight: 400;
    margin: 60px 0 0;
}
.wrapper-demo:after {
    clear: both;
    content: "";
    display: table;
}

a {
    color: #555;
    text-decoration: none;
}


.timeline {
    list-style: none;
    padding: 20px 0 20px;
    position: relative;
}

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline > li {
        margin-bottom: 20px;
        position: relative;
    }

        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }

        .timeline > li:after {
            clear: both;
        }

        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }

        .timeline > li:after {
            clear: both;
        }

        .timeline > li > .timeline-panel {
            width: 46%;
            float: left;
            border: 1px solid #d4d4d4;
            border-radius: 2px;
            padding: 20px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        }

            .timeline > li > .timeline-panel:before {
                position: absolute;
                top: 26px;
                right: -15px;
                display: inline-block;
                border-top: 15px solid transparent;
                border-left: 15px solid #ccc;
                border-right: 0 solid #ccc;
                border-bottom: 15px solid transparent;
                content: " ";
            }

            .timeline > li > .timeline-panel:after {
                position: absolute;
                top: 27px;
                right: -14px;
                display: inline-block;
                border-top: 14px solid transparent;
                border-left: 14px solid #fff;
                border-right: 0 solid #fff;
                border-bottom: 14px solid transparent;
                content: " ";
            }

        .timeline > li > .timeline-badge {
            color: #fff;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 1.4em;
            text-align: center;
            position: absolute;
            top: 16px;
            left: 50%;
            margin-left: -25px;
            background-color: #999999;
            z-index: 100;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        .timeline > li.timeline-inverted > .timeline-panel {
            float: right;
        }

            .timeline > li.timeline-inverted > .timeline-panel:before {
                border-left-width: 0;
                border-right-width: 15px;
                left: -15px;
                right: auto;
            }

            .timeline > li.timeline-inverted > .timeline-panel:after {
                border-left-width: 0;
                border-right-width: 14px;
                left: -14px;
                right: auto;
            }

.timeline-badge.primary {
    background-color: #2e6da4 !important;
}

.timeline-badge.success {
    background-color: #3f903f !important;
}

.timeline-badge.warning {
    background-color: #f0ad4e !important;
}

.timeline-badge.danger {
    background-color: #d9534f !important;
}

.timeline-badge.info {
    background-color: #5bc0de !important;
}

.timeline-title {
    margin-top: 0;
    color: inherit;
}

.timeline-body > p,
.timeline-body > ul {
    margin-bottom: 0;
}

    .timeline-body > p + p {
        margin-top: 5px;
    }

@media (max-width: 767px) {
    ul.timeline:before {
        left: 40px;
    }

    ul.timeline > li > .timeline-panel {
        width: calc(100% - 90px);
        width: -moz-calc(100% - 90px);
        width: -webkit-calc(100% - 90px);
    }

    ul.timeline > li > .timeline-badge {
        left: 15px;
        margin-left: 0;
        top: 16px;
    }

    ul.timeline > li > .timeline-panel {
        float: right;
    }

        ul.timeline > li > .timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }

        ul.timeline > li > .timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }
}


/* loading screen */

@-webkit-keyframes arc {
  0% {
    border-width: 30px;
  }
  25% {
    border-width: 15px;
  }
  50% {
    -webkit-transform: rotate(27deg);
            transform: rotate(27deg);
    border-width: 30px;
  }
  75% {
    border-width: 15px;
  }
  100% {
    border-width: 30px;
  }
}
@keyframes arc {
  0% {
    border-width: 30px;
  }
  25% {
    border-width: 15px;
  }
  50% {
    -webkit-transform: rotate(27deg);
            transform: rotate(27deg);
    border-width: 30px;
  }
  75% {
    border-width: 15px;
  }
  100% {
    border-width: 30px;
  }
}
.green-100 {
  background-color: #88b257;
}

.green-200 {
  background-color: #7da84d;
}

body {
  padding: 0;
  margin: 0;
  font-family: Tahoma, sans-serif;
}

.container {
  position: relative;
  width: 100vw;
  height: 100vh;
  -webkit-perspective: 1000px;
          perspective: 1000px;
  -webkit-perspective: 1000px;
          perspective: 1000px;
  overflow: hidden;
}

.cube {
  position: absolute;
  bottom: 50%;
  left: 50%;
  width: 30px;
  height: 30px;
  margin-left: -15px;
  margin-top: 0;
}

.cube-2d {
  background-color: #eef8fc;
}
.arc {
  position: absolute;
  bottom: 50%;
  left: 50%;
  margin-left: -70px;
  width: 140px;
  height: 70px;
  overflow: hidden;
}

.arc-cube {
  position: absolute;
  bottom: -70px;
  left: 50%;
  margin-left: -70px;
  width: 140px;
  height: 140px;
  border-style: solid;
  border-top-color: transparent;
  border-right-color: #eef8fc;
  border-left-color: transparent;
  border-bottom-color: transparent;
  border-radius: 50%;
  box-sizing: border-box;
  -webkit-animation: arc 2s ease-in-out infinite;
          animation: arc 2s ease-in-out infinite;
  -webkit-transform: rotate(-200deg);
      -ms-transform: rotate(-200deg);
          transform: rotate(-200deg);
}


/* end loading 1*/


.spinner {
  margin: 100px auto;
  width: 100px;
  height: 60px;
  text-align: center;
  font-size: 10px;
}

.spinner > div {
  background-color: #62cb31;;
  height: 100%;
  width: 6px;
  display: inline-block;
  
  -webkit-animation: stretchdelay 1.2s infinite ease-in-out;
  animation: stretchdelay 1.2s infinite ease-in-out;
}

.spinner .rect2 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

.spinner .rect3 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

.spinner .rect4 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

.spinner .rect5 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

.spinner .rect6 {
  -webkit-animation-delay: -0.7s;
  animation-delay: -0.7s;
}

@-webkit-keyframes stretchdelay {
  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
  20% { -webkit-transform: scaleY(1.0) }
}

@keyframes stretchdelay {
  0%, 40%, 100% { 
    transform: scaleY(0.4);
    -webkit-transform: scaleY(0.4);
  }  20% { 
    transform: scaleY(1.0);
    -webkit-transform: scaleY(1.0);
  }
}

</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

<script>

function DropDown(el) {
	this.dd = el;
	this.initEvents();
}
DropDown.prototype = {
	initEvents : function() {
		var obj = this;

		obj.dd.on('click', function(event){
			event.preventDefault();
			$(this).toggleClass('active');
			event.stopPropagation();
		});	
	}
}

 $(function(){
  
  	var x = { 3 : 'abc' , 5 : 'xyz' };
    x[1] = "hello";
    x[10] = 'testtttt';
  	//var abc = { "axd" :'test' };
	console.log( x[1] );
    
	console.log( x[10] );
	console.log( x[12] );
	delete x[3];
	console.log( x[3] );
		
	 	
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




	$(function() {

		var dd = new DropDown( $('.drop') );

		$(document).click(function(e) {
			e.preventDefault();
			// all dropdowns
			$('.wrapper-dropdown-5').removeClass('active');
		});

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

	<div class="header" style="margin-top:50px;">
			 <div class="bg-grayLighter metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  
	
	<span class="ion-load-c"> </span>
	
	<div class="wrapper-demo">
		<div id="dd" class="drop wrapper-dropdown-5 " tabindex="1">
		John Doe
		<ul class="dropdown">
			<li>
			<a href="#">Profile</a>
			</li>
			<li>
			<a href="#">Settings</a>
			</li>
			<li>
			<a href="#">Log out</a>
			</li>
		</ul>
		</div>
</div>
	
		<br/><br/>
			<br/><br/>
<div class="wrapper-demo">
		<div id="dd" class="drop wrapper-dropdown-5" >
		John Doe
			<ul class="dropdown">
			<li>
			<a href="#">Profile</a>
			</li>
			<li>
			<a href="#">Settings</a>
			</li>
			<li>
			<a href="#">Log out</a>
			</li>
		</ul>
		</div>
</div>
	
	
	<br/><br/>

<?php 

echo "<br/><br/>";

 $x= crypt('a20s5m','$6$rounds=5000$anexamplestringforsalt');
 echo "<br/>".$x."<br/>";
 echo "<br/>";
echo "<br/>";



 $Password = 'SuperSecurePassword123';

 
 //generate hash algorithm
 
// These only work for CRYPT_SHA512, but it should give you an idea of how crypt() works.
$Salt = 'dH[vdc]h;18+'; //uniqid(); // Could use the second parameter to give it more entropy.
$Algo = '6'; // This is CRYPT_SHA512 as shown on http://php.net/crypt
$Rounds = '9898'; // The more, the more secure it is!

// This is the "salt" string we give to crypt().
$CryptSalt = '$' . $Algo . '$rounds=' . $Rounds . '$' . $Salt;

$HashedPassword = crypt($Password, $CryptSalt);
echo "Generated a hashed password: " . $HashedPassword . "<br/>";

$HashedPassword = '$6$rounds=9898$dH[vdc]h;18+$/yORYJhaOJzkrCLS7wlrf0CAQgY4AzXtU.Vy9hvhHacxJbkUUH2m9GxNAjtnNDxUyOqrc1Bf87Pw45k1K5YDk.';

if (crypt($Password, $HashedPassword) == $HashedPassword) {
	echo "match";
	
}else{
	echo "not match";
}

 
echo "<br/>";
echo "<br/>";
 //Key
 
$Password1 = 'WrongPassword';

$Password2 = 'SuperSecurePassword123';

$HashedPassword = '$6$rounds=5000$4d2c68c2ef979$PZTAkwfvCZN0nT4La/0eNNKLt43w1B7DUkFNc9t1bnOG0OJRESnDa1E1H812TZ3CiBqd2qrcFrz2pk/kqpAy3/';

// Now, what about checking if a password is the right password?
if (crypt($Password1, $HashedPassword) == $HashedPassword) {
	echo "Hashed Password matched Password1";
} else {
	echo "Hashed Password didn't match Password1";
}
echo "<br/>";
if (crypt($Password2, $HashedPassword) == $HashedPassword) {
        echo "Hashed Password matched Password2";
} else {
        echo "Hashed Password didn't match Password2";
}

echo "<br/>";
echo "<br/>";

$str ="a10s2m3";
$x =   base64_encode($str);
echo $x;
//$str = 'VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==';
echo base64_decode($x);



/*
if( ip_local != hash ){
	
	"license miss match. only admin and supervisor can access for update license ";
}
*/


$ip=$_SERVER['REMOTE_ADDR'];
$mac_string = shell_exec("arp -a $ip");
$mac_array = explode(" ",$mac_string);
$mac = $mac_array[3];
echo($ip." - ".$mac);

?>

<!--  table  -->


	<!--  start loading pane -->
	    						<div style="background-color: rgba(255,255,255,1); z-index:999; position:absolute; width:100%; height:100%; text-align:center" id="newlist-loading">
	    						<div style="margin-top:5%;">
	    							<h3 style="font-family:raleway; color:#666;"> Loading  </h3>
	    							<p style="color:#777"> Please wait while loading new list</p>
	    						</div>
	    					  	<div class="spinner">
										  <div class="rect1"></div>
										  <div class="rect2"></div>
										   <div class="rect3"></div>
										  <div class="rect4"></div>
										  <div class="rect5"></div>
										  <div class="rect6"></div>
								  </div>
								  </div>
								  <!--  loading pane -->

<i class="icon-book icon-2x"></i> sdfsdf
  
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
  
  <div>
   <ul class="timeline">
        <li>
          <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Mussum ipsum cacilds</h4>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
            </div>
            <div class="timeline-body">
              <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-badge warning"><i class="glyphicon glyphicon-credit-card"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Mussum ipsum cacilds</h4>
            </div>
            <div class="timeline-body">
              <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
              <p>Suco de cevadiss, é um leite divinis, qui tem lupuliz, matis, aguis e fermentis. Interagi no mé, cursus quis, vehicula ac nisi. Aenean vel dui dui. Nullam leo erat, aliquet quis tempus a, posuere ut mi. Ut scelerisque neque et turpis posuere pulvinar pellentesque nibh ullamcorper. Pharetra in mattis molestie, volutpat elementum justo. Aenean ut ante turpis. Pellentesque laoreet mé vel lectus scelerisque interdum cursus velit auctor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac mauris lectus, non scelerisque augue. Aenean justo massa.</p>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge danger"><i class="glyphicon glyphicon-credit-card"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Mussum ipsum cacilds</h4>
            </div>
            <div class="timeline-body">
              <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Mussum ipsum cacilds</h4>
            </div>
            <div class="timeline-body">
              <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge info"><i class="glyphicon glyphicon-floppy-disk"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Mussum ipsum cacilds</h4>
            </div>
            <div class="timeline-body">
              <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
              <hr>
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Mussum ipsum cacilds</h4>
            </div>
            <div class="timeline-body">
              <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-badge success"><i class="glyphicon glyphicon-thumbs-up"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Mussum ipsum cacilds</h4>
            </div>
            <div class="timeline-body">
              <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
            </div>
          </div>
        </li>
    </ul>
  
  
 	 <ul class="cbp_tmtimeline">
				<li>
						<time class="cbp_tmtime" datetime="2013-04-10 18:30">
							<span class="date">today</span>
							<span class="time">	10:05 <span class="semi-bold">am</span></span>
						</time>
						<div class="cbp_tmicon primary">
							<i class="fa fa-comments"></i>
						</div>
						
			<div class="cbp_tmlabel">
			<div class="p-t-10 p-l-30 p-r-20 p-b-20 xs-p-r-10 xs-p-l-10 xs-p-t-5">
			<h4 class="inline m-b-5">
			<h5 class="inline muted semi-bold m-b-5">@johnsmith</h5>
			<div class="muted">Shared publicly - 12:45pm</div>
			<p class="m-t-5 dark-text"> Painter Lucian Freud was also born on December 8th a few years later - in 1922. Here's his "Girl with Roses" </p>
			</div>
			<div class="clearfix"></div>
			<div class="tiles grey p-t-10 p-b-10 p-l-20">
			<ul class="action-links">
			<div class="clearfix"></div>
			</div>
			</div>
			</li>
			
				
			</ul>
  </div>
  
  <div class="spinner">
		  <div class="rect1"></div>
		  <div class="rect2"></div>
		   <div class="rect3"></div>
		  <div class="rect4"></div>
		  <div class="rect5"></div>
		   <div class="rect6"></div>
  </div>
  <!-- 
  <div class="container green-100 animation-07">
  <div class="arc">
    <div class="arc-cube"></div>
  </div>
</div>
 -->
</body>

</html>