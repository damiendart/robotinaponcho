// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

import './copy-to-clipboard';
import './site-header';
import 'toolbox-sass/javascript/pretty-date';

import appleClickEventFix from 'toolbox-sass/javascript/apple-click-event-fix';
import DropdownMenu from './dropdown-menu';

appleClickEventFix.applyFix();

// eslint-disable-next-line no-unused-vars
const dropdownMenu = new DropdownMenu(document.querySelector('.dropdown-menu'));
