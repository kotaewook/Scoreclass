<?php
$sub_menu = '210500';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

$lg_ko_name = str_replace("'", "&#39;", $lg_ko_name);
$lg_en_name = str_replace("'", "&#39;", $lg_en_name);
$lg_ja_name = str_replace("'", "&#39;", $lg_ja_name);
$lg_ch_name = str_replace("'", "&#39;", $lg_ch_name);

$common = " lg_ko_name = '{$lg_ko_name}', lg_en_name = '{$lg_en_name}', lg_ja_name = '{$lg_ja_name}', lg_ch_name = '{$lg_ch_name}', lg_logo = '{$lg_logo}', lg_flag = '{$lg_flag}', lg_country = '{$lg_country}', lg_main = '{$lg_main}'";

if($lg_id && $w == 'u'){
	$sql = "update {$g5['volleyball_leagues']} set {$common} where lg_id = '{$lg_id}'";
	sql_query($sql);

	sql_query("update {$g5['game_list']} set gl_lg_ko_name = '{$lg_ko_name}', gl_lg_flag = '{$lg_flag}', gl_lg_en_name = '{$lg_en_name}', gl_lg_ja_name = '{$lg_ja_name}', gl_lg_ch_name = '{$lg_ch_name}' where gl_lg_type = '{$lg_id}' and gl_type = 3");

	for($i=0; $i<count($_POST['tm_id']); $i++){
		$tm_id = $_POST['tm_id'][$i];
		$tm_game = $_POST['tm_game'][$i];
		$tm_win = $_POST['tm_win'][$i];
		$tm_draw = $_POST['tm_draw'][$i];
		$tm_lose = $_POST['tm_lose'][$i];
		$tm_point = $_POST['tm_point'][$i];
		$tm_goal = $_POST['tm_goal'][$i];

		sql_query("update {$g5['volleyball_teams']} set tm_game = '{$tm_game}', tm_win = '{$tm_win}', tm_draw = '{$tm_draw}', tm_lose = '{$tm_lose}', tm_point = '{$tm_point}', tm_goal = '{$tm_goal}' where tm_id = '{$tm_id}'");
	}

	alert(lang('수정되었습니다.'), '/adm/volleyball_league_form.php?w=u&lg_id='.$lg_id.'&'.$_POST['qstr']);
} else if(!$rk_id && $w == '') {
	$row = sql_fetch("select lg_id from {$g5['volleyball_leagues']} order by lg_id desc");
	$lg_id = $row['lg_id'] ? $row['lg_id'] + 1 : 1;
	$common .= ", lg_id = '{$lg_id}'";
	$sql = "insert into {$g5['volleyball_leagues']} set {$common} ";

	sql_query($sql);
	alert(lang('등록되었습니다.'), '/adm/volleyball_league.php?'.$_POST['qstr']);
} else if($rk_id && $w == 'd'){
	sql_query("delete from {$g5['volleyball_leagues']} where lg_id = '{$lg_id}'");
	alert(lang('삭제되었습니다.'), '/adm/volleyball_league.php');
}
?>