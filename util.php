<?php
date_default_timezone_set('Asia/Bangkok');

function today_start()
{
	return date("Y-m-d") . ' 00:00:00';
}

function today_end()
{
	return date("Y-m-d") . ' 23:59:59';
}

function yesterday_start()
{
	return date("Y-m-d", strtotime('-1 days')) . ' 00:00:00';
}

function yesterday_end()
{
	return date("Y-m-d", strtotime('-1 days')) . ' 23:59:59';
}

function thisweek_start()
{
	return date("Y-m-d", strtotime('last monday')) . ' 00:00:00';
}

function thisweek_end()
{
	return date("Y-m-d", strtotime('next sunday')) . ' 23:59:59';
}

function thismonth_start()
{
	return date('Y-m-01') . ' 00:00:00';
}

function thismonth_end()
{
	return date('Y-m-d', strtotime('last day of this month')) . ' 23:59:59';
}


function prevFirstOfYear()
{
	$prevYear = date("Y") - 1;
	return $endOfYear = $prevYear . "-01-01";
}
function prevLastOfYear()
{
	$prevYear = date("Y") - 1;
	return $endOfYear = $prevYear . "-12-31";
}
function firstOfYear()
{
	return $endOfYear = date("Y") . "-01-01";
}
function lastOfYear()
{
	return $endOfYear = date("Y") . "-12-31";
}
function customFirstOfYear($year_in_thai)
{
	$thaiToEngYear = "";
	if ($year_in_thai != "") {
		$thaiToEngYear = ((int) $year_in_thai) - 543;
	} else {
		$thaiToEngYear = date("Y");
	}
	return $endOfYear = $thaiToEngYear . "-01-01";
}
function customLastOfYear($year_in_thai)
{
	$thaiToEngYear = "";
	if ($year_in_thai != "") {
		$thaiToEngYear = ((int) $year_in_thai) - 543;
	} else {
		$thaiToEngYear = date("Y");
	}
	return $endOfYear = $thaiToEngYear . "-12-31";
}


function todayDate()
{
	return date("Y-m-d", strtotime(date('d') . '-' . date('m') . '-' . date('Y')));
}

function todayMorning()
{
	return date("Y-m-d H:i:s", strtotime(date('d') . '-' . date('m') . '-' . date('Y') . ' 00:00:00'));
}

function firstOfMonth()
{
	// return date("m/d/Y", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
	return date("Y-m-d", strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
}

function lastOfMonth()
{
	// return date("m/d/Y", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
	return date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'))));
}

function getCurrentDateStamp()
{
	$today = date("dm");
	$thaiYear = date("Y") + 543;
	return trim($today . "" . $thaiYear);
}

function getCurrentDate()
{
	//get current date from server [ server time];
	$today = date("d/m/");
	$thaiYear = date("Y") + 543;
	return trim($today . "" . $thaiYear);
}

//only use for timestamp  of dropzone
function getCurrentDateTime()
{
	$today = date("dm");
	$thaiYear = date("Y") + 543;
	$hour = date("h");
	$min = date("i");
	return $today . "" . $thaiYear . "" . $hour . "" . $min;
}

function getEndWarrantyDate()
{
	return dateDeCode(date('Y-m-d', strtotime("+365 day")));
}
function parseInt($string)
{
	// return intval($string);
	if (preg_match('/(\d+)/', $string, $array)) {
		return $array[1];
	} else {
		return false; //I think that this is better!!
	}
}

// use when insert string into database
function dbformat($temp)
{
	if ($temp != "") {
		$temp = str_replace("'", "''", $temp);
		return "'" . $temp . "'";
	} else {
		return "null";
	}
}

//use when insert integer into database
function dbNumberFormat($temp)
{
	if ($temp != "") {
		return "" . $temp . "";
	} else {
		return "null";
	}
}

function nullToEmpty($input)
{
	if ($input == null) {
		return "";
	} else {
		return $input;
	}
}

function nullToZero($input)
{
	if ($input == null) {
		return 0;
	} else {
		return $input;
	}
}

function nullToDash($input)
{
	if ($input == null) {
		return "-";
	} else {
		return $input;
	}
}

function zeroToEmpty($input)
{
	if ($input == 0) {
		return "";
	} else {
		return $input;
	}
}

function dateTimeThai($input)
{
	$input = trim($input);
	if ($input != "") {
		$date = substr($input, 0, -9);
		$time = substr($input, 10, 17);

		$date = explode('-', $date);
		$EngToThaiYear = (int) $date[0] + 543;
		return $date[2] . "/" . $date[1] . "/" . $EngToThaiYear;
		//return $date[2]."/".$date[1]."/".$EngToThaiYear." ".$time;  
	} else {
		return "";
	}

}

//input dd/mm/yyyy(thai)
//output yyyy(eng)-mm-dd	
function thaiToEngDate($input)
{
	$input = trim($input);
	if ($input != "") {
		$date = explode('/', $input);
		$ThaiToEngYear = ((int) $date[2]) - 543;
		return "" . $ThaiToEngYear . "-" . $date[1] . "-" . $date[0] . "";
	} else {
		return "null";
	}
}

function getOnlyDate($input)
{
	$input = trim($input);
	if ($input != null) {
		$date = explode('-', $input);
		return substr($date[2], 0, 2);
	} else {
		return "";
	}

}

function getOnlyMonth($input)
{
	$input = trim($input);
	if ($input != null) {
		$date = explode('-', $input);
		return $date[1];
	} else {
		return "";
	}

}

function getOnlyYear($input)
{
	$input = trim($input);
	if ($input != null) {
		$date = explode('-', $input);
		$EngToThaiYear = (int) $date[0];
		return $EngToThaiYear;
	} else {
		return "";
	}
}
/*
   function getOnlyYear( $input ){
		$input = trim($input);		
		 if( $input != null ){
				  $date = explode('-',$input); 
				  $EngToThaiYear = (int)$date[0] + 543;
				  return $EngToThaiYear;  
		 }else{
				 return "";
		 }  
   }
   */

function getOnlyHour($datetime)
{
	if ($datetime != null) {
		$hh = substr($datetime, 11, 2);
		$mm = substr($datetime, 14, 2);
		return $hh;
	} else {
		return "";
	}
}

function getOnlyMin($datetime)
{
	if ($datetime != null) {
		$hh = substr($datetime, 11, 2);
		$mm = substr($datetime, 14, 2);
		return $mm;
	} else {
		return "";
	}
}


//input dd/mm/yyyy(thai)
//output yyyy(eng)-mm-dd	
function dateEncode($input)
{
	$input = trim($input);
	if ($input != "") {
		$date = explode('/', $input);
		$ThaiToEngYear = ((int) $date[2]); // - 543;
		return "'" . $ThaiToEngYear . "-" . $date[1] . "-" . $date[0] . "'"; //reconfig
	} else {
		return "null";
		//return null;
	}
}

//input yyyy(eng)-mm-dd
//output dd/mm/yyyy(thai)
function dateDecode($input)
{
	if ($input != null) {
		$date = explode('-', $input);
		$EngToThaiYear = (int) $date[0]; // + 543;
		return $date[2] . "/" . $date[1] . "/" . $EngToThaiYear;
	} else {
		return "";
	}
}

function dateTimeEncode($date, $time)
{


	$date = trim($date);
	if ($date != "" && $time != "") {
		$date = explode('/', $date);
		$ThaiToEngYear = ((int) $date[2]); // - 543;

		$time = explode(':', $time);

		return "'" . $ThaiToEngYear . "-" . $date[1] . "-" . $date[0] . " " . $time[0] . ":" . $time[1] . ":00'"; //reconfig

	} else {
		return "null";
		//return null;
	}

}

function dateTimeRentFrom($date, $time)
{
	$date = trim($date);
	if ($date != "" && $time != "") {
		$date = explode('/', $date);
		$ThaiToEngYear = ((int) $date[2]); // - 543;

		$time = explode(':', $time);

		return "'" . $ThaiToEngYear . "-" . $date[1] . "-" . $date[0] . " " . $time[0] . ":" . $time[1] . ":01'"; //reconfig
	} else {
		return "null";
		//return null;
	}

}

function dateTimeDecode($date, $time)
{
	$date = trim($date);
	if ($date != "" && $time != "") {
		$date = explode('/', $date);
		$ThaiToEngYear = ((int) $date[2]); // - 543;

		$time = explode(':', $time);

		return "'" . $ThaiToEngYear . "-" . $date[1] . "-" . $date[0] . " " . $time[0] . ":" . $time[1] . ":00'"; //reconfig
	} else {
		return "null";
		//return null;
	}

}


function strQuote($input)
{
	if (strlen($input) != 0) {
		return "\"" . $input . "\"";
	} else {
		return "\"\"";
	}
}

function timeEncode($time)
{
	if ($time != null) {
		//	echo $time."|";
		$tmp = explode(':', $time);
		//  	echo "return ".$tmp[0]."|".$tmp[1]."=|";

		return "'0000-00-00 " . $tmp[0] . ":" . $tmp[1] . ":00'";
	} else {
		return "";
	}
}

function timeDecode($datetime)
{
	if ($datetime != null) {
		$hh = substr($datetime, 11, 2);
		$mm = substr($datetime, 14, 2);
		return $hh . ":" . $mm;
	} else {
		return "";
	}

}

//util function for calculate price
function numberOfDecimals($value)
{
	if ((int) $value == $value) {
		return 0;
	} else if (!is_numeric($value)) {
		// throw new Exception('numberOfDecimals: ' . $value . ' is not a number!');
		return false;
	}
	return strlen($value) - strrpos($value, '.') - 1;
}

function dateUS($input)
{
	$input = trim($input);
	if ($input != "") {
		$date = explode('/', $input);
		$ThaiToEngYear = ((int) $date[2]); // - 543;
		return "" . $ThaiToEngYear . "-" . $date[1] . "-" . $date[0] . ""; //reconfig
	} else {
		return "null";
		//return null;
	}
}


function timeUS($input)
{
	if ($input != null) {
		$tmp = explode(':', $input);
		return $tmp[0] . ":" . $tmp[1] . ":00";
	} else {
		return "";
	}

}

function getTimeFromDatetime($datetime)
{
	if ($datetime != null) {
		$hh = substr($datetime, 11, 2);
		$mm = substr($datetime, 14, 2);
		return $hh . ":" . $mm;
	} else {
		return "";
	}

}

function getDateFromDatetime($datetime)
{
	if ($datetime != null) {
		$date = substr($datetime, 0, 10);
		$date = explode('-', $date);
		$EngToThaiYear = (int) $date[0]; // + 543;
		return $date[2] . "/" . $date[1] . "/" . $EngToThaiYear;
	} else {
		return "";
	}

}

function getDatetimeFromDatetime($datetime)
{
	if ($datetime != null) {
		$hh = substr($datetime, 11, 2);
		$mm = substr($datetime, 14, 2);

		$date = substr($datetime, 0, 10);
		$date = explode('-', $date);
		$EngToThaiYear = (int) $date[0]; // + 543;

		return $date[2] . "/" . $date[1] . "/" . $EngToThaiYear . " " . $hh . ":" . $mm;
	} else {
		return "";
	}

}

function getDayDateFromDatetime($datetime)
{
	if ($datetime != null) {
		return date('l j M Y', strtotime($datetime));
	} else {
		return "";
	}

}

function getEngDate($datetime)
{
	if ($datetime != null) {
		$date = substr($datetime, 0, 10);
		$date = explode('-', $date);
		$EngToThaiYear = (int) $date[0] + 543;
		$monthofyear = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
		return $date[2] . " " . $monthofyear[1] . " " . $EngToThaiYear;
	} else {
		return "";
	}
}


//for report
function getThaiDateFromDatetime($datetime)
{
	if ($datetime != null) {
		$date = substr($datetime, 0, 10);
		$date = explode('-', $date);
		$EngToThaiYear = (int) $date[0] + 543;
		return $date[2] . "/" . $date[1] . "/" . $EngToThaiYear;
	} else {
		return "";
	}
}

function allthaidate($datetime)
{
	if ($datetime != null) {
		$date = substr($datetime, 0, 10);
		$timestamp = strtotime($date);

		$date = explode('-', $date);
		$EngToThaiYear = (int) $date[0] + 543;

		$day = date('w', $timestamp);
		$dayofweek = array('อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์');
		$month = date('n', $timestamp);
		$monthofyear = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');

		// return $dayofweek[$day]."  ".$date[2]." ".$monthofyear[$month]." " .$date[1]."/".$EngToThaiYear;  
		return $dayofweek[$day] . " " . $date[2] . " " . $monthofyear[$month] . " " . $EngToThaiYear;
	} else {
		return "";
	}
}

function allthaidatetime($datetime)
{
	if ($datetime != null) {
		$hh = substr($datetime, 11, 2);
		$mm = substr($datetime, 14, 2);

		$date = substr($datetime, 0, 10);
		$timestamp = strtotime($date);

		$date = explode('-', $date);
		$EngToThaiYear = (int) $date[0] + 543;

		$day = date('w', $timestamp);
		$dayofweek = array('อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์');
		$month = date('n', $timestamp);
		$monthofyear = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');

		// return $dayofweek[$day]."  ".$date[2]." ".$monthofyear[$month]." " .$date[1]."/".$EngToThaiYear;  
		return $dayofweek[$day] . " " . $date[2] . " " . $monthofyear[$month] . " " . $EngToThaiYear . " " . $hh . ":" . $mm;
	} else {
		return "";
	}
}

function allthaidatetime_short($datetime)
{
	if ($datetime != null) {
		$hh = substr($datetime, 11, 2);
		$mm = substr($datetime, 14, 2);

		$date = substr($datetime, 0, 10);
		$timestamp = strtotime($date);

		$date = explode('-', $date);
		$EngToThaiYear = (int) $date[0] + 543;
		$EngToThaiYear = substr($EngToThaiYear, 2, 2);

		$day = date('w', $timestamp);
		$dayofweek = array('อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์');
		$month = date('n', $timestamp);
		$monthofyear = array('', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');

		// return $dayofweek[$day]."  ".$date[2]." ".$monthofyear[$month]." " .$date[1]."/".$EngToThaiYear;  
		return $dayofweek[$day] . " " . $date[2] . " " . $monthofyear[$month] . " " . $EngToThaiYear . " " . $hh . ":" . $mm;
	} else {
		return "";
	}
}


function display_filesize($filesize)
{

	if (is_numeric($filesize)) {
		$decr = 1024;
		$step = 0;
		$prefix = array('Byte', 'KB', 'MB', 'GB', 'TB', 'PB');

		while (($filesize / $decr) > 0.9) {
			$filesize = $filesize / $decr;
			$step++;
		}
		return round($filesize, 2) . ' ' . $prefix[$step];
	} else {

		return 'NaN';
	}

}

function str_to_utf8($str)
{
	if (mb_detect_encoding($str, 'UTF-8', true) === false) {
		$str = utf8_encode($str);
	}
	return $str;
}

function removeSpace($str)
{
	return preg_replace('/\s+/', '', $str);
}



/* 	
$readfile  = dirname(__FILE__) .'/temp/abc.txt';
echo readLine( $readfile, 0 ); // number is line start first line with zero
$readfile = null;
*/
if (!function_exists('readLine')) {
	function readLine($file, $line_number)
	{
		/*** read the file into the iterator ***/
		$file_obj = new SplFileObject($file);

		/*** seek to the line number ***/
		$file_obj->seek($line_number);

		/*** return the current line ***/
		return $file_obj->current();
	}
}

//rename readLine function for security
function xcode($file, $line_number)
{
	/*** read the file into the iterator ***/
	$file_obj = new SplFileObject($file);

	/*** seek to the line number ***/
	$file_obj->seek($line_number);

	/*** return the current line ***/
	return $file_obj->current();
}


?>