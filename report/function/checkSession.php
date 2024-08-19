<?php /*   CHK SESSION  */
if ($_SESSION["username"] == '') {  ?>
<script type="text/javascript">
	window.location="login.php";
</script>
<?php } ?>
