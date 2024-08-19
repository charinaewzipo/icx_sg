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
    <link rel="stylesheet" href="css/stylesheet.css?v=<?= time(); ?>" type="text/css" />

    <link href="../../css/smoothness/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />

    <script src="../../scripts/jquery-2.2.4.min.js"></script>
    <script src="../../scripts/jquery-ui.min.js"></script>
    <script src="../../scripts/jquery.validate.min.js"></script>

    <title>QA Form</title>
    <script type="text/javascript" src="../scripts/function.js?v=<?= time(); ?>"></script>
    <SCRIPT type="text/javascript" src="js/qa.js?v=<?= time(); ?>"></script>

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

    $qaReadonly = ($lv != 3) ? "readonly" : "";

    $submitFlag = (!in_array($lv, [3, 7])) ? "disabled" : "";

    $strSQL1 = "SELECT * FROM t_aig_qa_non_sale_answer WHERE app_id = '$app_id' and col_id=1 ";
    $result1 = mysqli_query($Conn, $strSQL1);
    while ($objResult1 = mysqli_fetch_array($result1)) {
        $app_id = $objResult1["app_id"];
        $form_id = $objResult1["form_id"];
        $remark = $objResult1["remark"];
        $talk_time = $objResult1["talk_time"];
        $reconfirm = $objResult1["reconfirm"];
        $feedback = $objResult1["feedback"];
        $comment = $objResult1["comment"];
        $QAStatus = $objResult1["QAStatus"];
        $campaign_id = $objResult1["campaign_id"];
    }

    $agent_id = $_SESSION["pfile"]["uid"];
    $strSQL2 = "SELECT * FROM t_agents WHERE agent_id = '$agent_id' ";
    $result2 = mysqli_query($Conn, $strSQL2);
    while ($objResult2 = mysqli_fetch_array($result2)) {
        $qa_first_name = $objResult2["first_name"];
        $qa_last_name = $objResult2["last_name"];
    }


    $strSQL3 = "SELECT * FROM tubtim.t_aig_app_non_sale WHERE app_id  = '$app_id' ";
    $result3 = mysqli_query($Conn, $strSQL3);
    while ($objResult3 = mysqli_fetch_array($result3)) {
        //$cust_title = $objResult3["TITLE"];
        //$cust_first_name = $objResult3["FIRSTNAME"];
        //$cust_last_name = Encryption::decrypt($objResult3["LASTNAME"]);
        $campaign_id = $objResult3["campaign_id"];
        $tsr_id = $objResult3["agent_id"];
        //$PRODUCT_NAME = $objResult3["PRODUCT_NAME"];
        $sale_date = $objResult3["last_wrapup_dt"];
        //$app_no = $objResult3["quotation"];
    }

    $strSQL2 = "SELECT * FROM t_agents WHERE agent_id = '$tsr_id' ";
    $result2 = mysqli_query($Conn, $strSQL2);
    while ($objResult2 = mysqli_fetch_array($result2)) {
        $tsr_first_name = $objResult2["first_name"];
        $tsr_last_name = $objResult2["last_name"];
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
                        <td>
                            <h1>TSR Name : </h1>
                        </td>
                        <td><?php echo $tsr_first_name; ?>&nbsp;<?php echo $tsr_last_name; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <h1>Application No. : </h1>
                        </td>
                        <td><?php echo $app_id; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <h1>Sale Date : </h1>
                        </td>
                        <td><?php echo $sale_date; ?></td>
                    </tr>
                    <!-- <tr>
                        <td>
                            <h1>Customer Name : </h1>
                        </td>
                        <td><?php echo $cust_title; ?><?php echo $cust_first_name; ?>&nbsp;<?php echo $cust_last_name; ?></td>
                    </tr> -->
                    <tr class="qc_score">
                        <td>
                            <h1>QC Score : </h1>
                        </td>
                        <td></td>
                    </tr>
                    <tr class="qa_score">
                        <td>
                            <h1>QA Score : </h1>
                        </td>
                        <td></td>
                    </tr>
                </table>
                <br />
            </div>

            <div id="user-detail">
                <table align="right">
                    <tr>
                        <td>
                            <h1>วันที่ประเมิน : </h1>
                        </td>
                        <td><?php echo "$currentdate_app" ?></td>
                        <td>&nbsp;</td>
                        <td>
                            <h1>ผู้ประเมิน : </h1>
                        </td>
                        <td><?php echo $qa_first_name; ?>&nbsp;<?php echo $qa_last_name; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <form name="App" method="post" action="QADetail_update_nonsale.php">


            <?php
            $count = 0;
            $answer = 0;
            $current_section = "";
            $section_name = "";
            $end_tab = "";
            $check_section = 0;
            $strSQL = "SELECT * FROM t_aig_qa_form where section in( 1,2,3) and form_id = '$form_id' ORDER BY section,sequence ASC";
            $objQuery = mysqli_query($Conn, $strSQL);
            while ($objResuut = mysqli_fetch_array($objQuery)) {
                if ($current_section != $objResuut["section"]) {
                    $current_section = $objResuut["section"];
                    if ($current_section == 1) {
                        $section_name = "1.  การแนะนำตัว, การนำเสนอโครงการและตอบข้อโต้แย้ง ";
                    } else if ($current_section == 2) {
                        $end_tab = "</table></fieldset>";
                        $section_name = "2. การลงทะเบียน ";
                    } else if ($current_section == 3) {
                        $end_tab = "</table></fieldset>";
                        $section_name = "3. สรุปการขาย Legal Statement ";
                    }
                    echo $end_tab;
            ?>
                    <!-- Tab 1-->
                    <br />

                    <fieldset id="form-content">
                        <h1><?php echo $section_name; ?></h1><br />
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
                    $answer_true = '';
                    $answer_fault = '';
                    $answer_qa_true = '';
                    $answer_qa_fault = '';
                    $strSQL_answer = "SELECT answer$count as answer, col_id, create_by FROM t_aig_qa_non_sale_answer where  app_id = '$app_id' and col_id in(1,2)";
                    //echo $strSQL_answer ;
                    $objQuery_answer = mysqli_query($Conn, $strSQL_answer);
                    while ($objResuut_answer = mysqli_fetch_array($objQuery_answer)) {
                        $col_id = $objResuut_answer["col_id"];
                        $answer = $objResuut_answer["answer"];
                        $create_by = $objResuut_answer["create_by"];
                        //echo $answer;
                        if ($col_id == 1) {
                            if ($answer == 'fault') {
                                $answer_true = '';
                                $answer_fault = 'checked';
                                $style = "color:red;";
                            } else if ($answer == 'true') {
                                $answer_true = 'checked';
                                $answer_fault = '';
                                $style = "";
                            }
                        } else {
                            if ($answer == 'fault') {
                                $answer_qa_true = '';
                                $answer_qa_fault = 'checked';
                            } else if ($answer == 'true') {
                                $answer_qa_true = 'checked';
                                $answer_qa_fault = '';
                            }
                        }
                    }

                        ?>

                        <tr style="<?php echo $style; ?>">
                            <input type="hidden" name="score<?php echo $count; ?>" value="<?php echo $objResuut["score"]; ?>" />
                            <td style="border: 1px solid; padding: 5px"><?php echo $count; ?></td>
                            <td style="border: 1px solid; padding: 5px"><?php echo $objResuut["evaluate"]; ?></td>
                            <td style="border: 1px solid; padding: 5px"><?php echo $objResuut["type"]; ?></td>
                            <td style="border: 1px solid; padding: 5px"><?php echo $objResuut["action"]; ?></td>
                            <td style="border: 1px solid; padding: 5px" class="qc_answer">
                                <input type="radio" id="true<?php echo $count; ?>" name="answer<?php echo $count; ?>" value="true" <?php echo $answer_true; ?>>
                                <label for="true<?php echo $count; ?>">ผ่าน</label><br><br>
                                <input type="radio" id="fault<?php echo $count; ?>" name="answer<?php echo $count; ?>" value="fault" <?php echo $answer_fault; ?>>
                                <label for="fault<?php echo $count; ?>">ไม่ผ่าน</label>
                            </td>
                            <td style="border: 1px solid; padding: 5px" class="qa_answer">
                                <input type="radio" checked id="qatrue_qa<?php echo $count; ?>" name="qaanswer<?php echo $count; ?>" value="true" <?php echo $answer_qa_true; ?>>
                                <label for="true_qa<?php echo $count; ?>">ผ่าน</label><br><br>
                                <input type="radio" id="fault_qa<?php echo $count; ?>" name="qaanswer<?php echo $count; ?>" value="fault" <?php echo $answer_qa_fault; ?>>
                                <label for="fault_qa<?php echo $count; ?>">ไม่ผ่าน</label>
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
                            <textarea rows="10" name="remark" cols="100"><?php echo $remark; ?></textarea>
                        </fieldset>
                    </div>
                    <div>
                        <fieldset id="form-content">
                            Reconfirm :
                            <textarea rows="10" name="reconfirm" cols="100" <?php echo $qaReadonly ?>><?php echo $reconfirm; ?></textarea>
                        </fieldset>
                    </div>
                    <div>
                        <fieldset id="form-content">
                            Feedback :
                            <textarea rows="10" name="feedback" cols="100" <?php echo $qaReadonly ?>><?php echo $feedback; ?></textarea>
                        </fieldset>
                    </div>
                    <div>
                        <fieldset id="form-content">
                            Comment :
                            <textarea rows="10" name="comment" cols="100" <?php echo $qaReadonly ?>><?php echo $comment; ?></textarea>
                        </fieldset>
                    </div>
                    <br />

                    <div>
                        <fieldset id="form-content">
                            <table id="table-form">
                                <tr>
                                    <td>Talk Time &nbsp;</td>
                                    <td><input type="text" name="talk_time" value="<?php echo $talk_time; ?>" placeholder="hh:mm:ss" /></td>
                                    <td width="100px"></td>
                                    <td>Application Status &nbsp;</td>
                                    <td><select name="QAStatus">
                                            <option value="<?php echo $QAStatus; ?>"><?php echo $QAStatus; ?></option>
                                            <?php
                                            $statusSQL = "select * from t_app_status where level='" . $lv . "' and role='qa'";
                                            $status = mysqli_query($Conn, $statusSQL) or die("ไม่สามารถเรียกดูข้อมูลได้");
                                            while ($st = mysqli_fetch_array($status)) {
                                                echo "<option value=\"" . $st["status"] . "\">" . $st["status"] . "</option>";
                                            }
                                            ?>
                                        </select></td>
                                    <input type="hidden" name="app_id" value="<?php echo $app_id; ?>" />
                                    <input type="hidden" name="qc_score" />
                                    <input type="hidden" name="qa_score" />
                                    <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>" />
                                    <input type="hidden" name="form_id" value="<?php echo $form_id; ?>" />
                                    <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />

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