<?php include_once('../common.php');
include_once(G5_PATH.'/head.sub.php');
$sql = "select * from {$g5['batting']} where bt_id = '{$bt_id}'";
?>
<div id="memo_write" class="new_win">
	<button type="button" onclick="window.close();" class="btn_close">창닫기</button>
    <h1 id="win_title"><?=lang('실시간 적중 내역')?></h1>
	<section class="bat_detail" style="margin:0; padding:20px;">
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
			<th colspan="2"><?=date('Y-m-d H:i:s', $row['bt_datetime'])?></th>
			<th colspan="6" style="border-right:none;"><?=team_name($title['gl_type'], $title['gl_home'])?> vs <?=team_name($title['gl_type'], $title['gl_away'])?><?php if($game_cnt > 1) echo lang(' 외 '.($game_cnt-1).'경기', ' and '.($game_cnt-1).' other matches');?></th>
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

			if($info['gl_type'] != 0){
				$info['gl_home_score'] = $info['gl_home_score_list'];
				$info['gl_away_score'] = $info['gl_away_score_list'];
			}

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
			<td style="width:100px; line-height:1.3;"><?=date('m/d', $info['gl_datetime'])?>(<?=$week[date('w', $info['gl_datetime'])]?>)<br><?=date('H:i', $info['gl_datetime'])?></td>
			<td class="league" style="width:100px; line-height:1.3;"><?=league_name($info['gl_type'], $info['gl_lg_type'])?></td>
			<td style="width:80px; line-height:1.3;"><?=game_name($info['gl_game_type'])?></td>
			<td class="info">
				<div>
					<div style="width:40%;">
						<p class="team_info<?php if(strpos($type_id[$j], 'home') !== false) echo ' select'?> home">
							<span class="name"><?=team_name($info['gl_type'], $info['gl_home'])?></span><span class="rate"><?=$info['gl_home_dividend']?></span>
						</p>
					</div>
					<div class="draw" style="width:20%; text-align:center;">
						<p class="team_info<?php if(strpos($type_id[$j], 'draw') !== false) echo ' select'?> draw" style="width:100%;">
							<?php if($info['gl_criteria'] != 0 && $info['gl_game_type'] != 0) echo '<span class="rate color">'.$info['gl_criteria'].'</span>';?>
							<?php if($info['gl_draw_dividend'] > 0){?><span class="rate"><?=$info['gl_draw_dividend']?></span><?php }?>
						</p>
					</div>
					<div style="width:40%;">
						<p class="team_info<?php if(strpos($type_id[$j], 'away') !== false) echo ' select'?> away">
							<span class="name"><?=team_name($info['gl_type'], $info['gl_away'])?></span><span class="rate"><?=$info['gl_away_dividend']?></span>
						</p>
					</div>
				</div>
			</td>
			<td class="score" style="width:90px;">
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
</div>
<?php
include_once(G5_PATH.'/tail.sub.php');
?>