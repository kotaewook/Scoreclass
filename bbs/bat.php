<?php include_once('./_common.php');
if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');
include_once(G5_THEME_PATH.'/head.php');

$week = array('일','월','화','수','목','금','토');

$sql = "select * from {$g5['batting']} where mb_id = '{$member['mb_id']}' order by bt_datetime desc";
$cnt = sql_fetch(str_replace('*', 'count(*) as cnt', $sql));
$rows = $limit < 10 ? 5 : $limit;
if($page < 1) $page = 1;
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql .= " limit {$from_record}, {$rows}";
?>

<section class="bet_detail">
	<div class="bet_detail_list_op">
		<ul>
			<li><a href="/batting_history?page=<?=$page?>">5개 보기</a></li>
			<li><a href="/batting_history?page=<?=$page?>&limit=10">10개 보기</a></li>
			<li><a href="/batting_history?page=<?=$page?>&limit=20">20개 보기</a></li>
		</ul>
	</div>
	<table class="bet_tb_h">
	  <tr>
		<th>번호</th>
		<th colspan="2">구매(배팅)일시</th>
		<th colspan="4">선택경기</th>
		<th>스코어</th>
		<th>상태</th>
	  </tr>
	</table>
	<?php
	$rs = sql_query($sql);
	for($i=0; $row = sql_fetch_array($rs); $i++){
		$chk_time = 999999999999;
		$bt_dividend = $success = 0;
		$list_id = explode(',', $row['bt_game']);
		$type_id = explode(',', $row['bt_type_list']);
		$game_cnt = count($list_id);
		$rowspan = $game_cnt == 1 ? 3 : 3 + $game_cnt;
		$title = sql_fetch("select gl_type, gl_home, gl_away from {$g5['game_list']} where gl_id = '{$row['bt_title']}'");
	?>
	<table class="bet_tb_cont">
	<tr>
		<th rowspan="<?=$rowspan ?>"><?=($cnt['cnt']-(($page-1)*$from_record)-$i)?></th>
		<th colspan="2"><?=date('Y-m-d H:i:s', $row['bt_datetime'])?></th>
		<th colspan="6"><?=team_name($title['gl_type'], $title['gl_home'])?> vs <?=team_name($title['gl_type'], $title['gl_away'])?><?php if($game_cnt > 1) echo lang(' 외 '.($game_cnt-1).'경기');?></th>
	</tr>
	<?php
	for($j=0; $j<$game_cnt; $j++){
		$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$list_id[$j]}'");
		$rate = $info['gl_' . $type_id[$j] . '_dividend'];
		$bt_dividend = round_down(($j == 0 ? 1 : $bt_dividend) * $rate, 2);
		
		if($chk_time  > (int) strtotime($info['gl_datetime']) )
			$chk_time = strtotime($info['gl_datetime']);

		$bet_type = '';
		if(strtotime($info['gl_datetime']) < G5_SERVER_TIME){
			$bet_type = 'stand';
			$bet_text = lang('대기중');
		} else if($info['gl_status'] == ''){
			$bet_type = 'on';
			$bet_text = lang('진행중');
		} else {
			if($info['gl_game_type'] == 0){
				if( ($type_id[$j] == 'home' && $info['gl_home_score'] > $info['gl_away_score']) || ($type_id[$j] == 'away' && $info['gl_home_score'] < $info['gl_away_score']) || ($type_id[$j] == 'draw' && $info['gl_home_score'] == $info['gl_away_score']) ){
					$bet_type = 'hit';
					$bet_text = lang('적중');
					$success++;
				} else {
					$bet_type = 'miss';
					$bet_text = lang('미적중');
				}
			}
		}
	?>
	<tr>
		<td><?=date('m/d', strtotime($info['gl_datetime']))?>(<?=$week[date('w', strtotime($info['gl_datetime']))]?>) <?=date('H:i', strtotime($info['gl_datetime']))?></td>
		<td class="league"><?=league_name($info['gl_type'], $info['gl_lg_type'])?></td>
		<td><?=game_name($info['gl_game_type'])?></td>
		<td class="info">
			<div>
				<div>
					<p class="team_info<?php if($type_id[$j] == 'home') echo ' select'?> home">
						<span class="name"><?=team_name($info['gl_type'], $info['gl_home'])?></span><span class="rate"><?=$info['gl_home_dividend']?></span>
					</p>
				</div>
				<div class="draw">
					<p class="team_info<?php if($type_id[$j] == 'draw') echo ' select'?> draw">
						<span class="rate"><?=$info['gl_draw_dividend']?></span>
					</p>
				</div>
				<div>
					<p class="team_info<?php if($type_id[$j] == 'away') echo ' select'?> away">
						<span class="name"><?=team_name($info['gl_type'], $info['gl_away'])?></span><span class="rate"><?=$info['gl_away_dividend']?></span>
					</p>
				</div>
			</div>
		</td>
		<td class="score">
			<?php if($bet_type == 'on') echo '<span class="bet_tb_liveon">Live</span>';?>
			<?php if($bet_type != 'stand') echo $info['gl_home_score'].' : '.$info['gl_away_score'];?>
		</td>
		<td class="bet_pro_<?=$bet_type?>">[<?=$bet_text?>]</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="8">
			<p>배팅포인트 : <span><?=number_format($row['bt_point'])?></span></p>
			<p>배당률 : <span><?=$bt_dividend?></span></p>
			<p>예상당첨 포인트 : <span><?=round_down_format($row['bt_point']*$bt_dividend, 2)?></span></p>
			<?php

			if(($chk_time - G5_SERVER_TIME) / 300 > 5){
			?>
			<a href="#" class="btn_bet_cancel">배팅취소</a>
			<?php }?>
		</td>
	</tr>

	</table>
	<?php }?>

  <table class="bet_tb_cont">
	  <tr>
		<th rowspan="4">1</th>
		<th colspan="2">2019-07-23 8:00:00</th>
		<th colspan="6">유벤투스 FC vs 인터밀란    외1 경기</th>
	  </tr>
	  <tr>
		<td>07-23(화)
		  20:30</td>
		<td>친선경기</td>
		<td>승무패</td>
		<td><p><span>유벤투스</span><span>1.69</span></p></td>
		<td><p>4.07</p></td>
		<td><p><span>인터밀란</span><span>5.49</span></p></td>
		<td>2 : 1</td>
		<td class="bet_pro_hit">[적중]</td>
	  </tr>
	  <tr>
		<td>07-23(화)
		  09:10</td>
		<td>MLB</td>
		<td>언더오버</td>
		<td><p><span>미네소타</span><span>2.52</span></p></td>
		<td><p>12.5</p></td>
		<td><p><span>뉴욕 양키스</span><span>1.56</span></p></td>
		<td>8 : 6</td>
		<td class="bet_pro_miss">[미적중]</td>
	  </tr>
	  <tr>
		<td colspan="8">
			<p>배팅포인트 : <span>10,000</span></p><p>배당률 : <span>4.25</span></p><p>예상당첨 포인트 : <span>42,500</span></p><span class="bet_result_lose">미당첨</span>
		</td>
	  </tr>
	</table>
</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>