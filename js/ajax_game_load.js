$(document).ready(function(){
	var index_of = $(location).attr('pathname'),
		substring = '/game';
	var this_type2 = index_of.indexOf(substring) !== -1 ? '' : 's';
	var this_type = $('.sec_fa nav ul li.select').index();
	$.ajax({
		url:'/ajax/ajax_game_load.php',
		type:'POST',
		data:{'game_type':this_type, 'type':this_type2},
		success:function(data){
			$('.sec_fa > section > div > div').html(data);
		}
	});
});