<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_THEME_PATH.'/myp_tabmenu.php');

$sql_common = " from {$g5['rank_table']} ";

if (!$sst) {
    $sst  = "rk_exp";
    $sod = "asc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select *
            {$sql_common}
            {$sql_order} ";
$result = sql_query($sql);
?>

<section class="sec_myp">
	<table>
		<colgroup>
			<col style="width:10%">
			<col style="width:20%">
			<col style="width:40%">
			<col style="width:10%">
			<col style="width:10%">
		</colgroup>
		<tr>
			<th><?=lang('레벨', 'Level')?></th>
			<th><?=lang('아이콘', 'Icon')?></th>
			<th><?=lang('등급명', 'Name')?></th>
			<th><?=lang('필요 경험치', 'Exp')?></th>
			<th><?=lang('무료 쪽지', 'Msg')?></th>
		</tr>
		<?php
		for($i=0; $row = sql_fetch_array($result); $i++){
		?>
		<tr>
			<td><?=$row['rk_level']?></td>
			<td><img src="/data/level/level<?=$row['rk_level']?>.gif"></td>
			<td><?=trim($row['rk_'.$country.'_name'])!=''?$row['rk_'.$country.'_name']:$row['rk_en_name']?></td>
			<td><?=number_format($row['rk_exp'])?></td>
			<td><?=$row['rk_msg']?></td>
		</tr>
		<?php }?>
	</table>

</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>