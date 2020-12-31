<?php
$sub_menu = $_POST['type'] == 's' ? '210120' :"210110";
include_once('./_common.php');

$count = count($_POST['chk']);
if(!$count)
	alert($_POST['act_button'].' 하실 항목을 하나 이상 체크하세요.');

if($w == 'u'){
	auth_check($auth[$sub_menu], 'w');

	check_admin_token();

	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$gl_id = (int) $_POST['gl_id'][$k];
		$gl_hide = $_POST['gl_hide'][$k];
		$gl_show = $_POST['gl_show'][$k];
		$gl_home_score = $_POST['gl_home_score'][$k];
		$gl_away_score = $_POST['gl_away_score'][$k];
		

		if(count($_POST['gl_home_dividend'][$k]) > 1){
			$gl_home_dividend = $gl_away_dividend = $gl_draw_dividend = $gl_criteria = '';
			for($j=0; $j<count($_POST['gl_home_dividend'][$k]); $j++){
				$gl_home_dividend .= ($j==0?'':'^').$_POST['gl_home_dividend'][$k][$j];
				$gl_away_dividend .= ($j==0?'':'^').$_POST['gl_away_dividend'][$k][$j];
				$gl_draw_dividend .= ($j==0?'':'^').$_POST['gl_draw_dividend'][$k][$j];
				$gl_criteria .= ($j==0?'':'^').$_POST['gl_criteria'][$k][$j];
			}
		} else {
			$gl_home_dividend = $_POST['gl_home_dividend'][$k][0];
			$gl_away_dividend = $_POST['gl_away_dividend'][$k][0];
			$gl_draw_dividend = $_POST['gl_draw_dividend'][$k][0];
			$gl_criteria = $_POST['gl_criteria'][$k][0];
		}

		sql_query("update {$g5['game_list']} set gl_hide = '{$gl_hide}', gl_show = '{$gl_show}', gl_home_dividend = '{$gl_home_dividend}', gl_away_dividend = '{$gl_away_dividend}', gl_draw_dividend = '{$gl_draw_dividend}', gl_criteria = '{$gl_criteria}', gl_away_score = '{$gl_away_score}', gl_home_score = '{$gl_home_score}' where gl_id = '{$gl_id}'");
	}
} else if($w == 'all'){
	$count = count($_POST['gl_id']);
	for ($i=0; $i<$count; $i++) {
		// 실제 번호를 넘김
		$gl_id = (int) $_POST['gl_id'][$i];

		sql_query("update {$g5['game_list']} set gl_show = '1' where gl_id = '{$gl_id}'");
	}
} else {

	auth_check($auth[$sub_menu], 'd');

	check_admin_token();

	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$gl_id = (int) $_POST['gl_id'][$k];

		sql_query("delete from {$g5['game_list']} where gl_id = '{$gl_id}'");
	}
}

if($now == 1)
	goto_url('./now_game.php?'.$_POST['qstr']);
else
	goto_url('./fight_game.php?'.$_POST['qstr']);
?>