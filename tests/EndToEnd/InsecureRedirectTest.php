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
use Psr\Http\Message\ResponseInterface;

/**
 * These tests should technically be part of my server-provisioning
 * gubbins as the Apache configuration for insecure-to-secure redirects
 * lives there, but it was easier to use the existing end-to-end test
 * setup here, so eh.
 *
 * @internal
 */
#[CoversNothing]
#[TestDox('The server')]
class InsecureRedirectTest extends EndToEndTestCase
{
    #[TestDox('should permanently redirect the insecure base URL correctly to support HSTS preloading')]
    public function test_should_permanently_redirect_the_insecure_base_url_correctly(): void
    {
        $response = $this->sendInsecureRequest($this->baseUri);
        $this->assertStringMatchesFormat(
            $this->baseUri,
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
        );
    }

    #[TestDox('should permanently redirect insecure URLs ending with "index.html" correctly to support HSTS preloading')]
    public function test_should_permanently_redirect_insecure_urls_ending_with_index_html_correctly(): void
    {
        $url = $this->baseUri . 'index.html';

        $response = $this->sendInsecureRequest($url);
        $this->assertStringMatchesFormat(
            $url . ', ' . $this->baseUri,
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
        );
    }

    #[TestDox('should permanently redirect insecure URLs with query strings correctly to support HSTS preloading')]
    public function test_should_permanently_redirect_insecure_urls_with_query_strings_correctly(): void
    {
        $url = $this->baseUri . 'sitemap?testing=123';

        $response = $this->sendInsecureRequest($url);
        $this->assertStringMatchesFormat(
            $url . ', ' . $this->baseUri . 'sitemap',
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
        );
    }

    #[TestDox('should permanently redirect insecure URLs with cache-busting gubbins correctly to support HSTS preloading')]
    public function test_should_permanently_redirect_insecure_urls_with_cache_busting_gubbins_correctly(): void
    {
        $url = $this->baseUri . 'assets/app.00000000000000.js';

        $response = $this->sendInsecureRequest($url);
        $this->assertStringMatchesFormat(
            $url . ', ' . $this->baseUri . 'assets/app.%d.js',
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
        );
    }

    #[TestDox('should permanently redirect an insecure alias base URL correctly to support HSTS preloading')]
    public function test_should_permanently_redirect_an_insecure_alias_base_url_correctly(): void
    {
        $aliasBaseUri = str_replace('www.', '', $this->baseUri);

        $response = $this->sendInsecureRequest($aliasBaseUri);
        $this->assertStringMatchesFormat(
            $aliasBaseUri . ', ' . $this->baseUri,
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
        );
    }

    #[TestDox('should permanently redirect insecure alias URLs with query strings correctly to support HSTS preloading')]
    public function test_should_permanently_redirect_insecure_alias_urls_with_query_strings_correctly(): void
    {
        $aliasBaseUri = str_replace('www.', '', $this->baseUri);

        $response = $this->sendInsecureRequest($aliasBaseUri . 'sitemap?testing=123');
        $this->assertStringMatchesFormat(
            join(
                ', ',
                [
                    $aliasBaseUri . 'sitemap?testing=123',
                    $this->baseUri . 'sitemap?testing=123',
                    $this->baseUri . 'sitemap',
                ],
            ),
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
        );
    }

    private function sendInsecureRequest(string $url): ResponseInterface
    {
        return $this->client->request(
            'GET',
            str_replace('https', 'http', $url),
            [
                'allow_redirects' => ['track_redirects' => true],
                'http_errors' => false,
            ],
        );
    }
}
