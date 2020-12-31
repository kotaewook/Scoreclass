<?php
$sub_menu = '210410';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

$tm_ko_name = str_replace("'", "&#39;", $tm_ko_name);
$tm_en_name = str_replace("'", "&#39;", $tm_en_name);
$tm_ja_name = str_replace("'", "&#39;", $tm_ja_name);
$tm_ch_name = str_replace("'", "&#39;", $tm_ch_name);

$common = " tm_ko_name = '{$tm_ko_name}', tm_en_name = '{$tm_en_name}', tm_ja_name = '{$tm_ja_name}', tm_ch_name = '{$tm_ch_name}', tm_logo = '{$tm_logo}', lg_id = '{$lg_id}'";

if($idx && $w == 'u'){
	$sql = "update {$g5['basketball_teams']} set  {$common} where idx = '{$idx}'";
	sql_query($sql);

	sql_query("update {$g5['game_list']} set gl_home_ko_name = '{$tm_ko_name}', gl_home_en_name = '{$tm_en_name}', gl_home_ja_name = '{$tm_ja_name}', gl_home_ch_name = '{$tm_ch_name}' where gl_home = '{$idx}' and gl_type = 2");
	sql_query("update {$g5['game_list']} set gl_away_ko_name = '{$tm_ko_name}', gl_away_en_name = '{$tm_en_name}', gl_away_ja_name = '{$tm_ja_name}', gl_away_ch_name = '{$tm_ch_name}' where gl_away = '{$idx}' and gl_type = 2");

	alert(lang('수정되었습니다.'), '/adm/basketball_team.php?'.$_POST['qstr']);
} else if(!$rk_id && $w == '') {
	$row = sql_fetch("select lg_country from {$g5['basketball_leagues']} where lg_id = '{$lg_id}' order by lg_id desc");
	$tm_country = $row['lg_country'];
	$row = sql_fetch("select count(*) as cnt from {$g5['basketball_teams']} order by idx desc");
	$tm_id = $row['cnt'] + 1;
	$common .= ", tm_id = '{$tm_id}', tm_country = '{$tm_country}'";

	$sql = "insert into {$g5['basketball_teams']} set {$common} ";

	sql_query($sql);
	alert(lang('등록되었습니다.'), '/adm/basketball_team.php');
} else if($rk_id && $w == 'd'){
	sql_query("delete from {$g5['basketball_teams']} where idx = '{$idx}'");
	alert(lang('삭제되었습니다.'), '/adm/basketball_team.php');
}
?>