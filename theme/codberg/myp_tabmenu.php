
<?php
$basename=basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.

if( $basename == "mypage.php" ){
	$tabmenu01 = "on";
	}
//if( $basename == "mypage.php" ){
//	$tabmenu02 = "on";
//	}	
if( $basename == "exp_list.php" ){
	$tabmenu03 = "on";
	}	
if( $basename == "recomm.php" ){
	$tabmenu04 = "on";
	}
if( $basename == "point_list.php" ){
	$tabmenu05 = "on";
	}

?>


<nav class="myp_tab">
	<ul>
		<li class="<?=$tabmenu01?>"><a href="/mypage"><?=lang('내정보', 'My info')?></a></li>
		<li class="<?=$tabmenu02?>" style="display:none;"><a href="#item"><?=lang('아이템', 'Item')?></a></li>
		<li class="<?=$tabmenu03?>"><a href="/exp_list"><?=lang('활동내역', 'Activity details')?></a></li>
		<li class="<?=$tabmenu04?>"><a href="/recomm"><?=lang('나를 추천한 회원', 'Recommended list')?></a></li>
		<li class="<?=$tabmenu05?>"><a href="/point_list"><?=lang('포인트 적립내역', 'Point reserve details')?></a></li>
	</ul>
</nav>