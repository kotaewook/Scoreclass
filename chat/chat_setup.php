<?php
include_once('../common.php');

if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');

include_once(G5_THEME_PATH.'/head.php');
if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/chat/m_chat_setup.php');
    return;
}
include_once('talk_tabmenu.php');
?>

<form action="/chat/bbs/chat_update.php" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="w" value="">
	<section class="sec_talk" style="padding-top:20px;">
		<table class="talk_set_tb">
			<tr>
				<th>단톡방 제목</th><td><input type="text" placeholder="단톡방 제목을 입력해주세요" name="ch_subject" required></td>
			</tr>
			<tr>
				<th>썸네일</th>
				<td>
					<input type="file" name="ch_profile">
					<img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png" id="ch_profile" accept="image/*" />
					<div class="pro_ex_btn">
					<p>썸네일 이미지 사이즈 100px*100px<br>이미지 최대용량은 1MB 입니다.</p>
					<span class="btn_myp_chg">등록하기</span>
				</div>
				</td>
			</tr>
			<tr>
				<th>입장 포인트</th><td><input type="text" placeholder="입장 포인트를 입력해주세요" name="ch_point" required></td>
			</tr>
			<tr>
				<th>관심 카테고리</th>
				<td>
					#<input type="text" placeholder="카테고리" name="ch_tag[]">#<input type="text" placeholder="카테고리" name="ch_tag[]">#<input type="text" placeholder="카테고리" name="ch_tag[]">
					#<input type="text" placeholder="카테고리" name="ch_tag[]">#<input type="text" placeholder="카테고리" name="ch_tag[]">
				</td>
				</td>
			</tr>
		</table>
		
	</section>
	<div class="talk_set_btn" style="padding-bottom:40px; margin-top:0;">
		<button class="talk_set">개설하기</button> &nbsp
		<a href="/chat/list" class="btn_cancel btn">취소</a>
	</div>
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
$('.btn_myp_chg').click(function(){
	$('input[name="ch_profile"]').click();
});
</script>
</div>
<aside class="aside_fa">
	<?php include_once(G5_PATH.'/login_form.php')?>
	<div class="right_rank">
		<?php include_once(G5_PATH.'/live_rank.php');?>
	</div>
</aside>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>