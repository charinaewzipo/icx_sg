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
<select name="Sub_district1" id="Sub_district1" required >
<option value=""><-- โปรดระบุ --></option>
<?php

$q = $_GET['q'] ;
$q2 = $_GET['q2'] ;


											$strSQL = "SELECT SUBDISTRICT_TH FROM t_aig_address where DISTRICT_TH = '$q' and PROVINCE_TH = '$q2' GROUP BY SUBDISTRICT_TH ORDER BY SUBDISTRICT_TH ASC ";
											//echo  $strSQL;
                                            $objQuery = mysqli_query($Conn, $strSQL);
                                            while($objResuut = mysqli_fetch_array($objQuery))
                                            {
                                            ?>
                                            
                                            <option value="<?php echo $objResuut["SUBDISTRICT_TH"];?>"><?php  echo $objResuut["SUBDISTRICT_TH"];?></option>
                                            <?php
                                            }


?>
</select>
</body>
</html>