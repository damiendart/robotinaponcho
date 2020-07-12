// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

const childProcess = require('child_process');

module.exports = {
  itemsModifier: (items) => {
    return items.map((item) => {
      childProcess.exec(
        `git log -n 1 --pretty=format:'%H %at' ${item.data.inputFilePath}`,
        (error, stdout) => {
          if (error) {
            throw error;
          }

          const [hash, timestamp] = stdout.split(' ');

          item.data.git = {
            hash,
            timestamp: new Date(parseInt(timestamp, 10)),
          };
        }
      );

      item.data.deployment = {
        releaseTimestamp: process.env.RELEASE_TIMESTAMP || '00000000000000',
      };

      return item;
    });
  }
};
