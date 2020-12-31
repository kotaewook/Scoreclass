<?php include_once('./_common.php');

$cnt = sql_fetch("select count(*) as cnt from g5_country where en_name like '%{$lg_en_name}%' or ko_name like '%{$country_name}%' or ja_name like '%{$country_name}%' or ch_name like '%{$country_name}%' ");
$rs = sql_query("select ct_id, en_name".($country != 'en' ? ", {$country}_name as lg_name" : '')." from g5_country where en_name like '%{$country_name}%' or ko_name like '%{$country_name}%' or ja_name like '%{$country_name}%' or ch_name like '%{$country_name}%' order by {$country}_name asc");

if($cnt['cnt'] == 0)
	echo json_encode('fail');
else {
	for($i=0; $row = sql_fetch_array($rs); $i++){
		$list[$i]['ct_id'] = $row['ct_id'];
		$list[$i]['lg_country'] = trim($row['lg_name'])!=''?$row['lg_name']:$row['en_name'];
	}

	echo json_encode($list);
}
?>