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
</SCRIPT>

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
		<!--<div id="logo"></div>-->
  </div>
        <div id="top-detail">
       	  <div id="app-detail">
<table>
                	<tr>
                    	<td><h1>Product Name : </h1></td>
                        <td>Gen Exclusive Plus</td>
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
				  <td>เลขที่ใบสมัคร : </td>
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
        <br /><h1>คำถามเกี่ยวกับข้อมูลส่วนบุคคลของผู้ขอเอาประกันภัย และรายละเอียดการขอเอาประกันภัย</h1><br />
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
				  				 <td>ชื่อผู้เอาประกัน (ไทย) : </td>
                   <td><input type="text" name="Firstname" maxlength="60" required value="<?php echo $cust_first_name; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>นามสกุล (ไทย) : </td>
                   <td><input type="text" name="Lastname" maxlength="60" required/ value="<?php echo $cust_last_name; ?>"></td>
                </tr>
                <tr>
				  <td>เพศ : </td>
                   <td><select name="Sex" required>
                     <option value=""><-- โปรดระบุ --></option>
                     <option value="ชาย">ชาย</option>
                     <option value="หญิง">หญิง</option>
                   </select></td>
                   <th>&nbsp;</th>
                   <td>สถานะภาพ : </td>
                   <td><select name="MaritalStatus" required>
                     			<option value=""><-- โปรดระบุ --></option>
											<?php
                                            $strSQL = "SELECT * FROM t_client_status ORDER BY code ASC";
                                            $objQuery = mysql_query($strSQL);
                                            while($objResuut = mysql_fetch_array($objQuery))
                                            {
                                            ?>
                                            <option value="<?php echo $objResuut["desc"];?>"><?php  echo $objResuut["desc"];?></option>
                                            <?php
                                            }
                                            ?>
                   				</select>
                   </td>
                </tr>
               <tr>
<!--				  <td> เชื้อชาติ: </td>
                  <td><input type="text" name="Race" maxlength="30" /></td>
                  <th>&nbsp;</th>-->
                   <td>สัญชาติ : </td>
                   <td>
										 <select name="Nationality" required>
										 <option value=""><-- โปรดระบุ --></option>
										 <option value="ไทย">ไทย</option>
										 <option value="จีน">จีน</option>
										 <option value="อินเดีย">อินเดีย</option>
										 <option value="อเมริกัน">อเมริกัน</option>
										 <option value="อังกฤษ">อังกฤษ</option>
										 </select>
									 </td>
                   <td>&nbsp;</td>
              </tr>
                <tr>
				  <td>อายุ : </td>
                  <td><input id="age" type="text" name="ADE_AT_RCD" maxlength="2"  size="8" required readonly /> &nbsp;ปี</td>
                  <th>&nbsp;</th>
                   <td>เกิดวันที่ : </td>
                  <td><input id="datepicker" type="text" name="DOB" maxlength="10" onchange="getAge(this)"  required /></td>
                </tr>
                <tr>  
				  <td>เลขที่บัตรประชาชน : </td>
                  <td><input type="text" name="IdCard" maxlength="13"  size="20" required/></td>
                  <td>&nbsp;</td>
                  <td>วันที่บัตรหมดอายุ : </td>
                  <td><input id="datepicker2" type="text" name="IdCardExpire" maxlength="13"   required /></td>
              </tr>
              <tr>  
				  <td>ออกโดย เขต/อำเภอ : </td>
                  <td><input type="text" name="IdCard_from_distric" maxlength="13"  size="20" required/></td>
                  <td>&nbsp;</td>
                  <td>จังหวัด : </td>
                  <td>
                   	<select name="IdCard_from_province" required>
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


                <tr><td colspan="2"><b>ที่อยู่ที่ทำงาน</b></td><td>&nbsp;</td></tr>
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

              <tr>
				  <td>อาชีพประจำ : </td>
           		  <td>
							<select name="OccupationalCategory" required>
									<option value=""><-- โปรดระบุ --></option>
									<?php
                                    $strSQL = "SELECT * FROM t_occupation ORDER BY id ASC";
                                    $objQuery = mysql_query($strSQL);
                                    while($objResuut = mysql_fetch_array($objQuery))
                                    {
                                    ?>
                                    <option value="<?php echo $objResuut["desc"];?>"><?php echo $objResuut["desc"];?></option>
                                    <?php
                                    }
                                    ?>
		  				</select>
						</td>
                        <td>&nbsp;</td>
                        <td>ตำแหน่ง : </td>
                       <td><input type="text" name="OCCUPATION_POSITION"  size="30" /></td>
                 </tr>
                 <tr>
                 		<td>หน้าที่รับผิดชอบ : </td>
                       <td><input type="text" name="OCCUPATION_DETAILS"  size="30" /></td>
                 		<td>&nbsp;</td>
                       <td>รายได้ต่อปี : </td>
                       <td><input type="text" name="AnnualIncome" maxlength="17" size="15" /></td>
                 </tr>
            </table>
            </fieldset>
 		</div>
        <!--end  form 2-->

        <br />
        <div>
        <fieldset id="form-content">
        <legend></legend>

            <div id="answer">

                <table id="table-form">
                <tr>
				  <td>น้ำหนัก  : </td>
                  <td colspan="4"><input type="text" name="WEIGHT" maxlength="5" size="10" onchange="calBMI()" required/> ก.ก.</td>
                  <th>&nbsp;</th>
                   <td>ส่วนสูง : </td>
                  <td><input type="text" name="HEIGHT" maxlength="5"  size="10" onchange="calBMI()" required/> ซม.</td>
									<th>&nbsp;</th>
                  	<td>BMI : </td>
                  <td><input type="text" name="BMI_SHOW" maxlength="5"  size="10"/> </td>
                </tr>
            </table>
            </div>

            </fieldset>
 		</div>
        <br />
        <!--start  form 5-->
        <div>
        <fieldset id="form-content">
        <legend>แบบประกันภัย</legend>
        	<table id="table-form">
                <tr>
				  <td>แผนประกันภัย  : </td>
                  <td><select name="COVERAGE_NAME" required onchange="getPremiumGenExP()">
                     <option value=""><-- โปรดระบุ --></option>
                     <option value="600000.00">600000.00</option>
                     <option value="1200000.00">1200000.00</option>
                     <option value="1800000.00">1800000.00</option>
					 <option value="2400000.00">2400000.00</option>
					 <option value="3000000.00">3000000.00</option>
                     <option value="3600000.00">3600000.00</option>
                   </select></td>
                </tr>
							  <td>การชำระเงิน  : </td>
			                  <td><select name="PaymentFrequency" required >
			                     <option value="รายปี">รายปี</option>
			                   </select></td>
			                </tr>
                 <tr>
                   <td>เบี้ยประกันภัยรวม : </td>
                  <td><input type="text" name="INSTALMENT_PREMIUM" maxlength="15" value="" required/> บาท</td>
                </tr>
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
								<td>ประเภทบัตร : </td>
                 <td><select name="CardType" required onChange="">
                     <option value=""><-- โปรดระบุ --></option>
                     <option value="เครดิต">เครดิต</option>
                     <option value="เดบิต">เดบิต</option>
                   </select></td>
							</tr>
							<tr>
								<td>ชื่อเจ้าของบัตร (Eng) : </td>
								<td><input id="card_name_eng" style="text-transform:uppercase ;" type="text" name="card_name_eng" maxlength="100"  size="30" required/></td>
								<td>&nbsp;</td>
								<td>นามสกุล : </td>
								<td><input id="card_lastname_eng" style="text-transform:uppercase ;" type="text" name="card_lastname_eng" maxlength="100"  size="30" required/></td>
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
            <br />
            </fieldset>
  </div>
  <!--end  form 5-->

        <br />
        <!--start  form 7-->
        <div>
        <fieldset id="form-content">
        <legend>ผู้รับผลประโยชน์</legend>
            <div><h2>ผู้รับผลประโยชน์ 1</h2></div>
        	<table id="table-form">
            	<tr>
				  <td>คำนำหน้า : </td>
                   <td>
										 <select name="BENEFICIARY_TITLE1" required>
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
				  <td>ชื่อ : </td>
                  <td><input type="text" name="BENEFICIARY_NAME1" maxlength="60" size="35" required/></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME1" maxlength="60" size="35" required/></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP1" required>
                     <option value=""><-- โปรดระบุ --></option>
                     <?php
			$strSQL = "SELECT * FROM t_relation where project = 'gen' ORDER BY name ASC";
			$objQuery = mysql_query($strSQL);
			while($objResuut = mysql_fetch_array($objQuery))
			{
			?>
			<option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
			<?php
			}
			?>
                   </select></td>
                   <th>&nbsp;</th>
                  <td>อายุ  : </td>
                  <td><input type="text" name="BENEFICIARY_AGE1" maxlength="8" size="8" required/></td>
                </tr>
                <tr>
				  <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT1" maxlength="3"  size="8" required/></td>
                </tr>
            </table>
             <div><h2>ผู้รับผลประโยชน์ 2</h2></div>
        	<table id="table-form">
                <tr>
				  <td>คำนำหน้า : </td>
                   <td>
										 <select name="BENEFICIARY_TITLE2" >
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
				  <td>ชื่อ : </td>
                  <td><input type="text" name="BENEFICIARY_NAME2" maxlength="60" size="35" /></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME2" maxlength="60" size="35" /></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP2" >
                     <option value=""><-- โปรดระบุ --></option>
                     <?php
			$strSQL = "SELECT * FROM t_relation where project = 'gen' ORDER BY name ASC";
			$objQuery = mysql_query($strSQL);
			while($objResuut = mysql_fetch_array($objQuery))
			{
			?>
			<option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
			<?php
			}
			?>
                   </select></td>
                   <th>&nbsp;</th>
                  <td>อายุ  : </td>
                  <td><input type="text" name="BENEFICIARY_AGE2" maxlength="8" size="8" /></td>
                </tr>
                <tr>
				  <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT2" maxlength="3"  size="8" /></td>
                </tr>
            </table>
            <div><h2>ผู้รับผลประโยชน์ 3</h2></div>
        	<table id="table-form">
            	<tr>
				  <td>คำนำหน้า : </td>
                   <td>
										 <select name="BENEFICIARY_TITLE3" >
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
				  				<td>ชื่อ : </td>
	                  <td><input type="text" name="BENEFICIARY_NAME3" maxlength="60" size="35" /></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME3" maxlength="60" size="35" /></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP3" >
                     <option value=""><-- โปรดระบุ --></option>
                     <?php
			$strSQL = "SELECT * FROM t_relation where project = 'gen' ORDER BY name ASC";
			$objQuery = mysql_query($strSQL);
			while($objResuut = mysql_fetch_array($objQuery))
			{
			?>
			<option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
			<?php
			}
			?>
                   </select></td>
                   <th>&nbsp;</th>
                  <td>อายุ  : </td>
                  <td><input type="text" name="BENEFICIARY_AGE3" maxlength="8" size="8" /></td>
                </tr>
                <tr>
				  <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT3" maxlength="3"  size="8" /></td>
                </tr>
            </table>
            <div><h2>ผู้รับผลประโยชน์ 4</h2></div>
        	<table id="table-form">
            	<tr>
				  <td>คำนำหน้า : </td>
                   <td>
										 <select name="BENEFICIARY_TITLE4" >
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
				  				<td>ชื่อ : </td>
	                  <td><input type="text" name="BENEFICIARY_NAME4" maxlength="60" size="35" /></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME4" maxlength="60" size="35" /></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP4" >
                     <option value=""><-- โปรดระบุ --></option>
                     <?php
			$strSQL = "SELECT * FROM t_relation where project = 'gen' ORDER BY name ASC";
			$objQuery = mysql_query($strSQL);
			while($objResuut = mysql_fetch_array($objQuery))
			{
			?>
			<option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
			<?php
			}
			?>
                   </select></td>
                   <th>&nbsp;</th>
                  <td>อายุ  : </td>
                  <td><input type="text" name="BENEFICIARY_AGE4" maxlength="8" size="8" /></td>
                </tr>
                <tr>
				  <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT4" maxlength="3"  size="8" /></td>
                </tr>
            </table>


            </fieldset>
 		</div>
        <!--end  form 3-->
        <br/>
        <div>
        <fieldset id="form-content">
        <legend>คำถามสุขภาพ</legend>

            <div id="answer">
            	<p>1. ท่านมีหรือได้ขอเอาประกันภัยอุบัติเหตุส่วนบุคคล หรือประกันชีวิตไว้กับบริษัทหรือกับบริษัทอืนหรือไม่? <br /><br /><input type="radio" name="Answer1_1" value="0" required/> ไม่เคย &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer1_1" value="1" /> เคย</p>
           		<p>(ถ้าเคยโปรดระบุรายละเอียด) บริษัท <input type="text" name="Answer1_2"   size="30" /> จำนวนเงินเอาประกันภัย <input type="text" name="Answer1_3"   size="30" />
            	<br />
                <br />
                <p>2.  ท่านเคยถูกปฏิเสธการขอเอาประกันภัยอุบัติเหตุส่วนบุคคล หรือการขอเอาประกันชีวิต หรือถูกปฏิเสธการต่ออายุสัญญาประกันภัย หรือถูกเรียก เก็บเบี้ยประกันภัยเพิ่มสำหรับการประกันภัยดังกล่าวหรือไม่ ?<br /><br /><input type="radio" name="Answer2_1" value="0" required/> ไม่เคย &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer2_1" value="1" /> เคย</p>
           		<p>(ถ้าเคยโปรดระบุรายละเอียด) บริษัท <input type="text" name="Answer2_2"   size="30" /> สาเหตุ <input type="text" name="Answer2_3"   size="30" /> เมื่อใด <input type="text" name="Answer2_4"   size="20" /></p>
            	<br />
                <p>3. ท่านเคยได้รับการวินิจฉัย หรือเคยเข้ารับการรักษาพยาบาลด้วยโรค การผ่าตัด การได้รับการบาดเจ็บทางร่างกาย หรือไม่ ?<br /><br /><input type="radio" name="Answer3_1" value="0" required/> ไม่เคย &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer3_1" value="1" /> เคย</p>
           		<p>(ถ้าเคยโปรดระบุรายละเอียด) ชื่อโรค/ลักษณะการบาดเจ็บ /สาเหตุ <input type="text" name="Answer3_2"   size="100" /> 
            	<br />
                
                
            </div>
            
            </fieldset>
 		</div>
        
        

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
                                    <input type="hidden" name="camp" value="GenExclusivePlus" />
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
