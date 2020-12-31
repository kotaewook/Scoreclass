<?php
$sub_menu = '210400';
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'd');

check_admin_token();

$count = count($_POST['chk']);
if(!$count)
    alert($_POST['act_button'].' 하실 항목을 하나 이상 체크하세요.');

for ($i=0; $i<$count; $i++)
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];
    $lg_id = (int) $_POST['lg_id'][$k];

	$row = sql_fetch("select count(*) as cnt from {$g5['game_list']} where gl_type = 1 and gl_lg_type = '{$lg_id}'");
	if($row['cnt'] > 0)
		alert('선택하신 리그에 등록된 게임이있어 삭제가 불가능합니다.');
	else
		sql_query("delete from {$g5['basketball_leagues']} where lg_id = '{$lg_id}'");
}

goto_url('./basketball_league.php?'.$qstr);
?>