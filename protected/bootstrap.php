<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

if (getenv('SENTRY_DSN')) {
    Sentry\init(
        [
            'dsn' => getenv('SENTRY_DSN'),
            'environment' => getenv('APP_ENV'),
            'release' => getenv('RELEASE_TIMESTAMP'),
        ],
    );
}

use Whoops\Handler\Handler;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run;

function reportThrowable(Throwable $throwable): void
{
    error_log($throwable->getMessage(), 0);

    if (getenv('SENTRY_DSN')) {
        Sentry\captureException($throwable);
    }
}

$whoops = new Run();

if (
    'local' === getenv('APP_ENV')
    || Whoops\Util\Misc::isCommandLine()
) {
    // Using the "PrettyPageHandler" requires faffing around with CSP
    // stuff which, for the sake of a prettier error page when running
    // the site locally, isn't worth the effort.
    $whoops->pushHandler(new PlainTextHandler());
} else {
    $whoops->pushHandler(
        function (Throwable $throwable): int {
            include 'fatal.php';

            return Handler::DONE;
        },
    );
}

$whoops->pushHandler(
    function (Throwable $throwable): int {
        reportThrowable($throwable);

        return Handler::DONE;
    },
);

$whoops->register();
