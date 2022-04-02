<?php

// Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\GitMetadata;

use DateTime;
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

    public function addMetadata(InputFile $inputFile): void
    {
        $this->innerMetadataExtractor->addMetadata($inputFile);

        [$createdHash, $createdTimestamp] =
            explode(
                ' ',
                git("log --diff-filter=A --follow --format='%H %ct' -1 -- " . $inputFile->getOriginalAbsolutePathname()),
            );
        [$lastModifiedHash, $lastModifiedTimestamp] =
            explode(
                ' ',
                git("log -n 1 --pretty=format:'%H %ct' " . $inputFile->getOriginalAbsolutePathname()),
            );

        $inputFile->setMetadata(
            [
                'git' => [
                    'created' => [
                        'hash' => $createdHash,
                        'timestamp' => (new DateTime())->setTimestamp((int) $createdTimestamp),
                    ],
                    'updated' => [
                        'hash' => $lastModifiedHash,
                        'timestamp' => (new DateTime())->setTimestamp((int) $lastModifiedTimestamp),
                    ],
                ],
            ],
        );
    }
}
