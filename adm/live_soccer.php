<?php
$sub_menu = "220000";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$key = 'qqkhwt8psn5sa3rr6qqc63vx';//'cbtp2qbg56d6vhk5pq7q7bzf';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.sportradar.com/soccer/trial/v4/en/schedules/live/summaries.json?api_key={$key}");
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$d = curl_exec($ch);
$list = json_decode($d,true);
curl_close($ch);

$count = count($list['summaries']);
$rs = $list['summaries'];

$g5['title'] = '라이브스코어 - 축구';
include_once ('./admin.head.php');

$colspan = 13;
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">진행중인 게임 내역 </span><span class="ov_num"> <?php echo number_format($count) ?>건 </span></span>
</div>

<div class="tbl_wrap live_sc">
    	<table class="live_table">
		<tr>
			<th><?=lang('경기시작 시간', 'Event time')?></th>
			<th><?=lang('리그명', 'League')?></th>
			
			<th><?=lang('홈팀', 'Home')?></th>
			<th><?=lang('점수', 'Score')?></th>
			<th><?=lang('원정팀', 'Away')?></th>
		</tr>
		<?php
		for($i=0; $i<$count; $i++){
			$row = $rs[$i];
			$home_team = $row['sport_event']['competitors'][0]['name'];
			$away_team = $row['sport_event']['competitors'][1]['name'];
			$home_score = $row['sport_event_status']['home_score'];
			$away_score = $row['sport_event_status']['away_score'];
			$status = $row['sport_event_status']['match_status'];

			$league = $row['sport_event']['sport_event_context']['season']['name'];
			$start_time = $row['sport_event']['start_time'];
		?>
		<tr>
			<td class="time"><?=date('Y.m.d H:i', strtotime($start_time))?></td>
			<td class="league"><?=$league?></td>
			
			<td class="team"><?=$home_team?></td>
			<td class="score">
				<?php if(strtotime($start_time) <= G5_SERVER_TIME){?>
				<span class="live_sc_score"><?=$home_score?> : <?=$away_score?></span>
				<?php } else {?>
				<span class="live_sc_vs">vs</span>
				<?php }?>
			</td>
			<td class="team" ><?=$away_team?></td>
		</tr>
		<?php } if($i == 0) echo '<tr><td colspan="5" class="no-list">'.lang('라이브 스코어가 없습니다.').'</td></tr>';?>
		
	</table>
</div>
<?php
include_once ('./admin.tail.php');
?>
