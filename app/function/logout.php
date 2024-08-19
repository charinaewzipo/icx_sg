<?php //logout.php
session_start();
session_destroy(); //Clear Session

header("Location: ../login.php");
?>
