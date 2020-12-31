<?php include_once('../common.php');
add_javascript('<script src="/js/betting.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="/js/ajax_game_load.js?ver='.G5_JS_VER.'"></script>', 0);

if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/betting/m_game.php');
    return;
}

include_once(G5_PATH.'/head.php');

$scdate = strtotime('+5 minutes');
$total_cnt = sql_fetch("select count(a.cnt) as cnt from (select count(*) as cnt from {$g5['game_list']} where gl_datetime >= '{$scdate}' and gl_show = 1 group by gl_fight_id) as a ");
$sc_cnt = sql_fetch("select count(a.cnt) as cnt from (select count(*) as cnt from {$g5['game_list']} where gl_datetime >= '{$scdate}' and gl_show = 1 and gl_type = 0 group by gl_fight_id) as a ");
$bs_cnt = sql_fetch("select count(a.cnt) as cnt from (select count(*) as cnt from {$g5['game_list']} where gl_datetime >= '{$scdate}' and gl_show = 1 and gl_type = 1 group by gl_fight_id) as a ");
$bsk_cnt = sql_fetch("select count(a.cnt) as cnt from (select count(*) as cnt from {$g5['game_list']} where gl_datetime >= '{$scdate}' and gl_show = 1 and gl_type = 2 group by gl_fight_id) as a ");
$vl_cnt = sql_fetch("select count(a.cnt) as cnt from (select count(*) as cnt from {$g5['game_list']} where gl_datetime >= '{$scdate}' and gl_show = 1 and gl_type = 3 group by gl_fight_id) as a ");
$hk_cnt = sql_fetch("select count(a.cnt) as cnt from (select count(*) as cnt from {$g5['game_list']} where gl_datetime >= '{$scdate}' and gl_show = 1 and gl_type = 4 group by gl_fight_id) as a ");
?>

<section class="sec_fa">
	<section>
		<nav>
			<ul>
				<li<?php if($game_type == 'all') echo ' class="select"';?>><a href="/<?=$type=='s'?'special':'game'?>"><?=lang('전체보기', 'Total')?> <b class="fa_tabmenu_num">(<?=$total_cnt['cnt']??0?>)</b></a></li>
				<li<?php if($game_type == 'soccer') echo ' class="select"';?>><a href="/<?=$type=='s'?'special':'game'?>/soccer"><span>&nbsp;</span> <?=event_game_name(0)?> <b class="fa_tabmenu_num">(<?=$sc_cnt['cnt']??0?>)</b></a></li>
				<li<?php if($game_type == 'baseball') echo ' class="select"';?>><a href="/<?=$type=='s'?'special':'game'?>/baseball"><span>&nbsp;</span> <?=event_game_name(1)?> <b class="fa_tabmenu_num">(<?=$bs_cnt['cnt']??0?>)</b></a></li>
				<li<?php if($game_type == 'basketball') echo ' class="select"';?>><a href="/<?=$type=='s'?'special':'game'?>/basketball"><span>&nbsp;</span> <?=event_game_name(2)?> <b class="fa_tabmenu_num">(<?=$bsk_cnt['cnt']??0?>)</b></a></li>
				<li<?php if($game_type == 'volleyball') echo ' class="select"';?>><a href="/<?=$type=='s'?'special':'game'?>/volleyball"><span>&nbsp;</span> <?=event_game_name(3)?> <b class="fa_tabmenu_num">(<?=$vl_cnt['cnt']??0?>)</b></a></li>
				<li<?php if($game_type == 'hockey') echo ' class="select"';?>><a href="/<?=$type=='s'?'special':'game'?>/hockey"><span>&nbsp;</span> <?=event_game_name(4)?> <b class="fa_tabmenu_num">(<?=$hk_cnt['cnt']??0?>)</b></a></li>
			</ul>
		</nav>
		<div>
			<table class="fa_sc_h">
				<col style="width:120px;">
				<col style="width:70px;">
				<col style="width:186px;">
				<col style="width:112px;">
				<col style="width:186px;">
				<col style="width:100px;">
				<tr>
					<th><?=lang('시간', 'Time', '時間', '时间')?></th>
					<th><?=lang('게임종류', 'Game', 'ゲーム', '游戏种类')?></th>
					<th><?=lang('홈(오버)', 'Home(over)', 'ホーム(over)', '主场(Over)')?></th>
					<th><?=lang('무 / 기준', 'Draw / standard', '図面 / 標準', '平/基准')?></th>
					<th><?=lang('원정(언더)', 'Away(under)', 'アウェイ(under)', '客场(under)')?></th>
					<th><?=lang('더보기', 'More')?></th>
				</tr>
			</table>
			<div>

				<div class="loader"><div><div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><p><?=lang('게임을 불러오는중입니다.<br>잠시만 기다려주세요.', 'No games are registered.', '登録されたゲームがありません。', '没有注册的游戏。')?></p></div></div>

			</div>
		</div>
	</section>
	<?=$write_pages?>
</section>

<aside class="aside_fa">
	<?php include_once(G5_PATH.'/login_form.php')?>

	<div class="fa_bet_box">
		<h3 class="bat_tit"><?=lang('배팅 BOX', 'Betting Box')?> (<font>0</font>)</h3>
		<form action="/batting_ok" method="post" autocomplete="off">
			<div class="bat_list_box">
				<div class="bat_remove">
					<?=lang('전체삭제', 'Delete all', '全削除', '全部删除')?> <i class="xi xi-close"></i>
				</div>
				<div class="bat_list">
					<ul>
					</ul>
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


</aside>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>