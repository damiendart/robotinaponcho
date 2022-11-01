<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
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
                'git' => [
                    'created' => $this->getCreatedMetadata(
                        $inputFile->getOriginalAbsolutePathname(),
                    ),
                    'updated' => $this->getLastUpdatedMetadata(
                        $inputFile->getOriginalAbsolutePathname(),
                    ),
                ],
            ],
        );
    }

    /**
     * @throws \Exception
     */
    private function getCreatedMetadata(string $pathname): array
    {
        $gitCommandOutput = explode(
            ' ',
            git(
                "log --diff-filter=A --follow --format='%H %ct' -1 -- {$pathname}",
            ),
        );

        if (empty($gitCommandOutput[0])) {
            return [
                'hash' => '0000000000000000000000000000000000000000',
                'timestamp' => new \DateTime(),
            ];
        }

        return [
            'hash' => $gitCommandOutput[0],
            'timestamp' => (new \DateTime())->setTimestamp((int) $gitCommandOutput[1]),
        ];
    }

    /**
     * @throws \Exception
     */
    private function getLastUpdatedMetadata(string $pathname): array
    {
        $gitCommandOutput = explode(
            ' ',
            git(
                "log -n 1 --pretty=format:'%H %ct' {$pathname}",
            ),
        );

        if (empty($gitCommandOutput[0])) {
            return [
                'hash' => '0000000000000000000000000000000000000000',
                'timestamp' => new \DateTime(),
            ];
        }

        return [
            'hash' => $gitCommandOutput[0],
            'timestamp' => (new \DateTime())->setTimestamp((int) $gitCommandOutput[1]),
        ];
    }
}
