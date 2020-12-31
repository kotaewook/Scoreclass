<?php
include_once('./_common.php');

$row = get_member($mb_id, 'mb_id, mb_name');
if($row['mb_id']){
	$row['rank'] = get_rank_name($mb_id);
	echo json_encode($row);
} else
	echo json_encode('fail');
?>