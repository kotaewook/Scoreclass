<?php
include_once('../common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once('./live_top.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/live.css">', 0);
add_javascript('<script src="/js/live_score.js?ver='.G5_JS_VER.'"></script>', 0);

if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/betting/m_live_baseball.php');
    return;
}

$wish_get = get_cookie('scoreclass_live');

$where_start = date('Y-m-d', strtotime($start_date.' days')).' 00:00:00';
$where_finish = date('Y-m-d', strtotime('+'.$finish_date.' days')).' 23:59:59';

$where = " and gl_datetime >= '".strtotime($where_start)."' and gl_datetime <= '".strtotime($where_finish)."'";

$sql = "select gl_home, gl_away, gl_home_score, gl_away_score, gl_home_score_list, gl_away_score_list, gl_type, gl_fight_id, gl_datetime, gl_status, lg_{$country}_name as lg_name, lg_en_name, c.tm_{$country}_name as tm_home, c.tm_en_name as tm_en_home, d.tm_{$country}_name as tm_away, d.tm_en_name as tm_en_away from {$g5['game_list']} a left join {$g5['baseball_leagues']} b on a.gl_lg_type = b.lg_id left join {$g5['baseball_teams']} c on a.gl_home = c.tm_id left join {$g5['baseball_teams']} d on a.gl_away = d.tm_id where gl_type = 1 and gl_status < 4 {$where} group by gl_fight_id order by gl_datetime asc, gl_id asc";

$rs = sql_query($sql);
foreach($rs as $row){
	if(strpos($wish_get, $row['gl_fight_id']) !== false)
		$wish_list[] = $row;

	if($row['gl_status'] == 3 || $date != G5_TIME_YMD)
		$finish_list[] = $row;
	else if(date('Y-m-d', $row['gl_datetime']) == $date)
		$today_list[] = $row;
}

$strto_2 = strtotime('-2 days');
$strto_1 = strtotime('-1 days');
$strto2 = strtotime('+2 days');
$strto1 = strtotime('+1 days');
?>


<section class="live_bs live_sc live_table">
	<?php include_once('./live_menu.php');?>
	<div class="warp">
	<ul class="live_date_tab">
		<li<?=$date==date('Y-m-d', $strto_2)?' class="select"':''?>><a href="/live/baseball?date=<?=date('Y-m-d', $strto_2)?>"><?=lang(date('n월 j일', $strto_2), date('j - M', $strto_2), date('n月 j日', $strto_2))?></a></li>
		<li<?=$date==date('Y-m-d', $strto_1)?' class="select"':''?>><a href="/live/baseball?date=<?=date('Y-m-d', $strto_1)?>"><?=lang(date('n월 j일', $strto_1), date('j - M', $strto_1), date('n月 j日', $strto_1))?></a></li>
		<li<?=!$date||$date==G5_TIME_YMD?' class="select"':''?>><a href="/live/baseball"><span>[<?=lang('오늘', 'Today', '今日')?>]</span> <?=lang(date('n월 j일'), date('j - M'), date('n月 j日'))?></a></li>
		<li<?=$date==date('Y-m-d', $strto1)?' class="select"':''?>><a href="/live/baseball?date=<?=date('Y-m-d', $strto1)?>"><?=lang(date('n월 j일', $strto1), date('j - M', $strto1), date('n月 j日', $strto1))?></a></li>
		<li<?=$date==date('Y-m-d', $strto2)?' class="select"':''?>><a href="/live/baseball?date=<?=date('Y-m-d', $strto2)?>"><?=lang(date('n월 j일', $strto2), date('j - M', $strto2), date('n月 j日', $strto2))?></a></li>
	</ul>

	<table class="live"> 
		<col width="100px" />
		<col width="100px" />
		<col width="254px" />
		<?php for($i=0; $i<12; $i++){?>
		<col width="20px" />
		<?php }?>
		<tr>
			<th class="time"><?=lang('경기시간', 'Event time')?></th>
			<th class="league"><?=lang('리그', 'League')?></th>
			<th class="team"><?=lang('팀구분', 'Team')?></th>
			<?php
			for($i=1; $i<13; $i++)
			echo "<th>{$i}</th>";
			?>
		</tr>
	</table>
	<table class="wish <?php if(count($wish_list) > 0) echo 'view';?>">
		<col width="100px" />
		<col width="100px" />
		<col width="254px" />
		<?php for($i=0; $i<12; $i++){?>
		<col width="20px" />
		<?php }?>
		<thead>
		<tr>
			<th colspan="15"><?=lang('관심경기', 'the result of a game', '試合の結果')?><span class="total"><?=lang('전체내리기')?></span></th>
		</tr>
		</thead>
		<?php
		$i = -1;
		foreach($wish_list as $wow){
			$league = trim($wow['lg_name']) == '' ? $wow['lg_en_name'] : $wow['lg_name'];
			$home_team = trim($wow['tm_home']) == '' ? $wow['tm_en_home'] : $wow['tm_home'];
			$away_team = trim($wow['tm_away']) == '' ? $wow['tm_en_away'] : $wow['tm_away'];
			$start_time = date('H:i', $wow['gl_datetime']);
		?>
		<tbody>
		  <tr data-num="<?=$wow['gl_fight_id']?>">
			<td rowspan="2" class="start_time"><?=$wow['gl_status']==1?lang('[지연]<br/>'):($wow['gl_status']==4?lang('[경기취소]<br/>'):'')?><?=date('Y.m.d H:i', strtotime($start_time))?></td>
			<td rowspan="2" class="league"><?=$league?></td>
			<td class="team"><span><span><?=lang('Home')?></span><?=$home_team?></span><b class="live_sc_score"><?=$wow['gl_home_score']?></b></td>
			<?php
			$home_score = explode(',', $wow['gl_home_score_list']);
			for($j=0; $j<12; $j++)
				echo '<td class="score">'.$home_score[$j].'</td>';
			?>
		  </tr>
		  <tr data-num="<?=$wow['gl_fight_id']?>">
			<td class="team"><span><span class="away"><?=lang('Away')?></span><?=$away_team?></span><b class="live_sc_score"><?=$wow['gl_away_score']?></b></td>
			<?php
			$away_score = explode(',', $wow['gl_away_score_list']);
			for($j=0; $j<12; $j++)
				echo '<td class="score">'.$away_score[$j].'</td>';
			?>
		  </tr>
		  <tr class="line" data-num="<?=$wow['gl_fight_id']?>">
			<td colspan="3"></td>
			<td colspan="12" class="up"><span class="down"></span></td>
		  </tr>
		</tbody>
		<?php }?>
	</table>
	<?php
	unset($wish_list);
	$strtime = strtotime($date);
	if($date == G5_TIME_YMD){
	?>
	<table class="live"> 
		<col width="100px" />
		<col width="100px" />
		<col width="254px" />
		<?php for($i=0; $i<12; $i++){?>
		<col width="20px" />
		<?php }?>
		<thead>
			<tr>
				<th colspan="15" class="finish"><?=lang(date('n월 j일', $strtime), date('j - M', $strtime), date('n月 j日', $strtime))?> (<?=$week[date('w', $strtime)]?>)</th>
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
		<tr data-num="<?=$tow['gl_fight_id']?>"<?php if(strpos($wish_get, $tow['gl_fight_id']) !== false) echo ' class="up"';?>>
			<td rowspan="2" class="start_time"><?=$tow['gl_status']==1?lang('[지연]').'<br/>':($tow['gl_status']==4?lang('[경기취소]').'<br/>':'')?><?=date('Y.m.d H:i', strtotime($start_time))?></td>
			<td rowspan="2" class="league"><?=$league?></td>
			<td class="team"><span><span><?=lang('Home')?></span><?=$home_team?></span><b class="live_sc_score"><?=$tow['gl_home_score']?></b></td>
			<?php
			$home_score = explode(',', $tow['gl_home_score_list']);
			for($j=0; $j<12; $j++)
			echo '<td class="score">'.$home_score[$j].'</td>';
			?>
		</tr>
		<tr<?php if(strpos($wish_get, $tow['gl_fight_id']) !== false) echo ' class="up"';?> data-num="<?=$tow['gl_fight_id']?>">
			<td class="team"><span><span class="away"><?=lang('Away')?></span><?=$away_team?></span><b class="live_sc_score"><?=$tow['gl_away_score']?></b></td>
			<?php
			$away_score = explode(',', $tow['gl_away_score_list']);
			for($j=0; $j<12; $j++)
			echo '<td class="score">'.$away_score[$j].'</td>';
			?>
		</tr>
		<tr class="line<?php if(strpos($wish_get, $tow['gl_fight_id']) !== false) echo ' up';?>" data-num="<?=$tow['gl_fight_id']?>">
			<td colspan="3"></td>
			<td colspan="12" class="up"><span class="up"></span></td>
		</tr>
	</tbody>
	<?php } if(count($today_list) == 0) echo '<tr><td colspan="15" class="no-list">'.lang('라이브 스코어가 없습니다.').'</td></tr>';?>
	</table>
	<?php
	} unset($today_list);
	$finish_cnt = count($finish_list);
	
	if(($finish_cnt > 0 && $date == G5_TIME_YMD) || $date < G5_TIME_YMD){
	?>
	<table class="live">
		<col width="100px" />
		<col width="100px" />
		<col width="254px" />
		<?php for($i=0; $i<12; $i++){?>
		<col width="20px" />
		<?php }?>
		<tr>
			<th colspan="15" class="finish"><?=lang(date('n월 j일', $strtime), date('j - M', $strtime), date('n月 j日', $strtime))?> (<?=$week[date('w', $strtime)]?>) <?=lang('경기결과', 'the result of a game', '試合の結果')?></th>
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
				<td rowspan="2" class="start_time time"><?=$fow['gl_status']==1?lang('[지연]<br/>'):($fow['gl_status']==4?lang('[경기취소]<br/>'):'')?><?=date('Y.m.d H:i', strtotime($start_time))?></td>
				<td rowspan="2" class="league"><?=$league?></td>
				<td class="team"><span><span><?=lang('Home')?></span><?=$home_team?></span><b class="live_sc_score"><?=$fow['gl_home_score']?></b></td>
				<?php
				$home_score = explode(',', $fow['gl_home_score_list']);
				for($j=0; $j<12; $j++)
					echo '<td class="score">'.$home_score[$j].'</td>';
				?>
			</tr>
			<tr<?php if(strpos($wish_get, $fow['gl_fight_id']) !== false) echo ' class="up"';?> data-num="<?=$fow['gl_fight_id']?>">
				<td class="team"><span><span class="away"><?=lang('Away')?></span><?=$away_team?></span><b class="live_sc_score"><?=$fow['gl_away_score']?></b></td>
				<?php
				$away_score = explode(',', $fow['gl_away_score_list']);
				for($j=0; $j<12; $j++)
					echo '<td class="score">'.$away_score[$j].'</td>';
				?>
			</tr>
			<tr class="line<?php if(strpos($wish_get, $fow['gl_fight_id']) !== false) echo ' up';?>" data-num="<?=$fow['gl_fight_id']?>">
				<td colspan="3"></td>
				<td colspan="12" class="up"><span class="up"></span></td>
			</tr>
		</tbody>
	  <?php } if(count($finish_list) == 0) echo '<tr><td colspan="15" class="no-list">'.lang('라이브 스코어가 없습니다.').'</td></tr>';?>
	</table>
	<?php } else if($date > G5_TIME_YMD){?>
	<table class="live">
		<col width="100px" />
		<col width="100px" />
		<col width="254px" />
		<?php for($i=0; $i<12; $i++){?>
		<col width="20px" />
		<?php }?>
		<tr>
			<th colspan="15" class="finish"><?=lang(date('n월 j일', $strtime), date('j - M', $strtime), date('n月 j日', $strtime))?> (<?=$week[date('w', $strtime)]?>) <?=lang('경기예정', 'the result of a game', '試合の結果')?></th>
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
				<td rowspan="2" class="start_time time"><?=$fow['gl_status']==1?lang('[지연]<br/>'):($fow['gl_status']==4?lang('[경기취소]<br/>'):'')?><?=date('Y.m.d H:i', strtotime($start_time))?></td>
				<td rowspan="2" class="league"><?=$league?></td>
				<td class="team"><span><span><?=lang('Home')?></span><?=$home_team?></span><b class="live_sc_score"><?=$fow['gl_home_score']?></b></td>
				<?php
				$home_score = explode(',', $fow['gl_home_score_list']);
				for($j=0; $j<12; $j++)
					echo '<td class="score">'.$home_score[$j].'</td>';
				?>
			</tr>
			<tr<?php if(strpos($wish_get, $fow['gl_fight_id']) !== false) echo ' class="up"';?> data-num="<?=$fow['gl_fight_id']?>">
				<td class="team"><span><span class="away"><?=lang('Away')?></span><?=$away_team?></span><b class="live_sc_score"><?=$fow['gl_away_score']?></b></td>
				<?php
				$away_score = explode(',', $fow['gl_away_score_list']);
				for($j=0; $j<12; $j++)
					echo '<td class="score">'.$away_score[$j].'</td>';
				?>
			</tr>
			<tr class="line<?php if(strpos($wish_get, $fow['gl_fight_id']) !== false) echo ' up';?>" data-num="<?=$fow['gl_fight_id']?>">
				<td colspan="3"></td>
				<td colspan="12" class="up"><span class="up"></span></td>
			</tr>
		</tbody>
		<?php } if(count($finish_list) == 0) echo '<tr><td colspan="15" class="no-list">'.lang('경기예정이 없습니다.').'</td></tr>';?>
	</table>
	<?php }  unset($finish_list);?>
	</div>
</section>
<aside class="aside_fa">
	<?php include_once(G5_PATH.'/login_form.php')?>
	<div class="right_rank">
		<?php include_once(G5_PATH.'/live_rank.php');?>
	</div>
</aside>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>