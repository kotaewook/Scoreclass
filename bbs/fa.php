<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
$total = sql_fetch("select count(*) as cnt from {$g5['game_list']} where gl_game_type = 0");
$soccer = sql_fetch("select count(*) as cnt from {$g5['game_list']} where gl_game_type = 0 and gl_type = 0");
$baseball = sql_fetch("select count(*) as cnt from {$g5['game_list']} where gl_game_type = 0 and gl_type = 1");
$basketball = sql_fetch("select count(*) as cnt from {$g5['game_list']} where gl_game_type = 0 and gl_type = 2");

if($game_type == 'soccer')
	$where = "and gl_type = 0";
else if($game_type == 'baseball')
	$where = "and gl_type = 1";
else if($game_type == 'basketball')
	$where = "and gl_type = 2";
else
	$where = '';

$week = array('일','월','화','수','목','금','토');
?>

<section class="sec_fa">
	<nav>
		<ul>
			<li<?php if($where == '') echo ' class="select"';?>><a href="/game">전체보기 <span class="fa_tabmenu_num"><?=number_format($total['cnt'])?></span></a></li>
			<li<?php if($game_type == 'soccer') echo ' class="select"';?>><a href="/game/soccer">축구 <span class="fa_tabmenu_num"><?=number_format($soccer['cnt'])?></span></a></li>
			<li<?php if($game_type == 'baseball') echo ' class="select"';?>><a href="/game/baseball">야구 <span class="fa_tabmenu_num"><?=number_format($baseball['cnt'])?></span></a></li>
			<li<?php if($game_type == 'basketball') echo ' class="select"';?>><a href="/game/basketball">농구 <span class="fa_tabmenu_num"><?=number_format($basketball['cnt'])?></span></a></li>
			<!--li<?php if($game_type == 'soccer') echo ' class="select"';?>><a href="">배구 <span class="fa_tabmenu_num">1</span></a></li>
			<li<?php if($game_type == 'soccer') echo ' class="select"';?>><a href="">하키 <span class="fa_tabmenu_num">1</span></a></li-->
		</ul>
	</nav>

	<table class="fa_sc_h">
		<tr>
			<th>팀 / 시간</th>
			<th>게임종류</th>
			<th>홈(오버)</th>
			<th>무 / 기준</th>
			<th>원정(언더)</th>
		</tr>
	</table>
	<?php
	$rs = sql_query("select gl_type, gl_lg_type from {$g5['game_list']} where gl_game_type = 0 {$where} group by gl_lg_type order by gl_datetime asc");
	while($row = sql_fetch_array($rs)){
		if($row['gl_type'] == 0)
			$flag = sql_fetch("select lg_flag, lg_logo from {$g5['soccer_leagues']} where lg_id = '{$row['gl_lg_type']}'");

		if(!$flag['lg_flag']) $flag['lg_flag'] = $flag['lg_logo'];
	?>
	<div class="fa_sc_list ">
		<p><span class="flag"><img src="<?=$flag['lg_flag']?>"></span><?=league_name($row['gl_type'], $row['gl_lg_type'])?></p>
		<table>
			<tbody>
			<?php
			$gs = sql_query("select * from {$g5['game_list']} where gl_game_type = 0 {$where} and gl_lg_type = '{$row['gl_lg_type']}' order by gl_datetime asc");
			for($i=0; $gow = sql_fetch_array($gs); $i++){
				$home_team = team_name($gow['gl_type'], $gow['gl_home']);
				$away_team = team_name($gow['gl_type'], $gow['gl_away']);

				$sub_sql = "select * from {$g5['game_list']} where gl_id != '{$gow['gl_id']}' and gl_fight_id = '{$gow['gl_fight_id']}' order by gl_game_type asc";

				$cnt = sql_fetch(str_replace('*', 'count(*) as cnt', $sub_sql));
				$sb = sql_query($sub_sql);
			?>
			<tr id="first_info" data-line="<?=$gow['gl_fight_id']?>" data-bat="<?=$gow['gl_id']?>">
				<td class="game_title">
					<table>
						<tr>
							<td class="title"><?=$home_team?> vs <?=$away_team?></td>
						</tr>
						<tr>
							<td><?=date('m/d', strtotime($gow['gl_datetime']))?>(<?=$week[date('w', strtotime($gow['gl_datetime']))]?>) <?=date('H:i', strtotime($gow['gl_datetime']))?></td>
						</tr>
					</table>
				</td>
				<td class="fa_game_type<?=$gow['gl_game_type']?>" id="game_type"><?=game_name($gow['gl_game_type'])?></td>
				<td class="select_game chk" data-type="home">
					<div>
						<span class="team_name"><?=$home_team?></span>
						<span class="di_rate"><?=$gow['gl_home_dividend']?></span>
					</div>
				</td>
				<td class="select_game chk" data-type="draw">
					<div>
						<span class="team_name" style="display:none"><?=lang('무승부', 'Draw')?></span>
						<?php if($gow['gl_criteria'] != 0 && $gow['gl_game_type'] != 0) echo '<span class="hd_num">'.$gow['gl_criteria'].'</span>';?><span class="di_rate"><?=$gow['gl_draw_dividend']?></span>
					</div>
				</td>
				<td class="select_game chk" data-type="away">
					<div>
						<span class="team_name"><?=$away_team?></span>
						<span class="di_rate"><?=$gow['gl_away_dividend']?></span>
					</div>
				</td>
				<td class="more_btn"><?=lang('더보기', 'More')?><br><span class="more_num">(+<?=$cnt['cnt']?>)</span></td>
			</tr>
			<?php for($j=0; $sub = sql_fetch_array($sb); $j++){?>
			<tr data-line="<?=$sub['gl_fight_id']?>" data-bat="<?=$sub['gl_id']?>">
				<td class="game_title"></td>
				<td class="fa_game_type<?=$sub['gl_game_type']?>" id="game_type"><?=game_name($sub['gl_game_type'])?></td>
				<td class="select_game chk" data-type="home">
					<div>
						<span class="team_name"><?=$home_team?></span>
						<span class="di_rate"><?=$sub['gl_home_dividend']?></span>
					</div>
				</td>
				<td class="<?php if($sub['gl_game_type'] != 1 && $sub['gl_game_type'] != 2){?>select_game chk<?php } else echo 'not';?>" data-type="draw">
					<div>
						<span class="team_name" style="display:none"><?=lang('무승부', 'Draw')?></span>
						<?php if($sub['gl_criteria'] != 0 && $sub['gl_game_type'] != 0) echo '<span class="hd_num">'.$sub['gl_criteria'].'</span>';?>
						<?php if($sub['gl_game_type'] != 1 && $sub['gl_game_type'] != 2){?><span class="di_rate"><?=$sub['gl_draw_dividend']?></span><?php }?>
					</div>
				</td>
				<td class="select_game chk" data-type="away">
					<div>
						<span class="team_name"><?=$away_team?></span>
						<span class="di_rate"><?=$sub['gl_away_dividend']?></span>
					</div>
				</td>
				<td></td>
			</tr>
			<?php }?>
			<?php }?>
			</tbody>
		</table>
	</div>
	<?php }?>
	
	<div class="fa_sc_list">
		<p>클럽 친선</p>
		<table>
		  <tr>
			<td>바르셀로나 vs 첼시<br>07/22(월) 00:00</td>
			<td class="fa_game_fa">승무패</td>
			<td><span class="team_name">바르셀로나</span><span class="di_rate">2.36</span></td>
			<td data-type="draw"><span class="di_rate">3.76</span></td>
			<td><span class="team_name">첼시</span><span class="di_rate">3.01</span></td>
			<td>
				<div class="fa_btn_more">더보기<br><span class="more_num">(+10)</span></div>

			</td>
		  </tr>
		  <tr>
			<td></td>
			<td class="fa_game_hd">핸디캡</td>
			<td><span class="team_name">바르셀로나</span><span class="di_rate">9.34</span></td>
			<td class="not" data-type="draw"><span class="hd_num">-2</span><span class="di_rate_cen">6.81</span></td>
			<td><span class="team_name">첼시</span><span class="di_rate">1.24</span></td>
			<td></td>
		  </tr>
		  <tr>
			<td></td>
			<td class="fa_game_un">언오버</td>
			<td><span class="team_name">바르셀로나</span><span class="di_rate">1.18</span></td>
			<td><span class="hd_num_cen">1.5</span></td>
			<td><span class="team_name">첼시</span><span class="di_rate">4.61</span></td>
			<td></td>
		  </tr>
		  <tr>
			<td></td>
			<td rowspan="2" class="fa_game_com">조합</td>
			<td><span class="team_name">홈(승)+언더</span><span class="di_rate">11.75</span></td>
			<td><span class="hd_num">1.5</span><span class="di_rate_cen">17.51</span></td>
			<td><span class="team_name">원정(승)+언더</span><span class="di_rate">3.01</span></td>
			<td></td>
		  </tr>
		  <tr>
			<td></td>
			<td><span class="team_name">홈(승)+오버</span><span class="di_rate">2.36</span></td>
			<td><span class="hd_num">1.5</span><span class="di_rate_cen">4.24</span></td>
			<td><span class="team_name">원정(승)+오버</span><span class="di_rate">3.01</span></td>
			<td></td>
		  </tr>
		</table>
	</div>
</section>

<aside class="aside_fa">
	<?php include_once(G5_PATH.'/login_form.php')?>

	<div class="fa_bat_box">
		<h3 class="bat_tit">배팅박스</h3>
		<form action="/batting" method="post">
			<div class="bat_list_box">
				<div class="bat_list">
					<ul>
					</ul>
				</div>
				<div class="bat_remove">
					전체삭제 <i class="fa fa-times"></i>
				</div>
			</div>
			<div class="bat_form_box">
				<ul class="bat_pt_btn">
					<li><button type="button" value="10000">1만</button></li>
					<li><button type="button" value="50000">5만</button></li>
					<li><button type="button" value="100000">10만</button></li>
					<li><button type="button" value="500000">50만</button></li>
					<li><button type="button" value="<?=round_down($member['mb_cp'], 0)?>">최대</button></li>
					<li><button type="button" value="0">초기화</button></li>
				</ul>
				<input type="text" class="bat_input" name="bat_price" value="0">
				<table>
					<tr>
						<th>배당</th>
						<td class="total_rate">0</td>
					</tr>
					<tr>
						<th>총 배팅포인트</th>
						<td class="set_pt">0</td>
					</tr>
					<tr>
						<th>총 예상적중포인트</th>
						<td class="total_pt">0</td>
					</tr>
				</table>
				<button class="btn_batting">배팅하기</button>
			</div>
		</form>
	</div>


</aside>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>