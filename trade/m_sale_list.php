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
					$list_id = explode(',', $row['bt_game']);
					$type_id = explode(',', $row['bt_type_list']);
					$game_cnt = count($list_id);
					$list_array = array();

					$title = sql_fetch("select gl_type, gl_home, gl_away from {$g5['game_list']} where gl_id = '{$row['bt_title']}'");
					$title = team_name($title['gl_type'], $title['gl_home']).' vs '.team_name($title['gl_type'], $title['gl_away']).($game_cnt > 1 ? ' 외 '.number_format($game_cnt).'경기' : '');

					for($j=0; $j<$game_cnt; $j++){
						$gl_id = str_replace('^', '', $list_id[$j]);
						$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");
						$list_array[$j] = $info;
						$rate = $info['gl_' . $type_id[$j] . '_dividend'];
						$bt_dividend = round_down(($j == 0 ? 1 : $bt_dividend) * $rate, 2);
						if($time_chk > $info['gl_datetime'])
							$time_chk = $info['gl_datetime'];
						
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

					$time = strtotime('-5 minutes', $time_chk);

					$now_time = $time - G5_SERVER_TIME;

					$minutes = floor($now_time/60);
					$sec = $now_time - ($minutes*60) - 1;
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
						<p>등록시간 <b><?=date('m-d H:i', $row['td_datetime'])?></b><span>베당률: <font><?=$bt_dividend?></font></span></p>
						<p>남은시간 <b id="get_time<?=$row['td_id']?>"><?=$row['ok_datetime']>0?lang('판매완료'):($minutes.'분 '.$sec.'초')?></b><span>당첨예상<?=$pt_name['rp']?>: <font><?=round_down_format($row['bt_point']*$bt_dividend, 2)?></font></span></p>
						<?php if($time > G5_SERVER_TIME && trim($row['ok_datetime']) == ''){?>
						<script>
						setInterval(function(){
							var now = new Date(); 
							var next = new Date(<?=date($time)?>); 

							var gap = Math.round(next.getTime() - now.getTime() / 1000);

							var M = Math.floor(gap / 60);
							var S = Math.floor((gap - M * 60) % 60);
							
							if(M+S < 1)
								$("#get_time<?=$row['td_id']?>").text(lang('판매종료'));
							else
								$("#get_time<?=$row['td_id']?>").text(M + lang('분 ', 'Hour ', ':')+ S + lang('초'));
						}, 1000);
						</script>
						<?php }?>
					</div>
					<div class="bottom">
						<p>판매금액: <b><?=round_down_format($row['td_price'], 2)?></b><?php if(trim($row['ok_datetime']) == ''){?><a href="javascript:trade_cancel(<?=$row['td_id']?>, <?=$row['bt_id']?>);">[취소하기]</a><?php }?></p>
						
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