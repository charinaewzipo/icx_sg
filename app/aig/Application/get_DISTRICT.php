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
<select name="district1" id="district1" required >
<option value=""><-- โปรดระบุ --></option>
<?php

$q = $_GET['q'] ;


											$strSQL = "SELECT DISTRICT_TH FROM t_aig_address where PROVINCE_TH = '$q' GROUP BY DISTRICT_TH ORDER BY DISTRICT_TH ASC ";
											echo  $strSQL;
                                            $objQuery = mysqli_query($Conn, $strSQL);
                                            while($objResuut = mysqli_fetch_array($objQuery))
                                            {
                                            ?>
                                            
                                            <option value="<?php echo $objResuut["DISTRICT_TH"];?>"><?php  echo $objResuut["DISTRICT_TH"];?></option>
                                            <?php
                                            }


?>
</select>
</body>
</html>