<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

include_once(G5_PATH.'/head.php');
?>
<section class="sec_fa">
	<section>
		<nav>
			<ul class="shop">
				<li<?php if($page_type == 'coin') echo ' class="select"';?>><a href="/market"><?=lang('코인충전')?></a></li>
				<li<?php if($page_type == 'shop' || $page_type == 'view') echo ' class="select"';?>><a href="/market/shop"><?=lang('아이템샵')?></a></li>
				<li<?php if($page_type == 'item') echo ' class="select"';?>><a href="/market/item"><?=lang('내아이템')?></a></li>
			</ul>
		</nav>