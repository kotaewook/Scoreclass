<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_THEME_PATH.'/talk_tabmenu.php');
?>

<form action="#" method="post">
	<section class="sec_talk">
		<table class="talk_set_tb">
			<tr>
				<th>단톡방 제목</th><td><input type="text" placeholder="단톡방 제목을 입력해주세요"></td>
			</tr>
			<tr>
				<th>썸네일</th>
				<td>
					<img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png" />
					<div class="pro_ex_btn">
					<p>썸네일 이미지 사이즈 100px*100px<br>이미지 최대용량은 1MB 입니다.</p>
					<span class="btn_myp_chg">등록하기</span>
				</div>
				</td>
			</tr>
			<tr>
				<th>입장 포인트</th><td><input type="text" placeholder="입장 포인트를 입력해주세요"></td>
			</tr>
			<tr>
				<th>관심 카테고리</th>
				<td>
					#<input type="text" placeholder="카테고리">#<input type="text" placeholder="카테고리">#<input type="text" placeholder="카테고리">
					#<input type="text" placeholder="카테고리">#<input type="text" placeholder="카테고리">
				</td>
				</td>
			</tr>
		</table>
		<div class="talk_set_btn">
			<button class="talk_set">개설하기</button> &nbsp
			<a href="#" class="btn_cancel btn">취소</a>
		</div>
	</section>
</form>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>