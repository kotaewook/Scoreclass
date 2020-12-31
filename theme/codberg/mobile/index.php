
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_MOBILE_PATH.'/head.php');
?>
<div class="main_sd">
	<ul class="bxslider">
		<?php
		$c = 0;
		$rs = sql_query("select * from {$g5['g5_shop_banner_table']} where bn_position = '메인' order by bn_order asc, bn_id desc");
		for($i = 0; $row = sql_fetch_array($rs); $i++){
			if(is_file(G5_DATA_PATH.'/banner/m_'.$row['bn_id'])){
				if($c == 0) $class=' class="active"';
				else $class='';
				echo '<li'.$class.'>';
				if($row['bn_url'] != '' && $row['bn_url'] != 'http://') echo '<a href="'.$row['bn_url'].'">';
				echo '<img src="/data/banner/m_'.$row['bn_id'].'" alt="메인배너" />';
				if($row['bn_url'] != '' && $row['bn_url'] != 'http://') echo '</a>';
				echo '</li>';
				$c++;
			}
		}
		?>
	</ul>
</div>

<div class="main_sec_menu">
	<ul>
		<li class="rank">
			<a href="/game">
				<!--<img src="<?php echo G5_THEME_IMG_URL; ?>/m_sec_menu01.png" />-->
				<p>승무패</p>
			</a>
		</li>
		<li class="score">
			<a href="/live">
				<!--<img src="<?php echo G5_THEME_IMG_URL; ?>/m_sec_menu02.png" />-->
				<p>라이브스코어</p>
			</a>
		</li>
		<!--li>
			<a href="http://scoreclass.designcodberg.co.kr/bbs/group.php?gr_id=groupchat">
				<img src="<?php echo G5_THEME_IMG_URL; ?>/m_sec_menu03.png" />
				<p>단톡방</p>
			</a>
		</li>
		<li>
			<a href="http://scoreclass.designcodberg.co.kr/bbs/group.php?gr_id=market">
				<img src="<?php echo G5_THEME_IMG_URL; ?>/m_sec_menu04.png" />
				<p>마켓</p>
			</a>
		</li-->
	</ul>
</div>

<ul class="btn_late">
	<li><button type="button" class="btn_late_spo btn_late_on" title="스포츠 분석">스포츠 분석</button></li>
	<li><button type="button" class="btn_late_noti" title="공지사항">공지사항</button></li>
</ul>

<div class="bo_sport_wrap late_list">
	<ul>
		<?php
		$rs = sql_query('select * from g5_write_spo_analy  order by wr_last desc limit 0, 5;');

		for($i = 0; $row = sql_fetch_array($rs); $i++){
				echo "<li>";
				echo "<div class='cate'>".$row['ca_name'];
						echo "</div>";
				echo "<a href='".G5_URL."/bbs/board.php?bo_table=spo_analy&wr_id=".$row['wr_id']."'>";	//눌럿을때 본문링크
						//echo "글번호 : ".$row['wr_id'];
						echo "".$row['wr_subject'];
						echo "</a>";
				echo "<span>";
						echo "".date("y.m.d", strtotime($row['wr_datetime']));
				echo "</span>";
						//echo "링크 : ".G5_URL."/bbs/board.php?bo_table=spo_analy&wr_id=".$row['wr_id'];
				echo "</li>";
		}
		?>
	</ul>
	<a class="btn_late_more" href="<?php echo G5_BBS_URL ?>/board.php?bo_table=spo_analy" >+ 게시물 전체보기</a>
</div>

<div class="bo_noti_wrap late_list" style="display:none;">
	<ul>
		<?php
		$rs = sql_query('select * from g5_write_notice  order by wr_last desc limit 0, 5;');

		for($i = 0; $row = sql_fetch_array($rs); $i++){
				echo "<li>";
				echo "<a href='".G5_URL."/bbs/board.php?bo_table=notice&wr_id=".$row['wr_id']."'>";	//눌럿을때 본문링크
						//echo "글번호 : ".$row['wr_id'];	
						echo "".$row['wr_subject'];
						echo "</a>";
				echo "<span>";
						echo "".date("y.m.d", strtotime($row['wr_datetime']));
				echo "</span>";
						//echo "링크 : ".G5_URL."/bbs/board.php?bo_table=freeboard&wr_id=".$row['wr_id'];
				echo "</li>";
		}
		?>
	</ul>
	<a class="btn_late_more" href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice" >+ 게시물 전체보기</a>
</div>


<div class="main_chart main_grid">
	<?php include_once(G5_PATH.'/live_rank.php');?>
</div>
<script type="text/javascript"> 
$(document).ready(function(){ 
	$('.bxslider').bxSlider({
        auto: true,
	}); 
});
</script>



<?php
include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>

<script>
jQuery(function($){
	// 레이어 팝업 토글 작동
	$(".btn_late_spo").on("click", function() {
		$('.btn_late_spo').addClass('btn_late_on');
		$('.btn_late_noti').removeClass('btn_late_on');
		$(".bo_sport_wrap").show();
		$(".bo_noti_wrap").hide();
	})

	$('.btn_late_noti').click(function(){
		$('.btn_late_noti').addClass('btn_late_on');
		$('.btn_late_spo').removeClass('btn_late_on');
		$(".bo_sport_wrap").hide();
		$(".bo_noti_wrap").show();
	});
});
</script>