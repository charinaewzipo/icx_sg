<?php
include("../function/session.inc");
include("../function/StartConnect.inc");
include("../function/checkSession.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Application Center ::.</title>

<!-- CSS -->
<link href="../style/css/trans.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="style/css/ie6.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="style/css/ie7.css" /><![endif]-->


<!-- JavaScripts-->
<script type="text/javascript" src="../style/js/jquery.js"></script>
<script type="text/javascript" src="../style/js/jNice.js"></script>

<script type="text/javascript" src="../scripts/jquery-1.4.2.min.js"></script>
<!--<script type="text/javascript" src="scripts/simpla.jquery.configuration.js"></script>-->
<script type="text/javascript" src="../scripts/jquery-ui-1.8.2.custom.min.js"></script>

<link href="../css/smoothness/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css"/>
<script src="../scripts/jquery-1.4.2.min.js"></script>
<script src="../scripts/jquery-ui-1.8.2.custom.min.js"></script>

<SCRIPT type=text/javascript>
	$(function() {
		$('#datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
	});
</SCRIPT>

<SCRIPT type=text/javascript>
	$(function() {
		$('#datepicker2').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
	});
</SCRIPT>
</head>

<body>
<?php
$_SESSION["r_id"] = $row["id"];
$_SESSION["r_firstname"] = $row["firstname"];
$_SESSION["r_username"] = $row["username"];
$_SESSION["r_level"] = $row["level"];
$_SESSION["r_mess"] = $row["mess"];
$keyword = $_POST["keyword"];
$AppStatus = $_POST["AppStatus"];
$start = $_POST["startdate"];
$end = $_POST["enddate"];
$TSRID = $_SESSION["username"];
$level = $_SESSION["level"];

$start_dd = substr($start,0,2);
$start_mm = substr($start,3,2);
$start_yy = substr($start,6,4);
// $startdate = $start_dd."/".$start_mm."/".$start_yy;
$startdate = $start_yy.$start_mm.$start_dd;

$end_dd = substr($end,0,2);
$end_mm = substr($end,3,2);
$end_yy = substr($end,6,4) ;
//$enddate = $end_dd."/".$end_mm."/".$end_yy;
$enddate =  $end_yy.$end_mm.$end_dd;

?>
	<div id="wrapper">
    	<!-- h1 tag stays for the logo, you can use the a tag for linking the index page -->
    	<h1 style="background-image:url(../style/img/logo-report.png); background-repeat:no-repeat;"></h1>
        
        <ul id="mainNav">
       		 <li><a href="../home.php">MAIN MENU</a></li> <!-- Use the "active" class for the active menu item  -->
            <li><a href="#" class="active">SEARCH</a></li> <!-- Use the "active" class for the active menu item  -->
<?php 
if ($_SESSION["level"] == 'admin' )
{
?>
            <li><a href="report/genYesfile.php">Report Center</a></li>
            
<?php 
}
?>
        	<li class="logout"><a href="../function/logout.php">LOGOUT</a></li>
        </ul>
        <!-- // #end mainNav -->

		<div id="tab_user"><font class="blue">User : </font><?php print $TSRID ?></div>
        <div id="containerHolder">
			<div id="container">
                <!-- h2 stays for breadcrumbs -->
                <h2 style=" width:900px;"><a href="#">Project Name</a> &raquo; <a href="#" class="active">เมืองไทยประกันชีวิต Saving Smile 20/8</a></h2>
                
          <div style=" width: 880px;" id="main">
                	<form name="search" action="search.php"  method="post"  >
                    	<fieldset>
                        	<p style="padding: 3px 0 3px 0;">ค้นหาข้อมูลลูกค้า :</p> 
                            <p><input type="text" class="text-long"  name="keyword" value=""/><input type="submit" value="ค้นหา" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onClick="window.open( 'Application/newApp.php'); "  value="New Application" /></p>
                            <p><label>Start Date (วันที่กรอก App) :</label><input name="startdate" type="text" class="text-long" id="datepicker" /></p>
                            <p><label>End Date (วันที่กรอก App) :</label><input name="enddate" type="text" class="text-long" id="datepicker2" /></p>
                            <p>สถานะ <select name="AppStatus" >
                            	<option value=""></option>
                    			<option value="Pending">Pending</option>
                    			<option value="QC_Approved">QC_Approved</option>
                    			<option value="Reject">Reject</option>
                  				</select></p>
              				<p style="color:#F00; font-size:12px;"><?php print  $_SESSION["mess"]; ?></p>
							
<style>
th{ border: 1px solid #BBBBBB; padding: 5px 10px 5px 10px; }
td{ border: 1px solid #BBBBBB; padding: 5px 10px 5px 10px; background-color:#FFF;}
td a { text-decoration: none; background-color:#FFF;}
td a:hover { text-decoration: underline;}
</style>
                            	<table style="border: 1px solid #BBBBBB; width:840px;">
                                	<tr style=" background-color:#D31145; color:#FFF;">
                                    	<th width="10%">Proposal_No</td>
                                        <th width="20%">Firstname</td>
                                        <th width="20%">Lastname</th>
                                        <th width="15%">Proposal_Date</th>
                                        <th width="15%">AppStatus</th>
                                        <th width="10%">Owner</th>
										<th width="10%">Action</th>
                                    </tr>
                                    
<?php




 $SQL = "select  * from app_mt where RecordType = '1' " ;
 	if($level == 'tsr' )
	{
		
			if( $AppStatus != '' )
			{
				$SQL .= " AND AppStatus = '".$AppStatus."' ";	
				$SQL .= " AND tsr_id = '".$TSRID."' ";
			}
			elseif( $keyword != '' )
			{
				$SQL .= " AND tsr_id = '".$TSRID."' ";
				$SQL .= " AND ( Firstname like '%".$keyword."%' OR Lastname like '%".$keyword."%' OR X_referencepolicynumber like '%".$keyword."%' ) ";	
			}
			elseif ($startdate != "" && $enddate != "" )
			{
				$SQL .= " AND tsr_id = '".$TSRID."' ";
				$SQL .= " AND PolicyEffectiveDate BETWEEN '".$startdate ."' AND '".$enddate."'";
			}
			 elseif ($keyword == "" && $AppStatus == "" && $startdate == "" && $enddate == "" )
			{
				$SQL .= " AND AppStatus = 'ghghhhhgtgrgdrgrggsdad9878665ggjhk' ";
			}
	}else {
		
		
			if( $AppStatus != '' )
			{
				$SQL .= " AND AppStatus = '".$AppStatus."' ";	
			}
			elseif( $keyword != '' )
			{
				$SQL .= " AND ( Firstname like '%".$keyword."%' OR Lastname like '%".$keyword."%' OR X_referencepolicynumber like '%".$keyword."%' ) ";	
			}
			elseif ($startdate != "" && $enddate != "" )
			{
				$SQL .= " AND PolicyEffectiveDate BETWEEN '".$startdate ."' AND '".$enddate."'";
			}
			 elseif ($keyword == "" && $AppStatus == "" && $startdate == "" && $enddate == "" )
			{
				$SQL .= " AND AppStatus = 'ghghhhhgtgrgdrgrggsdad9878665ggjhk' ";
			}
		
		
	}
	
	
	


 		
 //$SQL = "select  * from tokiomarine_hib_app order by Proposal_No" ;
 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");

	while($row = mysql_fetch_array($result))
{ 
 $X_referencepolicynumber =  ($row["X_referencepolicynumber"]);
 $Firstname =  ($row["Firstname"]);
 $Lastname  = $row["Lastname"];
 $SalesOrderDate = $row["SalesOrderDate"];
 $AppStatus = $row["AppStatus"];
 $owner = $row["TMCode"];
 $Id = ($row["X_referencepolicynumber"]);

 

 
 
 print "<tr>
 			<td><a href='Application/appDetail.php?Id=$Id' target='_blank'>$X_referencepolicynumber</a></td>
		    <td><a href='Application/appDetail.php?Id=$Id' target='_blank'>$Firstname</a></td>
 			<td><a href='Application/appDetail.php?Id=$Id' target='_blank'>$Lastname</a></td>
			<td>$SalesOrderDate</td>
			<td>$AppStatus</td>
			<td>$owner</td>
			<td><a href='Application/genForm.php?Id=$Id' target='_blank'>Gen App</a></td>
			</tr>";
}  mysql_free_result($result);
?>							
<!--                                    <tr style="background-color:#fff;">
                                    	<td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="background-color:#fff;">
                                    	<td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="background-color:#fff;">
                                    	<td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="background-color:#fff;">
                                    	<td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="background-color:#fff;">
                                    	<td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="background-color:#fff;">
                                    	<td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
-->
                                </table>
                            
                            </p>
                            </p>
                        </fieldset>
                    </form>
                </div>
                <!-- // #main -->
<?php session_unregister('mess');
?>
                <div class="clear"></div>
            </div>
            <!-- // #container -->
        </div>	
        <!-- // #containerHolder -->
        
        <p id="footer">&copy; Copyright 2013 all right reserved.</p>
    </div>
    <!-- // #wrapper -->
</body>
</html>
