// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import './apple-click-event-fix';
import './copy-to-clipboard';
import './pretty-date';

import DetailsElementAnimation from './details-element-animation';
import ThemeSwitcher from './theme-switcher';

document.querySelectorAll('details').forEach((el) => {
  // eslint-disable-next-line no-new
  new DetailsElementAnimation(el);
});

const siteFooterElement = document.querySelector('.site-footer');
const themeSwitcherContainerElement = document.createElement('div');

themeSwitcherContainerElement.setAttribute(
  'class',
  'site-footer__theme-switcher',
);

if (window.CSS && window.CSS.supports('(--css: variables)')) {
  siteFooterElement.appendChild(themeSwitcherContainerElement);
  // eslint-disable-next-line no-new
  new ThemeSwitcher(themeSwitcherContainerElement);
}
