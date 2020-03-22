<?php
// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

require __DIR__ . '/../../vendor/autoload.php';

if (getenv('SENTRY_DSN')) {
    Sentry\init(
        [
            'dsn' => getenv('SENTRY_DSN'),
            'environment' => getenv('APP_ENV'),
            'release' => getenv('RELEASE_TIMESTAMP'),
        ]
    );
}

return json_decode(
    file_get_contents(
        getenv('SHARED_ROOT') . '/protected/git/metadata.json'
    ),
    true
);
