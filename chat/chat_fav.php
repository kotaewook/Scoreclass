<?php include_once('../common.php');
if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');

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
	include_once(G5_PATH.'/chat/m_chat_fav.php');
    return;
}

include_once('../head.php');
include_once('talk_tabmenu.php');

$cnt = sql_fetch("select count(*) as cnt from {$g5['chat_fav']} a inner join {$g5['chat_list']} b on a.ch_id = b.ch_id where a.mb_id = '{$member['mb_id']}'");
$cnt = $cnt['cnt'];

$rows = 10;
if($page < 1) $page = 1;
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql_limit = " limit {$from_record}, {$rows}";
?>

<div class="talk_srch_set">
	<fieldset class="talk_srch">
		<legend>단톡방 검색</legend>
		<form action="" method="get">
		<label class="sound_only">검색대상</label>
		<select name="fild">
			<option value="ch_subject" <?php echo get_selected($_GET['fild'], "ch_subject"); ?>>단톡방 제목</option>
		</select>
		<input type="search" name="stx" placeholder="검색어를 입력해주세요" class="srch_in" value="<?=$stx?>">
		<button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> <span class="sound_only">검색</span></button>
		</form>
	</fieldset>
</div>

<section class="sec_talk">

	<div class="talk_gen talk_list">
		<h3>즐겨찾기</h3>
		<ul>
			<?php
			$rs = sql_query("select * from {$g5['chat_fav']} a inner join {$g5['chat_list']} b on a.ch_id = b.ch_id where a.mb_id = '{$member['mb_id']}' {$sql_search} order by cf_datetime desc {$sql_limit}");
			for($i=0; $row = sql_fetch_array($rs); $i++){
				$mb = get_member($row['mb_id'], 'mb_name');
				$ch_tag = explode('^chat^', $row['ch_tag']);
				$img_src = G5_DATA_PATH.'/ch_profile/ch_'.$row['ch_id'].'.gif';
			?>
			<li>
				<div class="troom_rank"><?=$i+1?></div>
				<div class="troom_thum"><img src="<?php echo is_file($img_src) ? '/data/ch_profile/ch_'.$row['ch_id'].'.gif' : '/img/no_profile.gif'?>" id="ch_profile"></div>
				<div class="troom_tit"><a href="/chat/view/<?=$row['ch_id']?>"><h4><?=$row['ch_subject']?></h4><p>&lt<?=$mb['mb_name']?>&gt <span>승률 : 55%</span></p></a></div>
				<span class="talk_tag_cate">
					<?php
					for($j=0; $j<count($ch_tag)-1; $j++)
						echo "<span>#{$ch_tag[$j]}</span>";
					?>
				</span>
			</li>
			<?php } if($i == 0){?>
			<li class="no-list">
				<?=lang('즐겨찾기하신 단톡방이 없습니다.')?>
			</li>
			<?php }?>
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
include_once('../tail.php');
?>