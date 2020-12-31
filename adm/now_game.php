<?php
$sub_menu = "210130";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$scdate = strtotime('+5 minutes');
$sql_common = " from {$g5['game_list']} ";

$sql_search = " where gl_datetime >= '{$scdate}' and gl_show = 1 and gl_status = '' and gl_hide != 1 ";

if($type == 's') $sql_search .= " and gl_special = '1' ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'gl_datetime' :
			$stx = strtotime($stx);
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
		case 'gl_lg_type' :
			$sql_search1 = array();

			$tsm = sql_query("select lg_id from {$g5['soccer_leagues']} where lg_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_lg_type = '{$tms['lg_id']}' ";
			}
			$tsm = sql_query("select lg_id from {$g5['baseball_leagues']} where lg_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_lg_type = '{$tms['lg_id']}' ";
			}
			$tsm = sql_query("select lg_id from {$g5['basketball_leagues']} where lg_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_lg_type = '{$tms['lg_id']}' ";
			}
			$sql_search .= implode(' or ', $sql_search1);
			break;
		case 'gl_home' :
			$sql_search1 = array();

			$tsm = sql_query("select tm_id from {$g5['soccer_teams']} where tm_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_home = '{$tms['tm_id']}' or gl_away = '{$tms['tm_id']}'";
			}
			$tsm = sql_query("select tm_id from {$g5['baseball_teams']} where tm_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_home = '{$tms['tm_id']}' or gl_away = '{$tms['tm_id']}'";
			}
			$tsm = sql_query("select tm_id from {$g5['basketball_teams']} where tm_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_home = '{$tms['tm_id']}' or gl_away = '{$tms['tm_id']}'";
			}
			$sql_search .= implode(' or ', $sql_search1);
			break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if(trim($_GET['game_type']) != '' && $_GET['game_type'] >= 0)
	$sql_search .= " and gl_type = '{$game_type}'";

if (!$sst) {
    $sst  = "gl_datetime";
    $sod = "asc";
}
$sql_order = " order by {$sst} {$sod}, gl_type asc, gl_lg_type asc, gl_fight_id asc, gl_game_type asc ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$result = sql_query($sql);

$g5['title'] = '진행중인 게임';
include_once ('./admin.head.php');

$colspan = 16;
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">전체 등록된 게임 내역 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
<select name="game_type" id="game_type">
	<option value=""<?php if(trim($_GET['game_type']) == '' || $_GET['game_type'] < 0) echo 'selected'; ?>>전체</option>
    <option value="0"<?php if(trim($_GET['game_type']) != '' && $_GET['game_type'] == 0) echo 'selected'; ?>>축구</option>
	<option value="1"<?php echo get_selected($_GET['game_type'], 1); ?>>야구</option>
	<option value="2"<?php echo get_selected($_GET['game_type'], 2); ?>>농구</option>
	<option value="3"<?php echo get_selected($_GET['game_type'], 3); ?>>배구</option>
	<option value="4"<?php echo get_selected($_GET['game_type'], 4); ?>>하키</option>
</select>
<select name="sfl" id="sfl">
    <option value="gl_id"<?php echo get_selected($_GET['sfl'], "gl_id"); ?>>게임번호</option>
	<option value="gl_fight_id"<?php echo get_selected($_GET['sfl'], "gl_fight_id"); ?>>경기번호</option>
	<option value="gl_lg_type"<?php echo get_selected($_GET['sfl'], "gl_lg_type"); ?>>리그이름</option>
	<option value="gl_home"<?php echo get_selected($_GET['sfl'], "gl_home"); ?>>팀이름</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?=$sfl=='gl_datetime'?date('Y-m-d H:i:s'):$stx?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">
</form>

<form name="fpointlist" id="fpointlist" method="post" action="./game_list_delete.php" onsubmit="return fpointlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="qstr" value="<?php echo $qstr ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="w" value="">
<input type="hidden" name="now" value="1">
<input type="hidden" name="type" value="<?=$type?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">게임 내역 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
		<th scope="col">출력</th>
		<th scope="col"><?php echo subject_sort_link('gl_id') ?>게임 번호</a></th>
		<th scope="col"><?php echo subject_sort_link('gl_fight_id') ?>경기 번호</a></th>
        <th scope="col"><?php echo subject_sort_link('gl_datetime') ?>경기시간</a></th>
        <th scope="col">종목</th>
		<th scope="col"><?php echo subject_sort_link('gl_game_type') ?>종류</a></th>
        <th scope="col">경기</th>
		<th scope="col" colspan="2">홈(오버)</th>
		<th scope="col">무</th>
        <th scope="col">기준</th>
		<th scope="col" colspan="2">원정(언더)</th>
		<th scope="col">스코어</th>
		<th scope="col">적중특례</th>
		<th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
		$home_team = team_name($row['gl_type'], $row['gl_home']);
		$away_team = team_name($row['gl_type'], $row['gl_away']);
		if($row['gl_game_type'] == 3){
			$gl_home_dividend = explode('^', $row['gl_home_dividend']);
			$gl_draw_dividend = explode('^', $row['gl_draw_dividend']);
			$gl_criteria = explode('^', $row['gl_criteria']);
			$gl_away_dividend = explode('^', $row['gl_away_dividend']);
		}
		
		$home_cnt = $home_price = $draw_cnt = $draw_price = $away_cnt = $away_price = $home_cnt2 = $home_price2 = $draw_cnt2 = $draw_price2 = $away_cnt2 = $away_price2 = 0;
		$bt_ct = sql_query("select * from {$g5['batting']} where bt_game like '%{$row['gl_id']}^%' and bt_trade != 2");
		while($btc = sql_fetch_array($bt_ct)){
			$list_id = explode(',', $btc['bt_game']);
			$type_id = explode(',', $btc['bt_type_list']);
			$game_cnt = count($list_id);

			for($j=0; $j<$game_cnt; $j++){
				$gl_id = str_replace('^', '', $list_id[$j]);
				if($gl_id != $row['gl_id'])
					continue;

				if($type_id[$j] == 'home' || $type_id[$j] == 'homeover'){
					$home_cnt++;
					$home_price += $btc['bt_point'];
				} else if($type_id[$j] == 'draw' || $type_id[$j] == 'drawunder'){
					$draw_cnt++;
					$draw_price += $btc['bt_point'];
				} else if($type_id[$j] == 'away' || $type_id[$j] == 'awayunder'){
					$away_cnt++;
					$away_price += $btc['bt_point'];
				} else if($type_id[$j] == 'homeunder'){
					$home_cnt2++;
					$home_price2 += $btc['bt_point'];
				} else if($type_id[$j] == 'drawover'){
					$draw_cnt2++;
					$draw_price2 += $btc['bt_point'];
				} else if($type_id[$j] == 'awayover'){
					$away_cnt2++;
					$away_price2 += $btc['bt_point'];
				}
			}
		}
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_chk" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>>
            <input type="hidden" name="gl_id[<?=$i?>]" value="<?=$row['gl_id']?>" id="gl_id_<?=$i?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only">내역</label>
            <input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
        </td>
		<td class="td_chk" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>>
            <label for="chk1_<?php echo $i; ?>" class="sound_only">내역</label>
            <input type="checkbox" name="gl_show[<?=$i?>]" value="1" id="gl_show_<?=$i?>" <?=get_checked($row['gl_show'], 1)?>>
        </td>
		<td class="td_num" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=$row['gl_id']?></td>
		<td class="td_num" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=$row['gl_fight_id']?></td>
		<td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=date('Y.m.d H:i', $row['gl_datetime'])?></td>
		<td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=event_game_name($row['gl_type'])?> / <?=league_name($row['gl_type'], $row['gl_lg_type'])?></td>
		<td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=game_name($row['gl_game_type'])?></td>
        <td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=$row['gl_hide']==1?'<b style="color:red">[적중특례]</b> ':''?><?=($row['gl_show']==0?'<b style="color:red">':'').$home_team.' vs '.$away_team.($row['gl_show']==0?'</b>':'')?></td>
        <td class="text-center"><?=$row['gl_game_type'] == 3?team_name(31):$home_team?><br>배팅수 : <?=number_format($home_cnt)?> / 배팅금액 : <?=round_down_format($home_price, 2)?></td>
		<td class="text-center">
			<input type="text" name="gl_home_dividend[<?=$i?>][0]" value="<?=$row['gl_game_type'] == 3?$gl_home_dividend[0]:$row['gl_home_dividend']?>" id="gl_home_dividend_<?=$i?>" style="width:30px; text-align:center; font-size:11px;">
		</td>
		<td class="text-center">
			<input type="text" name="gl_draw_dividend[<?=$i?>][0]" value="<?=$row['gl_game_type'] == 3?$gl_draw_dividend[0]:$row['gl_draw_dividend']?>" id="gl_draw_dividend_<?=$i?>" style="width:30px; text-align:center; font-size:11px;"><br>배팅수 : <?=number_format($draw_cnt)?> / 배팅금액 : <?=round_down_format($draw_price, 2)?>
		</td>
		<td class="text-center">
			<input type="text" name="gl_criteria[<?=$i?>][0]" value="<?=$row['gl_game_type'] == 3?$gl_criteria[0]:$row['gl_criteria']?>" id="gl_criteria_<?=$i?>" style="width:30px; text-align:center; font-size:11px;">
		</td>
		<td class="text-center"><?=$row['gl_game_type'] == 3?team_name(51):$away_team?><br>배팅수 : <?=number_format($away_cnt)?> / 배팅금액 : <?=round_down_format($away_price, 2)?></td>
		<td class="text-center">
			<input type="text" name="gl_away_dividend[<?=$i?>][0]" value="<?=$row['gl_game_type'] == 3?$gl_away_dividend[0]:$row['gl_away_dividend']?>" id="gl_away_dividend_<?=$i?>" style="width:30px; text-align:center; font-size:11px;">
		</td>
		<td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>>
			<input type="text" name="gl_home_score[<?=$i?>]" value="<?=$row['gl_home_score']?>" id="gl_home_score_<?=$i?>" style="width:30px; text-align:center; font-size:11px;">
			: 
			<input type="text" name="gl_away_score[<?=$i?>]" value="<?=$row['gl_away_score']?>" id="gl_away_score_<?=$i?>" style="width:30px; text-align:center; font-size:11px;">
		</td>
		<td class="td_chk" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>>
            <label for="chk1_<?php echo $i; ?>" class="sound_only">내역</label>
            <input type="checkbox" name="gl_hide[<?=$i?>]" value="1" id="gl_hide_<?=$i?>" <?=get_checked($row['gl_hide'], 1)?>>
        </td>
		<td headers="mb_list_mng" class="" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>>
			<a href="./game_bet_list.php?<?=$qstr?>&amp;w=u&amp;gl_fight_id=<?=$row['gl_fight_id']?>" class="btn btn_02">배팅목록</a>
			<a href="./game_form.php?<?=$qstr?>&amp;w=u&amp;gl_id=<?=$row['gl_id']?>&game_type=<?=$game_type?>&now=1&pg=now_game" class="btn btn_03">수정</a>
		</td>
    </tr>
    <?php
		if($row['gl_game_type'] == 3){
	?>
	<tr class="<?php echo $bg; ?>">
        <td class="text-center"><?=$row['gl_game_type'] == 3?team_name(31, 1):$home_team?><br>배팅수 : <?=number_format($home_cnt2)?> / 배팅금액 : <?=round_down_format($home_price2, 2)?></td>
		<td class="text-center">
			<input type="text" name="gl_home_dividend[<?=$i?>][1]" value="<?=$gl_home_dividend[1]?>" id="gl_home_dividend1_<?=$i?>" style="width:30px; text-align:center; font-size:11px;">
		</td>
		<td class="text-center">
			<input type="text" name="gl_draw_dividend[<?=$i?>][1]" value="<?=$gl_draw_dividend[1]?>" id="gl_draw_dividend1_<?=$i?>" style="width:30px; text-align:center; font-size:11px;"><br>배팅수 : <?=number_format($draw_cnt2)?> / 배팅금액 : <?=round_down_format($draw_price2, 2)?>
		</td>
		<td class="text-center">
			<input type="text" name="gl_criteria[<?=$i?>][1]" value="<?=$gl_criteria[1]?>" id="gl_criteria1_<?=$i?>" style="width:30px; text-align:center; font-size:11px;">
		</td>
		<td class="text-center"><?=$row['gl_game_type'] == 3?team_name(51, 1):$away_team?><br>배팅수 : <?=number_format($away_cnt2)?> / 배팅금액 : <?=round_down_format($away_price2, 2)?></td>
		<td class="text-center">
			<input type="text" name="gl_away_dividend[<?=$i?>][1]" value="<?=$gl_away_dividend[1]?>" id="gl_away_dividend1_<?=$i?>" style="width:30px; text-align:center; font-size:11px;">
		</td>
    </tr>
	<?php
		}
    }

    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
	<input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">
	<?php if ($is_admin == 'super') { ?>
    <a href="./game_form.php?type=<?=$type?>" id="member_add" class="btn btn_01">게임추가</a>
    <?php } ?>
</div>

</form>

<?php //echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

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

	if(document.pressed == "선택수정") {
		$('input[name="w"]').val('u');
    }

    return true;
}
$('.game_finish').click(function(){
	if(confirm('경기종료 후 배팅처리가되며 이후 정보를 수정할 수 없습니다.\n정말 경기종료 처리하시겠습니까?')){
	} else
		return false;
});
</script>

<?php
include_once ('./admin.tail.php');
?>
