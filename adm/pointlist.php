<?php
$sub_menu = '100130';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '각종 포인트 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['point_list']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = "select * $sql_common order by pl_datetime desc ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov"><span class="btn_ov01"><span class="ov_txt">전체 등록된 포인트 설정</span> <span class="ov_num">  <?php echo $total_count; ?>건</span></span></div>

<form name="fmemberlist" id="fmemberlist" action="#/member_list_update.php" onsubmit="return fmemberlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
		<th scope="col" id="pt_list_chk" rowspan="2" >
            <label for="chkall" class="sound_only">설정 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col" >발생 포인트</th>
		<th scope="col">카테고리</th>
		<th scope="col">활동내용</th>
        <th scope="col">포인트</th>
        <th scope="col">관리</th>
	</tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?=$bg?>">
        <td headers="pt_list_chk" class="td_chk">
            <input type="hidden" name="pl_id[<?php echo $i ?>]" value="<?php echo $row['pl_id'] ?>" id="pl_id_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['mb_name']); ?> <?php echo get_text($row['mb_nick']); ?>님</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
		<td class="td_center"><?=strtoupper($pt_name[$row['pl_type']])?></td>
		<td class="td_center"><?=$pt_type_cate[$row['pt_type']]?></td>
		<td class="td_left"><?=$pt_type_name[$row['pt_type']][$row['int_type']]?></td>
		<td class="td_num td_pt"><?=number_format($row['point'])?></td>     
		<td class="td_mng td_mng_m">
            <a href="./pointform.php?w=u&amp;pl_id=<?php echo $row['pl_id']; ?>" class="btn btn_03">수정</a>
            <a href="./pointformupdate.php?w=d&amp;pl_id=<?php echo $row['pl_id']; ?>" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only"><?php echo $row['nw_subject']; ?> </span>삭제</a>
        </td>
	</tr>
    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="11" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
    <?php if ($is_admin == 'super') { ?>
    <a href="./pointform.php" id="member_add" class="btn btn_01">포인트설정 추가</a>
    <?php } ?>

</div>

</form>
<script>
function fmemberlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
