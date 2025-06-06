<?php
ob_start();
session_start();
require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require("../scripts/app_singaporeAH.php");
require("../scripts/app_singaporeAPI.php");
require("./getToken.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
  #ncd-info-container,
  #remark-c-input,
  #insured-list-home,
  #isPolicyHolderDrivingRow,
  #insured-list-auto {
    display: none;
  }

  h2 {
    border-bottom: none !important;
  }

  #table-form {
    border-spacing: 0.5em 0.5em;
  }

  #table-form select {
    max-width: 216px !important;
  }


  #table-form td {
    white-space: nowrap;
  }

  table[id^="table-form-"] {
    border-spacing: 0.5em 0.5em;
  }

  table[id^="table-form-"] select {
    max-width: 216px !important;
  }

  table[id^="table-form-"] td {
    white-space: nowrap;
  }

  #header-select-type {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 10px;
  }

  #header-select-type p {
    text-align: center;
    width: 50px;
    padding: 5px 10px;
    border-bottom: 8px solid #D9D9D9;
    cursor: pointer;
  }

  #header-select-type p.selected {
    border-bottom-color: #001871;
    color: #001871;
  }

  #insuredListTable table {
    width: 100%;
    border-collapse: collapse;
  }

  .error-border {
    border: 1px solid red;
  }

  #insured-list-ah hr:last-child {
    display: none;
  }

  .draft-button {
    background-color: #fff !important;
    color: #52525e !important;
    border: 1px solid #52525e !important;

    &:hover {
      background-color: #52525e !important;
      color: #fff !important;
    }
  }
  .reject-button {
    background-color: red !important;
    /* border: 1px solid #52525e !important; */
    &:hover {
      /* background-color:#fff !important; */
      /* color: black !important; */
      opacity: 0.7;
    }
  
  }
 #rejectModal {
    display: none;
    position: fixed;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    padding: 24px;
    z-index: 1000;
    /* font-family: "Segoe UI", sans-serif; */
  }

  #rejectModal h2 {
    margin-top: 0;
    /* font-size: 20px; */
    /* color: #333; */
    margin-bottom: 16px;
  }

  #rejectModal label {
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
    color: #444;
  }

  #rejectModal select,
  #rejectModal input[type="text"] {
    width: 100%;
    padding: 2px;
    margin-top: 5px;
    margin-bottom: 16px;
    border: 1px solid inherit;
    /* border-radius: 6px; */
    /* font-size: 14px; */
  }

  #rejectModal button {
    padding: 10px 16px;
    font-size: 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-right: 8px;
  }

  #rejectModal button:first-of-type {
    background-color: red;
    color: white;
  }

  #rejectModal button:last-of-type {
    background-color: #52525e;
    color: white;
  }

  #rejectModal button:hover {
    opacity: 0.9;
  }
  #coverListBody {
    display: block;
    /* กำหนดให้ tbody แยกออกมา */
    max-height: 200px;
    /* กำหนดความสูงของพื้นที่เลื่อน */
    overflow-y: auto;
    /* เปิดการเลื่อนในแนวตั้ง */
    overflow-x: hidden;
    /* ปิดการเลื่อนในแนวนอน */
  }

  #coverListBody tr {
    display: table;
    /* รักษาโครงสร้างตาราง */
    table-layout: fixed;
    /* คงรูปแบบคอลัมน์ */
  }
</style>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
  <link href="../../css/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />

  <script src="../../scripts/jquery-2.2.4.min.js"></script>
  <script src="../../scripts/jquery-ui.min.js"></script>
  <script src="../../scripts/jquery-ui-datepicker-th.js"></script>
  <script src="../../scripts/moment.min.js"></script>
  <script src="../../scripts/jquery.validate.min.js"></script>

  <title>Application Form</title>
  <!-- <script type="text/javascript" src="../scripts/function.js?v=<?= time(); ?>"></script>
  <script type="text/javascript" src="../scripts/jsvalidate.js?v=<?= time(); ?>"></script>
  <script type="text/javascript" src="../scripts/jsvalidateSingapore.js?v=<?= time(); ?>"></script> -->
  <!-- <SCRIPT type="text/javascript" src="js/app.js?v=<?= time(); ?>"></script>  -->
  <script src="../scripts/app_singaporeApplication.js"></script>
  <!-- <script src="../scripts/app_singaporeAPI.js"></script> -->
  <script src="../scripts/singapore_database.js"></script>
  <script src="../scripts/app_singaporePolicy.js"></script>
  <script src="../scripts/app_singaporeForm.js"></script>
  <script src="../scripts/app_singaporeDraft.js"></script>
  <script src="../scripts/app_singaporePayment.js"></script>
  <script src="../scripts/app_singaporeRenew.js"></script>
  <script src="../scripts/app_singaporeAuto.js"></script>
  <script src="../scripts/app_singaporeLogAPI.js"></script>

  <script>
    var datepickerOptions = {
      yearRange: "c-80:c+20",
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy',
      showAnim: "slideDown"
    };
    $(function() {
      $("#datepicker").datepicker($.extend({}, datepickerOptions, {
        maxDate: new Date(),
        onSelect: function(dateText) {
          const {
            age,
            days
          } = calculateAge(dateText);
          $("#agePolicyHolder").val(age);
          //for autocampaign
          const yesCheckbox = document.getElementById('isPolicyHolderDrivingYes');
          if (yesCheckbox && yesCheckbox.checked) {
            const DOB= document.getElementsByName('dateOfBirth')[0]
            const driverDOB= document.getElementsByName('insured_auto_driverInfo_driverDOB')[0]
            driverDOB.value=DOB.value
            $("#ageDriver").val(age);
          }
        }
      }));

      $("#datepicker2").datepicker($.extend({}, datepickerOptions, {
        maxDate: new Date(),
        onSelect: function(dateText) {
          const {
            age,
            days
          } = calculateAge(dateText);
          if (age <= 23 || age >= 70) {
            alert("The driver's age should be between 23 and 70 years.");
            $(`#datepicker2`).val('');
            return;
          } else {
            $("#ageDriver").val(age);
          }
          //for autocampaign
          const yesCheckbox = document.getElementById('isPolicyHolderDrivingYes');
          if (yesCheckbox && yesCheckbox.checked) {
            const DOB= document.getElementsByName('dateOfBirth')[0]
            const driverDOB= document.getElementsByName('insured_auto_driverInfo_driverDOB')[0]
            DOB.value=driverDOB.value
            $("#agePolicyHolder").val(age);
          }
        }
      }));

      $("#datepicker3").datepicker($.extend({}, datepickerOptions, {
        maxDate: new Date()
      }));


      $("#datepicker4").datepicker(datepickerOptions);

      $("#datepicker5").datepicker($.extend({}, datepickerOptions, {
        minDate: new Date()
      }));
      $("#datepicker6").datepicker($.extend({}, datepickerOptions, {
        minDate: new Date()
      }));

      // $("#datepicker6").datepicker($.extend({}, datepickerOptions, {
      //   minDate: new Date()
      // }));
      $('input[name="payment_expiryDate"]').datepicker($.extend({}, {
        yearRange: "c-1:c+10",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/y'
      }));



    });

    $body = $("body");
    $(document).on({
      ajaxStart: function() {
        $body.addClass("loading");
      },
      ajaxStop: function() {
        $body.removeClass("loading");
      }
    });
  </script>

</head>

<body>
  <div class="modal"></div>
  <?php


  try {
    $campaign_id = isset($_GET['campaign_id']) ? (int)$_GET['campaign_id'] : 0;
    $calllist_id = isset($_GET['calllist_id']) ? (int)$_GET['calllist_id'] : 0;
    $agent_id = isset($_GET['agent_id']) ? (int)$_GET['agent_id'] : 0;
    $import_id = isset($_GET['import_id']) ? (int)$_GET['import_id'] : 0;
    $formType = isset($_GET['formType']) ? $_GET['formType'] : '';

    if ($campaign_id <= 0 || $calllist_id <= 0 || $agent_id <= 0 || $import_id <= 0 || empty($formType)) {
      throw new Exception("Invalid parameters");
    }
  } catch (Exception $e) {
    echo json_encode(array("result" => "error", "message" => $e->getMessage()));
    http_response_code(500); // Set HTTP status code to 500
  }
  ?>



  <div id="content">
    <div id="header"> </div>

    <div id="header-select-type">
      <p class="selectable" data-type=<?php echo $formType ?>><?php echo $formType === 'ah' ? "A&H" : strtoupper($formType) ?></p>
      <!-- <p class="selectable" data-type="home">HOME</p>
        <p class="selectable" data-type="auto">AUTO</p>
        <p class="selectable" data-type="ah">A&H</p> -->
    </div>
    <form id="application" novalidate>
      <!-- <div id="top-detail">
        <div id="app-detail" style="padding:5px 10px">
          <table>
           
          </table>
        </div>
      </div> -->

      <!--Form PolicyDetail -->
      <div id="confirmQuoteContainer">

        <fieldset id="form-content">
          <legend>Product Detail</legend>
          <table id="table-form">
            <tr>
              <td>
                <p style="white-space:nowrap;">Product Name : <span style="color:red">*</span></p>
              </td>
              <td>
                <select name="select-product" id="select-product" required onchange="handleProductChange(this)">
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  if ($formType === 'ah') {
                    $strSQL = "SELECT * FROM t_aig_sg_product WHERE product_group = 'A&H'";
                  } else {
                    $strSQL = "SELECT * FROM t_aig_sg_product WHERE product_group = '$formType'";
                  }

                  $strSQL .= " and campaign_id = '$campaign_id'";

                  $objQuery = mysqli_query($Conn, $strSQL);

                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["product_id"]; ?>" data-plan_group="<?php echo $objResuut["plan_group"]; ?>">
                      <?php echo $objResuut["product_name"]; ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
              </td>

              <th></th>
              <td style="white-space:nowrap; ">Campaign Name:</td>
              <td> <?php
                    $strSQL = "SELECT * FROM t_campaign WHERE campaign_id = '$campaign_id'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResult = mysqli_fetch_array($objQuery)) {
                      $data[] = $objResult;
                    ?>
                  <input style="width:216px;" type="text" id="product-<?php echo $objResult['campaign_id']; ?>" value="<?php echo $objResult['campaign_name']; ?>" readonly>

                <?php
                    }
                ?>
              </td>

            </tr>
            <tr id="policyid-display">
              <td id="policyid-text">Policy/Quote No:</td>
              <td><input type="text" id="policyid-input" style="display: inline-block; width:216px;" readonly /></td>
            </tr>
            <tr>
              <td style="white-space:nowrap;">Policy Effective Date: <span style="color:red">*</span></td>
              <td><input type="text" id="datepicker5" name="PolicyEffectiveDate" maxlength="10" required style="max-width: 130px;"></td>
              <th></th>
              <td style="white-space:nowrap;" id="promocode-label">Promo Code:</td>
              <td id="promocode-label2">
                <input id="promocode-input" name="campaignCode" type="text" style="display: inline-block; width:216px;" readonly />
              </td>

              <td style="white-space:nowrap;" <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>>Policy Expiry Date: <span style="color:red">*</span></td>
              <td <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>><input type="text" id="datepicker6" name="PolicyExpiryDate" maxlength="10" <?php echo ($formType === "auto") ? 'required' : ''; ?> style="max-width: 130px;"></td>
            </tr>
            <table id="promo-table" style="border-spacing:0.5rem 0.2rem" <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>>
              <tbody>

              </tbody>
              <tr id="add-code-display" style="display:none">
                <td></td>
                <td></td>
                <td>
                  <button type="button" onclick="addPromoCode()" class="button payment" style="float:inline-end">Add Code</button>
                </td>
              </tr>
            </table>


          </table>
          <table id="table-form">

            <tr id="remark-c-container">
              <td style="float: inline-start;padding-right: 84px;">RemarksC:</td>
              <td style="white-space:nowrap;">
                <textarea name="RemarkCInput" id="RemarkCInput" rows="4" cols="50" maxlength="2000"></textarea>
              </td>
            </tr>
          </table>


        </fieldset>
      </div>
      <div id="payment-container">
        <fieldset id="form-content">
          <legend>Payment</legend>


          <!-- <h1 style="padding-left:0.5em">Additional</h1> -->
          <table id="table-form">

            <tr>
              <td style="float:inline-start">Payment Frequency: <span style="color:red">*</span></td>
              <td>
                <div class="form-check" id="display-paymentFrequencyAnnual">
                  <input type="radio" class="form-check-input" id="paymentFrequencyAnnual" name="Payment_Frequency" value="1" onchange="handlePaymentFrequencyChange(this)">
                  <label class="form-check-label" for="paymentFrequencyAnnual">Annual</label>
                </div>
                <div class="form-check" id="display-paymentFrequencyMonthly">
                  <input type="radio" class="form-check-input" id="paymentFrequencyMonthly" name="Payment_Frequency" value="2" onchange="handlePaymentFrequencyChange(this)" checked>
                  <label class="form-check-label" for="paymentFrequencyMonthly">Monthly</label>
                </div>
              </td>
            </tr>

            <tr>
              <td>Payment Mode: <span style="color:red">*</span></td>
              <td>
                <select name="Payment_Mode" id="paymentModeSelect" required>
                  <option value=""> <-- Please select an option --> </option>
                  <option value="1001">Credit Card Lump sum</option>
                  <option value="124">Recurring Credit Card</option>
                  <option value="122" style="display: <?php echo ($formType === 'auto') ? 'block' : 'none'; ?>;">Credit Card IPP</option>
                </select>
              </td>
              <th></th>
              <td style="padding-left:47px" <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>>Automatic Renewal Flag: </td>
              <td <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>>
                <select name="automaticRenewalFlag" id="automaticRenewalFlag" disabled>
                  <option value=""> <-- Please select an option --> </option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </td>

            </tr>
            <tr id='cardTypeDisplay' style="display:none">
              <td>Card Type: <span style="color:red">*</span></td>
              <td>
                <select name="cardType" id="cardType">
                  <option value=""> <-- Please select an option </option> -->
                  <option value="3">Credit Card IPP UOB 6 months</option>
                  <option value="6">Credit Card IPP DBS 6 months</option>
                  <option value="4">Credit Card IPP UOB 12 months</option>
                  <option value="7">Credit Card IPP DBS 12 months</option>
                </select>
              </td>
            </tr>

          </table>
        </fieldset>
      </div>


      <!--Form Individual PolicyHolder Info -->
      <fieldset id="form-content">
        <br>
        <h1 style="padding-left:0.5em">Individual Policy Holder Info</h1><br>
        <legend>Policy Holder Info</legend>

        <table id="table-form" hidden>
          <tr>
            <td style="float:inline-start">Customer Type : <span style="color:red">*</span></td>
            <td style="width:20px"></td>
            <td>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="individual" name="customerType" value="0" checked onclick="showForm(this)">
                <label class="form-check-label" for="individual">Individual</label>
              </div>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="properate" name="customerType" value="1" onclick="showForm(this)" disabled>
                <label class="form-check-label" for="properate">Properate</label>
              </div>
            </td>
          </tr>
        </table>

        <div id="individualForm" class="form-section" style="display:none;">
          <table id="table-form">
            <tr>
              <td>Courtesy Title : </td>
              <td>
                <select name="courtesyTitle">
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'courtesyTitle'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
              </td>
              <td>&nbsp;</td>

              <td>Full Name : <span style="color:red">*</span></td>
              <td><input type="text" name="firstName" maxlength="100" size="30" required /></td>
              <td><input type="text" name="lastName" maxlength="60" size="30" hidden /></td>
            </tr>
            <!-- <tr>
             
              <th>&nbsp;</th>
              
              <td>Lastname : </td>
              <td><input type="text" name="lastName" maxlength="60" size="30" /></td>
            </tr> -->
            <tr>
              <td>Gender : <span style="color:red">*</span> </td>
              <td>
                <select name="gender" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'gender'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
              </td>
              <th>&nbsp;</th>
              <td>Nationality : <?php echo ($formType === "home") ? '' : '<span style="color:red">*</span>'; ?></td>
              <td>
                <select name="nationality" <?php echo ($formType === "home") ? '' : 'required'; ?>>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Nationality'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
              </td>

            </tr>
            <tr>
              <td>Date Of Birth : <span style="color:red">*</span></td>
              <td>
                <input type="text" id="datepicker" name="dateOfBirth" maxlength="10" required>
              </td>
              <th>&nbsp;</th>
              <td>Age :</td>
              <td>
                <input type="text" id="agePolicyHolder" name="agePolicyHolder" maxlength="4" readonly style="max-width:50px"> years old
              </td>
            </tr>
            <tr>
              <td style="white-space:nowrap">Marital Status : <?php echo ($formType === "home") ? '' : '<span style="color:red">*</span>'; ?> </td>
              <td>
                <select name="maritalStatus" <?php echo ($formType === "home") ? '' : 'required'; ?>>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Marital Status'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>


                </select>
              </td>
              <th>&nbsp;</th>
              <td style="white-space: nowrap;">Resident Status : <span style="color:red">*</span>
              </td>
              <td>
                <select name="residentStatus" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'residentStatus'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>CustomerId Type : <span style="color:red">*</span> </td>
              <td>
                <select name="customerIdType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'customerIdType'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select>
              </td>
              <th>&nbsp;</th>
              <td>CustomerId No. : <span style="color:red">*</span></td>
              <td><input type="text" name="customerIdNo" maxlength="60" size="30" required /></td>
            </tr>
            <tr>
              <td>Occupation : <?php echo ($formType === "home") ? '' : '<span style="color:red">*</span>'; ?></td>
              <td>
                <select name="occupation" <?php echo ($formType === "home") ? '' : 'required'; ?>>
                  <option value=""> <-- Please select an option --></option>
                  <?php
                  $strSQL = "SELECT name, id, description
FROM t_aig_sg_lov 
where name='ph occupation'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }

                  ?>
                </select>
              </td>
              <th>&nbsp;</th>
              <td>Mobile No. : <span style="color:red">*</span></td>
              <td><input type="text" name="mobileNo" maxlength="60" size="30" required /></td>
            </tr>
            <tr>
              <td>Email : <span style="color:red">*</span></td>
              <td><input type="text" name="emailId" maxlength="60" size="30" required /></td>
              <th></th>
              <td style="float:inline-start">Email Fulfillment Flag: <span style="color:red">*</span></td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="emailFulfillmentYes" name="Email_Fulfillment_Flag" value="1" checked>
                  <label class="form-check-label" for="emailFulfillmentYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="emailFulfillmentNo" name="Email_Fulfillment_Flag" value="2">
                  <label class="form-check-label" for="emailFulfillmentNo">No</label>
                </div>
              </td>
            </tr>

            <tr>
              <td>
                <h1>Mailing Address</h1>
              </td>
            </tr>
            <tr>
              <td>Block Number : <span style="color:red">*</span></td>
              <td><input type="text" name="blockNo" maxlength="60" size="30" required /></td>
              <th>&nbsp;</th>
              <td>Street Name : <span style="color:red">*</span></td>
              <td><input type="text" name="streetName" maxlength="60" size="30" required /></td>
            </tr>
            <tr>
              <td>Unit No. : </td>
              <td><input type="text" name="unitNo" maxlength="60" /></td>
              <th>&nbsp;</th>
              <td>Building Name : </td>
              <td><input type="text" name="buildingName" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Postal/Zip Code : <span style="color:red">*</span></td>
              <td><input type="text" name="postCode" maxlength="6" required /></td>
            </tr>

            <tr id="isPolicyHolderDrivingRow">
              <td style="float:inline-start">isPolicyHolderDriving : <span style="color:red">*</span></td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="isPolicyHolderDrivingYes" name="isPolicyHolderDriving" value="2" onclick="handleChangeIsPolicyHolderDriving(this)">
                  <label class="form-check-label" for="isPolicyHolderDrivingYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="isPolicyHolderDrivingNo" name="isPolicyHolderDriving" value="1" checked onclick="handleChangeIsPolicyHolderDriving(this)">
                  <label class="form-check-label" for="isPolicyHolderDrivingNo">No</label>
                </div>
              </td>
            </tr>

          </table>
        </div>

        <div id="properateForm" class="form-section" style="display:none;">
          <h1 style="padding-left:0.5em">Organization Info</h1>
          <table id="table-form">
            <tr>
              <td>Nature Of Business : <span style="color:red">*</span></td>
              <td>
                <select name="natureOfBusiness">
                  <option value=""> <-- Please select an option --></option>
                  <?php
                  $strSQL = "SELECT name, id, description
FROM t_aig_sg_lov 
where name='Nature of Business'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }

                  ?>
                </select>
              </td>
              <th>&nbsp;</th>
              <td>Company Name : <span style="color:red">*</span></td>
              <td><input type="text" name="companyName" maxlength="60" size="30" required /></td>
            </tr>
            <tr>
              <td>Company Reg No. : <span style="color:red">*</span></td>
              <td><input type="text" name="companyRegNo" maxlength="60" size="30" required /></td>
              <th>&nbsp;</th>
              <td>Company Reg Date : <span style="color:red">*</span></td>
              <td><input type="text" name="companyRegDate" maxlength="60" size="30" required /></td>
            </tr>
            <tr>

            </tr>
            <tr>
              <td colspan="5">
                <h1>Organization Contact Info</h1>
              </td>
            </tr>
            <tr>
              <td>Block Number : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_blockNo" maxlength="60" size="30" required /></td>
              <th>&nbsp;</th>
              <td>Street Name : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_streetName" maxlength="60" size="30" required /></td>
            </tr>
            <tr>
              <td>Unit No. : </td>
              <td><input type="text" name="Organization_unitNo" maxlength="60" /></td>
              <th>&nbsp;</th>
              <td>Building Name : </td>
              <td><input type="text" name="Organization_buildingName" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Postal/Zip Code : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_postCode" maxlength="60" required /></td>
            </tr>
          </table>
        </div>
      </fieldset>

      <!--Form Insured List -->
      <fieldset id="form-content">
        <legend>Insured List</legend>

        <!--Form Insured List (Home) -->
        <div id="insured-list-home">
          <table id="table-form">
            <tr>
              <td>
                <h1>Address Info</h1>
              </td>
            </tr>
            <tr>
              <td>Dwelling Type : <span style="color:red">*</span></td>
              <td>
                <select name="insured_home_dwellingType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>


                </select>
              </td>
              <th>&nbsp;</th>
              <td>Flat Type: <span style="color:red">*</span></td>
              <td>
                <select name="insured_home_flatType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>

                </select>
              </td>
            </tr>
            <tr>
              <td>Owner Occupied Type : <span style="color:red">*</span></td>
              <td>
                <select name="insured_home_ownerOccupiedType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Owner Occupancy Type'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select>
              </td>
              <th>&nbsp;</th>

            </tr>

            <tr>
              <td>Block Number : <span style="color:red">*</span></td>
              <td>
                <input type="text" name="insured_home_insuredBlockNo" maxlength="60" required />
              </td>
              <th>&nbsp;</th>
              <td>Street Name: <span style="color:red">*</span></td>
              <td>
                <input type="text" name="insured_home_insuredStreetName" maxlength="60" required />
              </td>
            </tr>
            <tr>
              <td>Unit No. : </td>
              <td>
                <input type="text" name="insured_home_insuredUnitNo" maxlength="60" />
              </td>
              <th>&nbsp;</th>
              <td>Building Name : </td>
              <td>
                <input type="text" name="insured_home_insuredBuildingName" maxlength="60" />
              </td>
            </tr>
            <tr>
              <td>Postal/Zip Code: <span style="color:red">*</span></td>
              <td>
                <input type="text" name="insured_home_insuredPostCode" maxlength="6" required />
              </td>
              <th>&nbsp;</th>
            </tr>

            <!-- <tr>
              <td style="float: inline-start;">Smoke Detector Available : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="smokeDetecYes" name="insured_home_smokeDetectorAvailable" value="1" checked>
                  <label class="form-check-label" for="smokeDetecYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="smokeDetecNo" name="insured_home_smokeDetectorAvailable" value="2">
                  <label class="form-check-label" for="smokeDetecNo">No</label>
                </div>
              </td>
            </tr>
            <tr>
              <td style="float: inline-start;">Auto Sprinkler : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="autoSprinkYes" name="insured_home_autoSprinklerAvailable" value="1" checked>
                  <label class="form-check-label" for="autoSprinkYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="autoSprinkNo" name="insured_home_autoSprinklerAvailable" value="2">
                  <label class="form-check-label" for="autoSprinkNo">No</label>
                </div>
              </td>
            </tr>
            <tr>
              <td style="float: inline-start;">Security System Available : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="securityYes" name="insured_home_securitySystemAvailable" value="1" checked>
                  <label class="form-check-label" for="securityYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="securityNo" name="insured_home_securitySystemAvailable" value="2">
                  <label class="form-check-label" for="securityNo">No</label>
                </div>
              </td>
            </tr> -->
          </table>
        </div>

        <!--Form Insured List (Auto) -->
        <div id="insured-list-auto">
          <table id="table-form">
            <tr>
              <td>
                <h1>Vehicle Info</h1>
              </td>
            </tr>
            <tr>
              <td>Make : <span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_vehicle_make" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  

                </select>
              </td>
              <th>&nbsp;</th>
              <td>Model : <span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_vehicle_model" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>

                </select>
              </td>
            </tr>
            <tr>
              <td>Vehicle Reg Year :<span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_vehicle_vehicleRegYear" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'vehicleRegYear' order by description desc";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select>

              <th>&nbsp;</th>
              <td>Reg No. : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_vehicle_regNo" maxlength="60" required /></td>
            </tr>
            <tr>
              <td style="float: inline-start;">Insuring With COE : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" name="insured_auto_vehicle_insuringWithCOE" value="2" checked>
                  <label class="form-check-label" for="Yes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" name="insured_auto_vehicle_insuringWithCOE" value="1">
                  <label class="form-check-label" for="No">No</label>
                </div>
              </td>
              <th></th>

            </tr>
            <tr>
              <td style="float: inline-start;">Off Peak Car : <span style="color:red">*</span></td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" name="insured_auto_vehicle_offPeakCar" value="2">
                  <label class="form-check-label" for="Yes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" name="insured_auto_vehicle_offPeakCar" value="1" checked>
                  <label class="form-check-label" for="No">No</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>Vehicle Usage :<span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_vehicle_vehicleUsage" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Vehicle Usage'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $selected = ((int)$objResuut["id"] === 205) ? "selected" : "";
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>" <?php echo $selected; ?>>
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select>

              </td>
              <th>&nbsp;</th>
              <td id='mileageDeclaration-label'>Mileage Declaration : </td>
              <td>
                <input type="text" name="insured_auto_vehicle_mileageDeclaration" maxlength="60" />
              </td>
            </tr>
            <tr>
              <td>Engine No. : <span style="color:red">*</span> </td>
              <td><input type="text" name="insured_auto_vehicle_engineNo" maxlength="60" required /></td>
              <th>&nbsp;</th>
              <td>Chassis No. : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_vehicle_chassisNo" maxlength="60" required /></td>
            </tr>
            <tr>
              <td>Hire Purchase Company: <span style="color:red">*</span></td>
              <td>

                <select name="insured_auto_vehicle_hirePurchaseCompany" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Hire Purchase'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select>
            </tr>
            <tr>
              <td>
                <h1>Driver Info</h1>
              </td>
            </tr>
            <tr>

              <td>Driver Type : <span style="color:red">*</span></td>
              <td><select name="insured_auto_driverInfo_driverType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov WHERE name = 'driverType'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResult = mysqli_fetch_array($objQuery)) {
                    // Ensure both $objResult["id"] and 5 are of the same type (integer)
                    $selected = ((int)$objResult["id"] === 5) ? "selected" : "";
                  ?>
                    <option value="<?php echo $objResult["id"]; ?>" <?php echo $selected; ?>>
                      <?php echo $objResult["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select></td>
              <th>&nbsp;</th>
              <td>Driver Name : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_driverInfo_driverName" maxlength="60" required /></td>
            </tr>
            <tr>
              <td>Driver Resident Status : <span style="color:red">*</span></td>
              <td><select name="insured_auto_driverInfo_driverResidentStatus" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'residentStatus'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select></td>
              <th>&nbsp;</th>
              <td>DriverId Type : <span style="color:red">*</span></td>
              <td><select name="insured_auto_driverInfo_driverIdType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'driverIdType'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select></td>
            </tr>


            <tr>
              <td>DriverId Number: <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_driverInfo_driverIdNumber" maxlength="60" required /></td>
              <th>&nbsp;</th>
              <td>Driver Occupation: <span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_driverInfo_occupation" required>
                  <option value=""> <-- Please select an option --></option>
                  <?php
                  $strSQL = "SELECT name, id, description
                    FROM t_aig_sg_lov 
                    where name='Occupation'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }

                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>Driver DOB : <span style="color:red">*</span> </td>
              <td>
                <input type="text" id="datepicker2" name="insured_auto_driverInfo_driverDOB" maxlength="10" required>
              <th>&nbsp;</th>
              <td>Age :</td>
              <td>
                <input type="text" id="ageDriver" name="ageDriver" maxlength="4" readonly style="max-width:50px"> years old
              </td>
            </tr>
            <tr>
              <td>Driver Gender : <span style="color:red">*</span></td>
              <td><select name="insured_auto_driverInfo_driverGender" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'gender'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select></td>
              <th>&nbsp;</th>
              <td>Driver Nationality : <span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_driverInfo_driverNationality" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Nationality'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>
              </td>
            </tr>
            <tr>
              <td>Driver Marital Status : <span style="color:red">*</span></td>
              <td><select name="insured_auto_driverInfo_maritalStatus" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Marital Status'";
                  $objQuery = mysqli_query($Conn, $strSQL);
                  while ($objResuut = mysqli_fetch_array($objQuery)) {
                    $data[] = $objResuut;
                  ?>
                    <option value="<?php echo $objResuut["id"]; ?>">
                      <?php echo $objResuut["description"]; ?>
                    </option>
                  <?php
                  }
                  ?>

                </select></td>
              <th>&nbsp;</th>
              <td>Driver Experience : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_driverInfo_drivingExperience" id="drivingExperience" maxlength="4" size="10" required value="1" /> <span>year</span></td>
            </tr>

            <tr>
              <td style="float: inline-start;">Claim Experience : <span style="color:red">*</span> </td>
              <td>
                <select id="insured_auto_driverInfo_claimExperience" name="insured_auto_driverInfo_claimExperience" required
                  onchange="toggleClaimExperience(this)">
                  <option value=""> <-- Please select an option --></option>
                  <option value="N"> No claims </option>
                  <option value="Y"> 1 claim</option>
                  <option value="morethan1">More than 1 claim </option>

                </select>
              </td>
              <!-- <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="insured_auto_driverInfo_claimExperience" name="insured_auto_driverInfo_claimExperience" value="Y" checked onclick="toggleClaimExperience(this)">
                  <label class="form-check-label" for="Yes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="insured_auto_driverInfo_claimExperience" name="insured_auto_driverInfo_claimExperience" value="N" onclick="toggleClaimExperience(this)">
                  <label class="form-check-label" for="No">No</label>
                </div>
              </td> -->
            </tr>

          </table>
          <div class="table" id="claim-info">

            <table id="table-form">
              <tr>
                <td>
                  <h1>Claim Info</h1>
                </td>
              </tr>
              <tr>
                <td style="padding:0px 30px">Date Of Loss : <span style="color:red">*</span></td>
                <td>
                  <input type="text" id="datepicker3" name="insured_auto_driverInfo_claimInfo_dateOfLoss" required maxlength="10">
                <th>&nbsp;</th>
                <td>Loss Description : <span style="color:red">*</span></td>
                <td><input type="text" name="insured_auto_driverInfo_claimInfo_lossDescription" maxlength="60" required /></td>
              </tr>
              <tr>
                <td style="padding:0px 30px">Claim Nature : <span style="color:red">*</span></td>
                <td><select name="insured_auto_driverInfo_claimInfo_claimNature" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'claimNature'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>

                  </select></td>
                <th>&nbsp;</th>
                <td>Claims Amount : <span style="color:red">*</span></td>
                <td><input type="text" name="insured_auto_driverInfo_claimInfo_claimAmount" maxlength="60" required /></td>
              </tr>
              <tr>
                <td style="padding:0px 30px">Status : <span style="color:red">*</span></td>
                <td><select name="insured_auto_driverInfo_claimInfo_claimStatus" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'statusClaimInfo'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>

                  </select></td>
                <th>&nbsp;</th>
                <td>Insured Liability : <span style="color:red">*</span></td>
                <td>
                  <select name="insured_auto_driverInfo_claimInfo_insuredLiability" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredLiability'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>

                  </select>

                </td>
              </tr>
            </table>
          </div>
          <div id="ncd-info-container">
            <table id="table-form">
              <tr>
                <td>
                  <h1>Ncd Info</h1>
                </td>
              </tr>
              <tr>
                <td style="width:185px">Ncd Level: <span style="color:red">*</span> </td>
                <td>

                  <select name="Ncd_Level" id="ncdLevel" onchange="toggleNcdLevel()" style="text-align:center " required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'NCD Level'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>%
                      </option>
                    <?php
                    }
                    ?>

                  </select>
                </td>
                <td>&nbsp;</td>
                <td id="ncdLevel_gears_display">Ncd Level (GEARS) : </td>
                <td>

                  <select name="Ncd_Level_gears" id="ncdLevel_gears" onchange="toggleNcdLevel()" style="text-align:center " disabled>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'NCD Level'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>%
                      </option>
                    <?php
                    }
                    ?>

                  </select>
                </td>
              </tr>
              <tr id="noClaimExperienceRow">
                <td>No Claim Experience : <span style="color:red">*</span> </td>
                <td>
                  <select name="NoClaimExperience" id="ncdNoExperience" onchange="toggleNcdNoExperience()" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'noClaimExperience'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>
                  </select>
                </td>
                <th>&nbsp;</th>
                <td id="otherExperience-display" style="display:none">Other <span style="color:red">*</span></td>
                <td> <input type="text" id="otherExperience" name="otherExperience" maxlength="60" size="30" style="display:none" /></td>
              </tr>
              <tr id="haveExperienceRow" style="display:none">
                <td>Previous Insurer: <span style="color:red">*</span> </td>
                <td>
                  <select name="haveEx-PreviousInsurer">
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'NCD Previous Insurer'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>
                  </select>
                </td>
                <th>&nbsp;</th>
                <td><span>Previous Policy No./</span><br>
                  <span>Vehicle Reg No: <span><span style="color:red">*</span>
                </td>
                <td>
                  <input type="text" name="haveEx-PreviousPolicyNo" maxlength="60" size="30" />
                </td>
              </tr>



            </table>
          </div>
          <div id="excess-section" hidden>
            <table id="table-form">
              <tr>
                <td>
                  <h1>Excess Info</h1>
                </td>
              </tr>
              <tr>
                <td style="width:176px">Standard Excess :</td>
                <td>
                <td>
                  <input type="text" name="insured_auto_standard_excess" id='insured_auto_standard_excess' maxlength="60" readonly />
                </td>
                </td>
              </tr>
              <tr>
                <td style="width:176px">Min Standard Excess :</td>
                <td>
                <td>
                  <input type="text" name="insured_auto_min_standard_excess" id='insured_auto_min_standard_excess' maxlength="60" readonly />
                </td>
                </td>
              </tr>
              <tr>
                <td style="width:176px">Max Standard Excess :</td>
                <td>
                <td>
                  <input type="text" name="insured_auto_max_standard_excess" id='insured_auto_max_standard_excess' maxlength="60" readonly />
                </td>
                </td>
              </tr>
              <tr>
                <td style="width:176px">Interval Value :</td>
                <td>
                <td>
                  <input type="text" name="insured_auto_interval_value" id='insured_auto_interval_value' maxlength="60" readonly />
                </td>
                </td>
              </tr>
              <tr>
                <td>Buy Up/Down :</td>
                <td>
                <td>
                  <select name="insured_auto_buy_up_down" id='insured_auto_buy_up_down'>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                  </select>
                </td>
                </td>
              </tr>
              <tr>
                <td>UW Excess :</td>
                <td>
                <td>
                  <input type="text" name="insured_auto_uw_excess" id='insured_auto_uw_excess' maxlength="60" readonly />
                </td>
                </td>
              </tr>

              <tr>
                <td>Final Excess :</td>
                <td>
                <td>
                  <input type="text" name="insured_auto_final_excess" id='insured_auto_final_excess' maxlength="60" readonly />
                </td>
                </td>
              </tr>
            </table>

          </div>
          <div id="excess-section-other" hidden>
            <table id="table-form" style="border-spacing: 0.5em 0em">
              <tbody id='section-other-body' >
              <!-- <tr>
                <td>
                  <span>Section 1</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span>Fire - $0</span>
                  <span>Own Damage - $600</span>
                  <span>Theft - $0</span>
                  <span>Flood Cover - $600</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span>Section 2</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span>Property Damage - $0</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span>Windscreen - $100</span>
                </td>
              </tr> -->
              </tbody>
            
            </table>

          </div>
          <div id="agecondition">
            <table id="table-form">
              <tr>
                <td>
                  <h1>Other Info</h1>
                </td>
              </tr>
              <tr>
                <td style="width:185px">Age Condition Basis : <span style="color:red">*</span></td>
                <td>
                  <select name="insured_auto_vehicle_ageConditionBasis" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'ageConditionBasis'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $selected = ((int)$objResuut["id"] === 1) ? "selected" : "";
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>" <?php echo $selected; ?>>
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>


                  </select>
                </td>
                <th></th>
                <td>Mileage Condition : <span style="color:red">*</span></td>
                <td><select name="insured_auto_vehicle_mileageCondition" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Mileage Condition'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                      $selected = ((int)$objResuut["id"] === 1838000062) ? "selected" : "";
                      $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>" <?php echo $selected; ?>>
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>

                  </select>
                </td>
              </tr>
            </table>

          </div>
          <br>
        </div>
        <!--Form Insured List (A&H) -->
        <div id="insured-list-ah">

        </div>
        <button id="add-insured-child" class="button payment" style="float: right; display:none" type="button">Add Child</button>
        <button <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?> id="get-premium-button" class="button payment" type="button" onclick="validateAndSubmitFormCallPremium()">Get premium</button>

        <!--Form Insured List Plan info -->
        <div id="plan-info-container-main">
          <table id="table-form" name="plan-info">
            <tr>
              <td>
                <h1>Plan Info</h1>
              </td>
            </tr>
            <tr>
              <td style="white-space:nowrap;padding-right:75px;">Plan Name : <span style="color:red">*</span> </td>
              <td>
                <select id="planSelect" name="planId" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>

                </select>
              </td>
              <th></th>
              <td style="white-space: nowrap;">Plan Poi :</td>
              <td colspan="2">
                <input type="text" id="planPoiSelect" name="planPoi" readonly>
              </td>

            </tr>




          </table>
          <table id="table-form">
            <tr id="coverListDisplay" hidden>
              <td>Cover List</td>
              <td></td>
            </tr>
            <tbody id="coverListBody">

            </tbody>
            </tr>
            <tr id="addCoverDisplay" hidden>
              <!-- <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td> -->


              <td>

                <button type="button" id="addCover" class="button payment" style="float:right;margin-right:8px">Add cover</button>
              </td>
            </tr>

          </table>
          <table id="table-form">
            <tr id="premium-amount-label" <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>>
              <td>Amount : </td>
              <td>
                <input type="text" name="premium-amount" id="premium-amount" maxlength="10" size="10" readonly="">
              </td>
            </tr>
            <tr id="premium-amount-withgst-label" <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>>
              <td style='padding-right:32px'>Amount (9% GST) : </td>
              <td>
                <input type="text" name="premium-amount-with-gst" id="premium-amount-with-gst" maxlength="10" size="10" readonly="">
              </td>
            </tr>
          </table>
          <table id="table-form" <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>>
            <tr id="comment-label">
              <td style="float: inline-start; padding-right:26px">Quote Version Memo:</td>
              <td style="white-space:nowrap;">
                <textarea name="commentHistory" id="commentHistory" style="padding-left:5px;height: 60px;width:300px"></textarea>
                <button class="extend-btn" data-textarea-id="commentHistory" onclick="extendTextarea('commentHistory', this)" style="display: inline-block; margin-left: 10px; color: gray; border: none; background: none; cursor: pointer;">Extend</button>

              </td>
            </tr>
          </table>
          <div id='additional-info' hidden>
            <table id="table-form" <?php echo ($formType === "auto") ? 'block' : 'hidden'; ?>>
              <tr>
                <td style="float: inline-start; padding-right:20px">Internal Claim History:</td>
                <td style="white-space:nowrap;">
                  <textarea name="internal-claim-history" id="internal-claim-history" readonly style="padding-left:5px;height: 60px;width:300px; display: inline-block;"></textarea>
                  <button class="extend-btn" data-textarea-id="internal-claim-history" onclick="extendTextarea('internal-claim-history', this)" style="display: inline-block; margin-left: 10px; color: gray; border: none; background: none; cursor: pointer;">Extend</button>
                </td>
              </tr>
              <tr>
                <td style="float: inline-start; padding-right:20px">Special Text:</td>
                <td style="white-space:nowrap;">
                  <textarea name="special-text" id="special-text" readonly style="padding-left:5px;height: 60px;width:300px; display: inline-block;"></textarea>
                  <button class="extend-btn" data-textarea-id="special-text" onclick="extendTextarea('special-text', this)" style="display: inline-block; margin-left: 10px; color: gray; border: none; background: none; cursor: pointer;">Extend</button>
                </td>
              </tr>
              <tr>
                <td style="float: inline-start; padding-right:20px">Remarks:</td>
                <td style="white-space:nowrap;">
                  <textarea name="remarks-retrieve" id="remarks-retrieve" readonly style="padding-left:5px;height: 60px;width:300px; display: inline-block;"></textarea>
                  <button class="extend-btn" data-textarea-id="remarks-retrieve" onclick="extendTextarea('remarks-retrieve', this)" style="display: inline-block; margin-left: 10px; color: gray; border: none; background: none; cursor: pointer;">Extend</button>
                </td>
              </tr>
              <tr>
                <td style="float: inline-start; padding-right:20px">RemarksC:</td>
                <td style="white-space:nowrap;">
                  <textarea name="remarksC-memo" id="remarksC-memo" readonly style="padding-left:5px;height: 60px;width:300px"></textarea>
                  <button class="extend-btn" data-textarea-id="remarksC-memo" onclick="extendTextarea('remarksC-memo', this)" style="display: inline-block; margin-left: 10px; color: gray; border: none; background: none; cursor: pointer;">Extend</button>
                </td>
              </tr>
              <tr>
                <td style="float: inline-start; padding-right:20px">Comments History:</td>
                <td style="white-space:nowrap;">
                  <textarea name="commentsHistory" id="commentsHistory" readonly style="padding-left:5px;height: 60px;width:300px"></textarea>
                  <button class="extend-btn" data-textarea-id="commentsHistory" onclick="extendTextarea('commentsHistory', this)" style="display: inline-block; margin-left: 10px; color: gray; border: none; background: none; cursor: pointer;">Extend</button>
                </td>
              </tr>
              <tr>
                <td style="float: inline-start; padding-right:20px">Referral Response:</td>
                <td style="white-space:nowrap;">
                  <textarea name="referral-response" id="referral-response" readonly style="padding-left:5px;height: 60px;width:300px"></textarea>
                  <button class="extend-btn" data-textarea-id="referral-response" onclick="extendTextarea('referral-response', this)" style="display: inline-block; margin-left: 10px; color: gray; border: none; background: none; cursor: pointer;">Extend</button>
                </td>
              </tr>
              <tr>
                <td style="float: inline-start; padding-right:20px">Discount list:</td>
                <td style="white-space:nowrap;">
                  <textarea name="discountList" id="discountList" readonly style="padding-left:5px;height: 60px;width:300px"></textarea>
                  <button class="extend-btn" data-textarea-id="discountList" onclick="extendTextarea('discountList', this)" style="display: inline-block; margin-left: 10px; color: gray; border: none; background: none; cursor: pointer;">Extend</button>
                </td>
              </tr>
              <tr></tr>
              <tr>
                <td>
                  <h1>Objection Handling<br>Vouchers</h1>
                </td>
              </tr>
              <tr>
                <td style="width:185px">Promo Code: </td>
                <td>
                  <select name="insured_auto_objecthandlingvouchers" >
                    <option value="">
                      <-- Please select an option -->
                    </option>

                  </select>
                </td>
                  </tr>
                  </br>
            </table>

          </div>
        </div>


      </fieldset>

      <div id="payment-container-amount" hidden>
        <fieldset id="form-content">
          <!-- <legend>Payment</legend> -->

          <div class="table" style="display: table; width: 100%; ">
  <!-- Table Header -->
  <div class="table-header" style="display: table-row; font-weight: bold; ">
    <div class="header__item" style="display: table-cell; width: 40%; padding: 10px;">Payment Type</div>
    <div class="header__item" style="display: table-cell; width: 35%; padding: 10px;">Action</div>
    <div class="header__item" style="display: table-cell; width: 25%; padding: 10px;">Other</div>
  </div>

  <!-- Table Content -->
  <div class="table-content" style="display: table-row-group;">
    
    <!-- Default Payment Row -->
    <div class="table-row" style="display: table-row;" id="default-payment-display">
      <div class="table-data" style="display: table-cell; width: 40%; padding: 10px;">
        Online Payment (Secure Flow)
      </div>
      <div class="table-data" style="display: table-cell; width: 35%; padding: 10px;">
        <button type="button" class="button" id="secure_flow" onclick="handleSecureFlow()" style="width:120px !important">Create Token</button>
        <button type="button" class="button" id="payment_secure_flow" style="opacity: 0.65;display:none;width:120px !important">Pay by Token</button>
      </div>
      <div class="table-data" style="display: table-cell; width: 25%; padding: 10px;">
      <div style="display: flex; align-items: baseline; gap: 10px;flex-direction:column;">
        <label style="display: flex; align-items: center; gap: 5px;">
          <input type="checkbox" id="payment_checkbox"
                onchange="document.getElementById('payment_comment').disabled = !this.checked;">
          Opt Manual Payment
        </label>
        <input type="text" id="payment_comment"
              placeholder="Add comment..."
              style="width: 200px; padding: 5px;"
              disabled>
      </div>

      </div>
    </div>

      <!-- Alternate Payment Row -->
    <div class="table-row" style="display: table-row;" id="alternate-payment-display">
      <div class="table-data" style="display: table-cell; width: 40%; padding: 10px;">
      Online Payment (Manual Pause)-<br>Override Secure Flow
      </div>
      <div class="table-data" style="display: table-cell; width: 35%; padding: 10px;">
        <button type="button" class="button payment" id="btnPayment" onclick="handleRetrieveQuote()" style="width:120px !important">Make payment</button>
      </div>
      <div class="table-data" style="display: table-cell; width: 25%; padding: 10px;">
      -
      </div>
    </div>
  </div>
</div>




          <!-- <h1 style="padding-left:0.5em">Additional</h1> -->
          <table id="table-form">
            <!-- <tr>
              <td>Card Type : <span style="color:red">*</span> </td>
              <td>
                <select name="Payment_CardType" id="Payment_CardType" >
                  <option value="1" hidden>Credit Card Lump Sum VISA</option>
                  <option value="2" hidden>Credit Card Lump Sum MASTER</option>
                  <option value="3">Credit Card IPP UOB 6 months</option>
                  <option value="4">Credit Card IPP UOB 12 months</option>
                  <option value="5">Credit Card IPP UOB 24 months</option>
                  <option value="6">Credit Card IPP DBS 6 months</option>
                  <option value="7">Credit Card IPP DBS 12 months</option>
                  <option value="8">Credit Card IPP DBS 24 months</option>
                  <option value="9" hidden>Recurring Credit Card VISA</option>
                  <option value="10" hidden>Recurring Credit Card Master</option>
                  <option value="23" hidden>Credit Card Lump Sum Amex</option>
                  <option value="26">Recurring Credit Card Amex</option>
                </select>
              </td>
            </tr> -->
            <tr id="card-number-container" hidden>
              <td>Card Number : <span style="color:red">*</span> </td>
              <td>
                <input type="text" name="payment_cardNumber" maxlength="60" disabled />
              </td>
            </tr>
            <tr id="card-expiry-container" hidden>
              <td>Expiry Date : <span style="color:red">*</span> </td>
              <td>

                <input type="text" name="payment_expiryDate" id="expiryDate" maxlength="5" size="5" placeholder="MM/YY" disabled />
              </td>

            </tr>
            <!-- <tr>
              <td>CVV : <span style="color:red">*</span> </td>
              <td>
                <input type="text" name="payment_securityCode" id="securityCode" maxlength="10" size="10" required />
              </td>
            </tr> -->
            <tr id='payment_amount_label'>
              <td>Amount : </td>
              <td>
                <input type="text" name="payment_amount" id="payment_amount" maxlength="10" size="10" readonly />
              </td>
              <td><div id="discount_summary">
                <!-- ส่วนลดทั้งหมดจะแสดงตรงนี้ -->
              </div></td>
            </tr>
          </table>
          <br>

        </fieldset>
      </div>


      <div style="display: flex; justify-content: center;padding:1em 0px; gap:10px">
        <input type="hidden" name="action" id="formAction" value="">
        <button  <?php echo ($formType === "ah") ? 'block' : 'hidden'; ?> type="button" class="button reject-button" id="btnReject" onclick="handleRejectButton()">Reject</button>
        <button type="button" class="button draft-button" id="btnDraftForm" onclick="handleClickDraftButton()">Save</button>
        <button type="button" class="button draft-button" id="btnSaveDraftForm" onclick="handleClickSaveDraftButton()" hidden>Save</button>
        <button hidden type="submit" class="button edit" id="btnEditForm" onclick="handleEditQuote()" data-recalculate="true">Edit</button>
        <button type="submit" class="button payment" id="btnSaveForm">Create Quote</button>
        <!-- <button type="submit" class="button payment" id="btnPaymentOnline" onclick="handleForm()">Save</button> -->
        <!-- <button type="button" class="button payment" id="btnClearForm" style="color:#65558F; background-Color:white; border:1px solid white;">Clear</button> -->
      </div>

    </form>
  </div>
<div id="rejectModal">
  <h2>Reject Campaign</h2>
  <label for="rejectReason">Select a reason for rejection:</label>
  <select id="rejectReason" onchange="handleReasonChange()">
    <option value="">-- Please select an option --</option>
    <option>Cannot afford premium</option>
    <option>Already upgraded/covered</option>
    <option>Coverage level too low</option>
    <option>No interest in product</option>
    <option>Prefer to deal with own agent</option>
    <option>Premium rates too high</option>
    <option>Rejected by company / underwriting</option>
    <option>Unhappy experience with company</option>
    <option>Renewal via other means</option>
    <option>Rejected due to medical condition</option>
    <option value="Other">Other (refer to Notes)</option>
  </select>

  <div id="otherReasonContainer" style="display:none;">
    <label for="otherReason">Please specify:</label>
    <input type="text" id="otherReason" placeholder="Please enter reason here" />
  </div>

  <div style="text-align: right;">
    <button onclick="submitRejectReason()">Submit</button>
    <button onclick="closeRejectModal()">Cancel</button>
  </div>
</div>


</body>

</html>