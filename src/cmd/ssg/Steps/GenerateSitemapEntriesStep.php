<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\Inputfile;
use StaticSiteGenerator\ValueObjects\SitemapEntry;
use StaticSiteGenerator\ValueObjects\SiteMetadata;

final readonly class GenerateSitemapEntriesStep implements StepInterface
{
    public function __construct(
        private SiteMetadata $metadata,
    ) {}

    public function run(Inputfile ...$inputFiles): array
    {
        $entries = [
            new SitemapEntry(
                'crap/colouring-pages-a4.pdf',
                'crap/colouring-pages-a4.pdf',
            ),
            new SitemapEntry(
                'crap/colouring-pages-us.pdf',
                'crap/colouring-pages-us.pdf',
            ),
        ];

        foreach ($inputFiles as $inputFile) {
            $slug = $inputFile->metadata['slug'];

            if (
                'robots.txt' === $slug
                || 'sitemap.xml' === $slug
                || str_starts_with($slug, 'google')
                || str_ends_with($slug, '.atom')
            ) {
                continue;
            }

            $entries[] = new SitemapEntry(
                $inputFile->metadata['sitemapTitle']
                    ?? $inputFile->metadata['title']
                    ?? $slug,
                $slug,
            );
        }

        $this->metadata->metadata['sitemapEntries'] = $entries;

        return $inputFiles;
    }
}
