<?php
if(!$is_member){
?>

<form name="flogin" action="/bbs/login_check.php" onsubmit="return flogin_submit(this);" method="post">
	<input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<div class="login_div">
		<div>
			<label for="login_id" class="sound_only">회원아이디<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="mb_id" class="main_login_id main_login_input" placeholder="<?=lang('아이디', 'ID', '', '账户')?>">
			<label for="login_pw" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
			<input type="password" name="mb_password" class="main_login_pw main_login_input" placeholder="<?=lang('비밀번호', 'Password', '', '登录密码')?>">
			<input type="submit" value="<?=lang('로그인', 'Login', '', '登录')?>" class="btn_main_submit">
		</div>
	</div>
	
	<aside id="login_info">
		<h2>회원로그인 안내</h2>
		<div>
			<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost">ID/PW 찾기</a>
			<a href="/bbs/register.php"><?=lang('회원가입', 'Sign up', '', '免费注册会员')?></a>
			<?php @include_once(get_social_skin_path().'/social_login.skin.php');?>
		</div>
		
	</aside>
	
</form>
<?php
} else {
	$profile_img = get_member_profile_img($member['mb_id'], 100, 100);
	$next_lv = sql_fetch("select rk_exp from {$g5['rank_table']} where rk_exp > '{$member['mb_exp']}' order by rk_exp asc");
	$exp_percent = round_down($member['mb_exp']/$next_lv['rk_exp']*100, 1);

	$sql = " select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '{$member['mb_id']}' and me_read_datetime = '0000-00-00 00:00:00' ";
	$me = sql_fetch($sql);
	$memo_not_read = $me['cnt'];
?>
<div class="fa_myinfo_box">
    <div class="inner cf">
		<div class="login_top">
			<div class="img_warp"><?=$profile_img?></div>
			<ul class="my_info_detail">
				<li>
					<strong id="my_name"><?=get_rank_ico($member['mb_id'])?> <?=$member['mb_nick']?></strong>
				</li>
				<li>
					<p class="exp_top">EXP<span>Lv Up</span></p>
					<div class="exp_bar"><div style="width:<?=$exp_percent?>%;"></div></div>
				</li>
				<li class="but">
					<a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" id="ol_after_memo" class="win_memo"><img src="<?=G5_THEME_IMG_URL?>/note_ico.png" height="13"> <?=lang('쪽지', 'Note')?> <font><?=number_format($memo_not_read)?></font></a>
					<a href="/betting_history"><?=lang('배팅내역', 'Betting details')?></a>
					<a href="/market/item"><?=lang('내아이템', 'My item')?></a>
				</li>
			</ul>
        </div>
        <ul class="myinfo_btn">
			<li><span>C</span><strong><?=round_down_format($member['mb_cp'], 2)?></strong></li>
			<li><span><?=$pt_name['rp']?></span><strong><?=round_down_format($member['mb_rp'], 2)?></strong></li>
            <li><a href="/mypage"><?=lang('내 정보', 'Mypage')?> <img src="<?=G5_THEME_IMG_URL?>/mypage_ico.png" height="15"></a></li>
        </ul>
    </div>
</div>
<?php }?>