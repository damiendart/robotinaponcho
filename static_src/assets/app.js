// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import 'toolbox-sass/javascript/pretty-date';

import appleClickEventFix from 'toolbox-sass/javascript/apple-click-event-fix';
import clipboard from 'toolbox-sass/javascript/clipboard';

let ticking = false;

// <https://developer.mozilla.org/en-US/docs/Web/API/Element/matches#Polyfill>
if (!Element.prototype.matches) {
  Element.prototype.matches = Element.prototype.msMatchesSelector
    || Element.prototype.webkitMatchesSelector;
}

appleClickEventFix.applyFix();
clipboard.addHandler(
  document.body,
  (target) => target.matches('a[href$=".git"]'),
  (target) => target.getAttribute('href'),
  (target) => {
    target.classList.add('clipboard-success');
    target.addEventListener(
      'mouseout',
      (event) => {
        event.target.classList.remove('clipboard-success');
      },
      { once: true },
    );
  },
  () => {},
);

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
