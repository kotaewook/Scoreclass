<?php include_once('./_common.php');

if($gl_type == 0)
	$table = $g5['soccer_teams'];
elseif($gl_type == 1)
	$table = $g5['baseball_teams'];
elseif($gl_type == 2)
	$table = $g5['basketball_teams'];
elseif($gl_type == 3)
	$table = $g5['volleyball_teams'];
elseif($gl_type == 4)
	$table = $g5['hockey_teams'];

$cnt = sql_fetch("select count(*) as cnt from {$table} where tm_en_name like '%{$tm_name}%' or tm_ko_name like '%{$tm_name}%' or tm_ja_name like '%{$tm_name}%' or tm_ch_name like '%{$tm_name}%' group by tm_id ");
$rs = sql_query("select * from {$table} where tm_en_name like '%{$tm_name}%' or tm_ko_name like '%{$tm_name}%' or tm_ja_name like '%{$tm_name}%' or tm_ch_name like '%{$tm_name}%' group by tm_id order by tm_en_name asc");

if($cnt['cnt'] == 0)
	echo json_encode('fail');
else {
	for($i=0; $row = sql_fetch_array($rs); $i++){
		$list[$i]['tm_id'] = $row['idx'];
		$list[$i]['tm_name'] = trim($row['tm_'.$country.'_name'])!=''?$row['tm_'.$country.'_name']:$row['tm_en_name'];
		$list[$i]['tm_country'] = $row['tm_country'];
	}

	echo json_encode($list);
}
?>