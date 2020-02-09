<?php

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
