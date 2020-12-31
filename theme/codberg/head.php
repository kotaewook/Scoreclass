<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}

if (G5_IS_MOBILE) {
	include_once(G5_THEME_PATH.'/mobile/head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>
<div class="menu_back1"></div>
<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
	<div id="tnbwrap">
	    <div id="tnb" class="cf">
			<div class="util_l btn_fav"><a href="#" id="favorite" title="<?=lang('즐겨찾기 추가', 'Bookmark ', '', '')?>"><img src="<?php echo G5_THEME_IMG_URL; ?>/btn_fav.png" alt="" /> <?=lang('즐겨찾기 추가', 'Bookmark ', '', '')?></a></div>
			<div class="util_l btn_cs"><a href="/board/notice"><img src="<?php echo G5_THEME_IMG_URL; ?>/btn_cs.png" alt="" /> 고객센터</a></div>
			
			<div class="util_r">
				<?php
				if($country == 'ko')
					$langtxt = '한국어';
				elseif($country == 'en')
					$langtxt = 'English';
				elseif($country == 'ja')
					$langtxt = '日本語';
					elseif($country == 'ch')
					$langtxt = '中國語';
				?>
                <ul class="btn_lang">
                    <li>
                        <span id="<?=$country?>"><img src="<?php echo G5_THEME_IMG_URL; ?>/langbtn_<?=$country?>.png"> <?=$langtxt?> &nbsp<i class="fa fa-caret-down"></i></span>
                        <ul>
                            <li><span id="ko"><img src="<?php echo G5_THEME_IMG_URL; ?>/langbtn_ko.png"> 한국어</span></li>
                            <li><span id="en"><img src="<?php echo G5_THEME_IMG_URL; ?>/langbtn_en.png"> English</span></li>
                            <li><span id="ja"><img src="<?php echo G5_THEME_IMG_URL; ?>/langbtn_ja.png"> 日本語</span></li>
                            <li><span id="ch"><img src="<?php echo G5_THEME_IMG_URL; ?>/langbtn_ch.png"> 中國語</span></li>
                        </ul>
                    </li>
                </ul>
                <ul class="btn_mem">
                    <?php if ($is_member) {  ?>

                    <li><a href="/mypage"><?=lang('정보수정', 'Information modification', '', '')?></a></li>
                    <li><a href="<?php echo G5_BBS_URL ?>/logout.php"><?=lang('로그아웃', 'Logout', '', '')?></a></li>
                    <?php if ($is_admin) {  ?>
                    <li class="tnb_admin"><a href="<?php echo G5_ADMIN_URL ?>"><?=lang('관리자', 'Admin', '', '')?></a></li>
                    <?php }  ?>
                    <?php } else {  ?>
                    <li><a href="<?php echo G5_BBS_URL ?>/login.php"><!--<img src="<?php echo G5_THEME_IMG_URL; ?>/btn_login.png" alt="" />--><?=lang('로그인', 'Login', '', '')?></a></li>
                    <li><a href="<?php echo G5_BBS_URL ?>/register.php"><?=lang('회원가입', 'Sign up', '', '')?></a></li>
                    
                    <?php }  ?>
                </ul>
			</div>
		</div>
	</div>

    <div id="hd_wrapper">
        <div class="inner">
            <div id="logo">
                <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_DATA_URL; ?>/common/logo_img" alt="<?php echo $config['cf_title']; ?>"></a>
            </div>

            <nav id="gnb">
                <div class="gnb_wrap">
                    <ul id="gnb_1dul">
                        <!--<li class="gnb_1dli gnb_mnal"><button type="button" class="gnb_menu_btn"><span class="sound_only">전체메뉴열기</span></button></li>-->
                        <?php
                        $sql = " select *, me_{$country}_name as me_name
                                    from {$g5['menu_table']}
                                    where me_use = '1'
                                      and length(me_code) = '2'
                                    order by me_order, me_id ";
                        $result = sql_query($sql, false);
                        $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                        $menu_datas = array();

                        for ($i=0; $row=sql_fetch_array($result); $i++) {
                            $menu_datas[$i] = $row;

                            $sql2 = " select *, me_{$country}_name as me_name
                                        from {$g5['menu_table']}
                                        where me_use = '1'
                                          and length(me_code) = '4'
                                          and substring(me_code, 1, 2) = '{$row['me_code']}'
                                        order by me_order, me_id ";
                            $result2 = sql_query($sql2);
                            for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                                $menu_datas[$i]['sub'][$k] = $row2;
                            }

                        }

                        $i = 0;
                        foreach( $menu_datas as $row ){
                            if( empty($row) ) continue; 
                        ?>
                        <li class="gnb_1dli" style="z-index:<?php echo $gnb_zindex--; ?>">
                            <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                            <?php
                            $k = 0;
                            foreach( (array) $row['sub'] as $row2 ){

                                if( empty($row2) ) continue; 

                                if($k == 0)
                                    echo '<span class="bg">하위분류</span><ul class="gnb_2dul">'.PHP_EOL;
                            ?>
                                <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
                            <?php
                            $k++;
                            }   //end foreach $row2

                            if($k > 0)
                                echo '</ul>'.PHP_EOL;
                            ?>
                        </li>
                        <?php
                        $i++;
                        }   //end foreach $row

                        if ($i == 0) {  ?>
                            <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                        <?php } ?>
                    </ul>
                    <div id="gnb_all">
                        <h2>전체메뉴</h2>
                        <ul class="gnb_al_ul">
                            <?php

                            $i = 0;
                            foreach( $menu_datas as $row ){
                            ?>
                            <li class="gnb_al_li">
                                <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_al_a"><?php echo $row['me_name'] ?></a>
                                <?php
                                $k = 0;
                                foreach( (array) $row['sub'] as $row2 ){
                                    if($k == 0)
                                        echo '<ul>'.PHP_EOL;
                                ?>
                                    <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a></li>
                                <?php
                                $k++;
                                }   //end foreach $row2

                                if($k > 0)
                                    echo '</ul>'.PHP_EOL;
                                ?>
                            </li>
                            <?php
                            $i++;
                            }   //end foreach $row

                            if ($i == 0) {  ?>
                                <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                            <?php } ?>
                        </ul>
                        <button type="button" class="gnb_close_btn"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                </div>
				<div class="menu_back"></div>
            </nav>

            <!--div class="quick">
               <p>게임센터</p>
               <ul>
                    <li><a href=""><img src="<?php echo G5_THEME_IMG_URL; ?>/quick_game01.png" alt="승무패" /></a></li>
                    <li><a href=""><img src="<?php echo G5_THEME_IMG_URL; ?>/quick_game02.png" alt="파워볼" /></a></li>
                    <li><a href=""><img src="<?php echo G5_THEME_IMG_URL; ?>/quick_game03.png" alt="사다리" /></a></li>
                    <li><a href=""><img src="<?php echo G5_THEME_IMG_URL; ?>/quick_game04.png" alt="달팽이" /></a></li>
                    <li><a href=""><img src="<?php echo G5_THEME_IMG_URL; ?>/quick_game05.png" alt="스피드키노" /></a></li>
               </ul>
            </div-->
            <script>

            $(function(){
                $(".gnb_menu_btn").click(function(){
                    $("#gnb_all").show();
                });
                $(".gnb_close_btn").click(function(){
                    $("#gnb_all").hide();
                });
            });

            </script>
		</div>
    </div>
</div>

<?php
if(! defined('_INDEX_' )) {
	include_once(G5_THEME_PATH.'/subtit_bn.php');
}
?>

<!-- } 상단 끝 -->

<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="container_wr">
        <div id="container">
            <?php if (!defined("_INDEX_")) { ?>
			<div class="con_inner">
			<?php } ?>

