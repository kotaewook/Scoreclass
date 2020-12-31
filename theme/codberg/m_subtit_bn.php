<?php
$basename = basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.

	$bo_table = $_GET['bo_table'];

	if( $basename == "live_soccer.php" ){
		$img_file = "live_sc";
		$div_style="#12100b";
		$p_subject="라이브스코어";
		$h2_color="#fff";
	} else if( $basename == "live_baseball.php" ){
		$img_file = "live_bs";
		$div_style="#e4e4e4";
		$p_subject="라이브스코어";
		$h2_color="#031949";
	} else if( $basename == "live_basketball.php" ){

		$img_file = "live_bk";
		$div_style="#527ea9";
		$p_subject="라이브스코어";
		$h2_color="#fff";
	} else if( $basename == "game.php" ){
		$img_file = "fa";
		$div_style="#130c06";
		$p_subject=lang('승무패', 'Money Line Bets');
		$h2_color="#fff";
	} else if( $basename == "betting_history.php" ){
		$img_file = "batlist";
		$div_style="#f2e7e1";
		$p_subject=lang('배팅내역', 'Betting history');
		$h2_color="#031949";
	} else if($bo_table != "freeboard" && $bo_table != ''){
		$img_file = "spo_analy";
		$div_style="#e9e9e8";
		$p_subject = $board['bo_subject'];
		$h2_color="#031949";
	}  else if( $bo_table == "freeboard"){
        $img_file = "comm";
        $div_style="#e7e9ee;";
        $p_subject ="자유게시판";
        $h2_color="#031949";
    } else if( $basename == "mypage.php" || $basename == "exp_list.php"  || $basename == "recomm.php"  || $basename == "point_list.php" || $basename == "rank.php" ){
		$img_file = "m_myp";
		$div_style="#fefefe;";
		$p_subject = "마이페이지";
		$h2_color="#031949";
	} else if( $basename == "login.php"){
		$style = "text-align:center; margin-bottom:30px; margin-top:50px;";
        $p_subject = lang('로그인', 'Login');
        $h2_color="#12155a";
		$h2_style = 'padding:0; line-height:150px; font-size:30px;';
    } else if(strpos($_SERVER['REQUEST_URI'], 'market')) {
		$p_subject = lang('마켓', 'Market');
		$h2_color="#12155a";
		$img_file = "myp";
		$div_style = "#fefefe;background-image:linear-gradient(to top, #9999991a 0px, #fafafa 7px, #fefefe 22px);";
	} else if($pg_type == 'chat' ){
        $img_file = "talk";
        $div_style = "#010101;";
        $p_subject ="단톡방";
        $h2_color="#fff";
    } else if($pg_type == 'exchange') {
		$img_file = "fa";
		$div_style="#130c06";
		$p_subject =  lang('거래소', 'Exchange');
		$h2_color="#fff";
	} else if(strpos($_SERVER['REQUEST_URI'], 'game_guide')) {
		$img_file = "fa";
		$div_style="#130c06";
		$p_subject =  lang('게임가이드', 'Game Guide');
		$h2_color="#fff";
	}

	/*
	
	<div class="subtit_bn" style="background-color:<?= $div_style?>;"> 
	<div style="background-image:url(<?php echo G5_THEME_IMG_URL; ?>/tit_bg_<?= $img_file?>.png); ">
		<h2 style="color:<?= $h2_color?>;"><?= $p_subject?></h2>
	</div>
</div>
	*/
?>


