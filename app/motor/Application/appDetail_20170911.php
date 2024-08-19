<?php

ob_start();
session_start();

include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");
//include("../../function/checkSession.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />

<link href="../../css/smoothness/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css"/>

<script src="../../scripts/jquery-1.4.2.min.js"></script>
<script src="../../scripts/jquery-ui-1.8.2.custom.min.js"></script>

<title>Application Form</title>
<script type="text/javascript" src="../scripts/function.js"></script>

<SCRIPT type=text/javascript>
	$(function() {
		$('#datepicker3').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy'
		});
	});

	$(function() {
		$('#datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			isBuddhist: true
			
		});
	});

	$(function() {
		$('#datepicker2').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy'
		});
	});
	
	$(function() {
		$('#datepicker4').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy'
		});
	});
	
	$(function() {
		$('#datepicker5').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy'
		});
	});
</SCRIPT>

<script>
function showModel(str) {
    if (str == "") {
       // document.getElementById("result_car_model").innerHTML = "";
        return;
    } else { 
	    //alert("I am an alert box!");
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result_car_model").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getModel.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>

<script>
function showInstallments(str) {
    if (str == "") {
        document.getElementById("result_Installmentsl").innerHTML = "";
        return;
    } else { 
	    //alert("I am an alert box!");
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result_Installmentsl").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getInstallmentsl.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>

<script>
function showCC(str) {
    if (str == "") {
        document.getElementById("result_car_engine").innerHTML = "";
        return;
    } else { 
	    //alert("I am an alert box!");
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result_car_engine").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getCC.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>

<script>
	function AjaxSearch(str) {
			  //alert("Call Function Is Work!!");
			  HttPRequest = false;
			  if (window.XMLHttpRequest) { // Mozilla, Safari,...
				 HttPRequest = new XMLHttpRequest();
				 if (HttPRequest.overrideMimeType) {
					HttPRequest.overrideMimeType('text/html');
				 }
			  } else if (window.ActiveXObject) { // IE
				 try {
					HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
				 } catch (e) {
					try {
					   HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e) {}
				 }
			  }
			  if (!HttPRequest) {
				 alert('Cannot create XMLHTTP instance');
				 return false;
			  }
				var url = 'AjaxSearchInsure.php';
				var pmeters = 'car_brand='+(document.getElementById('car_brand').value)+
							           '&car_model='+(document.getElementById('car_model').value)+
								    	'&car_year='+(document.getElementById('car_year').value)+
										'&car_engine='+(document.getElementById('car_engine').value);

				//alert(pmeters);

				HttPRequest.open('POST',url,true);
				HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				HttPRequest.setRequestHeader("Content-length", pmeters.length);
				HttPRequest.setRequestHeader("Connection", "close");
				HttPRequest.send(pmeters);
				HttPRequest.onreadystatechange = function()
				{
					 if(HttPRequest.readyState == 3)  // Loading Request
					  {
					   document.getElementById("data_result").innerHTML = "Now is Loading...";
					  }

					 if(HttPRequest.readyState == 4) // Return Request
					  {
					   document.getElementById("data_result").innerHTML = HttPRequest.responseText;
					  }

				}

		   }
		   
		   
function showBank(str) {
	
	var insurer = document.App.insurer.value;
	//alert (insurer);
	
    if (str == "") {
		
        return;
    } else { 
	    //alert("I am an alert box!");
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("payment_account").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getBank.php?q="+str+"&insurer="+insurer,true);
        xmlhttp.send();
    }
}	   

function fncSubmit(strPage)
{
	if(strPage == "page1")
	{
		document.App.action="app_update.php";
	}
	
	if(strPage == "page2")
	{
		document.App.target="_blank";
		document.App.action="print_pdf2.php";
	}	
	
	if(strPage == "page3")
	{
		document.App.target="_blank";
		document.App.action="genForm.php";
	}	
	document.App.submit();
}



function get_payment(str){
	 
         var trans_id = (str) ;
		// alert (trans_id);
		 
		document.App.payment_id.value = trans_id ;

	 }


</script>

<style>
#table_premium  {
    text-align: center;
	width:100%;

}

#table_premium thead {
    text-align: center;
	color:#fff;
	background-color:#31bc86;
	width:100%;

} 

#table_premium tbody  {
    text-align: center;
	color:#000;
	background-color:#fff;
	width:100%;

} 


#table_premium td  {
	padding:0 5px 0 5px;
} 


</style>

</head>

<body>

	<?php

	$app_number = $_GET["Id"];

	
		
	 $SQL = "select  * from t_motor_app where app_number = '$app_number' " ;
	  $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	  	while($row = mysql_fetch_array($result))
	 {
		 
	    $Owner = $row["agent_id"];
		$strSQL2 = "SELECT * FROM t_agents WHERE agent_id = '$agent_id' ";
		$result2= mysql_query($strSQL2);
		while($objResult2 = mysql_fetch_array($result2))
		{
			$first_name = $objResult2["first_name"] ;
			$last_name = $objResult2["last_name"] ;
			$tsr_code = $objResult2["sales_agent_code"] ;
			$license_code = $objResult2["sales_license_code"] ;
			$team_id = $objResult2["team_id"];
		}

	?>


<div id="content">
   	<div id="header">

  </div>
        <div id="top-detail">
       	  <div id="app-detail">
<table>
                	<tr>
                    	<td><h1>Product Name : </h1></td>
                        <td> Motor </td>
                    </tr>
            </table>
          </div>
        	<div id="user-detail">
<table align="right">
            	<tr>
                	<td><h1>Date : </h1></td>
                    <td><?php echo "$currentdate_app" ?></td>
                    <td>&nbsp;</td>
                    <td><h1>TSR : </h1></td>
                    <td><?php echo $first_name ;?>&nbsp;<?php echo $last_name ;?></td>
                </tr>
            </table>
            </div>
        </div>
<form id="App" name="App" method="post" action="xxxxx.php">


        <!--start  form 1 -->
        <div>
        <fieldset id="form-content" >
        	<table id="table-form">
                <tr>
				  <td>เลขที่รับแจ้ง : </td>
                   <td><input type="text" name="issue_no" maxlength="15" value="<?php echo $row["issue_no"]; ?>" /></td>
                   <td>&nbsp;</td>
                   <td>Application No : </td>
                   <td><input type="text" name="app_number" maxlength="15" value="<?php echo $row["app_number"]; ?>" readonly="readonly" /></td>
                   <td>Policy No : </td>
                   <td><input type="text" name="policy_no" maxlength="15" value="<?php echo $row["policy_no"]; ?>"  /></td>
                </tr>
            </table>
        </fieldset>
 		</div>
        <!--end  form 1 -->

        <!--start  form 2-->
        <div>
        <fieldset id="form-content">
        <br /><h1>รายละเอียดผู้เอาประกัน</h1><br />
        <legend>ผู้เอาประกัน</legend>
		
        	<table id="table-form">
            	<tr>
				  <td>คำนำหน้าผู้เอาประกัน : </td>
                   <td>
										 <select name="Title" required00>
										 	<option value="<?php echo $row["Title"]; ?>"><?php echo $row["Title"]; ?></option>
											<?php
                                            $strSQL = "SELECT * FROM t_salutation ORDER BY id ASC";
                                            $objQuery = mysql_query($strSQL);
                                            while($objResuut = mysql_fetch_array($objQuery))
                                            {
                                            ?>
                                            <option value="<?php echo $objResuut["desc"];?>"><?php  echo $objResuut["desc"];?></option>
                                            <?php
                                            }
                                            ?>
		  					 		</select></td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
				  	<td>ชื่อผู้เอาประกัน: </td>
                   <td><input type="text" name="Firstname" maxlength="60" required00 value="<?php echo $row["Firstname"]; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>นามสกุล : </td>
                   <td><input type="text" name="Lastname" maxlength="60" required00 value="<?php echo $row["Lastname"]; ?>"/></td>
                </tr>
                
                <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>ข้อมูลรถยนต์</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>ทะเบียนรถ : </td>
                   <td><input type="text" name="car_license" maxlength="20" size="15"  value="<?php echo $row["car_license"]; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>เลขตัวถัง : </td>
                   <td><input type="text" name="body_no" maxlength="20" size="30" value="<?php echo $row["body_no"]; ?>"/></td>
              </tr>
              <tr>
              	   <td>เลขเครื่องยนต์ : </td>
                   <td><input type="text" name="engine_no" maxlength="50"  size="30"  value="<?php echo $row["engine_no"]; ?>" /></td>
                   <th>&nbsp;</th>
                   <td>ปีที่จดทะเบียน : </td>
                   <td><input type="text" name="car_regit_year" maxlength="50"  size="10" value="<?php echo $row["car_regit_year"]; ?>" /></td>
              </tr>
              
              <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>ค้นหาประกันภัย</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>ยี่ห้อรถ : </td>
                   <td>
                   	<select name="car_brand" id="car_brand" required00 onchange="showModel(this.value)">
                        <option value="<?php  echo $row["car_brand"];?>"><?php  echo $row["car_brand"];?></option>
                        <?php
                        $strSQL = "SELECT car_brand FROM t_motor_premium GROUP BY car_brand ORDER BY car_brand ASC";
                        $objQuery = mysql_query($strSQL);
                        while($objResuut = mysql_fetch_array($objQuery))
                        {
                        ?>
                        <option value="<?php  echo $objResuut["car_brand"];?>"><?php  echo $objResuut["car_brand"];?></option>
                        <?php
                        }
                        ?>
                     </select>
                   </td>
                   <th>&nbsp;</th>
                   <td>รุ่นรถ : </td>
                   <td>
                   <div id="result_car_model">
                   	<select name="car_model" id="car_model" required00 onchange="showCC(this.value)">
                        <option value="<?php echo $row["car_model"]; ?>"><?php echo $row["car_model"]; ?></option>
                     </select>
                   </div>
                   </td>
              </tr>
              
              <tr>
                   <td>อายุรถ : </td>
                   <td><select name="car_year" id="car_year" required00>
                        <option value="<?php echo $row["car_year"]; ?>"><?php echo $row["car_year"]; ?></option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        </select>
                        ปี</td>
                   <th>&nbsp;</th>
                   <td>ขนาดเครื่องยนต์ : </td>
                   <td><div id="result_car_engine">
                   	<select name="car_engine" id="car_engine" required00 onchange="">
                        <option value="<?php echo $row["car_engine"]; ?>"><?php echo $row["car_engine"]; ?></option>
                     </select>
                   </div></td>
              </tr>
	      <tr>  
				  <td>ทุนคุ้มครอง : </td>
                  <td><input type="text" name="car_cover" maxlength="13"  size="20" value="<?php echo $row["car_cover"]; ?>" required00/></td>
                  <td>&nbsp;</td>
              </tr>	
              <tr><td><input name="search" type="button" onclick="AjaxSearch()" value=" ค้นหาประกัน " /></td></tr>
              </table>

              <div id="data_result" style="margin-top:20px;"></div>
              
              <table id="table_premium">
                <thead>
                <tr>
                    <th colspan="5" >รายละเอียดประกันภัย</th>
                    <th colspan="6">ตางรางความคุ้มครอง</th>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <th >บริษัทประกัน</th>
                    <th >ประเภทประกัน</th>
                    <th style="width: 150px;">ทุนคุ้มครอง</th>
                    <th >ซ่อม</th>
                    <th >ค่าเบี้ย</th>
                    <th>ทรัพย์สิน</th>
                    <th>บุคคล</th>
                    <th>สูญหาย/ไฟไหม้</th>
                    <th>อุบัติเหตุส่วนบุคคล</th>
                    <th>ค่ารักษา</th>
                    <th>ประกันตัวผู้ขับขี่</th>
                    <th style="width: 100px;">Select</th>
                </tr>
                </thead>
                <tbody>
<?php 

$insure_select = $row["insure_select"];


	  $SQL_pk = "select  * from t_motor_map_package where app_number = '$app_number' " ;
	  $result_pk = mysql_query($SQL_pk,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	  	while($row_pk = mysql_fetch_array($result_pk))
	 {
		 $package_id = $row_pk["package_id"];
		 $SQL_pk2= "select  * from t_motor_premium where id = '$package_id' " ;
	 	 $result_pk2 = mysql_query($SQL_pk2,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	  		while($objResuut = mysql_fetch_array($result_pk2))
			 {
				
				// check การซ่อม
											$premium_type_1_DG = $objResuut["premium_type_1_DG"];
											$premium_type_1_OG = $objResuut["premium_type_1_OG"];
											$premium_type_2 = $objResuut["premium_type_2"];
											$premium_type_2P = $objResuut["premium_type_2P"];
											$premium_type_3 = $objResuut["premium_type_3"];
											$premium_type_3P = $objResuut["premium_type_3P"];
											
											if($premium_type_1_DG != ''){
												$insure_type = 'ชั้น 1';
												$clame_type = 'ห้าง';
												$premium = $premium_type_1_DG;
												
											}elseif($premium_type_1_OG != ''){
												$insure_type = 'ชั้น 1';
												$clame_type = 'อู่';
												$premium = $premium_type_1_OG;
												
											}elseif($premium_type_2 != ''){
												$insure_type = 'ชั้น 2';
												$clame_type = '';
												$premium = $premium_type_2;
												
											}elseif($premium_type_2P != ''){
												$insure_type = 'ชั้น 2 Plus';
												$clame_type = '';
												$premium = $premium_type_2P;
												
											}elseif($premium_type_3 != ''){
												$insure_type = 'ชั้น 3';
												$clame_type = '';
												$premium = $premium_type_3;
												
											}elseif($premium_type_3P != ''){
												$insure_type = 'ชั้น 3 Plus';
												$clame_type = '';
												$premium = $premium_type_3P;
											}
											
											
											$sum_insured_start = $objResuut["sum_insured_start"];	
											$sum_insured_end = $objResuut["sum_insured_end"];
											
											$cover_asset = $objResuut["cover_asset"];
											if($cover_asset != ''){
												$cover_asset = number_format($cover_asset);
											}

											$cover_person = $objResuut["cover_person"];
											if($cover_person != ''){
												$cover_person = number_format($cover_person);
											}
											
											$cover_bail_out = $objResuut["cover_bail_out"];
											if($cover_bail_out != ''){
												$cover_bail_out = number_format($cover_bail_out);
											}
											
											$cover_xxx = $objResuut["cover_medical_free"];
											if($cover_xxx != ''){
												$cover_xxx = number_format($cover_xxx);
											}
											
	
											$cover_pa = $objResuut["cover_pa"];
											if($cover_pa != ''){
												$cover_pa = number_format($cover_pa);
											} 
											
											
											if($insure_select == $objResuut["id"]){
												$selected_insure = 'checked';
											}else{
												$selected_insure = '';
											}
			
?>

<tr>
	<td><?php echo $objResuut["insurer"]; ?></td>
    <td><?php echo $insure_type; ?></td>
    <td><?php echo number_format($objResuut["sum_insured_start"]).' - '.number_format($objResuut["sum_insured_end"]) ; ?></td>
    <td><?php echo $clame_type; ?></td>
    <td><?php echo number_format($premium); ?></td>
    <td><?php echo $cover_asset ; ?></td>
    <td><?php echo $cover_person ; ?></td>
    <td><?php echo $cover_lost_fire ; ?></td>
    <td><?php echo $cover_pa ; ?></td>
    <td><?php echo $cover_xxx ; ?></td>
    <td><?php echo $cover_bail_out ; ?></td>
    <td><input  type="radio"  name="insure_select" value="<?php echo $objResuut["id"]; ?>" <?php echo $selected_insure ;?> /> </td>
</tr>

<?php
				 
	
		 
			 }
		 
	 }


?>							
			   

                            
                
                </tbody>
                </table>
                              
              
              <table id="table-form">
              <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>ที่อยู่ปัจจุบัน</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>เลขที่ : </td>
                   <td><input type="text" name="AddressNo1" maxlength="30" size="30" value="<?php echo $row["AddressNo1"]; ?>" required00/></td>
                   <th>&nbsp;</th>
                   <td>หมู่บ้าน/อาคาร : </td>
                   <td><input type="text" name="building1" maxlength="30"  size="30" value="<?php echo $row["building1"]; ?>"/></td>
              </tr>
              <tr>
              	   <td>หมู่ : </td>
                   <td><input type="text" name="Moo1" maxlength="50"  size="10"  value="<?php echo $row["Moo1"]; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>ตรอก/ซอย : </td>
                   <td><input type="text" name="Soi1" maxlength="50"  size="30"  value="<?php echo $row["Soi1"]; ?>"/></td>
              </tr>
			  <tr>
              		<td>ถนน : </td>
                   <td><input type="text" name="Road1" maxlength="50"  size="30"  value="<?php echo $row["Road1"]; ?>"/></td>
                   <th>&nbsp;</th>
              	   <td>แขวง/ตำบล : </td>
                   <td><input type="text" name="Sub_district1" maxlength="50"  size="30" value="<?php echo $row["Sub_district1"]; ?>" required00/></td>
              </tr>
              <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><input type="text" name="district1" maxlength="50"  size="30" value="<?php echo $row["district1"]; ?>" required00/></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
                   	<select name="province1" required00>
                        <option value="<?php echo $row["province1"]; ?>"><?php echo $row["province1"]; ?></option>
                        <?php
                        $strSQL = "SELECT * FROM t_province ORDER BY id ASC";
                        $objQuery = mysql_query($strSQL);
                        while($objResuut = mysql_fetch_array($objQuery))
                        {
                        ?>
                        <option value="<?php  echo $objResuut["province"];?>"><?php  echo $objResuut["province"];?></option>
                        <?php
                        }
                        ?>
                     </select>
                   </td>
              </tr>
               <tr>
              	   <td>รหัสไปรษณีย์ : </td>
                 <td><input type="text" name="zipcode1" maxlength="5" size="10" value="<?php echo $row["zipcode1"]; ?>" required00/></td>
                   <th>&nbsp;</th>
                   <td>โทรศัพท์บ้าน : </td>
                 <td><input type="text" name="telephone1" maxlength="25"  size="15" value="<?php echo $row["telephone1"]; ?>" /></td>
              </tr>
               <tr>
              	   <td>โทรศัพท์มือถือ : </td>
                  <td><input type="text" name="Mobile1" maxlength="25" size="15" value="<?php echo $row["Mobile1"]; ?>" required00/></td>
<!--				   <th>&nbsp;</th>
                   <td>อีเมล์ : </td>
                   <td><input type="text" name="EMAIL_ADDRESS" maxlength="50"  size="35"/></td>-->
              </tr>


                <tr><td colspan="2"><b>ที่อยู่จัดส่งกรมธรรม์</b></td><td>&nbsp;</td></tr>
                <tr><td></td><td colspan="3">
					<select name="add_bill" onchange="get_address()" required00>
		     				<option value="3">ที่อยู่อื่นๆ</option>
                		    <option value="1">ที่อยู่ที่ปัจจุบัน</option>
               		</select>
                </td></tr>
              <tr>
                   <td>เลขที่ : </td>
                   <td><input type="text" name="AddressNo3" maxlength="20"  value="<?php echo $row["AddressNo3"]; ?>" /></td>
                   <th>&nbsp;</th>
                   <td>หมู่บ้าน/อาคาร : </td>
                   <td><input type="text" name="building3" maxlength="50"  size="30" value="<?php echo $row["building3"]; ?>"/></td>
              </tr>
              <tr>
              	   <td>หมู่ : </td>
                   <td><input type="text" name="Moo3" maxlength="50"  size="10" value="<?php echo $row["Moo3"]; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>ตรอก/ซอย : </td>
                   <td><input type="text" name="Soi3" maxlength="50"  size="30" value="<?php echo $row["Soi3"]; ?>"/></td>
              </tr>
			  <tr>
              		<td>ถนน : </td>
                   <td><input type="text" name="Road3" maxlength="50"  size="30" value="<?php echo $row["Road3"]; ?>"/></td>
                   <th>&nbsp;</th>
              	   <td>แขวง/ตำบล : </td>
                   <td><input type="text" name="Sub_district3" maxlength="50"  size="30" value="<?php echo $row["Sub_district3"]; ?>"/></td>
              </tr>
              <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><input type="text" name="district3" maxlength="50"  size="30" value="<?php echo $row["district3"]; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
           		 	<select name="province3" required00>
                        <option value="<?php echo $row["province3"]; ?>"><?php echo $row["province3"]; ?></option>
                        <?php
                        $strSQL = "SELECT * FROM t_province ORDER BY id ASC";
                        $objQuery = mysql_query($strSQL);
                        while($objResuut = mysql_fetch_array($objQuery))
                        {
                        ?>
                        <option value="<?php echo $objResuut["province"];?>"><?php echo $objResuut["province"];?></option>
                        <?php
                        }
                        ?>
                     </select>
                   </td>
              </tr>
               <tr>
              	   <td>รหัสไปรษณีย์ : </td>
                 <td><input type="text" name="zipcode3" maxlength="5" size="10" value="<?php echo $row["zipcode3"]; ?>" /></td>
                 <th>&nbsp;</th>
                   <td>โทรศัพท์ : </td>
                 <td><input type="text" name="telephone3" maxlength="25"  size="15" value="<?php echo $row["telephone3"]; ?>" /></td>
                </tr>
             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>

            </table>
            </fieldset>
 		</div>
        <!--end  form 2-->

        <br />
  
        <div>
        <fieldset id="form-content">
        <legend>รายละเอียดการทำประกันภัย</legend>
        <?php 
			 $SQL_pk3= "select  * from t_motor_premium where id = '$insure_select' " ;
	 	     $result_pk3 = mysql_query($SQL_pk3,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	  		while($objResuut2 = mysql_fetch_array($result_pk3))
			 {
				
				// check การซ่อม
											$premium_type_1_DG = $objResuut2["premium_type_1_DG"];
											$premium_type_1_OG = $objResuut2["premium_type_1_OG"];
											$premium_type_2 = $objResuut2["premium_type_2"];
											$premium_type_2P = $objResuut2["premium_type_2P"];
											$premium_type_3 = $objResuut2["premium_type_3"];
											$premium_type_3P = $objResuut2["premium_type_3P"];
											
											if($premium_type_1_DG != ''){
												$insure_type = 'ชั้น 1';
												$clame_type = 'ห้าง';
												$premium = $premium_type_1_DG;
												
											}elseif($premium_type_1_OG != ''){
												$insure_type = 'ชั้น 1';
												$clame_type = 'อู่';
												$premium = $premium_type_1_OG;
												
											}elseif($premium_type_2 != ''){
												$insure_type = 'ชั้น 2';
												$clame_type = '';
												$premium = $premium_type_2;
												
											}elseif($premium_type_2P != ''){
												$insure_type = 'ชั้น 2 Plus';
												$clame_type = '';
												$premium = $premium_type_2P;
												
											}elseif($premium_type_3 != ''){
												$insure_type = 'ชั้น 3';
												$clame_type = '';
												$premium = $premium_type_3;
												
											}elseif($premium_type_3P != ''){
												$insure_type = 'ชั้น 3 Plus';
												$clame_type = '';
												$premium = $premium_type_3P;
											}
											
											$insurer_name =  $objResuut2["insurer"];
											
											$car_type = $objResuut2["car_type"] ;
											switch ($car_type) {
												case "110":
													$premium_prb = "645.21";
													break;
												case "320":
													$premium_prb = "967.28";
													break;
												case "210":
													$premium_prb = "967.28";
													break;
												case "220":
													$premium_prb = "1182.35";
													break;
												case "230":
													$premium_prb = "2493.28";
													break;
											}
			 }
			 

			 if( $row["insurer"]  <> '' ){
				 $insurer_name = $row["insurer"] ;
			 }
			 
			 if( $row["insure_type"]  <> '' ){
				 $insure_type = $row["insure_type"] ;
			 }
			 
			  if( $row["insure_cover_type"]  <> '' ){
				 $clame_type = $row["insure_cover_type"] ;
			 }
			 
			 if( $row["premium1"]  <> '' ){
				 $premium = $row["premium1"] ;
			 }
			 
			  if( $row["premium2"]  <> '' ){
				 $premium_prb = $row["premium2"] ;
			 }
		
		
		?>
        	<table id="table-form">
                <tr>
                  <td>บริษัทประกัน : </td>
                  <td><input type="text" id="insurer" name="insurer" maxlength="30" value="<?php echo $insurer_name ; ?>" required00/></td>
                  <th>&nbsp;</th>
                   <td>ประเภทความคุ้มครอง : </td>
                 <td><input type="text" name="insure_type" maxlength="25"  size="15" value="<?php echo $insure_type ; ?>" /></td>
               </tr>
               <tr>
                   <td>ซ่อม : </td>
                 <td><input type="text" name="insure_cover_type" maxlength="25"  size="15" value="<?php echo $clame_type ; ?>" /></td>
                 <th>&nbsp;</th>
                 <td>ทุนคุ้มครอง : </td>
                  <td><input type="text" name="car_cover2" maxlength="13"  size="20" value="<?php echo $row["car_cover"]; ?>" required00/></td>
               </tr>
               <tr>
                  <td>วันเริ่มคุ้มครอง : </td>
                  <td><input type="text" id="datepicker" name="effective_date" maxlength="25" value="<?php echo $row["effective_date"]; ?>" required00/></td>
                  <th>&nbsp;</th>
                   <td>วันสิ้นสุด : </td>
                 <td><input type="text" id="datepicker3" name="expire_date" maxlength="25"  size="15" value="<?php echo $row["expire_date"]; ?>" /></td>
               </tr>
                 <tr>
                   <td>เบี้ยประกันภัยรวม : </td>
                  <td><input type="text" name="premium1" maxlength="15" value="<?php echo $premium ; ?>" required00/> บาท</td>
                </tr>
                <tr>
                   <td>เบี้ย พรบ. : </td>
                  <td><input type="text" name="premium2" maxlength="15" value="<?php echo $premium_prb ; ?>" required00/> บาท</td>
                  <th>&nbsp;</th>
                  <?php
				   if($row["free_premium2"] == 'on'){
					   $free_premium2_check = 'checked' ;
				   }else{
					    $free_premium2_check = '' ;
				   }
				  ?>
                   <td>ฟรี พรบ. : </td>
                 <td><input type="checkbox" name="free_premium2" <?php echo $free_premium2_check; ?> /></td>
                </tr>
                <br/><br/>
                <tr><td>&nbsp;</td><td><input name="search" type="button"  onClick="JavaScript:fncSubmit('page3')" value=" พิมพ์ใบความคุ้มครอง " /></td></tr>
            </table><br />

            </fieldset>
  </div>
  <!--end  form 5-->
  <br />
          <!--start  form 5-->
        <div>
        <fieldset id="form-content">
        <legend>ข้อมูลการชำระเงิน</legend><br />
        	<table id="table-form">
							<tr>
							<td>ข้อมูลบัตรเครดิต</td>
                			 <td></td>
                              <td>&nbsp;</td>                                    
							</tr>
						 <tr>
							 <td>เลขที่บัตรเครดิต : </td>
							 <td><input id="AccountNo" type="text" name="AccountNo" maxlength="16"  size="30" value="<?php echo $row["AccountNo"]; ?>" required00/></td>
                             <td>&nbsp;</td>
                              <td>วันที่บัตรหมดอายุ : </td>
                             <td><input id="card_expire" type="text" name="ExpiryDate" maxlength="16"  size="10" value="<?php echo $row["ExpiryDate"]; ?>" required00/></td>
						</tr>
                <tr>
                	<td>ธนาคาร  : </td>
                 <td>
                 <select name="bank" required00>
									<option value="<?php echo $row["bank"]; ?>"><?php echo $row["bank"]; ?></option>
									<?php
                                    $strSQL = "SELECT * FROM t_bank_code ORDER BY name ASC";
                                    $objQuery = mysql_query($strSQL);
                                    while($objResuut = mysql_fetch_array($objQuery))
                                    {
                                    ?>
                                    <option value="<?php echo $objResuut["name"];?>"><?php echo $objResuut["name"];?></option>
                                    <?php
                                    }
                                    ?>
		  				</select>
                 </td>
                  <td>&nbsp;</td>
                <td>ลักษณะบัตร : </td>
                 <td><select name="AccountType" required00>
                     <option value="<?php echo $row["AccountType"]; ?>"><?php echo $row["AccountType"]; ?></option>
                     <option value="Visa">Visa</option>
                     <option value="Master">Master</option>
                   </select></td>
              </tr>
              <tr>
							<td>เงื่อนไขการชำระ</td>
                			 <td><select name="pay_by_installments">
                                 <option value="<?php echo $row["pay_by_installments"]; ?>"><?php echo $row["pay_by_installments"]; ?></option>
                    			 <option>ชำระเต็มจำนวน</option>
                    			 <option>แบ่งชำระ 2 งวด</option>
                    			 <option>แบ่งชำระ 3 งวด</option>
                                 <option>แบ่งชำระ 4 งวด</option>
                                 <option>แบ่งชำระ 5 งวด</option>
                                 <option>แบ่งชำระ 6 งวด</option>
                   					</select></td>
                                    
							</tr>
            </table>
            <br />
            <br/>
            <div id="result_Installmentsl"> 
  				ตารางชำระค่าเบี้ย
              <table id="table_premium">
                <thead>
                <tr>
                    <th>งวด</th>
                    <th>วันที่นัดชำระ</th>
                    <th>ยอดนัดชำระ</th>
                    <th>ยอดชำระ</th>
                    <th>วันที่ชำระ</th>
                    <th>เวลา</th>
                    <th>ช่องทางการชำระ</th>
                    <th>สถานะ</th>
                    <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					$count = 0;
                	$strSQL = "SELECT * FROM t_motor_installment where app_number = '$app_number' ";
                                    $objQuery = mysql_query($strSQL);
                                    while($objResuut = mysql_fetch_array($objQuery))
                                    {
										if($objResuut["installment"] == ''){
											$payment_status = 'ค้างชำระ' ;
										}else{
											$payment_status = 'ชำระแล้ว' ;
										}
										
										$trans_id = $objResuut["id"];
                ?>
                <tr>
                				 <td><?php echo $objResuut["payment_no"]; ?></td>
                				 <td><?php echo $objResuut["due_date"]; ?></td>
                                  <td><?php echo $objResuut["payment_due"]; ?></td>
                                  <td><?php echo $objResuut["installment"]; ?></td>
                                  <td><?php echo $objResuut["payment_date"]; ?></td>
                                  <td><?php echo $objResuut["payment_time"]; ?></td>
                                  <td><?php echo $objResuut["payment_by"]; ?></td>
                                  <td><?php echo $payment_status; ?></td>
   
                                 

                                 <td> 
                                 <?php if( $payment_status == 'ค้างชำระ'){
									 ?>
                                 <input name="Add" type="button" id="Add" value="รับชำระ" onclick="JavaScript:fncShow('box_addnew_payment');JavaScript:get_payment('<?php echo $trans_id ;?>');" />
                                 <input name="Edit" type="button" id="Edit" value="แก้ไข" onclick="JavaScript:fncShow('box_edit');JavaScript:get_payment('<?php echo $trans_id ;?>');" />
                                 <?php }?>
                                 </td>
                </tr>
                	
                <?php 
				$count = $count + 1 ;
				}
				?>
                <tbody>
            	</table>
            </div>
            
            </br></br>
            
            <input type="button" name="save" value="+ เพิ่มรายการนัดชำระ" onClick="JavaScript:fncShow('box_addnew');">
            </br></br>
            
            <!--  start  box_addnew-->
            <div id="box_addnew" style="display:none; border: 1px solid #ccc; padding: 10px 0 0 10px; margin: 0px 0 20px 0; background-color:#fff;">
             <table id="table-form">
            	<tr>
                <?php $payment_no = $count+1 ;?>
				  <td>งวดที่  : </td>
                   <td><select name="payment_no">
						<?php for ($x = $payment_no; $x <= 10; $x++){?>
						
						<option><?php echo $x;  ?></option>
						
						 <?php }?>

		  				</select>
                   </td>
                </tr>
                <tr>
				  <td>จำนวนเงิน : </td>
                  <td><input type="text" name="payment_due" size="10" /> บาท</td>
                  <th>&nbsp;</th>
                  <td>วันที่นัดชำระ  : </td>
                  <td><input type="text" id="datepicker4" name="due_date" maxlength="60" size="10" /></td>
                </tr>
            </table>

            <p style="margin: 10px 0 10px 0;"><input name="Add" type="button" id="Add" value="SAVE" onclick="javascript:window.document.App.action='AddNew_duepayment.php';document.App.submit();">&nbsp;&nbsp;&nbsp;<input type="button" name="Cancel" value="Cancel" onclick="JavaScript:fncHide('box_addnew');"></p>
            </div>
            <!--  End  box_addnew-->
            
            
            
            <!--  start  box_addnew_payment-->
            <div id="box_addnew_payment" style="display:none; border: 1px solid #ccc; padding: 10px 0 0 10px; margin: 0px 0 20px 0; background-color:#fff;">
            	<b>รับชำระค่าเบี้ยประกัน</b><br /><br />
             <table id="table-form">
            	<tr>
				  <td>วิธีการชำระ : </td>
                   <td><select name="payment_by" >
							<option>เงินสด</option>
                            <option>โอนเงิน</option>
                            <option>บัตรเครดิต</option>
		  				</select> </td>
                   <td>&nbsp;</td>
                  <td>ช่องทางการชำระ  : </td>
                  <td><select id="payment_company" name="payment_company" onchange="showBank(this.value)">
                  			<option>ระบุ</option>
							<option>ARK INSURE</option>
                            <option>บริษัทประกัน</option>
		  				</select> </td>
                </tr>
                <tr>
                  <td>บัญชีธนาคาร  : </td>
                  <td colspan="3"><select name="payment_account" id="payment_account">
							<option></option>
		  				</select> </td>
                </tr>
                <tr>
				  <td>จำนวนเงิน : </td>
                  <td><input type="text" name="installment" size="10" /> บาท</td>
                  <th>&nbsp;</th>
                  <td>วันที่ชำระ  : </td>
                  <td><input type="text" id="datepicker5" name="payment_date" maxlength="60" size="10" /></td>
                  <th>&nbsp;</th>
                  <td>เวลาชำระ  : </td>
                  <td><input type="text" id="" name="payment_time" maxlength="10" size="10" /></td>
                </tr>
            </table>
			<input type="hidden" id="payment_id" name="payment_id"/>
            <p style="margin: 10px 0 10px 0;"><input name="Add" type="button" id="Add" value="SAVE" onclick="javascript:window.document.App.action='AddNew_payment.php?xx=111';document.App.submit();">&nbsp;&nbsp;&nbsp;<input type="button" name="Cancel" value="Cancel" onclick="JavaScript:fncHide('box_addnew_payment');"></p>
            </div>
            <!--  End   box_addnew_payment-->
            
 
            <br />
            </fieldset>
  </div>
  <!--end  form 5-->

        <br />
        <!--start  form 7-->
        
        
        

		<div>
				<fieldset id="form-content">
					Remark :
					<textarea rows="5" name="remark" cols="100"><?php echo $row["remark"]; ?></textarea>
				</fieldset>
		</div>

        <!--start  form 7-->
        <div>
        <fieldset id="form-content">
        	<table id="table-form">
               <tr>
				  <td>Application Status &nbsp;</td>
                  <td><select name="AppStatus" >
                  <option value="<?php echo $row["AppStatus"]; ?>"><?php echo $row["AppStatus"]; ?></option>
                    <option>เสนอราคา</option>
					<option>ติดตามครั้งที่ 1</option>
                    <option>ติดตามครั้งที่ 2</option>
                    <option>ติดตามครั้งที่ 3</option>
                    <option>ขายไม่ได้</option>
                    <option>ขายได้</option>
<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	if($lv > 1){
?>

	 <option>เก็บค่าเบี้ย</option>
     <option>เก็บค่าเบี้ยงวด 2</option>
     <option>เก็บค่าเบี้ยงวด 3</option>
     <option>เก็บค่าเบี้ยงวด 4</option>
     <option>เก็บค่าเบี้ยงวด 5</option>
     <option>เก็บค่าเบี้ยงวด 6</option>
	 <option>ชำระครบ</option>
	 <option>ยกเลิกคืนเงินเต็มจำนวน</option>
     <option>ยกเลิกคืนเงินบางส่วน</option>
     <option>ยกเลิกไม่คืนเงิน</option>
 <?php } ?>
                  </select></td>
                  <th>&nbsp;</th>

                 					 <input type="hidden" name="create_date" value="<?php echo "$currentdate_app" ?>" />
				  					 <input type="hidden" name="create_time" value="<?php echo "$currenttime" ?>" />

									<input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>" />
									<input type="hidden" name="calllist_id" value="<?php echo $row["calllist_id"]; ?>" />
									<input type="hidden" name="agent_id" value="<?php echo  $Owner ; ?>" />
									<input type="hidden" name="import_id" value="<?php echo $import_id; ?>" />
									<input type="hidden" name="team_id" value="<?php echo $team_id; ?>" />


                  <th>&nbsp;</th>
                  <td><input name="Submit" type="button" value=" Save " onClick="JavaScript:fncSubmit('page1')" /></td>
               </tr>
            </table>
          </fieldset>
  </div>
  </form>
  </form>
        <!--end  form 7-->
 <?php }?>       
<br />
</div>
</body>
</html>
