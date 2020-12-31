<?php include_once('../common.php');
include_once('../head.php');

$sql_common = " from {$g5['batting']} where mb_id = '{$member['mb_id']}' and bt_buy > 0 ";
$sql = "select * {$sql_common}  ";

if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/trade/m_buy_list.php');
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
					<th><?=lang('구매')?><?=$pt_name['rp']?></th>
					<th><?=lang('구매내용')?></th>
					<th><?=lang('구매시간')?></th>
					<th><?=lang('상태')?></th>
				</tr>
				<?php
				$rs = sql_query($sql);
				for($i=0; $row = sql_fetch_array($rs); $i++){
					$time_chk = 999999999999;
					$bat_chk = 0;
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

						$bat = betting_result($row['bt_status'], $info, $type_id[$j]);

						if($bat['type'] == 'on' && $bat_chk == 0)
							$bat_chk = 1;
						else if($bat['type'] == 'hit' && $bat_chk < 2)
							$bat_chk = 2;
						else if($bat['type'] == 'miss' && $bat_chk < 3)
							$bat_chk = 3;
					}

					$bat = betting_result_chk($bat_chk);

					$time = sql_fetch("select td_datetime, td_id, ok_datetime, td_price from {$g5['trade']} where bt_id = '{$row['bt_buy']}'");
				?>
				<tr>
					<td><?=$time['td_id']?></td>
					<td><?=date('Y-m-d', $time['td_datetime'])?><br><?=date('H:i:s', $time['td_datetime'])?></td>
					<td><?=round_down_format($row['bt_point']*$bt_dividend, 2)?></td>
					<td><?=round_down_format($time['td_price'], 2)?></td>
					<td><?=$game_cnt?>경기/<?=$bt_dividend?>배</td>
					<td><?=date('Y-m-d H:i:s', $time['ok_datetime'])?></td>
					<td class="bat_pro_<?=$bat['type']?>">[<?=$bat['text']?>]</td>
				</tr>
				<?php } if($i == 0){?>
				<tr>
					<td colspan="7" class="no-list" style="height:150px;"><?=lang('구매내역이 없습니다.')?></td>
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