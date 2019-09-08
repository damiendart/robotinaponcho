// <https://developer.mozilla.org/en-US/docs/Web/API/Element/matches#Polyfill>
if (!Element.prototype.matches) {
  Element.prototype.matches =
    Element.prototype.msMatchesSelector
    || Element.prototype.webkitMatchesSelector;
}

window.addEventListener('click', function(e) {
  if (!e.target.matches('[href$=".git"]')) {
    return;
  }

  var el = document.createElement('textarea');
  var selected =
    document.getSelection().rangeCount > 0
      ? document.getSelection().getRangeAt(0)
      : false;

  e.preventDefault();

  el.value = e.target.href;
  el.setAttribute('readonly', '');
  el.style.position = 'absolute';
  el.style.left = '-9999px';

  document.body.appendChild(el);

  el.select();
  document.execCommand('copy');
  document.body.removeChild(el);

  if (selected) {
    document.getSelection().removeAllRanges();
    document.getSelection().addRange(selected);
  }
});
