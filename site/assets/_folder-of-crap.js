$(".content").addClass("tk-proxima-nova");
$(".content__header").addClass("tk-league-gothic");
$("td:nth-child(2)").each(function() {
  $(this).text(moment($.trim($(this).text()), "DD-MMM-YYYY HH:mm").fromNow());
});
