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
			<th>번호</th>
			<th>내역</th>
			<th>경험치 (EXP)</th>
			<th>적립일자</th>
		</tr>
		<?php
		for($i=0; $row = sql_fetch_array($result); $i++){
		?>
		<tr>
			<td><?=($total_count - ($i+$from_record))?></td>
			<td><?=point_type_name($row['point'],$row['pt_type'])?></td>
			<td><?=round_down_format($row['point'], 2)?></td>
			<td><?=date('Y.m.d', strtotime($row['pt_datetime']))?></td>
		</tr>
		<?php } if($i == 0) echo '<tr><td colspan="10" class="no-list">'.lang('활동내역이 없습니다.').'</td></tr>';?>
	</table>

</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>