<?php include_once('../../common.php');

if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');

$coin = $cash == 'self' ? $self_pt : $cash;

point_log('cp', $coin, $member['mb_id'], $member['mb_id'], 101);

alert(lang('충전되었습니다.'), '/market');
?>