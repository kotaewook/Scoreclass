<?php include_once('../common.php');

if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');

$bt_point = preg_replace("/[^0-9]*/s", "", $_POST['bet_price']);

if($bt_point > $member['mb_cp'])
	alert(lang('보유포인트가 부족합니다.'));
else if($bt_point < 1)
	alert(lang('배팅금액은 최소 1부터 가능합니다.'));

$total_cnt = count($_POST['bet_id']);
$bt_title = $_POST['bet_id'][0];
$bt_game = $bt_type_list = '';
$bt_dividend = 0;

for($i=0; $i<$total_cnt; $i++){
	$bt_game .= ($i == 0 ? '' : ',') . $_POST['bet_id'][$i];
	$bt_type_list .= ($i == 0 ? '' : ',') . $_POST['bet_type'][$i];

	$row = sql_fetch("select gl_{$_POST['bet_type'][$i]}_devidend from {$g5['game_list']} where gl_id = '{$_POST['bet_id'][$i]}'");
	$rate = $row['gl_' . $_POST['bet_type'][$i] . '_dividend'];

	$bt_dividend = ($i == 0 ? 1 : $bt_dividend) * $rate;
}

$sql = "insert into {$g5['batting']} set mb_id = '{$member['mb_id']}', bt_title = '{$bt_title}', bt_game = '{$bt_game}', bt_type_list = '{$bt_type_list}', bt_point = '{$bt_point}', bt_dividend = '{$bt_dividend}', bt_datetime = '".G5_SERVER_TIME."'";

sql_query($sql);

alert(lang('배팅되었습니다.'), '/batting_history');
?>