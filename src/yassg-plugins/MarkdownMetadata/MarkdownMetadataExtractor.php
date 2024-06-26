<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Yassg\Plugins\MarkdownMetadata;

use Yassg\Files\InputFile;
use Yassg\Files\Metadata\MetadataExtractorInterface;

use function Yassg\preg_match_safe;

readonly class MarkdownMetadataExtractor implements MetadataExtractorInterface
{
    public function __construct(
        private MetadataExtractorInterface $innerMetadataExtractor,
    ) {}

    /**
     * @throws \Exception
     */
    public function addMetadata(InputFile $inputFile): void
    {
        $this->innerMetadataExtractor->addMetadata($inputFile);

        if (
            1 === preg_match_safe(
                "/(.*)\n=+/",
                $inputFile->getContent(),
                $titles,
            )
        ) {
            $inputFile->mergeMetadata(['title' => $titles[1]]);
            $inputFile->setContent(
                preg_replace(
                    "/{$titles[1]}\n=+\n/",
                    '',
                    $inputFile->getContent(),
                ),
            );
        }
    }
}
