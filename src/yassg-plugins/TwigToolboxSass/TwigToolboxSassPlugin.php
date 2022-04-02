<?php

// Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\TwigToolboxSass;

use function DI\decorate;
use Twig\Loader\FilesystemLoader;
use Yassg\Plugins\PluginInterface;

class TwigToolboxSassPlugin implements PluginInterface
{
    public function getContainerDefinitions(): array
    {
        return [
            FilesystemLoader::class => decorate(
                function (FilesystemLoader $previous): FilesystemLoader {
                    $previous->addPath(
                        dirname(__DIR__, 3) . '/node_modules/toolbox-sass/twig',
                        'toolbox-sass',
                    );

                    return $previous;
                },
            ),
        ];
    }
}
