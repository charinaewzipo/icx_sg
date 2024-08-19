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

<script>
function ConsentFlag() {
	//alert("I am an alert box!");
	
	var ConsentFlag = document.getElementsByName('Consent_Flag')[0].value;
	var ProposalNumber = document.getElementsByName('ProposalNumber')[0].value;
	var url = "AjaxGetConsentFlag.php?ConsentFlag="+ConsentFlag+"&ProposalNumber="+ProposalNumber;
	
	alert(url);
	
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
   //  document.getElementById("plan_insure").innerHTML=

    //document.getElementsByName('INSTALMENT_PREMIUM')[0].value = xmlhttp.responseText;
	//	 console.log( );
	     }
  }

  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}
	
</script>

<?php

$Id = $_GET["Id"];


$agent_id = $_GET["agent_id"];
	$Owner = $objResult["agent_id"];
		$strSQL2 = "SELECT * FROM t_agents WHERE agent_id = '$agent_id' ";
		$result2= mysql_query($strSQL2);
		while($objResult2 = mysql_fetch_array($result2))
		{
			$first_name = $objResult2["first_name"] ;
			$last_name = $objResult2["last_name"] ;
			$tsr_code = $objResult2["sales_agent_code"] ;
			//$sales_agent_name = $objResult2["sales_agent_name"] ;
			$license_code = $objResult2["sales_license_code"] ;
			//$sales_license_name = $objResult2["sales_license_name"] ;
			$team_id = $objResult2["team_id"];
		}



	$SQL = "select  * from t_app where ProposalNumber = '$Id'" ;
	  $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	  	while($row = mysql_fetch_array($result))
	 {

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
                        <td>Gen Health Lump Sum</td>
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
<form name="App" method="post" action="app_update.php">
        <!--start  form 1 -->
        <div>
        <fieldset id="form-content" >
        	<table id="table-form">
                <tr>
				  <td>เลขที่ใบสมัคร : </td>
                   <td><input type="text" name="App_ID" maxlength="15" value="<?php echo "$Id" ?>" /></td>
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
										 	<option value="<?php  echo $row["Title"];?>"><?php  echo $row["Title"];?></option>
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
                   <td><input type="text" name="Firstname" maxlength="60" required value="<?php  echo $row["Firstname"];?>"/></td>
                   <th>&nbsp;</th>
                   <td>นามสกุล (ไทย) : </td>
                   <td><input type="text" name="Lastname" maxlength="60" required/ value="<?php  echo $row["Lastname"];?>"></td>
                </tr>
                <tr>
				  <td>เพศ : </td>
                   <td><select name="Sex" required>
                     <option value="<?php  echo $row["Sex"];?>"><?php  echo $row["Sex"];?></option>
                     <option value="ชาย">ชาย</option>
                     <option value="หญิง">หญิง</option>
                   </select></td>
                   <th>&nbsp;</th>
                   <td>สถานะภาพ : </td>
                   <td><select name="MaritalStatus" required>
                     			<option value="<?php  echo $row["MaritalStatus"];?>"><?php  echo $row["MaritalStatus"];?></option>
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
										 <option value="<?php  echo $row["Nationality"];?>"><?php  echo $row["Nationality"];?></option>
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
                  <td><input id="age" type="text" name="ADE_AT_RCD" maxlength="2"  size="8" value="<?php  echo $row["ADE_AT_RCD"];?>" required readonly /> &nbsp;ปี</td>
                  <th>&nbsp;</th>
                   <td>เกิดวันที่ : </td>
                  <td><input id="datepicker" type="text" name="DOB" maxlength="10" onchange="getAge(this)"  value="<?php  echo $row["DOB"];?>" required /></td>
                </tr>
                <tr>  
				  <td>เลขที่บัตรประชาชน : </td>
                  <td><input type="text" name="IdCard" maxlength="13"  size="20" value="<?php  echo $row["IdCard"];?>" required/></td>
                  <td>&nbsp;</td>
                  <td>วันที่บัตรหมดอายุ : </td>
                  <td><input id="datepicker2" type="text" name="IdCardExpire" maxlength="13" value="<?php  echo $row["IdCardExpire"];?>"   required /></td>
              </tr>
               <tr>  
				  <td>ออกโดย เขต/อำเภอ : </td>
                  <td><input type="text" name="IdCard_from_distric" maxlength="13"  size="20" value="<?php  echo $row["IdCard_from_distric"];?>" required/></td>
                  <td>&nbsp;</td>
                  <td>จังหวัด : </td>
                  <td>
                   	<select name="IdCard_from_province" required>
                        <option value="<?php  echo $row["IdCard_from_province"];?>"><?php  echo $row["IdCard_from_province"];?></option>
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
                   <td><input type="text" name="AddressNo1" maxlength="30" size="30" value="<?php  echo $row["AddressNo1"];?>" required/></td>
                   <th>&nbsp;</th>
                   <td>หมู่บ้าน/อาคาร : </td>
                   <td><input type="text" name="building1" maxlength="30"  size="30" value="<?php  echo $row["building1"];?>"/></td>
              </tr>
              <tr>
              	   <td>หมู่ : </td>
                   <td><input type="text" name="Moo1" maxlength="50"  size="10" value="<?php  echo $row["Moo1"];?>" /></td>
                   <th>&nbsp;</th>
                   <td>ตรอก/ซอย : </td>
                   <td><input type="text" name="Soi1" maxlength="50"  size="30" value="<?php  echo $row["Soi1"];?>"/></td>
              </tr>
			  <tr>
              		<td>ถนน : </td>
                   <td><input type="text" name="Road1" maxlength="50"  size="30" value="<?php  echo $row["Road1"];?>"/></td>
                   <th>&nbsp;</th>
              	   <td>แขวง/ตำบล : </td>
                   <td><input type="text" name="Sub_district1" maxlength="50"  size="30" value="<?php  echo $row["Sub_district1"];?>" required/></td>
              </tr>
              <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><input type="text" name="district1" maxlength="50"  size="30" value="<?php  echo $row["district1"];?>" required/></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
                   	<select name="province1" required>
                        <option value="<?php  echo $row["province1"];?>"><?php  echo $row["province1"];?></option>
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
                 <td><input type="text" name="zipcode1" maxlength="5" size="10" value="<?php  echo $row["zipcode1"];?>" required/></td>
                   <th>&nbsp;</th>
                   <td>โทรศัพท์บ้าน : </td>
                 <td><input type="text" name="telephone1" maxlength="25"  size="15" value="<?php  echo $row["telephone1"];?>"/></td>
              </tr>
               <tr>
              	   <td>โทรศัพท์มือถือ : </td>
                  <td><input type="text" name="Mobile1" maxlength="25" size="15" value="<?php  echo $row["Mobile1"];?>" required/></td>
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
                   <td><input type="text" name="AddressNo3" maxlength="20" value="<?php  echo $row["AddressNo3"];?>" /></td>
                   <th>&nbsp;</th>
                   <td>หมู่บ้าน/อาคาร : </td>
                   <td><input type="text" name="building3" maxlength="50"  size="30" value="<?php  echo $row["building3"];?>"/></td>
              </tr>
              <tr>
              	   <td>หมู่ : </td>
                   <td><input type="text" name="Moo3" maxlength="50"  size="10" value="<?php  echo $row["Moo3"];?>"/></td>
                   <th>&nbsp;</th>
                   <td>ตรอก/ซอย : </td>
                   <td><input type="text" name="Soi3" maxlength="50"  size="30" value="<?php  echo $row["Soi3"];?>"/></td>
              </tr>
			  <tr>
              		<td>ถนน : </td>
                   <td><input type="text" name="Road3" maxlength="50"  size="30" value="<?php  echo $row["Road3"];?>"/></td>
                   <th>&nbsp;</th>
              	   <td>แขวง/ตำบล : </td>
                   <td><input type="text" name="Sub_district3" maxlength="50"  size="30" value="<?php  echo $row["Sub_district3"];?>"/></td>
              </tr>
              <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><input type="text" name="district3" maxlength="50"  size="30" value="<?php  echo $row["district3"];?>"/></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
           		 	<select name="province3" required>
                        <option value="<?php  echo $row["province3"];?>"><?php  echo $row["province3"];?></option>
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
                 <td><input type="text" name="zipcode3" maxlength="5" size="10" value="<?php  echo $row["zipcode3"];?>" /></td>
                 <th>&nbsp;</th>
                   <td>โทรศัพท์ : </td>
                 <td><input type="text" name="telephone3" maxlength="25"  size="15" value="<?php  echo $row["telephone3"];?>" /></td>
                </tr>
             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>

              <tr>
				  <td>อาชีพประจำ : </td>
           		  <td>
							<select name="OccupationalCategory" required>
									<option value="<?php  echo $row["OccupationalCategory"];?>"><?php  echo $row["OccupationalCategory"];?></option>
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
                       <td><input type="text" name="OCCUPATION_POSITION"  size="30" value ="<?php echo $row["OCCUPATION_POSITION"];?>" /></td>
                 </tr>
                 <tr>
                 		<td>หน้าที่รับผิดชอบ : </td>
                       <td><input type="text" name="OCCUPATION_DETAILS"  size="30" value ="<?php echo $row["OCCUPATION_DETAILS"];?>" /></td>
                 		<td>&nbsp;</td>
                       <td>รายได้ต่อปี : </td>
                       <td><input type="text" name="AnnualIncome" maxlength="17" size="15" value ="<?php echo $row["AnnualIncome"];?>" /></td>
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
                  <td colspan="4"><input type="text" name="WEIGHT" maxlength="5" size="10" onchange="calBMI()" value ="<?php echo $row["WEIGHT"];?>" required/> ก.ก.</td>
                  <th>&nbsp;</th>
                   <td>ส่วนสูง : </td>
                  <td><input type="text" name="HEIGHT" maxlength="5"  size="10" onchange="calBMI()" value ="<?php echo $row["HEIGHT"];?>" required/> ซม.</td>
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
                  <td><select name="COVERAGE_NAME" required onchange="getPremiumGenHealth()">
                     <option value="<?php echo $row["COVERAGE_NAME"];?>"><?php echo $row["COVERAGE_NAME"];?></option>
                     <option value="250000.00">250000.00</option>
                     <option value="500000.00">500000.00</option>
                     <option value="750000.00">750000.00</option>
					 <option value="1000000.00">1000000.00</option>
                   </select></td>
                </tr>
                <td>ประเภทแบบประกัน  : </td>
			                  <td><select name="ProductCode" required onchange="getPremiumGenHealth()">
			                     <option value="<?php echo $row["ProductCode"];?>"><?php echo $row["ProductCode"];?></option>
			                     <option value="IPD">IPD</option>
			                     <option value="IPD,OPD">IPD,OPD</option>
			                   </select></td>
			                </tr>
							  <td>การชำระเงิน  : </td>
			                  <td><select name="PaymentFrequency" required onchange="getPremiumGenHealth()">
			                     <option value="<?php echo $row["PaymentFrequency"];?>"><?php echo $row["PaymentFrequency"];?></option>
			                     <option value="รายเดือน">รายเดือน</option>
			                     <option value="รายปี">รายปี</option>
			                   </select></td>
			                </tr>
                 <tr>
                   <td>เบี้ยประกันภัยรวม : </td>
                  <td><input type="text" name="INSTALMENT_PREMIUM" maxlength="15" value="<?php echo $row["INSTALMENT_PREMIUM"];?>" required/> บาท</td>
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
				<td>ผู้ชำระเงิน : </td>
                 <td><select name="payment_relation" required onChange="">
                 	<option value="<?php echo $row["payment_relation"];?>"><?php echo $row["payment_relation"];?></option>
                     <option value="ผู้เอาประกัน">ผู้เอาประกัน</option>
                     <option value="สามี">สามี</option>
					 <option value="ภรรยา">ภรรยา</option>
                     <option value="บุตร">บุตร</option>
                     <option value="บิดา">บิดา</option>
                     <option value="มารดา">มารดา</option>
                   </select></td>
			</tr>
				<tr>
				<td>ประเภทบัตร : </td>
                 <td><select name="CardType" required onChange="">
                     <option value="<?php echo $row["CardType"];?>"><?php echo $row["CardType"];?></option>
                     <option value="เครดิต">เครดิต</option>
                     <option value="เงินสด">เงินสด</option>
                   </select></td>
							</tr>
							<tr>
								<td>ชื่อเจ้าของบัตร (Eng) : </td>
								<td><input id="card_name_eng" style="text-transform:uppercase ;" type="text" name="card_name_eng" maxlength="100"  size="30" value="<?php echo $row["card_name_eng"];?>" required/></td>
								<td>&nbsp;</td>
								<td>นามสกุล : </td>
								<td><input id="card_lastname_eng" style="text-transform:uppercase ;" type="text" name="card_lastname_eng" maxlength="100"  size="30" value="<?php echo $row["card_lastname_eng"];?>" required/></td>
						 </tr>
						 <tr>
							 <td>เลขที่บัตรเครดิต : </td>
							 <td><input id="AccountNo" type="text" name="AccountNo" maxlength="16"  size="30" value="<?php echo $row["AccountNo"];?>" required/></td>
                             <td>&nbsp;</td>
<?php 
 $ExpiryDate = $row["ExpiryDate"];
 $CREDIT_CARD_EXPIRY_DATE =  substr($ExpiryDate, 0, 2);
 $CREDIT_CARD_EXPIRY_YEAR =  substr($ExpiryDate, 3, 5);
?>
                              <td>วันที่บัตรหมดอายุ : </td>
                             <td id="card_expire"><select id="CREDIT_CARD_EXPIRY_DATE" name="CREDIT_CARD_EXPIRY_DATE" required>
                                 <option value="<?php echo $CREDIT_CARD_EXPIRY_DATE; ?>"><?php echo $CREDIT_CARD_EXPIRY_DATE; ?></option>
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
                                 <option value="<?php echo $CREDIT_CARD_EXPIRY_YEAR; ?>"><?php echo $CREDIT_CARD_EXPIRY_YEAR; ?></option>
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
									<option value="<?php echo $row["Bank"];?>"><?php echo $row["Bank"];?></option>
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
                     <option value="<?php echo $row["AccountType"];?>"><?php echo $row["AccountType"];?></option>
                     <option value="Visa">Visa</option>
                     <option value="Master">Master</option>
                   </select></td>
              </tr>
              <tr>
              		<td colspan="4">ข้อมูลส่วนบุคคลของผู้ชำระเบี้ยประกันภัย (กรณีผู้ขอเอาประกันเป็ น สามี / ภรรยา /บุตร / บิดา มารดา)</td>
              </tr>
              <tr>
              <td>คำนำหน้า : </td>
                   <td>
										 <select name="payment_title" >
										 	<option value="<?php  echo $row["payment_title"];?>"><?php  echo $row["payment_title"];?></option>
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
				  <td>ชื่อ ผู้ชำระเบี้ย : </td>
                  <td><input type="text" name="payment_name" maxlength="60" size="35" value="<?php echo $row["payment_name"];?>" /></td>
                  <td>&nbsp;</td>
                  <td>นาสกุล ผู้ชำระเบี้ย : </td>
                  <td><input type="text" name="payment_lastname" maxlength="60" size="35" value="<?php echo $row["payment_lastname"];?>" /></td>
              </tr>
              <tr>
				  <td>วันเดือนปี เกิด : </td>
                  <td><input type="text" name="payment_bod" maxlength="30" size="30" value="<?php echo $row["payment_bod"];?>" /></td>
                  <td>&nbsp;</td>
                  <td>อายุ : </td>
                  <td><input type="text" name="payment_age" maxlength="30" size="10" value="<?php echo $row["payment_age"];?>" /> ปี</td>
              </tr>
              <tr>
				  <td>เลขที่บัตรประชาชน : </td>
                  <td><input type="text" name="payment_idcard" maxlength="30" size="30" value="<?php echo $row["payment_idcard"];?>" /></td>
                  <td>&nbsp;</td>
                  <td>เบอร์โทรศัพท์ : </td>
                  <td><input type="text" name="payment_phone" maxlength="30" size="15" value="<?php echo $row["payment_phone"];?>" /></td>
              </tr>
              
              <tr>
				  <td>เพศ : </td>
                   <td><select name="Payer_Sex" required>
                     <option value="<?php  echo $row["Payer_Sex"];?>"><?php  echo $row["Payer_Sex"];?></option>
                     <option value="ชาย">ชาย</option>
                     <option value="หญิง">หญิง</option>
                   </select></td>
                   <th>&nbsp;</th>
                   <td>สถานะภาพ : </td>
                   <td><select name="Payer_status" required>
                     			<option value="<?php  echo $row["Payer_status"];?>"><?php  echo $row["Payer_status"];?></option>
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
                   <td>เลขที่ : </td>
                   <td><input type="text" name="AddressNo4" maxlength="20" value="<?php  echo $row["AddressNo4"];?>" /></td>
                   <th>&nbsp;</th>
                   <td>หมู่บ้าน/อาคาร : </td>
                   <td><input type="text" name="building4" maxlength="50"  size="30" value="<?php  echo $row["building4"];?>"/></td>
              </tr>
              <tr>
              	   <td>หมู่ : </td>
                   <td><input type="text" name="Moo4" maxlength="50"  size="10" value="<?php  echo $row["Moo4"];?>"/></td>
                   <th>&nbsp;</th>
                   <td>ตรอก/ซอย : </td>
                   <td><input type="text" name="Soi4" maxlength="50"  size="30" value="<?php  echo $row["Soi4"];?>"/></td>
              </tr>
			  <tr>
              		<td>ถนน : </td>
                   <td><input type="text" name="Road4" maxlength="50"  size="30" value="<?php  echo $row["Road4"];?>"/></td>
                   <th>&nbsp;</th>
              	   <td>แขวง/ตำบล : </td>
                   <td><input type="text" name="Sub_district4" maxlength="50"  size="30" value="<?php  echo $row["Sub_district4"];?>"/></td>
              </tr>
              <tr>
              	   <td>เขต/อำเภอ : </td>
                   <td><input type="text" name="district4" maxlength="50"  size="30" value="<?php  echo $row["district4"];?>"/></td>
                   <th>&nbsp;</th>
                   <td>จังหวัด : </td>
                   <td>
           		 	<select name="province4" required>
                        <option value="<?php  echo $row["province4"];?>"><?php  echo $row["province4"];?></option>
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
                 <td><input type="text" name="zipcode4" maxlength="5" size="10" value="<?php  echo $row["zipcode4"];?>" /></td>
                 <th>&nbsp;</th>
                   <td>อีเมล์ : </td>
                   <td><input type="text" name="Payer_email" maxlength="100"  size="30" value="<?php  echo $row["Payer_email"];?>" /></td>
                </tr>
              
              
              <tr>
				  <td>อาชีพ : </td>
                  <td>
							<select name="payment_occupation" >
									<option value="<?php  echo $row["payment_occupation"];?>"><?php  echo $row["payment_occupation"];?></option>
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
                  <td><input type="text" name="payment_postion" maxlength="30" size="30" value="<?php echo $row["payment_postion"];?>" /></td>
              </tr>
              <tr>
              	<td>ต้องการใบเสร็จ : </td>
              	<td><select name="payment_tax" >
                     <option value="<?php echo $row["payment_tax"];?>"><?php echo $row["payment_tax"];?></option>
                     <option value="ไม่ต้องการ">ไม่ต้องการ</option>
                     <option value="ต้องการ">ต้องการ</option>
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
										 	<option value="<?php echo $row["BENEFICIARY_TITLE1"];?>"><?php echo $row["BENEFICIARY_TITLE1"];?></option>
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
                  <td><input type="text" name="BENEFICIARY_NAME1" maxlength="60" size="35" value="<?php echo $row["BENEFICIARY_NAME1"];?>" required/></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME1" maxlength="60" size="35" value="<?php echo $row["BENEFICIARY_LASTNAME1"];?>" required/></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP1" required>
                     <option value="<?php echo $row["BENEFICIARY_RELATIONSHIP1"];?>"><?php echo $row["BENEFICIARY_RELATIONSHIP1"];?></option>
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
                  <td><input type="text" name="BENEFICIARY_AGE1" maxlength="8" size="8" value="<?php  echo $row["BENEFICIARY_AGE1"];?>" required/></td>
                </tr>
                <tr>
				  <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT1" maxlength="3"  size="8" value="<?php echo $row["BENEFICIARY_BENEFIT1"];?>" required/></td>
                </tr>
            </table>
             <div><h2>ผู้รับผลประโยชน์ 2</h2></div>
        	<table id="table-form">
                <tr>
				  <td>คำนำหน้า : </td>
                   <td>
										 <select name="BENEFICIARY_TITLE2" >
										 	<option value="<?php echo $row["BENEFICIARY_TITLE2"];?>"><?php echo $row["BENEFICIARY_TITLE2"];?></option>
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
                  <td><input type="text" name="BENEFICIARY_NAME2" maxlength="60" size="35" value="<?php echo $row["BENEFICIARY_NAME2"];?>" /></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME2" maxlength="60" size="35" value="<?php echo $row["BENEFICIARY_LASTNAME2"];?>" /></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP2" >
                     <option value="<?php echo $row["BENEFICIARY_RELATIONSHIP2"];?>"><?php echo $row["BENEFICIARY_RELATIONSHIP2"];?></option>
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
                  <td><input type="text" name="BENEFICIARY_AGE2" maxlength="8" size="8" value="<?php  echo $row["BENEFICIARY_AGE2"];?>" /></td>
                </tr>
                <tr>
				  <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT2" maxlength="3"  size="8" value="<?php echo $row["BENEFICIARY_BENEFIT2"];?>" /></td>
                </tr>
            </table>
            <div><h2>ผู้รับผลประโยชน์ 3</h2></div>
        	<table id="table-form">
            	<tr>
				  <td>คำนำหน้า : </td>
                   <td>
										 <select name="BENEFICIARY_TITLE3" >
										 	<option value="<?php echo $row["BENEFICIARY_TITLE3"];?>"><?php echo $row["BENEFICIARY_TITLE3"];?></option>
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
	                  <td><input type="text" name="BENEFICIARY_NAME3" maxlength="60" size="35" value="<?php echo $row["BENEFICIARY_NAME3"];?>" /></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME3" maxlength="60" size="35" value="<?php echo $row["BENEFICIARY_LASTNAME3"];?>" /></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP3" >
                     <option value="<?php echo $row["BENEFICIARY_RELATIONSHIP3"];?>"><?php echo $row["BENEFICIARY_RELATIONSHIP3"];?></option>
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
                  <td><input type="text" name="BENEFICIARY_AGE3" maxlength="8" size="8" value="<?php  echo $row["BENEFICIARY_AGE3"];?>" /></td>
                </tr>
                
                <tr>
				  <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT3" maxlength="3"  size="8" value="<?php echo $row["BENEFICIARY_BENEFIT3"];?>" /></td>
                </tr>
            </table>
            <div><h2>ผู้รับผลประโยชน์ 4</h2></div>
        	<table id="table-form">
            	<tr>
				  <td>คำนำหน้า : </td>
                   <td>
										 <select name="BENEFICIARY_TITLE4" >
										 	<option value="<?php echo $row["BENEFICIARY_TITLE4"];?>"><?php echo $row["BENEFICIARY_TITLE4"];?></option>
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
	                  <td><input type="text" name="BENEFICIARY_NAME4" maxlength="60" size="35" value="<?php echo $row["BENEFICIARY_NAME4"];?>" /></td>
                  <th>&nbsp;</th>
                  <td>นามสกุล  : </td>
                  <td><input type="text" name="BENEFICIARY_LASTNAME4" maxlength="60" size="35" value="<?php echo $row["BENEFICIARY_LASTNAME4"];?>" /></td>
                </tr>
                <tr>
                   <td>ความสัมพันธ์ : </td>
                 <td><select name="BENEFICIARY_RELATIONSHIP4" >
                     <option value="<?php echo $row["BENEFICIARY_RELATIONSHIP4"];?>"><?php echo $row["BENEFICIARY_RELATIONSHIP4"];?></option>
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
                  <td><input type="text" name="BENEFICIARY_AGE4" maxlength="8" size="8" value="<?php  echo $row["BENEFICIARY_AGE4"];?>" /></td>
                </tr>
                <tr>
				  <td>ร้อยละของผลประโยชน์ : </td>
                   <td><input type="text" name="BENEFICIARY_BENEFIT4" maxlength="3"  size="8" value="<?php echo $row["BENEFICIARY_BENEFIT4"];?>" /></td>
                </tr>
            </table>


            </fieldset>
 		</div>
        <!--end  form 3-->
        <br/>
        <div>
        <fieldset id="form-content">
        <legend>คำถามสุขภาพ</legend>

<?php 

 $chk_ans1 = $row["Answer1_1"];
 if( $chk_ans1 == '0'){
	 $chk_Answer1_1 = 'checked';
 }else{
	 $chk_Answer1_2 = 'checked';
 }
 
 $chk_ans2 = $row["Answer2_1"];
 if( $chk_ans2 == '0'){
	 $chk_Answer2_1 = 'checked';
 }else{
	 $chk_Answer2_2 = 'checked';
 }
 
 $chk_ans3 = $row["Answer3_1"];
 if( $chk_ans3 == '0'){
	 $chk_Answer3_1 = 'checked';
 }else{
	 $chk_Answer3_2 = 'checked';
 }
 
 $chk_ans4 = $row["Answer4_1"];
 if( $chk_ans4 == '0'){
	 $chk_Answer4_1 = 'checked';
 }else{
	 $chk_Answer4_2 = 'checked';
 }
 
 $chk_ans5 = $row["Answer5_1"];
 if( $chk_ans5 == '0'){
	 $chk_Answer5_1 = 'checked';
 }else{
	 $chk_Answer5_2 = 'checked';
 }
 
  $chk_ans6 = $row["Answer6_1"];
 if( $chk_ans6 == '0'){
	 $chk_Answer6_1 = 'checked';
 }else{
	 $chk_Answer6_2 = 'checked';
 }
 
 

?>
            <div id="answer">
            	<p>1. ท่านมีหรือได้ขอเอาประกันภัยอุบัติเหตุส่วนบุคคล หรือประกันชีวิตไว้กับบริษัทหรือกับบริษัทอืนหรือไม่? <br /><br /><input type="radio" name="Answer1_1" value="0" <?php echo $chk_Answer1_1;?> required/> ไม่เคย &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer1_1" value="1" <?php echo $chk_Answer1_2;?> /> เคย</p>
           		<p>(ถ้าเคยโปรดระบุรายละเอียด) บริษัท <input type="text" name="Answer1_2"   size="30" value="<?php echo $row["Answer1_2"];?>" /> จำนวนเงินเอาประกันภัย <input type="text" name="Answer1_3"   size="30"  value="<?php echo $row["Answer1_3"];?>" />
            	<br />
                <br />
                <p>2.  ท่านเคยถูกปฏิเสธการขอเอาประกันภัยอุบัติเหตุส่วนบุคคล หรือการขอเอาประกันชีวิต หรือถูกปฏิเสธการต่ออายุสัญญาประกันภัย หรือถูกเรียก เก็บเบี้ยประกันภัยเพิ่มสำหรับการประกันภัยดังกล่าวหรือไม่ ?<br /><br /><input type="radio" name="Answer2_1" value="0" <?php echo $chk_Answer2_1;?> required/> ไม่เคย &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer2_1" value="1" <?php echo $chk_Answer2_2;?> /> เคย</p>
           		<p>(ถ้าเคยโปรดระบุรายละเอียด)  <input type="text" name="Answer2_2"   size="100" value="<?php echo $row["Answer2_2"];?>" />
            	<br /><br />
                <p>3. ท่านเป็น หรือ เคยได้รับการรักษาโรคดังต่อไปนี้หรือไม่ โรคไต โรคหัวใจและหลอดเลือด โรคมะเร็ง โรคตับ โรคเอดส์ โรคความดันโลหิตสูง โรคเบาหวาน โรคเลือด
โรคทางสมองและหลอดเลือดสมอง โรคทาง ระบบประสาท อัมพาต เนื้องอก โรคกระดูกหรือโรคกล้ามเนื้อ หรือโรคอื่นๆ<br /><br /><input type="radio" name="Answer3_1" value="0" <?php echo $chk_Answer3_1;?> required/> ไม่เคย &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer3_1" value="1" <?php echo $chk_Answer3_2;?> /> เคย</p>
           		<p>(ถ้าเคยโปรดระบุรายละเอียด)  <input type="text" name="Answer3_2"   size="100"  value="<?php echo $row["Answer3_2"];?>"/> 
            	<br /><br />
                <p>4. ใน 5 ปี ที่ผ่านมาท่านเคยเข้ารับการปรึกษาแพทย์ ได้รับการตรวจวินิจฉัย อาทิเช่น เอ๊กซเรย์คอมพิวเตอร์ การตรวจด้วยคลื่นแม่เหล็กไฟฟ้ า การส่งตรวจชิ้นเนื้อทางด้าน
พยาธิวิทยา การตรวจอัลตร้าซาวด์ การตรวจคลื่นหัวใจ หรือการตรวจเลือด ปัสสาวะหรือได้รับการสั่งยาจากแพทย์หรือไม่ หากเคย กรุณาให้ละเอียดและสาเหตุของการ
เข้ารับการปรึกษา การได้รับการสั่งยา รวมถึงชื่อยาที่ได้รับ หรือยาที่ปัจจุบันใช้อยู่<br /><br /><input type="radio" name="Answer4_1" value="0" <?php echo $chk_Answer4_1;?> required/> ไม่เคย &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer4_1" value="1" <?php echo $chk_Answer4_2;?> /> เคย</p>
           		<p>(ถ้าเคยโปรดระบุรายละเอียด)  <input type="text" name="Answer4_2"   size="100" value="<?php echo $row["Answer4_2"];?>" /> 
            	<br /><br />
                <p>5. ปัจจุบันท่านกำลังเจ็บป่วยหรือมีอาการผิดปกติ (อาทิเช่น อาการปวดที่ผิดปกติ, ก้อนเนื้อ ติ่งเนื้อ ที่เจริญผิดปกติ, ภาวะการมองเห็นพร่ามัวผิดปกติ, ภาวะเลือดออกผิดปกติ,
มีอาการกล้ามเนื่ออ่อนแรง เป็นลมบ่อยๆและ อื่น ๆ) ที่ยังมิได้เข้ารับการรักษาหรือปรึกษาจากแพทย์หรือไม่ หากมี กรุณาระบุผลการตรวจหรือสาเหตุที่ต้องเข้ารับการ
ตรวจ วันเดือนปี และสถานที่ที่ตรวจ<br /><br /><input type="radio" name="Answer5_1" value="0" <?php echo $chk_Answer5_1;?> required/> ไม่เคย &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer5_1" value="1" <?php echo $chk_Answer5_2;?>/> เคย</p>
           		<p>(ถ้าเคยโปรดระบุรายละเอียด)  <input type="text" name="Answer5_2"   size="100" value="<?php echo $row["Answer5_2"];?>" /> 
            	<br /><br />

                <p>ผู้ประกันภับประสงค์จะใช้สิทธิ์ขอยกเว้นภาษีเงินได้ตามกฎหมายว่าด้วยภาษีอากร หรือไม่ ?<br /><br /><input type="radio" name="Answer6_1" value="0" <?php echo $chk_Answer6_1;?> required/> ไม่มีความประสงค์ &nbsp;&nbsp;&nbsp;<input type="radio" name="Answer6_1" value="1" <?php echo $chk_Answer6_2;?>/> มีความประสงค์</p>
           		<p>(ถ้ามี)  โปรดแจ้งเลขประจำตัวผู้เสียภาษี <input type="text" name="Answer6_2"   size="100" value="<?php echo $row["Answer6_2"];?>" /> 
            	<br />
                
                
                <p>ในโอกาสหน้าหากทางเจนเนอราลี่ มีผลิตภัณฑ์ หรือ Promotion ใหม่ๆ รบกวนขออนุญาติโทรหาอีกครั้ง สะดวกนะคะ / ครับ<br /><br />
                		<select name="Consent_Flag" onchange="ConsentFlag()"  required>
                     		<option value="<?php echo $row["Consent_Flag"];?>"><?php echo $row["Consent_Flag"];?></option>
                     		<option value="Y">Y</option>
                     		<option value="N">N</option>
                       	</select>
                </p>
                
                
            </div>
            
            </fieldset>
 		</div>
        
		<div>
				<fieldset id="form-content">
					Remark :
					<textarea rows="5" name="remark" cols="100"><?php echo $row["remark"];?></textarea>
				</fieldset>
		</div>

    <div>
      <fieldset id="form-content">
        <h2>ไฟล์เสียง</h2>
				<ul>
          <li><a href="https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/219cab5f-e89b-456c-9a76-7e0bd236e16f" target="_blank">ไฟล์เสียง1</a></li>
          <li><a href="https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/219cab5f-e89b-456c-9a76-7e0bd236e16f" target="_blank">ไฟล์เสียง2</a></li>
          <li><a href="https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/219cab5f-e89b-456c-9a76-7e0bd236e16f" target="_blank">ไฟล์เสียง3</a></li>
          <li><a href="https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/219cab5f-e89b-456c-9a76-7e0bd236e16f" target="_blank">ไฟล์เสียง4</a></li>
          <li><a href="https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/219cab5f-e89b-456c-9a76-7e0bd236e16f" target="_blank">ไฟล์เสียง5</a></li>
          <li><a href="https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/219cab5f-e89b-456c-9a76-7e0bd236e16f" target="_blank">ไฟล์เสียง6</a></li>
          <li><a href="https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/219cab5f-e89b-456c-9a76-7e0bd236e16f" target="_blank">ไฟล์เสียง7</a></li>
        </ul>
      </fieldset>
		</div>

        <!--start  form 7-->
        <div>
        <fieldset id="form-content">
        	<table id="table-form">
               <tr>
				  <td>Application Status &nbsp;</td>
                  <td><select name="AppStatus" >
                    <option value="<?php echo $row["AppStatus"];?>"><?php echo $row["AppStatus"];?></option>
                    <option value="Follow Doc">Follow Doc</option>
					<option value="Submit">Submit</option>
                    <option value="Submit Re-Confirm">Submit Re-Confirm</option>
<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	if($lv > 1){
?>

    <option value="QC_Approved">QC_Approved</option>
    <option value="QC Re-Confirm">QC Re-Confirm</option>
	<option value="Success">Success</option>
	<option value="QC_Reject">QC_Reject</option>
    
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
                                    
                                    <input type="hidden" name="ProposalNumber" value="<?php echo $Id ; ?>" />
                                    <input type="hidden" name="camp" value="GenHealth" />
<?php
 	session_start();
	$lv = $_SESSION["pfile"]["lv"];
	if($lv > 1){
?>
                  <td>วันที่คุ้มครอง</td>
                  <td><input id="datepicker3" type="text" name="Approved_Date"  size="10"  value="<?php echo $row["Approved_Date"];?>"/></td>
                  
                  <td>Approved Code</td>
                  <td><input  type="text" name="Approved_code" size="10" value="<?php echo $row["Approved_code"];?>" /></td>
 <?php } ?>
                  <th>&nbsp;</th>
                  <td><input name="Submit" type="submit" value=" Save " /></td>
                  <td>&nbsp;&nbsp;<a  href="appRegal.php?Id=<?php echo $Id;?>" target="_blank"/>บทยืนยัน</a></td>
               </tr>
            </table>
          </fieldset>
  </div>
  </form>
  <?php } mysql_free_result($result); ?>
        <!--end  form 7-->
<br />
</div>
</body>
</html>
