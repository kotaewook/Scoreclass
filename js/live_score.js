function wish_set(){
	$('td.up > span').unbind('click').bind('click', function(){
		var this_num = $(this).parent().parent().attr('data-num');
		if($(this).hasClass('up')){
			$(this).parent().parent().parent().children('tr').addClass('up');
			$('table.wish').append('<tbody>'+$(this).parent().parent().parent().html()+'</tbody>');
			$('table.wish tbody tr[data-num="' + this_num + '"]').removeClass('up');
			$('table.wish tbody tr[data-num="' + this_num + '"] td.up > span').removeClass('up').addClass('down');
			$('table.wish').addClass('view');
			$.ajax({
				url:'/betting/bbs/live_wish.php',
				type:'POST',
				data:{'type':'up', 'idx':this_num},
				success:function(data){
				}
			});
			
			wish_set();
		} else if($(this).hasClass('down')){
			$(this).parent().parent().parent().remove();
			$('table.live tr[data-num="' + this_num + '"]').removeClass('up');

			if($('table.wish tbody tr').length == 0)
				$('table.wish').removeClass('view');

			$.ajax({
				url:'/betting/bbs/live_wish.php',
				type:'POST',
				data:{'type':'down', 'idx':this_num},
				success:function(data){
				}
			});
		}
	});
}
$(document).ready(function(){
	wish_set();

	$('table.wish th span.total').click(function(){
		$('table.wish tbody tr').remove();
		$('table.live tr').removeClass('up');
		$('table.wish').removeClass('view');
		$.ajax({
			url:'/betting/bbs/live_wish.php',
			type:'POST',
			data:{'type':'total'},
			success:function(data){
			}
		});
	});
});