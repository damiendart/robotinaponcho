<?php

// Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

use Robotinaponcho\Yassg\Plugins\GitMetadata\GitMetadataPlugin;
use Robotinaponcho\Yassg\Plugins\HtmlMinifier\HtmlMinifierPlugin;
use Robotinaponcho\Yassg\Plugins\SiteMapEntries\SiteMapEntriesPlugin;
use Robotinaponcho\Yassg\Plugins\TwigMarkdown\TwigMarkdownPlugin;
use Robotinaponcho\Yassg\Plugins\TwigSmartyPants\TwigSmartyPantsPlugin;
use Robotinaponcho\Yassg\Plugins\TwigWidont\TwigWidontPlugin;
use Yassg\Configuration\Configuration;
use Yassg\Plugins\Collections\CollectionsPlugin;
use Yassg\Plugins\Slug\SlugPlugin;
use Yassg\Services\Slug\BasicSlugStrategy;

return (new Configuration(
    __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'yassg',
    __DIR__ . DIRECTORY_SEPARATOR . 'public',
))
    ->addPlugin(new CollectionsPlugin())
    ->addPlugin(new HtmlMinifierPlugin())
    ->addPlugin(new GitMetadataPlugin())
    ->addPlugin(new SiteMapEntriesPlugin())
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
            'metaOpengraphImage' => 'https://www.robotinaponcho.net/assets/opengraph.png',
            'releaseTimestamp' => getenv('RELEASE_TIMESTAMP') ?? '00000000000000',
            'urlBase' => 'https://www.robotinaponcho.net/',
        ],
    );
