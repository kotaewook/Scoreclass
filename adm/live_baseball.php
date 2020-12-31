<?php
$sub_menu = "220100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$key = '7ev5tzfujnsb7zxd28ehf5yk';//'qtxg3r55sfrxevzksdtn6unh';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.sportradar.us/baseball/trial/v2/en/schedules/live/summaries.json?api_key={$key}");
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$d = curl_exec($ch);
$list = json_decode($d,true);
curl_close($ch);

$count = count($list['summaries']);
$rs = $list['summaries'];

$g5['title'] = '라이브스코어 - 야구';
include_once ('./admin.head.php');

$colspan = 13;
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">진행중인 게임 내역 </span><span class="ov_num"> <?php echo number_format($count) ?>건 </span></span>
</div>

<div class="tbl_wrap live_bs">
    <table>
	  <col span="16">  
	  <tr>
	  	<th>경기시간</th>
		<th>리그</th>
		<th colspan="2">팀구분</th>
		<?php
		for($i=1; $i<13; $i++)
			echo "<th>{$i}</th>";
		?>
		<th>R</th>
		<th class="tb_1st_hr_bb"><p>첫홈런</p>H</th>
		<th>E</th>
		<th class="tb_1st_hr_bb"><p>첫볼넷</p>B</th>
		<th>기준</th>
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

			$score_cnt = count($row['sport_event_status']['period_scores']);
		?>
	  <tr>
		<td rowspan="2" class="start_time"><?=date('Y.m.d H:i', strtotime($start_time))?></td>
		<td rowspan="2" class="league"><?=$league?></td>
		<td class="team_position">홈팀</td>
		<td class="team"><?=$home_team?><b><?=$home_score?></b></td>
		<?php
		for($j=0; $j<12; $j++)
			echo '<td class="score">'.($j<$score_cnt?$row['sport_event_status']['period_scores'][$j]['home_score']:'').'</td>';
		?>
		<td class="score"><?=$home_score?></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="live_bs_bp"><p>2.17<br><span>-1.5</span></p></td>
	  </tr>
	  <tr>
	  	<td class="team_position">원정팀</td>
		<td class="team"><?=$away_team?><b><?=$away_score?></b></td>
		<?php
		for($j=0; $j<12; $j++)
			echo '<td class="score">'.($j<$score_cnt?$row['sport_event_status']['period_scores'][$j]['away_score']:'').'</td>';
		?>
		<td class="score"><?=$away_score?></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="live_bs_bp"><p>1.74<br><span>9.5</span></p></td>
	  </tr>
	  <?php } if($i == 0) echo '<tr><td colspan="30" class="no-list">'.lang('라이브 스코어가 없습니다.').'</td></tr>';?>
	</table>
</div>

<?php
include_once ('./admin.tail.php');
?>
