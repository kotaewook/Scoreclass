<?php
$sub_menu = '200500';
include_once('./_common.php');
auth_check($auth[$sub_menu], "w");

$mb = get_member($mb_id);

if(!$mb['mb_id'])
	alert(lang('존재하지 않는 계정입니다.\n다시 한 번 확인해주세요.'));
else {
	if(!$point || $point == 0)
		alert(lang('포인트는 0보다 크거나 작아야합니다.'));

	if($point > 0)
		$msg = lang('지급되었습니다.');
	else
		$msg = lang('회수되었습니다.');

	point_log($pt_type, $point, $member['mb_id'], $mb_id, 99);

	alert($msg, '/adm/point_form.php');
}
?>