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
<select name="zipcode1" id="zipcode1" required >
<?php

$q = $_GET['q'] ;
$q2 = $_GET['q2'] ;
$q3 = $_GET['q3'] ;


$strSQL = "SELECT ZIPCODE FROM t_aig_address where SUBDISTRICT_TH = '$q' and DISTRICT_TH = '$q2' and PROVINCE_TH = '$q3'  GROUP BY ZIPCODE ORDER BY ZIPCODE ASC ";
											echo  $strSQL;
                                            $objQuery = mysqli_query($Conn, $strSQL);
                                            while($objResuut = mysqli_fetch_array($objQuery))
                                            {
                                            ?>
                                            
                                            <option value="<?php echo $objResuut["ZIPCODE"];?>"><?php  echo $objResuut["ZIPCODE"];?></option>
                                            <?php
                                            }


?>
</select>
</body>
</html>