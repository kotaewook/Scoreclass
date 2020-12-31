<?php include_once('../../common.php');
$row = sql_fetch("select* from {$g5['trade']} a inner join {$g5['batting']} b on a.bt_id = b.bt_id where td_id = '{$td_id}' and b.mb_id != '{$member['mb_id']}' and bt_trade = 1");
if($row){
	if($member['mb_rp'] > $row['td_price']){

		$list_id = explode(',', $row['bt_game']);
		$game_cnt = count($list_id);
		for($j=0; $j<$game_cnt; $j++){
			$gl_id = str_replace('^', '', $list_id[$j]);
			$info = sql_fetch("select gl_datetime from {$g5['game_list']} where gl_id = '{$gl_id}'");
			if($info['gl_datetime'] < strtotime('+5 minutes'))
				alert(lang('배팅내역 구매는 경기시작 5분전 까지 가능합니다.'));
		}

		$mbid = sql_fetch("select mb_id from {$g5['batting']} where bt_id = '{$row['bt_id']}'");
		sql_query("insert into {$g5['batting']} set mb_id = '{$member['mb_id']}', bt_title = '{$row['bt_title']}', bt_game = '{$row['bt_game']}', bt_buy = '{$row['bt_id']}', bt_type_list = '{$row['bt_type_list']}', bt_point = '{$row['bt_point']}', bt_dividend = '{$row['bt_dividend']}', bt_datetime = '".G5_SERVER_TIME."'");
		sql_query("update {$g5['batting']} set bt_trade = 2 where bt_id = '{$row['bt_id']}'");

		sql_query("update {$g5['trade']} set ok_datetime = '".G5_SERVER_TIME."' where td_id = '{$td_id}'");

		point_log('rp', $row['td_price'], $member['mb_id'], $mbid['mb_id'], 300, $td_id);
		point_log('rp', $row['td_price'] * -1, $mbid['mb_id'], $member['mb_id'], 301, $td_id);

		echo json_encode('success');
	} else {
		echo json_encode('money');
	}
} else {
	echo json_encode('fail');
}
?>