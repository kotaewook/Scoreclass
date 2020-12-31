<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원가입약관 동의 시작 { -->
<div class="join_btn_wrap">

    <div class="join_gen">
        <a href="<?php echo G5_BBS_URL; ?>/register_form.php" class="">일반 회원가입</a>
    </div>

    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    @include_once(get_social_skin_path().'/social_register.skin.php');
    ?>

</div>
<!-- } 회원가입 약관 동의 끝 -->
