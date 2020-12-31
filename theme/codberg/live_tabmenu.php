
<?php
$basename=basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.

if( $basename == "live_soccer.php" ){
	$tabmenu01 = "on";
	}
	
if( $basename == "live_base.php" ){
	$tabmenu02 = "on";
	}
	
if( $basename == "live_basket.php" ){
	$tabmenu03 = "on";
	}

?>

<nav class="live_ball_tab">
	<ul>
		<li class="<?=$tabmenu01?>"><a href="/live"><?=lang('축구', 'Soccer')?></a></li>
		<li class="<?=$tabmenu02?>"><a href="<?php echo G5_BBS_URL ?>/live_base.php"><?=lang('야구', 'Baseball')?></a></li>
		<li class="<?=$tabmenu03?>"><a href="<?php echo G5_BBS_URL ?>/live_basket.php"><?=lang('농구', 'Basketball')?></a></li>
		<li style="display:none;"><a href="">배구 <span class="tabmenu_num">1</span></a></li>
		<li style="display:none;"><a href="">하키 <span class="tabmenu_num">1</span></a></li>
	</ul>
</nav>
