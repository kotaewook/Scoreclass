<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_THEME_PATH.'/myp_tabmenu.php');

$sql_common = " from {$g5['tree']} ";

$sql_search = " where tr_writer = '{$member['mb_id']}' ";

if (!$sst) {
    $sst  = "tr_datetime";
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
<section class="sec_myp myp_recomm">
	<table>
	    <tr>
			<th><?=lang('번호', 'No')?></th>
			<th><?=lang('회원 아이디', 'Account')?></th>
			<th><?=lang('가입한 일자', 'Date')?></th>
	    </tr>
	    <?php
		for($i=0; $row = sql_fetch_array($result); $i++){
		?>
		<tr>
			<td><?=($total_count - ($i+$from_record))?></td>
			<td><?=$row['tr_from']?></td>
			<td><?=date('Y.m.d', $row['tr_datetime'])?></td>
		</tr>
		<?php } if($i == 0) echo '<tr><td colspan="10" class="no-list">'.lang('추천받은 회원이 없습니다.', 'There are no recommended members.').'</td></tr>';?>
	</table>
</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>