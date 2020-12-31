m.printChatMessage = function(type,sender,message,time) {
	var user = m.userTag(sender,false);
	var message = m.decodeMessage(message,true);

	var content = '<div>';
	content += '<div><a href="#1" class="username"></a></div>';
	content += '<p>'+message;
	content += '</p>';
	content += '</div>';
	
	if (sender.nickname != m.myinfo.nickname)
		var item = $("<div>").addClass("balloon").html(content);
	else 
		var item = $("<div>").addClass("balloon my_chat").html(content);

	$(".chatArea").append(item);
	$(item.find(".username")).append(user);
	
	if (sender.info !== undefined && sender.info.photo !== undefined) {
		$(item).append($("<img>").attr("src",sender.info.photo).css("width","30").css("height","30"));
	} else
		$(item).append($("<img>").attr("src", '/img/no_profile.gif').css("width","30").css("height","30"));
	
	m.autoScroll();
}

m.printWhisperMessage = function(type,sender,to,message,time) {
	var message = m.decodeMessage(message,true);
	var user1 = m.userTag(sender,false);

	if (sender.nickname != m.myinfo.nickname) {
		var user = m.userTag(sender,false);
		var content = '<div>';
		content += '<div><a href="#1" class="username"></a></div>';
		content += '<p>'+LANG.whisper.from.replace("{nickname}",'<span class="whisperTag"></span>')+'<br />'+message;
		content += '</p>';
		content += '</div>';

		var item = $("<div>").addClass("balloon").html(content);
	} else {
		var user = m.userTag(to,false);
		var content = '<div>';
		content += '<div><a href="#1" class="username"></a></div>';
		content += '<p>'+LANG.whisper.to.replace("{nickname}",'<span class="whisperTag"></span>')+'<br />'+message;
		content += '</p>';
		content += '</div>';

		var item = $("<div>").addClass("balloon my_chat").html(content);
	}
	
	$(".chatArea").append(item);
	$(item.find(".whisperTag")).append(user);
	$(item.find(".username")).append(user1);
	
	if (sender.info !== undefined && sender.info.photo !== undefined) {
		$(item).append($("<img>").attr("src",sender.info.photo).css("width","30").css("height","30"));
	} else
		$(item).append($("<img>").attr("src", '/img/no_profile.gif').css("width","30").css("height","30"));
	
	m.autoScroll();
}