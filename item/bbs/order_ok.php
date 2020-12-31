<?php include_once('../../common.php');

if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');

$row = sql_fetch("select * from {$g5['item_shop']} where it_id = '{$it_id}'");

if($row['it_price']*$it_count > $member['mb_cp'])
	alert(lang('보유 코인이 부족합니다.\n충전 후 구매해주세요.'), '/market');

$chk = sql_fetch("select it_count from {$g5['my_item']} where mb_id = '{$member['mb_id']}' and it_id = '{$it_id}'");
if(!$chk)
	sql_query("insert into {$g5['my_item']} set it_id = '{$it_id}', mb_id = '{$member['mb_id']}', it_count = '{$it_count}', it_datetime = '".G5_SERVER_TIME."'");
else {
	$count = $chk['it_count'] + $it_count;
	sql_query("update {$g5['my_item']} set it_count = '{$count}', it_datetime = '".G5_SERVER_TIME."' where it_id = '{$it_id}' and mb_id = '{$member['mb_id']}'");
}

point_log('cp', $row['it_price']*$it_count*-1, $member['mb_id'], $member['mb_id'], 20, $it_id);

$gp = $it_count * $row['it_gp'];

if($gp > 0)
	point_log('rp', $gp, $member['mb_id'], $member['mb_id'], 20, $it_id);

alert(lang('구매되었습니다.'), '/market/item');
?>