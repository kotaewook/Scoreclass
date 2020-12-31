<?php
$sub_menu = "210150";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if($gl_fight_id){
	$game = sql_fetch("select * from {$g5['game_list']} where gl_fight_id = '{$gl_fight_id}' order by gl_id desc");

	$sql_where = array();
	$ge = sql_query("select gl_id from {$g5['game_list']} where gl_fight_id = '{$gl_fight_id}' and gl_home = '{$game['gl_home']}'");
	while($gow = sql_fetch_array($ge))
		$sql_where[] = " bt_game like '%{$gow['gl_id']}^%' ";

	$sql_where = implode(' or ', $sql_where);

	$sql_search = " where ({$sql_where}) ";

	
} else {
	$game = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");
	$sql_search = " where bt_game like '%{$gl_id}^%' ";
}

$sql_common = " from {$g5['batting']} ";



if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "bt_datetime";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($bage < 1) $bage = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$result = sql_query($sql);

$home_team = team_name($game['gl_type'], $game['gl_home']);
$away_team = team_name($game['gl_type'], $game['gl_away']);

$g5['title'] = $home_team.' vs '.$away_team.($gl_fight_id?'':'('.game_name($game['gl_game_type']).')').' 배팅목록';
include_once ('./admin.head.php');

if($country == 'ko')
	$week = array('일','월','화','수','목','금','토');
elseif($country == 'en')
	$week = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
else
	$week = array('日', '月', '火', '水', '木', '金', '土');
?>
<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">해당 게임에 등록된 배팅 내역 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
<input type="hidden" name="gl_id" value="<?php echo $gl_id ?>">
<input type="hidden" name="gl_fight_id" value="<?php echo $gl_fight_id ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>회원아이디</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">
</form>

<form name="fpointlist" id="<?php if(!$gl_fight_id) echo 'view';?>" method="post" action="./exp_list_delete.php" onsubmit="return fpointlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<input type="hidden" name="token" value="">
	<?php

	if($gl_fight_id){
		for($i=0; $row = sql_fetch_array($result); $i++){
		$chk_time = 999999999999;
		$bt_dividend = $success = 0;
		$list_id = explode(',', $row['bt_game']);
		$type_id = explode(',', $row['bt_type_list']);
		$rate_id = explode(',', $row['bt_dividend_list']);
		$game_cnt = count($list_id);
		$rowspan = $game_cnt == 1 ? 3 : 3 + $game_cnt;
		$title = sql_fetch("select gl_type, gl_home, gl_away from {$g5['game_list']} where gl_id = '{$row['bt_title']}'");
	?>
	<section class="bat_detail" id="list">
		<table class="bat_tb_cont">
			<thead>
				<tr>
					<th colspan="2"><b><?=$row['mb_id']?></b></th>
					<th colspan="2"><?=lang('선택경기', 'Selective Game')?></th>
					<th><?=lang('스코어', 'Score')?></th>
					<th><?=lang('상태', 'Status')?></th>
				</tr>
			</thead>
		<tbody>
		<tr>
			<th colspan="2"><?=date('Y-m-d H:i:s', $row['bt_datetime'])?></th>
			<th colspan="6" class="text-left" style="padding:0 20px;"><?=team_name($title['gl_type'], $title['gl_home'])?> vs <?=team_name($title['gl_type'], $title['gl_away'])?><?php if($game_cnt > 1) echo lang(' 외 '.($game_cnt-1).'경기', ' and '.($game_cnt-1).' other matches');?></th>
		</tr>
		<?php

		for($j=0; $j<$game_cnt; $j++){
			$gl_id = str_replace('^', '', $list_id[$j]);
			$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");

			$rate_list = explode('?', $rate_id[$j]);

			$rating = rate_select($type_id[$j], $rate_list);

			$info['gl_home_dividend'] = $rate_list[0];
			$info['gl_draw_dividend'] = $rate_list[1];
			$info['gl_away_dividend'] = $rate_list[2];
			$info['gl_criteria'] = $rate_list[3];

			if($info['gl_hide'] == 1)
				$info['gl_home_dividend'] = $info['gl_draw_dividend'] = $info['gl_away_dividend'] = 1;

			if($info['gl_game_type'] == 3){
				$rate1 = $rating;
				if(strpos($type_id[$j], 'under') !== false)
					$check = 0;
				else
					$check = 1;

				$rate = $rate1[$check];

				$gl_home_dividend = explode('^', $rate_list[0]);
				$info['gl_home_dividend'] = $gl_home_dividend[$check];
				$gl_draw_dividend = explode('^', $rate_list[1]);
				$info['gl_draw_dividend'] = $gl_draw_dividend[$check];
				$gl_criteria = explode('^', $rate_list[3]);
				$info['gl_criteria'] = $gl_criteria[$check];
				$gl_away_dividend = explode('^', $rate_list[2]);
				$info['gl_away_dividend'] = $gl_away_dividend[$check];
			} else
			$rate = $rating;
			$bt_dividend = round_down(($j == 0 ? 1 : $bt_dividend) * $rate, 2);
			
			if($chk_time  > (int) strtotime($info['gl_datetime']) )
				$chk_time = strtotime($info['gl_datetime']);

			$bat = betting_result($row['bt_status'], $info, $type_id[$j]);

			if($bat['type'] == 'miss')
				$bat_miss = 1;
		?>
		<tr<?php if($info['gl_fight_id'] == $gl_fight_id) echo ' style="background:#f1ffe9;"';?>>
			<td><?=date('m/d', $info['gl_datetime'])?>(<?=$week[date('w', $info['gl_datetime'])]?>) <?=date('H:i', $info['gl_datetime'])?></td>
			<td class="league"><?=league_name($info['gl_type'], $info['gl_lg_type'])?></td>
			<td><?=game_name($info['gl_game_type'])?></td>
			<td class="info">
				<div>
					<div>
						<p class="team_info<?php if($type_id[$j] == 'home') echo ' select'?> home">
							<span class="name text-left" style="padding:0 10px;"><?=team_name($info['gl_type'], $info['gl_home'])?></span>
							<span class="rate"><?=round_down1($info['gl_home_dividend'], 2, 1)?></span>
						</p>
					</div>
					<div class="draw">
						<p class="team_info<?php if($type_id[$j] == 'draw') echo ' select'?> draw">
							<?php if($info['gl_criteria'] != 0 && $info['gl_game_type'] != 0) echo '<span class="rate color">'.$info['gl_criteria'].'</span>';?>
							<?php if($info['gl_draw_dividend'] > 0){?><span class="rate"><?=$info['gl_draw_dividend']?></span><?php }?>
						</p>
					</div>
					<div>
						<p class="team_info<?php if($type_id[$j] == 'away') echo ' select'?> away">
							<span class="name text-left" style="padding:0 10px;"><?=team_name($info['gl_type'], $info['gl_away'])?></span>
							<span class="rate"><?=round_down1($info['gl_away_dividend'], 2, 1)?></span>
						</p>
					</div>
				</div>
			</td>
			<td class="score">
				<?php if($bat_type == 'on') echo '<span class="bat_tb_liveon">Live</span>';?>
				<?php if($bat_type != 'stand') echo ($info['gl_game_type']==0?$info['gl_home_score'].' : '.$info['gl_away_score']:$info['gl_home_score_list'].' : '.$info['gl_away_score_list']);?>
			</td>
			<td class="bat_pro_<?=$bat['type']?>">[<?=$bat['text']?>]</td>
		</tr>
		<?php } ?>
		
		<tr>
			<td colspan="8">
				<p><?=lang('배팅포인트', 'Betting point')?> : <span><?=number_format($row['bt_point'])?></span></p>
				<p><?=lang('배당률', 'Dividend')?> : <span><?=$bt_dividend?></span></p>
				<p><?=lang('예상당첨 포인트', 'Estimated Attachment Point')?> : <span><?=round_down_format($row['bt_point']*$bt_dividend, 2)?></span></p>

			</td>
		</tr>
		</tbody>
		</table>
	</section>
	<?php
				} if($i == 0) echo '<table width="100%"><tr><td colspan="10" class="no-list text-center">'.lang('배팅내역이 없습니다.', 'No betting details.').'</td></tr></table>';
		} else {	
	?>
	<table class="bat_tb_h">
		<col width="5%" />
		<col width="10%" />
		<col width="10%" />
		<col width="5%" />
		<col width="55%" />
		<col width="10%" />
		<col width="5%" />
	  <tr>
		<th class="text-center">
			<label for="chkall" class="sound_only">게임 내역 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
		</th>
		<th><?=lang('계정', 'ID')?></th>
		<th><?=lang('배팅일자', 'Betting time')?></th>
		<th><?=lang('게임종류', 'Betting time')?></th>
		<th><?=lang('선택경기', 'Selective Game')?></th>
		<th><?=lang('스코어', 'Score')?></th>
		<th><?=lang('상태', 'Status')?></th>
	  </tr>
	</table>
	<?php
	$rs = sql_query($sql);
	$chk_time2 = time();
	for($i=0; $row = sql_fetch_array($rs); $i++){
		$list_id = explode(',', $row['bt_game']);
		$type_id = explode(',', $row['bt_type_list']);
		$game_cnt = count($list_id);
	?>
	<table class="bat_tb_cont">
		<col width="5%" />
		<col width="10%" />
		<col width="10%" />
		<col width="5%" />
		<col width="55%" />
		<col width="10%" />
		<col width="5%" />
	<?php
	for($j=0; $j<$game_cnt; $j++){
		$gl_id1 = str_replace('^', '', $list_id[$j]);
		if($gl_id != $gl_id1)
			continue;

		$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id1}'");
		if($row['gl_game_type'] == 3){
			if(strpos($type_id[$j], 'under') !== false){
				$rate1 = explode('^', $info['gl_'.str_replace('under', '', $type_id[$j]).'_dividend']);
				$check = 0;
			} else {
				$rate1 = explode('^', $info['gl_'.str_replace('over', '', $type_id[$j]).'_dividend']);
				$check = 1;
			}

			$rate = $rate1[$check];

			$gl_home_dividend = explode('^', $info['gl_home_dividend']);
			$info['gl_home_dividend'] = $gl_home_dividend[$check];
			$gl_draw_dividend = explode('^', $info['gl_draw_dividend']);
			$info['gl_draw_dividend'] = $gl_draw_dividend[$check];
			$gl_criteria = explode('^', $info['gl_criteria']);
			$info['gl_criteria'] = $gl_criteria[$check];
			$gl_away_dividend = explode('^', $info['gl_away_dividend']);
			$info['gl_away_dividend'] = $gl_away_dividend[$check];
		} else
			$rate = $info['gl_' . $type_id[$j] . '_dividend'];

		if($info['gl_hide'] == 1)
			$info['gl_home_dividend'] = $info['gl_draw_dividend'] = $info['gl_away_dividend'] = 1;

		$bat_type = '';
		if($info['gl_hide'] == 1){
			$bat_type = 'hit';
			$bat_text = lang('적중특례');
			$success++;
		} else if($row['bt_status'] == 1){
			$bat_type = 'hit';
			$bat_text = lang('적중');
			$success++;
		} else {
			if($info['gl_datetime'] > G5_SERVER_TIME){
				$bat_type = 'stand';
				$bat_text = lang('대기중', 'Waiting');
			} else {
				$this_success = game_success_chk($info, $type_id[$j]);
				if($this_success == 0){
					$bat_type = 'hit';
					$bat_text = lang('적중');
					$success++;
				} else {
					$bat_type = 'miss';
					$bat_text = lang('미적중');
				}
			}
		}
	?>
	<tr>
		<td class="td_chk text-center">
            <input type="hidden" name="gl_id[<?=$i?>]" value="<?=$row['gl_id']?>" id="gl_id_<?=$i?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only">내역</label>
            <input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
        </td>
		<td class="text-center"><?=$row['mb_id']?></td>
		<td class="text-center"><?=date('Y-m-d H:i:s', $row['bt_datetime'])?></td>
		<td class="text-center" style="border-right:1px solid #e7e7e7;"><?=game_name($info['gl_game_type'])?></td>
		<td class="info">
			<div>
				<div>
					<p class="team_info<?php if(strpos($type_id[$j], 'home') !== false) echo ' select'?> home">
						<span class="name"><?=team_name($info['gl_type'], $info['gl_home'])?></span><span class="rate"><?=$info['gl_home_dividend']?></span>
					</p>
				</div>
				<div class="draw">
					<p class="team_info<?php if(strpos($type_id[$j], 'draw') !== false) echo ' select'?> draw">
						<span class="rate"><?=$info['gl_draw_dividend']?></span>
					</p>
				</div>
				<div>
					<p class="team_info<?php if(strpos($type_id[$j], 'away') !== false) echo ' select'?> away">
						<span class="name"><?=team_name($info['gl_type'], $info['gl_away'])?></span><span class="rate"><?=$info['gl_away_dividend']?></span>
					</p>
				</div>
			</div>
		</td>
		<td class="score text-center">
			<?php if($bat_type == 'on') echo '<span class="bat_tb_liveon">Live</span>';?>
			<?php if($bat_type != 'stand') echo ($info['gl_game_type']==0?$info['gl_home_score'].' : '.$info['gl_away_score']:$info['gl_home_score_list'].' : '.$info['gl_away_score_list']);?>
		</td>
		<td class="bat_pro_<?=$bat_type?> text-center">[<?=$bat_text?>]</td>
	</tr>
	<?php } ?>
	</table>
	<?php }?>
	<?php }?>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $bage, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page={$page}&bage="); ?>
<?php
include_once ('./admin.tail.php');
?>