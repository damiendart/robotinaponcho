<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Tests\EndToEnd;

use App\Tests\EndToEndTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\TestDox;

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
#[TestDox('When using query strings, the application')]
class QueryStringTest extends EndToEndTestCase
{
    #[TestDox('should remove unnecessary query strings from URLs')]
    public function test_should_remove_unnecessary_query_strings_from_urls(): void
    {
        $response = $this->client->request(
            'GET',
            '?utm=blah',
            ['allow_redirects' => ['track_redirects' => true]],
        );

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals(
            "{$this->baseUri}",
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
        );
        $this->assertEquals(
            '301',
            $response->getHeaderLine('X-Guzzle-Redirect-Status-History'),
        );
    }
}
