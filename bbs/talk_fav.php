<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_THEME_PATH.'/talk_tabmenu.php');
?>

	<div class="talk_srch_set">
		<fieldset class="talk_srch">
			<legend>단톡방 검색</legend>
			<form>
			<label class="sound_only">검색대상</label>
			<select>
				<option>단톡방 제목</option>
				<option >방장닉네임</option>
			</select>
			<input placeholder="검색어를 입력해주세요" class="srch_in">
			<button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> <span class="sound_only">검색</span></button>
			</form>
		</fieldset>
	</div>
</div>

<section class="sec_talk">

	<div class="talk_gen talk_list">
		<h3>즐겨찾기</h3>
		<ul>
			<li>
				<div class="troom_rank">1</div>
				<div class="troom_thum"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTSH8WKxZO2faXuxVside7bNvLslitN0T9dZ7aRLdWB0N49S57jg" width="130%"></div>
				<div class="troom_tit"><h4>단톡방 제목이 출력됩니다. </h4><p>&lt방장닉네임&gt <span>승률 : 55%</span></p></div>
				<span class="talk_tag_cate"><span>#야구</span><span>#축구</span><span>#EPL</span></span>
			</li>
			<li>
				<div class="troom_rank">2</div>
				<div class="troom_thum"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT30kSco83BZMNehbnbePlTnEys8zzrSlWW-oSZUI6jtwxAouLydw" width="210%"></div>
				<div class="troom_tit"><h4>단톡방 제목이 출력됩니다. </h4><p>&lt방장닉네임&gt <span>승률 : 55%</span></p></div>
				<span class="talk_tag_cate"><span>#야구</span><span>#축구</span><span>#EPL</span></span>
			</li>
			<li>
				<div class="troom_rank">3</div>
				<div class="troom_thum"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRn5oxZ5-0krY4Mo5cyWIDNROYqr-fIdCKc-kh_6mxaTDyQN5VJ" width="100%"></div>
				<div class="troom_tit"><h4>단톡방 제목이 출력됩니다. </h4><p>&lt방장닉네임&gt <span>승률 : 55%</span></p></div>
				<span class="talk_tag_cate"><span>#야구</span><span>#축구</span><span>#EPL</span></span>
			</li>
		</ul>
	</div>

</section>



<?php
include_once(G5_THEME_PATH.'/tail.php');
?>