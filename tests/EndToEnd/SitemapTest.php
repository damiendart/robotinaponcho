<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Tests\EndToEnd;

use Robotinaponcho\Tests\EndToEndTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class SitemapTest extends EndToEndTestCase
{
    public function test_return_a_valid_sitemap_with_entries_using_the_correct_domain_name(): void
    {
        $response = $this->client->request('GET', 'sitemap.xml');

        $responseDocument = new \DOMDocument();
        $responseDocument->loadXML($response->getBody()->getContents());

        $xpath = new \DOMXPath($responseDocument);
        $xpath->registerNamespace(
            's',
            'http://www.sitemaps.org/schemas/sitemap/0.9',
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(
            'application/xml',
            $response->getHeaderLine('Content-Type'),
        );

        $this->assertCount(
            $xpath->query('//s:url/s:loc')->count(),
            $xpath->query(
                "//s:url/s:loc[starts-with(text(), 'https://www.robotinaponcho.net')]",
            ),
        );
    }
}
