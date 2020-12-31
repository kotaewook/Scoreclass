<?php include_once('../common.php');
include_once('../head.php');

$scdate = strtotime('+5 minutes');

$sql_common = " from {$g5['trade']} a inner join {$g5['batting']} b on a.bt_id = b.bt_id where ok_datetime = '' and bt_first_time  >= '{$scdate}' ";
$sql = "select * {$sql_common}  ";

if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/trade/m_trade.php');
    return;
}
?>
<div class="exchage_warp">
	<section>
		<?php include_once('trade_top.php')?>
		<div>
			<table class="trade_tbl">
				<tr>
					<th><?=lang('거래번호', 'No')?></th>
					<th><?=lang('등록시간', 'Time')?></th>
					<th><?=lang('당첨예상')?><?=$pt_name['rp']?></th>
					<th><?=lang('판매', 'Sales ')?><?=$pt_name['rp']?></th>
					<th><?=lang('배팅내용')?></th>
					<th><?=lang('승률')?></th>
					<th><?=lang('남은시간')?></th>
					<th><?=lang('구매', 'Buy')?></th>
				</tr>
				<?php
				$rs = sql_query($sql);
				for($i=0; $row = sql_fetch_array($rs); $i++){
					$time_chk = 999999999999;
					$list_id = explode(',', $row['bt_game']);
					$type_id = explode(',', $row['bt_type_list']);
					$game_cnt = count($list_id);
					$list_array = array();

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
				<tr>
					<td><?=$row['td_id']?></td>
					<td><?=date('Y-m-d', $row['td_datetime'])?><br><?=date('H:i:s', $row['td_datetime'])?></td>
					<td><?=round_down_format($row['bt_point']*$bt_dividend, 2)?></td>
					<td><?=round_down_format($row['td_price'], 2)?></td>
					<td class="info">
						<span><?=$game_cnt?>경기/<?=$bt_dividend?>배</span>
						<ul>
							<?php for($j=0; $j<$game_cnt; $j++){?>
							<li>
								<span class="time"><?=date('Y-m-d H:i:s', $list_array[$j]['gl_datetime'])?></span>
								<span class="game"><?=game_name($list_array[$j]['gl_game_type'])?></span>
								<span class="title"><?=team_name($list_array[$j]['gl_type'], $list_array[$j]['gl_home'])?> vs <?=team_name($list_array[$j]['gl_type'], $list_array[$j]['gl_away'])?></span>
								<span class="type"><?=$list_array[$j]['type']?></span>
							</li>
							<?php }?>
						</ul>
					</td>
					<td>12.8%</td>
					<td class="time" id="get_time<?=$row['td_id']?>">
						<span><?=$minutes.'분 '.$sec.'초'?></span>
						<?php if($time > G5_SERVER_TIME){?>
						<script>
						setInterval(function(){
							var now = new Date(); 
							var next = new Date(<?=date($time)?>); 

							var gap = Math.round(next.getTime() - now.getTime() / 1000);

							var M = Math.floor(gap / 60);
							var S = Math.floor((gap - M * 60) % 60);
							
							if(M+S < 1)
								$("#get_time<?=$row['td_id']?> > span").text(lang('판매종료'));
							else
								$("#get_time<?=$row['td_id']?> > span").text(M + lang('분 ', 'Hour ', ':')+ S + lang('초'));
						}, 1000);
						</script>
						<?php }?>
					</td>
					<td><?php if($row['mb_id'] != $member['mb_id']){?><a href="javascript:trade_buy(<?=$row['td_id']?>);"><?=lang('구매하기', 'buyiung')?></a><?php }?></td>
				</tr>
				<?php } if($i == 0){?>
				<tr>
					<td colspan="8" class="no-list" style="height:150px;"><?=lang('거래소에 등록된 매물이 없습니다.')?></td>
				</tr>
				<?php }?>
			</table>
		</div>
	</section>
</div>
<aside class="aside_fa">
	<?php include_once(G5_PATH.'/login_form.php')?>
	<div class="right_rank">
		<?php include_once(G5_PATH.'/live_rank.php');?>
	</div>
</aside>
<?php include_once('../tail.php');?>