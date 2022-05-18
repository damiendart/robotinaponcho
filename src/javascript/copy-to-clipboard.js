// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

function copyToClipboard(text) {
  let copySuccessful = false;
  const currentSelection = (document.getSelection().rangeCount > 0)
    ? document.getSelection().getRangeAt(0)
    : false;
  const textAreaElement = document.createElement('textarea');
  const currentVerticalPosition = window.pageYOffset
    || document.documentElement.scrollTop;

  textAreaElement.setAttribute('readonly', '');
  textAreaElement.style.left = '-9999px';
  textAreaElement.style.position = 'absolute';
  textAreaElement.style.top = `${currentVerticalPosition}px`;
  textAreaElement.value = text;

  document.body.appendChild(textAreaElement);
  textAreaElement.select();

  try {
    document.execCommand('copy');
    copySuccessful = true;
  } catch (err) {
    copySuccessful = false;
  }

  document.body.removeChild(textAreaElement);

  if (currentSelection) {
    document.getSelection().removeAllRanges();
    document.getSelection().addRange(currentSelection);
  }

  return copySuccessful;
}

function addHandler(
  containerElement,
  targetCallback,
  textCallback,
  successCallback,
  errorCallback,
) {
  containerElement.addEventListener(
    'click',
    (event) => {
      if (targetCallback(event.target) === false) {
        return;
      }

      const textToCopy = textCallback(event.target);

      event.preventDefault();

      if (copyToClipboard(textToCopy)) {
        successCallback(event.target, textToCopy);
      } else {
        errorCallback(event.target, textToCopy);
      }
    },
  );
}

// The following is based on
// <https://programmingwithmosh.com/javascript/javascript-throttle-and-debounce-patterns/>.
function debounce(callback, interval) {
  let debounceTimeoutID = null;

  // eslint-disable-next-line func-names
  return function (...args) {
    clearTimeout(debounceTimeoutID);
    debounceTimeoutID = setTimeout(
      () => callback.apply(this, args),
      interval,
    );
  };
}

const clipboardSuccessDebounceFunction = debounce(
  (target) => {
    target.classList.remove('clipboard-success');
  },
  1000,
);

addHandler(
  document.body,
  (target) => target.matches('.social-share-list__item--permalink a'),
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
    element.title = 'Copy page URL to clipboard';
  },
);
