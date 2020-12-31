<?php
$sub_menu = '200400';
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
    $exp_id = (int) $_POST['exp_id'][$k];
    $str_mb_id = $_POST['mb_id'][$k];

    // 포인트 내역정보
    $sql = " select * from {$g5['exp_log']} where exp_id = '{$exp_id}' ";
    $row = sql_fetch($sql);

    if(!$row['exp_id'])
        continue;

    // 포인트 내역삭제
    $sql = " delete from {$g5['exp_log']} where exp_id = '{$exp_id}' ";
    sql_query($sql);

    // 포인트 UPDATE
    $sum_point = sql_fetch("select sum(point) as total from {$g5['exp_log']} where mb_id = '{$str_mb_id}'");
    $sql= " update {$g5['member_table']} set mb_exp = '{$sum_point['total']}' where mb_id = '{$str_mb_id}' ";
    sql_query($sql);
}

goto_url('./exp_list.php?'.$qstr);
?>