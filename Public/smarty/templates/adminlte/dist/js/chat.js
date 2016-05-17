$( document ).ready(function() {
	$("#contactsBtn").click();
	
	$(".chatItem").on('click', function(event) {
		event.preventDefault();
		var id = $(this).attr("id");
		
		$("#chatFooter").removeClass("hidden");
		$("#contactsBtn").click();
		$("#chatLoading").removeClass("hidden");

		$.ajax({
			data: "chat_id=" + id,
			method: "POST",
			url: "http://app.visvitalis.info/Chat/GetMessages/"
		}).done(function( plain ) {
			$("#chatLoading").addClass("hidden");
			if (plain.valid)
			{
				console.log(plain.message);
				var chatContent = $("#chatContent");
				chatContent.html("");
				
				$.each(plain.data, function(k,v) {
					if (k.sended_by == "Büro") {
						chatContent.append("<div class='direct-chat-msg right'><div class='direct-chat-info clearfix'><span class='direct-chat-name pull-left'>"+v.sended_by+"</span><span class='direct-chat-timestamp pull-right'>"+v.date+"</span></div><img class='direct-chat-img' src='http://app.visvitalis.info/Public/smarty/templates/adminlte/dist/img/ic_launcher.png' alt='message user image'><div class='direct-chat-text'>"+v.message+"</div></div>");
					} else {
						chatContent.append("<div class='direct-chat-msg'><div class='direct-chat-info clearfix'><span class='direct-chat-name pull-left'>"+v.sended_by+"</span><span class='direct-chat-timestamp pull-right'>"+v.date+"</span></div><img class='direct-chat-img' src='http://app.visvitalis.info/Public/smarty/templates/adminlte/dist/img/ic_launcher.png' alt='message user image'><div class='direct-chat-text'>"+v.message+"</div></div>");
					}
				});	
			}
			else
			{
				setMessage(true, "danger", plain.message);
			}
		});
	});
});