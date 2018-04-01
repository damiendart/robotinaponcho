window.onload = window.onreadystatechange = function() {
  if (!this.readyState || /loaded|complete/.test(this.readyState)) {
    Itch.attachBuyButton(document.getElementById("itch"),
        { user: "damiendart", game: "flippywindow" });
  }
};
