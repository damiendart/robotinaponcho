// Homepage JavaScript for Damien Dart's personal website.
//
// Copyright (C) 2013-2015 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

function easterEgg() {
if (window.location.hash == "#iloveyou") {
  var links = document.getElementsByTagName("a");
  for (var i = 0; i < links.length; i++) {
    links[i].onmouseover = function() {
      this.style.fontFamily = "\"Comic Sans MS\", \"Comic Sans\"";
      this.style.lineHeight = "1";
}; } } }
window.onhashchange = easterEgg;
easterEgg();
