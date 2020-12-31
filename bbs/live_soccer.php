<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_THEME_PATH.'/live_tabmenu.php');
require_once G5_PATH.'/vendor/autoload.php';
/*
$response = Unirest\Request::get("https://api-football-v1.p.rapidapi.com/v2/fixtures/date/".date('Y-m-d'),
  array(
    "X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
    "X-RapidAPI-Key" => G5_SCORE_API_KEY
  )
);
*/
?>


<ul class="live_date_tab">
	<li><a href="">7월 20일</a></li>
	<li><a href="">7월 21일</a></li>
	<li><a href=""><span>[오늘]</span> 7월 22일</a></li>
	<li><a href="">7월 23일</a></li>
	<li><a href="">7월 24일</a></li>
</ul>

<section class="live_sc">
	<div class="live_sc_selc">
		<select>
			<option value="">국가별 보기</option>
		</select>
		&nbsp;
		<select>
			<option value="">리그별 보기</option>
			<?php
			for($i=0; $i<$response->body->api->results; $i++){
				$lg_id = $response->body->api->fixtures[$i]->league_id;
				echo '<option value="'.$lg_id.'">'.league_name(0, $lg_id).'</option>';
			}
			?>
		</select>
	</div>

	<table>
		<tr>
			<th>리그명</th>
			<th>경기시작 시간</th>
			<th>홈팀</th>
			<th>점수</th>
			<th>원정팀</th>
		</tr>
		<?php
		for($i=0; $i<$response->body->api->results; $i++){
			$lg_id = $response->body->api->fixtures[$i]->league_id;
			$ht_id = $response->body->api->fixtures[$i]->homeTeam->team_id;
			$aw_id = $response->body->api->fixtures[$i]->awayTeam->team_id;
			$league = sql_fetch("select lg_{$country}_name as lg_name from {$g5['soccer_leagues']} where lg_id = '{$lg_id}'");
			$home_team = sql_fetch("select tm_{$country}_name as tm_name from {$g5['soccer_teams']} where tm_id = '{$ht_id}'");
			$away_team = sql_fetch("select tm_{$country}_name as tm_name from {$g5['soccer_teams']} where tm_id = '{$aw_id}'");
			$start_time = date('H:i', $response->body->api->fixtures[$i]->event_timestamp);
/*
			if(!$away_team['tm_name'] || !$home_team['tm_name']){
				$response1 = Unirest\Request::get("https://api-football-v1.p.rapidapi.com/v2/teams/league/".$lg_id,
				  array(
					"X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
					"X-RapidAPI-Key" => G5_SCORE_API_KEY
				  )
				);
				 
				for($j=0; $j<$response1->body->api->results; $j++){
					$tm_id = $response1->body->api->teams[$j]->team_id;
					$tm_country = $response1->body->api->teams[$j]->country;
					$tm_logo = $response1->body->api->teams[$j]->logo;
					$tm_en_name = $response1->body->api->teams[$j]->name;

					$row = sql_fetch("select * from {$g5['soccer_teams']} where tm_id = '{$tm_id}'");

					if(!$row)
						sql_query("insert into {$g5['soccer_teams']} set lg_id = '{$lg_id}', tm_id = '{$tm_id}', tm_en_name = '{$tm_en_name}', tm_country = '{$tm_country}', tm_logo = '{$tm_logo}'");
				}
			}
*/
			if(date('Y-m-d', $response->body->api->fixtures[$i]->event_timestamp) != date('Y-m-d'))
				continue;
		?>
		<tr>
			<td><?=$league['lg_name']?$league['lg_name']:$lg_id?></td>
			<td><?=$start_time?></td>
			<td data-id="<?=$ht_id?>"><?=team_name(0, $ht_id)?></td>
			<td>
				<?php if(date('dGi') < date('dGi', strtotime($start_time))){?>
				<span class="live_sc_vs">vs</span>
				<?php } else {?>
				<span class="live_sc_score"><?=$response->body->api->fixtures[$i]->goalsHomeTeam?> - <?=$response->body->api->fixtures[$i]->goalsAwayTeam?></span>
				<?php }?>
			</td>
			<td data-id="<?=$aw_id?>"><?=team_name(0, $aw_id)?></td>
		</tr>
		<?php } if($i == 0) echo '<tr><td colspan="10" class="no-list">'.lang('라이브 스코어가 없습니다.').'</td></tr>';?>
	</table>
</section>


<?php
include_once(G5_THEME_PATH.'/tail.php');
?>