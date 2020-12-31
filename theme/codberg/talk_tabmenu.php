
<?php
$basename=basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.

if( $basename == "talk_list.php" ){
	$tabmenu01 = "on";
	}
	
if( $basename == "talk_fav.php" ){
	$tabmenu02 = "on";
	}

?>

<div class="talk_menu_srch">

	<nav class="talk_tab myp_tab">
		<ul>
			<li class="<?php echo $tabmenu01; ?>"><a href="<?php echo G5_BBS_URL ?>/talk_list.php">단톡방</a></li>
			<li class="<?php echo $tabmenu02; ?>"><a href="<?php echo G5_BBS_URL ?>/talk_fav.php">즐겨찾기</a></li>
		</ul>
	</nav>

