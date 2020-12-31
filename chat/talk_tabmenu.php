<?php
$basename=basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.

if( $basename == "chat_list.php" || $basename == "chat_setup.php" ){
	$tabmenu01 = "on";
	}
	
if( $basename == "chat_fav.php" ){
	$tabmenu02 = "on";
	}

?>
<div class="talk_menu_srch">
<nav class="talk_tab myp_tab">
	<ul>
		<li class="<?php echo $tabmenu01; ?>"><a href="/chat/list"><?=lang('단톡방', 'Group Chat', '団体チャット', '集体聊天')?></a></li>
		<li class="<?php echo $tabmenu02; ?>"><a href="/chat/fav"><?=lang('즐겨찾기', 'Bookmark')?></a></li>
	</ul>
</nav>

