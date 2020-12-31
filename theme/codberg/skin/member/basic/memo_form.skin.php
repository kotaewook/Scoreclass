<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
$member_skin_url = G5_THEME_URL.'/skin/member/basic';
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지 보내기 시작 { -->
<div id="memo_write" class="new_win">
    <h1 id="win_title"><?=lang('쪽지 보내기')?></h1>
    <div class="new_win_con">
        <ul class="win_ul">
            <li><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li class="selected"><a href="./memo_form.php">쪽지쓰기</a></li>
        </ul>
		<div class="warp">
        <form name="fmemoform" action="<?php echo $memo_action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
        <div class="list_01">
            <table>
				<col style="width:20%">
				<?php
				$item_cnt = sql_fetch("select count(*) as cnt from {$g5['my_item']} where mb_id = '{$member['mb_id']}' and it_id > 3 and it_id < 7 and it_count > 0");
				if($item_cnt['cnt'] > 0){
				?>
				<tr>
					<th><label for="me_recv_mb_id">랜덤 쪽지</label></th>
					<td>
					<?php
					$rs = sql_query("select a.it_id, it_{$country}_name as it_name, it_en_name from {$g5['my_item']} a inner join {$g5['item_shop']} b on a.it_id = b.it_id where a.mb_id = '{$member['mb_id']}' and a.it_id > 3 and a.it_id < 7 and a.it_count > 0");
					while($row = sql_fetch_array($rs)){
					?>
                    <input type="checkbox" name="item_use" value="<?=$row['it_id']?>" id="item_use<?=$row['it_id']?>">
					<label for="item_use<?=$row['it_id']?>"><?=$row['it_name']==''?$row['it_en_name']:$row['it_name']?></label>
					<?php }?>
					</td>
                </tr>
				<?php }?>
				<tr class="users">
					<th><label for="me_recv_mb_id">받는 회원아이디</label></th>
					<td>
                    <input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" class="frm_input full_input" size="47">
                    <span class="frm_info" style="color:#ff7e00">여러 회원에게 보낼때는 컴마(,)로 구분하세요.</span>
					</td>
                </tr>
                <tr>
                    <th><label for="me_memo">내용</label></th>
                    <td><textarea name="me_memo" id="me_memo" required class="frm_input full_input"><?php echo $content ?></textarea></td>
                </tr>
            </table>
        </div>

        <div class="win_btn text-center" style="padding-top:20px; padding-bottom:10px;">
            <input type="submit" value="보내기" id="btn_submit" class="btn_submit" style="float:unset;">
            <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
        </div>
    </div>
    </form>
	</div>
</div>

<script>
$('input[name="item_use"]').change(function(){
	if($('input[name="item_use"]:checked').index() >= 0){
		$('input[name="item_use"]').prop('checked', false);
		$(this).prop('checked', true);

		$('.users').css('display', 'none');
	} else
		$('.users').css('display', 'table-row');
});
</script>
<!-- } 쪽지 보내기 끝 -->