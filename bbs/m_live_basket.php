<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_THEME_PATH.'/live_tabmenu.php');
?>


<div class="live_date_tab">
	<span class="btn_date prev"><a href=""></a></span>
	<span>2019년 08월 29일(목)</span>
	<span class="btn_date next"><a href=""></a></span>
</div>


<section class="live_bk">
	<div class="bk_score">
		<h4>국제<span><i class="fa fa-angle-up"></i></span></h4>
		<div class="bk_sco_wrap">
			<div class="team_info">
				<span class="team_img"><img src="<?php echo G5_THEME_IMG_URL; ?>/flag_iran.png" width=70></span>
				<span class="team_name">이란</span>
			</div>
			<div class="sco_center">
				<p>경기종료</p>
				<p class="team_sco">
					<span class="win">74</span>
					- 
					<span>70</span>
				</p>
			</div>
			<div class="team_info">
				<span class="team_img"><img src="<?php echo G5_THEME_IMG_URL; ?>/flag_portugal.png" width=70></span>
				<span class="team_name">포르투갈</span>
			</div>
		</div>
	</div>
	<table class="bk_score_tb">
		<colgroup>
			<col style="width:27%">
			<col style="width:9%">
			<col style="width:9%">
			<col style="width:9%">
			<col style="width:9%">
			<col style="width:12%">
			<col style="width:10%">
			<col style="width:50px;">
			<col style="width:50px">
		</colgroup>
		 <tr>
			<th>팀명</th>
			<th>1Q</th>
			<th>2Q</th>
			<th>3Q</th>
			<th>4Q</th>
			<th>연장전</th>
			<th>합계</th>
			<th>첫삼</th>
			<th>첫자</th>
		  </tr>
		  <tr>
			<td>이란</td>
			<td>18</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td></td>
			<td>74</td>
			<td><img src="<?php echo G5_THEME_IMG_URL; ?>/bk_num01.png"></td>
			<td><img src="<?php echo G5_THEME_IMG_URL; ?>/bk_num02.png"></td>
		  </tr>
		  <tr>
			<td>포르투갈</td>
			<td>14</td>
			<td>22</td>
			<td>8</td>
			<td>26</td>
			<td></td>
			<td>70</td>
			<td><img src="<?php echo G5_THEME_IMG_URL; ?>/bk_num03.png"></td>
			<td><img src="<?php echo G5_THEME_IMG_URL; ?>/bk_num04.png"></td>
		  </tr>
		  <tr>
			<td>합계</td>
			<td>32</td>
			<td>40</td>
			<td>29</td>
			<td>43</td>
			<td></td>
			<td>144</td>
			<td></td>
			<td></td>
		  </tr>
	</table>
</section>








<?php
include_once(G5_THEME_PATH.'/tail.php');
?>