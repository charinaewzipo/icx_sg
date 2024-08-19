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
<select name="car_engine" id="car_engine" required onchange="">
<option value=""><-- โปรดระบุ --></option>
<?php

$q = $_GET['q'] ;


											$strSQL = "SELECT car_engine FROM t_motor_premium where car_model = '$q' GROUP BY car_engine ";
											echo  $strSQL;
                                            $objQuery = mysql_query($strSQL);
                                            while($objResuut = mysql_fetch_array($objQuery))
                                            {
                                            ?>
                                            <option value="<?php echo $objResuut["car_engine"];?>"><?php  echo $objResuut["car_engine"];?></option>
                                            <?php
                                            }


?>
</select>
</body>
</html>