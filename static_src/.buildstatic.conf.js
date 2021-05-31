// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

const childProcess = require('child_process');
const addSlugsToItems = require('yassg/src/modifiers/add-slugs-to-items');
const addSitemap = require('yassg/src/modifiers/add-sitemap')

function addGitMetadataToItems(globalData, items) {
  return [
    globalData,
    items.map((item) => {
      if (item.data.inputFilePath === null) {
        return item;
      }

      const [createdHash, createdTimestamp] =
        childProcess.execSync(
          `git log --diff-filter=A --follow --format='%H %ct' -1 -- ${item.data.inputFilePath}`,
        )
          .toString()
          .split(' ');
      const [lastModifiedHash, lastModifiedTimestamp] =
        childProcess.execSync(
          `git log -n 1 --pretty=format:'%H %ct' ${item.data.inputFilePath}`,
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

function addNotesCollection(globalData, items) {
  return [
    {
      ...globalData,
      collections: {
        notes: items.filter(
          item => 'slug' in item.data && item.data.slug.match(/^notes\/.+/)
        )
          .map(item => item.data)
          .sort((a, b) => a.title.localeCompare(b.title))
          .sort((a, b) => b.git.updated.timestamp - a.git.updated.timestamp),
      }
    },
    items,
  ]
}

module.exports = {
  globalData: {
    author: 'Damien Dart',
    authorEmail: 'damiendart@pobox.com',
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
    addNotesCollection,
  ],
};
