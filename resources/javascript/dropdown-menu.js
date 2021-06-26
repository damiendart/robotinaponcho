// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import './polyfills';

document.addEventListener('click', (event) => {
  const dropDownMenuElement = document.querySelector('.dropdown-menu');

  if (
    window.matchMedia('(hover: hover)').matches
    || dropDownMenuElement
      .querySelector('.dropdown-menu__lists')
      .contains(event.target)
  ) {
    return;
  }

  if (dropDownMenuElement.contains(event.target)) {
    dropDownMenuElement.classList.toggle('dropdown-menu--open');

    return;
  }

  dropDownMenuElement.classList.remove('dropdown-menu--open');
});
