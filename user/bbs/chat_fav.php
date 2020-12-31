<?php include_once('common.php');
$row = sql_fetch("select * from {$g5['chat_fav']} where mb_id = '{$member['mb_id']}' and ch_id = '{$ch_id}'");
if($row){
	sql_query("delete from {$g5['chat_fav']} where mb_id = '{$member['mb_id']}' and ch_id = '{$ch_id}'");
	echo json_encode(1);
} else {
	sql_query("insert into {$g5['chat_fav']} set mb_id = '{$member['mb_id']}', ch_id = '{$ch_id}', cf_datetime = '".G5_SERVER_TIME."'");
	echo json_encode(0);
}
?>