<?php
if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'), '/bbs/login.php');
?>
<nav>
	<ul>
		<li<?php if($ec_type == 'trade') echo ' class="select"';?>><a href="/exchange"><?=lang('거래소', 'Exchange', '取引所', '交易所')?></a></li>
		<li<?php if($ec_type == 'sale') echo ' class="select"';?>><a href="/exchange/sale"><?=lang('판매등록', 'Sales registration', '販売登録', '出售登记')?></a></li>
		<li<?php if($ec_type == 'sale_list') echo ' class="select"';?>><a href="/exchange/sale_list"><?=lang('판매내역', 'Sales history', '販売内訳', '出售明细')?></a></li>
		<li<?php if($ec_type == 'buy_list') echo ' class="select"';?>><a href="/exchange/buy_list"><?=lang('구매내역', 'Purchase history', '購買内訳', '购买明细')?></a></li>
	</ul>
</nav>                             