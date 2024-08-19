<?php

ob_start();

include("../../function/currentDateTime.inc");
include("../../function/StartConnect.inc");

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
<select name="payment_account" id="payment_account" required>
<option value=""><-- โปรดระบุ --></option>
<?php


$q = $_GET['q'] ;
$insurer = $_GET['insurer'] ;

echo  $insurer ;

if($q == 'ARK INSURE'){
	$company = 'ARK INSURE' ;
}else{
	$company = $insurer ;
}




											$strSQL = "SELECT * FROM t_motor_acc_payment where company = '$company' and active = '1' ORDER BY bank_name ASC ";
											echo  $strSQL;
                                            $objQuery = mysql_query($strSQL);
                                            while($objResuut = mysql_fetch_array($objQuery))
                                            {
                                            ?>
                                            
                                            <option value="<?php echo $objResuut["bank_name"];?> <?php echo $objResuut["bank_brance"];?> <?php echo $objResuut["bank_account_no"];?> "><?php echo $objResuut["bank_name"];?> <?php echo $objResuut["bank_brance"];?> <?php echo $objResuut["bank_account_no"];?></option>
                                            <?php
                                            }


?>
</select>
</body>
</html>