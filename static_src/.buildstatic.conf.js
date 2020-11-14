// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

const childProcess = require('child_process');
const addSlugsToItems = require('toolbox-sass/buildstatic/modifiers/add-slugs-to-items');
const addSitemap = require('toolbox-sass/buildstatic/modifiers/add-sitemap')

function addGitMetadataToItems(globalData, items) {
  return [
    globalData,
    items.map((item) => {
      if (item.data.inputFilePath === null) {
        return item;
      }

      const [createdHash, createdTimestamp] =
        childProcess.execSync(
          `git log --diff-filter=A --follow --format='%H %at' -1 -- ${item.data.inputFilePath}`,
        )
          .toString()
          .split(' ');
      const [lastModifiedHash, lastModifiedTimestamp] =
        childProcess.execSync(
          `git log -n 1 --pretty=format:'%H %at' ${item.data.inputFilePath}`,
        )
          .toString()
          .split(' ');

      item.data.git = {
        created: {
          hash: createdHash,
          timestamp: new Date(parseInt(createdTimestamp, 10)),
        },
        updated: {
          hash: lastModifiedHash,
          timestamp: new Date(parseInt(lastModifiedTimestamp, 10)),
        }
      };

      return item;
    }),
  ];
}

module.exports = {
  globalData: {
    author: 'Damien Dart',
    metaTwitterAuthor: '@damiendart',
    metaTwitterSite: '@damiendart',
    metaOpengraphImage: 'https://www.robotinaponcho.net/assets/opengraph.png',
    releaseTimestamp: process.env.RELEASE_TIMESTAMP || '00000000000000',
    urlBase: 'https://www.robotinaponcho.net/',
  },
  modifiers: [
    addSlugsToItems,
    [
      addSitemap,
      {
        additionalEntries: [
          'art/colouring-pages-a4.pdf',
          'art/colouring-pages-us.pdf',
        ],
        ignorePattern: /google(.*).html$/,
      }
    ],
    addGitMetadataToItems,
  ],
};
