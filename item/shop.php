<?php include_once('../common.php');

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>
<div class="warp">
	<ul class="item_list">
		<?php 
		$rs = sql_query("select *, it_{$country}_name as it_name from {$g5['item_shop']} order by it_id asc");
		for($i=0; $row = sql_fetch_array($rs); $i++){
		?>
		<li>
			<div class="img">
				<?php if($row['it_gp'] > 0){?><b><span class="pt_gp"><?=$pt_name['rp']?></span><?=number_format($row['it_gp'])?> 지급</b><?php }?>
				<div><img src="/data/item/<?=$row['it_id']?>.gif" alt="<?=$row['it_name']==''?$row['it_en_name']:$row['it_name']?>" title=""></div>
			</div>
			<div class="info">
				<b><?=$row['it_name']==''?$row['it_en_name']:$row['it_name']?></b>
				<?=nl2br($row['it_'.$country.'_content'])?>
				<p><span class="pt_cp">C</span><?=number_format($row['it_price'])?></p>
			</div>
			<div class="form">
				<form action="/item/bbs/order_ok.php" method="post">
					<input type="hidden" value="<?=$row['it_id']?>" name="it_id">
					<select name="it_count">
						<?php for($i=1; $i<51; $i++){?>
						<option value="<?=$i?>"><?=$i?></option>
						<?php }?>
					</select>
					<button class="btn_buy"><?=lang('구매하기', 'Buy')?></button>
				</form>
			</div>
		</li>
		<?php }?>
	</ul>
</div>
<?php include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');?>