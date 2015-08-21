// Homepage JavaScript for Damien Dart's personal website.
//
// Copyright (C) 2013-2015 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

$(".panel").each(function(i) {
  if($(this).attr("data-image")) {
    $(this).prepend("<img class=\"panel__js-image\" onLoad=\"this.style.opacity = 1\" src=\"" + 
        $(this).data("image") + "\">");
  } else if($(this).attr("data-code-example")) {
    var panel = $(this);
    $.get($(this).data("code-example"), function(data) {
      line_number = parseInt(panel.data("code-example").split("#")[1]);
      code = data.split("\n").slice(line_number, line_number + 25).join("\n");
      panel.prepend("<pre class=\"panel__js-code tk-source-code-pro\">" + code + "</pre>");
    });
  }
});
