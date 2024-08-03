<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\ValueObjects;

use StaticSiteGenerator\InputFile;

/** @implements \IteratorAggregate<array-key, InputFile> */
final class InputFileCollection implements \IteratorAggregate
{
    private array $inputFiles;

    public function __construct(InputFile ...$inputFiles)
    {
        $this->inputFiles = $inputFiles;
    }

    /** @return \ArrayIterator<array-key, InputFile> */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->inputFiles);
    }

    /** @return SitemapEntry[] */
    public function getSitemapEntries(): array
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

        foreach ($this->inputFiles as $inputFile) {
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

        return $entries;
    }
}
