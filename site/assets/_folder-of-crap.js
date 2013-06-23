$(".content").addClass("tk-proxima-nova");
$(".content__header").addClass("tk-league-gothic");
$("td:nth-child(2)").each(function() {
  $(this).text(moment($.trim($(this).text()), "DD-MMM-YYYY HH:mm").fromNow());
});

var header = $(".content__header").text().split("");
var in_word = true;
var new_inner_html = "";
var previous_character = "";
$(header).each(function(i, item) {
  if (item != ' ') {
    if (!in_word) {
      new_inner_html += "<span class=\"tk-league-gothic__js-word\">"
    }
    in_word = true;
    new_inner_html += "<span class=\"tk-league-gothic__js-char " +
        "tk-league-gothic__js-char--" + (i + 1)
        + "\">" + item + "</span>";
  } else {
    if (in_word) {
      new_inner_html += "</span>";
      in_word = false;
    }
    new_inner_html += item;
  }
});
$(".content__header").empty().append(new_inner_html);
