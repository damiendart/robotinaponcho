<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\ValueObjects;

final class SiteMetadata
{
    public array $metadata;

    public function __construct()
    {
        $releaseTimestamp = getenv('RELEASE_TIMESTAMP') ?: (new \DateTimeImmutable())->format('YmdHis');

        $this->metadata = [
            'author' => 'Damien Dart',
            'authorEmail' => 'damiendart@pobox.com',
            'metaTwitterAuthor' => '@damiendart',
            'metaTwitterSite' => '@damiendart',
            'metaOpengraphImage' => "https://www.robotinaponcho.net/assets/opengraph.{$releaseTimestamp}.png",
            'releaseTimestamp' => $releaseTimestamp,
            'urlBase' => 'https://www.robotinaponcho.net/',
        ];
    }
}
