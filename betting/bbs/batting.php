<?php include_once('../../common.php');

if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');

$bt_point = preg_replace("/[^0-9]*/s", "", $_POST['bet_price']);

$total_cnt = count($_POST['bet_id']);

if($bt_point > $member['mb_rp'])
	alert(lang('보유포인트가 부족합니다.'));
else if($total_cnt == 0)
	alert(lang('배팅할 게임을 선택해주세요.'));
else if($total_cnt > 10)
	alert(lang('베팅 폴더는 최대 10개까지 선택 가능합니다.'));
else if($bt_point < 100000)
	alert(lang('배팅금액은 최소 10만GP부터 가능합니다.'));
else if($bt_point > 2000000000)
	alert(lang('배팅금액은 최대 20억GP까지 가능합니다.'));
else {
	for($i=0; $i<$total_cnt; $i++){
		$fight_id = sql_fetch("select gl_fight_id from {$g5['game_list']} where gl_id = '{$_POST['bet_id'][$i]}'");
		$fight_id = $fight_id['gl_fight_id'];
		
		$grray = array();

		$fs = sql_query("select gl_id from{$g5['game_list']} where gl_fight_id = '{$fight_id}'");
		while($fow = sql_fetch_array($fs))
			$grray[] = "bt_game like '%{$fow['gl_id']}^%'";
		
		$gid_sql = implode(' or ', $grray);
		unset($grray);

		$bck = sql_fetch("select sum(bt_point) as total from {$g5['batting']} where {$gid_sql}");
		$btp_chk = $bck['total']??0;

		if($btp_chk + $bt_point > 2000000000)
			alert(lang('같은 경기에 최대 20억GP까지 배팅이 가능합니다.'));
	}
}

$bt_title = $_POST['bet_id'][0];
$bt_game = $bt_type_list = $bt_dividend_list = '';
$bt_dividend = 0;
$time_chk = 999999999999;
for($i=0; $i<$total_cnt; $i++){
	$bt_type = str_replace(array('homeover', 'awayunder', 'drawunder', 'drawover'), array('home', 'away', 'draw', 'draw'), $_POST['bet_type'][$i]);
	$bt_game .= ($i == 0 ? '' : ',') . $_POST['bet_id'][$i].'^';
	$bt_type_list .= ($i == 0 ? '' : ',') . $_POST['bet_type'][$i];

	$row = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$_POST['bet_id'][$i]}'");
	$rate = $row['gl_' . $bt_type . '_dividend'];

	$bt_dividend_list .= ($i == 0 ? '' : ',') . $row['gl_home_dividend'].'?'.$row['gl_draw_dividend'].'?'.$row['gl_away_dividend'].'?'.$row['gl_criteria'];

	if($row['gl_datetime'] < strtotime('+5 minutes'))
		alert(lang('배팅은 경기시작 5분전 까지 가능합니다.'));

	if($time_chk > $row['gl_datetime'])
		$time_chk = $row['gl_datetime'];

	$bt_dividend = ($i == 0 ? 1 : $bt_dividend) * $rate;
}

if($bt_dividend > 300)
	$bt_dividend = 300;

point_log('rp', $bt_point * -1, $member['mb_id'], $member['mb_id']);

$sql = "insert into {$g5['batting']} set mb_id = '{$member['mb_id']}', bt_title = '{$bt_title}', bt_game = '{$bt_game}', bt_type_list = '{$bt_type_list}', bt_point = '{$bt_point}', bt_dividend = '{$bt_dividend}', bt_datetime = '".G5_SERVER_TIME."', bt_first_time = '{$time_chk}', bt_dividend_list = '{$bt_dividend_list}'";
sql_query($sql);

alert(lang('배팅되었습니다.'), '/betting_history');
?>