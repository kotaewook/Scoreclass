<?php
$sub_menu = '210410';
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
    $idx = (int) $_POST['idx'][$k];

	$row = sql_fetch("select count(*) as cnt from {$g5['game_list']} where gl_type = 1 and (gl_home = '{$idx}' or gl_away = '{$idx}')");
	if($row['cnt'] > 0)
		alert('선택하신 리그에 등록된 게임이있어 삭제가 불가능합니다.');
	else
		sql_query("delete from {$g5['basketball_teams']} where idx = '{$idx}'");
}

goto_url('./basketball_team.php?'.$qstr);
?>