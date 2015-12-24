// Homepage JavaScript for Damien Dart's personal website.
//
// Copyright (C) 2013-2015 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

var panels = document.querySelectorAll(".panel");
for (var i = 0; i < panels.length; i++) {
  (function() {
    if (panels[i].hasAttribute("data-code-example")) {
      var request = new XMLHttpRequest();
      request.open("GET", panels[i].getAttribute("data-code-example"), true);
      request.onreadystatechange = function(el) {
        return function() {
          if (request.readyState === XMLHttpRequest.DONE) {
            var code_html = document.createElement("pre");
            code_html.className = "panel__js-code tk-source-code-pro";
            var line_number = parseInt(
                el.getAttribute("data-code-example").split("#")[1]);
            code_html.innerHTML = this.responseText.split(
                "\n").slice(line_number, line_number + 25).join("\n");
            el.insertBefore(code_html, el.firstChild);
          }
        }
      }(panels[i]);
      request.send()
    }
  })();
}
