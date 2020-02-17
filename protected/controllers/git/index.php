<?php
// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

if (getenv('SENTRY_DSN')) {
    Sentry\init(
        [
            'dsn' => getenv('SENTRY_DSN'),
            'environment' => getenv('APP_ENV'),
            'release' => getenv('DEPLOYED_RELEASE'),
        ]
    );
}

$repositories = json_decode(
    file_get_contents(
        join(
            DIRECTORY_SEPARATOR,
            [getenv('SHARED_ROOT'), 'protected', 'git', 'metadata.json']
        )
    ),
    true
);
