<?php
$aaa1 = $_POST['stx'];
$sub_menu = $_GET['type'] == 's' ? '210120' : ($_GET['now'] == 1 ? '210130' : "210110");
include_once('./_common.php');

 function GenerateString($length)  
{  
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  
      
    $string_generated = "";  
      
    $nmr_loops = $length;  
    while ($nmr_loops--)  
    {  
        $string_generated .= $characters[mt_rand(0, strlen($characters) - 1)];  
    }  
      
    return $string_generated;  
}  


if($gl_type == 0){
	$lg_table = $g5['soccer_leagues'];
	$tm_table = $g5['soccer_teams'];
} else if($gl_type == 1){
	$lg_table = $g5['baseball_leagues'];
	$tm_table = $g5['baseball_teams'];
} else if($gl_type == 2){
	$lg_table = $g5['basketball_leagues'];
	$tm_table = $g5['basketball_teams'];
} else if($gl_type == 3){
	$lg_table = $g5['volleyball_leagues'];
	$tm_table = $g5['volleyball_teams'];
} else if($gl_type == 4){
	$lg_table = $g5['hockey_leagues'];
	$tm_table = $g5['hockey_teams'];
}

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

$gl_datetime = strtotime(date('Y-m-d H:i', strtotime($gl_datetime)));

if($gl_id && $w == 'u'){
	$i=0;
	$row = sql_fetch("select gl_datetime, gl_fight_id from {$g5['game_list']} where gl_id = '{$gl_id}'");
	$gl_game_type = $_POST['gl_game_type'][$i];

	if(count($_POST['gl_home_dividend'][$i]) > 1){
		$gl_home_dividend = $gl_away_dividend = $gl_draw_dividend = $gl_criteria = '';
		for($j=0; $j<count($_POST['gl_home_dividend'][$i]); $j++){
			$gl_home_dividend .= ($j==0?'':'^').$_POST['gl_home_dividend'][$i][$j];
			$gl_away_dividend .= ($j==0?'':'^').$_POST['gl_away_dividend'][$i][$j];
			$gl_draw_dividend .= ($j==0?'':'^').$_POST['gl_draw_dividend'][$i][$j];
			$gl_criteria .= ($j==0?'':'^').$_POST['gl_criteria'][$i][$j];
		}
	} else {
		$gl_home_dividend = $_POST['gl_home_dividend'][$i];
		$gl_away_dividend = $_POST['gl_away_dividend'][$i];
		$gl_draw_dividend = $_POST['gl_draw_dividend'][$i];
		$gl_criteria = $_POST['gl_criteria'][$i];
	}

	$game_lg = sql_fetch("select lg_ko_name, lg_en_name, lg_ja_name, lg_ch_name from {$lg_table} where lg_id = '{$gl_lg_type}'");
	$gl_lg_ko_name = str_replace("'", "''", $game_lg['lg_ko_name']);
	$gl_lg_en_name = str_replace("'", "''", $game_lg['lg_en_name']);
	$gl_lg_ja_name = str_replace("'", "''", $game_lg['lg_ja_name']);
	$gl_lg_ch_name = str_replace("'", "''", $game_lg['lg_ch_name']);
	$gl_lg_flag = $game_lg['lg_flag'];

	$home_tm = sql_fetch("select tm_ko_name, tm_en_name, tm_ja_name, tm_ch_name from {$tm_table} where idx = '{$gl_home}' ");
	$gl_home_ko_name = str_replace("'", "''", $home_tm['tm_ko_name']);
	$gl_home_en_name = str_replace("'", "''", $home_tm['tm_en_name']);
	$gl_home_ja_name = str_replace("'", "''", $home_tm['tm_ja_name']);
	$gl_home_ch_name = str_replace("'", "''", $home_tm['tm_ch_name']);

	$away_tm = sql_fetch("select tm_ko_name, tm_en_name, tm_ja_name, tm_ch_name from {$tm_table} where idx = '{$gl_away}' ");
	$gl_away_ko_name = str_replace("'", "''", $away_tm['tm_ko_name']);
	$gl_away_en_name = str_replace("'", "''", $away_tm['tm_en_name']);
	$gl_away_ja_name = str_replace("'", "''", $away_tm['tm_ja_name']);
	$gl_away_ch_name = str_replace("'", "''", $away_tm['tm_ch_name']);

	$lg_tm_sql = " gl_lg_ko_name = '{$gl_lg_ko_name}', gl_lg_en_name = '{$gl_lg_en_name}', gl_lg_ja_name = '{$gl_lg_ja_name}', gl_lg_ch_name = '{$gl_lg_ch_name}', gl_lg_flag = '{$gl_lg_flag}', gl_home_ko_name = '{$gl_home_ko_name}', gl_home_en_name = '{$gl_home_en_name}', gl_home_ja_name = '{$gl_home_ja_name}', gl_home_ch_name = '{$gl_home_ch_name}', gl_away_ko_name = '{$gl_away_ko_name}', gl_away_en_name = '{$gl_away_en_name}', gl_away_ja_name = '{$gl_away_ja_name}', gl_away_ch_name = '{$gl_away_ch_name}'";

	if($gl_datetime < 1 || trim($gl_datetime) == '' || !$gl_datetime){
	} else {
		$common = " gl_game_type = '{$gl_game_type}', gl_home_dividend = '{$gl_home_dividend}', gl_away_dividend = '{$gl_away_dividend}', gl_draw_dividend = '{$gl_draw_dividend}', gl_criteria = '{$gl_criteria}', gl_datetime = '{$gl_datetime}', gl_hide = '{$gl_hide}', gl_special = '{$gl_special}', gl_away_score_list = '{$gl_away_score_list}', gl_home_score_list = '{$gl_home_score_list}', {$lg_tm_sql} ";

		$sql = "update {$g5['game_list']} set  {$common} where gl_id = '{$gl_id}'";
		sql_query($sql);

		$sql = "update {$g5['game_list']} set gl_type = '{$gl_type}', gl_lg_type = '{$gl_lg_type}', gl_home = '{$gl_home}', gl_away = '{$gl_away}', gl_datetime = '{$gl_datetime}', gl_home_score = '{$gl_home_score}', gl_away_score = '{$gl_away_score}', gl_away_score_list = '{$gl_away_score_list}', gl_home_score_list = '{$gl_home_score_list}'".($chk_all_hide == 1 ? ", gl_hide = '{$gl_hide}'" : '')." where gl_fight_id = '{$row['gl_fight_id']}'";
		sql_query($sql);

		if(count($_POST['gl_game_type']) > 1){
			for($i=1; $i<count($_POST['gl_game_type']); $i++){
				$gl_game_type = $_POST['gl_game_type'][$i];

				if(count($_POST['gl_home_dividend'][$i]) > 1){
					$gl_home_dividend = $gl_away_dividend = $gl_draw_dividend = $gl_criteria = '';
					for($j=0; $j<count($_POST['gl_home_dividend'][$i]); $j++){
						$gl_home_dividend .= ($j==0?'':'^').$_POST['gl_home_dividend'][$i][$j];
						$gl_away_dividend .= ($j==0?'':'^').$_POST['gl_away_dividend'][$i][$j];
						$gl_draw_dividend .= ($j==0?'':'^').$_POST['gl_draw_dividend'][$i][$j];
						$gl_criteria .= ($j==0?'':'^').$_POST['gl_criteria'][$i][$j];
					}
				} else {
					$gl_home_dividend = $_POST['gl_home_dividend'][$i];
					$gl_away_dividend = $_POST['gl_away_dividend'][$i];
					$gl_draw_dividend = $_POST['gl_draw_dividend'][$i];
					$gl_criteria = $_POST['gl_criteria'][$i];
				}

				$common = " gl_fight_id = '{$row['gl_fight_id']}', gl_type = '{$gl_type}', gl_lg_type = '{$gl_lg_type}', gl_game_type = '{$gl_game_type}', gl_home = '{$gl_home}', gl_home_dividend = '{$gl_home_dividend}', gl_away = '{$gl_away}', gl_away_dividend = '{$gl_away_dividend}', gl_draw_dividend = '{$gl_draw_dividend}', gl_criteria = '{$gl_criteria}', gl_datetime = '{$gl_datetime}', gl_home_score = '{$gl_home_score}', gl_away_score = '{$gl_away_score}', gl_away_score_list = '{$gl_away_score_list}', gl_home_score_list = '{$gl_home_score_list}', {$lg_tm_sql} ";
				$sql = "insert into {$g5['game_list']} set {$common} ";
				sql_query($sql);
			}
		}
	}

	if($finish_game == 1 && $row['gl_status'] != 3){
		include_once('game_finish.php');
	}

	goto_url('/adm/'.$_POST['pg'].'.php?'.$_POST['qstr'].'&game_type='.$_POST['game_type']);
} else if(!$gl_id && $w == '') {
	$cnt = sql_fetch("select count(*) as cnt from {$g5['game_list']} order by gl_fight_id desc");

	$game_lg = sql_fetch("select lg_ko_name, lg_en_name, lg_ja_name, lg_ch_name from {$lg_table} where lg_id = '{$gl_lg_type}'");
	$gl_lg_ko_name = str_replace("'", "''", $game_lg['lg_ko_name']);
	$gl_lg_en_name = str_replace("'", "''", $game_lg['lg_en_name']);
	$gl_lg_ja_name = str_replace("'", "''", $game_lg['lg_ja_name']);
	$gl_lg_ch_name = str_replace("'", "''", $game_lg['lg_ch_name']);
	$gl_lg_flag = $game_lg['lg_flag'];

	$home_tm = sql_fetch("select tm_ko_name, tm_en_name, tm_ja_name, tm_ch_name from {$tm_table} where idx = '{$gl_home}' ");
	$gl_home_ko_name = str_replace("'", "''", $home_tm['tm_ko_name']);
	$gl_home_en_name = str_replace("'", "''", $home_tm['tm_en_name']);
	$gl_home_ja_name = str_replace("'", "''", $home_tm['tm_ja_name']);
	$gl_home_ch_name = str_replace("'", "''", $home_tm['tm_ch_name']);

	$away_tm = sql_fetch("select tm_ko_name, tm_en_name, tm_ja_name, tm_ch_name from {$tm_table} where idx = '{$gl_away}' ");
	$gl_away_ko_name = str_replace("'", "''", $away_tm['tm_ko_name']);
	$gl_away_en_name = str_replace("'", "''", $away_tm['tm_en_name']);
	$gl_away_ja_name = str_replace("'", "''", $away_tm['tm_ja_name']);
	$gl_away_ch_name = str_replace("'", "''", $away_tm['tm_ch_name']);

	$lg_tm_sql = " gl_lg_ko_name = '{$gl_lg_ko_name}', gl_lg_en_name = '{$gl_lg_en_name}', gl_lg_ja_name = '{$gl_lg_ja_name}', gl_lg_ch_name = '{$gl_lg_ch_name}', gl_lg_flag = '{$gl_lg_flag}', gl_home_ko_name = '{$gl_home_ko_name}', gl_home_en_name = '{$gl_home_en_name}', gl_home_ja_name = '{$gl_home_ja_name}', gl_home_ch_name = '{$gl_home_ch_name}', gl_away_ko_name = '{$gl_away_ko_name}', gl_away_en_name = '{$gl_away_en_name}', gl_away_ja_name = '{$gl_away_ja_name}', gl_away_ch_name = '{$gl_away_ch_name}'";

	$gl_fight_id = 'A'.GenerateString(1).($cnt['cnt'] + 1);

	for($i=0; $i<count($_POST['gl_game_type']); $i++){
		$gl_game_type = $_POST['gl_game_type'][$i];

		if(count($_POST['gl_home_dividend'][$i]) > 1){
			$gl_home_dividend = $gl_away_dividend = $gl_draw_dividend = $gl_criteria = '';
			for($j=0; $j<count($_POST['gl_home_dividend'][$i]); $j++){
				$gl_home_dividend .= ($j==0?'':'^').$_POST['gl_home_dividend'][$i][$j];
				$gl_away_dividend .= ($j==0?'':'^').$_POST['gl_away_dividend'][$i][$j];
				$gl_draw_dividend .= ($j==0?'':'^').$_POST['gl_draw_dividend'][$i][$j];
				$gl_criteria .= ($j==0?'':'^').$_POST['gl_criteria'][$i][$j];
			}
		} else {
			$gl_home_dividend = $_POST['gl_home_dividend'][$i];
			$gl_away_dividend = $_POST['gl_away_dividend'][$i];
			$gl_draw_dividend = $_POST['gl_draw_dividend'][$i];
			$gl_criteria = $_POST['gl_criteria'][$i];
		}

		$common = " gl_fight_id = '{$gl_fight_id}', gl_type = '{$gl_type}', gl_lg_type = '{$gl_lg_type}', gl_game_type = '{$gl_game_type}', gl_home = '{$gl_home}', gl_home_dividend = '{$gl_home_dividend}', gl_away = '{$gl_away}', gl_away_dividend = '{$gl_away_dividend}', gl_draw_dividend = '{$gl_draw_dividend}', gl_criteria = '{$gl_criteria}', gl_datetime = '{$gl_datetime}', gl_home_score = '{$gl_home_score}', gl_away_score = '{$gl_away_score}', {$lg_tm_sql} ";
		$sql = "insert into {$g5['game_list']} set {$common} ";
		sql_query($sql);
	}
	if($now == 1)
		alert(lang('등록되었습니다.'), '/adm/now_game.php');
	else
		alert(lang('등록되었습니다.'), '/adm/fight_game.php');
} else if($gl_id && $w == 'd'){
	sql_query("delete from {$g5['game_list']} where gl_id = '{$gl_id}'");

	if($now == 1)
		alert(lang('삭제되었습니다.'), '/adm/now_game.php');
	else
		alert(lang('삭제되었습니다.'), '/adm/fight_game.php');
}
?>