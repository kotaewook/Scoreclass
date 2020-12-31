<?php
$sub_menu = "210100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['game_list']} ";

$sql_search = " where (1) and gl_status = '3' ";

if(!$time_start && !$time_finish)
	$sql_search .= " and gl_datetime >= '".strtotime(date('Y/m/d').' 00:00')."' ";
else if($time_start && !$time_finish)
	$sql_search .= " and gl_datetime >= '".strtotime($time_start)."' and gl_datetime <= '".strtotime(date('Y/m/d').' 23:59')."' ";
else if($time_start && !$time_finish)
	$sql_search .= " and gl_datetime >= '".strtotime(date('Y/m/d').' 00:00')."' and gl_datetime <= '".strtotime($time_finish)."' ";
else if($time_start && $time_finish)
	$sql_search .= " and gl_datetime >= '".strtotime($time_start)."' and gl_datetime <= '".strtotime($time_finish)."' ";

if($type == 's') $sql_search .= " and gl_special = '1' ";

if($game_type)
	$sql_search .= " and gl_type = '{$game_type}' ";

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

			$tsm = sql_query("select idx from {$g5['soccer_teams']} where tm_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_home = '{$tms['idx']}' or gl_away = '{$tms['idx']}'";
			}
			$tsm = sql_query("select idx from {$g5['baseball_teams']} where tm_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_home = '{$tms['idx']}' or gl_away = '{$tms['idx']}'";
			}
			$tsm = sql_query("select idx from {$g5['basketball_teams']} where tm_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_home = '{$tms['idx']}' or gl_away = '{$tms['idx']}'";
			}
			$tsm = sql_query("select idx from {$g5['volleyball_teams']} where tm_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_home = '{$tms['idx']}' or gl_away = '{$tms['idx']}'";
			}
			$tsm = sql_query("select idx from {$g5['hockey_teams']} where tm_ko_name like '%{$stx}%'");
			while($tms = sql_fetch_array($tsm)){
				$sql_search1[] = " gl_home = '{$tms['idx']}' or gl_away = '{$tms['idx']}'";
			}
			$sql_search .= implode(' or ', $sql_search1);
			break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "gl_datetime";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod}, gl_id asc ";

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
            {$sql_order} ";
$result = sql_query($sql);

$g5['title'] = '지난 게임';
include_once ('./admin.head.php');
$qstr .= '&time_start='.$_GET['time_start'].'&time_finish='.$_GET['time_finish'];

$colspan = 16;
?>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css" />  
<script type="text/javascript" src="/js/jquery.datetimepicker.full.min.js" charset="UTF-8"></script>
<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">전체 등록된 지난 게임 내역 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
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
<input type="text" name="time_start" value="<?=!$time_start?date('Y/m/d').' 00:00':$time_start?>"class="frm_input text-center" id="time_start">
~
<input type="text" name="time_finish" value="<?=!$time_finish?'':$time_finish?>"class="frm_input text-center" id="time_finish">
<input type="submit" class="btn_submit" value="검색">
</form>

<form name="fpointlist" id="fpointlist" method="post" action="./exp_list_delete.php" onsubmit="return fpointlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="qstr" value="<?php echo $qstr ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
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
		<th scope="col">배팅수</th>
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

		$bat = sql_fetch("select count(*) as cnt from {$g5['batting']} where bt_game like '%{$row['gl_id']}^%' and bt_trade != 2");
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
		<td class="td_num" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=$row['gl_id']?></td>
		<td class="td_num" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=$row['gl_fight_id']?></td>
		<td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=date('Y.m.d H:i', $row['gl_datetime'])?></td>
		<td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=event_game_name($row['gl_type'])?> / <?=league_name($row['gl_type'], $row['gl_lg_type'])?></td>
		<td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=game_name($row['gl_game_type'])?></td>
        <td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=$row['gl_hide']==1?'<b style="color:red">[적중특례]</b> ':''?><?=$home_team.' vs '.$away_team?></td>
        <td class="text-center"><?=$row['gl_game_type'] == 3?team_name(31):$home_team?><br>배팅수 : <?=number_format($home_cnt)?> / 배팅금액 : <?=round_down_format($home_price, 2)?></td>
		<td class="text-center"><?=$row['gl_game_type'] == 3?$gl_home_dividend[0]:$row['gl_home_dividend']?></td>
		<td class="text-center"><?=$row['gl_game_type'] == 3?$gl_draw_dividend[0].' (언더)':$row['gl_draw_dividend']?><br>배팅수 : <?=number_format($draw_cnt2)?> / 배팅금액 : <?=round_down_format($draw_price2, 2)?></td>
		<td class="text-center"><?=$row['gl_game_type'] == 3?$gl_criteria[0]:$row['gl_criteria']?></td>
		<td class="text-center"><?=$row['gl_game_type'] == 3?team_name(51):$away_team?><br>배팅수 : <?=number_format($away_cnt)?> / 배팅금액 : <?=round_down_format($away_price, 2)?></td>
		<td class="text-center"><?=$row['gl_game_type'] == 3?$gl_away_dividend[0]:$row['gl_away_dividend']?></td>
		<td class="text-center" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=$row['gl_home_score']?> : <?=$row['gl_away_score']?><br><?=$row['gl_home_score_list']?> : <?=$row['gl_away_score_list']?></td>
		<td class="td_num" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=number_format($bat['cnt'])?></td>
		<td headers="mb_list_mng" class="td_mng" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>>
			<a href="./game_bet_list.php?<?=$qstr?>&amp;w=u&amp;gl_fight_id=<?=$row['gl_fight_id']?>" class="btn btn_02">배팅목록</a>
			<a href="./game_return.php?gl_fight_id=<?=$row['gl_fight_id']?>" class="btn btn_03">종료취소</a>
		</td>
    </tr>
    <?php
		if($row['gl_game_type'] == 3){
	?>
	<tr class="<?php echo $bg; ?>">
        <td class="text-center"><?=$row['gl_game_type'] == 3?team_name(31, 1):$home_team?><br>배팅수 : <?=number_format($home_cnt2)?> / 배팅금액 : <?=round_down_format($home_price2, 2)?></td>
		<td class="text-center"><?=$gl_home_dividend[1]?></td>
		<td class="text-center"><?=$gl_draw_dividend[1].' (오버)'?><br>배팅수 : <?=number_format($draw_cnt2)?> / 배팅금액 : <?=round_down_format($draw_price2, 2)?></td>
		<td class="text-center"><?=$gl_criteria[1]?></td>
		<td class="text-center"><?=$row['gl_game_type'] == 3?team_name(51, 1):$away_team?><br>배팅수 : <?=number_format($away_cnt2)?> / 배팅금액 : <?=round_down_format($away_price2, 2)?></td>
		<td class="text-center"><?=$gl_away_dividend[1]?></td>
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
	<?php if ($is_admin == 'super') { ?>
    <a href="./game_form.php" id="member_add" class="btn btn_01">게임추가</a>
    <?php } ?>
</div>

</form>

<?php// echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

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
$('#time_start').datetimepicker();
$('#time_finish').datetimepicker();
</script>

<?php
include_once ('./admin.tail.php');
?>
