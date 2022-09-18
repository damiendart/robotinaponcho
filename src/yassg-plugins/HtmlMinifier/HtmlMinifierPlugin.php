<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\HtmlMinifier;

use function DI\decorate;

use Psr\Container\ContainerInterface;
use voku\helper\HtmlMin;
use Yassg\Files\Processors\ProcessorResolver;
use Yassg\Plugins\PluginInterface;

class HtmlMinifierPlugin implements PluginInterface
{
    public function getContainerDefinitions(): array
    {
        return [
            HtmlMin::class => function (ContainerInterface $c): HtmlMin {
                return (new HtmlMin())
                    // HTMLMin adds superfluous whitespace when removing
                    // unnecessary closing tags. For more information,
                    // see <https://github.com/voku/HtmlMin/issues/59>.
                    ->doRemoveOmittedHtmlTags(false)
                    ->doMakeSameDomainsLinksRelative(['www.robotinaponcho.net']);
            },
            ProcessorResolver::class => decorate(
                function (ProcessorResolver $previous, ContainerInterface $c): ProcessorResolver {
                    /** @var HtmlProcessor $htmlProcessor */
                    $htmlProcessor = $c->get(HtmlProcessor::class);

                    return $previous->addProcessor($htmlProcessor);
                },
            ),
        ];
    }
}
