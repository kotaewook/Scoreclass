<?php include_once('./_common.php');
if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');
include_once(G5_THEME_PATH.'/head.php');

?>

<section class="bat_detail">
	<div class="bat_detail_list_op">
		<ul>
			<li><a href="/batting_history?page=<?=$page?>">5개 보기</a></li>
			<li><a href="/batting_history?page=<?=$page?>&limit=10">10개 보기</a></li>
			<li><a href="/batting_history?page=<?=$page?>&limit=20">20개 보기</a></li>
		</ul>
	</div>
	<table class="bat_tb_cont">
		<colgroup>
		  <col style="width:38%">
		  <col style="width:25%">
		  <col style="width:38%">
		</colgroup>
	  <tr>
		<th colspan="2"><input type="checkbox"> 배팅일자 : 2019.08.29  10:00</th>
		<th><span class="prz_not">미당첨</span></th>
	  </tr>
	  <tr>
		<td><p>2019.08.30  03:45</p>
		  <p>잉글랜드EFL컵</p></td>
		<td><p><span class="lab_fa">승무패</span> <strong class="bat_tb_sco">[1:<span class="win">3</span>]</strong></p></td>
		<td><p class="bat_pro_miss">[미적중]</p></td>
	  </tr>
	  <tr>
		<td>
			<p class="team_info home select">
				<span class="name">Llaneros</span><span class="rate">4.45</span>
			</p>
		</td>
		<td>
			<p class="team_info draw">
				<span class="rate">4.36</span>
			</p>
		</td>
		<td>
			<p class="team_info away">
				<span class="name">Leones FC</span><span class="rate">1.63</span>
			</p>
		</td>
	  </tr>
	  <tr>
		<td><p>2019.08.30  03:45</p>
		  <p>잉글랜드EFL컵</p></td>
		<td><p><span class="lab_fa">승무패</span> <strong class="bat_tb_sco">[<span class="win">6</span>:0]</strong></p></td>
		<td><p class="bat_pro_hit">[적중]</p></td>
	  </tr>
	  <tr>
		<td>
			<p class="team_info home select">
				<span class="name">Llaneros</span><span class="rate">4.45</span>
			</p>
		</td>
		<td>
			<p class="team_info draw">
				<span class="rate">4.36</span>
			</p>
		</td>
		<td>
			<p class="team_info away">
				<span class="name">Leones FC</span><span class="rate">1.63</span>
			</p>
		</td>
	  </tr>
	  <tr>
		<td><p>배팅포인트<br> : <span>1,000,000,000</span></p></td>
		<td><p>배당률<br> : <span>2.10</span></p></td>
		<td><p>예상당첨포인트<br> : <span>2,100,000,000</span></p></td>
	  </tr>
	</table>
		
	<table class="bat_tb_cont">
		<colgroup>
		  <col style="width:38%">
		  <col style="width:25%">
		  <col style="width:38%">
		</colgroup>
	  <tr>
		<th colspan="2"><input type="checkbox"> 배팅일자 : 2019.08.30  09:51</th>
		<th>대기중<a href="#" class="btn_bat_cancel">배팅취소</a></th>
	  </tr>
	  <tr>
		<td><p>2019.09.01  01:30</p>
		  <p>프리미어리그</p></td>
		<td><span class="lab_fa">승무패</span></td>
		<td><p class="bat_pro_stand">[대기중]</p></td>
	  </tr>
	  <tr>
		<td>
			<p class="team_info home select">
				<span class="name">Llaneros</span><span class="rate">4.45</span>
			</p>
		</td>
		<td>
			<p class="team_info draw">
				<span class="rate">4.36</span>
			</p>
		</td>
		<td>
			<p class="team_info away">
				<span class="name">Leones FC</span><span class="rate">1.63</span>
			</p>
		</td>
	  </tr>
	  <tr>
		<td><p>배팅포인트<br> : <span>1,000,000</span></p></td>
		<td><p>배당률<br> : <span>1.35</span></p></td>
		<td><p>예상당첨포인트<br> : <span>1,350,000</span></p></td>
	  </tr>
	</table>

	<table class="bat_tb_cont">
		<colgroup>
		  <col style="width:38%">
		  <col style="width:25%">
		  <col style="width:38%">
		</colgroup>
	  <tr>
		<th colspan="2"><input type="checkbox"> 배팅일자 : 2019.08.30  09:51</th>
		<th><span class="prz_win">당첨</span></th>
	  </tr>
	  <tr>
		<td><p>2019.09.01  01:30</p>
		  <p>프리미어리그</p></td>
		<td><span class="lab_fa">승무패</span></td>
		<td><p class="bat_pro_hit">[적중]</p></td>
	  </tr>
	  <tr>
		<td>
			<p class="team_info home select">
				<span class="name">Llaneros</span><span class="rate">4.45</span>
			</p>
		</td>
		<td>
			<p class="team_info draw">
				<span class="rate">4.36</span>
			</p>
		</td>
		<td>
			<p class="team_info away">
				<span class="name">Leones FC</span><span class="rate">1.63</span>
			</p>
		</td>
	  </tr>
	  <tr>
		<td><p>배팅포인트<br> : <span>1,000,000</span></p></td>
		<td><p>배당률<br> : <span>1.35</span></p></td>
		<td><p>예상당첨포인트<br> : <span>1,350,000</span></p></td>
	  </tr>
	</table>
	
	<div class="btn_del"><button>선택삭제</button></div>
	
</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>