import './.modules/clipboard.mjs';

function updatePrettyDates() {
  document.querySelectorAll("[data-timestamp]").forEach(function(el) {
    var time_since = Math.floor((new Date().getTime() / 1000) -
        parseInt(el.getAttribute("data-timestamp")));
    // This mess of code is based on <http://ejohn.org/files/pretty.js>.
    el.innerHTML =
        time_since < 60 && Math.floor(time_since) + " seconds ago" ||
        time_since < 120 && "a minute ago" ||
        time_since < 3600 && Math.floor(time_since / 60) + " minutes ago" ||
        time_since < 7200 && "an hour ago" ||
        time_since < 86400 && Math.floor(time_since / 3600) + " hours ago" ||
        time_since < 172800 && "a day ago" ||
        time_since < 2592000 && Math.floor(time_since / 86400) + " days ago" ||
        time_since < 5184000 && "a month ago" ||
        time_since < 31536000 && Math.floor(time_since / 2592000) + " months ago" ||
        time_since < 63072000 && "a year ago" ||
        Math.ceil(time_since / 31536000) + " years ago";
  });
}

updatePrettyDates();
window.setInterval(updatePrettyDates, 1000);

var dropdowns = document.getElementsByClassName("dropdown-menu");
for (var i = 0; i < dropdowns.length; i++) {
  dropdowns[i].onclick = function() {
    if (window.matchMedia("(hover: none)").matches) {
      this.classList.toggle("dropdown-menu--open");
      this.getElementsByClassName("hamburger")[0].classList.toggle(
          "hamburger--active");
    }
  };
}
