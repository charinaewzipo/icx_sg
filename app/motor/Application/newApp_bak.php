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
			dateFormat: 'yymmdd'
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
<form name="App" method="post" action="newApp_save.php">
        <!--start  form 1 -->
        <div>
        <fieldset id="form-content" >
        	<table id="table-form">
                <tr>
				  <td>เลขที่รับแจ้ง : </td>
                   <td><input type="text" name="App_ID" maxlength="15" value="<?php echo "$Run_no" ?>" /></td>
                   <td colspan="30">&nbsp;</td>
                   <td>วันที่บันทึก : </td>
                   <td><input type="text" name="Submit_Date" maxlength="10" value="<?php echo "$currentdate_app" ?>" /></td>
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
										 <select name="Title" required>
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
                   <td><input type="text" name="Firstname" maxlength="60" required value="<?php echo $cust_first_name; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>นามสกุล : </td>
                   <td><input type="text" name="Lastname" maxlength="60" required/ value="<?php echo $cust_last_name; ?>"></td>
                </tr>

                <tr>  
				  <td>เลขที่บัตรประชาชน : </td>
                  <td><input type="text" name="IdCard" maxlength="13"  size="20" required/></td>
                  <td>&nbsp;</td>
                  <td>วันที่บัตรหมดอายุ : </td>
                  <td><input id="datepicker2" type="text" name="IdCardExpire" maxlength="13"   required /></td>
              </tr>
              
              <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>รายละเอียดรถยนต์</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>ยี่ห้อรถ : </td>
                   <td>
                   	<select name="car_brand" id="car_brand" required onchange="showModel(this.value)">
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
                   	<select name="car_model" id="car_model" required onchange="showCC(this.value)">
                        <option value=""><-- โปรดระบุ --></option>
                     </select>
                   </div>
                   </td>
              </tr>
              <tr>
                   <td>อายุรถ : </td>
                   <td><select name="car_year" id="car_year" required>
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
                   	<select name="car_engine" id="car_engine" required onchange="">
                        <option value=""><-- โปรดระบุ --></option>
                     </select>
                   </div></td>
              </tr>
              <tr><td><input name="search" type="button" onclick="AjaxSearch()" value=" ค้นหาประกัน " /></td></tr>
              </table>

              <div id="data_result" style="margin-top:20px;"></div>
              
               <table id="table-form">
              <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>ข้อมูลรถยนต์</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>ทะเบียนรถ : </td>
                   <td><input type="text" name="car_license" maxlength="20" size="15" required/></td>
                   <th>&nbsp;</th>
                   <td>เลขตัวถัง : </td>
                   <td><input type="text" name="body_no" maxlength="20" size="30" required/></td>
              </tr>
              <tr>
              	   <td>เลขเครื่องยนต์ : </td>
                   <td><input type="text" name="engine_no" maxlength="50"  size="30" /></td>
                   <th>&nbsp;</th>
                   <td>ปีที่จดทะเบียน : </td>
                   <td><input type="text" name="Soi1" maxlength="50"  size="10" /></td>
              </tr>
              </table>
              
              <table id="table-form">
              <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			  <tr><td><b>ที่อยู่ปัจจุบัน</b></td><td>&nbsp;</td></tr>
              <tr>
                   <td>เลขที่ : </td>
                   <td><input type="text" name="AddressNo1" maxlength="30" size="30" required/></td>
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
                   <td><input type="text" name="Sub_district1" maxlength="50"  size="30" required/></td>
              </tr>
              <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><input type="text" name="district1" maxlength="50"  size="30" required/></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
                   	<select name="province1" required>
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
                 <td><input type="text" name="zipcode1" maxlength="5" size="10" required/></td>
                   <th>&nbsp;</th>
                   <td>โทรศัพท์บ้าน : </td>
                 <td><input type="text" name="telephone1" maxlength="25"  size="15" /></td>
              </tr>
               <tr>
              	   <td>โทรศัพท์มือถือ : </td>
                  <td><input type="text" name="Mobile1" maxlength="25" size="15" required/></td>
<!--				   <th>&nbsp;</th>
                   <td>อีเมล์ : </td>
                   <td><input type="text" name="EMAIL_ADDRESS" maxlength="50"  size="35"/></td>-->
              </tr>


                <tr><td colspan="2"><b>ที่อยู่จัดส่งกรมธรรม์</b></td><td>&nbsp;</td></tr>
                <tr><td></td><td colspan="3">
					<select name="add_bill" onchange="get_address()" required>
		     				<option value="3"></option>
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
           		 	<select name="province3" required>
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
                  <td>บริษัทประกัน : </td>
                  <td><input type="text" name="" maxlength="30" value="" required/></td>
                  <th>&nbsp;</th>
                   <td>ประเภทความคุ้มครอง : </td>
                 <td><input type="text" name="" maxlength="25"  size="15" /></td>
               </tr>
               <tr>
                  <td>ทุนคุ้มครอง : </td>
                  <td><input type="text" name="" maxlength="25" value="" required/></td>
                  <th>&nbsp;</th>
                   <td>ซ่อม : </td>
                 <td><input type="text" name="" maxlength="25"  size="15" /></td>
               </tr>
               <tr>
                  <td>วันเริ่มคุ้มครอง : </td>
                  <td><input type="text" id="datepicker" name="" maxlength="25" value="" required/></td>
                  <th>&nbsp;</th>
                   <td>วันสิ้นสุด : </td>
                 <td><input type="text" id="datepicker3" name="" maxlength="25"  size="15" /></td>
               </tr>
                 <tr>
                   <td>เบี้ยประกันภัยรวม : </td>
                  <td><input type="text" name="INSTALMENT_PREMIUM" maxlength="15" value="" required/> บาท</td>
                </tr>
                <tr>
                   <td>เบี้ย พรบ. : </td>
                  <td><input type="text" name="INSTALMENT_PREMIUM" maxlength="15" value="" required/> บาท</td>
                </tr>
                <br/><br/>
                <tr><td>&nbsp;</td><td><input name="search" type="button" onclick="" value=" พิมพ์ใบความคุ้มครอง " /></td></tr>
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
							<td>ช่องทางการชำระเงิน : </td>
                			 <td><select name="payment_type" required onChange="">
                    			 <option value=""><-- โปรดระบุ --></option>
                    			 <option value="เครดิต">เครดิต</option>
                    			 <option value="เงินสด">เงินสด</option>
                   					</select></td>
                              <td>&nbsp;</td>
                             <td>แบ่งชำระ : </td>
                			 <td><select name="pay_by_installments" required onchange="showInstallments(this.value)">
                    			 <option value="">ชำระเต็มจำนวน</option>
                    			 <option value="2">แบ่งชำระ 2</option>
                    			 <option value="3">แบ่งชำระ 3</option>
                                 <option value="4">แบ่งชำระ 4</option>
                                 <option value="5">แบ่งชำระ 5</option>
                                 <option value="6">แบ่งชำระ 6</option>
                   					</select></td>
                                    
							</tr>
						 <tr>
							 <td>เลขที่บัตรเครดิต : </td>
							 <td><input id="AccountNo" type="text" name="AccountNo" maxlength="16"  size="30" required/></td>
                             <td>&nbsp;</td>
                              <td>วันที่บัตรหมดอายุ : </td>
                             <td id="card_expire"><select id="CREDIT_CARD_EXPIRY_DATE" name="CREDIT_CARD_EXPIRY_DATE" required>
                                 <option value=""></option>
                                 <option value="01">01</option>
                                 <option value="02">02</option>
                                 <option value="03">03</option>
                                 <option value="04">04</option>
                                 <option value="05">05</option>
                                 <option value="06">06</option>
                                 <option value="07">07</option>
                                 <option value="08">08</option>
                                 <option value="09">09</option>
                                 <option value="10">10</option>
                                 <option value="11">11</option>
                                 <option value="12">12</option>
                               </select>
                               
                               <select id="CREDIT_CARD_EXPIRY_YEAR" name="CREDIT_CARD_EXPIRY_YEAR" required>
                                 <option value=""></option>
                                 <option value="14">14</option>
                                 <option value="15">15</option>
                                 <option value="16">16</option>
                                 <option value="17">17</option>
                                 <option value="18">18</option>
                                 <option value="19">19</option>
                                 <option value="20">20</option>
                                 <option value="21">21</option>
                                 <option value="22">22</option>
                                 <option value="23">23</option>
                                 <option value="24">24</option>
                                 <option value="25">25</option>
                                 <option value="26">26</option>
                                 <option value="27">27</option>
                                 <option value="28">28</option>
                                 <option value="29">29</option>
                                 <option value="30">30</option>
                                 <option value="31">31</option>
                                 <option value="32">32</option>
                                 <option value="33">33</option>
                               </select> MM / YY</td>
						</tr>
                <tr>
                	<td>ธนาคาร  : </td>
                 <td>
                 <select name="bank" required>
									<option value=""><-- โปรดระบุ --></option>
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
                 <td><select name="AccountType" required>
                     <option value=""><-- โปรดระบุ --></option>
                     <option value="CC01">Visa</option>
                     <option value="MC01">Master</option>
                   </select></td>
              </tr>
            </table>
            <div id="result_Installmentsl"> </div>
            <br />
            </fieldset>
  </div>
  <!--end  form 5-->

        <br />
        <!--start  form 7-->
        
        
        

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
                    <option value="Follow Doc">Follow Doc</option>
	<option value="Submit">Submit</option>
<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	if($lv > 1){
?>

                    <option value="QC_Approved">QC_Approved</option>
	<option value="Success">Success</option>
	<option value="QC_Reject">QC_Reject</option>
                     <option value="Approved">Approved</option>
	<option value="Credit Reject">Credit Reject</option>
	<option value="Partner Reject">Partner Reject</option>
 <?php } ?>
                  </select></td>
                  <th>&nbsp;</th>
                  <input type="hidden" name="TSR_Name" value="<?php print $first_name ;?>" />
                  <input type="hidden" name="TSR_Lastname" value="<?php print $last_name ;?>" />
		          <input type="hidden" name="tsr_id" value="<?php print $agent_id ;?>" />
                  <input type="hidden" name="License_No" value="<?php print $license_code ;?>" />
                  <input type="hidden" name="SupID" value="<?php print $sup_id ;?>" />
                  <input type="hidden" name="TSR_CODE" value="<?php print $tsr_code ;?>" />

                  <input type="hidden" name="list_dtl_id" value="<?php print $list_dtl_id ;?>" />

                  <input type="hidden" name="CREATED_BY" value="<?php print $first_name;?> <?php print $last_name;?>" />
                  <input type="hidden" name="CREATED_DATE" value="<?php echo "$currentdate_app" ?>" />
				  <input type="hidden" name="CREATED_TIME" value="<?php echo "$currenttime" ?>" />
                  <input type="hidden" name="DateNow" value="<?php echo "$currentdate_app" ?>" />

									<input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>" />
									<input type="hidden" name="calllist_id" value="<?php echo $calllist_id; ?>" />
									<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
									<input type="hidden" name="import_id" value="<?php echo $import_id; ?>" />
									<input type="hidden" name="team_id" value="<?php echo $team_id; ?>" />
                                    <input type="hidden" name="camp" value="GenExclusive" />
<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	if($lv > 1){
?>
                  <td>วันที่คุ้มครอง</td>
                  <td><input id="datepicker3" type="text" name="completed_date" /></td>
 <?php } ?>
                  <th>&nbsp;</th>
                  <td><input name="Submit" type="submit" value=" Submit " /></td>
               </tr>
            </table>
          </fieldset>
  </div>
  </form>
        <!--end  form 7-->
<br />
</div>
</body>
</html>
