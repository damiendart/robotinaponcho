var spinner = new Spinner().spin();
document.getElementsByTagName("body").item(0).appendChild(spinner.el);
$(window).load(function() {
  $(".spinner").addClass("animated fadeOut");
  setTimeout(function() { 
    spinner.stop(); 
    $(".site-image").show().addClass("animated fadeInDown");
    $(".site-header").show().addClass("animated fadeInUp");
    $(".site-navigation").show().addClass("animated fadeInUp");
  }, 1000);
});