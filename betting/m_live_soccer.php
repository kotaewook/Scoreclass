<?php
include_once('../common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once('./live_top.php');

add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/live.css">', 0);
add_javascript('<script src="/js/live_score.js?ver='.G5_JS_VER.'"></script>', 0);

$wish_get = get_cookie('scoreclass_live');

$where_start = date('Y-m-d', strtotime($start_date.' days')).' 00:00:00';
$where_finish = date('Y-m-d', strtotime('+'.$finish_date.' days')).' 23:59:59';

$where = " and gl_datetime >= '".strtotime($where_start)."' and gl_datetime <= '".strtotime($where_finish)."'";

$sql = "select gl_home, gl_away, gl_home_score, gl_away_score, gl_type, gl_fight_id, gl_datetime, gl_status, lg_{$country}_name as lg_name, lg_en_name, c.tm_{$country}_name as tm_home, c.tm_en_name as tm_en_home, d.tm_{$country}_name as tm_away, d.tm_en_name as tm_en_away from {$g5['game_list']} a left join {$g5['soccer_leagues']} b on a.gl_lg_type = b.lg_id left join {$g5['soccer_teams']} c on a.gl_home = c.tm_id left join {$g5['soccer_teams']} d on a.gl_away = d.tm_id where gl_type = 0 and gl_status < 4 {$where} group by gl_fight_id order by gl_datetime asc, gl_id asc";

$rs = sql_query($sql);
foreach($rs as $row){
	if(strpos($wish_get, $row['gl_fight_id']) !== false)
		$wish_list[] = $row;

	if($row['gl_status'] == 3 || $date != G5_TIME_YMD)
		$finish_list[] = $row;
	else if(date('Y-m-d', $row['gl_datetime']) == $date)
		$today_list[] = $row;
}
?>

<section class="live_sc">
	<?php include_once('./live_menu.php');?>
	<div class="warp">
	<table class="live_table wish <?php if(count($wish_list) > 0) echo 'view';?>">
		<thead>
		<tr>
			<th colspan="6"><?=lang('관심경기', 'the result of a game', '試合の結果')?><span class="total"><?=lang('전체내리기')?></span></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($wish_list as $wow){
			$league = trim($wow['lg_name']) == '' ? $wow['lg_en_name'] : $wow['lg_name'];
			$home_team = trim($wow['tm_home']) == '' ? $wow['tm_en_home'] : $wow['tm_home'];
			$away_team = trim($wow['tm_away']) == '' ? $wow['tm_en_away'] : $wow['tm_away'];
			$start_time = date('H:i', $wow['gl_datetime']);
			
		?>
		<tr data-num="<?=$wow['gl_fight_id']?>">
			<td colspan="4"><b><?=$league?></b></td>
			<td class="up"><span class="down"></span></td>
		</tr>
		<tr data-num="<?=$wow['gl_fight_id']?>">
			<td class="team" data-id="<?=$wow['gl_home']?>" style="text-align:right;"><?=$home_team?></td>
			<td class="score"><?php if(date('dGi') < date('dGi', strtotime($start_time)) || $date > G5_TIME_YMD) echo '-'; else echo $wow['gl_home_score'];?></td>
			<td class="score"><span class="live_sc_vs">vs</span><br><?=$start_time?></td>
			<td class="score"><?php if(date('dGi') < date('dGi', strtotime($start_time)) || $date > G5_TIME_YMD) echo '-'; else echo $wow['gl_away_score'];?></td>
			<td class="team" data-id="<?=$wow['gl_away']?>"><?=$away_team?></td>
		</tr>
		
		<?php }?>
		</tbody>
	</table>
	<?php
	unset($wish_list);
	$strtime = strtotime($date);
	if($date == G5_TIME_YMD){
	?>
	<table class="live_table live">
		<thead>
			<tr>
				<th colspan="5" class="finish"><?=lang(date('n월 j일', $strtime), date('j - M', $strtime), date('n月 j日', $strtime))?> (<?=$week[date('w', $strtime)]?>)</th>
			</tr>
		</thead>
		<?php
		foreach($today_list as $tow){
			$league = trim($tow['lg_name']) == '' ? $tow['lg_en_name'] : $tow['lg_name'];
			$home_team = trim($tow['tm_home']) == '' ? $tow['tm_en_home'] : $tow['tm_home'];
			$away_team = trim($tow['tm_away']) == '' ? $tow['tm_en_away'] : $tow['tm_away'];
			$start_time = date('H:i', $tow['gl_datetime']);
		?>
		<tbody>
		<tr data-num="<?=$tow['gl_fight_id']?>" class="leagues<?php if(strpos($wish_get, $tow['gl_fight_id']) !== false) echo ' up';?>">
			<td colspan="4"><b><?=$league?></b></td>
			<td class="up"><span class="up"></span></td>
		</tr>
		<tr data-num="<?=$tow['gl_fight_id']?>"<?php if(strpos($wish_get, $tow['gl_fight_id']) !== false) echo ' class="up"';?>>
			<td class="team" data-id="<?=$tow['gl_home']?>" style="text-align:right;"><?=$home_team?></td>
			<td class="score"><?php if(date('dGi') < date('dGi', strtotime($start_time)) || $date > G5_TIME_YMD) echo '-'; else echo $tow['gl_home_score'];?></td>
			<td class="score"><span class="live_sc_vs">vs</span><br><?=$start_time?></td>
			<td class="score"><?php if(date('dGi') < date('dGi', strtotime($start_time)) || $date > G5_TIME_YMD) echo '-'; else echo $tow['gl_away_score'];?></td>
			<td class="team" data-id="<?=$tow['gl_away']?>"><?=$away_team?></td>
		</tr>
		
		</tbody>
		<?php } if(count($today_list) == 0) echo '<tr><td colspan="6" class="no-list">'.lang('라이브 스코어가 없습니다.').'</td></tr>';?>		
	</table>
	<?php
	} unset($today_list);
	$finish_cnt = count($finish_list);
	
	if(($finish_cnt > 0 && $date == G5_TIME_YMD) || $date < G5_TIME_YMD){
	?>
	<table class="live_table live">
		<tr>
			<th colspan="6" class="finish"><?=lang(date('n월 j일', $strtime), date('j - M', $strtime), date('n月 j日', $strtime))?> (<?=$week[date('w', $strtime)]?>) <?=lang('경기결과', 'the result of a game', '試合の結果')?></th>
		</tr>
		<?php
		foreach($finish_list as $fow){
			$league = trim($fow['lg_name']) == '' ? $fow['lg_en_name'] : $fow['lg_name'];
			$home_team = trim($fow['tm_home']) == '' ? $fow['tm_en_home'] : $fow['tm_home'];
			$away_team = trim($fow['tm_away']) == '' ? $fow['tm_en_away'] : $fow['tm_away'];
			$start_time = date('H:i', $fow['gl_datetime']);
		?>
		<tbody>
		<tr data-num="<?=$fow['gl_fight_id']?>"<?php if(strpos($wish_get, $fow['gl_fight_id']) !== false) echo ' class="up"';?>>
			<td class="team" data-id="<?=$fow['gl_home']?>" style="text-align:right;"><?=$home_team?></td>
			<td class="score"><?php if(date('dGi') < date('dGi', strtotime($start_time)) || $date > G5_TIME_YMD) echo '-'; else echo $fow['gl_home_score'];?></td>
			<td class="score"><span class="live_sc_vs">vs</span><br><?=$start_time?></td>
			<td class="score"><?php if(date('dGi') < date('dGi', strtotime($start_time)) || $date > G5_TIME_YMD) echo '-'; else echo $fow['gl_away_score'];?></td>
			<td class="team" data-id="<?=$fow['gl_away']?>"><?=$away_team?></td>
		</tr>
		<tr data-num="<?=$fow['gl_fight_id']?>" class="leagues<?php if(strpos($wish_get, $fow['gl_fight_id']) !== false) echo ' up';?>">
			<td colspan="4"><?=$league?></td>
			<td class="up"><span class="up"></span></td>
		</tr>
		</tbody>
		<?php }	if(count($finish_list) == 0) echo '<tr><td colspan="6" class="no-list">'.lang('경기결과가 없습니다.').'</td></tr>';?>
	</table>
	<?php } else if($date > G5_TIME_YMD){?>
	<table class="live_table live">
		<tr>
			<th colspan="6"><?=lang(date('n월 j일', $strtime), date('j - M', $strtime), date('n月 j日', $strtime))?> (<?=$week[date('w', $strtime)]?>) <?=lang('경기예정', 'the result of a game', '試合の結果')?></th>
		</tr>
		<?php
		foreach($finish_list as $fow){
			$league = trim($fow['lg_name']) == '' ? $fow['lg_en_name'] : $fow['lg_name'];
			$home_team = trim($fow['tm_home']) == '' ? $fow['tm_en_home'] : $fow['tm_home'];
			$away_team = trim($fow['tm_away']) == '' ? $fow['tm_en_away'] : $fow['tm_away'];
			$start_time = date('H:i', $fow['gl_datetime']);
		?>
		<tbody>
		<tr data-num="<?=$fow['gl_fight_id']?>"<?php if(strpos($wish_get, $fow['gl_fight_id']) !== false) echo ' class="up"';?>>
			<td class="team" data-id="<?=$fow['gl_home']?>" style="text-align:right;"><?=$home_team?></td>
			<td class="score"><?php if(date('dGi') < date('dGi', strtotime($start_time)) || $date > G5_TIME_YMD) echo '-'; else echo $fow['gl_home_score'];?></td>
			<td class="score"><span class="live_sc_vs">vs</span><br><?=$start_time?></td>
			<td class="score"><?php if(date('dGi') < date('dGi', strtotime($start_time)) || $date > G5_TIME_YMD) echo '-'; else echo $fow['gl_away_score'];?></td>
			<td class="team" data-id="<?=$fow['gl_away']?>"><?=$away_team?></td>
		</tr>
		<tr data-num="<?=$fow['gl_fight_id']?>" class="leagues<?php if(strpos($wish_get, $fow['gl_fight_id']) !== false) echo ' up';?>">
			<td colspan="4"><?=$league?></td>
			<td class="up"><span class="up"></span></td>
		</tr>
		</tbody>
		<?php } if(count($finish_list) == 0) echo '<tr><td colspan="6" class="no-list">'.lang('경기예정이 없습니다.').'</td></tr>';?>
	</table>
	<?php }  unset($finish_list);?>
	</div>
</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>