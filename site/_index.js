var spinner = new Spinner({className: "js-spinner", color: "#ccc", corners: 1,
    hwaccel: true, length: 0, lines: 12,radius: 15, width: 5}).spin();
document.getElementsByTagName("body").item(0).appendChild(spinner.el);
if (window.devicePixelRatio > 1) {
  $(".site-image").attr("src", "assets/site-header@2x.png");
}

$(window).load(function() {
  $(".spinner").addClass("js-fade-out");
  setTimeout(function() {
    spinner.stop();
    $(".site-image").show().addClass("js-fade-in-from-top");
    setTimeout(function() {
      $(".site-header").show().addClass("js-fade-in-from-bottom");
      setTimeout(function() {
        $(".site-navigation").show().addClass("js-fade-in-from-bottom");
      }, (window.innerWidth < 767) ? 250 : 0);
    }, (window.innerWidth < 767) ? 250 : 0);
  }, 500);
  setTimeout(function() {
    $(".site-image, .site-header, .site-navigation").addClass(
        "js-no-animation");
  }, 1500);
});
