<?php
$sub_menu = "200200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['batting']} ";

$sql_search = " where bt_id = '{$bt_id}' ";


$sql = " select *
            {$sql_common}
            {$sql_search} ";
$row = sql_query($sql);

if(!$row)
	alert('잘못된 접근입니다.');

$g5['title'] = '배팅 상세정보';
include_once ('./admin.head.php');

if($country == 'ko')
	$week = array('일','월','화','수','목','금','토');
elseif($country == 'en')
	$week = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
else
	$week = array('日', '月', '火', '水', '木', '金', '土');
?>

<section class="bat_detail" id="list">
	<?php
	$rs = sql_query($sql);
	$chk_time2 = time();
	for($i=0; $row = sql_fetch_array($rs); $i++){
		$chk_time = 999999999999;
		$bt_dividend = $success = 0;
		$list_id = explode(',', $row['bt_game']);
		$type_id = explode(',', $row['bt_type_list']);
		$rate_id = explode(',', $row['bt_dividend_list']);
		$game_cnt = count($list_id);
		$rowspan = $game_cnt == 1 ? 3 : 3 + $game_cnt;
		$title = sql_fetch("select gl_type, gl_home, gl_away from {$g5['game_list']} where gl_id = '{$row['bt_title']}'");
	?>
	<table class="bat_tb_cont">
		<thead>
			<tr>
				<th colspan="2"><?=lang('배팅일시', 'Betting time')?></th>
				<th colspan="2"><?=lang('선택경기', 'Selective Game')?></th>
				<th><?=lang('스코어', 'Score')?></th>
				<th><?=lang('상태', 'Status')?></th>
			</tr>
		</thead>
	<tbody>
	<tr>
		<th colspan="2"><?=date('Y-m-d H:i:s', $row['bt_datetime'])?></th>
		<th colspan="6" class="text-left" style="padding:0 20px;"><?=team_name($title['gl_type'], $title['gl_home'])?> vs <?=team_name($title['gl_type'], $title['gl_away'])?><?php if($game_cnt > 1) echo lang(' 외 '.($game_cnt-1).'경기', ' and '.($game_cnt-1).' other matches');?></th>
	</tr>
	<?php
	for($j=0; $j<$game_cnt; $j++){
		$gl_id = str_replace('^', '', $list_id[$j]);
		$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");

		$rate_list = explode('?', $rate_id[$j]);

		$rating = rate_select($type_id[$j], $rate_list);

		$info['gl_home_dividend'] = $rate_list[0];
		$info['gl_draw_dividend'] = $rate_list[1];
		$info['gl_away_dividend'] = $rate_list[2];
		$info['gl_criteria'] = $rate_list[3];

		if($info['gl_game_type'] == 3){
			$rate1 = $rating;
			if(strpos($type_id[$j], 'under') !== false)
				$check = 0;
			else
				$check = 1;

			$rate = $rate1[$check];

			$gl_home_dividend = explode('^', $rate_list[0]);
			$info['gl_home_dividend'] = $gl_home_dividend[$check];
			$gl_draw_dividend = explode('^', $rate_list[1]);
			$info['gl_draw_dividend'] = $gl_draw_dividend[$check];
			$gl_criteria = explode('^', $rate_list[3]);
			$info['gl_criteria'] = $gl_criteria[$check];
			$gl_away_dividend = explode('^', $rate_list[2]);
			$info['gl_away_dividend'] = $gl_away_dividend[$check];
		} else
			$rate = $rating;

		$bt_dividend = round_down(($j == 0 ? 1 : $bt_dividend) * $rate, 2);

		if($bt_dividend > 300)
			$bt_dividend = 300;
		
		if($chk_time  > (int) strtotime($info['gl_datetime']) )
			$chk_time = strtotime($info['gl_datetime']);

		$bat = betting_result($row['bt_status'], $info, $type_id[$j]);

		if($bat['type'] == 'miss')
			$bat_miss = 1;
	?>
	<tr>
		<td><?=date('m/d', $info['gl_datetime'])?>(<?=$week[date('w', $info['gl_datetime'])]?>) <?=date('H:i', $info['gl_datetime'])?></td>
		<td class="league"><?=league_name($info['gl_type'], $info['gl_lg_type'])?></td>
		<td><?=game_name($info['gl_game_type'])?></td>
		<td class="info">
			<div>
				<div>
					<p class="team_info<?php if($type_id[$j] == 'home') echo ' select'?> home">
						<span class="name text-left" style="padding:0 10px;"><?=team_name($info['gl_type'], $info['gl_home'])?></span><span class="rate"><?=round_down1($info['gl_home_dividend'], 2, 1)?></span>
					</p>
				</div>
				<div class="draw">
					<p class="team_info<?php if($type_id[$j] == 'draw') echo ' select'?> draw">
						<?php if($info['gl_criteria'] != 0 && $info['gl_game_type'] != 0) echo '<span class="rate color">'.$info['gl_criteria'].'</span>';?>
						<?php if($info['gl_draw_dividend'] > 0){?><span class="rate"><?=$info['gl_draw_dividend']?></span><?php }?>
					</p>
				</div>
				<div>
					<p class="team_info<?php if($type_id[$j] == 'away') echo ' select'?> away">
						<span class="name text-left" style="padding:0 10px;"><?=team_name($info['gl_type'], $info['gl_away'])?></span><span class="rate"><?=round_down1($info['gl_away_dividend'], 2, 1)?></span>
					</p>
				</div>
			</div>
		</td>
		<td class="score">
			<?php if($bat_type == 'on') echo '<span class="bat_tb_liveon">Live</span>';?>
			<?php if($bat_type != 'stand') echo $info['gl_home_score'].' : '.$info['gl_away_score'];?>
		</td>
		<td class="bat_pro_<?=$bat['type']?>">[<?=$bat['text']?>]</td>
	</tr>
	<?php } ?>
	
	<tr>
		<td colspan="8">
			<p><?=lang('배팅포인트', 'Betting point')?> : <span><?=number_format($row['bt_point'])?></span></p>
			<p><?=lang('배당률', 'Dividend')?> : <span><?=$bt_dividend?></span></p>
			<p><?=lang('예상당첨 포인트', 'Estimated Attachment Point')?> : <span><?=round_down_format($row['bt_point']*$bt_dividend>10000000000?10000000000:$row['bt_point']*$bt_dividend, 2)?></span></p>

		</td>
	</tr>
	</tbody>
	</table>
	<?php } if($i == 0) echo '<table width="100%"><tr><td colspan="10" class="no-list text-center">'.lang('배팅내역이 없습니다.', 'No betting details.').'</td></tr></table>';?>

</section>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="배팅취소" onclick="document.pressed=this.value" class="btn btn_02">
	<a href="./betting_list.php?<?=$qstr?>" id="member_add" class="btn btn_01">목록</a>
</div>

<script>
function fpointlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 배팅을 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
$('.bet_de').click(function(){
	if(confirm('선택한 배팅을 정말 삭제하시겠습니까?')){
	} else
		return false;
});
</script>

<?php
include_once ('./admin.tail.php');
?>
