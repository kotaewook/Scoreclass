<?php
$basename = basename($_SERVER["PHP_SELF"]);

if( $basename == "live_soccer.php" )
	$tabmenu01 = "on";
	
if( $basename == "live_baseball.php" )
	$tabmenu02 = "on";
	
if( $basename == "live_basketball.php" )
	$tabmenu03 = "on";

if($country == 'ko')
	$week = array('일','월','화','수','목','금','토');
elseif($country == 'en')
	$week = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
else
	$week = array('日', '月', '火', '水', '木', '金', '土');

if(!$date) $date = G5_TIME_YMD;

$center_date = intval( (strtotime(G5_TIME_YMD) - strtotime($date) ) / 86400);
$start_date = $center_date * -1;
$finish_date = $center_date * -1;
?>