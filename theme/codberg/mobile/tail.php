<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}

?>
    </div>
</div>



<div id="ft">
    <div id="ft_copy">
        <div id="ft_company">
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">회사소개</a>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보처리방침</a>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">서비스이용약관</a>
        </div>
		<div class="ft_addr">
            <span><?php echo $default['de_admin_company_name']; ?></span>&nbsp&nbsp|&nbsp&nbsp
            <span>대표이사&nbsp&nbsp<?php echo $default['de_admin_company_owner']; ?></span><br>
            <span>사업자등록번호&nbsp&nbsp<?php echo $default['de_admin_company_saupja_no']; ?></span><br>
            <span>TEL: <?php echo $default['de_admin_company_tel']; ?></span>&nbsp&nbsp|&nbsp&nbsp
            <span>FAX: <?php echo $default['de_admin_company_fax']; ?></span><br>
            <span>주소: <?php echo $default['de_admin_company_addr']; ?></span><br>
			Copyright &copy; <b>SCORECLASS.</b> All rights reserved.
		</div>
    </div>
    <button type="button" id="top_btn"><i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span></button>
    <?php
    if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
    <!--a href="<?php echo get_device_change_url(); ?>" id="device_change">PC 버전으로 보기</a-->
    <?php
    }

    if ($config['cf_analytics']) {
        echo $config['cf_analytics'];
    }
    ?>
</div>



<script>
jQuery(function($) {

    $( document ).ready( function() {

        // 폰트 리사이즈 쿠키있으면 실행
        font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
        
        //상단고정
        if( $(".top").length ){
            var jbOffset = $(".top").offset();
            $( window ).scroll( function() {
                if ( $( document ).scrollTop() > jbOffset.top ) {
                    $( '.top' ).addClass( 'fixed' );
                }
                else {
                    $( '.top' ).removeClass( 'fixed' );
                }
            });
        }

        //상단으로
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });

    });
});

//상단고정
$(window).scroll(function(){
  var sticky = $('.top'),
      scroll = $(window).scrollTop();

  if (scroll >= 50) sticky.addClass('fixed');
  else sticky.removeClass('fixed');
});

//상단으로
$(function() {
    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>
<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>