<?php include_once('../../common.php');
$row = sql_fetch("select * from {$g5['batting']} where bt_id = '{$bt_id}' and mb_id = '{$member['mb_id']}'");
if($row){
	if($w == 'd'){
		sql_query("delete from {$g5['trade']} where bt_id = '{$bt_id}'");
		sql_query("update {$g5['batting']} set bt_trade = 0 where bt_id = '{$bt_id}'");

		echo json_encode('success');
	} else {
		$sql = "insert into {$g5['trade']} set mb_id = '{$member['mb_id']}', bt_id = '{$bt_id}', td_price = '{$sale_pt}', td_datetime = '".G5_SERVER_TIME."'";
		sql_query($sql);

		sql_query("update {$g5['batting']} set bt_trade = 1 where bt_id = '{$bt_id}'");

		alert(lang('거래소에 등록 되었습니다.'), '/exchange/sale_list');
	}
} else {
	alert(lang('잘못된 접근입니다.'));
}
?>