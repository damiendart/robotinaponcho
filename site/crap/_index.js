$("td:nth-child(2)").each(function() {
  $(this).text(moment($.trim($(this).text()), "DD-MMM-YYYY HH:mm").fromNow());
});