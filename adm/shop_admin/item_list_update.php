<?php
$sub_menu = "400300";
include_once('./_common.php');

$count = count($_POST['chk']);
if(!$count)
	alert($_POST['act_button'].' 하실 항목을 하나 이상 체크하세요.');

if($w == 'u'){
	auth_check($auth[$sub_menu], 'w');

	check_admin_token();

	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$it_id = (int) $_POST['it_id'][$k];
		$it_price = $_POST['it_price'][$k];
		$it_gp = $_POST['it_gp'][$k];
		$it_best = $_POST['it_best'][$k];

		sql_query("update {$g5['item_shop']} set it_price = '{$it_price}', it_gp = '{$it_gp}', it_best = '{$it_best}' where it_id = '{$it_id}'");
	}
} else {

	auth_check($auth[$sub_menu], 'd');

	check_admin_token();

	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$it_id = (int) $_POST['it_id'][$k];
		if($it_id < 7)
			alert('삭제할 수 없는 상품이 포함되어있습니다.\n삭제 불가 상품 : 닉네임 변경권, 프로필 변경권, 배팅취소권, 랜덤 쪽지');

		sql_query("delete from {$g5['item_shop']} where it_id = '{$it_id}'");
	}
}

goto_url('./item_list.php?'.$qstr);
?>