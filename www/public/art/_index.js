setTimeout(function() {
  if (document.readyState != "complete") {
    var loading = document.createElement("div");
    loading.className = "js-loading";
    for (var i = 0; i < 3; i++) {
      loading.insertBefore(document.createElement("div"), loading.firstChild);
    }
    document.body.appendChild(loading);
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
