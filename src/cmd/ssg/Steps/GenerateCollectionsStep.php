<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\Inputfile;
use StaticSiteGenerator\ValueObjects\SiteMetadata;

final readonly class GenerateCollectionsStep implements StepInterface
{
    public function __construct(
        private SiteMetadata $metadata,
    ) {}

    public function run(Inputfile ...$inputFiles): array
    {
        /** @var array<string, InputFile[]> $collections */
        $collections = [];

        foreach ($inputFiles as $inputFile) {
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

            $this->metadata->metadata['collections'] = $collections;
        }

        return $inputFiles;
    }
}
