<?php
$sub_menu = '200300';
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
    $pt_id = (int) $_POST['pt_id'][$k];
    $str_mb_id = $_POST['mb_id'][$k];
	$pt_type = $_POST['pt_type'][$k];
	$set_table = $g5[$pt_type.'_log'];

    // 포인트 내역정보
    $sql = " select * from {$set_table} where {$pt_type}_id = '{$pt_id}' ";
    $row = sql_fetch($sql);

    if(!$row[$pt_type.'_id'])
        continue;

    // 포인트 내역삭제
    $sql = " delete from {$set_table} where {$pt_type}_id = '{$pt_id}' ";
    sql_query($sql);

    // 포인트 UPDATE
    $sum_point = sql_fetch("select sum({$pt_type}) as total from {$set_table} where mb_id = '{$str_mb_id}'");
    $sql= " update {$g5['member_table']} set mb_{$pt_type} = '{$sum_point['total']}' where mb_id = '{$str_mb_id}' ";
    sql_query($sql);
}

goto_url('./point_list.php?'.$qstr);
?>