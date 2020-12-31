<?php include_once('../../common.php');
if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'));

$item_chk = sql_fetch("select * from {$g5['my_item']} where mb_id = '{$member['mb_id']}' and it_id  = '3' and it_count > 0");
if(!$item_chk)
	alert(lang('배팅취소권을 구매 후 취소가 가능합니다.'), '/market/view/3');

$trade_chk = sql_fetch("select * from {$g5['trade']} where bt_id = '{$bt_id}'");
if($trade_chk)
	alert(lang('거래소에 등록된 배팅은 취소할 수 없습니다.'), '/exchange/sale_list');

$row = sql_fetch("select * from {$g5['batting']} where bt_id = '{$bt_id}'");
if(!$row || ($row['mb_id'] != $member['mb_id'] && !$is_admin))
	alert(lang('잘못된 접근입니다.'));
else {
	$chk_time = 999999999999;
	$list_id = explode(',', $row['bt_game']);
	$type_id = explode(',', $row['bt_type_list']);

	for($j=0; $j<$game_cnt; $j++){		
		if($chk_time  > (int) strtotime($info['gl_datetime']) )
			$chk_time = strtotime($info['gl_datetime']);
	}

	if(($chk_time - G5_SERVER_TIME) / 60 > 5){
		$insert_pt = $row['bt_point'];
		sql_query("delete from {$g5['batting']} where bt_id = '{$bt_id}'");
		point_log('rp', $insert_pt, $member['mb_id'], $member['mb_id'], 1);

		$it_count = $item_chk['it_count'] - 1;

		sql_query("update {$g5['my_item']} set it_count = '{$it_count}' where mb_id = '{$member['mb_id']}' and it_id  = '3'");
		sql_query("insert into {$g5['item_log']} set it_id = '3', mb_id = '{$member['mb_id']}', il_datetime = '".G5_SERVER_TIME."'");

		alert(lang('배팅이 취소되었습니다.'), '/betting_history');
	} else
		alert(lang('경기 시작 5분 전까지 취소가 가능합니다.'));
}
?>