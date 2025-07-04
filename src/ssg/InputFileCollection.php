<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

/**
 * @psalm-api
 *
 * @implements \IteratorAggregate<array-key, InputFile>
 */
final class InputFileCollection implements \IteratorAggregate
{
    /** @var InputFile[] */
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

    /** @return InputFile[] */
    public function getSitemapEntries(): array
    {
        return array_filter(
            $this->inputFiles,
            static function (InputFile $inputFile): bool {
                $urlPath = $inputFile->metadata['urlPath'];

                \assert(\is_string($urlPath));

                if (
                    'speculation-rules.json' === $urlPath
                    || 'robots.txt' === $urlPath
                    || 'sitemap.xml' === $urlPath
                    || str_starts_with($urlPath, 'google')
                    || str_ends_with($urlPath, '.atom')
                ) {
                    return false;
                }

                return true;
            },
        );
    }

    /** @return array<string, InputFile[]> */
    public function getCollections(): array
    {
        /** @var array<string, InputFile[]> $collections */
        static $collections = [];

        if (\count($collections) > 0) {
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
