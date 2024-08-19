<?php

ob_start();
session_start();

require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../../class/Encrypt.php");
//include("../../function/checkSession.php");


$agent_id = $_SESSION["pfile"]["uid"];
$lv = $_SESSION["pfile"]["lv"];


?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="css/stylesheet.css" type="text/css" />

  <link href="../../css/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />

  <script>
		var uid = <?php echo $_SESSION["uid"]; ?>;
	</script>
  <script src="../../scripts/jquery-2.2.4.min.js"></script>
  <script src="../../scripts/jquery-ui.min.js"></script>
  <script src="../../scripts/jquery-ui-datepicker-th.js"></script>
  <script src="../../scripts/moment.min.js"></script>
  <script src="../../scripts/jquery.validate.min.js"></script>
  <title>Application Form</title>
  <script type="text/javascript" src="../scripts/function.js?v=<?=time();?>"></script>
  <script type="text/javascript" src="../scripts/jsvalidate.js?v=<?=time();?>"></script>
  <SCRIPT type="text/javascript" src="js/app.js?v=<?=time();?>"></script>

</head>

<body>

  <?php

  $id = $_GET["id"];

  $submitFlag = ($lv == 7)?"disabled":"";


  $SQL = "select  a.*,b.first_name,b.last_name,c.plancode from t_aig_app a left outer join t_agents b ON a.agent_id=b.agent_id left outer join t_campaign c ON a.campaign_id=c.campaign_id where a.id = '$id'";
  $result = mysqli_query($Conn, $SQL) or die("ไม่สามารถเรียกดูข้อมูลได้");
  while ($row = mysqli_fetch_array($result)) {

    $DOB = "";
    $DOB_val = "";
    $xxx_DOB = "";
    $IN2_DOB = "";
    $IN2_DOB_val = "";
    $IN2_xxx_DOB = "";
    $IDCARD = "";
    $xxx_IDCARD = "";
    $MOBILE1 = "";
    $xxx_MOBILE1 = "";
    $Approved_Date = "";
    $Approved_Date_val = "";


    if ($row["DOB"] != "") {
      $DOB = Encryption::decrypt($row["DOB"]);
      if(!in_array($lv,[3,7])){
        $DOB_val = "XX/XX/" . substr($DOB, -4);
        $xxx_DOB = "XX/XX/" . (intval(substr($DOB, -4)) + 543);
      } else {
        $DOB_val = $DOB;
        $xxx_DOB = substr($DOB, 0,6) . (intval(substr($DOB, -4)) + 543);
      }
    }

    if ($row["INSURED_DOB2"] != "") {
      $IN2_DOB = $row["INSURED_DOB2"];
      if(!in_array($lv,[3,7])){
        $IN2_DOB_val = "XX/XX/" . substr($IN2_DOB, -4);
        $IN2_xxx_DOB = "XX/XX/" . (intval(substr($IN2_DOB, -4)) + 543);
      } else {
        $IN2_DOB_val = $IN2_DOB;
        $IN2_xxx_DOB = substr($IN2_DOB, 0,6) . (intval(substr($IN2_DOB, -4)) + 543);
      }
      
    }

    if ($row["IDCARD"] != "") {
      $IDCARD = Encryption::decrypt($row["IDCARD"]);
      if(!in_array($lv,[3,7])){
        $xxx_IDCARD = "000000000" . substr($IDCARD, -4);
      } else {
        $xxx_IDCARD = $IDCARD;
      }
    }

    if ($row["TELEPHONE1"] != "") {
      $TELEPHONE1 = Encryption::decrypt($row["TELEPHONE1"]);
      $xxx_TELEPHONE1 = "XXXXXXXXX" . substr($TELEPHONE1, -4);
    }

    if ($row["MOBILE1"] != "") {
      $MOBILE1 = Encryption::decrypt($row["MOBILE1"]);
      $xxx_MOBILE1 = "XXXXXX" . substr($MOBILE1, -4);
      
    }

    if ($row["Approved_Date"] != "") {
      $Approved_Date = $row["Approved_Date"]; // 20230810
      $Approved_Date_val = (substr($Approved_Date, 6, 2) . '/' . substr($Approved_Date, 4, 2) . '/' . substr($Approved_Date, 0, 4)); // 20230810
      $Approved_Date = (substr($Approved_Date, 6, 2) . '/' . substr($Approved_Date, 4, 2) . '/' . (intval(substr($Approved_Date, 0, 4)) + 543));
    }

    $tsr_name = $row["first_name"] . " " . $row["last_name"];

    $seqno = $row["plancode"].$row["ProposalNumber"];

    ?>


    <div id="content">
      <div id="header">
        <!--<div id="logo"></div>-->
      </div>
      <div id="top-detail">
        <div id="app-detail">
          <table>
            <tr>
              <td>
                <h1>Product Name : </h1>
              </td>
              <td>Double Care</td>
            </tr>
          </table>
        </div>
        <div id="user-detail">
          <table align="right">
            <tr>
              <td>
                <h1>Date : </h1>
              </td>
              <td>
                <?php echo "$currentdate_app" ?>
              </td>
              <td>&nbsp;</td>
              <td>
                <h1>License : </h1>
              </td>
              <td>
                <?php print $license_code; ?>
              </td>
              <td>&nbsp;</td>
              <td>
                <h1>TSR : </h1>
              </td>
              <td>
                <?php echo $tsr_name; ?>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <form id="application">
        <input type="hidden" name="OLD_DOB" value="<?php echo Encryption::decrypt($row["DOB"]); ?>">
        <input type="hidden" name="OLD_IDCARD" value="<?php echo $IDCARD; ?>">
        <input type="hidden" name="OLD_MOBILE1" value="<?php echo $MOBILE1; ?>">
        <input type="hidden" name="OLD_TELEPHONE1" value="<?php echo $TELEPHONE1; ?>">
        <input type="hidden" name="OLD_IN2_DOB" value="<?php echo $row["INSURED_DOB2"]; ?>">
        <input type="hidden" name="campaign_id" value="<?php echo $row["campaign_id"]; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="calllist_id" value="<?php echo $row['calllist_id']; ?>">

        <!--start  form 1 -->
        <div>
          <fieldset id="form-content">
            <table id="table-form">
              <tr>
                <td>เลขที่ใบสมัคร : </td>
                <td><input type="text" name="ProposalNumber" maxlength="15"
                    value="<?php echo $seqno; ?>" /></td>
                <td colspan="30">&nbsp;</td>
                <td>วันที่บันทึก : </td>
                <td><input type="text" name="create_date" maxlength="19" value="<?php echo $row["create_date"]; ?>" />
                </td>
              </tr>
            </table>
          </fieldset>
        </div>
        <!--end  form 1 -->

        <!--start  form 2-->
        <div>
          <fieldset id="form-content">
            <br />
            <h1>คำถามเกี่ยวกับข้อมูลส่วนบุคคลของผู้ขอเอาประกันภัย และรายละเอียดการขอเอาประกันภัย</h1><br />
            <legend>ผู้เอาประกัน</legend>

            <table id="table-form">
              <tr>
                <td>คำนำหน้าผู้เอาประกัน : <span style="color:red">*</span></td>
                <td>
                  <select name="TITLE">
                    <option value="<?php echo $row["TITLE"]; ?>">
                      <?php echo $row["TITLE"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>ชื่อผู้เอาประกัน (ไทย) : <span style="color:red">*</span></td>
                <td><input type="text" name="FIRSTNAME"
                    value="<?php echo $row["FIRSTNAME"]; ?>" />
                </td>
                <th>&nbsp;</th>
                <td>นามสกุล (ไทย) : <span style="color:red">*</span></td>
                <td><input type="text" name="LASTNAME" value="<?php echo Encryption::decrypt($row["LASTNAME"]); ?>">
                </td>
              </tr>
              <tr>
                <td>เพศ : <span style="color:red">*</span></td>
                <td><select name="SEX">
                    <option value="<?php echo $row["SEX"]; ?>">
                      <?php echo $row["SEX"]; ?>
                    </option>
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                  </select></td>
                <th>&nbsp;</th>
              </tr>
              <tr>
                <td>วัน/เดือน/ปี เกิด : <span style="color:red">*</span></td>
                <td>
                  <input type="hidden" name="DOB" value="<?php echo $DOB_val; ?>" />
                  <input id="datepicker" type="text" name="DOB_V" value="<?php echo $xxx_DOB; ?>" />
                </td>
                <th>&nbsp;</th>
                <td>อายุ : <span style="color:red">*</span></td>
                <td><input id="age" type="text" name="ADE_AT_RCD" size="8"
                    value="<?php echo $row["ADE_AT_RCD"]; ?>" readonly /> &nbsp;ปี</td>


              </tr>
              <tr>
                <td>เลขที่บัตรประชาชน : <span style="color:red">*</span></td>
                <td><input type="text" name="IDCARD" size="20" value="<?php echo $xxx_IDCARD; ?>"/></td>
                <th>&nbsp;</th>
                <td>อาชีพ : </td>
                <td>
                  <select name="OCCUPATIONAL">
                    <option value="<?php echo $row["OCCUPATIONAL"]; ?>">
                      <?php echo $row["OCCUPATIONAL"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'occupation' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Email : </td>
                <td><input type="text" name="EMAIL" maxlength="50" size="30" value="<?php echo $row["EMAIL"]; ?>" /></td>
                <th>&nbsp;</th>
                <td></td>
                <td>
                </td>
              </tr>


              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><b>ที่อยู่ปัจจุบัน</b></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>เลขที่ : <span style="color:red">*</span></td>
                <td><input type="text" name="ADDRESSNO1" size="30"
                    value="<?php echo $row["ADDRESSNO1"]; ?>" /></td>
                <th>&nbsp;</th>
                <td>หมู่บ้าน/อาคาร : </td>
                <td><input type="text" name="BUILDING1" value="<?php echo $row["BUILDING1"]; ?>"
                    size="30" /></td>
              </tr>
              <tr>
                <td>หมู่ : </td>
                <td><input type="text" name="MOO1" value="<?php echo $row["MOO1"]; ?>" size="10" /></td>
                <th>&nbsp;</th>
                <td>ตรอก/ซอย : </td>
                <td><input type="text" name="SOI1" value="<?php echo $row["SOI1"]; ?>" size="30" /></td>
              </tr>
              <tr>
                <td>ถนน : </td>
                <td><input type="text" name="ROAD1" value="<?php echo $row["ROAD1"]; ?>" size="30" /></td>
                <th>&nbsp;</th>
                <td>แขวง/ตำบล : <span style="color:red">*</span></td>
                <td><select name="SUB_DISTRICT1" id="Sub_district1"
                    onchange="show_ZIPCODE(this.value,document.getElementById('district1').value,document.getElementById('province1').value)">
                    <option value="<?php echo $row["SUB_DISTRICT1"]; ?>">
                      <?php echo $row["SUB_DISTRICT1"]; ?>
                    </option>
                  </select></td>
              </tr>
              <tr>
                <td>เขต/อำเภอ : <span style="color:red">*</span></td>
                <td><select name="DISTRICT1" id="district1"
                    onchange="show_SUBDISTRICT(this.value,document.getElementById('province1').value)">
                    <option value="<?php echo $row["DISTRICT1"]; ?>">
                      <?php echo $row["DISTRICT1"]; ?>
                    </option>
                  </select></td>
                <th>&nbsp;</th>
                <td>จังหวัด : <span style="color:red">*</span></td>
                <td>
                  <select name="PROVINCE1" id="province1" onchange="show_DISTRICT(this.value)">
                    <option value="<?php echo $row["PROVINCE1"]; ?>">
                      <?php echo $row["PROVINCE1"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_address GROUP BY PROVINCE_TH ORDER BY PROVINCE_TH ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["PROVINCE_TH"]; ?>">
                        <?php echo $objResuut["PROVINCE_TH"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>รหัสไปรษณีย์ : <span style="color:red">*</span></td>
                <td><select name="ZIPCODE1" id="zipcode1">
                    <option value="<?php echo $row["ZIPCODE1"]; ?>">
                      <?php echo $row["ZIPCODE1"]; ?>
                    </option>
                  </select></td>
                <th>&nbsp;</th>
                <td>โทรศัพท์บ้าน : </td>
                <td><input type="text" name="TELEPHONE1" size="15" value="<?php echo $xxx_TELEPHONE1; ?>" />
                </td>
              </tr>
              <tr>
                <td>โทรศัพท์มือถือ : <span style="color:red">*</span></td>
                <td><input type="text" name="MOBILE1" value="<?php echo $xxx_MOBILE1; ?>" size="15" /></td>
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
                <td>แบบประกันภัย : <span style="color:red">*</span></td>
                <td>
                  <select name="PRODUCT_NAME" >
                    <option value="<?php echo $row["PRODUCT_NAME"]; ?>">
                      <?php echo $row["PRODUCT_NAME"]; ?>
                    </option>
                    <option>แผนรายเดี่ยว</option>
                    <option>แผนคู่สมรส</option>
                    <option>แผนครอบครัว</option>
                    <option>แผนบุพการี</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>แผนประกันภัย : <span style="color:red">*</span></td>
                <td><select name="COVERAGE_NAME" >
                    <option value="<?php echo $row["COVERAGE_NAME"]; ?>">
                      <?php echo $row["COVERAGE_NAME"]; ?>
                    </option>
                    <option>Plan 1</option>
                    <option>Plan 2</option>
                    <option>Plan 3</option>
                  </select></td>
              </tr>
              <td>การชำระเงิน : <span style="color:red">*</span></td>
              <td><select name="PAYMENTFREQUENCY">
                  <option value="<?php echo $row["PAYMENTFREQUENCY"]; ?>">
                    <?php echo $row["PAYMENTFREQUENCY"]; ?>
                  </option>
                  <option value="รายเดือน">รายเดือน</option>
                  <option value="รายปี">รายปี</option>
                </select></td>
              </tr>
              <tr>
                <td>เบี้ยประกันภัยรวม : <span style="color:red">*</span></td>
                <td><input type="text" name="INSTALMENT_PREMIUM" maxlength="15"
                    value="<?php echo $row["INSTALMENT_PREMIUM"]; ?>" readonly /> บาท&nbsp;
                  ยอดที่ใช้ตัด Payment : <input type="text" name="INSTALMENT_COPY" maxlength="15" value=""
                  readonly /> บาท
                </td>
              </tr>
            </table><br />

            <span style="color:red">* ในกรณี ที่เป็นแบบประกัน คู่สมรส, ครอบครัว, บุพการี จะต้องมีการกรอก
              ผู้เอาประกันเพิ่มเติม</label></span>
            <!--Insure 2-->
            <div>
              <h2>ผู้เอาประกันที่ 2 (คู่สมรส)</h2>
            </div>
            <table id="table-form">
              <tr>
                <td>คำนำหน้า : </td>
                <td>
                  <select name="INSURED_TITLE2">
                    <option value="<?php echo $row["INSURED_TITLE2"]; ?>">
                      <?php echo $row["INSURED_TITLE2"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>ชื่อ : </td>
                <td><input type="text" name="INSURED_NAME2" maxlength="60" size="35"
                    value="<?php echo $row["INSURED_NAME2"]; ?>" /></td>
                <th>&nbsp;</th>
                <td>นามสกุล : </td>
                <td><input type="text" name="INSURED_LASTNAME2" maxlength="60" size="35"
                    value="<?php echo $row["INSURED_LASTNAME2"]; ?>" /></td>
              </tr>
              <tr>
                <td>วัน/เดือน/ปี เกิด : </td>
                <td>
                  <input type="hidden" name="INSURED_DOB2" maxlength="10" value="<?php echo $IN2_DOB_val; ?>" />
                  <input id="datepicker2" type="text" name="INSURED_DOB2_V" maxlength="10"
                    value="<?php echo $IN2_xxx_DOB; ?>" />
                </td>
                <th>&nbsp;</th>
                <td>ความสัมพันธ์ : </td>
                <td><select name="INSURED_RELATIONSHIP2">
                    <option value="<?php echo $row["INSURED_RELATIONSHIP2"]; ?>">
                      <?php echo $row["INSURED_RELATIONSHIP2"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
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

            <?php
            $CHK_GIVEN_BENAFICIARY = $row["GIVEN_BENAFICIARY"];
            if ($CHK_GIVEN_BENAFICIARY == '1') {
              $GIVEN_BENAFICIARY_GIVEN_BENAFICIARY = 'checked';
            }
            ?>
            <div style="padding: 10px 50px 10px 50px ;  "><input type="checkbox" id="GIVEN_BENAFICIARY"
                name="GIVEN_BENAFICIARY" value="1" <?php echo $GIVEN_BENAFICIARY_GIVEN_BENAFICIARY; ?>>
              <label for="vehicle1"> ระบุเป็น ทายาทโดยธรรม &nbsp;&nbsp;<span style="color:red">* ถ้าระบุ
                  ไม่ต้องทำการกรอกข้อมูลผู้รับผลประโยชน์</label></span><br>
            </div>
            <div>
              <h2>ผู้รับผลประโยชน์ 1</h2>
            </div>
            <table id="table-form">
              <tr>
                <td>คำนำหน้า : </td>
                <td>
                  <select name="BENEFICIARY_TITLE1">
                    <option value="<?php echo $row["BENEFICIARY_TITLE1"]; ?>">
                      <?php echo $row["BENEFICIARY_TITLE1"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>ชื่อ : </td>
                <td><input type="text" name="BENEFICIARY_NAME1" maxlength="60" size="35"
                    value="<?php echo $row["BENEFICIARY_NAME1"]; ?>" /></td>
                <th>&nbsp;</th>
                <td>นามสกุล : </td>
                <td><input type="text" name="BENEFICIARY_LASTNAME1" maxlength="60" size="35"
                    value="<?php echo $row["BENEFICIARY_LASTNAME1"]; ?>" /></td>
              </tr>
              <tr>
                <td>ความสัมพันธ์ : </td>
                <td><select name="BENEFICIARY_RELATIONSHIP1">
                    <option value="<?php echo $row["BENEFICIARY_RELATIONSHIP1"]; ?>">
                      <?php echo $row["BENEFICIARY_RELATIONSHIP1"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select></td>
                <th>&nbsp;</th>
                <td>ร้อยละของผลประโยชน์ : </td>
                <td><input type="text" name="BENEFICIARY_BENEFIT1" maxlength="3" size="8"
                    value="<?php echo $row["BENEFICIARY_BENEFIT1"]; ?>" /></td>
              </tr>
              <tr>
                <td>เพศ : </td>
                <td><select name="BENEFICIARY_SEX1">
                    <option value="<?php echo $row["BENEFICIARY_SEX1"]; ?>">
                      <?php echo $row["BENEFICIARY_SEX1"]; ?>
                    </option>
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                  </select></td>
                <th>&nbsp;</th>
              </tr>
            </table>
            <div>
              <h2>ผู้รับผลประโยชน์ 2</h2>
            </div>
            <table id="table-form">
              <tr>
                <td>คำนำหน้า : </td>
                <td>
                  <select name="BENEFICIARY_TITLE2">
                    <option value="<?php echo $row["BENEFICIARY_TITLE2"]; ?>">
                      <?php echo $row["BENEFICIARY_TITLE2"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <td>ชื่อ : </td>
              <td><input type="text" name="BENEFICIARY_NAME2" maxlength="60" size="35"
                  value="<?php echo $row["BENEFICIARY_NAME2"]; ?>" /></td>
              <th>&nbsp;</th>
              <td>นามสกุล : </td>
              <td><input type="text" name="BENEFICIARY_LASTNAME2" maxlength="60" size="35"
                  value="<?php echo $row["BENEFICIARY_LASTNAME2"]; ?>" /></td>
              </tr>
              <tr>
                <td>ความสัมพันธ์ : </td>
                <td><select name="BENEFICIARY_RELATIONSHIP2">
                    <option value="<?php echo $row["BENEFICIARY_RELATIONSHIP2"]; ?>">
                      <?php echo $row["BENEFICIARY_RELATIONSHIP2"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select></td>
                <th>&nbsp;</th>
                <td>ร้อยละของผลประโยชน์ : </td>
                <td><input type="text" name="BENEFICIARY_BENEFIT2" maxlength="3" size="8"
                    value="<?php echo $row["BENEFICIARY_BENEFIT2"]; ?>" /></td>
              </tr>
              <tr>
                <td>เพศ : </td>
                <td><select name="BENEFICIARY_SEX2">
                    <option value="<?php echo $row["BENEFICIARY_SEX2"]; ?>">
                      <?php echo $row["BENEFICIARY_SEX2"]; ?>
                    </option>
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                  </select></td>
                <th>&nbsp;</th>
              </tr>

            </table>
            <div>
              <h2>ผู้รับผลประโยชน์ 3</h2>
            </div>
            <table id="table-form">
              <tr>
                <td>คำนำหน้า : </td>
                <td>
                  <select name="BENEFICIARY_TITLE3">
                    <option value="<?php echo $row["BENEFICIARY_TITLE3"]; ?>">
                      <?php echo $row["BENEFICIARY_TITLE3"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'titlename' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>ชื่อ : </td>
                <td><input type="text" name="BENEFICIARY_NAME3" maxlength="60" size="35"
                    value="<?php echo $row["BENEFICIARY_NAME3"]; ?>" /></td>
                <th>&nbsp;</th>
                <td>นามสกุล : </td>
                <td><input type="text" name="BENEFICIARY_LASTNAME3" maxlength="60" size="35"
                    value="<?php echo $row["BENEFICIARY_LASTNAME3"]; ?>" /></td>
              </tr>
              <tr>
                <td>ความสัมพันธ์ : </td>
                <td><select name="BENEFICIARY_RELATIONSHIP3">
                    <option value="<?php echo $row["BENEFICIARY_RELATIONSHIP3"]; ?>">
                      <?php echo $row["BENEFICIARY_RELATIONSHIP3"]; ?>
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_pancode where type = 'relationship' ORDER BY id ASC";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      ?>
                      <option value="<?php echo $objResuut["name"]; ?>">
                        <?php echo $objResuut["name"]; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select></td>
                <th>&nbsp;</th>
                <td>ร้อยละของผลประโยชน์ : </td>
                <td><input type="text" name="BENEFICIARY_BENEFIT3" maxlength="3" size="8"
                    value="<?php echo $row["BENEFICIARY_BENEFIT3"]; ?>" /></td>
              </tr>
              <tr>
                <td>เพศ : </td>
                <td><select name="BENEFICIARY_SEX3">
                    <option value="<?php echo $row["BENEFICIARY_SEX3"]; ?>">
                      <?php echo $row["BENEFICIARY_SEX3"]; ?>
                    </option>
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
              <?php
              $CHK_APP_CONSENT = $row["APP_CONSENT"];
              if ($CHK_APP_CONSENT == 'Y') {
                $APP_CONSENT = 'checked';
              }
              ?>
              <div style="padding: 10px 50px 10px 50px ;  "><input type="checkbox" id="APP_CONSENT" name="APP_CONSENT"
                  value="Y" <?php echo $APP_CONSENT; ?>>
                <label for="vehicle1"> ไม่ยินยอมให้เปิดเผยข้อมูล &nbsp;&nbsp;<span style="color:red">*
                    กรณีลูกค้าไม่ให้ความยินยอมส่งข้อมูลสรรพากร ลดหย่อนภาษี</label></span><br>
              </div>

            </div>

          </fieldset>
        </div>
        <br />
        <?php
        if ($lv != 3) {
          ?>
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
                    <div class="table-data"><button type="button" class="button"
                        onclick="window.open('https://dpsvcuat-pcidigital.aig.net:15575/PCI_TH/tokenize.html')">Payment</button>
                    </div>
                  </div>
                  <div class="table-row">
                    <div class="table-data">Online Payment Gateway </div>
                    <div class="table-data"><button type="button" class="button"
                        onclick="window.open('https://dpsvcuat-pcidigital.aig.net:15595/PCI_TH_CC/payment-gateway-login.html')">Payment</button>
                    </div>
                  </div>
                </div>
              </div>

            </fieldset>
          </div>
          <br />
          <?php
        }
        ?>
        <div>
          <fieldset id="form-content">
            <legend>Additional</legend>
            <table id="table-form">
              <tr>
                <td>ชื่อหน้าบัตร : <span style="color:red">*</span></td>
                <td><input type="text" name="ACCOUNT_NAME" maxlength="50" size="30"
                    value="<?php echo $row["ACCOUNT_NAME"]; ?>" />
                </td>
                <td>
                  <button type="button" class="button" id="secure_pause">Pause</button>
                  <button type="button" class="button" id="unsecure_pause"
                    style="padding-left=5px;margin-left:10px;">Resume</button>

                </td>
              </tr>
              <tr>
                <?php
                $FIRST_PAYMENT = $row["FIRST_PAYMENT"];
                if ($FIRST_PAYMENT == '1') {
                  $FIRST_PAYMENT = 'checked';
                }
                ?>
                <td>จ่ายงวดแรก : </td>
                <td><input type="checkbox" id="FIRST_PAYMENT" name="FIRST_PAYMENT" value="1" <?php echo $FIRST_PAYMENT; ?>>
                </td>
              </tr>
              <tr>
                <td>วันหมดอายุบัตร : </td>
                <td><input type="text" name="ACCOUNT_EXPIRE" maxlength="5" size="5"
                    value="<?php echo $row["ACCOUNT_EXPIRE"]; ?>">
                </td>
              </tr>
              <tr>
                <td>Payment Key : <span style="color:red">*</span></td>
                <td><input type="text" name="payment_key" size="50" maxlength="100"
                    value="<?php echo $row["payment_key"]; ?>" /></td>
              </tr>
            </table>
          </fieldset>
        </div>
        <br />
        <div>
          <fieldset id="form-content">
            <legend>Voice File</legend>
            <div class="table">
              <div class="table-header">
                <div class="header__item">Call No.</div>
                <div class="header__item">Cal Date</div>
                <div class="header__item">Action</div>
              </div>
              <div class="table-content">
                <?php
                $voice_sql = "select voice_id,create_date from t_call_trans where calllist_id = '" . $row['calllist_id'] . "'";
                $vocie_result = mysqli_query($Conn, $voice_sql) or die("ไม่สามารถเรียกดูข้อมูลได้");
                $v_index = 1;
                while ($voice_row = mysqli_fetch_array($vocie_result)) {
                  $created_date = new DateTime($voice_row['create_date'], new DateTimeZone('Asia/Bangkok'));
                  ?>
                  <div class="table-row">
                    <div class="table-data">
                      <?php echo $v_index; ?>
                    </div>
                    <div class="table-data">
                      <?php echo date_format($created_date, "Y-m-d H:i:s"); ?>
                    </div>
                    <div class="table-data"><button type="button"
                        onclick="window.open('https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/<?php echo $voice_row['voice_id']; ?>', '_blank');"
                        class="button">Play</button></div>
                  </div>
                  <?php
                  $v_index++;
                }
                ?>
              </div>
            </div>
          </fieldset>
        </div>
        <br />
        <div>
          <fieldset id="form-content">
            Note TSR :
            <textarea rows="5" name="REMARK" cols="100"><?php echo $row["REMARK"]; ?></textarea>
          </fieldset>
        </div>

        <br />
        <!--start  form 7-->
        <div>
          <fieldset id="form-content">
            <table id="table-form">
              <tr>
                <td>Application Status &nbsp;</td>
                <td><select name="AppStatus">
                    <option value="<?php echo $row["AppStatus"]; ?>">
                      <?php echo $row["AppStatus"]; ?>
                    </option>
                    <?php
                      $statusSQL = "select * from t_app_status where level='".$lv."' and isActive=1";
                      $status = mysqli_query($Conn, $statusSQL) or die("ไม่สามารถเรียกดูข้อมูลได้");
                      while ($st = mysqli_fetch_array($status)) {
                          echo "<option value=\"".$st["status"]."\">".$st["status"]."</option>";
                      }
                      ?>
                  </select></td>
                <th>&nbsp;</th>

                <?php
                if ($lv > 1) {
                  ?>
                  <td>วันที่ Approved </td>
                  <td>
                    <input type="hidden" name="Approved_Date" size="10" value="<?php echo $Approved_Date_val; ?>" />
                    <input id="datepicker6" type="text" name="Approved_Date_V" size="10"
                      value="<?php echo $Approved_Date; ?>" />
                  </td>
                <?php } ?>
                <th>&nbsp;</th>
                <td><button type="button" class="button" id="submit" <?php echo $submitFlag; ?>>Submit</button></td>
              </tr>
            </table>
          </fieldset>

        </div>
      </form>
    <?php }
  mysqli_free_result($result); ?>
    <!--end  form 7-->
    <br />
  </div>
  <div class="modal"></div>
</body>

</html>