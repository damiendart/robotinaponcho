// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import './copy-to-clipboard';
import 'toolbox-sass/javascript/pretty-date';
import appleClickEventFix from 'toolbox-sass/javascript/apple-click-event-fix';
import DetailsElementAnimation from './details-element-animation';
import ThemeSwitcher from './theme-switcher';

appleClickEventFix.applyFix();

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
