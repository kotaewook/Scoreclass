<?php
$scdate = strtotime('+5 minutes');

if($game_type == 1)
	$where = "and gl_type = 0";
else if($game_type == 2)
	$where = "and gl_type = 1";
else if($game_type == 3)
	$where = "and gl_type = 2";
else if($game_type == 4)
	$where = "and gl_type = 3";
else if($game_type == 5)
	$where = "and gl_type = 4";
else
	$where = '';

$where1 .= $type == 's' ? ' and gl_special = 1' : '';

if($country == 'ko')
	$week = array('일','월','화','수','목','금','토');
elseif($country == 'en')
	$week = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
else
	$week = array('日', '月', '火', '水', '木', '金', '土');

$sdate = date('Y-m-d H:i:s', strtotime('+2 days'));
$sdate = strtotime($sdate);

	$fild_list = "gl_datetime, gl_fight_id, gl_home_{$country}_name as gl_home_name, gl_home_en_name, gl_away_{$country}_name as gl_away_name, gl_away_en_name, gl_id, gl_home, gl_away, gl_game_type, gl_home_dividend, gl_draw_dividend, gl_away_dividend, gl_criteria, gl_lg_{$country}_name as gl_lg_name, gl_lg_en_name, gl_lg_type, gl_game_type";
	$fight_id = '';
	$new_sql = "select * from g5_game_list where (1) {$where} {$where1} and gl_datetime >= '{$scdate}' and gl_show = 1 and gl_status != 3 order by gl_datetime asc, gl_fight_id asc, gl_game_type asc";
	$rs = sql_query(str_replace('*', $fild_list, $new_sql));
	$tcnt = sql_fetch(str_replace('*', 'count(*) as cnt', $new_sql));

	for($ga=0; $row = sql_fetch_array($rs); $ga++){
		$gl_time = $row['gl_datetime'];

		$flag['lg_flag'] = G5_THEME_IMG_URL.'/bullet_sc.png';

		if($row['gl_type'] == 1)
			$flag['lg_flag'] = G5_THEME_IMG_URL.'/bullet_bs.png';
		elseif($row['gl_type'] == 2)
			$flag['lg_flag'] = G5_THEME_IMG_URL.'/bullet_bsk.png';
		elseif($row['gl_type'] == 3)
		$flag['lg_flag'] = G5_THEME_IMG_URL.'/bullet_vo.png';

		$lg_name = $row['gl_lg_name']??$row['gl_lg_en_name'];

		$home_team = $row['gl_home_name']??$row['gl_home_en_name'];
		$away_team = $row['gl_away_name']??$row['gl_away_en_name'];

		$cnt = sql_fetch("select count(*) as cnt from {$g5['game_list']} where gl_fight_id = '{$row['gl_fight_id']}' and gl_id != '{$row['gl_id']}'");

		if($fight_id != $row['gl_fight_id'] || $fight_id == ''){
			if($ga > 0)
				echo '</tbody></table></div>';
	?>
	<div class="fa_sc_list " data-time="<?=$row['gl_datetime']?>">
		<p><span class="flag"><img src="<?=$flag['lg_flag']?>" onerror="this.src='/img/no_profile.gif'"></span><?=$lg_name?></p>

		<table>
			<tbody>

			<tr id="first_info" data-line="<?=$row['gl_fight_id']?>" data-bet="<?=$row['gl_id']?>" data-game="<?=$row['gl_game_type']?>" data-time="<?=$row['gl_datetime']?>">
				<td class="game_title">
					<table>
						<tr>
							<td class="title"><?=$home_team?> vs <?=$away_team?></td>
						</tr>
						<tr>
							<td><?=date('m/d', $gl_time)?>(<?=$week[date('w', $gl_time)]?>) <?=date('H:i', $gl_time)?></td>
						</tr>
					</table>
				</td>
				<td class="fa_game_type<?=$row['gl_game_type']?>" id="game_type"><?=game_name($row['gl_game_type'])?></td>
				<td class="select_game chk" data-type="home">
					<div>
						<span class="team_name"><?php if($row['gl_game_type'] == 2) echo '<img src="/img/arrow_over.png" height="13" style="margin-right:5px;" />';?><?=$home_team?></span>
						<span class="di_rate"><?=round_down1($row['gl_home_dividend'], 2, 1)?></span>
					</div>
				</td>
				<td class="<?php if($row['gl_draw_dividend'] > 0 ){?>select_game chk<?php } ?>" data-type="draw">
					<div>
						<span class="team_name" style="display:none"><?=lang('무승부', 'Draw')?></span>
						<?php if($row['gl_criteria'] != 0 && $row['gl_game_type'] != 0) echo '<span class="hd_num">'.$row['gl_criteria'].'</span>';?>
						<?php if($row['gl_draw_dividend'] > 0){?><span class="di_rate"><?=round_down1($row['gl_draw_dividend'], 2, 1)?></span><?php }?>
					</div>
				</td>
				<td class="select_game chk" data-type="away">
					<div>
						<span class="team_name"><?php if($row['gl_game_type'] == 2) echo '<img src="/img/arrow_under.png" height="13" style="margin-right:5px;" />';?><?=$away_team?></span>
						<span class="di_rate"><?=round_down1($row['gl_away_dividend'], 2, 1)?></span>
					</div>
				</td>
				<td class="more_btn"><span><div><div><?=lang('더보기', 'More')?><br><span class="more_num">(+<?=$cnt['cnt']?>)</span></div></div></span></td>
			</tr>
			<?php
		} if($cnt['cnt'] > 1){
				if($row['gl_game_type'] == 3){
					$gl_home_dividend = explode('^', $row['gl_home_dividend']);
					$gl_draw_dividend = explode('^', $row['gl_draw_dividend']);
					$gl_criteria = explode('^', $row['gl_criteria']);
					$gl_away_dividend = explode('^', $row['gl_away_dividend']);
				}
			?>
			<tr data-line="<?=$row['gl_fight_id']?>" data-bet="<?=$row['gl_id']?>" data-game="<?=$row['gl_game_type']?>">
				<td class="game_title" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>></td>
				<td class="fa_game_type<?=$row['gl_game_type']?>" id="game_type" <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>><?=game_name($row['gl_game_type'])?></td>
				<td class="select_game chk" data-type="home<?php if($row['gl_game_type'] == 3) echo 'under';?>">
					<div>
						<span class="team_name"><?php if($row['gl_game_type'] == 2) echo '<img src="/img/arrow_over.png" height="13" style="margin-right:5px;" />';?><?=$row['gl_game_type'] == 3?team_name(31):$home_team?></span>
						<span class="di_rate"><?=$row['gl_game_type'] == 3?round_down1($gl_home_dividend[0], 2, 1):round_down1($row['gl_home_dividend'], 2, 1)?></span>
					</div>
				</td>
				<td class="<?php if($row['gl_draw_dividend'] > 1){?>select_game chk<?php } else echo 'not';?>" data-type="draw<?php if($row['gl_game_type'] == 3) echo 'under';?>">
					<div>
						<span class="team_name" style="display:none"><?=$row['gl_game_type'] == 3?team_name(41):lang('무승부', 'Draw')?></span>
						<?php if($row['gl_criteria'] != 0 && $row['gl_game_type'] != 0) echo '<span class="hd_num">'.($row['gl_game_type'] == 3?$gl_criteria[0]:$row['gl_criteria']).'</span>';?>
						<?php if($row['gl_draw_dividend'] > 1){?><span class="di_rate"><?=($row['gl_game_type'] == 3?round_down1($gl_draw_dividend[0], 2, 1):round_down1($row['gl_draw_dividend'], 2, 1))?></span><?php }?>
					</div>
				</td>
				<td class="select_game chk" data-type="away<?php if($row['gl_game_type'] == 3) echo 'under';?>">
					<div>
						<span class="team_name"><?php if($row['gl_game_type'] == 2) echo '<img src="/img/arrow_under.png" height="13" style="margin-right:5px;" />';?><?=$row['gl_game_type'] == 3?team_name(51):$away_team?></span>
						<span class="di_rate"><?=$row['gl_game_type'] == 3?round_down1($gl_away_dividend[0], 2, 1):round_down1($row['gl_away_dividend'], 2, 1)?></span>
					</div>
				</td>
				<td <?php if($row['gl_game_type'] == 3) echo ' rowspan="2"';?>></td>
			</tr>
			<?php if($row['gl_game_type'] == 3){?>
			<tr data-line="<?=$gow['gl_fight_id']?>" data-bet="<?=$row['gl_id']?>" data-game="<?=$row['gl_game_type']?>">
				<td class="select_game chk" data-type="homeover">
					<div>
						<span id="game_type" style="display:none;"><?=game_name($row['gl_game_type'])?></span>
						<span class="team_name"><?=$row['gl_game_type'] == 3?team_name(31,1):$home_team?></span>
						<span class="di_rate"><?=round_down1($gl_home_dividend[1], 2, 1)?></span>
					</div>
				</td>
				<td class="<?php if($row['gl_game_type'] != 1 && $row['gl_game_type'] != 2){?>select_game chk<?php  } else echo 'not';?>" data-type="drawover">
					<div>
						<span class="team_name" style="display:none"><?=team_name(41,1)?></span>
						<?php if($gl_criteria[1] != 0 && $row['gl_game_type'] != 0) echo '<span class="hd_num">'.$gl_criteria[1].'</span>';?>
						<?php if($row['gl_game_type'] != 1 && $row['gl_game_type'] != 2){?><span class="di_rate"><?=round_down1($gl_draw_dividend[1], 2, 1)?></span><?php }?>
					</div>
				</td>
				<td class="select_game chk" data-type="awayover">
					<div>
						<span class="team_name"><?=$row['gl_game_type'] == 3?team_name(51,1):$away_team?></span>
						<span class="di_rate"><?=round_down1($gl_away_dividend[1], 2, 1)?></span>
					</div>
				</td>
			</tr>
			<?php
			}
		} 
		$fight_id = $row['gl_fight_id'];
	}
	if($tcnt['cnt']>0)
		echo '</tbody></table></div>';
	if($ga == 0){
	?>
	<p class="no-list"><?=lang('등록된 게임이 없습니다.', 'No games are registered.', '登録されたゲームがありません。', '没有注册的游戏。')?></p>
	<?php }?>