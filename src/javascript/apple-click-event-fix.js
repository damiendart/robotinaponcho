// Copyright (C) Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

function _noop() {
  return () => { /* block left intentionally empty */ };
}

// Account for iOS and iPadOS WebKit's busted handling of mouse events.
// See <https://www.quirksmode.org/blog/archives/2014/02/mouse_event_bub.html>
// for more information. This fix is based on one used by Bootstrap.
if ('ontouchstart' in document.documentElement) {
  Array.from(document.body.children).forEach(
    (element) => {
      element.addEventListener('mouseover', _noop);
    },
  );
}
