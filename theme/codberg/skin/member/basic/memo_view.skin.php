<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$nick = get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']);
if($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
}
else {
    $kind_str = "받는";
    $kind_date = "보낸";
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지보기 시작 { -->
<div id="memo_view" class="new_win">
    <h1 id="win_title"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $g5['title'] ?></h1>
    <div class="new_win_con">
        <!-- 쪽지함 선택 시작 { -->
        <ul class="win_ul">
            <li class="<?php if ($kind == 'recv') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="<?php if ($kind == 'send') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li><a href="./memo_form.php">쪽지쓰기</a></li>
        </ul>
        <!-- } 쪽지함 선택 끝 -->
		<div class="warp">
		<div class="list_01">
            <table>
				<col style="width:20%">
				<tr>
					<th><label for="me_recv_mb_id"><?php echo $kind_str ?>사람</label></th>
					<td class="text-left"><?php echo $nick ?></td>
                </tr>
				<tr>
					<th><label for="me_recv_mb_id"><?php echo $kind_date ?>시간</label></th>
					<td class="text-left"><?php echo $memo['me_send_datetime'] ?></td>
                </tr>
                <tr>
                    <th><label for="me_memo">내용</label></th>
                    <td class="text-left"><?php echo conv_content($memo['me_memo'], 0) ?></td>
                </tr>
            </table>
        </div>
		<div>


       
</div>
<!-- } 쪽지보기 끝 -->
<div class="win_btn text-center" style="padding-top:10px;">
		<?php if($prev_link) {  ?>
		<a href="<?php echo $prev_link ?>" class="btn btn_b01"><i class="fa fa-angle-left" aria-hidden="true"></i> 이전쪽지</a>
		<?php }  ?>
		<?php if($next_link) {  ?>
		<a href="<?php echo $next_link ?>" class="btn btn_b01">다음쪽지 <i class="fa fa-angle-right" aria-hidden="true"></i></a>
		<?php }  ?>

		<a href="<?php echo $list_link ?>" class="btn btn_b01"><i class="fa fa-list" aria-hidden="true"></i> 목록</a>
		<button type="button" onclick="window.close();" class="btn_close">창닫기</button>
		<?php if ($kind == 'recv') {  ?><a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="btn btn_b02 reply_btn" style="float:unset;">답장</a><?php }  ?>
	</div>
</div>