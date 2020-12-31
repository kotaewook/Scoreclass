<?php
include_once('../common.php');
if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');

include_once(G5_THEME_PATH.'/head.php');
if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/chat/m_chat_view.php');
    return;
}
$row = sql_fetch("select a.mb_id, ch_id, mb_name, ch_subject, ch_point from {$g5['chat_list']} a inner join {$g5['member_table']} b on a.mb_id = b.mb_id where a.ch_id = '{$ch_id}'");
if(!$ch_id || !$row['mb_id'])
	alert(lang('단톡방이 존재하지 않습니다.'), '/chat/list');
else if($row['mb_id'] != $member['mb_id']) {
	$pt_chk = sql_fetch("select * from {$g5['rp_log']} where mb_id = '{$member['mb_id']}' and pt_type = '30' and pt_num ='{$ch_id}'");
	if(!$pt_chk && $row['ch_point'] > $member['mb_rp'])
		alert(lang('입장 포인트가 부족합니다.\n입장포인트 : '.number_format($row['ch_point'])));
	else {
		point_log('rp', $row['ch_point'] * -1, $row['mb_id'], $member['mb_id'], 30, $ch_id);
	}
}

$fav = sql_fetch("select * from {$g5['chat_fav']} where mb_id = '{$member['mb_id']}' and ch_id = '{$ch_id}'");
?>


<section class="sec_talk" style="border-top:1px solid #d1d1d1;">

<div class="talk_tit">
	<h3><?=$row['ch_subject']?></h3>
	<div><button class="talk_fav" data-index="<?=$ch_id?>"><i class="fa fa-heart"></i> <span><?=$fav?lang('즐겨찾기 해제', 'Bookmark'):lang('즐겨찾기', 'Bookmark')?></span></button>&nbsp <a href="/chat/list" class="talk_exit">나가기</a></div>
</div>

<div class="talk_box_wrap">
	<div class="main_chat_wrap">
		<script type="text/javascript" src="<?php echo $_MINITALK_PATH; ?>script/minitalk.js" charset="UTF-8"></script>
		<script type="text/javascript">
		new Minitalk({
			channel:"<?=$row['mb_id'].'_'.$ch_id?>",
			nickname:"<?=$member['mb_nick']?>",
			<?php if ($is_admin || $member['mb_id'] == $row['mb_id']) { ?>
			opperCode:"<?php echo GetOpperCode('ADMIN'); ?>",
			info:{photo:$('.fa_myinfo_box img').attr('src')},
			<?php } elseif ($is_member) { ?>
			opperCode:"<?php echo GetOpperCode('MEMBER'); ?>",
			info:{photo:$('.fa_myinfo_box img').attr('src')},
			<?php } ?>
			width:"100%",
			height:500,
			skin:"kakaotalk",
			viewAlert:false,
			showChannelConnectMessage:false,
			language:"<?=$country=='ch'?'en':$country?>"
		});
		</script>
	</div>
</div>

</section>

<aside class="aside_fa">
	<?php include_once(G5_PATH.'/login_form.php')?>
	<div class="right_rank">
		<?php include_once(G5_PATH.'/live_rank.php');?>
	</div>
</aside>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>