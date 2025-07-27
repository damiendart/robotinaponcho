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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
#[TestDox('The application')]
class RedirectTest extends EndToEndTestCase
{
    public static function goneProvider(): array
    {
        return [
            ['/demons_souls_theodore.jpg'],
            ['/deadlypremonition.jpeg'],
            ['/robotinaponcho.jpeg'],
            ['/art/2015-12-18-christmas-card.png'],
            ['/art/2015-12-18-christmas-card@2x.png'],
            ['/art/colouring-pages-sample-1.png'],
            ['/art/colouring-pages-sample-2.png'],
            ['/art/colouring-pages-sample-3.png'],
            ['/art/colouring-pages-sample-4.png'],
            ['/assets/animate.min.css'],
            ['/assets/artwork.png'],
            ['/assets/artwork.svg'],
            ['/assets/blog-background.png'],
            ['/assets/blog-style.css'],
            ['/assets/decomp.min.js'],
            ['/assets/drawings-on-tumblr-background.png'],
            ['/assets/foc-footer.html'],
            ['/assets/foc-header.html'],
            ['/assets/gelica-semibold.woff2'],
            ['/assets/glyphiconshalflings-regular.eot'],
            ['/assets/glyphiconshalflings-regular.otf'],
            ['/assets/glyphiconshalflings-regular.svg'],
            ['/assets/glyphiconshalflings-regular.ttf'],
            ['/assets/glyphiconshalflings-regular.woff'],
            ['/assets/greycliff-bold.woff2'],
            ['/assets/greycliff-oblique.woff2'],
            ['/assets/greycliff-regular.woff2'],
            ['/assets/homepage-robot-outline.png'],
            ['/assets/homepage-robot-outline.webp'],
            ['/assets/homepage-robot-outline@2x.png'],
            ['/assets/homepage-robot-outline@2x.webp'],
            ['/assets/html5shiv.js'],
            ['/assets/ibmplexserif-bold.woff2'],
            ['/assets/ibmplexserif-italic.woff2'],
            ['/assets/ibmplexserif-regular.woff2'],
            ['/assets/icon-arrow-left.svg'],
            ['/assets/icon-buy-me-a-coffee-link.svg'],
            ['/assets/icon-download.svg'],
            ['/assets/icon-github-link.svg'],
            ['/assets/icon-help.svg'],
            ['/assets/icon-info.svg'],
            ['/assets/icon-instagram-link.svg'],
            ['/assets/icon-menu.svg'],
            ['/assets/index-vendor.js'],
            ['/assets/instagram.png'],
            ['/assets/instagram@2x.png'],
            ['/assets/inter-bold.woff2'],
            ['/assets/inter-italic.woff2'],
            ['/assets/inter-regular.woff2'],
            ['/assets/iosevka-bold.woff2'],
            ['/assets/iosevka-italic.woff2'],
            ['/assets/iosevka-regular.woff2'],
            ['/assets/jquery-1.10.1.min.js'],
            ['/assets/jquery-1.11.3.min.js'],
            ['/assets/kathryn.png'],
            ['/assets/kathryn@2x.png'],
            ['/assets/matter.min.js'],
            ['/assets/moment.min.js'],
            ['/assets/montserrat-bold.woff2'],
            ['/assets/montserrat-italic.woff2'],
            ['/assets/montserrat-regular.woff2'],
            ['/assets/obtaincornhoop.png'],
            ['/assets/obtaincornhoop@2x.png'],
            ['/assets/radicalapps.png'],
            ['/assets/radicalapps@2x.png'],
            ['/assets/robot-and-things-outlines.png'],
            ['/assets/robot-and-things-outlines.webp'],
            ['/assets/robot-and-things.png'],
            ['/assets/robot-and-things.webp'],
            ['/assets/robot.png'],
            ['/assets/robot@2x.png'],
            ['/assets/robotinaponcho.png'],
            ['/assets/robotinaponcho@2x.png'],
            ['/assets/selectnav.min.js'],
            ['/assets/site-header.png'],
            ['/assets/site-header@2x.png'],
            ['/assets/spin.min.js'],
            ['/crap/bastardsnake.swf'],
            ['/crap/blog-background2.gif'],
            ['/crap/blog-date-icon.png'],
            ['/crap/blog-header.png'],
            ['/crap/blog-source-icon.png'],
            ['/crap/blog-tags-icon.png'],
            ['/crap/colouring-pages-sample-1.png'],
            ['/crap/colouring-pages-sample-2.png'],
            ['/crap/colouring-pages-sample-3.png'],
            ['/crap/colouring-pages-sample-4.png'],
            ['/crap/glyphiconshalflings-regular.eot'],
            ['/crap/glyphiconshalflings-regular.otf'],
            ['/crap/glyphiconshalflings-regular.svg'],
            ['/crap/glyphiconshalflings-regular.ttf'],
            ['/crap/glyphiconshalflings-regular.woff'],
            ['/crap/teamspeak-banner.jpeg'],
            ['/crap/thingy.swf'],
            ['/flippywindow/arrow.png'],
            ['/flippywindow/arrow@2x.png'],
            ['/flippywindow/background.svg'],
            ['/obtaincornhoop/glyphiconshalflings-regular.eot'],
            ['/obtaincornhoop/glyphiconshalflings-regular.otf'],
            ['/obtaincornhoop/glyphiconshalflings-regular.svg'],
            ['/obtaincornhoop/glyphiconshalflings-regular.ttf'],
            ['/obtaincornhoop/glyphiconshalflings-regular.woff'],
            ['/obtaincornhoop/html5shiv.js'],
            ['/obtaincornhoop/page-background.png'],
            ['/obtaincornhoop/selectnav.min.js'],
            ['/obtaincornhoop/style.css'],
        ];
    }

    public static function permanentRedirectProvider(): array
    {
        return [
            ['/art/colouring-pages-a4.pdf', '/crap/colouring-pages-a4.pdf'],
            ['/art/colouring-pages-us.pdf', '/crap/colouring-pages-us.pdf'],
            ['/assets/homepage-robot.avif', '/assets/robot-in-a-poncho.%d.avif'],
            ['/assets/homepage-robot.png', '/assets/robot-in-a-poncho.%d.png'],
            ['/assets/homepage-robot.webp', '/assets/robot-in-a-poncho.%d.webp'],
            ['/assets/homepage-robot@2x.avif', '/assets/robot-in-a-poncho@2x.%d.avif'],
            ['/assets/homepage-robot@2x.png', '/assets/robot-in-a-poncho@2x.%d.png'],
            ['/assets/homepage-robot@2x.webp', '/assets/robot-in-a-poncho@2x.%d.webp'],
            ['/assets/icon-check-link.svg', '/assets/icon-check.%d.svg'],
            ['/assets/icon-copy-link.svg', '/assets/icon-copy.%d.svg'],
            ['/assets/icon-facebook-link.svg', '/assets/icon-facebook.%d.svg'],
            ['/assets/icon-twitter-link.svg', '/assets/icon-twitter.%d.svg'],
            ['/assets/icons-chevrons.svg', '/assets/icon-chevron.%d.svg'],
            ['/assets/og.png', '/assets/opengraph.%d.png'],
            ['/crap/FlippyWindowVertical.zip', '/projects/flippywindow/flippywindow-64-bit.zip'],
            ['/crap/photoshop-notes.html', '/notes/#adobe-creative-cloud'],
            ['/crap/synology-notes.html', '/notes/#synology-diskstation'],
            ['/flippywindow/', '/projects/flippywindow/'],
            ['/flippywindow/flippywindow-32-bit.zip', '/projects/flippywindow/flippywindow-32-bit.zip'],
            ['/flippywindow/flippywindow-64-bit.zip', '/projects/flippywindow/flippywindow-64-bit.zip'],
            ['/flippywindow/opengraph.png', '/projects/flippywindow/opengraph.%d.png'],
            ['/flippywindow/screenshot.png', '/projects/flippywindow/screenshot.%d.png'],
            ['/git/?p=bastardsnake.git', '/git/#bastardsnake'],
            ['/git/?p=brainfuck.git', '/git/#brainfuck'],
            ['/git/?p=flippywindow.git', '/git/#flippywindow'],
            ['/git/?p=knr-solutions.git', '/git/#knr-solutions'],
            ['/git/?p=nfsnapi-python.git', '/git/#nfsnapi-python'],
            ['/git/?p=notes.git', '/git/#notes'],
            ['/git/?p=obtaincornhoop.git', '/git/#obtaincornhoop'],
            ['/git/?p=robotinaponcho.git', '/git/#robotinaponcho'],
            ['/git/index.php', '/git/'],
            ['/git/robotinaponcho.git', '/git/#robotinaponcho'],
            ['/notes/books', '/notes/completed-books'],
            ['/notes/books-2021', '/notes/completed-books'],
            ['/notes/books-2021.html', '/notes/completed-books'],
            ['/notes/books.html', '/notes/completed-books'],
            ['/notes/breadmaking', '/notes/white-loaf-recipe'],
            ['/notes/breadmaking.html', '/notes/white-loaf-recipe'],
            ['/notes/computer', '/notes/ubuntu-desktop-setup'],
            ['/notes/computer.html', '/notes/ubuntu-desktop-setup'],
            ['/notes/development-environment', '/notes/ubuntu-desktop-setup'],
            ['/notes/development-environment.html', '/notes/ubuntu-desktop-setup'],
            ['/notes/photoshop', '/notes/#adobe-creative-cloud'],
            ['/notes/photoshop.html', '/notes/#adobe-creative-cloud'],
            ['/notes/phpstorm', '/notes/#jetbrains-ides'],
            ['/notes/phpstorm.html', '/notes/#jetbrains-ides'],
            ['/notes/procreate', '/notes/#procreate'],
            ['/notes/procreate.html', '/notes/#procreate'],
            ['/notes/synology', '/notes/#synology-diskstation'],
            ['/notes/synology.html', '/notes/#synology-diskstation'],
            ['/notes/windows', '/notes/ubuntu-desktop-setup'],
            ['/notes/windows.html', '/notes/ubuntu-desktop-setup'],
        ];
    }

    #[DataProvider('permanentRedirectProvider')]
    #[TestDox('should permanently redirect "$original" correctly')]
    public function test_should_permanent_redirect_old_urls_correctly(string $original, string $target): void
    {
        $response = $this->client->request(
            'GET',
            ltrim($original, '/'),
            [
                'allow_redirects' => ['track_redirects' => true],
                'http_errors' => false,
            ],
        );

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertStringMatchesFormat(
            rtrim($this->baseUri, '/') . $target,
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
            'Unnecessary redirect chain detected.',
        );
        $this->assertEquals(
            '301',
            $response->getHeaderLine('X-Guzzle-Redirect-Status-History'),
            'Unnecessary redirect chain detected.',
        );
    }

    #[DataProvider('goneProvider')]
    #[TestDox('should return 410 Gone when requesting "$original"')]
    public function test_should_handle_permanently_unavailable_urls_correctly(string $original): void
    {
        $response = $this->client->request(
            'GET',
            ltrim($original, '/'),
            [
                'allow_redirects' => ['track_redirects' => true],
                'http_errors' => false,
            ],
        );

        $this->assertEquals('410', $response->getStatusCode());
        $this->assertEquals(
            '',
            $response->getHeaderLine('X-Guzzle-Redirect-History'),
            'Unnecessary redirect chain detected.',
        );
    }
}
