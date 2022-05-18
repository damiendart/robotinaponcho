// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

// eslint-disable-next-line no-underscore-dangle
function _noop() {
  return () => {};
}

// Account for iOS and iPadOS WebKit's busted handling of mouse events.
// See <https://www.quirksmode.org/blog/archives/2014/02/mouse_event_bub.html>
// for more information. This fix is based on one used by Bootstrap.
function applyFix() {
  if ('ontouchstart' in document.documentElement) {
    // Internet Explorer 11 doesn't implement `NodeList.forEach()`,
    // hence the `Array.prototype.forEach()` kludge. See
    // <https://developer.mozilla.org/en-US/docs/Web/API/NodeList#Example>
    // for more information.
    Array.prototype.forEach.call(document.body.children, (element) => {
      element.addEventListener('mouseover', _noop);
    });
  }
}

applyFix();
