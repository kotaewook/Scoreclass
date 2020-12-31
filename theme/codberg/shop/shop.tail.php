<?php
if (G5_IS_MOBILE) {
	include_once(G5_THEME_PATH.'/mobile/shop/shop.tail.php');
    return;
}
?>
	</section>
</section>
<aside class="aside_fa">
	<?php include_once(G5_PATH.'/login_form.php')?>
	<div class="right_rank">
		<?php include_once(G5_PATH.'/live_rank.php');?>
	</div>
</aside>
<?php include_once(G5_PATH.'/tail.php');?>