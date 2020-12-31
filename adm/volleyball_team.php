<?php
$sub_menu = "210510";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['volleyball_teams']} ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
		case 'tm_country';
			$isql = array();

			$sct = sql_query("select ct_id from g5_country where ko_name like '%{$stx}%' or en_name like '%{$stx}%' or ja_name like '%{$stx}%' or ch_name like '%{$stx}%'");
			for($s = 0; $sow=sql_fetch_array($sct); $s++)
				$isql[] = "tm_country = '{$sow['ct_id']}'";

			if(count($isql) > 0)

				$sql_search .= ' ('.implode(' or ', $isql).') ';
			break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "idx";
    $sod = "asc";
}
$sql_order = " order by {$sst} {$sod}, idx asc ";

$sql = "select count(cnt) as cnt from (select count(*) as cnt from {$g5['volleyball_teams']} group by idx) as a";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search} group by idx 
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$mb = array();
if ($sfl == 'mb_id' && $stx)
    $mb = get_member($stx);

$g5['title'] = '배구 팀 관리';
include_once ('./admin.head.php');

$colspan = 11;

$po_expire_term = '';
if($config['cf_point_term'] > 0) {
    $po_expire_term = $config['cf_point_term'];
}

if (strstr($sfl, "mb_id"))
    $mb_id = $stx;
else
    $mb_id = "";
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">전체 등록된 배구 팀 내역 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
	<option value="idx"<?php echo get_selected($_GET['sfl'], "idx"); ?>>팀번호</option>
    <option value="lg_id"<?php echo get_selected($_GET['sfl'], "lg_id"); ?>>리그번호</option>
	<option value="tm_ko_name"<?php echo get_selected($_GET['sfl'], "tm_ko_name"); ?>>한국어</option>
	<option value="tm_en_name"<?php echo get_selected($_GET['sfl'], "tm_en_name"); ?>>영어</option>
	<option value="tm_ja_name"<?php echo get_selected($_GET['sfl'], "tm_ja_name"); ?>>일본어</option>
	<option value="tm_ch_name"<?php echo get_selected($_GET['sfl'], "tm_ch_name"); ?>>중국어</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" class="btn_submit" value="검색">
</form>

<form name="fpointlist" id="fpointlist" method="post" action="./volleyball_team_list_delete.php" onsubmit="return fpointlist_submit(this);">
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
		<th scope="col">
            <label for="chkall" class="sound_only">팀 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
		<th scope="col"><?php echo subject_sort_link('idx') ?>팀번호</a></th>
		<th scope="col">나라</th>
		<th scope="col"><?php echo subject_sort_link('lg_id') ?>리그</a></th>
        <th scope="col"><?php echo subject_sort_link('tm_ko_name') ?>한국어</a></th>
        <th scope="col"><?php echo subject_sort_link('tm_en_name') ?>영어</a></th>
        <th scope="col"><?php echo subject_sort_link('tm_ja_name') ?>일본어</a></th>
        <th scope="col"><?php echo subject_sort_link('tm_ch_name') ?>중국어</a></th>
		<th scope="col">등록된<br>경기</th>
        <th scope="col">배팅수</th>
		<th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
		$ct = sql_fetch("select {$country}_name as name from g5_country where ct_id = '{$row['tm_country']}'");
    ?>

    <tr class="<?php echo $bg; ?>">
		<td class="td_chk">
            <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>" id="gl_id_<?=$i?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only">내역</label>
            <input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
        </td>
		<td class="td_num"><?=$row['idx']?></td>
		<td class="td_num"><?=$ct['name']?></td>
		<td class="td_num"><?=league_name(1,$row['lg_id'])?></td>
        <td class="td_left"><?=$row['tm_ko_name'] ?></td>
        <td class="td_left"><?=$row['tm_en_name']?></td>
		<td class="td_left"><?=$row['tm_ja_name']?></td>
		<td class="td_left"><?=$row['tm_ch_name']?></td>
		<td class="td_num"><?=number_format($row['before_pt'])?></td>
        <td class="td_num"><?=number_format($row['after_pt'])?></td>
		<td headers="mb_list_mng" class="td_mng td_mng_s"><a href="./volleyball_team_form.php?<?=$qstr?>&amp;w=u&amp;idx=<?=$row['idx']?>" class="btn btn_03">수정</a></td>
    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
	<?php if ($is_admin == 'super') { ?>
    <a href="./volleyball_team_form.php" id="member_add" class="btn btn_01">팀추가</a>
    <?php } ?>
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fpointlist_submit(f)
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
include_once ('./admin.tail.php');
?>
