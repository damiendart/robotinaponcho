// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

const childProcess = require('child_process');

module.exports = {
  contextModifier: (context) => {
    childProcess.exec(
      `git log -n 1 --pretty=format:'%H %at' ${context.inputFile.name}`,
      (error, stdout) => {
        if (error) {
          throw error;
        }

        const [hash, timestamp] = stdout.split(' ');

        context.inputFile.git = {
          hash,
          timestamp: new Date(parseInt(timestamp, 10)),
        };
      }
    );

    context.deployment = {
      releaseTimestamp: process.env.RELEASE_TIMESTAMP || '00000000000000',
    };

    return context;
  }
};
