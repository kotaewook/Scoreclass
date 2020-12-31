<?php
$basename = basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.

	$bo_table = $_GET['bo_table'];

	if( $basename == "live_soccer.php"){
		$img_file = "live_sc";
		$div_style="#12100b";
		$p_subject = lang('라이브스코어', 'Live Score');
		$h2_color="#fff";
	} else if( $basename == "live_baseball.php" ){
		$img_file = "live_bs";
		$div_style="#e4e4e4";
		$p_subject = "라이브스코어";
		$h2_color="#031949";
	}	 else if( $basename == "live_basketball.php" ){
		$img_file = "live_bk";
		$div_style="#527ea9";
		$p_subject="라이브스코어";
		$h2_color="#fff";
	} else if( strpos($_SERVER['REQUEST_URI'], 'special') ){
		$img_file = "fa";
		$div_style="#130c06";
		$p_subject =  lang('스페셜경기', 'Special Game');
		$h2_color="#fff";
	} else if( $basename == "game.php"){
		$h2_subject =  lang('승무패', 'Money Line Bets');
		$p_subject =  lang('스코어클래스의 승무패로 예상적중의 짜릿함을 느껴보세요!', '');
	}	 else if( $basename == "betting_history.php" ){
		$h2_subject = lang('배팅내역', 'Betting history');
		$p_subject =  lang('스코어클래스 배팅내역을 확인하세요!', '');
	} else if($bo_table != "freeboard" && $bo_table != ''){
		$h2_subject = $board['bo_subject'];
		$p_subject = lang('스코어클래스의 승무패로 예상적중의 짜릿함을 느껴보세요!');
	} else if($pg_type == "mypage" || strpos($basename, 'register') !== false){
		$h2_subject = strpos($basename, 'register') !== false ? lang('회원가입', 'Rgister') : lang('마이페이지', 'Mypage');
		$p_subject = strpos($basename, 'register') !== false ? lang('회원가입', 'Rgister') : lang('마이페이지', 'Mypage');
	} else if($pg_type == 'chat' ){
        $h2_subject = lang('단톡방');
		$p_subject = lang('단톡방');
    }  else if( $bo_table == "freeboard"){
		$h2_subject = lang('자유게시판', 'Free Board');
        $p_subject = lang('자유게시판', 'Free Board');
    } else if( $basename == "login.php"){
        $h2_subject = lang('로그인', 'Login');
    } else if(strpos($_SERVER['REQUEST_URI'], 'market')) {
		$h2_subject = lang('마켓', 'Market');
		$p_subject = lang('코인을 충전하여 다양한 아이템을 구매해보세요.', '');
	} else if(strpos($_SERVER['REQUEST_URI'], 'faq')) {
		$h2_subject = lang('FAQ');
		$p_subject = lang('FAQ');
	} else if($pg_type == 'exchange') {
		$h2_subject =  lang('거래소', 'Exchange');
		$p_subject =  lang('거래소', 'Exchange');
	} else if(strpos($_SERVER['REQUEST_URI'], 'game_guide')) {
		$h2_subject =  lang('게임가이드', 'Game Guide');
		$p_subject =  lang('스코어클래스의 게임가이드를 확인해주세요!');
	} else if(strpos($_SERVER['REQUEST_URI'], 'regulation')) {
		$h2_subject =  lang('배팅규정', 'Betting Guide');
		$p_subject =  lang('배팅규정', 'Betting Guide');
	} else if($co_id == 'privacy') {
		$h2_subject =  lang('개인정보처리방침');
		$p_subject =  lang('개인정보처리방침');
	} else if($co_id == 'provision') {
		$h2_subject =  lang('서비스이용약관');
		$p_subject =  lang('서비스이용약관');
	} else if($basename == "qalist.php" || $basename == 'qawrite.php' || $basename == 'qaview.php') {
		$h2_subject =  lang('1:1 문의');
		$p_subject =  lang('1:1 문의');
	}
?>

<div class="subtit_bn"> 
	<div>
		<h2><?=$h2_subject?></h2>
		<p><?=$p_subject?></p>
	</div>
</div>
