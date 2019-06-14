var gitCloneLinks = document.querySelectorAll('.button[href$=".git"');

for (var i = 0; gitCloneLinks[i]; i++) {
  gitCloneLinks[i].addEventListener('click', function(event) {
    event.preventDefault();

    const el = document.createElement('textarea');

    el.value = event.target.href;
    el.setAttribute('readonly', '');
    el.style.position = 'absolute';
    el.style.left = '-9999px';

    document.body.appendChild(el);

    const selected =
      document.getSelection().rangeCount > 0
        ? document.getSelection().getRangeAt(0)
        : false;

    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);

    if (selected) {
      document.getSelection().removeAllRanges();
      document.getSelection().addRange(selected);
    }
  });
}
