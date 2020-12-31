<?php include_once('../common.php');
include_once('../head.php');

$sql_common = " from {$g5['trade']} a inner join {$g5['batting']} b on a.bt_id = b.bt_id where a.mb_id = '{$member['mb_id']}' ";
$sql = "select * {$sql_common}  ";

if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/trade/m_sale_list.php');
    return;
}
?>
<div class="exchage_warp">
	<section>
		<?php include_once('trade_top.php')?>
		<div>
			<table class="trade_tbl">
				<tr>
					<th><?=lang('번호')?></th>
					<th><?=lang('등록시간')?></th>
					<th><?=lang('당첨예상')?><?=$pt_name['rp']?></th>
					<th><?=lang('판매')?><?=$pt_name['rp']?></th>
					<th><?=lang('배팅내용')?></th>
					<th><?=lang('남은시간')?></th>
					<th><?=lang('취소')?></th>
				</tr>
				<?php
				$rs = sql_query($sql);
				for($i=0; $row = sql_fetch_array($rs); $i++){
					$time_chk = 999999999999;
					$list_id = explode(',', $row['bt_game']);
					$type_id = explode(',', $row['bt_type_list']);
					$game_cnt = count($list_id);

					for($j=0; $j<$game_cnt; $j++){
						$gl_id = str_replace('^', '', $list_id[$j]);
						$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");
						$rate = $info['gl_' . $type_id[$j] . '_dividend'];
						$bt_dividend = round_down(($j == 0 ? 1 : $bt_dividend) * $rate, 2);
						if($time_chk > $row['gl_datetime'])
							$time_chk = $info['gl_datetime'];
					}

					$time = strtotime('-5 minutes', $time_chk);

					$now_time = $time - G5_SERVER_TIME;

					$minutes = floor($now_time/60);
					$sec = $now_time - ($minutes*60) - 1;
					if($sec < 0)
						$sec = 0;
				?>
				<tr>
					<td><?=$row['td_id']?></td>
					<td><?=date('Y-m-d', $row['td_datetime'])?><br><?=date('H:i:s', $row['td_datetime'])?></td>
					<td><?=round_down_format($row['bt_point']*$bt_dividend, 2)?></td>
					<td><?=round_down_format($row['td_price'], 2)?></td>
					<td><?=$game_cnt?>경기/<?=$bt_dividend?>배</td>
					<td class="time" id="get_time<?=$row['td_id']?>">
						<span><?=$row['ok_datetime']>0?lang('판매완료'):($minutes+$sec<=0?$minutes.'분 '.$sec.'초':lang('판매실패'))?></span>
						<?php if($time > G5_SERVER_TIME && trim($row['ok_datetime']) == '' && $minutes+$sec>0){?>
						<script>
						setInterval(function(){
							var now = new Date(); 
							var next = new Date(<?=date($time)?>); 

							var gap = Math.round(next.getTime() - now.getTime() / 1000);

							var M = Math.floor(gap / 60);
							var S = Math.floor((gap - M * 60) % 60);
							
							if(M+S < 1)
								$("#get_time<?=$row['td_id']?> > span").text(lang('판매실패'));
							else
								$("#get_time<?=$row['td_id']?> > span").text(M + lang('분 ', 'Hour ', ':')+ S + lang('초'));
						}, 1000);
						</script>
						<?php }?>
					<td><?php if(trim($row['ok_datetime']) == ''){?><a href="javascript:trade_cancel(<?=$row['td_id']?>, <?=$row['bt_id']?>);">취소하기</a><?php }?></td>
				</tr>
				<?php } if($i == 0){?>
				<tr>
					<td colspan="7" class="no-list" style="height:150px;"><?=lang('판매내역이 없습니다.')?></td>
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