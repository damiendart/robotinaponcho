// Copyright (C) Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

// The following is based on
// <https://programmingwithmosh.com/javascript/javascript-throttle-and-debounce-patterns/>.
function debounce(callback, interval) {
  let debounceTimeoutID = null;

  return (...args) => {
    clearTimeout(debounceTimeoutID);
    debounceTimeoutID = setTimeout(
      () => callback.apply(this, args),
      interval,
    );
  };
}

export default debounce;
