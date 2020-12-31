<?php include_once('../common.php');
include_once(G5_THEME_PATH.'/mobile/head.php');
?>
<section class="sec_fa">
	<nav>
		<ul>
			<li<?php if($game_type == 'all') echo ' class="select"';?>><a href="/game"><span><?=lang('전체보기', 'Total')?></span></a></li>
			<li<?php if($game_type == 'soccer') echo ' class="select"';?>><a href="/game/soccer"><span><?=event_game_name(0)?></span></a></li>
			<li<?php if($game_type == 'baseball') echo ' class="select"';?>><a href="/game/baseball"><span><?=event_game_name(1)?></span></a></li>
			<li<?php if($game_type == 'basketball') echo ' class="select"';?>><a href="/game/basketball"><span><?=event_game_name(2)?></span></a></li>
			<li<?php if($game_type == 'volleyball') echo ' class="select"';?>><a href="/game/volleyball"><span><?=event_game_name(3)?></span></a></li>
			<li<?php if($game_type == 'hockey') echo ' class="select"';?>><a href="/game/hockey"><span><?=event_game_name(4)?></span></a></li>
		</ul>
	</nav>
	<section>
		<div>
			<div>
				<div class="loader"><div><div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><p><?=lang('게임을 불러오는중입니다.<br>잠시만 기다려주세요.', 'No games are registered.', '登録されたゲームがありません。', '没有注册的游戏。')?></p></div></div>
			</div>
		</div>
	</section>
	<div class="fa_bet_box down">
		<h3 class="bat_tit"><?=lang('배팅 BOX', 'Betting Box')?> (<font>0</font>)<span class="open"><b><?=lang('열기', 'Open')?></b> <i class="fa fa-angle-up"></i></span></h3>
		<form action="/batting_ok" method="post">
			<div class="bat_list_box">
				<div class="bat_list">
					<ul>
					</ul>
				</div>
				<div class="bat_remove">
					<?=lang('전체삭제', 'Delete all', '全削除', '全部删除')?> <i class="xi xi-close"></i>
				</div>
			</div>
			<div class="bat_form_box">
				<ul class="bat_pt_btn">
					<li><button type="button" value="100000"><?=lang('100,000')?></button></li>
					<li><button type="button" value="1000000"><?=lang('1,000,000')?></button></li>
					<li><button type="button" value="10000000"><?=lang('10,000,000')?></button></li>
					<li><button type="button" value="50000000"><?=lang('50,000,000')?></button></li>
					<li><button type="button" value="<?=round_down1($member['mb_cp'], 0, true)?>" data-type="max"><?=lang('MAX')?></button></li>
					<li><button type="button" value="0"><?=lang('RESET')?></button></li>
				</ul>
				<table>
					<tr>
						<th><?=lang('배당률', 'Dividend', '配当', '盘率')?></th>
						<td class="total_rate">0</td>
					</tr>
					<tr>
						<th><?=lang('배당 ', 'Total betting ').$pt_name['rp']?></th>
						<td><input type="text" class="bat_input" name="bet_price" value="0"></td>
					</tr>
					<tr>
						<th><?=lang('예상당첨 ', 'Total point ').$pt_name['rp']?></th>
						<td class="total_pt">0</td>
					</tr>
				</table>
				<button class="btn_batting"><?=lang('배팅하기', 'Betting')?></button>
			</div>
		</form>
	</div>
</section>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>