$(document).ready(function(){
	const socket = io("http://test.nk-processing.com:3909");
	$('form#openchat').submit(function(){
		if($.trim($("form#openchat input").val()) != '' && $("form#openchat input").is(':disabled') == false){
			$.ajax({
				url:'/openchat',
				type:'POST',
				data:{'content':$("form#openchat input").val()},
				dataType:'json',
				success:function(data){
					if(data == 'fail')
						alert(lang('로그인 후 이용해주세요.'));
					else if(data == 'send_fail')
						alert(lang('메세지 전송에 실패했습니다.'));
					else {
						socket.emit("open chat", data);
						$("form#openchat input").val('');
					}
				}, error:function(a,b,c){
					alert(c);
				}
			});
		}
		return false;
	});
	socket.on("open chat", (msg) => {
		var country = $('.btn_lang > li > span').attr('id');
		if(msg.country == country){
			var content = msg.img;
			content += '<div><a href="#1">' + msg.writer + '</a></div>';
			content += '<p>' + msg.msg + '</p>';
			content  = $('<div>').html(content);
			$(".main_chat_box > ul").append($("<li" + ($('.my_info_detail li strong#my_name').text() == msg.writer ? ' class="my_chat"' : '') + ">").html(content));
			$('.main_chat_box').scrollTop($(".main_chat_box > ul").height());
		}
	});
});