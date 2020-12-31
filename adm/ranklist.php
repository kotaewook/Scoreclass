<?php
$sub_menu = '100120';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '회원등급 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['rank_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = "select * $sql_common order by rk_level asc ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov"><span class="btn_ov01"><span class="ov_txt">전체 등록된 회원등급 </span><span class="ov_num">  <?php echo $total_count; ?>건</span></span></div>

<div class="btn_fixed_top ">
    <a href="./rankform.php" class="btn btn_01">회원등급 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="2">레벨</th>
		<th scope="col" rowspan="2">아이콘</th>
		<th scope="col" colspan="4">등급명</th>
		<th scope="col" rowspan="2">Exp</th>
        <th scope="col" rowspan="2">쪽지혜택</th>
        <th scope="col" rowspan="2">1:1대화 혜택</th>
        <th scope="col" rowspan="2">관리</th>
	</tr>
	<tr>
		<th scope="col">한국어</th>
		<th scope="col">영어</th>
		<th scope="col">일본어</th>
		<th scope="col">중국어</th>
	</tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?=$bg?>">
        <td class="td_num"><?=$row['rk_level']?></td>
		<td class="td_num"><img src="<?=G5_DATA_URL?>/level/level<?=$row['rk_level']?>.gif"></td>
		<td class="td_left"><?=$row['rk_ko_name']?></td>
		<td class="td_left"><?=$row['rk_en_name']?></td>
		<td class="td_left"><?=$row['rk_jp_name']?></td>
		<td class="td_left"><?=$row['rk_ch_name']?></td>     
		<td class="td_num td_mng"><?=number_format($row['rk_exp'])?></td>
		<td class="td_num td_mng"><?=number_format($row['rk_msg'])?></td>
		<td class="td_num td_mng"><?=number_format($row['rk_chat'])?></td>
		<td class="td_mng td_mng_m">
            <a href="./rankform.php?w=u&amp;rk_id=<?php echo $row['rk_id']; ?>" class="btn btn_03">수정</a>
            <a href="./rankformupdate.php?w=d&amp;rk_id=<?php echo $row['rk_id']; ?>" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only"><?php echo $row['nw_subject']; ?> </span>삭제</a>
        </td>
	</tr>
    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="11" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
