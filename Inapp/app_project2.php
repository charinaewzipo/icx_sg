<?php
    session_start();
    if(!isset($_SESSION["uid"])){
       header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
		$pfile = $_SESSION["pfile"];
	}
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
?>
 <!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>TeleSmile 2 </title>
<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">

	 <script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
	 <script type="text/javascript" src="js/app.js"></script>
	 <script>
	 $(function(){
		 	if( $('[name=uniqueid]').val() != ""){
		 		 $.app.load();
			 }
		
		 //	$('#app-pane').load('app_project.php');
			//initial config
			//$('[name=appid]').val()
		 	
		 });
		 </script>

	</head>
	<body>
	<form>


  <h2> Application of campaign 2 </h2>
  
   <input type="text" name="uniqueid" value="<?php echo $id; ?>">
  <br/>
	create campaign : <input type="text" name="cmpid" value="1">
	create calllist id : <input type="text" name="clid" value="10">
	 <input type="hidden" name="appid" value="1">
	create user <input type="text" name="uid" value="10">
	
	
		<table class="table table-border"> 
			<thead>
				<tr>
					<td style="border-bottom:1px solid #000;" colspan="4">Personal Insure</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> First Name </td>
					<td> <input type="text" name="firstname"> </td>
					<td> Last Name </td>
					<td> <input type="text" name="lastname"> </td>
				</tr>
				<tr>
					<td> Mobile Phone </td>
					<td> <input type="text" name="mobile"></td>
				</tr>
				<tr>
					<td>Policy Type</td>
					<td> 
							<input type="radio" name="gender" value="m">  Health Care 
							<input type="radio" name="gender" value="f">  Personal Insure
					</td>
				</tr>
				<tr>
					<td style="vertical-align:top;"> Policy Starter Cost </td>
					<td>
							<input type="radio" name="product" value="p1"> 1,000$ <br/>
							<input type="radio" name="product" value="p2"> 2,000$ <br/>
							<input type="radio" name="product" value="p3">  5,000$ <br/>
							<input type="radio" name="product" value="p4"> 100,000$<br/>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" style="border-top:1px solid #000; padding:5px;">
							<button id="save"> Save </button>
					</td>
				</tr>
			</tfoot>
		</table>
		
</form>
</body>
</html>