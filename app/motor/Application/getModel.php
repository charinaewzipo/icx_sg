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
<select name="car_model" id="car_model" required onchange="showCC(this.value)">
<option value=""><-- โปรดระบุ --></option>
<?php

$q = $_GET['q'] ;


											$strSQL = "SELECT car_model FROM t_motor_premium where car_brand = '$q' GROUP BY car_model ORDER BY car_model ASC ";
											echo  $strSQL;
                                            $objQuery = mysql_query($strSQL);
                                            while($objResuut = mysql_fetch_array($objQuery))
                                            {
                                            ?>
                                            
                                            <option value="<?php echo $objResuut["car_model"];?>"><?php  echo $objResuut["car_model"];?></option>
                                            <?php
                                            }


?>
</select>
</body>
</html>