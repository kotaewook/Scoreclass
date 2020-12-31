function unregi(){
	if(confirm(lang('정말 회원 탈퇴하시겠습니까?\n탈퇴 후 정보는 복구가 불가능합니다.', 'Are you sure you want to leave the membership?\nAfter exit, information is not recoverable.', '本当に会員を脱退しますか。\n脱退後の情報は復旧できません。', '确定要退出会员吗?\n退出后,信息无法修复。'))){
		alert(lang('테스트 버전에선 탈퇴가 불가능합니다.'));
	}
}


$(document).ready(function(){
	var mb_height = 0;

	for(var i = 0; i < $('.gnb_2dul').length; i++)
		mb_height = $('.gnb_2dul').eq(i).height() + 5 > mb_height ? $('.gnb_2dul').eq(i).height() + 5 : mb_height;

	$('.menu_back, .menu_back1').height(mb_height);

	$('#gnb').hover(function(){
		$('.menu_back, .menu_back1').addClass('open');
		$('#gnb .gnb_2dul').addClass('open');
	}, function(){
		$('.menu_back, .menu_back1').removeClass('open');
		$('#gnb .gnb_2dul').removeClass('open');
	});
	$('#favorite').on('click', function(e) {
		var bookmarkURL = window.location.href;
		var bookmarkTitle = document.title; 
		var triggerDefault = false; 

		if (window.sidebar && window.sidebar.addPanel) { 
			// Firefox version < 23
			window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
		} else if ((window.sidebar && (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)) || (window.opera && window.print)) {
			// Firefox version >= 23 and Opera Hotlist 
			var $this = $(this);
			$this.attr('href', bookmarkURL); 
			$this.attr('title', bookmarkTitle); 
			$this.attr('rel', 'sidebar'); 
			$this.off(e); triggerDefault = true;
		} else if (window.external && ('AddFavorite' in window.external)) {
			// IE Favorite 
			window.external.AddFavorite(bookmarkURL, bookmarkTitle);
		} else {
			// WebKit - Safari/Chrome 
			alert((navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다.'); 
		}
		
		return triggerDefault; 
	});

	$('.live_ranking .tab_tit1 li').click(function(){
		var this_index = $(this).index();
		$('.live_ranking .tab_tit1 li, .live_ranking .tab_tit2, .live_ranking > div').removeClass('on');
		$(this).addClass('on');
		$('.live_ranking .tab_tit2[data-index="' + this_index + '"]').addClass('on');
		$('.live_ranking > div[data-index="' + this_index + '"]').addClass('on');
	});
	$('.live_ranking .tab_tit2 li').click(function(){
		var lg_type = $(this).parent().attr('data-index');
		var this_index = $(this).index();
		var lg_id = $(this).attr('data-lg');

		$('.live_ranking .tab_tit2[data-index="' + lg_type + '"] li').removeClass('on');
		$('.live_ranking > div[data-index="' + lg_type + '"] > table').removeClass('on');
		$(this).addClass('on');

		if($('.live_ranking > div[data-index="' + lg_type + '"] > table[data-index="' + this_index + '"]').index() * 1 >= 0)
			$('.live_ranking > div[data-index="' + lg_type + '"] > table[data-index="' + this_index + '"]').addClass('on');
		else {
			$.ajax({
				url:'/user/bbs/main_league_ajax.php',
				type:'POST',
				data:{'lg_type':lg_type, 'index':this_index, 'lg_id':lg_id},
				success:function(data){
					$('.live_ranking > div[data-index="' + lg_type + '"]').append(data);
				}
			});
		}
	});
	$('.talk_fav').click(function(){
		var this_index = $(this).attr('data-index') * 1;
		$.ajax({
			url:'/user/bbs/chat_fav.php',
			type:'POST',
			data:{'ch_id':this_index},
			dataType:'json',
			success:function(data){
				if(data == 1){
					alert(lang('즐겨찾기가 해제되었습니다.'));
					$('.talk_fav > span').text(lang('즐겨찾기', 'Bookmark'));
				} else {
					alert(lang('즐겨찾기에 등록되었습니다.'));
					$('.talk_fav > span').text(lang('즐겨찾기 해제', 'Bookmark'));
				}
			}
		});
	});

	$(".bt_view").click(function() {
        bt_view(this.href);
        return false;
    });

	$('.live_bat_list').css('transform', 'translateY(5px)');
});

function trade_buy(td_id){
	if(confirm(lang('해당 배팅 내역을 구매하시겠습니까?'))){
		$.ajax({
			url:'/trade/bbs/buy_ok.php',
			type:'POST',
			data:{'td_id':td_id},
			dataType:'json',
			success:function(data){
				if(data == 'success'){
					alert(lang('배팅 내역 구매가 완료 되었습니다.'));
					location.href = '/exchange/buy_list';
				} else if(data == 'money'){
					alert(lang('보유 GP가 부족합니다.'));
				} else
					alert(lang('시스템 오류로 구매가 실패하였습니다.\n잠시 후 다시 시도해주세요.'));
			}
		});
	}
}

function trade_cancel(td_id, bt_id){
	if(confirm(lang('해당 판매 내역을 취소 하시겠습니까?'))){
		$.ajax({
			url:'/trade/bbs/sale_ok.php',
			type:'POST',
			data:{'w':'d', 'td_id':td_id, 'bt_id':bt_id},
			dataType:'json',
			success:function(data){
				if(data == 'success'){
					alert(lang('배팅 내역 판매가 취소 되었습니다.'));
					location.reload();
				} else
					alert(lang('시스템 오류로 판매취소가 실패하였습니다.\n잠시 후 다시 시도해주세요.'));
			}
		});
		
	}
}

function trade_sale(bt_id, title, rate, result){ // 거래소 판매 등록
	var content = '<p style="color:#444; font-size:17px; font-weight:bold; line-height:1.2; letter-spacing:-0.5px;">' + title + '</p>';
	content += '<p style="color:#15a9ff; padding:20px 0; font-size:12px; font-weight:normal; font-family:dotum;"><span style="padding-right:10px;">' + lang('배당률 : ') + rate + '</span>' + lang('예상당첨금액 : ') + result + 'GP</p>';
	content += '<form action="/trade/bbs/sale_ok.php" method="post">';
	content += '<input type="hidden" name="bt_id" value="' + bt_id + '">';
	content += '<label for="sale_pt" style="font-size:15px">' + lang('판매가격') + '</label>';
	content += '<input type="number" name="sale_pt" id="sale_pt" value="0" style="text-align:right; height:30px; border:1px solid  #d1d1d1; padding:0 10px; margin:0 5px 0 10px; font-family:dotum;" required><font style="font-size:15px; line-height:30px; display:inline-block; vertical-align:top;">GP</font>';
	content += '</form>';
	sc_alert(content, lang('판매하기'));

	$('.sc_alert_warp > div > div > span').click(function(){
		if($.trim($(".sc_alert_warp form #sale_pt").val()) == ''){
			alert(lang('판매금액을 입력해주세요'));
			$('.sc_alert_warp').addClass('show');
			$(".sc_alert_warp form #sale_pt").focus();
		} else if($(".sc_alert_warp form #sale_pt").val() <= 0){
			alert(lang('판매금액은 0보다 작을 수 없습니다.'));
			$('.sc_alert_warp').addClass('show');
			$(".sc_alert_warp form #sale_pt").focus();
		} else 
			$('.sc_alert_warp form').submit();
	});
}

function sc_alert(html, btn_name){ // 디자인된 알림창
	var content = '<div class="sc_alert_warp show">';
	content += '<div>';
		content += '<div>';
		content += '<div>' + html + '</div>';
		content += '<span>' + btn_name + '</span>';
		content += '<b class="xi xi-close"></b>';
		content += '</div>';
	content += '</div>';
	content += '</div>';
	$('body').append(content);

	$('.sc_alert_warp > div > div > span').click(function(){
		$('.sc_alert_warp').removeClass('show');
	});

	$('.sc_alert_warp > div > div > b').click(function(){
		$('.sc_alert_warp').remove();
	});
}

/**
 * 배팅 보기 창
 **/
var bt_view = function(href) {
    var bt_view = window.open(href, 'bt_view', 'left=100,top=100,width=1000,height=500,scrollbars=1');
    bt_view.focus();
}