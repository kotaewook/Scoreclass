<?php
$sub_menu = '100130';
include_once('./_common.php');
auth_check($auth[$sub_menu], "w");
if($w == 'd'){
	sql_query("delete from {$g5['point_list']} where pl_id = '{$pl_id}'");
	alert(lang('삭제되었습니다.'), 'pointlist.php');
} else if($w == 'u'){
	$sql = "update {$g5['point_list']} set pl_type = '{$pl_type}', pt_type = '{$pt_type}', int_type = '{$int_type}', point = '{$point}' where pl_id = '{$pl_id}'";
	sql_query($sql);

	alert(lang('수정되었습니다.'), 'pointlist.php');
} else {
	$sql = "insert into {$g5['point_list']} set pl_type = '{$pl_type}', pt_type = '{$pt_type}', int_type = '{$int_type}', point = '{$point}', pl_datetime = '".G5_TIME_YMDHIS."'";
	sql_query($sql);

	alert(lang('등록되었습니다.'), 'pointlist.php');
}
?>