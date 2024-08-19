<?php ob_start();
session_start();
require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc"); //include("../../function/checkSession.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
  #table-form {
    border-spacing: 0.5em 0.5em;
  }

  #table-form td {
    white-space: nowrap;
  }
</style>

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
  <script type="text/javascript" src="../scripts/function.js?v=<?= time(); ?>"></script>
  <script type="text/javascript" src="../scripts/jsvalidate.js?v=<?= time(); ?>"></script>
  <SCRIPT type="text/javascript" src="js/app.js?v=<?= time(); ?>"></script>


  <script>
    
    function showForm(selectedOption) {
      document.getElementById('individualForm').style.display = 'none';
      document.getElementById('properateForm').style.display = 'none';

      if (selectedOption) {
        if (selectedOption.value === 'individual') {
          document.getElementById('individualForm').style.display = 'block';
        } else if (selectedOption.value === 'properate') {
          document.getElementById('properateForm').style.display = 'block';
        }
      } else {
        // Show default form
        document.getElementById('individualForm').style.display = 'block';
      }
    }

    window.onload = function() {
      showForm(document.querySelector('input[name="CustomerType"]:checked'));
    }
  </script>
</head>

<body>

  <?php

  $campaign_id = $_GET["campaign_id"];
  $calllist_id = $_GET["calllist_id"];
  $agent_id = $_GET["agent_id"];
  $import_id = $_GET["import_id"];
  $lv = $_SESSION["pfile"]["lv"];

  $Owner = $objResult["agent_id"];
  $strSQL2 = "SELECT * FROM t_agents WHERE agent_id = '$agent_id' ";
  $result2 = mysqli_query($Conn, $strSQL2);
  while ($objResult2 = mysqli_fetch_array($result2)) {
    $first_name = $objResult2["first_name"];
    $last_name = $objResult2["last_name"];
    $tsr_code = $objResult2["sales_agent_code"];
    $license_code = $objResult2["sales_license_code"];
    $team_id = $objResult2["team_id"];
  }

  $strSQL3 = "SELECT first_name,last_name,tel1,id_num FROM t_calllist WHERE calllist_id = '$calllist_id' ";
  $result3 = mysqli_query($Conn, $strSQL3);
  while ($objResult3 = mysqli_fetch_array($result3)) {
    $cust_first_name = $objResult3["first_name"];
    $cust_last_name = $objResult3["last_name"];
    $Mobile1 = $objResult3["tel1"];
    $id_num = $objResult3["id_num"];
  }
  $Mobile1_Display = "XXXXXX" . substr($Mobile1, -4);

  $strSQL4 = "SELECT c.campaign_name,c.max_insured,c.max_beneficiary,c.campaign_test_code,c.url_billing_payment,c.url_online_payment,c.check_bin FROM t_campaign c WHERE c.campaign_id = '$campaign_id' ";
  $result4 = mysqli_query($Conn, $strSQL4);
  while ($objResult4 = mysqli_fetch_array($result4)) {
    $campaign_name = $objResult4["campaign_name"];
    $max_insured = $objResult4["max_insured"];
    $max_beneficiary = $objResult4["max_beneficiary"];
    $campaign_test_code = $objResult4["campaign_test_code"];
    $url_billing_payment = $objResult4["url_billing_payment"];
    $url_online_payment = $objResult4["url_online_payment"];
    $check_bin = $objResult4["check_bin"];
  }

  $hide = 'style="display:none"';
  $APP_CONSENT = "Y";
  ?>
  <?php ?>
  <div id="content">
    <div id="header"> </div>
    <div id="top-detail">
      <div id="app-detail">
        <table>
          <tr>
            <td>
              <h1>Product Name : </h1>
            </td>
            <td><?php echo $campaign_name ?></td>
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
              <?php echo $first_name; ?>&nbsp;
              <?php echo $last_name; ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <form id="application">
      <!--Form PolicyDetail -->
      <fieldset id="form-content">
        <table id="table-form">
          <tr>
            <td>PolicyId: <span style="color:red">*</span></td>
            <td><?php echo $Run_no ?>5612367 </td>
            <td style="white-space:nowrap;">Policy Effective Date: <span style="color:red">*</span></td>
            <td><input type="text" name="PolicyEffectiveDate" maxlength="10" value="<?php echo "$currentdate_app" ?>" /></td>
            <td>Campaign Code:</td>
            <td><?php print $first_name ?></td>
          </tr>
          <tr>
            <td>
              <h1 style="color:#001871;padding:10px 0px 5px 0px ;">ncd Info</h1>
            </td>
          </tr>
          <tr>
            <td>Previous Insurer: <span style="color:red">*</span></td>
            <td><input type="text" name="PreviousInsurer" maxlength="10" value="25" /></td>
            <td style="white-space:nowrap;">PreviousPolicy No. : <span style="color:red">*</span></td>
            <td><input type="text" name="PreviousPolicy_No" maxlength="15" value="SLE3274M" /></td>
          </tr>
        </table>
      </fieldset>
      <!--Form Individual PolicyHolder Info -->
      <fieldset id="form-content">
        <br>
        <h1 style="padding-left:0.5em">Individual PolicyHolder Info</h1><br>
        <legend>PolicyHolder Info</legend>

        <table id="table-form">
          <tr>
            <td style="float:inline-start">Customer Type : <span style="color:red">*</span></td>
            <td style="width:35px"></td>
            <td>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="individual" name="CustomerType" value="individual" checked onclick="showForm(this)">
                <label class="form-check-label" for="individual">Individual</label>
              </div>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="properate" name="CustomerType" value="properate" onclick="showForm(this)">
                <label class="form-check-label" for="properate">Properate</label>
              </div>
            </td>
          </tr>
        </table>

        <div id="individualForm" style="display:none;">
          <table id="table-form">
            <tr>
              <td>Courtesy Title : <span style="color:red">*</span> </td>
              <td>
                <select name="PolicyHolder_Individual_CourtesyTitle">
                  <option value="">
                    <-- Please select an option -->
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
              <td>Firstname : <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Individual_Firstname" maxlength="60" size="30" /></td>
              <th>&nbsp;</th>
              <td>Lastname : </td>
              <td><input type="text" name="PolicyHolder_Individual_Lastname" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Gender : <span style="color:red">*</span> </td>
              <td>
                <select name="PolicyHolder_Individual_Gender">
                  <option value="">
                    <-- Please select an option -->
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
              <th>&nbsp;</th>
              <td>Nationality : <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Individual_Nationality" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Date Of Birth : </td>
              <td>
                <input id="datepicker4" type="text" name="PolicyHolder_Individual_DateOfBirth" maxlength="10" />
                <!-- <input type="hidden" name="INSURED_DOB4" maxlength="10" /> -->
              </td>
              <th>&nbsp;</th>
              <td>Age : <span style="color:red">*</span></td>
              <td>
                <div>
                  <input type="text" name="PolicyHolder_Individual_Age" maxlength="2" size="10" />
                  <span> years old</span>
                </div>
              </td>
            </tr>
            <tr>
              <td style="white-space:nowrap">Marital Status : <span style="color:red">*</span> </td>
              <td>
                <select name="PolicyHolder_Individual_MaritalStatus">
                  <option value="">
                    <-- Please select an option -->
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
              <th>&nbsp;</th>
              <td style="white-space: nowrap;">Resident Status : <span style="color:red">*</span>
              </td>
              <td>
                <select name="PolicyHolder_Individual_ResidentStatus">
                  <option value="">
                    <-- Please select an option -->
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
            </tr>
            <tr>
              <td>CustomerId Type : <span style="color:red">*</span> </td>
              <td>
                <select name="PolicyHolder_Individual_CustomerIdType">
                  <option value="">
                    <-- Please select an option -->
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
              <th>&nbsp;</th>
              <td>CustomerId No. <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Individual_CustomerIdNo" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Occupation : <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Individual_Occupation" maxlength="60" size="30" /></td>
              <th>&nbsp;</th>
              <td>Mobile No. : <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Individual_MobileNo" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Email : <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Individual_Email" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td style="float:inline-start">IsPolicyHolderDriving : <span style="color:red">*</span></td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="IsPolicyHolderDriving" name="PolicyHolder_Individual_IsPolicyHolderDriving" value="Yes" checked>
                  <label class="form-check-label" for="IsPolicyHolderDriving ">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="IsPolicyHolderDriving" name="PolicyHolder_Individual_IsPolicyHolderDriving" value="No">
                  <label class="form-check-label" for="IsPolicyHolderDriving ">No</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <h1>Contact Info</h1>
              </td>
            </tr>
            <tr>
              <td>Block Number : <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Contact_BlockNumber" maxlength="60" size="30" /></td>
              <th>&nbsp;</th>
              <td>Street Name : <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Contact_StreetName" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Unit No. : </td>
              <td><input type="text" name="PolicyHolder_Contact_UnitNo" maxlength="60" /></td>
              <th>&nbsp;</th>
              <td>Building Name : </td>
              <td><input type="text" name="PolicyHolder_Contact_BuildingName" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Postal/Zip Code : <span style="color:red">*</span></td>
              <td><input type="text" name="PolicyHolder_Contact_Postal" maxlength="60" /></td>
            </tr>
          </table>
        </div>

        <div id="properateForm" style="display:none;">
          <h1 style="padding-left:0.5em">Organization Info</h1>
          <table id="table-form">
            <tr>
              <td>Nature Of Business : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_NatureOfBusiness" maxlength="60" size="30" /></td>
              <th>&nbsp;</th>
              <td>Company Name : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_CompanyName" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Company Reg No. : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_CompanyRegNo" maxlength="60" size="30" /></td>
            </tr>
            <tr></tr>
            <tr>
              <td colspan="5">
                <h1>Organization Contact Info</h1>
              </td>
            </tr>
            <tr>
              <td>Block Number : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_Contact_BlockNumber" maxlength="60" size="30" /></td>
              <th>&nbsp;</th>
              <td>Street Name : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_Contact_StreetName" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Unit No. : </td>
              <td><input type="text" name="Organization_Contact_UnitNo" maxlength="60" /></td>
              <th>&nbsp;</th>
              <td>Building Name : </td>
              <td><input type="text" name="Organization_Contact_BuildingName" maxlength="60" size="30" /></td>
            </tr>
            <tr>
              <td>Postal/Zip Code : <span style="color:red">*</span></td>
              <td><input type="text" name="Organization_Contact_Postal" maxlength="60" /></td>
            </tr>
          </table>
        </div>
      </fieldset>

      <!--Form Insured List -->
      <fieldset id="form-content">
        <legend>Insured List</legend>
        <br>

        <h1 style="padding-left:0.5em">Vehicle Info</h1>
        <table id="table-form">
          <tr>
            <td>Mileage Declaration : <span style="color:red">*</span></td>
            <td><input type="text" name="INSURED_VEHICLE_MIL" maxlength="60" size="30" /></td>
            <th>&nbsp;</th>
            <td>Engine No.: </td>
            <td><input type="text" name="INSURED_VEHICLE_ENGI" maxlength="60" size="30" /></td>
          </tr>

          <tr>
            <td>Chassis No. : <span style="color:red">*</span> </td>
            <td>
              <select name="INSURED_VEHICLE_CHASSIS">
                <option value="">
                  <-- Please select an option -->
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
            <th>&nbsp;</th>
            <td>Hire Purchase Company : <span style="color:red">*</span></td>
            <td><input type="text" name="INSURED_VEHICLE_COMPANY" maxlength="60" size="30" /></td>
          </tr>
          <tr>
            <td>
              <h1>Upsell List</h1>
            </td>
          </tr>
          <tr>
            <td>Code : <span style="color:red">*</span></td>
            <td>
              <p>CT01</p>
            </td>
            <th>&nbsp;</th>
            <td>Action: <span style="color:red">*</span></td>
            <td>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="Add" name="Upsell_Action" value="Add" checked>
                <label class="form-check-label" for="Add">Add</label>
              </div>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="Remove" name="Upsell_Action" value="Remove">
                <label class="form-check-label" for="Remove">Remove</label>
              </div>
            </td>
          </tr>
        </table>
      </fieldset>

      <!--Form Payment -->
      <fieldset id="form-content">
        <legend>Payment</legend>
        <div class="table">
          <div class="table-header">
            <div class="header__item">Payment Type</div>>
            <div class="header__item">Action</div>
          </div>
          <div class="table-content">
            <div class="table-row" style="padding:10px 0px;" <?php if ($url_online_payment == '') {
                                                                echo $hide;
                                                              } ?>>
              <div class="table-data">Online Payment Gateway </div>
              <div class="table-data"><button type="button" class="button payment" id="btnPaymentOnline" onclick="window.open('<?php echo $url_online_payment; ?>')">Payment</button>
              </div>
            </div>
          </div>
        </div>
        <br>
        <h1 style="padding-left:0.5em">Additional</h1>
        <table id="table-form">
          <tr>
            <td>Payment Mode : <span style="color:red">*</span> </td>
            <td>
              <select name="Payment_Mode">
                <option value="">
                  <-- Please select an option -->
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
          </tr>
          <tr>
            <td style="float:inline-start">Payment Frequency : <span style="color:red">*</span></td>
            <td>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="Payment_Frequency" name="Payment_Frequency" value="Annual" checked>
                <label class="form-check-label" for="Payment_Frequency">Annual</label>
              </div>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="Payment_Frequency" name="Payment_Frequency" value="Monthly">
                <label class="form-check-label" for="Payment_Frequency">Monthly</label>
              </div>
            </td>
          </tr>
          <tr>
            <td>Card Type : <span style="color:red">*</span> </td>
            <td>
              <select name="Card_Type">
                <option value="">
                  <-- Please select an option -->
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
          </tr>
        </table>
      </fieldset>


      <div style="display: flex; justify-content: center;padding:1em 0px; ">
        <button type="button" class="button payment" id="btnPaymentOnline" onclick="handleForm()">Save</button>
        <button type="button" class="button payment" id="btnPaymentOnline" style="color:#65558F; background-Color:white; border:1px solid white;">Clear</button>
      </div>

    </form>
  </div>


</body>

</html>