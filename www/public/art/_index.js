window.onload = function() {
  var images = document.querySelectorAll(".image");
  for (var i = 0; i < images.length; i++) {
    images[i].className += " image--js-show";
  }
};
