<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지 목록 시작 { -->
<div id="memo_list" class="new_win">
    <h1 id="win_title"><?=lang('내 쪽지함')?></h1>
    <div class="new_win_con">
        <ul class="win_ul">
            <li class="<?php if ($kind == 'recv') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="<?php if ($kind == 'send') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li><a href="./memo_form.php">쪽지쓰기</a></li>
        </ul>
		<div class="warp">
			<p class="win_desc">
				<span style="float:left;">전체 <?php echo $kind_title ?>쪽지 <font color="#ff7e00"><?php echo $total_count ?></font>통</span>
				<font style="float:right; color:#ff7e00; font-weight:bold;">쪽지 보관일수는 최장 <strong><?php echo $config['cf_memo_del'] ?></strong>일 입니다.</font>
			</p>
			<div class="list_01">
				<table>
					<col style="width:5%;">
					<col style="width:20%;">
					<col style="width:35%;">
					<col style="width:20%;">
					<col style="width:20%;">
					<thead>
						<tr>
							<th><input type="checkbox"></th>
							<th><?=$kind == 'send'?lang('받은사람'):lang('보낸사람')?></th>
							<th><?=lang('내용')?></th>
							<th><?=lang('보낸시간')?></th>
							<th><?=lang('읽은시간')?></th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i=0; $i<count($list); $i++) {  ?>
						<tr>
							<td><input type="checkbox"></td>
							<td><?=$list[$i]['mb_nick']?></td>
							<td class="title"><a href="<?php echo $list[$i]['view_href'] ?>" class="title"><?=strip_tags($list[$i]['me_memo'])?></a><a href="<?php echo $list[$i]['del_href'] ?>" onclick="del(this.href); return false;" class="memo_del"><i class="fa fa-times-circle" aria-hidden="true"></i> <span class="sound_only">삭제</span></a></td>
							<td><?=$list[$i]['send_datetime']?></td>
							<td><?=$list[$i]['read_datetime']?></td>
						</tr>
						<?php } if ($i==0) echo '<tr><td colspan="5" class="empty_table">자료가 없습니다.</td></tr>';  ?>
					</tbody>
				</table>
			</div>

			<!-- 페이지 -->
			<?php echo $write_pages; ?>

			
		</div>
        <div class="win_btn">
            <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
        </div>
    </div>
</div>
<!-- } 쪽지 목록 끝 -->