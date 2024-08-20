<?php
ob_start();
session_start();
require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
  #ncd-info-container,
  #remark-c-contanier,
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
    border: 2px solid red;
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
  <!-- <script type="text/javascript" src="../scripts/function.js?v=<?= time(); ?>"></script>
  <script type="text/javascript" src="../scripts/jsvalidate.js?v=<?= time(); ?>"></script>
  <script type="text/javascript" src="../scripts/jsvalidateSingapore.js?v=<?= time(); ?>"></script> -->
  <!-- <SCRIPT type="text/javascript" src="js/app.js?v=<?= time(); ?>"></script>  -->
  <script src="../scripts/app_singaporeApplication.js"></script>
  <script src="../scripts/app_singaporeAPI.js"></script>
  <script src="../scripts/singapore_database.js"></script>
  <script src="../scripts/app_singaporePolicy.js"></script>
  <script src="../scripts/app_singaporeForm.js"></script>

  <script>
    const campaignID = <?php echo json_encode($_GET["campaign_id"]); ?>;
  </script>
  <script>
    $(function() {
      $("#datepicker").datepicker({maxDate :new Date()});
      $("#datepicker2").datepicker({maxDate :new Date()});
      $("#datepicker3").datepicker();
      $("#datepicker4").datepicker();
      $("#datepicker5").datepicker({
    minDate: new Date() // Set the minimum date to today
});
      $("#datepicker6").datepicker({
    minDate: new Date() // Set the minimum date to today
});
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

  <?php
  $formType = $_GET["formType"];
  $campaign_id = $_GET["campaign_id"];
  $calllist_id = $_GET["calllist_id"];
  $agent_id = $_GET["agent_id"];
  $import_id = $_GET["import_id"];
  $lv = $_SESSION["pfile"]["lv"];
  ?>

  <div id="content">
    <div id="header"> </div>

    <div id="header-select-type">
      <p class="selectable" data-type=<?php echo $formType ?>><?php echo strtoupper($formType) ?></p>
      <!-- <p class="selectable" data-type="home">HOME</p>
        <p class="selectable" data-type="auto">AUTO</p>
        <p class="selectable" data-type="ah">A&H</p> -->
      <div hidden>
        <div>
          <h2>Select Type</h2>
          <select id="select-type" name="select-type">
            <option value=""><-- Please select a type --></option>
            <option value="home">Home</option>
            <option value="auto">auto</option>
          </select>
        </div>
      </div>

      <div id="category-campaign">
        <div style="display: flex; gap: 10px">
          <div>
            <h2>Select Category</h2>
            <select id="category-select" name="category">
              <option value=""><-- Please select a category --></option>
            </select>
          </div>

          <div id="sub-plan-select">
            <h2>Select Campaign</h2>
            <select id="campaign-select" name="campaign">
              <option value=""><-- Please select a campaign --></option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div id="top-detail">


      <div id="app-detail" style="padding:5px 10px">
        <table>
          <tr>
            <td>
              <h1>Product Name : </h1>
            </td>
            <td><?php echo "$campaign_name ($confirmQuoteType)" ?></td>
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
    <form id="application" novalidate>
      <!--Form PolicyDetail -->
      <div id="confirmQuoteContainer">
        <fieldset id="form-content">
          <table id="table-form">
            <tr>
              <td>PolicyId: <span style="color:red">*</span></td>
              <td><?php echo $Run_no ?>5612367 </td>
              <th></th>
              <td style="white-space:nowrap;">Policy Effective Date: <span style="color:red">*</span></td>
              <td><input type="text" id="datepicker5" name="PolicyEffectiveDate" maxlength="10" required></td>
              <td style="white-space:nowrap;">Policy Expiry Date: <span style="color:red">*</span></td>
              <td><input type="text" id="datepicker6" name="PolicyExpiryDate" maxlength="10" required></td>
            </tr>
            <tr>
              <td>Campaign Code:</td>
              <td>
                <input type="text" id="campaign-code" name="campaignCode" style="max-width: 110px;">
              </td>
              <td></td>
              <td id="remark-c-contanier">RemarksC: </td>
              <td id="remark-c-input" style="white-space:nowrap;">
                <input type="text" name="RemarkCInput" maxlength="10" value="" ?>
              </td>
            </tr>
          </table>
          <div class="table" id="ncd-info-container">
            <table id="table-form">
              <tr>
                <td>
                  <h1>Ncd Info</h1>
                </td>
              </tr>
              <tr>
                <td>Ncd Level: <span style="color:red">*</span> </td>
                <td>

                  <select name="Ncd_Level" id="ncdLevel" onchange="toggleNcdLevel()" style="text-align:center" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'ncdLevel'";
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
                <td id="otherExperience" style="display:none">Other <span style="color:red">*</span> <input type="text" name="otherExperience" maxlength="60" size="30" /></td>
              </tr>
              <tr id="haveExperienceRow" style="display:none">
                <td>Previous Insurer: <span style="color:red">*</span> </td>
                <td>
                  <input type="text" name="haveEx-PreviousInsurer" maxlength="60" size="30" />
                </td>
                <th>&nbsp;</th>
                <td>Previous PolicyNo.: <span style="color:red">*</span> </td>
                <td>
                  <input type="text" name="haveEx-PreviousPolicyNo" maxlength="60" size="30" />
                </td>
              </tr>



            </table>
          </div>

        </fieldset>
      </div>



      <!--Form Individual PolicyHolder Info -->
      <fieldset id="form-content">
        <br>
        <h1 style="padding-left:0.5em">Individual PolicyHolder Info</h1><br>
        <legend>PolicyHolder Info</legend>

        <table id="table-form">
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
              <td>Courtesy Title : <span style="color:red">*</span> </td>
              <td>
                <select name="courtesyTitle" required>
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
            </tr>
            <tr>
              <td>Firstname : <span style="color:red">*</span></td>
              <td><input type="text" name="firstName" maxlength="60" size="30" required /></td>
              <th>&nbsp;</th>
              <td>Lastname : </td>
              <td><input type="text" name="lastName" maxlength="60" size="30" /></td>
            </tr>
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
              <td>Nationality : <span style="color:red">*</span></td>
              <td><input type="text" name="nationality" maxlength="60" size="30" required /></td>
            </tr>
            <tr>
              <td>Date Of Birth : <span style="color:red">*</span></td>
              <td>
                <input type="text" id="datepicker" name="dateOfBirth" maxlength="10" required>
              </td>
              <th>&nbsp;</th>

            </tr>
            <tr>
              <td style="white-space:nowrap">Marital Status : <span style="color:red">*</span> </td>
              <td>
                <select name="maritalStatus" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'maritalStatus'";
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
              <td>CustomerId No. <span style="color:red">*</span></td>
              <td><input type="text" name="customerIdNo" maxlength="60" size="30" required /></td>
            </tr>
            <tr>
              <td>Occupation : <span style="color:red">*</span></td>
              <td>
                <select name="occupation" required>
                  <option value=""> <-- Please select an option --></option>
                  <?php
                  $strSQL = "SELECT name, id, description
FROM tubtim.t_aig_sg_lov 
where name='PA Occupation'";
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
            </tr>

            <tr>
              <td>
                <h1>Contact Info</h1>
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
              <td><input type="text" name="postCode" maxlength="60" required /></td>
            </tr>

            <tr id="isPolicyHolderDrivingRow">
              <td style="float:inline-start">isPolicyHolderDriving : <span style="color:red">*</span></td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="isPolicyHolderDrivingYes" name="isPolicyHolderDriving" value="2" checked>
                  <label class="form-check-label" for="isPolicyHolderDrivingYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="isPolicyHolderDrivingNo" name="isPolicyHolderDriving" value="1">
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
FROM tubtim.t_aig_sg_lov 
where name='PA Nature of Business'";
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
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'dwellingType'";
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
              <td>Flat Type: <span style="color:red">*</span></td>
              <td>
                <select name="insured_home_flatType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'flatType'";
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
              <td>Owner Occupied Type : <span style="color:red">*</span></td>
              <td>
                <select name="insured_home_ownerOccupiedType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'ownerOccupiedType'";
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
              <td>Floor Occupied: <span style="color:red">*</span></td>
              <td>
                <input type="text" name="insured_home_floorOccupied" maxlength="60" required />
              </td>
            </tr>
            <tr>
              <td>Construction Type : <span style="color:red">*</span></td>
              <td>
                <select name="insured_home_constructionType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'constructionType'";
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
              <td>Year Built : </td>
              <td>
                <input type="text" name="insured_home_yearBuilt" maxlength="60" />
              </td>
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
                <input type="text" name="insured_home_insuredPostCode" maxlength="60" required />
              </td>
              <th>&nbsp;</th>
            </tr>

            <tr>
              <td style="float: inline-start;">Smoke Detector Available : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="smokeDetecYes" name="insured_home_smokeDetectorAvailable" value="Yes" checked>
                  <label class="form-check-label" for="smokeDetecYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="smokeDetecNo" name="insured_home_smokeDetectorAvailable" value="No">
                  <label class="form-check-label" for="smokeDetecNo">No</label>
                </div>
              </td>
            </tr>
            <tr>
              <td style="float: inline-start;">Auto Sprinkler : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="autoSprinkYes" name="insured_home_autoSprinklerAvailable" value="Yes" checked>
                  <label class="form-check-label" for="autoSprinkYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="autoSprinkNo" name="insured_home_autoSprinklerAvailable" value="No">
                  <label class="form-check-label" for="autoSprinkNo">No</label>
                </div>
              </td>
            </tr>
            <tr>
              <td style="float: inline-start;">Security System Available : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="securityYes" name="insured_home_securitySystemAvailable" value="Yes" checked>
                  <label class="form-check-label" for="securityYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="securityNo" name="insured_home_securitySystemAvailable" value="No">
                  <label class="form-check-label" for="securityNo">No</label>
                </div>
              </td>
            </tr>
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
              <td>Brand : <span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_vehicle_make" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <option value="BMW">
                    BMW
                  </option>
                  <option value="Toyota">
                    Toyota
                  </option>
                  <option value="Ford">Ford</option>
    <option value="Honda">Honda</option>
    <option value="Chevrolet">Chevrolet</option>
    <option value="Nissan">Nissan</option>
    <option value="Mazda">Mazda</option>

                </select>
              </td>
              <th>&nbsp;</th>
              <td>Model : <span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_vehicle_model" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <option value="52966">
                    52966
                  </option>
                  <option value="52967">
                    52967
                  </option>
                  <option value="52968">
                    52968
                  </option>
                  <option value="52969">52969</option>
    <option value="52970">52970</option>
    <option value="52971">52971</option>
    <option value="52972">52972</option>
    <option value="52973">52973</option>

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
                  <option value="2016">2016</option>
                  <option value="2017">2017</option>
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                </select>

              <th>&nbsp;</th>
              <td>Reg No. : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_vehicle_regNo" maxlength="60" required /></td>
            </tr>
            <tr>
              <td style="float: inline-start;">Insuring With COE : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="Yes" name="insured_auto_vehicle_insuringWithCOE" value="2" checked>
                  <label class="form-check-label" for="Yes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="No" name="insured_auto_vehicle_insuringWithCOE" value="1">
                  <label class="form-check-label" for="No">No</label>
                </div>
              </td>
              <th></th>
              <td>Age Condition Basis : <span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_vehicle_ageConditionBasis" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'ageConditionBasis'";
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
              <td style="float: inline-start;">Off Peak Car : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="Yes" name="insured_auto_vehicle_offPeakCar" value="2" checked>
                  <label class="form-check-label" for="Yes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="No" name="insured_auto_vehicle_offPeakCar" value="1">
                  <label class="form-check-label" for="No">No</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>Vehicle Usage : <span style="color:red">*</span></td>
              <td>
                <input type="text" name="insured_auto_vehicle_vehicleUsage" maxlength="60" required />

              </td>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <td>Mileage Condition : <span style="color:red">*</span></td>
              <td><select name="insured_auto_vehicle_mileageCondition" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'mileageCondition'";
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
              <td>Mileage Declaration : <span style="color:red">*</span></td>
              <td>
                <input type="text" name="insured_auto_vehicle_mileageDeclaration" maxlength="60" required />
              </td>

            </tr>
            <tr>
              <td>Engine No. : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_vehicle_engineNo" maxlength="60" required /></td>
              <th>&nbsp;</th>
              <td>Chassis No. : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_vehicle_chassisNo" maxlength="60" required /></td>
            </tr>
            <tr>
              <td>Hire Purchase Company: <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_vehicle_hirePurchaseCompany" maxlength="60" required /></td>
              <th>&nbsp;</th>
              <td>Declared SI : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_auto_vehicle_declaredSI" maxlength="60" required /></td>
            </tr>
            <tr></tr>
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
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'driverType'";
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
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'driverResidentStatus'";
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
              <td>Driver DOB : <span style="color:red">*</span> </td>
              <td>
                <input type="text" id="datepicker2" name="insured_auto_driverInfo_driverDOB" maxlength="10" required>

            </tr>
            <tr>
              <td>Driver Gender : <span style="color:red">*</span></td>
              <td><select name="insured_auto_driverInfo_driverGender" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'driverGender'";
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
              <td><input type="text" name="insured_auto_driverInfo_driverNationality" maxlength="60" required /></td>
            </tr>
            <tr>
              <td>Driver Marital Status : <span style="color:red">*</span></td>
              <td><select name="insured_auto_driverInfo_maritalStatus" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'driverMaritalStatus'";
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
              <td><input type="text" name="insured_auto_driverInfo_drivingExperience" maxlength="2" size="10" required /> <span>year</span></td>
            </tr>
            <tr>
              <td>Driver Occupation: <span style="color:red">*</span></td>
              <td>
                <select name="insured_auto_driverInfo_occupation" required>
                  <option value=""> <-- Please select an option --></option>
                  <?php
                  $strSQL = "SELECT name, id, description
FROM tubtim.t_aig_sg_lov 
where name='PA Occupation'";
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
              <td style="float: inline-start;">Claim Experience : </td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="insured_auto_driverInfo_claimExperience" name="insured_auto_driverInfo_claimExperience" value="Y" checked onclick="toggleClaimExperience(this)">
                  <label class="form-check-label" for="Yes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="insured_auto_driverInfo_claimExperience" name="insured_auto_driverInfo_claimExperience" value="N" onclick="toggleClaimExperience(this)">
                  <label class="form-check-label" for="No">No</label>
                </div>
              </td>
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
          <br>
        </div>
        <!--Form Insured List (A&H) -->
        <div id="insured-list-ah">
          <table id="table-form">
            <tr>
              <td>
                <h1>Person Info</h1>
              </td>
            </tr>
            <tr>
              <td>Insured Firstname : <span style="color:red">*</span></td>
              <td><input type="text" name="insured_ah_insuredFirstName" maxlength="60" required /></td>
              <th>&nbsp;</th>
              <td>Insured Lastname: <span style="color:red">*</span></td>
              <td><input type="text" name="insured_ah_insuredLastName" maxlength="60" required /></td>
            </tr>
            <tr>
              <td>Insured Resident Status : <span style="color:red">*</span></td>
              <td>
                <select name="insured_ah_insuredResidentStatus" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredResidentStatus'";
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
              <td>Insured Type : <span style="color:red">*</span></td>
              <td>
                <select name="insured_ah_insuredIdType" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredIdType'";
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
              <td>Insured ID Number : <span style="color:red">*</span></td>
              <td>
                <input type="text" name="insured_ah_insuredIdNumber" maxlength="60" required />


              </td>
              <th>&nbsp;</th>
              <td>Insured Gender : <span style="color:red">*</span></td>
              <td>
                <select name="insured_ah_insuredGender" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredGender'";
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
              <td>Insured Date Of Birth : <span style="color:red">*</span></td>
              <td>
                <input type="text" id="datepicker4" name="insured_ah_insuredDateOfBirth" maxlength="60" required />
              </td>

              </td>
              <th>&nbsp;</th>
              <td>Insured Marital Status: <span style="color:red">*</span></td>
              <td>
                <select name="insured_ah_insuredMaritalStatus" required>
                  <option value="">
                    <-- Please select an option -->
                  </option>
                  <?php
                  $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredMaritalStatus'";
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
              <td>Insured Occupation : <span style="color:red">*</span> </td>
              <td>
                <select name="insured_ah_insuredOccupation" required>
                  <option value=""> <-- Please select an option --></option>
                  <?php
                  $strSQL = "SELECT name, id, description
FROM tubtim.t_aig_sg_lov 
where name='PA Occupation'";
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
              <td>Relation To Policyholder : </td>
              <td>
                <select name="insured_ah_relationToPolicyholder">
                  <option value=""> <-- Please select an option --></option>
                  <?php
                  $strSQL = "SELECT name, id, description
FROM tubtim.t_aig_sg_lov 
where name='PH Relation'";
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
              <td>Insured Campaign Code: <span style="color:red">*</span></td>
              <td><input type="text" name="insured_ah_insuredCampaignCode" maxlength="60" required /></td>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <td>Nature Of Business: <span style="color:red">*</span></td>
              <td>
                <select name="insured_ah_natureOfBusiness">
                  <option value=""> <-- Please select an option --></option>
                  <?php
                  $strSQL = "SELECT name, id, description
FROM tubtim.t_aig_sg_lov 
where name='PA Nature of Business'";
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
              <td style="float:inline-end">reservefield1: <span style="color:red; ">*</span></td>
              <td><input type="text" name="insured_ah_reservefield1" maxlength="60" required /></td>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <td style="float:inline-end">reservefield2: <span style="color:red; ">*</span></td>
              <td><input type="text" name="insured_ah_reservefield2" maxlength="60" required /></td>
              <th>&nbsp;</th>
            </tr>
          </table>
        </div>

        <!--Form Insured List Plan info -->
        <div class="table">
          <table id="table-form">
            <tr>
              <td>
                <h1>Plan Info</h1>
              </td>
            </tr>
            <tr>
              <td style="white-space:nowrap">Plan Id : <span style="color:red">*</span> </td>
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
            <tr>
              <td>Cover List</td>
              <td></td>
            </tr>
            <tbody id="coverListBody">
              <tr class="cover-row">
                <td style="padding:0px 30px">Cover Name: <span style="color:red">*</span> </td>
                <td>
                  <select name="plan_cover_list[]" class="planCoverList" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                  </select>
                </td>
                <td style="padding:0px 30px">Cover Code: <span style="color:red">*</span> </td>
                <td style="width:70px">
                  <p class="planCoverCode"></p>
                </td>
                <td>Limit Amount:</td>
                <td>
                  <p class="planCoverLimitAmount"></p>
                  <input type="hidden" class="selectedFlagInput" value="">
                  <p class="coverName" hidden></p>
                </td>

                <td>
                  <button style="color:#65558F; background-Color:white; border:1px solid white; cursor:pointer;float:inline-end;" type="button" class="removeCoverBtn" onclick="removeCoverRow(this)">Remove</button>
                </td>
              </tr>
            </tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>
                <button type="button" class="button add-cover" onclick="addCoverRow()">Add Cover</button>
              </td>
            </tr>
            <tr>
              <td>
                <button type="button" class="button seePlan" id="btnPaymentOnline" style="margin-left: 20px;" onclick="validateAndSubmitFormCallPremium()">See plan</button>
              </td>
            </tr>
          </table>
        </div>



      </fieldset>

      <div id="payment-container" hidden>
        <fieldset id="form-content">
          <legend>Payment</legend>
          <div class="table">
            <div class="table-header">
              <div class="header__item">Payment Type</div>
              <div class="header__item">Action</div>
            </div>
            <div class="table-content">
              <div class="table-row" style="padding:10px 0px;">
                <div class="table-data">Online Payment Gateway </div>
                <div class="table-data">
                  <button type="button" class="button payment" id="btnPayment">Payment</button>
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
                <select name="Payment_Mode" required>
                  <option value=""> <-- Please select an option --> </option>
                  <option value="1001">Credit Card Lump sum</option>
                  <option value="122">Credit Card IPP</option>
                  <option value="124">Recurring Credit Card</option>
                  <option value="209">PayNow</option>
                </select>
              </td>
            </tr>
            <tr>
              <td style="float:inline-start">Payment Frequency : <span style="color:red">*</span></td>
              <td>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="paymentFrequencyAnnual" name="Payment_Frequency" value="1" checked>
                  <label class="form-check-label" for="paymentFrequencyAnnual">Annual</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="paymentFrequencyMonthly" name="Payment_Frequency" value="2">
                  <label class="form-check-label" for="paymentFrequencyMonthly">Monthly</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>Card Type : <span style="color:red">*</span> </td>
              <td>
                <select name="Payment_CardType" required>
                  <option value=""> <-- Please select an option --> </option>
                  <option value="1">Credit Card Lump Sum VISA</option>
                  <option value="2">Credit Card Lump Sum MASTER</option>
                  <option value="3">Credit Card IPP UOB 6 months</option>
                  <option value="4">Credit Card IPP UOB 12 months</option>
                  <option value="5">Credit Card IPP UOB 24 months</option>
                  <option value="6">Credit Card IPP DBS 6 months</option>
                  <option value="7">Credit Card IPP DBS 12 months</option>
                  <option value="8">Credit Card IPP DBS 24 months</option>
                  <option value="9">Recurring Credit Card VISA</option>
                  <option value="10">Recurring Credit Card Master</option>
                  <option value="23">Credit Card Lump Sum Amex</option>
                  <option value="26">Recurring Credit Card Amex</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Card Number : <span style="color:red">*</span> </td>
              <td>
                <input type="text" name="payment_cardNumber" maxlength="60" required />
              </td>
            </tr>
            <tr>
              <td>Expiry Date : <span style="color:red">*</span> </td>
              <td>

                <input type="text" name="payment_expiryDate" id="expiryDate" maxlength="5" size="5" placeholder="MM/YY" required />
              </td>

            </tr>
            <tr>
              <td>Security Code : <span style="color:red">*</span> </td>
              <td>
                <input type="text" name="payment_securityCode" id="securityCode" maxlength="4" size="4" required />
              </td>
            </tr>
          </table>
        </fieldset>
        </div>


        <div style="display: flex; justify-content: center;padding:1em 0px; ">
          <input type="hidden" name="action" id="formAction" value="">
          <button type="submit" class="button payment" id="btnSaveForm">Save</button>
          <!-- <button type="submit" class="button payment" id="btnPaymentOnline" onclick="handleForm()">Save</button> -->
          <!-- <button type="button" class="button payment" id="btnClearForm" style="color:#65558F; background-Color:white; border:1px solid white;">Clear</button> -->
        </div>

    </form>
  </div>



</body>

</html>