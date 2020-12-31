<?php include_once('../common.php');
if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');

if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/betting/m_betting_history.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');

if($country == 'ko')
	$week = array('일','월','화','수','목','금','토');
elseif($country == 'en')
	$week = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
else
	$week = array('日', '月', '火', '水', '木', '金', '土');

$sql = "select * from {$g5['batting']} where mb_id = '{$member['mb_id']}' and bt_trade != 2 order by bt_datetime desc";
$cnt = sql_fetch(str_replace('*', 'count(*) as cnt', $sql));
$rows = $limit < 10 ? 5 : $limit;
if($page < 1) $page = 1;
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql .= " limit {$from_record}, {$rows}";
?>

<section class="bat_detail">
	<div class="bat_detail_list_op">
		<ul>
			<li><a href="/betting_history?page=<?=$page?>"><?=lang('5개씩 보기', '5 Views')?></a></li>
			<li><a href="/betting_history?page=<?=$page?>&limit=10"><?=lang('10개씩 보기', '10 Views')?></a></li>
			<li><a href="/betting_history?page=<?=$page?>&limit=20"><?=lang('20개씩 보기', '20 Views')?></a></li>
		</ul>
	</div>
	<table class="bat_tb_h">
	  <tr>
		<th><?=lang('번호', 'No')?></th>
		<th colspan="2"><?=lang('배팅일자', 'Betting time')?></th>
		<th colspan="4"><?=lang('선택경기', 'Selective Game')?></th>
		<th><?=lang('스코어', 'Score')?></th>
		<th><?=lang('상태', 'Status')?></th>
	  </tr>
	</table>
	<?php
	$rs = sql_query($sql);
	$chk_time2 = time();
	for($i=0; $row = sql_fetch_array($rs); $i++){
		$chk_time = 999999999999;
		$bt_dividend = $bat_miss = 0;
		$list_id = explode(',', $row['bt_game']);
		$type_id = explode(',', $row['bt_type_list']);
		$rate_id = explode(',', $row['bt_dividend_list']);
		$game_cnt = count($list_id);
		$rowspan = $game_cnt == 1 ? 3 : 3 + $game_cnt;
		$title = sql_fetch("select gl_type, gl_home, gl_away from {$g5['game_list']} where gl_id = '{$row['bt_title']}'");
	?>
	<table class="bat_tb_cont">
	<tr>
		<th rowspan="<?=$rowspan ?>"><?=($cnt['cnt']-(($page-1)*$from_record)-$i)?></th>
		<th colspan="2"><?=date('Y-m-d H:i:s', $row['bt_datetime'])?></th>
		<th colspan="6"><?=team_name($title['gl_type'], $title['gl_home'])?> vs <?=team_name($title['gl_type'], $title['gl_away'])?><?php if($game_cnt > 1) echo lang(' 외 '.($game_cnt-1).'경기', ' and '.($game_cnt-1).' other matches');?></th>
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
		
		if($chk_time  > (int) $info['gl_datetime'])
			$chk_time = $info['gl_datetime'];

		$bat = betting_result($row['bt_status'], $info, $type_id[$j]);

		if($bat['type'] == 'miss')
			$bat_miss = 1;
	?>
	<tr>
		<td><?=date('m/d', $info['gl_datetime'])?>(<?=$week[date('w', $info['gl_datetime'])]?>) <?=date('H:i', $info['gl_datetime'])?></td>
		<td class="league"><?=league_name($info['gl_type'], $info['gl_lg_type'])?></td>
		<td><?=game_name($info['gl_game_type'])?></td>
		<td class="info">
			<div>
				<div>
					<p class="team_info<?php if(strpos($type_id[$j], 'home') !== false) echo ' select'?> home">
						<span class="name"><?=team_name($info['gl_type'], $info['gl_home'])?></span><span class="rate"><?=$info['gl_home_dividend']?></span>
					</p>
				</div>
				<div class="draw">
					<p class="team_info<?php if(strpos($type_id[$j], 'draw') !== false) echo ' select'?> draw">
						<?php if($info['gl_criteria'] != 0 && $info['gl_game_type'] != 0) echo '<span class="rate color">'.$info['gl_criteria'].'</span>';?>
						<?php if($info['gl_draw_dividend'] > 0){?><span class="rate"><?=$info['gl_draw_dividend']?></span><?php }?>
					</p>
				</div>
				<div>
					<p class="team_info<?php if(strpos($type_id[$j], 'away') !== false) echo ' select'?> away">
						<span class="name"><?=team_name($info['gl_type'], $info['gl_away'])?></span><span class="rate"><?=$info['gl_away_dividend']?></span>
					</p>
				</div>
			</div>
		</td>
		<td class="score">
			<?php if($bat['type'] == 'on') echo '<span class="bat_tb_liveon">Live</span>';?>
			<?php if($bat['type'] != 'stand') echo $info['gl_home_score'].' : '.$info['gl_away_score'];?>
		</td>
		<td class="bat_pro_<?=$bat['type']?>">[<?=$bat['text']?>]</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="8">
			<p><?=lang('배팅포인트', 'Betting point')?> : <span><?=number_format($row['bt_point'])?></span></p>
			<p><?=lang('배당률', 'Dividend')?> : <span><?=$bt_dividend?></span></p>
			<p><?=lang('예상당첨 포인트', 'Estimated Attachment Point')?> : <span><?=round_down_format($row['bt_point']*$bt_dividend, 2)?></span></p>
			<?php
			if(($chk_time - G5_SERVER_TIME) / 60 > 5){
			?>
			<a href="/betting/bbs/batting_delete.php?bt_id=<?=$row['bt_id']?>" class="btn_bat_cancel"><?=lang('배팅취소', 'Cancel')?></a>
			<?php } else if($bat_miss == 1) echo '<span class="bat_result_lose">미당첨</span>';?>
		</td>
	</tr>

	</table>
	<?php } if($i == 0) echo '<table width="100%"><tr><td colspan="10" class="no-list text-center">'.lang('배팅내역이 없습니다.', 'No betting details.').'</td></tr></table>';?>

</section>

<script>
$('.btn_bat_cancel').click(function(){
	if(confirm(lang('해당 배팅을 취소하시겠습니까?'))){
	} else
		return false;
});
</script>
<?php include_once(G5_THEME_PATH.'/tail.php');?>