<?php
ob_start();
session_start();
include("StartConnect.inc");

$username = $_POST["username"];
$password = $_POST["password"];
$ext = $_POST["ext"];

$SQL = "select * from staff where username = '$username' ";

$result = mysql_query($SQL,$Conn) or die ("ไม่สามารถติดต่อฐานข้อมูลได้");
if($row = mysql_fetch_array($result))
{
	if($row["password"] == $password)
	{
		if($row["active"])
		{
			$_SESSION["username"] = $row["username"];
			$_SESSION["first_name"] = $row["first_name"];
			$_SESSION["last_name"] = $row["last_name"];
			$_SESSION["level_code"] = $row["level_code"];
			$_SESSION["tsr_code"] = $row["tsr_code"];
			$_SESSION["license_code"] = $row["license_code"];
			$_SESSION["group_id"] = $row["group_id"];
			$_SESSION["team_id"] = $row["team_id"];
			$_SESSION["sup_id"] = $row["sup_id"];
			$_SESSION["campaign_id"] = $row["campaign_id"];
			$_SESSION["staff_id"] = $row["staff_id"];
			$_SESSION["license_name"] = $row["license_name"];
			
			$_SESSION["ext"] = $ext;
		
			header("Location: ../home.php");
		}
		else
		{
		$_SESSION["msg"] = "Username ของคุณไม่มีสิทธิ์เข้าใช้งานระบบ";
	    header("Location: ../index.php");	
		}
	}
	else
	{
	$_SESSION["msg"] = "Password ไม่ถูกต้อง";
	header("Location: ../index.php");
	}
}
else
{
	$_SESSION["msg"] = "Username ไม่ถูกต้อง";
	header("Location: ../index.php");
}
include("EndConnect.inc");
ob_end_flush();
?>
