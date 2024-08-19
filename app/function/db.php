<?php
require_once 'settings.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");

extract($_GET);
extract($_POST);

function get_data_mysql($query){
	$mysqli_server = $GLOBALS["db_server"];
	$mysqli_username = $GLOBALS["db_user"];
	$mysqli_password = $GLOBALS["db_password"];
	$mysqli_dbname = $GLOBALS["db_database"];
	global $conn_mysql;
	$conn_mysql = mysqli_connect($mysqli_server, $mysqli_username, $mysqli_password, $mysqli_dbname);
	if( $conn_mysql ) {
		$result = mysqli_query($conn_mysql, $query);
		if(mysqli_error($conn_mysql)){
			return 'error:'.mysqli_error($conn_mysql);
		}
		else{
			return $result;
		}
	}
	else{
		return 'error:'.mysqli_connect_error();
	}
}

function get_data_mssql($query){
	$mssql_server = $GLOBALS["app_db_server"];
	$mssql_username = $GLOBALS["app_db_user"];
	$mssql_password = $GLOBALS["app_db_password"];
	$mssql_dbname = $GLOBALS["app_db_database"];

    $dsn = "Driver={SQL Server};Server=$mssql_server;Database=$mssql_dbname;";
    $user = "$mssql_username";
    $password = "$mssql_password";
    
    global $conn_mssql;
    $conn_mssql = odbc_connect($dsn, $user, $password);
    
    if ($conn_mssql) {
        $result = odbc_exec($conn_mssql, $query);
        if (!$result) {
            return 'error:'.odbc_errormsg();
        }
        else{
			return $result;
		}
        odbc_close($conn_mssql);
    } else {
        return 'error:'.odbc_errormsg();
    }
}


?>