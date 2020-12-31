var fix_num = 0;
function check_time(){
	setInterval(function(){
		var now_time = new Date().getTime();
		now_time = String(now_time).substring(0, 10) * 1;
		now_time += 300;

		var chk_len = $('.bat_list ul li[data-time="' + now_time + '"]').length;

		$('.fa_sc_list[data-time="' + now_time + '"]').remove();
		$('.bat_list ul li[data-time="' + now_time + '"]').remove();

		$('.bat_tit font').text($('.bat_list ul li').length);

		if(chk_len > 0){
			var rating = 0;
			for(var i = 0; i < $('.bat_list ul li').length; i++){
				var rate = $('.bat_list ul li:eq(' + i + ') .rate').text() * 1;

				if(i == 0)
					rating = rate;
				else {
					if(rate < 1) rate += 1;
					rating = rating * rate;
				}
			}
			rating = rating != 0 ? rating.toFixed(1) : rating;

			if(rating > 300)
				rating = 300;

			if($('.total_rate').text() * 1 != rating){
				$('.bat_form_box .total_rate').text(rating);
				$.ajax({
					url:'/user/bbs/bet_calculation.php',
					type:'POST',
					data:{'point':$('.bat_input').val().replace(/[^0-9]/g,""), 'rate':rating},
					dataType:'json',
					success:function(data){
						$('.bat_form_box .total_pt').text(data);
					}
				});
			}
		}
	}, 1000);
}
$(document).ready(function(){
	check_time();
	fix_num = $('.fa_bet_box').offset().top * 1;
	$('.bat_input').keyup(function(){
		var value = $(this).val();
		value = value.replace(/[^0-9]/g,"");
		$(this).val(number_format(value));
		$('.bat_form_box .set_pt').text(number_format(value));
		$.ajax({
			url:'/user/bbs/bet_calculation.php',
			type:'POST',
			data:{'point':value, 'rate':$('.bat_form_box .total_rate').text()},
			dataType:'json',
			success:function(data){
				$('.bat_form_box .total_pt').text(data);
			}
		});
	});
	$('.bat_pt_btn li button').click(function(){
		if($(this).attr('data-type') == 'max')
			var value = $(this).attr('value') * 1;
		else if($(this).attr('value') * 1 == 0)
			var value = 0;
		else
			var value = ($('.bat_input').val().replace(/[^0-9]/g,"") * 1) + ($(this).attr('value') * 1);
		$('.bat_input').val(number_format(value));
		$('.bat_form_box .set_pt').text(number_format(value));
		$.ajax({
			url:'/user/bbs/bet_calculation.php',
			type:'POST',
			data:{'point':value, 'rate':$('.bat_form_box .total_rate').text()},
			dataType:'json',
			success:function(data){
				$('.bat_form_box .total_pt').text(data);
			}
		});
	});
	$('.bat_remove').click(function(){
		$('.bat_list ul li').remove();

		var rating = 0;
		for(var i = 0; i < $('.bat_list ul li').length; i++){
			var rate = $('.bat_list ul li:eq(' + i + ') .rate').text() * 1;

			if(i == 0)
				rating = rate;
			else {
				if(rate < 1) rate += 1;
				rating = rating * rate;
			}
		}

		rating = rating != 0 ? rating.toFixed(2) : rating;
		
		$('.fa_sc_list > table > tbody > tr').removeClass('select').attr('data-index', '');
		$('.fa_sc_list > table > tbody > tr > td.chk').removeClass('bat_on').addClass('select_game');
		$('.bat_form_box .total_rate').text(rating);
		$.ajax({
			url:'/user/bbs/bet_calculation.php',
			type:'POST',
			data:{'point':$('.bat_input').val().replace(/[^0-9]/g,""), 'rate':rating},
			dataType:'json',
			success:function(data){
				$('.bat_form_box .total_pt').text(data);
			}
		});
	});
	
	$('td.chk').click(function(){
		var bt_id = $(this).parent().attr('data-bet') * 1;
		var game_id = $(this).parent().attr('data-game') * 1;
		var this_line = $(this).parent().attr('data-line');
		var this_time = $(this).parent().attr('data-time') * 1;

		if($(this).parent().attr('data-index')*1 >= 0 && $(this).hasClass('bat_on')){
			var index = $(this).parent().attr('data-index')*1;
			$(this).parent().removeClass('select').attr('data-index', '');
			$(this).removeClass('bat_on');
			$(this).parent().children('.chk').addClass('select_game');

			$('.bat_list ul li[data-index="' + index + '"]').remove();
		} else if($(this).hasClass('select_game')){
			var index = $('.bat_list ul li').last().index() * 1 + 1;

			if($('.bat_list ul li[data-game="' + game_id + '"][data-bet="' + this_line + '"]').index() >= 0){
				$('.fa_sc_list > table > tbody > tr[data-game="' + game_id + '"][data-line="' + this_line + '"] .bat_on').removeClass('bat_on');
				$(this).addClass('bat_on');

				$('.bat_list ul li[data-game="' + game_id + '"][data-bet="' + this_line + '"]').remove();
			} else {
				$(this).addClass('bat_on');
				$(this).parent().addClass('select').attr('data-index', index);
			}

			var game_type = $(this).parent().find('#game_type').text();
			var game_title = $(this).parent().parent().find('tr[data-line="' + this_line + '"]:eq(0)').children('.game_title').find('table td.title').text();
			var select_team = $(this).parent().children('.bat_on').find('.team_name').text();
			var select_rate = $(this).parent().children('.bat_on').find('.di_rate').text();

			var content = '';
			content += '<li data-index="' + index + '" data-game="' + game_id + '" data-bet="' + this_line + '" data-time="' + this_time + '">';
			content += '<span class="bat_close"><i class="xi xi-close"></i></span>';
			content += '<input type="hidden" name="bet_id[]" value="' + bt_id + '">';
			content += '<input type="hidden" name="bet_type[]" value="' + $(this).attr('data-type') + '">';
			content += '<div>[' + game_type + '] ' + game_title + '</div>';
			content += '<div>' + select_team + '<span class="rate">' + select_rate + '</span></div>';
			content += '</li>';

			$('.bat_list ul').append(content);
			$('.bat_list').scrollTop($('.bat_list ul').height());

			$('.bat_close').unbind('click').bind('click', function(){
				var bt_id = $(this).parent().attr('data-bet') * 1;
				var game_id = $(this).parent().attr('data-game') * 1;
				var this_line = $(this).parent().attr('data-bet') * 1;

				$('.fa_sc_list > table > tbody > tr[data-game="' + game_id + '"][data-line="' + this_line + '"] .bat_on').removeClass('bat_on');

				$('.bat_list ul li[data-game="' + game_id + '"][data-bet="' + this_line + '"]').remove();
			});
		}

		var rating = 0;
		for(var i = 0; i < $('.bat_list ul li').length; i++){
			var rate = $('.bat_list ul li:eq(' + i + ') .rate').text() * 1;

			if(i == 0)
				rating = rate;
			else {
				if(rate < 1) rate += 1;
				rating = rating * rate;
			}
		}

		rating = rating != 0 ? rating.toFixed(2) : rating;

		$('.bat_form_box .total_rate').text(rating);
		$.ajax({
			url:'/user/bbs/bet_calculation.php',
			type:'POST',
			data:{'point':$('.bat_input').val().replace(/[^0-9]/g,""), 'rate':rating},
			dataType:'json',
			success:function(data){
				$('.bat_form_box .total_pt').text(data);
			}
		});
	});
	$('td.more_btn').click(function(){
		var this_index = $(this).parent().attr('data-line');

		$('.fa_sc_list > table > tbody > tr[data-line="' + this_index + '"]').toggleClass('view');
	});
	$('.bat_tit > span').click(function(){
		if($(this).hasClass('close')){
			$(this).addClass('open').removeClass('close');
			$('.fa_bet_box').addClass('down');
			$('.fa_bet_box .fa-angle-down').addClass('fa-angle-up').removeClass('fa-angle-down');
			$(this).children('b').text(lang('열기', 'Open'));
		} else {
			$(this).addClass('close').removeClass('open');
			$('.fa_bet_box').removeClass('down');
			$('.fa_bet_box .fa-angle-up').addClass('fa-angle-down').removeClass('fa-angle-up');
			$(this).children('b').text(lang('닫기', 'Close'));
		}
	});
});

$(document).ajaxSuccess(function(){
	$('.bat_input').unbind('keyup').bind('keyup', function(){
		var value = $(this).val();
		value = value.replace(/[^0-9]/g,"");
		if(value > 2000000000)
			value = 2000000000;
		$(this).val(number_format(value));
		$('.bat_form_box .set_pt').text(number_format(value));
		$.ajax({
			url:'/user/bbs/bet_calculation.php',
			type:'POST',
			data:{'point':value, 'rate':$('.bat_form_box .total_rate').text()},
			dataType:'json',
			success:function(data){
				$('.bat_form_box .total_pt').text(data);
			}
		});
	});
	$('.bat_pt_btn li button').unbind('click').bind('click', function(){
		if($(this).attr('data-type') == 'max')
			var value = $(this).attr('value') * 1;
		else if($(this).attr('value') * 1 == 0)
			var value = 0;
		else
			var value = ($('.bat_input').val().replace(/[^0-9]/g,"") * 1) + ($(this).attr('value') * 1);

		if(value > 2000000000)
			value = 2000000000;

		$('.bat_input').val(number_format(value));
		$('.bat_form_box .set_pt').text(number_format(value));
		$.ajax({
			url:'/user/bbs/bet_calculation.php',
			type:'POST',
			data:{'point':value, 'rate':$('.bat_form_box .total_rate').text()},
			dataType:'json',
			success:function(data){
				$('.bat_form_box .total_pt').text(data);
			}
		});
	});
	$('.bat_remove').unbind('click').bind('click', function(){
		$('.bat_list ul li').remove();

		var rating = 0;
		for(var i = 0; i < $('.bat_list ul li').length; i++){
			var rate = $('.bat_list ul li:eq(' + i + ') .rate').text() * 1;

			if(i == 0)
				rating = rate;
			else {
				if(rate < 1) rate += 1;
				rating = rating * rate;
			}
		}

		$('.bat_tit font').text($('.bat_list ul li').length);

		rating = rating != 0 ? rating.toFixed(2) : rating;

		if(rating > 300)
			rating = 300;
		
		$('.fa_sc_list > table > tbody > tr').removeClass('select').attr('data-index', '');
		$('.fa_sc_list > table > tbody > tr > td.chk').removeClass('bat_on').addClass('select_game');
		$('.bat_form_box .total_rate').text(rating);
		$.ajax({
			url:'/user/bbs/bet_calculation.php',
			type:'POST',
			data:{'point':$('.bat_form_box .set_pt').text().replace(/[^0-9]/g,""), 'rate':rating},
			dataType:'json',
			success:function(data){
				$('.bat_form_box .total_pt').text(data);
			}
		});
	});
	
	$('td.chk').unbind('click').bind('click', function(){
		if($('.bat_list ul li').length >= 10 && !$(this).hasClass('bat_on')){
			alert(lang('베팅 폴더는 최대 10개까지 선택 가능합니다.'));
		} else {
			var bt_id = $(this).parent().attr('data-bet') * 1;
			var game_id = $(this).parent().attr('data-game') * 1;
			var this_line = $(this).parent().attr('data-line');
			var this_time = $(this).parent().attr('data-time') * 1;

			if($(this).parent().attr('data-index')*1 >= 0 && $(this).hasClass('bat_on')){
				var index = $(this).parent().attr('data-index')*1;
				$(this).parent().removeClass('select').attr('data-index', '');
				$(this).removeClass('bat_on');
				$(this).parent().children('.chk').addClass('select_game');

				$('.bat_list ul li[data-index="' + index + '"]').remove();
			} else if($(this).hasClass('select_game')){
				var index = $('.bat_list ul li').last().index() * 1 + 1;

				if($('.bat_list ul li[data-game="' + game_id + '"][data-bet="' + this_line + '"]').index() >= 0){
					$('.fa_sc_list > table > tbody > tr[data-game="' + game_id + '"][data-line="' + this_line + '"] .bat_on').removeClass('bat_on');
					$(this).addClass('bat_on');

					$('.bat_list ul li[data-game="' + game_id + '"][data-bet="' + this_line + '"]').remove();
				} else {
					$(this).addClass('bat_on');
					$(this).parent().addClass('select').attr('data-index', index);
				}

				var game_type = $(this).parent().find('#game_type').text();
				var game_title = $(this).parent().parent().find('tr[data-line="' + this_line + '"]:eq(0)').children('.game_title').find('table td.title').text();
				var select_team = $(this).parent().children('.bat_on').find('.team_name').text();
				var select_rate = $(this).parent().children('.bat_on').find('.di_rate').text();

				var content = '';
				content += '<li data-index="' + index + '" data-game="' + game_id + '" data-bet="' + this_line + '" data-time="' + this_time + '">';
				content += '<span class="bat_close"><i class="xi xi-close"></i></span>';
				content += '<input type="hidden" name="bet_id[]" value="' + bt_id + '">';
				content += '<input type="hidden" name="bet_type[]" value="' + $(this).attr('data-type') + '">';
				content += '<div>[' + game_type + '] ' + game_title + '</div>';
				content += '<div>' + select_team + '<span class="rate">' + select_rate + '</span></div>';
				content += '</li>';

				$('.bat_list ul').append(content);
				$('.bat_list').scrollTop($('.bat_list ul').height());

				$('.bat_close').unbind('click').bind('click', function(){
					var bt_id = $(this).parent().attr('data-bet') * 1;
					var game_id = $(this).parent().attr('data-game') * 1;
					var this_line = $(this).parent().attr('data-bet') * 1;

					$('.fa_sc_list > table > tbody > tr[data-game="' + game_id + '"][data-line="' + this_line + '"] .bat_on').removeClass('bat_on');

					$('.bat_list ul li[data-game="' + game_id + '"][data-bet="' + this_line + '"]').remove();
				});
			}

			var rating = 0;
			for(var i = 0; i < $('.bat_list ul li').length; i++){
				var rate = $('.bat_list ul li:eq(' + i + ') .rate').text() * 1;

				if(i == 0)
					rating = rate;
				else {
					if(rate < 1) rate += 1;
					rating = rating * rate;
				}
			}

			$('.bat_tit font').text($('.bat_list ul li').length);

			rating = rating != 0 ? rating.toFixed(2) : rating;

			if(rating > 300)
				rating = 300;

			$('.bat_form_box .total_rate').text(rating);
			$.ajax({
				url:'/user/bbs/bet_calculation.php',
				type:'POST',
				data:{'point':$('.bat_form_box .set_pt').text().replace(/[^0-9]/g,""), 'rate':rating},
				dataType:'json',
				success:function(data){
					$('.bat_form_box .total_pt').text(data);
				}
			});
		}
	});
	$('td.more_btn').unbind('click').bind('click', function(){
		var this_index = $(this).parent().attr('data-line');
		var this_text = $(this).attr('data-text');

		$('.fa_sc_list > table > tbody > tr[data-line="' + this_index + '"]').toggleClass('view');
		$(this).attr('data-text', $(this).children('span').children('div').children('div').text());
		$(this).children('span').children('div').children('div').text(this_text);
	});
	$('.bat_tit > span').unbind('click').bind('click', function(){
		if($(this).hasClass('close')){
			$(this).addClass('open').removeClass('close');
			$('.fa_bet_box').addClass('down');
			$('.fa_bet_box .fa-angle-down').addClass('fa-angle-up').removeClass('fa-angle-down');
			$(this).children('b').text(lang('열기', 'Open'));
		} else {
			$(this).addClass('close').removeClass('open');
			$('.fa_bet_box').removeClass('down');
			$('.fa_bet_box .fa-angle-up').addClass('fa-angle-down').removeClass('fa-angle-up');
			$(this).children('b').text(lang('닫기', 'Close'));
		}
	});
});

$(window).scroll(function(){
	var this_top = $(this).scrollTop();

	if(this_top >= fix_num - 20)
		$('.fa_bet_box').addClass('fix');
	else
		$('.fa_bet_box').removeClass('fix');
});