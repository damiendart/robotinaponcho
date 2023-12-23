<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\GitMetadata;

use Yassg\Files\InputFile;
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

        $inputFile->mergeMetadata(
            [
                'git' => new GitMetadata(
                    ...$this->getCreatedMetadata(
                        $inputFile->getOriginalAbsolutePathname(),
                    ),
                    ...$this->getLastUpdatedMetadata(
                        $inputFile->getOriginalAbsolutePathname(),
                    ),
                ),
            ],
        );
    }

    /**
     * @throws \Exception
     */
    private function getCreatedMetadata(string $pathname): array
    {
        [$createdHash, $createdAt] = explode(
            ' ',
            git("log --diff-filter=A --follow --format='%H %ct' -1 -- {$pathname}"),
        );

        if (empty($createdHash)) {
            return [
                'createdAt' => new \DateTimeImmutable(),
                'createdHash' => null,
            ];
        }

        return [
            'createdAt' => \DateTimeImmutable::createFromFormat('U', $createdAt),
            'createdHash' => $createdHash,
        ];
    }

    /**
     * @throws \Exception
     */
    private function getLastUpdatedMetadata(string $pathname): array
    {
        [$updatedHash, $updatedAt] = explode(
            ' ',
            git("log -n 1 --pretty=format:'%H %ct' {$pathname}"),
        );

        if (empty($updatedHash)) {
            return [
                'updatedAt' => null,
                'updatedHash' => new \DateTimeImmutable(),
            ];
        }

        return [
            'updatedAt' => \DateTimeImmutable::createFromFormat('U', $updatedAt),
            'updatedHash' => $updatedHash,
        ];
    }
}
