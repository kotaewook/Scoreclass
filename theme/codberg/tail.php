<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>
	<?php if (!defined("_INDEX_")) { ?></div><?php }?>
    </div>
</div>

</div>
<!-- } 콘텐츠 끝 -->

<hr>
<!-- 하단 시작 { -->
<div id="ft">

    <div id="ft_wr">
		 <div id="ft_cs">
			<ul>
				<li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보처리방침</a></li>
				<li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">서비스이용약관</a></li>
				<li><a href="/board/notice">공지사항</a></li>
				<li><a href="/faq">FAQ</a></li>
				<li><a href="/bbs/qalist.php">1:1문의</a></li>
			</ul>
        </div>
		<div class="ft_addr">
            <span><?php echo $default['de_admin_company_name']; ?></span>&nbsp&nbsp&nbsp&nbsp
            <span>대표이사&nbsp&nbsp<?php echo $default['de_admin_company_owner']; ?></span>&nbsp&nbsp&nbsp&nbsp
            <span>사업자등록번호&nbsp&nbsp<?php echo $default['de_admin_company_saupja_no']; ?></span>&nbsp&nbsp&nbsp&nbsp
            <span>TEL <?php echo $default['de_admin_company_tel']; ?></span>&nbsp&nbsp&nbsp&nbsp
            <span>FAX <?php echo $default['de_admin_company_fax']; ?></span><br>
            <span>주소 <?php echo $default['de_admin_company_addr']; ?> (6-7F, 11-10 Teheran-ro 77-gil, Gangnam-gu, Seoul)</span>
		</div>
    </div>
    
    <!--button type="button" id="top_btn"><i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span></button-->
        <script>
        
        $(function() {
            $("#top_btn").on("click", function() {
                $("html, body").animate({scrollTop:0}, '500');
                return false;
            });
        });
        </script>
</div>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>