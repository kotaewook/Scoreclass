<?php
$sub_menu = "200200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['batting']} a inner join {$g5['game_list']} b on a.bt_title = b.gl_id ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "bt_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$g5['title'] = '배팅내역';
include_once ('./admin.head.php');

$colspan = 10;
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">전체 등록된 배팅 내역 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>회원아이디</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" class="btn_submit" value="검색">
</form>

<form name="fpointlist" id="fpointlist" method="post" action="./betting_list_delete.php" onsubmit="return fpointlist_submit(this);">
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
            <label for="chkall" class="sound_only">포인트 내역 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
		<th scope="col"><?php echo subject_sort_link('bt_id') ?>배팅번호</a></th>
        <th scope="col"><?php echo subject_sort_link('mb_id') ?>아이디</a></th>
        <th scope="col">배팅경기</th>
        <th scope="col"><?php echo subject_sort_link('bt_dividend') ?>배당율</a></th>
        <th scope="col"><?php echo subject_sort_link('bt_point') ?>배팅<br>포인트</a></th>
		<th scope="col">예상당첨 포인트</th>
        <th scope="col">상태</th>
		<th scope="col"><?php echo subject_sort_link('bt_datetime') ?>배팅일</a></th>
		<th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		$success = 0;
		$list_id = explode(',', $row['bt_game']);
		$type_id = explode(',', $row['bt_type_list']);
		$game_cnt = count($list_id);

		$title = sql_fetch("select gl_type, gl_home, gl_away from {$g5['game_list']} where gl_id = '{$row['bt_title']}'");

        $bg = 'bg'.($i%2);

		$bt_type = 0;
		for($j=0; $j<$game_cnt; $j++){
			$gl_id = str_replace('^', '', $list_id[$j]);
			$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");
			$rate = $info['gl_' . $type_id[$j] . '_dividend'];
			$bt_dividend = round_down(($j == 0 ? 1 : $bt_dividend) * $rate, 2);

			$bat = betting_result($row['bt_status'], $info, $type_id[$j]);
			
			
			$bat_type = '';
			if(strtotime($info['gl_datetime']) < G5_SERVER_TIME){
				$bat_type = 'stand';
				$bat_text = lang('대기중', 'Waiting');
			} else if($info['gl_status'] != 'Match Finished'){
				$bat_type = 'on';
				$bat_text = lang('진행중', 'Playing');
				if($bt_type >= 0)
					$bt_type = 1;
			} else {
				$game_chk = game_success_chk($type_id[$j], $info);

				if($game_chk == 1){
					$bat_type = 'hit';
					$bat_text = lang('적중');
					$success++;
				} else {
					$bat_type = 'miss';
					$bat_text = lang('미적중');
					if($bt_type >= 0)
						$bt_type = -1;
				}
			}

			if($bt_type == 0 && $success == 0)
				$type = lang('대기중');
			else if($bt_type == 1 && $success == 0)
				$type = lang('진행중');
			else if($success == $game_cnt)
				$type = lang('적중');
			else if($bt_type == -1)
				$type = lang('미적중');
			else
				$type = $bt_type;
		}
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="hidden" name="mb_id[<?=$i?>]" value="<?=$row['mb_id']?>" id="mb_id_<?=$i?>">
            <input type="hidden" name="exp_id[<?=$i?>]" value="<?=$row['exp_id']?>" id="exp_id_<?=$i?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?=$type?> 내역</label>
            <input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
        </td>
		<td class="td_num"><?=$row['bt_id']?></td>
		<td class="text-center"><?=$row['mb_id']?></td>
        <td class="td_left"><?=team_name($title['gl_type'], $title['gl_home'])?> vs <?=team_name($title['gl_type'], $title['gl_away'])?><?php if($game_cnt > 1) echo ' 외 '.number_format($game_cnt).'경기';?></td>
        <td class="text-right td_num"><?=$bt_dividend?></td>
        <td class="text-right td_num"><?=round_down_format($row['bt_point'], 2)?></td>
        <td class="td_num text-right"><?=round_down_format($row['bt_point'] * $bt_dividend, 2)?></td>
		<td class="td_num"><?=$bat['text']?></td>
        <td class="text-center"><?=date('Y.m.d H:i:s', $row['bt_datetime'])?></td>
		<td class="td_datetime" style="width:200px;">
			<a href="./betting_view.php?<?=$qstr?>&amp;bt_id=<?=$row['bt_id']?>" class="btn btn_02">상세보기</a>
			<a href="./game_form.php?<?=$qstr?>&amp;w=u&amp;gl_id=<?=$row['gl_id']?>" class="btn btn_03 bet_de">삭제</a>
		</td>
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
        if(!confirm("선택한 배팅을 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
$('.bet_de').click(function(){
	if(confirm('선택한 배팅을 정말 삭제하시겠습니까?')){
	} else
		return false;
});
</script>

<?php
include_once ('./admin.tail.php');
?>
