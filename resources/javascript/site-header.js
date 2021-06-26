// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import throttle from 'toolbox-sass/javascript/throttle';

let currentScroll = window.pageYOffset;
let initialScroll = true;

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
      && document.querySelector('.header__navigation:hover, .dropdown-menu--open') === null
    ) {
      siteHeaderElement.classList.add('header--slide-up');
    } else {
      siteHeaderElement.classList.remove('header--slide-up');
    }

    currentScroll = window.pageYOffset;
    initialScroll = false;
  }),
);
