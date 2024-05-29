<?php

// Copyright (C) Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

use App\Yassg\Plugins\GitMetadata\GitMetadataPlugin;
use App\Yassg\Plugins\HtmlMinifier\HtmlMinifierPlugin;
use App\Yassg\Plugins\MarkdownMetadata\MarkdownMetadataPlugin;
use App\Yassg\Plugins\MarkdownSetup\MarkdownSetupPlugin;
use App\Yassg\Plugins\SitemapEntries\SitemapEntriesPlugin;
use App\Yassg\Plugins\TwigMarkdown\TwigMarkdownPlugin;
use App\Yassg\Plugins\TwigSmartyPants\TwigSmartyPantsPlugin;
use App\Yassg\Plugins\TwigWidont\TwigWidontPlugin;
use Yassg\Configuration\Configuration;
use Yassg\Plugins\Collections\CollectionsPlugin;
use Yassg\Plugins\Slug\BasicSlugStrategy;
use Yassg\Plugins\Slug\SlugPlugin;

$releaseTimestamp = getenv('RELEASE_TIMESTAMP') ?? '00000000000000';

return (new Configuration(
    __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'yassg',
    __DIR__ . DIRECTORY_SEPARATOR . 'public',
))
    ->addPlugin(new CollectionsPlugin())
    ->addPlugin(new HtmlMinifierPlugin())
    ->addPlugin(new GitMetadataPlugin())
    ->addPlugin(new MarkdownMetadataPlugin())
    ->addPlugin(new MarkdownSetupPlugin())
    ->addPlugin(new SitemapEntriesPlugin())
    ->addPlugin(new SlugPlugin(new BasicSlugStrategy))
    ->addPlugin(new TwigMarkdownPlugin())
    ->addPlugin(new TwigSmartyPantsPlugin())
    ->addPlugin(new TwigWidontPlugin())
    ->setMetadata(
        [
            'author' => 'Damien Dart',
            'authorEmail' => 'damiendart@pobox.com',
            'metaTwitterAuthor' => '@damiendart',
            'metaTwitterSite' => '@damiendart',
            'metaOpengraphImage' => "https://www.robotinaponcho.net/assets/opengraph.{$releaseTimestamp}.png",
            'releaseTimestamp' => $releaseTimestamp,
            'urlBase' => 'https://www.robotinaponcho.net/',
        ],
    );
