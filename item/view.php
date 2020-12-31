<?php include_once('../common.php');
include_once(G5_THEME_SHOP_PATH.'/shop.head.php');

if(!$it_id)
	alert(lang('상품정보가 없습니다.'));

$row = sql_fetch("select *, it_{$country}_name as it_name from {$g5['item_shop']} where it_id = '{$it_id}'");
?>

<div class="warp">
	<form action="/item/bbs/order_ok.php" method="post">
		<input type="hidden" value="<?=$it_id?>" name="it_id">
		<div class="item_info">
			<p><?=$row['it_name']==''?$row['it_en_name']:$row['it_name']?><?=$row['it_best']==1?'<span>BEST</span>':''?></p>
			<div>
				<div class="img">
					<b><span><?=$pt_name['rp']?></span><?=number_format($row['it_gp'])?> 지급</b>
					<img src="/data/item/<?=$row['it_id']?>.gif" alt="베스트 아이템" title="">
				</div>
				<div class="info">
					<p>
						<strong>수량</strong>
						<select name="it_count" data-price="<?=$row['it_price']?>">
							<?php for($i=1; $i<51; $i++){?>
							<option value="<?=$i?>"><?=$i?></option>
							<?php }?>
						</select>
					</p>
					<p><strong><?=$row['it_name']==''?$row['it_en_name']:$row['it_name']?></strong><b><font><?=number_format($row['it_price'])?></font> P</b></p>
					<p><?=nl2br($row['it_'.$country.'_content'])?></p>
				</div>
			</div>
			<span>
				<button class="btn btn_01"><?=lang('구매하기')?></button>
			</span>
		</div>
	</form>
</div>
<script>
$("select[name='it_count']").change(function(){
	var price = $(this).attr('data-price') * $(this).val();
	$('.item_info > div > .info > p b font').text(number_format(price));
});
</script>
<?php include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');?>