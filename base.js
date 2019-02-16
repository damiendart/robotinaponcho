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
