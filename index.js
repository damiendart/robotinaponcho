var images = document.querySelectorAll("[data-code-example]");
for (var i = 0; i < images.length; i++) {
  (function() {
    var request = new XMLHttpRequest();
    request.open("GET", images[i].getAttribute("data-code-example"), true);
    request.onreadystatechange = function(el) {
      return function() {
        if (request.readyState === XMLHttpRequest.DONE) {
          var code_html = document.createElement("pre");
          code_html.className = "js-code-example";
          var line_number = parseInt(
              el.getAttribute("data-code-example").split("#")[1]);
          code_html.innerHTML = this.responseText.split(
              "\n").slice(line_number, line_number + 25).join("\n");
          el.insertBefore(code_html, el.firstChild);
        }
      }
    }(images[i]);
    request.send()
  })();
}