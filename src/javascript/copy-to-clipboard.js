// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import debounce from './debounce';

document.body.addEventListener(
  'click',
  (event) => {
    if (event.target.matches('[data-clipboard]') === false) {
      return;
    }

    event.preventDefault();

    window.navigator.clipboard.writeText(
      event.target.getAttribute('data-clipboard'),
    )
      .then(
        () => {
          const onClipboardSuccess = debounce(
            (target) => {
              target.classList.remove('clipboard-success');
            },
            1000,
          );

          event.target.classList.add('clipboard-success');
          onClipboardSuccess(event.target);
          event.target.addEventListener(
            'mouseout',
            (e) => {
              e.target.classList.remove('clipboard-success');
            },
            { once: true },
          );
        },
        () => {},
      );
  },
);

Array.prototype.forEach.call(
  document.querySelectorAll('a[data-clipboard]'),
  (element) => {
    // eslint-disable-next-line no-param-reassign
    element.title = 'Copy page URL to clipboard';
  },
);
