<?php include_once('./_common.php');
if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'));

include_once(G5_THEME_PATH.'/head.php');
include_once(G5_THEME_PATH.'/myp_tabmenu.php');

$next_lv = sql_fetch("select rk_exp from {$g5['rank_table']} where rk_exp > '{$member['mb_exp']}' order by rk_exp asc");
?>
<form action="/user/bbs/info_update.php" method="post" enctype="multipart/form-data" autocomplete="off">
<section class="sec_myinfo">
<table class="myp_info">
	<tr>
		<th>계정정보</th>
	</tr>	
	<tr>	
		<td><?=$member['mb_id']?></td>
	</tr>
</table>
<table class="my_comm_info">
	<tr>
		<th colspan="2">커뮤니티 정보</th>
	</tr>	
	<tr>	
		<td>닉네임</td>
		<td><?=$member['mb_nick']?></td>
	</tr>
	<tr>
		<td colspan="2">
			<span class="btn_myp_chg" id="nick_chg"><?=lang('변경하기', 'To change')?></span>
			<div class="mb_change">
				<input type="text" name="mb_name" placeholder="변경하실 닉네임을 입력해주세요" />
			</div>
			
		</td>
	</tr>
	<tr>
		<td>프로필 이미지</td>
		<td>
			<?php
			echo get_member_profile_img($member['mb_id'], $config['cf_member_img_width'], $config['cf_member_img_height']);
			$item_chk = sql_fetch("select * from {$g5['my_item']} where mb_id = '{$member['mb_id']}' and it_id  = '2' and it_count > 0");
			if($item_chk){
			?>
			<div class="pro_ex_btn">
				<p><?=lang('프로필 이미지는 가로, 세로 '.$config['cf_member_img_width'].'px 으로 생성됩니다.<br>이미지 최대용량은 1MB 입니다.', 'The profile image is created in a '.$config['cf_member_img_width'].'px thumbnail across.<br>The maximum image capacity is 1MB.')?></p>
				<span class="btn_myp_chg" id="img_chg"><?=lang('변경하기', 'To change')?></span>
				<input type="file" name="ch_profile" accept="image/*">
			</div>
			<?php } else {?>
			<div class="pro_ex_btn">
				<p><?=lang('프로필 변경권을 보유하고 있어야 프로필을 변경하실 수 있습니다.')?></p>
				<a href="/market/view/2" class="btn_myp_chg"><?=lang('프로필 변경권 구매', 'To change')?></a>
			</div>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td>레벨</td><td><?=get_rank_ico_name($member['mb_id'])?><a href="/rank" class="myp_tb_link">[등업안내]</a></td>
	</tr>
	<tr>
		<td>경험치</td><td><?=number_format($member['mb_exp'])?> EXP</td>
	</tr>	
	<tr>
		<td>다음 레벨까지 남은 경험치</td><td><?=number_format($next_lv['rk_exp']-$member['mb_exp'])?> EXP</td>
	</tr>
	<tr>
		<td>총 보유포인트</td><td><?=round_down_format($member['mb_cp'], 2)?> P<a href="/point_list" class="myp_tb_link">[적립내역]</a></td>
	</tr>
</table>
<table class="myp_info">
	<tr>
		<th>비밀번호 변경</th>
	</tr>	
	<tr>
		<td>
			<span class="btn_myp_chg" id="pw_change"><?=lang('변경하기', 'To change')?></span>
			<div class="pw_change">
				<input type="password" name="my_password" placeholder="기존 비밀번호를 입력해주세요" />
				<input type="password" name="mb_password" placeholder="새로운 비밀번호를 입력해주세요" />
				<input type="password" name="mb_password_re" placeholder="새로운 비밀번호를 한번 더 입력해주세요" />
			</div>
		</td>
	</tr>
</table>
<table class="myp_info">
	<tr>
		<th>회원 탈퇴</th>
	</tr>	
	<tr>
		<td><button class="btn_myp_wdr">탈퇴하기</button></td>
	</tr>
</table>
	<div class="text-center" style="padding-bottom:20px; padding-top:10px;">
		<button class="btn_myp_chg"><?=lang('저장하기')?></button>
	</div>
</section>
</form>
<script>
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#ch_profile').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$('input[name="ch_profile"]').change(function() {
	readURL(this);
});
$('#img_chg').click(function(){
	$('input[name="ch_profile"]').click();
});

$('.btn_myp_chg#pw_change').click(function(){
	$('div.pw_change').addClass('show');
});

$('.btn_myp_chg#nick_chg').click(function(){
	$('div.mb_change').addClass('show');
	$(this).remove();
});


$('form').submit(function(){
	var submit_chk = 0;
	if($.trim($('input[name="mb_password"]').val()) != ''){
		if($.trim($('input[name="my_password"]').val()) == ''){
			alert(lang('기존 비밀번호를 입력해주세요.\n확인 후 다시 시도해주세요.'));
			$('input[name="my_password"]').focus();
			submit_chk = 1;
		} else if($('input[name="mb_password"]').val() != $('input[name="mb_password_re"]').val()){
			alert(lang('변경하실 비밀번호가 틀렸습니다.\n확인 후 다시 시도해주세요.'));
			$('input[name="mb_password"]').focus();
			submit_chk = 1;
		}
	}

	if($.trim($('input[name="mb_name"]').val()) != ''){
		if(confirm(lang('닉넴임 변경 후 변경권이 소모됩니다.\n변경하시겠습니까?'))){
		} else
			submit_chk = 1;
	}

	if(submit_chk == 1)
		return false;
	else
		return true;
});
</script>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>