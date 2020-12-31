<?php
include_once('../common.php');
include_once(G5_THEME_PATH.'/head.php');

if ($stx) {
    switch ($fild) {
		case 'mb_name' :
			$sql_search = " and (b.{$fild} like '%{$stx}%') ";
            break;
        default :
            $sql_search = " and (a.{$fild} like '%{$stx}%') ";
            break;
    }
}

if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/chat/m_chat_list.php');
    return;
}

include_once('talk_tabmenu.php');
?>
<div class="talk_srch_set">
	<fieldset class="talk_srch">
		<legend>단톡방 검색</legend>
		<form action="" method="get">
		<label class="sound_only">검색대상</label>
		<select name="fild">
			<option value="ch_subject" <?php echo get_selected($_GET['fild'], "ch_subject"); ?>>단톡방 제목</option>
			<option value="mb_name" <?php echo get_selected($_GET['fild'], "mb_name"); ?>>방장닉네임</option>
		</select>
		<input type="search" name="stx" placeholder="검색어를 입력해주세요" class="srch_in" value="<?=$stx?>">
		<button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> <span class="sound_only">검색</span></button>
		</form>
	</fieldset>
	<a class="talk_set" href="/chat/setup">단톡방 개설</a>
</div>

<section class="sec_talk">
	<div class="talk_pop talk_list">
		<h3>실시간 인기 단톡방</h3>
		<ul>
			<?php
			$link = mysqli_connect('scoreclassrdb.cw51mwae8jmx.ap-northeast-2.rds.amazonaws.com', 'scoreclass_aws', 'ske39dm@si23jn2', 'minitalk');
			mysqli_set_charset($link, 'utf8');
			$sql = "select password from `minitalk`.`minitalk_channel_table` where category1 = '2' order by user desc limit 0,3";
			$rs = mysqli_query($link, $sql);
			for($i=0; $row = mysqli_fetch_assoc($rs); $i++){
				$explode = explode('^', $row['password']);
				$list = sql_fetch("select ch_id, ch_subject, mb_nick, ch_tag, a.mb_id from {$g5['chat_list']} a inner join {$g5['member_table']} b on a.mb_id = b.mb_id where a.mb_id = '{$explode[0]}' and a.ch_id = '{$explode[1]}'");
				$ch_tag = explode('^chat^', $list['ch_tag']);
				$img_src = G5_DATA_PATH.'/ch_profile/ch_'.$list['ch_id'].'.gif';
			?>
			<li>
				<div class="troom_rank"><?=$i+1?>등</div>
				<div class="troom_thum"><img src="<?php echo is_file($img_src) ? '/data/ch_profile/ch_'.$list['ch_id'].'.gif' : '/img/no_profile.gif'?>" id="ch_profile"></div>
				<div class="troom_tit"><a href="/chat/view/<?=$list['ch_id']?>"><h4><?=$list['ch_subject']?></h4><p>&lt<?=$list['mb_nick']?>&gt <span>승률 : 55%</span></p></a></div>
				<span class="talk_tag_cate">
					<?php
					for($j=0; $j<count($ch_tag)-1; $j++)
						echo "<span>#{$ch_tag[$j]}</span>";
					?>
				</span>
			</li>
			<?php }?>
		</ul>
	</div>

	<div class="talk_gen talk_list">
		<h3>일반 단톡방</h3>
		<ul>
			<?php
			$rs = sql_query("select ch_id, ch_subject, mb_nick, ch_tag, a.mb_id from {$g5['chat_list']} a inner join {$g5['member_table']} b on a.mb_id = b.mb_id where (1) {$sql_search} order by ch_id desc");
			while($row = sql_fetch_array($rs)){
				$ch_tag = explode('^chat^', $row['ch_tag']);
				$img_src = G5_DATA_PATH.'/ch_profile/ch_'.$row['ch_id'].'.gif';
			?>
			<li>
				<div class="troom_rank"><?=$row['ch_id']?></div>
				<div class="troom_thum"><img src="<?php echo is_file($img_src) ? '/data/ch_profile/ch_'.$row['ch_id'].'.gif' : '/img/no_profile.gif'?>" id="ch_profile"></div>
				<div class="troom_tit"><a href="/chat/view/<?=$row['ch_id']?>"><h4><?=$row['ch_subject']?></h4><p>&lt<?=$row['mb_nick']?>&gt <span>승률 : 55%</span></p></a></div>
				<span class="talk_tag_cate">
				<?php
					for($i=0; $i<count($ch_tag)-1; $i++)
						echo "<span>#{$ch_tag[$i]}</span>";
				?>
				</span>
			</li>
			<?php } ?>
		</ul>
	</div>

</section>
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