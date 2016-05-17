$(document).ready(function() {
  var count = 0;

  var ajax_call = function() {
    $.ajax({
      method: "POST",
      url: "http://app.visvitalis.info/api/messages/unread"
    }).done(function(plain) {
      if (plain.valid) {
        count = plain.count;
        var messageObj = $("li .dropdown .messages-menu");

        if (count === 0)
          $("#messageList").addClass("hidden");
        else
        {
          $("#messageCountLabel").html(count);
          $("#messageList").removeClass("hidden");
        }

        $("#messageCountText").html("You have " + count + " unread ticket(s)");

        $("#messageList ul").empty();
        for (var i = 0; i < count; i++) {
          $("#messageList ul").append("<li><a href=\"/TicketChat/get/" + plain.data[i].TicketId + "\"><div class=\"pull-left\"><img src=\"http://app.visvitalis.info/Public/smarty/templates/adminlte/dist/img/user2-160x160.jpg\" class=\"img-circle\" alt=\"User Image\" /></div><h4>"+ plain.data[i].title +"<small><i class=\"fa fa-clock-o\"></i> "+jQuery.timeago(plain.data[i].timestamp)+" </small>  </h4><p>"+ plain.data[i].message.substring(0, 20)+"... </p></a></li>");
        };
      }
    });
  };

  var reverseTitle = false;
  var titleToReverse = document.title;

  var title_call = function() {
    if (!reverseTitle) {
      document.title = 'You have ' + count + ' unread message(s).';
      reverseTitle = true;
    } else {
      document.title = titleToReverse;
      reverseTitle = false;
    }
  };

  // check on site call
  ajax_call();

  // every 5 minutes check for new messages
  setInterval(ajax_call, 1000 * 60 * 5);
  // if there are new messages show title
  if (count > 0) {
    setInterval(title_call, 2500);
  }
});
