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

  $(function() {
		$('#datepicker6').datepicker({
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
		$result2= mysqli_query($Conn, $strSQL2);
		while($objResult2 = mysqli_fetch_array($result2))
		{
			$first_name = $objResult2["first_name"] ;
			$last_name = $objResult2["last_name"] ;
			$tsr_code = $objResult2["sales_agent_code"] ;
			$license_code = $objResult2["sales_license_code"] ;
			$team_id = $objResult2["team_id"];
		}

    $strSQL3 = "SELECT first_name,last_name,tel1 FROM t_calllist WHERE calllist_id = '$calllist_id' ";
		$result3= mysqli_query($Conn, $strSQL3);
		while($objResult3 = mysqli_fetch_array($result3))
		{		
      $cust_first_name = $objResult3["first_name"];
      $cust_last_name = $objResult3["last_name"];
      $Mobile1 = $objResult3["tel1"];
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
                        <td>Happy Family <?php echo $campaign_id;?></td>
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
        <br/><h1>คำถามเกี่ยวกับข้อมูลส่วนบุคคลของผู้ขอเอาประกันภัย และรายละเอียดการขอเอาประกันภัย</h1><br/>
        <legend>ผู้เอาประกัน</legend>

        	<table id="table-form">
            	  <tr>
				            <td>คำนำหน้าผู้เอาประกัน : </td>
                    <td>
										 <select name="TITLE" required>
										 	<option value=""><-- โปรดระบุ --></option>
											<?php
                                            $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                                            $objQuery = mysqli_query($Conn, $strSQL);
                                            while($objResuut = mysqli_fetch_array($objQuery))
                                            {
                                            ?>
                                            <option value="<?php echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                            <?php
                                            }
                                            ?>
		  					 		</select></td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
				  				 <td>ชื่อผู้เอาประกัน (ไทย) : </td>
                   <td><input type="text" name="FIRSTNAME" maxlength="60" required value="<?php echo $cust_first_name; ?>"/></td>
                   <th>&nbsp;</th>
                   <td>นามสกุล (ไทย) : </td>
                   <td><input type="text" name="LASTNAME" maxlength="60" required value="<?php echo $cust_last_name; ?>"></td>
                </tr>
                <tr>
				          <td>เพศ : </td>
                   <td><select name="SEX" required>
                     <option value=""><-- โปรดระบุ --></option>
                     <option value="ชาย">ชาย</option>
                     <option value="หญิง">หญิง</option>
                   </select></td>
                   <th>&nbsp;</th>
                </tr>
                <tr>
                  <td>วัน/เดือน/ปี เกิด : </td>
                  <td><input id="datepicker" type="text" name="DOB" maxlength="10" onchange="getAge(this)"  required /></td>
                  <th>&nbsp;</th>
				          <td>อายุ : </td>
                  <td><input id="age" type="text" name="ADE_AT_RCD" maxlength="2"  size="8" required readonly /> &nbsp;ปี</td>
                  
                  
                </tr>
                <tr>  
				          <td>เลขที่บัตรประชาชน : </td>
                  <td><input type="text" name="IDCARD" maxlength="13"  size="20" required/></td>
                  <th>&nbsp;</th>
                  <td>อาชีพ : </td>
           		    <td>
                  <select name="OCCUPATIONAL" required>
                      <option value=""><-- โปรดระบุ --></option>
                      <?php
                                        $strSQL = "SELECT * FROM t_aig_pancode where type = 'occupation' ORDER BY id ASC";
                                        $objQuery = mysqli_query($Conn, $strSQL);
                                        while($objResuut = mysqli_fetch_array($objQuery))
                                        {
                                        ?>
                                        <option value="<?php echo $objResuut["name"];?>"><?php echo $objResuut["name"];?></option>
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
                    <td><input type="text" name="ADDRESSNO1" maxlength="30" size="30" required/></td>
                    <th>&nbsp;</th>
                    <td>หมู่บ้าน/อาคาร : </td>
                    <td><input type="text" name="BUILDING1" maxlength="30"  size="30"/></td>
                </tr>
                <tr>
                    <td>หมู่ : </td>
                    <td><input type="text" name="MOO1" maxlength="50"  size="10" /></td>
                    <th>&nbsp;</th>
                    <td>ตรอก/ซอย : </td>
                    <td><input type="text" name="SOI1" maxlength="50"  size="30" /></td>
                </tr>
			          <tr>
              		 <td>ถนน : </td>
                   <td><input type="text" name="ROAD1" maxlength="50"  size="30" /></td>
                   <th>&nbsp;</th>
              	   <td>แขวง/ตำบล : </td>
                   <td><select name="SUB_DISTRICT1" id="Sub_district1" required onchange="show_ZIPCODE(this.value,document.getElementById('district1').value,document.getElementById('province1').value)">
                          <option value=""><-- โปรดระบุ --></option>
                      </select></td>
                </tr>
                <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><select name="DISTRICT1" id="district1" required onchange="show_SUBDISTRICT(this.value,document.getElementById('province1').value)">
                          <option value=""><-- โปรดระบุ --></option>
                      </select></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
                   	<select name="PROVINCE1" id="province1" required onchange="show_DISTRICT(this.value)">
                     <option value=""><-- โปรดระบุ --></option>
                        <?php
                        $strSQL = "SELECT * FROM t_aig_address GROUP BY PROVINCE_TH ORDER BY PROVINCE_TH ASC";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while($objResuut = mysqli_fetch_array($objQuery))
                        {
                        ?>
                        <option value="<?php  echo $objResuut["PROVINCE_TH"];?>"><?php echo $objResuut["PROVINCE_TH"];?></option>
                        <?php
                        }
                        ?>
                     </select>
                   </td>
                </tr>
                <tr>
              	   <td>รหัสไปรษณีย์ : </td>
                   <td><select name="ZIPCODE1" id="zipcode1" required >
                          <option value=""><-- โปรดระบุ --></option>
                      </select></td>
                   <th>&nbsp;</th>
                   <td>โทรศัพท์บ้าน : </td>
                 <td><input type="text" name="TELEPHONE1" maxlength="9"  size="15" /></td>
                </tr>
                <tr>
              	   <td>โทรศัพท์มือถือ : </td>
                  <td><input type="text" name="MOBILE1" maxlength="10" value="<?php echo $Mobile1; ?>" size="15" required/></td>
                </tr>

            </table>
          </fieldset>
 	    </div>
        <!--end  form 2-->

        <br />
        
        <div>
        <fieldset id="form-content">
        <legend>แบบประกันภัย</legend>
        	<table id="table-form">
                <tr>
				          <td>แบบประกันภัย  : </td>
                  <td><select name="PRODUCT_NAME" required onchange="getPremiumFamily()">
                     <option value=""><-- โปรดระบุ --></option>
                     <option>แผนรายเดี่ยว</option>
                     <option>แผนคู่สมรส</option>
                     <option>แผนครอบครัว</option>
                     <option>แผนบุพการี</option>
                   </select></td>
                </tr>
                <tr>
				          <td>แผนประกันภัย  : </td>
                  <td><select name="COVERAGE_NAME" required onchange="getPremiumFamily()">
                     <option value=""><-- โปรดระบุ --></option>
                     <option>Plan 1</option>
                     <option>Plan 2</option>
                     <option>Plan 3</option>
                   </select></td>
                </tr>
							  <td>การชำระเงิน  : </td>
			                  <td><select name="PAYMENTFREQUENCY" required onchange="getPremiumFamily()">
			                     <option value=""><-- โปรดระบุ --></option>
			                     <option value="รายเดือน">รายเดือน</option>
			                     <option value="รายปี">รายปี</option>
			                   </select></td>
			                </tr>
                 <tr>
                   <td>เบี้ยประกันภัยรวม : </td>
                  <td><input type="text" name="INSTALMENT_PREMIUM" maxlength="15" value="" required/> บาท</td>
                </tr>
            </table><br />
             
            <span style="color:red">* ในกรณี ที่เป็นแบบประกัน คู่สมรส, ครอบครัว, บุพการี จะต้องมีการกรอก ผู้เอาประกันเพิ่มเติม</label></span>
            <!--Insure 2-->
            <div><h2>ผู้เอาประกันที่ 2</h2></div>
              <table id="table-form">
                  <tr>
                    <td>คำนำหน้า : </td>
                            <td>
                              <select name="INSURED_TITLE2" >
                                <option value=""><-- โปรดระบุ --></option>
                                <?php
                                                      $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                                                      $objQuery = mysqli_query($Conn, $strSQL);
                                                      while($objResuut = mysqli_fetch_array($objQuery))
                                                      {
                                                      ?>
                                                      <option value="<?php echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                                      <?php
                                                      }
                                                      ?>
                              </select></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>ชื่อ : </td>
                            <td><input type="text" name="INSURED_NAME2" maxlength="60" size="35" /></td>
                            <th>&nbsp;</th>
                            <td>นามสกุล  : </td>
                            <td><input type="text" name="INSURED_LASTNAME2" maxlength="60" size="35" /></td>
                          </tr>
                          <tr>
                            <td>วัน/เดือน/ปี เกิด : </td>
                            <td><input id="datepicker2" type="text" name="INSURED_DOB2" maxlength="10"   /></td>                               
                            <th>&nbsp;</th>
                            <td>ความสัมพันธ์ : </td>
                              <td><select name="INSURED_RELATIONSHIP2" >
                                  <option value=""><-- โปรดระบุ --></option>
                                  <?php
                                      $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                                      $objQuery = mysqli_query($Conn, $strSQL);
                                      while($objResuut = mysqli_fetch_array($objQuery))
                                      {
                                      ?>
                                      <option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                      <?php
                                      }
                                    ?>
                          </select></td>
                    </tr>
                </table>


                <!--Insure 3-->
            <div><h2>ผู้เอาประกันที่ 3</h2></div>
              <table id="table-form">
                  <tr>
                    <td>คำนำหน้า : </td>
                            <td>
                              <select name="INSURED_TITLE3" >
                                <option value=""><-- โปรดระบุ --></option>
                                <?php
                                                      $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                                                      $objQuery = mysqli_query($Conn, $strSQL);
                                                      while($objResuut = mysqli_fetch_array($objQuery))
                                                      {
                                                      ?>
                                                      <option value="<?php echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                                      <?php
                                                      }
                                                      ?>
                              </select></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>ชื่อ : </td>
                            <td><input type="text" name="INSURED_NAME3" maxlength="60" size="35" /></td>
                            <th>&nbsp;</th>
                            <td>นามสกุล  : </td>
                            <td><input type="text" name="INSURED_LASTNAME3" maxlength="60" size="35" /></td>
                          </tr>
                          <tr>
                            <td>วัน/เดือน/ปี เกิด : </td>
                            <td><input id="datepicker3" type="text" name="INSURED_DOB3" maxlength="10"   /></td>                               
                            <th>&nbsp;</th>
                            <td>ความสัมพันธ์ : </td>
                              <td><select name="INSURED_RELATIONSHIP3" >
                                  <option value=""><-- โปรดระบุ --></option>
                                  <?php
                                      $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                                      $objQuery = mysqli_query($Conn, $strSQL);
                                      while($objResuut = mysqli_fetch_array($objQuery))
                                      {
                                      ?>
                                      <option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                      <?php
                                      }
                                    ?>
                          </select></td>
                    </tr>
                </table>

            <!--Insure 4-->
            <div><h2>ผู้เอาประกันที่ 4</h2></div>
              <table id="table-form">
                  <tr>
                    <td>คำนำหน้า : </td>
                            <td>
                              <select name="INSURED_TITLE4" >
                                <option value=""><-- โปรดระบุ --></option>
                                <?php
                                                      $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                                                      $objQuery = mysqli_query($Conn, $strSQL);
                                                      while($objResuut = mysqli_fetch_array($objQuery))
                                                      {
                                                      ?>
                                                      <option value="<?php echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                                      <?php
                                                      }
                                                      ?>
                              </select></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>ชื่อ : </td>
                            <td><input type="text" name="INSURED_NAME4" maxlength="60" size="35" /></td>
                            <th>&nbsp;</th>
                            <td>นามสกุล  : </td>
                            <td><input type="text" name="INSURED_LASTNAME4" maxlength="60" size="35" /></td>
                          </tr>
                          <tr>
                            <td>วัน/เดือน/ปี เกิด : </td>
                            <td><input id="datepicker4" type="text" name="INSURED_DOB4" maxlength="10"   /></td>                               
                            <th>&nbsp;</th>
                            <td>ความสัมพันธ์ : </td>
                              <td><select name="INSURED_RELATIONSHIP4" >
                                  <option value=""><-- โปรดระบุ --></option>
                                  <?php
                                      $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                                      $objQuery = mysqli_query($Conn, $strSQL);
                                      while($objResuut = mysqli_fetch_array($objQuery))
                                      {
                                      ?>
                                      <option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                      <?php
                                      }
                                    ?>
                          </select></td>
                    </tr>
                </table>


                <!--Insure 2-->
            <div><h2>ผู้เอาประกันที่ 5</h2></div>
              <table id="table-form">
                  <tr>
                    <td>คำนำหน้า : </td>
                            <td>
                              <select name="INSURED_TITLE5" >
                                <option value=""><-- โปรดระบุ --></option>
                                <?php
                                                      $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                                                      $objQuery = mysqli_query($Conn, $strSQL);
                                                      while($objResuut = mysqli_fetch_array($objQuery))
                                                      {
                                                      ?>
                                                      <option value="<?php echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                                      <?php
                                                      }
                                                      ?>
                              </select></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>ชื่อ : </td>
                            <td><input type="text" name="INSURED_NAME5" maxlength="60" size="35" /></td>
                            <th>&nbsp;</th>
                            <td>นามสกุล  : </td>
                            <td><input type="text" name="INSURED_LASTNAME5" maxlength="60" size="35" /></td>
                          </tr>
                          <tr>
                            <td>วัน/เดือน/ปี เกิด : </td>
                            <td><input id="datepicker5" type="text" name="INSURED_DOB5" maxlength="10"  /></td>                               
                            <th>&nbsp;</th>
                            <td>ความสัมพันธ์ : </td>
                              <td><select name="INSURED_RELATIONSHIP5" >
                                  <option value=""><-- โปรดระบุ --></option>
                                  <?php
                                      $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                                      $objQuery = mysqli_query($Conn, $strSQL);
                                      while($objResuut = mysqli_fetch_array($objQuery))
                                      {
                                      ?>
                                      <option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                      <?php
                                      }
                                    ?>
                          </select></td>
                    </tr>
                </table>


            
            


            </fieldset>
          </div>
          <!--end  form 5-->
        <br />

        <!--start  form 7-->
        <div>
        <fieldset id="form-content">
        <legend>ผู้รับผลประโยชน์</legend>
            <div style="padding: 10px 50px 10px 50px ;  "><input type="checkbox" id="GIVEN_BENAFICIARY" name="GIVEN_BENAFICIARY" value="1">
            <label for="vehicle1"> ระบุเป็น ทายาทโดยธรรม &nbsp;&nbsp;<span style="color:red">* ถ้าระบุ ไม่ต้องทำการกรอกข้อมูลผู้รับผลประโยชน์</label></span><br></div>
            <div><h2>ผู้รับผลประโยชน์ 1</h2></div>
        	<table id="table-form">
            	<tr>
				  <td>คำนำหน้า : </td>
                   <td>
										 <select name="BENEFICIARY_TITLE1" >
										 	<option value=""><-- โปรดระบุ --></option>
											<?php
                                            $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                                            $objQuery = mysqli_query($Conn, $strSQL);
                                            while($objResuut = mysqli_fetch_array($objQuery))
                                            {
                                            ?>
                                            <option value="<?php echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                                            <?php
                                            }
                                            ?>
		  					 		</select></td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
				  <td>ชื่อ : </td>
                  <td><input type="text" name="BENEFICIARY_NAME1" maxlength="60" size="35" /></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME1" maxlength="60" size="35" /></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP1" >
                     <option value=""><-- โปรดระบุ --></option>
                     <?php
                        $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while($objResuut = mysqli_fetch_array($objQuery))
                        {
                        ?>
                        <option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
                        <?php
                        }
                      ?>
                   </select></td>
                   <th>&nbsp;</th>
                   <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT1" maxlength="3"  size="8" /></td> 
                </tr>
                <tr>
				          <td>เพศ : </td>
                   <td><select name="BENEFICIARY_SEX1" >
                     <option value=""><-- โปรดระบุ --></option>
                     <option value="ชาย">ชาย</option>
                     <option value="หญิง">หญิง</option>
                   </select></td>
                   <th>&nbsp;</th>
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
                                            $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                                            $objQuery = mysqli_query($Conn, $strSQL);
                                            while($objResuut = mysqli_fetch_array($objQuery))
                                            {
                                            ?>
                                            <option value="<?php echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
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
			$strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
			$objQuery = mysqli_query($Conn, $strSQL);
			while($objResuut = mysqli_fetch_array($objQuery))
			{
			?>
			<option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
			<?php
			}
			?>
                   </select></td>
                   <th>&nbsp;</th>
                   <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT2" maxlength="3"  size="8" /></td>
                </tr>
                <tr>
				          <td>เพศ : </td>
                   <td><select name="BENEFICIARY_SEX2" >
                     <option value=""><-- โปรดระบุ --></option>
                     <option value="ชาย">ชาย</option>
                     <option value="หญิง">หญิง</option>
                   </select></td>
                   <th>&nbsp;</th>
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
                                            $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                                            $objQuery = mysqli_query($Conn, $strSQL);
                                            while($objResuut = mysqli_fetch_array($objQuery))
                                            {
                                            ?>
                                            <option value="<?php echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
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
			$strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
			$objQuery = mysqli_query($Conn, $strSQL);
			while($objResuut = mysqli_fetch_array($objQuery))
			{
			?>
			<option value="<?php  echo $objResuut["name"];?>"><?php  echo $objResuut["name"];?></option>
			<?php
			}
			?>
                   </select></td>
                   <th>&nbsp;</th>
                   <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT3" maxlength="3"  size="8" /></td>
                </tr>
                <tr>
				          <td>เพศ : </td>
                   <td><select name="BENEFICIARY_SEX3">
                     <option value=""><-- โปรดระบุ --></option>
                     <option value="ชาย">ชาย</option>
                     <option value="หญิง">หญิง</option>
                   </select></td>
                   <th>&nbsp;</th>
                </tr>
            </table>
            
        </fieldset>
 		</div>
     <br />    

    <div>
				<fieldset id="form-content">
        <legend>Consent</legend>
        <div class="table">
        
        <div style="padding: 10px 50px 10px 50px ;  "><input type="checkbox" id="APP_CONSENT" name="APP_CONSENT" value="Y">
            <label for="vehicle1"> ไม่ยินยอมให้เปิดเผยข้อมูล &nbsp;&nbsp;<span style="color:red">* กรณีลูกค้าไม่ให้ความยินยอมส่งข้อมูลสรรพากร ลดหย่อนภาษี</label></span><br></div>
        
          </div>

				</fieldset>
		</div>
    <br /> 

     <div>
				<fieldset id="form-content">
        <legend>Payment</legend>
        <div class="table">
            <div class="table-header">
              <div class="header__item">Payment Type</div>>
              <div class="header__item">Action</div>
            </div>
            <div class="table-content">	
              <div class="table-row">		
                <div class="table-data">Change card number and generate </div>
                <div class="table-data"><button type="button" class="button" onclick="window.open('https://dpsvc-pcidigital.aig.net:15575/PCI_TH/tokenize.html')">Payment</button></div>
              </div>
              <div class="table-row">
                <div class="table-data">Online Payment Gateway </div>
                <div class="table-data"><button type="button" class="button" onclick="window.open('https://dpsvc-pcidigital.aig.net:15595/PCI_TH_TeleIntel/payment-gateway-login.html')">Payment</button></div>
              </div>
            </div>	
          </div>

				</fieldset>
		</div>
    <br />   

		<div>
				<fieldset id="form-content">
					Remark :
					<textarea rows="5" name="REMARK" id="REMARK" cols="100"></textarea>
				</fieldset>
		</div>
    <br /> 
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
	                  <option value="QC_Reject">QC_Reject</option>
	                  <option value="Credit Reject">Credit Reject</option>
	                  <option value="Partner Reject">Partner Reject</option>
 <?php } ?>
                  </select></td>
                  <th>&nbsp;</th>

									<input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>" />
									<input type="hidden" name="calllist_id" value="<?php echo $calllist_id; ?>" />
									<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
									<input type="hidden" name="import_id" value="<?php echo $import_id; ?>" />
									<input type="hidden" name="team_id" value="<?php echo $team_id; ?>" />

<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	if($lv > 1){
?>
                 
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
