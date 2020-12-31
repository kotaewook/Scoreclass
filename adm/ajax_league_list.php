<?php include_once('./_common.php');

if($gl_type == 0)
	$table = $g5['soccer_leagues'];
elseif($gl_type == 1)
	$table = $g5['baseball_leagues'];
elseif($gl_type == 2)
	$table = $g5['basketball_leagues'];
elseif($gl_type == 3)
	$table = $g5['volleyball_leagues'];
elseif($gl_type == 4)
	$table = $g5['hockey_leagues'];

$cnt = sql_fetch("select count(*) as cnt from {$table} where lg_en_name like '%{$lg_en_name}%' or lg_ko_name like '%{$lg_en_name}%' or lg_ja_name like '%{$lg_en_name}%' or lg_ch_name like '%{$lg_en_name}%' group by lg_id ");
$rs = sql_query("select lg_id, lg_en_name".($country != 'en' ? ", lg_{$country}_name as lg_name" : '').", lg_country from {$table} where lg_en_name like '%{$lg_en_name}%' or lg_ko_name like '%{$lg_en_name}%' or lg_ja_name like '%{$lg_en_name}%' or lg_ch_name like '%{$lg_en_name}%' group by lg_id order by lg_en_name asc");

if($cnt['cnt'] == 0)
	echo json_encode('fail');
else {
	for($i=0; $row = sql_fetch_array($rs); $i++){
		$list[$i]['lg_id'] = $row['lg_id'];
		$list[$i]['lg_en_name'] = trim($row['lg_name'])!=''?$row['lg_name']:$row['lg_en_name'];
		$list[$i]['lg_country'] = $row['lg_country'];
	}

	echo json_encode($list);
}
?>