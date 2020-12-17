// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import 'toolbox-sass/javascript/pretty-date';
import appleClickEventFix from 'toolbox-sass/javascript/apple-click-event-fix';
import clipboard from 'toolbox-sass/javascript/clipboard';
import debounce from 'toolbox-sass/javascript/debounce';
import throttle from 'toolbox-sass/javascript/throttle';

let currentScroll = window.pageYOffset;
let initialScroll = true;

// <https://developer.mozilla.org/en-US/docs/Web/API/Element/matches#Polyfill>
if (!Element.prototype.matches) {
  Element.prototype.matches = Element.prototype.msMatchesSelector
    || Element.prototype.webkitMatchesSelector;
}

const clipboardSuccessDebounceFunction = debounce(
  (target) => {
    target.classList.remove('clipboard-success');
  },
  1000,
);

appleClickEventFix.applyFix();

clipboard.addHandler(
  document.body,
  (target) => target.matches('a[href$=".git"], .social-share-list__item--permalink a'),
  (target) => target.getAttribute('href'),
  (target) => {
    target.classList.add('clipboard-success');
    clipboardSuccessDebounceFunction(target);
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

Array.prototype.forEach.call(
  document.querySelectorAll('a[href$=".git"], .social-share-list__item--permalink a'),
  (element) => {
    // eslint-disable-next-line no-param-reassign
    element.title = 'Copy to clipboard';
  },
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

    return;
  }

  dropDownMenuElement.classList.remove('dropdown-menu--open');
});

window.addEventListener(
  'scroll',
  throttle(() => {
    const siteHeaderElement = document.querySelector('.header');

    if (window.pageYOffset > 50) {
      siteHeaderElement.classList.add('header--shadow');
    } else {
      siteHeaderElement.classList.remove('header--shadow');
    }

    if (
      !initialScroll
      && window.pageYOffset > 150
      && window.pageYOffset > currentScroll
    ) {
      siteHeaderElement.classList.add('header--slide-up');
    } else {
      siteHeaderElement.classList.remove('header--slide-up');
    }

    currentScroll = window.pageYOffset;
    initialScroll = false;
  }),
);
