<?php include_once('../common.php');
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

	<div class="fa_sc_list ">
		<table>
			<tbody>
				<colgroup>
				  <col style="width:34%">
				  <col style="width:20%">
				  <col style="width:34%">
				  <col style="width:12%">
				</colgroup>
				<tr id="first_info" data-line="<?=$gow['gl_fight_id']?>" data-bat="<?=$gow['gl_id']?>">
					<th colspan="4">
						<div class="game_league">
							<span class="flag"><img src="https://media.api-football.com/flags/il.svg"></span>스테이트컵
						</div>						
						<div class="game_date">09/03(화) 14:30</div>
					</th>
				</tr>
				<tr id="first_info" data-line="<?=$gow['gl_fight_id']?>" data-bat="<?=$gow['gl_id']?>">
				
				<td class="select_game chk" data-type="home">
					<div>
						<span class="team_name">바르셀로나</span>
						<span class="di_rate">2.36</span>
					</div>
				</td>
				<td class="select_game chk" data-type="draw">
					<div>
						<span class="team_name" style="display:none"><?=lang('무승부', 'Draw')?></span><span class="di_rate">3.76</span>
					</div>
				</td>
				<td class="select_game chk" data-type="away">
					<div>
						<span class="team_name">첼시</span>
						<span class="di_rate">3.01</span>
					</div>
				</td>
				<td class="more_btn"><?=lang('더보기', 'More')?><br><span class="more_num">(+10)</span></td>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="fa_sc_list ">
		<table>
			<tbody>
				<colgroup>
				  <col style="width:34%">
				  <col style="width:20%">
				  <col style="width:34%">
				  <col style="width:12%">
				</colgroup>
				<tr id="first_info" data-line="<?=$gow['gl_fight_id']?>" data-bat="<?=$gow['gl_id']?>">
					<th colspan="4">
						<div class="game_league">
							<span class="flag"><img src="https://media.api-football.com/flags/dk.svg"></span>덴마크 컵
						</div>						
						<div class="game_date">09/03(화) 14:30</div>
					</th>
				</tr>
				<tr id="first_info" data-line="<?=$gow['gl_fight_id']?>" data-bat="<?=$gow['gl_id']?>">
				
				<td class="select_game chk" data-type="home">
					<div>
						<span class="team_name">바르셀로나</span>
						<span class="di_rate">2.36</span>
					</div>
				</td>
				<td class="select_game chk" data-type="draw">
					<div>
						<span class="team_name" style="display:none"><?=lang('무승부', 'Draw')?></span><span class="di_rate">3.76</span>
					</div>
				</td>
				<td class="select_game chk" data-type="away">
					<div>
						<span class="team_name">첼시</span>
						<span class="di_rate">3.01</span>
					</div>
				</td>
				<td class="more_btn"><?=lang('더보기', 'More')?><br><span class="more_num">(+2)</span></td>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="fa_sc_list ">
		<table>
			<tbody>
				<colgroup>
				  <col style="width:34%">
				  <col style="width:20%">
				  <col style="width:34%">
				  <col style="width:12%">
				</colgroup>
				<tr id="first_info" data-line="<?=$gow['gl_fight_id']?>" data-bat="<?=$gow['gl_id']?>">
					<th colspan="4">
						<div class="game_league">
							<span class="flag"><img src="https://media.api-football.com/flags/md.svg"></span>디비지아 나치오날러
						</div>						
						<div class="game_date">09/03(화) 14:30</div>
					</th>
				</tr>
				<tr id="first_info" data-line="<?=$gow['gl_fight_id']?>" data-bat="<?=$gow['gl_id']?>">
				
				<td class="select_game chk" data-type="home">
					<div>
						<span class="team_name">바르셀로나</span>
						<span class="di_rate">2.36</span>
					</div>
				</td>
				<td class="select_game chk" data-type="draw">
					<div>
						<span class="team_name" style="display:none"><?=lang('무승부', 'Draw')?></span><span class="di_rate">3.76</span>
					</div>
				</td>
				<td class="select_game chk" data-type="away">
					<div>
						<span class="team_name">첼시</span>
						<span class="di_rate">3.01</span>
					</div>
				</td>
				<td class="more_btn"><?=lang('더보기', 'More')?><br><span class="more_num">(+5)</span></td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="fa_bat_box">
		<h3 class="bat_tit">배팅박스<span>닫기 <i class="fa fa-angle-down"></i></span></h3>
		<form action="/batting_ok" method="post">
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
</section>





<?php
include_once(G5_THEME_PATH.'/tail.php');
?>