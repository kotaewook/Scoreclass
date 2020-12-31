<?php include_once('../common.php');

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>
<div class="warp">

	<ul class="item_list">
		<?php
		$rs = sql_query("select *, it_{$country}_name as it_name from {$g5['my_item']} a inner join {$g5['item_shop']} b on a.it_id = b.it_id where mb_id = '{$member['mb_id']}' and it_count > 0 order by it_datetime desc");
		for($i=0; $row = sql_fetch_array($rs); $i++){
			$target = 0;
			if($row['it_id'] == 3)
				$href = '/betting_history';
			else if($row['it_id'] < 3)
				$href = '/mypage';
			else if($row['it_id'] < 7){
				$href = '/bbs/memo_form.php';
				$target = 1;
			} else
				$href = '#';
		?>
		<li>
			<div class="img">
				<img src="/data/item/<?=$row['it_id']?>.gif" alt="<?=$row['it_name']==''?$row['it_en_name']:$row['it_name']?>" title="<?=$row['it_name']==''?$row['it_en_name']:$row['it_name']?>">
			</div>
			<div class="info">
			<b><?=$row['it_name']==''?$row['it_en_name']:$row['it_name']?></b>
			<p><?=number_format($row['it_count'])?><font color="#000">개</font></p>
			</div>
			<a href="<?=$href?>" <?php if($target == 1) echo 'target="_blank"';?> class="btn_buy<?php if($target == 1) echo ' win_memo';?>"><?=lang('사용하기')?></a>
		</li>
		<?php } if ($i==0) echo '<li class="no-list">'.lang('보유중인 아이템이 없습니다.').'</li>';?>
	</ul>
</div>
<?php include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');?>