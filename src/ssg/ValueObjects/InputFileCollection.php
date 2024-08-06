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
    private array $collections = [];
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

    public function getCollections(): array
    {
        static $collections;

        if (true === \is_array($collections)) {
            return $collections;
        }

        foreach ($this->inputFiles as $inputFile) {
            if (
                \array_key_exists(
                    'collections',
                    $inputFile->metadata,
                )
            ) {
                /** @var iterable<string>|string $keys */
                $keys = $inputFile->metadata['collections'];

                if (!is_iterable($keys)) {
                    $keys = [$keys];
                }

                foreach ($keys as $key) {
                    $collections[$key][] = $inputFile;
                }
            }
        }

        if (\count($collections) > 0) {
            ksort($collections);
        }

        return $collections;
    }
}
