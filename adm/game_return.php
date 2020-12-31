<?php include_once('./_common.php');
$rs = sql_query("select gl_id from {$g5['game_list']} where gl_fight_id = '{$gl_fight_id}'");
while($row = sql_fetch_array($rs)){
	$sb = sql_query("select * from {$g5['batting']} where bt_game like '%{$row['gl_id']}^%' and bt_status = 1");
	while($sub = sql_fetch_array($sb)){
		$bt_point = $sub['bt_point'];
		$bt_dividend = $sub['bt_dividend'];

		$rt_pt = round_down($bt_point * $bt_dividend, 2);

		if($rt_pt > 10000000000)
			$rt_pt = 10000000000;

		point_log('rp', $rt_pt * -1, $sub['mb_id'], $sub['mb_id'], 404);

		sql_query("update {$g5['batting']} set bt_status = '0', bt_dividend = '{$bt_dividend}' where bt_id = '{$sub['bt_id']}'");
	}

	sql_query("update {$g5['game_list']} set gl_status = '0' where gl_id = '{$row['gl_id']}'");
}

alert('경기종료가 취소되었습니다.', '/adm/game_list.php');
?>