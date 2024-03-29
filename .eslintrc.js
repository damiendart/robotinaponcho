// Copyright (C) Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

module.exports = {
  env: {
    browser: true,
    es6: true,
  },
  extends: [
    'eslint:recommended',
    'airbnb-base',
  ],
  rules: {
    indent: [
      'error',
      2,
      {
        ignoredNodes: ['TemplateLiteral *'],
      },
    ],
  },
};
