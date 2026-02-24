<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

abstract class EndToEndTestCase extends TestCase
{
    protected ?string $baseUri;
    protected ?Client $client;

    protected function setUp(): void
    {
        $this->baseUri = rtrim(getenv('END_TO_END_TESTS_BASE_URI'), '/') . '/';
        $this->client = new Client(
            [
                'base_uri' => $this->baseUri,
                'verify' => filter_var(
                    getenv('END_TO_END_TESTS_VERIFY_SSL'),
                    FILTER_VALIDATE_BOOL,
                ),
            ],
        );
    }

    protected function tearDown(): void
    {
        $this->baseUri = null;
        $this->client = null;
    }
}
