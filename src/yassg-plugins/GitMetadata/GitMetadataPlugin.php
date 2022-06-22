<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\GitMetadata;

use function DI\decorate;
use Yassg\Files\Metadata\MetadataExtractorInterface;
use Yassg\Plugins\PluginInterface;

class GitMetadataPlugin implements PluginInterface
{
    public function getContainerDefinitions(): array
    {
        return [
            MetadataExtractorInterface::class => decorate(
                function (MetadataExtractorInterface $previous) {
                    return new GitMetadataExtractor($previous);
                },
            ),
        ];
    }
}
