<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Yassg\Plugins\GitMetadata;

use Yassg\Files\InputFile;
use Yassg\Files\InputFileInterface;
use Yassg\Files\Metadata\MetadataExtractorInterface;

class GitMetadataExtractor implements MetadataExtractorInterface
{
    private MetadataExtractorInterface $innerMetadataExtractor;

    public function __construct(
        MetadataExtractorInterface $metadataExtractor,
    ) {
        $this->innerMetadataExtractor = $metadataExtractor;
    }

    /**
     * @throws \Exception
     */
    public function addMetadata(InputFile $inputFile): void
    {
        $this->innerMetadataExtractor->addMetadata($inputFile);

        if (false === \array_key_exists('git', $inputFile->getMetadata())) {
            $this->addDummyMetadata($inputFile);

            return;
        }

        $metadata = explode(' ', trim($inputFile->getMetadata()['git'], '$'));

        if (5 !== \count($metadata)) {
            $this->addDummyMetadata($inputFile);

            return;
        }

        $inputFile->mergeMetadata(
            [
                'git' => new GitMetadata(
                    \DateTimeImmutable::createFromFormat('U', $metadata[2]),
                    \DateTimeImmutable::createFromFormat('U', $metadata[4]),
                    $metadata[1],
                    $metadata[3],
                ),
            ],
        );
    }

    private function addDummyMetadata(InputFileInterface $inputFile): void
    {
        $inputFile->mergeMetadata(
            [
                'git' => new GitMetadata(
                    new \DateTimeImmutable(),
                    new \DateTimeImmutable(),
                    '0000000000000000000000000000000000000000',
                    '0000000000000000000000000000000000000000',
                ),
            ],
        );
    }
}
