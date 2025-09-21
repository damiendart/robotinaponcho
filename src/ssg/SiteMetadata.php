<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

final class SiteMetadata
{
    /** @var mixed[] */
    public array $metadata;

    public function __construct()
    {
        $releaseTimestamp = false === getenv('RELEASE_TIMESTAMP')
            ? (new \DateTimeImmutable())->format('YmdHis')
            : getenv('RELEASE_TIMESTAMP');

        $this->metadata = [
            'author' => 'Damien Dart',
            'authorEmail' => 'damiendart@pobox.com',
            'metaOpengraphImage' => "https://www.robotinaponcho.net/assets/opengraph.{$releaseTimestamp}.png",
            'releaseTimestamp' => $releaseTimestamp,
            'urlOrigin' => 'https://www.robotinaponcho.net',
        ];
    }
}
