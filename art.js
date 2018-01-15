function update_modified() {
  var modified = document.querySelectorAll("[data-timestamp]");
  for (var i = 0; i < modified.length; i++) {
    var time_since = Math.floor((new Date().getTime() / 1000) -
        parseInt(modified[i].getAttribute("data-timestamp")));
    // This mess of code is based on <http://ejohn.org/files/pretty.js>.
    modified[i].innerHTML =
        time_since < 60 && Math.floor(time_since) + " seconds ago" ||
        time_since < 120 && "A minute ago" ||
        time_since < 3600 && Math.floor(time_since / 60) + " minutes ago" ||
        time_since < 7200 && "An hour ago" ||
        time_since < 86400 && Math.floor(time_since / 3600) + " hours ago" ||
        time_since < 172800 && "A day ago" ||
        time_since < 2592000 && Math.floor(time_since / 86400) + " days ago" ||
        time_since < 5184000 && "A month ago" ||
        time_since < 31536000 && Math.floor(time_since / 2592000) + " months ago" ||
        time_since < 63072000 && "A year ago" ||
        Math.floor(time_since / 31536000) + " years ago";
  }
}

update_modified();
setInterval(update_modified, 1000);
