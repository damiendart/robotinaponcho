setTimeout(function() {
  if (document.readyState != "complete") {
    var loading_text = document.createElement("div");
    loading_text.className = "js-loading";
    loading_text.appendChild(document.createTextNode("Loading images"));
    document.body.appendChild(loading_text);
  }
}, 750);
window.onload = function() {
  if (document.querySelector(".js-loading")) {
    document.querySelector(".js-loading").className += " js-loading--hidden";
  }
  var images = document.querySelectorAll(".image");
  for (var i = 0; i < images.length; i++) {
    images[i].className += " image--js-show";
  }
};
