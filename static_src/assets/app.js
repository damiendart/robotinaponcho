// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import AppleClickEventFix from 'toolbox-sass/javascript/apple-click-event-fix';
import Clipboard from 'toolbox-sass/javascript/clipboard';

let ticking = false;

// <https://developer.mozilla.org/en-US/docs/Web/API/Element/matches#Polyfill>
if (!Element.prototype.matches) {
  Element.prototype.matches = Element.prototype.msMatchesSelector
    || Element.prototype.webkitMatchesSelector;
}

const gitCloneClipboard = new Clipboard(
  document.body,
  {
    errorCallback: () => {},
    successCallback: (target) => {
      target.classList.add('clipboard-success');
      target.addEventListener(
        'mouseout',
        (event) => {
          event.target.classList.remove('clipboard-success');
        },
        { once: true },
      );
    },
    targetCallback: (target) => target.matches('a[href$=".git"]'),
    textCallback: (target) => target.getAttribute('href'),
  },
);

AppleClickEventFix.applyFix();
gitCloneClipboard.init();

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

document.addEventListener('click', (event) => {
  const dropDownMenuElement = document.querySelector('.dropdown-menu');

  if (
    window.matchMedia('(hover: hover)').matches
    || dropDownMenuElement
      .querySelector('.dropdown-menu__lists')
      .contains(event.target)
  ) {
    return;
  }

  if (dropDownMenuElement.contains(event.target)) {
    dropDownMenuElement.classList.toggle('dropdown-menu--open');
    dropDownMenuElement
      .querySelector('.hamburger')
      .classList
      .toggle('hamburger--active');

    return;
  }

  dropDownMenuElement.classList.remove('dropdown-menu--open');
  dropDownMenuElement.querySelector('.hamburger')
    .classList
    .remove('hamburger--active');
});

window.addEventListener('scroll', () => {
  if (!ticking) {
    window.requestAnimationFrame(() => {
      const siteHeaderElement = document.querySelector('.header');

      if (window.pageYOffset > 50) {
        siteHeaderElement.classList.add('header--shadow');
      } else {
        siteHeaderElement.classList.remove('header--shadow');
      }

      ticking = false;
    });

    ticking = true;
  }
});
