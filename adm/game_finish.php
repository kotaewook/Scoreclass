<?php
$sub_menu = $_GET['type'] == 's' ? '210120' :"210110";
include_once('./_common.php');

$row = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");
sql_query("update {$g5['game_list']} set gl_status = '3' where gl_fight_id = '{$row['gl_fight_id']}'");
league_update($row, $row['gl_home_score'], $row['gl_away_score']);

$py = sql_query("select * from {$g5['game_list']} where gl_fight_id = '{$row['gl_fight_id']}'");
while($play = sql_fetch_array($py)){
	$bt_dividend = 1;
	$cancel = $bt_point = 0;
	$now_type = '';
	$bt = sql_query("select * from {$g5['batting']} where bt_game like '%{$play['gl_id']}^%' and bt_trade != 2");
	while($bet = sql_fetch_array($bt)){
		$list_id = explode(',', $bet['bt_game']);
		$type_id = explode(',', $bet['bt_type_list']);
		$rate_id = explode(',', $bet['bt_dividend_list']);
		$game_cnt = count($list_id);
		$bt_point = $bet['bt_point'];

		for($j=0; $j<$game_cnt; $j++){
			$list_id[$j] = str_replace('^', '', $list_id[$j]);

			$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$list_id[$j]}'");

			$rate_list = explode('?', $rate_id[$j]);

			$rating = rate_select($type_id[$j], $rate_list);

			$info['gl_home_dividend'] = $rate_list[0];
			$info['gl_draw_dividend'] = $rate_list[1];
			$info['gl_away_dividend'] = $rate_list[2];
			$info['gl_criteria'] = $rate_list[3];

			if($info['gl_hide'] == 1)
				$info['gl_home_dividend'] = $info['gl_draw_dividend'] = $info['gl_away_dividend'] = 1;

			if($info['gl_game_type'] == 3){
				$rate1 = $rating;
				if(strpos($type_id[$j], 'under') !== false)
					$check = 0;
				else
					$check = 1;

				$rate = $rate1[$check];
			} else
				$rate = $rating;

			$bt_dividend = round_down($bt_dividend * $rate, 1);
			
			if($cancel == 0)
				$cancel = game_success_chk($info, $type_id[$j]);
		}

		unset($list_id);
		unset($type_id);
		
		if($cancel == 0){
			if($bt_dividend > 300)
				$bt_dividend = 300;

			$insert_pt = round_down($bt_point * $bt_dividend, 2);

			if($insert_pt > 10000000000)
				$insert_pt = 10000000000;

			point_log('rp', $insert_pt, $bet['mb_id'], $bet['mb_id'], 100);

			sql_query("update {$g5['batting']} set bt_status = '1', bt_dividend = '{$bt_dividend}' where bt_id = '{$bet['bt_id']}'");
		}
	}
}

alert(lang('경기가 종료되었습니다.'), '/adm/fight_game.php?page='.$_GET['page']);
?>