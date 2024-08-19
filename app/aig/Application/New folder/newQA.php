<?php

ob_start();
session_start();

require_once("../../function/currentDateTime.inc");
require_once("../../function/StartConnect.inc");
require_once("../../../class/Encrypt.php");

$agent_id = $_SESSION["pfile"]["uid"];
$lv = $_SESSION["pfile"]["lv"];
echo "<script>var user_lv = $lv;</script>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/stylesheet.css?v=<?=time();?>" type="text/css" />

<link href="../../css/smoothness/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css"/>

<script src="../../scripts/jquery-2.2.4.min.js"></script>
<script src="../../scripts/jquery-ui.min.js"></script>
<script src="../../scripts/jquery.validate.min.js"></script>
<title>QA Form</title>

<script type="text/javascript" src="../scripts/function.js?v=<?=time();?>"></script>
<SCRIPT type="text/javascript" src="js/qa.js?v=<?=time();?>"></script>

<SCRIPT type=text/javascript>
	$(function() {
		$('#datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			isBuddhist: true
			
		});
	});

</SCRIPT>

</head>

<body>

	<?php

	$app_id = $_GET["id"];

  $qaReadonly = ($lv == 7)?"readonly":"";

  $submitFlag = (!in_array($lv,[3,7]))?"disabled":"";

    $agent_id = $_SESSION["pfile"]["uid"];
		$strSQL2 = "SELECT * FROM t_agents WHERE agent_id = '$agent_id' ";
		$result2= mysql_query($strSQL2);
		while($objResult2 = mysql_fetch_array($result2))
		{
			$qa_first_name = $objResult2["first_name"] ;
			$qa_last_name = $objResult2["last_name"] ;
		}


        $strSQL3 = "SELECT *,COALESCE(CONCAT(campaign.plancode,ProposalNumber),ProposalNumber) as quotation FROM t_aig_app app LEFT OUTER JOIN  t_campaign campaign ON app.campaign_id = campaign.campaign_id  WHERE id = '$app_id' ";
		$result3= mysql_query($strSQL3);
		while($objResult3 = mysql_fetch_array($result3))
		{		
            $cust_title = $objResult3["TITLE"];
            $cust_first_name = $objResult3["FIRSTNAME"];
            $cust_last_name = Encryption::decrypt($objResult3["LASTNAME"]);
            $campaign_id = $objResult3["campaign_id"];
            $tsr_id = $objResult3["agent_id"];
            $PRODUCT_NAME = $objResult3["PRODUCT_NAME"];
            $sale_date = $objResult3["create_date"];
            $app_no = $objResult3["quotation"];
		}

		$strSQL2 = "SELECT * FROM t_agents WHERE agent_id = '$tsr_id' ";
		$result2= mysql_query($strSQL2);
		while($objResult2 = mysql_fetch_array($result2))
		{
			$tsr_first_name = $objResult2["first_name"] ;
			$tsr_last_name = $objResult2["last_name"] ;
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
                    	<td><h1>TSR Name : </h1></td>
                        <td><?php echo $tsr_first_name ;?>&nbsp;<?php echo $tsr_last_name ;?></td>
                    </tr>
                    <tr>
                    	<td><h1>Application No. : </h1></td>
                        <td><?php echo $app_no ;?></td>
                    </tr>
                    <tr>
                    	<td><h1>Sale Date : </h1></td>
                        <td><?php echo $sale_date ;?></td>
                    </tr>
                    <tr>
                    	<td><h1>Customer Name : </h1></td>
                        <td><?php echo $cust_title ;?><?php echo $cust_first_name ;?>&nbsp;<?php echo $cust_last_name ;?></td>
                    </tr>
                    <tr class="qc_score">
                    	<td><h1>QC Score : </h1></td>
                      <td></td>
                    </tr>
                    <tr class="qa_score">
                    	<td><h1>QA Score : </h1></td>
                      <td></td>
                    </tr>
            </table>
            <br/>
          </div>
          
            <div id="user-detail">
            <table align="right">
            	<tr>
                	<td><h1>วันที่ประเมิน : </h1></td>
                    <td><?php echo "$currentdate_app" ?></td>
                    <td>&nbsp;</td>
                    <td><h1>ผู้ประเมิน : </h1></td>
                    <td><?php echo $qa_first_name ;?>&nbsp;<?php echo $qa_last_name ;?></td>
                </tr>
            </table>
            </div>
        </div>
    <form name="App" method="post" action="newQA_save.php">

<?php
$count = 0;
$answer = 0;
$current_section = "";
$section_name = "";
$end_tab = "";
$check_section = 0;
$strSQL = "SELECT * FROM t_aig_qa_form where section in( 1,2,3) and form_id = '1' ORDER BY section,sequence ASC";
$objQuery = mysql_query($strSQL);
while($objResuut = mysql_fetch_array($objQuery))
{
  $form_id = $objResuut["form_id"];
  if($current_section != $objResuut["section"]){
      $current_section = $objResuut["section"];
      if($current_section == 1) {
          $section_name= "1.  การแนะนำตัว, การนำเสนอโครงการและตอบข้อโต้แย้ง ";
      } else if($current_section == 2) {
          $end_tab = "</table></fieldset>";
          $section_name= "2. การลงทะเบียน ";
      } else if($current_section == 3) {
          $end_tab = "</table></fieldset>";
          $section_name= "3. สรุปการขาย Legal Statement ";
      }
      echo $end_tab;
      ?>        
          <!-- Tab 1-->
          <br/>
          
          <fieldset id="form-content">
          <h1><?php echo $section_name; ?></h1><br/>
              <table id="table-form" style="width: 100%; border-collapse: collapse; border: 1px solid;">
                      <tr style="width: 100%; background-color: #001871; color: #fff; border: 1px solid;">
                      <td style="width: 5%; padding: 5px">#</td>
                      <td style="width: 40%; padding: 5px">รายละเอียดตรวจสอบ</td>
                      <td style="width: 10%; padding: 5px">ประเภท</td>
                      <td style="width: 15%; padding: 5px">ดำเนินการ</td>
                      <td class="qc_answer" style="width: 10%; padding: 5px">ผลการตรวจ (QC)</td>
                      <td class="qa_answer" style="width: 10%; padding: 5px">ผลการตรวจ (QA)</td>
                      </tr>
                      <?php
  }
  $count = $count + 1;
?>

          <tr>
            <input type="hidden" name="score<?php echo $count;?>" value="<?php echo $objResuut["score"];?>"/>
            <td style="border: 1px solid; padding: 5px"><?php echo $count;?></td>
            <td style="border: 1px solid; padding: 5px"><?php echo $objResuut["evaluate"];?></td>
            <td style="border: 1px solid; padding: 5px"><?php echo $objResuut["type"];?></td>
            <td style="border: 1px solid; padding: 5px"><?php echo $objResuut["action"];?></td>
            <td style="border: 1px solid; padding: 5px" class="qc_answer">
              <input type="radio" checked id="true<?php echo $count;?>" name="answer<?php echo $count;?>" value="true">
              <label for="true<?php echo $count;?>">ผ่าน</label><br><br>
              <input type="radio" id="fault<?php echo $count;?>" name="answer<?php echo $count;?>" value="fault">
              <label for="fault<?php echo $count;?>">ไม่ผ่าน</label>
            </td>
            <td style="border: 1px solid; padding: 5px" class="qa_answer">
              <input type="radio" checked id="true_qa<?php echo $count;?>" name="qaanswer<?php echo $count;?>" value="true">
              <label for="true_qa<?php echo $count;?>">ผ่าน</label><br><br>
              <input type="radio" id="fault_qa<?php echo $count;?>" name="qaanswer<?php echo $count;?>" value="fault">
              <label for="fault_qa<?php echo $count;?>">ไม่ผ่าน</label>
            </td>
          </tr>
<?php 
}
?>
            </table>
	    </fieldset>
        <br /> 
        <!-- end Tab 3-->

		<div style="display:none;">
				<fieldset id="form-content">
					Remark :
					<textarea rows="10" name="remark" cols="100"></textarea>
				</fieldset>
		</div>
    <div>
				<fieldset id="form-content">
					Reconfirm :
					<textarea rows="10" name="reconfirm" cols="100" <?php echo $qaReadonly ?>></textarea>
				</fieldset>
		</div>
    <div>
				<fieldset id="form-content">
					Feedback :
					<textarea rows="10" name="feedback" cols="100" <?php echo $qaReadonly ?>></textarea>
				</fieldset>
		</div>
    <div>
				<fieldset id="form-content">
					Comment :
					<textarea rows="10" name="comment" cols="100" <?php echo $qaReadonly ?>></textarea>
				</fieldset>
		</div>
    <br /> 
        
        <div>
        <fieldset id="form-content">
        	<table id="table-form">
               <tr>
               <td>Talk Time &nbsp;</td>
               <td><input type="text" name="talk_time" value="" placeholder="hh:mm:ss" /></td>
              <td width="100px"></td>
				  <td>Application Status &nbsp;</td>
                  <td><select name="QAStatus" >
                  <?php
                      $statusSQL = "select * from t_app_status where level='".$lv."' and role='qa'";
                      $status = mysql_query($statusSQL, $Conn) or die("ไม่สามารถเรียกดูข้อมูลได้");
                      while ($st = mysql_fetch_array($status)) {
                          echo "<option value=\"".$st["status"]."\">".$st["status"]."</option>";
                      }
                      ?>
                  </select></td>

                  <input type="hidden" name="app_id" value="<?php echo $app_id; ?>" />
                  <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>" />
				          <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
                  <input type="hidden" name="form_id" value="<?php echo $form_id; ?>" />
                  
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td><input name="Submit" type="submit" <?php echo $submitFlag; ?> value=" Save " /></td>
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
