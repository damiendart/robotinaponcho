// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import throttle from 'toolbox-sass/javascript/throttle';

let currentScroll = window.pageYOffset;
let initialScroll = true;

window.addEventListener(
  'scroll',
  throttle(() => {
    const siteHeaderElement = document.querySelector('.site-header');

    if (window.pageYOffset > 50) {
      siteHeaderElement.classList.add('site-header--shadow');
    } else {
      siteHeaderElement.classList.remove('site-header--shadow');
    }

    if (
      !initialScroll
      && window.pageYOffset > 150
      && window.pageYOffset > currentScroll
      && document.querySelector(
        '.site-header__navigation:hover, .dropdown-menu__list[aria-hidden="false"]',
      ) === null
    ) {
      siteHeaderElement.classList.add('site-header--slide-up');
    } else {
      siteHeaderElement.classList.remove('site-header--slide-up');
    }

    currentScroll = window.pageYOffset;
    initialScroll = false;
  }),
);
