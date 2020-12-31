<?php include_once('../common.php');
include_once('../head.php');

$sql_common = " from {$g5['batting']} a inner join {$g5['game_list']} b on a.bt_title = b.gl_id where mb_id = '{$member['mb_id']}' and bt_trade = 0 and bt_status = 0";
$sql = "select * {$sql_common}  ";

if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/trade/m_sale.php');
    return;
}
?>
<div class="exchage_warp">
	<section>
		<?php include_once('trade_top.php')?>
		<div>
			<table class="trade_tbl">
				<tr>
					<th><?=lang('배팅일시')?></th>
					<th><?=lang('배팅내용')?></th>
					<th><?=lang('배팅')?><?=$pt_name['rp']?></th>
					<th><?=lang('배당율')?></th>
					<th><?=lang('판매')?></th>
				</tr>
				<?php
				$c = 0;
				$rs = sql_query($sql);
				for($i=0; $row = sql_fetch_array($rs); $i++){
					$time_chk = 999999999999;
					$list_id = explode(',', $row['bt_game']);
					$type_id = explode(',', $row['bt_type_list']);
					$game_cnt = count($list_id);

					$title = sql_fetch("select gl_type, gl_home, gl_away from {$g5['game_list']} where gl_id = '{$row['bt_title']}'");

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

					if($now_time < 0)
						continue;

					$title = team_name($title['gl_type'], $title['gl_home']).' vs '.team_name($title['gl_type'], $title['gl_away']).($game_cnt > 1 ? ' 외 '.number_format($game_cnt).'경기' : '');
					$c++;
				?>
				<tr>
					<td><?=date('Y-m-d', $row['bt_datetime'])?><br><?=date('H:i:s', $row['bt_datetime'])?></td>
					<td><?=$title?></td>
					<td><?=round_down_format($row['bt_point'], 2)?></td>
					<td><?=$bt_dividend?></td>
					<td><a href="javascript:trade_sale(<?=$row['bt_id']?>, '<?=$title?>', '<?=$bt_dividend?>', '<?=round_down_format($row['bt_point']*$bt_dividend, 2)?>');">판매하기</a></td>
				</tr>
				<?php } if($c== 0){?>
				<tr>
					<td colspan="5" class="no-list" style="height:150px;"><?=lang('판매 가능한 배팅목록이 없습니다.')?></td>
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