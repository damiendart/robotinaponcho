// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import './polyfills';
import clipboard from 'toolbox-sass/javascript/clipboard';
import debounce from 'toolbox-sass/javascript/debounce';

const clipboardSuccessDebounceFunction = debounce(
  (target) => {
    target.classList.remove('clipboard-success');
  },
  1000,
);

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
