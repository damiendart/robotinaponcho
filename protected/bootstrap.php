<?php

require __DIR__ . '/vendor/autoload.php';

if (getenv('SENTRY_DSN')) {
    Sentry\init(
        [
            'dsn' => getenv('SENTRY_DSN'),
            'environment' => getenv('APP_ENV'),
            'release' => getenv('RELEASE_TIMESTAMP'),
        ]
    );
}

use Whoops\Handler\Handler;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run;

function reportThrowable(Throwable $throwable): void
{
    error_log($throwable, 0);

    if (getenv('SENTRY_DSN')) {
        Sentry\captureException($throwable);
    }
}

$whoops = new Run();

if (
    getenv('APP_ENV') === 'local'
    || Whoops\Util\Misc::isCommandLine()
) {
    // Using the "PrettyPageHandler" requires faffing around with CSP
    // stuff which, for the sake of a prettier error page when running
    // the site locally, is a battle that I don't think is worth having.
    $whoops->pushHandler(new PlainTextHandler());
} else {
    $whoops->pushHandler(function (Throwable $throwable) {
        include 'views/fatal.php';

        return Handler::DONE;
    });
}

$whoops->pushHandler(function (Throwable $throwable) {
    reportThrowable($throwable);

    return Handler::DONE;
});
$whoops->register();
