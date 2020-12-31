<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
?>


<section class="sec_talk">

<div class="talk_tit">
	<h3>단톡방 제목</h3>
	<div><span class="nick">회원닉네임: <?=$member['mb_name']?></span> <button class="talk_fav"><i class="fa fa-heart"></i> 즐겨찾기</button>&nbsp <button class="talk_exit">나가기</button></div>
</div>

<div class="acc_on">
	<h4>단톡방 접속자 리스트</h4>
	<div class="acc_on_list">
		<div>
			<ul>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>최유리나</span></li>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>오청운</span></li>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>이재인</span></li>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>최수화</span></li>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>조정관</span></li>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>박민영</span></li>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>박철우</span></li>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>김효정</span></li>
				<li><img src="<?php echo G5_THEME_IMG_URL; ?>/pro_no_img.png"><span>윤근영</span></li>
			</ul>
		</div>
		<input type="text" placeholder="닉네임 검색">
	</div>
</div>

<div class="talk_box_wrap">
	<h4>단톡방<span>접속자: 3/10</span></h4>
	<div>
		<div class="talk_box">
			<p>단톡방 접속 완료</p>
		</div>
			<input type="text" placeholder="대화 내용을 입력해주세요">
	</div>
</div>

</section>



<?php
include_once(G5_THEME_PATH.'/tail.php');
?>