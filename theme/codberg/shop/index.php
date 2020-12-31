<?php $page_type = 'coin';
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>

<div class="shop_warp">
	<div class="my_coin">
	<p><?=lang('<strong>보유중 코인</strong>')?><b><?=round_down_format($member['mb_cp']??0, 2)?></b><font>코인</font><span>구입하신 코인은 마켓에서 사용하실 수 있습니다.</span></p>
	</div>
	<form action="/item/bbs/charging_ok.php" method="post">
		<div id="cash_list">
			<p><b>충전금액</b> 선택</p>
			<?php $cash = array(3000, 5000, 10000, 30000, 50000, 100000, 300000, 500000);?>
			<ul>
				<?php for($i=0; $i<8; $i++){?>
				<li>
					<input type="radio" name="cash" value="<?=$cash[$i]?>" id="cash<?=$i?>"<?php if($i==0) echo ' checked';?>>
					<label for="cash<?=$i?>"><?=number_format($cash[$i])?><font><?=lang('원', 'won')?></font></label>
					<span><?=number_format($cash[$i])?><?=lang('원', 'won')?></span>
				</li>
				<?php }?>
				<li>
					<input type="radio" name="cash" value="self" id="cash">
					<label for="cash"><?=lang('직접입력', 'Self')?></label>
					<input type="number" name="self_pt" value="0"><?=lang('원', 'won')?>
					<font>※ 충전금액은 3,000원 이상 천원 단위로 입력해주세요.</font>
					<span><font id="self">0</font><?=lang('원', 'won')?></span>
				</li>
			</ul>
		</div>

		<div id="od_pay_sl">
			<h3><b>결재방법</b> 선택</h3>
			<?php
			$list = array();
			$multi_settle = 0;
			$checked = '';

			$escrow_title = "";
			if ($default['de_escrow_use']) {
				$escrow_title = "에스크로<br>";
			}

			// 카카오페이
			if($is_kakaopay_use) {
				$multi_settle++;
				$list[] = '<input type="radio" id="od_settle_kakaopay" name="od_settle_case" value="KAKAOPAY" '.$checked.'> <label for="od_settle_kakaopay" class="kakaopay_icon lb_icon">KAKAOPAY</label>'.PHP_EOL;
				$checked = '';
			}

			// 무통장입금 사용

			$multi_settle++;
			$list[] = '<input type="radio" id="od_settle_vbank" name="od_settle_case" value="무통장입금" '.$checked.'> <label for="od_settle_vbank" class="lb_icon vbank_icon">무통장입금</label>'.PHP_EOL;
			$checked = '';


			// 가상계좌 사용
			if ($default['de_vbank_use']) {
				$multi_settle++;
				$list[] = '<input type="radio" id="od_settle_vbank" name="od_settle_case" value="가상계좌" '.$checked.'> <label for="od_settle_vbank" class="lb_icon vbank_icon">'.$escrow_title.'가상계좌</label>'.PHP_EOL;
				$checked = '';
			}

			// 계좌이체 사용
			if ($default['de_iche_use']) {
				$multi_settle++;
				$list[] = '<input type="radio" id="od_settle_iche" name="od_settle_case" value="계좌이체" '.$checked.'> <label for="od_settle_iche" class="lb_icon iche_icon">'.$escrow_title.'계좌이체</label>'.PHP_EOL;
				$checked = '';
			}

			// 휴대폰 사용
			if ($default['de_hp_use']) {
				$multi_settle++;
				$list[] = '<input type="radio" id="od_settle_hp" name="od_settle_case" value="휴대폰" '.$checked.'> <label for="od_settle_hp" class="lb_icon hp_icon">휴대폰</label>'.PHP_EOL;
				$checked = '';
			}

			// 신용카드 사용
			if ($default['de_card_use']) {
				$multi_settle++;
				$list[] = '<input type="radio" id="od_settle_card" name="od_settle_case" value="신용카드" '.$checked.'> <label for="od_settle_card" class="lb_icon card_icon">신용카드</label>'.PHP_EOL;
				$checked = '';
			}

			// PG 간편결제
			if($default['de_easy_pay_use']) {
				switch($default['de_pg_service']) {
					case 'lg':
						$pg_easy_pay_name = 'PAYNOW';
						break;
					case 'inicis':
						$pg_easy_pay_name = 'KPAY';
						break;
					default:
						$pg_easy_pay_name = 'PAYCO';
						break;
				}

				$multi_settle++;
				$list[] = '<input type="radio" id="od_settle_easy_pay" name="od_settle_case" value="간편결제" '.$checked.'> <label for="od_settle_easy_pay" class="'.$pg_easy_pay_name.' lb_icon">'.$pg_easy_pay_name.'</label>'.PHP_EOL;
				$checked = '';
			}

			//이니시스 Lpay
			if($default['de_inicis_lpay_use']) {
				$list[] = '<input type="radio" id="od_settle_inicislpay" data-case="lpay" name="od_settle_case" value="lpay" '.$checked.'> <label for="od_settle_inicislpay" class="inicis_lpay lb_icon">L.pay</label>'.PHP_EOL;
				$checked = '';
			}


			if (count($list) == 0)
				echo '<p>결제할 방법이 없습니다.<br>운영자에게 알려주시면 감사하겠습니다.</p>';
			else {
			?>
			<ul>
				<?php
				for($i = 0; $i<count($list); $i++){
				?>
				<li><?=$list[$i]?></li>
				<?php }?>
			</ul>
			<?php }?>
		</div>

		<div id="agree">
			<p><b>결제 안내</b></p>
			<div>
				<p>결제하실 금액은 <font>3,000</font>원이며 총 <font>3,000</font>코인이 충전됩니다.</p>
				이달의 결제 가능 금액인 500,000원 입니다.<br>
				결제금액기준 1인 월 50만원을 초과 할 수 없습니다.<br>
				결제금액은 부가세가 포함된 가격입니다.<br>
				직접입력시 최소 3,000원에서 최대 500,000원을 입력해주세요.
			</div>
		</div>

		<div class="text-center">
			<p><input type="checkbox" value="1" name="agree_chk" id="agree_chk"><label for="agree_chk">가격, 유의 사항 등을 확인하였으며 구매에 동의합니다.</label></p>
			<button class="btn btn_01"><?=lang('코인충전')?></button>
		</div>
	</form>
</div>

<script>
$('input[name="self_pt"]').keyup(function(){
	var this_val = $(this).val();
	if(this_val > 500000){
		this_val = 500000;
		$(this).val(this_val);
	}
	if($('input[name="cash"][value="self"]:checked').index() >= 0){
		$('font#self, #agree font').text(number_format(this_val));
	} else 
		$('font#self').text(number_format(this_val));
});
$('input[name="cash"]').change(function(){
	if($('input[name="cash"][value="self"]:checked').index() >= 0){
		$('#agree font').text(number_format($('input[name="self_pt"]').val()));
	} else {
		var this_val = $(this).val();
		$('#agree font').text(number_format(this_val));
	}
});
$('form').submit(function(){

	if($('#od_pay_sl input[type="radio"]:checked').index() < 0){
		alert(lang('결재방법을 선택해주세요.'));
		return false;
	} else if($('input[name="cash"][value="self"]:checked').index() >= 0 && $('input[name="self_pt"]').val() < 3000){
		alert(lang('충전금액은 최소 3,000원부터 가능합니다.'));
		$('input[name="self_pt"]').focus();
		return false;
	} else if($('input[name="cash"][value="self"]:checked').index() >= 0 && $('input[name="self_pt"]').val() > 500000){
		alert(lang('충전금액은 최대 500,000원까지 가능합니다.'));
		$('input[name="self_pt"]').focus();
		return false;
	} else if($('input[name="cash"][value="self"]:checked').index() >= 0 && (eval($('input[name="self_pt"]').val()) % 1000) > 0){
		alert(lang('충전은 1,000원 단위로 가능합니다.'));
		$('input[name="self_pt"]').focus();
		return false;
	} else if($('.shop_warp div > p input[type="checkbox"]:checked').index() < 0){
		alert(lang('유의사항에 동의해주세요.'));
		return false;
	} else {
		 var settle_case = document.getElementsByName("od_settle_case");
		var settle_check = false;
		var settle_method = "";
		for (i=0; i<settle_case.length; i++)
		{
			if (settle_case[i].checked)
			{
				settle_check = true;
				settle_method = settle_case[i].value;
				break;
			}
		}

		<?php if($default['de_tax_flag_use']) { ?>
		calculate_tax();
		<?php } ?>

		<?php if($default['de_pg_service'] == 'inicis') { ?>
		if( f.action != form_action_url ){
			f.action = form_action_url;
			f.removeAttribute("target");
			f.removeAttribute("accept-charset");
		}
		<?php } ?>

		// 카카오페이 지불
		if(settle_method == "KAKAOPAY") {
			<?php if($default['de_tax_flag_use']) { ?>
			f.SupplyAmt.value = parseInt(f.comm_tax_mny.value) + parseInt(f.comm_free_mny.value);
			f.GoodsVat.value  = parseInt(f.comm_vat_mny.value);
			<?php } ?>
			getTxnId(f);
			return false;
		}

		var form_order_method = '';

		if( settle_method == "lpay" ){      //이니시스 L.pay 이면 ( 이니시스의 삼성페이는 모바일에서만 단독실행 가능함 )
			form_order_method = 'samsungpay';
		}

		if( jQuery(f).triggerHandler("form_sumbit_order_"+form_order_method) !== false ) {

			// pay_method 설정
			<?php if($default['de_pg_service'] == 'kcp') { ?>
			f.site_cd.value = f.def_site_cd.value;
			f.payco_direct.value = "";
			switch(settle_method)
			{
				case "계좌이체":
					f.pay_method.value   = "010000000000";
					break;
				case "가상계좌":
					f.pay_method.value   = "001000000000";
					break;
				case "휴대폰":
					f.pay_method.value   = "000010000000";
					break;
				case "신용카드":
					f.pay_method.value   = "100000000000";
					break;
				case "간편결제":
					<?php if($default['de_card_test']) { ?>
					f.site_cd.value      = "S6729";
					<?php } ?>
					f.pay_method.value   = "100000000000";
					f.payco_direct.value = "Y";
					break;
				default:
					f.pay_method.value   = "무통장";
					break;
			}
			<?php } else if($default['de_pg_service'] == 'lg') { ?>
			f.LGD_EASYPAY_ONLY.value = "";
			if(typeof f.LGD_CUSTOM_USABLEPAY === "undefined") {
				var input = document.createElement("input");
				input.setAttribute("type", "hidden");
				input.setAttribute("name", "LGD_CUSTOM_USABLEPAY");
				input.setAttribute("value", "");
				f.LGD_EASYPAY_ONLY.parentNode.insertBefore(input, f.LGD_EASYPAY_ONLY);
			}

			switch(settle_method)
			{
				case "계좌이체":
					f.LGD_CUSTOM_FIRSTPAY.value = "SC0030";
					f.LGD_CUSTOM_USABLEPAY.value = "SC0030";
					break;
				case "가상계좌":
					f.LGD_CUSTOM_FIRSTPAY.value = "SC0040";
					f.LGD_CUSTOM_USABLEPAY.value = "SC0040";
					break;
				case "휴대폰":
					f.LGD_CUSTOM_FIRSTPAY.value = "SC0060";
					f.LGD_CUSTOM_USABLEPAY.value = "SC0060";
					break;
				case "신용카드":
					f.LGD_CUSTOM_FIRSTPAY.value = "SC0010";
					f.LGD_CUSTOM_USABLEPAY.value = "SC0010";
					break;
				case "간편결제":
					var elm = f.LGD_CUSTOM_USABLEPAY;
					if(elm.parentNode)
						elm.parentNode.removeChild(elm);
					f.LGD_EASYPAY_ONLY.value = "PAYNOW";
					break;
				default:
					f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
					break;
			}
			<?php }  else if($default['de_pg_service'] == 'inicis') { ?>
			switch(settle_method)
			{
				case "계좌이체":
					f.gopaymethod.value = "DirectBank";
					break;
				case "가상계좌":
					f.gopaymethod.value = "VBank";
					break;
				case "휴대폰":
					f.gopaymethod.value = "HPP";
					break;
				case "신용카드":
					f.gopaymethod.value = "Card";
					f.acceptmethod.value = f.acceptmethod.value.replace(":useescrow", "");
					break;
				case "간편결제":
					f.gopaymethod.value = "Kpay";
					break;
				case "lpay":
					f.gopaymethod.value = "onlylpay";
					f.acceptmethod.value = f.acceptmethod.value+":cardonly";
					break;
				default:
					f.gopaymethod.value = "무통장";
					break;
			}
			<?php } ?>
	}
	}

});
</script>
<?php
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
?>