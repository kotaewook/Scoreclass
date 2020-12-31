<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_THEME_PATH.'/myp_tabmenu.php');

$sql_common = " from {$g5['exp_log']} ";

$sql_search = " where mb_id = '{$member['mb_id']}' ";

if (!$sst) {
    $sst  = "exp_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);
?>

<section class="sec_myp">
	<table>
		<colgroup>
			<col style="width:12%">
			<col style="width:50%">
			<col style="width:20%">
			<col style="width:18%">
		</colgroup>
		<tr>
			<th><?=lang('번호', 'No')?></th>
			<th><?=lang('내역', 'Content')?></th>
			<th><?=lang('경험치', 'Exp')?></th>
			<th><?=lang('적립일자', 'Date')?></th>
		</tr>
		<?php
		for($i=0; $row = sql_fetch_array($result); $i++){
			$write_date = date('Y.m.d', $row['pt_datetime']);
		?>
		<tr>
			<td><?=($total_count - ($i+$from_record))?></td>
			<td><?=($row['pt_type']==2?str_replace('.', '-', $write_date).' ':'').point_type_name($row['point'],$row['pt_type'])?></td>
			<td><?=($row['point']>0?'+':'').round_down_format($row['point'], 2)?></td>
			<td><?=$write_date?></td>
		</tr>
		<?php } if($i == 0) echo '<tr><td colspan="10" class="no-list">'.lang('활동내역이 없습니다.', 'No activity details.').'</td></tr>';?>
	</table>

</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>