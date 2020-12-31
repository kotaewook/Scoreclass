<?php include_once('../common.php');
include_once('../head.php');
?>
<div class="exchage_warp">
	<section>
		<?php include_once('trade_top.php')?>
		<div>
			<ul class="trade_list">
				<?php
				$rs = sql_query($sql);
				for($i=0; $row = sql_fetch_array($rs); $i++){
					$time_chk = 999999999999;
					$bat_chk = 0;
					$list_id = explode(',', $row['bt_game']);
					$type_id = explode(',', $row['bt_type_list']);
					$game_cnt = count($list_id);
					$list_array = array();

					$title = sql_fetch("select gl_type, gl_home, gl_away from {$g5['game_list']} where gl_id = '{$row['bt_title']}'");
					$title = team_name($title['gl_type'], $title['gl_home']).' vs '.team_name($title['gl_type'], $title['gl_away']).($game_cnt > 1 ? ' 외 '.number_format($game_cnt).'경기' : '');

					for($j=0; $j<$game_cnt; $j++){
						$gl_id = str_replace('^', '', $list_id[$j]);
						$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");
						$rate = $info['gl_' . $type_id[$j] . '_dividend'];
						$list_array[$j] = $info;
						$bt_dividend = round_down(($j == 0 ? 1 : $bt_dividend) * $rate, 2);
						if($time_chk > $row['gl_datetime'])
							$time_chk = $info['gl_datetime'];

						$bat = betting_result($row['bt_status'], $info, $type_id[$j]);

						if($bat['type'] == 'on' && $bat_chk == 0)
							$bat_chk = 1;
						else if($bat['type'] == 'hit' && $bat_chk < 2)
							$bat_chk = 2;
						else if($bat['type'] == 'miss' && $bat_chk < 3)
							$bat_chk = 3;

						if($info['gl_game_type'] == 0){
							if($type_id[$j] == 'home')
								$list_array[$j]['type'] = lang('승', 'win');
							else if($type_id[$j] == 'draw')
								$list_array[$j]['type'] = lang('무', 'draw');
							else if($type_id[$j] == 'away')
								$list_array[$j]['type'] = lang('패', 'lose');
						} else if($info['gl_game_type'] == 1){
							if($type_id[$j] == 'home')
								$list_array[$j]['type'] = lang('승', 'win');
							else if($type_id[$j] == 'draw')
								$list_array[$j]['type'] = lang('무', 'draw');
							else if($type_id[$j] == 'away')
								$list_array[$j]['type'] = lang('패', 'lose');
						} else if($info['gl_game_type'] == 2){
							if($type_id[$j] == 'home')
								$list_array[$j]['type'] = lang('오버', 'over');
							else if($type_id[$j] == 'draw')
								$list_array[$j]['type'] = lang('무', 'draw');
							else if($type_id[$j] == 'away')
								$list_array[$j]['type'] = lang('언더', 'under');
						} else if($info['gl_game_type'] == 3){
							if($type_id[$j] == 'homeover')
								$list_array[$j]['type'] = lang('홈+오버', 'home+over');
							else if($type_id[$j] == 'drawover')
								$list_array[$j]['type'] = lang('무+오버', 'draw+over');
							else if($type_id[$j] == 'awayover')
								$list_array[$j]['type'] = lang('원정+오버', 'away+over');
							else if($type_id[$j] == 'homeunder')
								$list_array[$j]['type'] = lang('홈+언더', 'home+under');
							else if($type_id[$j] == 'drawunder')
								$list_array[$j]['type'] = lang('무+언더', 'draw+under');
							else if($type_id[$j] == 'awayunder')
								$list_array[$j]['type'] = lang('원정+언더', 'away+under');
						}
					}

					$bat = betting_result_chk($bat_chk);

					$time = sql_fetch("select td_datetime, td_id, ok_datetime, td_price from {$g5['trade']} where bt_id = '{$row['bt_buy']}'");
				?>
				<li>
					<div class="title">
						<p><?=$title?><span><?=$row['td_id']?> <i class="xi xi-arrow-down"></i></span></p>
					</div>
					<ul class="detail">
						<?php for($j=0; $j<$game_cnt; $j++){?>
						<li>
							<span class="title">[<?=game_name($list_array[$j]['gl_game_type'])?>] <?=team_name($list_array[$j]['gl_type'], $list_array[$j]['gl_home'])?> vs <?=team_name($list_array[$j]['gl_type'], $list_array[$j]['gl_away'])?></span>
							<span class="time"><?=date('m-d H:i', $list_array[$j]['gl_datetime'])?></span>
							<span class="type"><?=$list_array[$j]['type']?></span>
						</li>
						<?php }?>
					</ul>
					<div class="info">
						<p>등록시간 <b><?=date('m-d H:i', $time['td_datetime'])?></b><span>베당률: <font><?=$bt_dividend?></font></span></p>
						<p>구매시간 <b><?=date('m-d H:i', $time['ok_datetime'])?></b><span>당첨예상<?=$pt_name['rp']?>: <font><?=round_down_format($row['bt_point']*$bt_dividend, 2)?></font></span></p>
					</div>
					<div class="bottom">
						<p>구매금액: <b><?=round_down_format($time['td_price'], 2)?></b><span class="bat_pro_<?=$bat['type']?>">[<?=$bat['text']?>]</span></p>
						
					</div>
				</li>
				<?php }?>
			</ul>

		</div>
	</section>
</div>
<script>
$('.trade_list > li > .title > p > span').click(function(){
	if($(this).parent().parent().parent().children('.detail').hasClass('show')){
		$(this).parent().parent().parent().children('.detail').removeClass('show');
		$(this).children('i').addClass('xi-arrow-down').removeClass('xi-arrow-up');
	} else {
		$(this).parent().parent().parent().children('.detail').addClass('show');
		$(this).children('i').addClass('xi-arrow-up').removeClass('xi-arrow-down');
	}
});
</script>
<?php include_once('../tail.php');?>