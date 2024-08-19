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
		   

function fncSubmit(strPage)
{
	if(strPage == "page1")
	{
		document.App.action="newApp_save.php";
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



function premium1disc(val)
{
	//alert("Call Function Is Work!!" + val );
	
	var premium1 = document.getElementById("premium1").value;
	
	var  total_premium1 = premium1 - val ;
	
	//alert("Call Function Is Work!!" + premium1 );
	
	document.getElementById("total_premium1").value = total_premium1 ;
	
}

function premium2disc(val)
{
	//alert("Call Function Is Work!!" + val );
	
	var premium2 = document.getElementById("premium2").value;
	
	var  total_premium2 = premium2 - val ;
	
	//alert("Call Function Is Work!!" + premium1 );
	
	document.getElementById("total_premium2").value = total_premium2 ;
	
}

</script>

</head>

<body>

	<?php

	$campaign_id = $_GET["campaign_id"];
	$calllist_id = $_GET["calllist_id"];
	$agent_id = $_GET["agent_id"];
	$import_id = $_GET["import_id"];

	$Owner = $objResult["agent_id"];
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
		
		$strSQL2 = "SELECT * FROM t_calllist WHERE calllist_id = '$calllist_id' ";
		$result2= mysql_query($strSQL2);
		while($objResult2 = mysql_fetch_array($result2))
		{
			$cust_first_name = $objResult2["first_name"] ;
			$cust_last_name = $objResult2["last_name"] ;
			$tel1 = $objResult2["tel1"] ;
			$tel2 = $objResult2["tel2"] ;
			$tel3 = $objResult2["tel3"] ;
			$tel4 = $objResult2["tel4"] ;
			
			$car_detail = $objResult2["car_detail"] ;
			$plate = $objResult2["plate"] ;
			$chassee = $objResult2["chassee"] ;
			$engine_no = $objResult2["engine_no"] ;
			$car_year = $objResult2["car_year"] ;
		}
		
		//$car_detail = $tel3.' '.$tel4 ;
		
		

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
                	<td><h1>License : </h1></td>
                    <td><?php print $license_code ;?></td>
                    <td>&nbsp;</td>
                    <td><h1>TSR : </h1></td>
                    <td><?php echo $first_name ;?>&nbsp;<?php echo $last_name ;?></td>
                </tr>
            </table>
            </div>
        </div>
<form id="App" name="App" method="post" action="xxxxx.php">

		<input type="hidden" name="calllist_id" value="<?php echo "$calllist_id" ?>" />
        
        
        

        <!--start  form 1 -->
        <div>
        <fieldset id="form-content" >
        	<table id="table-form">
                <tr>
				  <td>เลขที่รับแจ้ง : </td>
                   <td><input type="text" name="issue_no" maxlength="15" value="<?php echo "$confirm_no" ?>" /></td>
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
										 	<option value=""><-- โปรดระบุ --></option>
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
                   <td><input type="text" name="Firstname" maxlength="60" required00 value="<?php echo $cust_first_name; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>นามสกุล : </td>
                   <td><input type="text" name="Lastname" maxlength="60" required00/ value="<?php echo $cust_last_name; ?>"></td>
                </tr>
                
                <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>ข้อมูลรถยนต์</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>รายละเอียดรถ : </td>
                   <td colspan="3"><input type="text" name="car_detail"  size="50" value="<?php echo $car_detail; ?>" /></td>
              </tr>
              <tr>
                   <td>ทะเบียนรถ : </td>
                   <td><input type="text" name="car_license" maxlength="20" size="15" value="<?php echo $plate; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>เลขตัวถัง : </td>
                   <td><input type="text" name="body_no" maxlength="20" size="30" value="<?php echo $chassee; ?>"/></td>
              </tr>
              <tr>
              	   <td>เลขเครื่องยนต์ : </td>
                   <td><input type="text" name="engine_no" maxlength="50"  size="30" value="<?php echo $engine_no; ?>" /></td>
                   <th>&nbsp;</th>
                   <td>ปีที่จดทะเบียน : </td>
                   <td><input type="text" name="car_regit_year" maxlength="50"  size="10" value="<?php echo $car_year; ?>" /></td>
              </tr>
              
              <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>ค้นหาประกันภัย</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>ยี่ห้อรถ : </td>
                   <td>
                   	<select name="car_brand" id="car_brand" required00 onchange="showModel(this.value)">
                        <option value=""><-- โปรดระบุ --></option>
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
                        <option value=""><-- โปรดระบุ --></option>
                     </select>
                   </div>
                   </td>
              </tr>
              <tr>
                   <td>อายุรถ : </td>
                   <td><select name="car_year" id="car_year" required00>
                        <option value=""><-- โปรดระบุ --></option>
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
                        <option value=""><-- โปรดระบุ --></option>
                     </select>
                   </div></td>
              </tr>
	          <tr>  
				  <td>ทุนคุ้มครอง : </td>
                  <td><input type="text" name="car_cover" maxlength="13"  size="20" required00/></td>
                  <td>&nbsp;</td>
              </tr>
              <tr>  
				  <td>ประเภทความคุ้มครอง : </td>
                  <td><input type="text" name="insure_type_s" id="insure_type_s" maxlength="13"  size="10" required00/></td>
                  <th>&nbsp;</th>
                  <td>รหัสรถ : </td>
                  <td><input type="text" name="car_type_s" id="car_type_s" maxlength="13"  size="10" required00/></td>
              </tr>		
              <tr><td><input name="search" type="button" onclick="AjaxSearch()" value=" ค้นหาประกัน " /></td></tr>
              </table>

              <div id="data_result" style="margin-top:20px;"></div>
              
              
              <table id="table-form">
              <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>ที่อยู่ปัจจุบัน</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>เลขที่ : </td>
                   <td><input type="text" name="AddressNo1" maxlength="30" size="30" required00/></td>
                   <th>&nbsp;</th>
                   <td>หมู่บ้าน/อาคาร : </td>
                   <td><input type="text" name="building1" maxlength="30"  size="30"/></td>
              </tr>
              <tr>
              	   <td>หมู่ : </td>
                   <td><input type="text" name="Moo1" maxlength="50"  size="10" /></td>
                   <th>&nbsp;</th>
                   <td>ตรอก/ซอย : </td>
                   <td><input type="text" name="Soi1" maxlength="50"  size="30" /></td>
              </tr>
			  <tr>
              		<td>ถนน : </td>
                   <td><input type="text" name="Road1" maxlength="50"  size="30" /></td>
                   <th>&nbsp;</th>
              	   <td>แขวง/ตำบล : </td>
                   <td><input type="text" name="Sub_district1" maxlength="50"  size="30" required00/></td>
              </tr>
              <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><input type="text" name="district1" maxlength="50"  size="30" required00/></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
                   	<select name="province1" required00>
                        <option value=""><-- โปรดระบุ --></option>
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
                 <td><input type="text" name="zipcode1" maxlength="5" size="10" required00/></td>
                   <th>&nbsp;</th>
                   <td>โทรศัพท์บ้าน : </td>
                 <td><input type="text" name="telephone1" maxlength="25"  size="15" /></td>
              </tr>
               <tr>
              	   <td>โทรศัพท์มือถือ : </td>
                  <td><input type="text" name="Mobile1" maxlength="25" size="15" required00/></td>
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
                   <td><input type="text" name="AddressNo3" maxlength="20" /></td>
                   <th>&nbsp;</th>
                   <td>หมู่บ้าน/อาคาร : </td>
                   <td><input type="text" name="building3" maxlength="50"  size="30"/></td>
              </tr>
              <tr>
              	   <td>หมู่ : </td>
                   <td><input type="text" name="Moo3" maxlength="50"  size="10"/></td>
                   <th>&nbsp;</th>
                   <td>ตรอก/ซอย : </td>
                   <td><input type="text" name="Soi3" maxlength="50"  size="30"/></td>
              </tr>
			  <tr>
              		<td>ถนน : </td>
                   <td><input type="text" name="Road3" maxlength="50"  size="30"/></td>
                   <th>&nbsp;</th>
              	   <td>แขวง/ตำบล : </td>
                   <td><input type="text" name="Sub_district3" maxlength="50"  size="30"/></td>
              </tr>
              <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><input type="text" name="district3" maxlength="50"  size="30"/></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
           		 	<select name="province3" required00>
                        <option value=""><-- โปรดระบุ --></option>
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
                 <td><input type="text" name="zipcode3" maxlength="5" size="10" /></td>
                 <th>&nbsp;</th>
                   <td>โทรศัพท์ : </td>
                 <td><input type="text" name="telephone3" maxlength="25"  size="15" /></td>
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
        	<table id="table-form">
            	<tr>
                  <td>ประเภทการทำประกัน : </td>
                  <td><select id="policy_type" name="policy_type" required>
									<option value="New">New</option>
                                    <option value="Renew">Renew</option>
		  				</select></td>
               </tr>
                <tr>
                  <td>บริษัทประกัน : </td>
                  <td><select id="insurer" name="insurer" required00>
									<option value="<?php echo $insurer_name ; ?>"><?php echo $insurer_name ; ?></option>
									<?php
                                    $strSQL = "SELECT * FROM t_motor_company ORDER BY name ASC";
                                    $objQuery = mysql_query($strSQL);
                                    while($objResuut = mysql_fetch_array($objQuery))
                                    {
                                    ?>
                                    <option value="<?php echo $objResuut["name"];?>"><?php echo $objResuut["name"];?></option>
                                    <?php
                                    }
                                    ?>
		  				</select></td>
                  <th>&nbsp;</th>
                   <td>ประเภทความคุ้มครอง : </td>
                 <td><input type="text" name="insure_type" maxlength="25"  size="15" /></td>
               </tr>
               <tr>
                   <td>ซ่อม : </td>
                 <td><select name="insure_cover_type" required00>
										 	<option value=""><-- โปรดระบุ --></option>
                                            <option value="1">ห้าง</option>
                                            <option value="2">อู่</option>
		  					 		</select></td>
                 <th>&nbsp;</th>
                 <td>ทุนคุ้มครอง : </td>
                  <td><input type="text" name="car_cover2" maxlength="13"  size="20" value="<?php echo $row["car_cover"]; ?>" required00/></td>
               </tr>
               <tr>
                  <td>วันเริ่มคุ้มครอง : </td>
                  <td><input type="text" id="datepicker" name="effective_date" maxlength="25" value="" required00/></td>
                  <th>&nbsp;</th>
                   <td>วันสิ้นสุด : </td>
                 <td><input type="text" id="datepicker3" name="expire_date" maxlength="25"  size="15" /></td>
               </tr>
                 <tr>
                   <td>เบี้ยประกันภัย : </td>
                  <td><input type="text" name="premium1" id="premium1" maxlength="15" value="" required00/> บาท</td>
                  <th>&nbsp;</th>
                  <td>ส่วนลดค่าเบี้ย : </td>
                  <td><input type="text" name="disc_premium1" maxlength="10" value="" onchange="premium1disc(this.value)"  size="10" /> บาท</td>
                </tr>
                <tr>
                   <td>เบี้ยประกันภัยเรียกเก็บ : </td>
                  <td><input type="text" name="total_premium1" id="total_premium1" maxlength="15" value="" readonly="readonly" required00/> บาท</td>
                </tr>
                <tr>
                   <td>เบี้ย พรบ. : </td>
                  <td><input type="text" name="premium2" id="premium2" maxlength="15" value="" required00/> บาท</td>
                </tr>
                <tr>
                   <td>ส่วนลด พรบ. : </td>
                  <td><input type="text" name="disc_premium2" id="disc_premium2" maxlength="10" value="" onchange="premium2disc(this.value)" size="10"/> บาท</td>
                  <th>&nbsp;</th>
                  <td>เบี้ย พรบ. เรียกเก็บ  : </td>
                  <td><input type="text" name="total_premium2" id="total_premium2" maxlength="15" value=""  size="10" /> บาท</td>
                </tr>
                <tr>
                   <td>เลขที่ พรบ. : </td>
                  <td><input type="text" name="policy_no2" id="policy_no2" maxlength="25" value=""/> </td>
                  <th>&nbsp;</th>
                  <td>พรบ. เริ่มคุ้มครอง  : </td>
                  <td><input type="text" id="datepicker4" name="policy_effective2" maxlength="15" value=""  size="15" /> </td>
                </tr>
                <tr>
                   <td>พรบ. ออกให้โดย : </td>
                   <td><select name="insurer_premium2" required00>
                        <option value=""><-- โปรดระบุ --></option>
                        <?php
                        $strSQL = "select `name` from t_motor_company  ORDER BY id ASC";
                        $objQuery = mysql_query($strSQL);
                        while($objResuut = mysql_fetch_array($objQuery))
                        {
                        ?>
                        <option value="<?php echo $objResuut["name"];?>"><?php echo $objResuut["name"];?></option>
                        <?php
                        }
                        ?>
                     </select> </td>
               </tr>
               
                <br/><br/>
                <tr><td>&nbsp;</td><td><input name="search" type="button"  onClick="JavaScript:fncSubmit('page3')" value=" พิมพ์ใบความคุ้มครอง " /></td></tr>
            </table><br />

            </fieldset>
  </div>
  <!--end  form 5-->
  <br />
          

        <br />


		<div>
				<fieldset id="form-content">
					Remark :
					<textarea rows="5" name="remark" cols="100"></textarea>
				</fieldset>
		</div>

        <!--start  form 7-->
        <div>
        <fieldset id="form-content">
        	<table id="table-form">
               <tr>
				  <td>Application Status &nbsp;</td>
                  <td><select name="AppStatus" >
                    <option>เสนอราคา</option>
					<option>ติดตามครั้งที่ 1</option>
                    <option>ติดตามครั้งที่ 2</option>
                    <option>ติดตามครั้งที่ 3</option>
                    <option>ขายไม่ได้</option>
                    <option>ขายได้</option>
<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	if($lv > 0){
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
									<input type="hidden" name="calllist_id" value="<?php echo $calllist_id; ?>" />
									<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
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
<br />
</div>
</body>
</html>
