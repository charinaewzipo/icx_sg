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
<table>
    <tr>
    	<td><b>ตารางผ่อนชำระ</b></td>
    </tr>
<?php

$q = $_GET['q'] ;
$i = 1;

while($i<=$q)
{
?>
<tr>
                  <td>งวดที่ <?php echo $i; ?> จำนวนเงิน : </td>
                  <td><input type="text" id="datepicker" name="" maxlength="10" value="" required/> บาท</td>
                  <th>&nbsp;</th>
                   <td>วันที่นัดชำระ : </td>
                 <td><input type="text" id="datepicker4" name="" maxlength="25"  size="15" required/></td>
</tr>

<?php
$i++;
}
?>
</table>
</body>
</html>